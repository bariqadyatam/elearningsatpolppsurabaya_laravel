<?php

namespace App\Services;

use App\Models\Enkripsi;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\Twofish;

class MultiLayerEncryptionService
{
    public function encrypt(string $text, string $key1, string $key2, int $key3, string $key4): string
    {
        $aes = new AES('cbc');
        $aes->setKey($key1);
        $aes->setIV(str_repeat("\0", 16));
        $cipher1 = $aes->encrypt($text);

        $twofish = new Twofish('cbc');
        $twofish->setKey($key2);
        $twofish->setIV(str_repeat("\0", 16));
        $cipher2 = $twofish->encrypt($cipher1);

        $cipher3 = '';
        foreach (str_split(base64_encode($cipher2)) as $char) {
            $cipher3 .= chr((ord($char) + $key3) % 256);
        }

        $cipher4 = '';
        $keyLen = strlen($key4);
        for ($i = 0; $i < strlen($cipher3); $i++) {
            $cipher4 .= chr((ord($cipher3[$i]) + ord($key4[$i % $keyLen])) % 256);
        }

        return base64_encode($cipher4);
    }

    public function decrypt(string $encodedText, int $penyewaId): string
    {
        $enkripsi = Enkripsi::where('id_penyewa', $penyewaId)->firstOrFail();
        $key1 = base64_decode($enkripsi->kunci_enkripsi1);
        $key2 = base64_decode($enkripsi->kunci_enkripsi2);
        $key3 = (int) base64_decode($enkripsi->kunci_enkripsi3);
        $key4 = base64_decode($enkripsi->kunci_enkripsi4);

        $cipher = base64_decode($encodedText);

        // Vigenère Reverse
        $vigenere = '';
        $keyLen = strlen($key4);
        for ($i = 0; $i < strlen($cipher); $i++) {
            $vigenere .= chr((ord($cipher[$i]) - ord($key4[$i % $keyLen]) + 256) % 256);
        }

        // Caesar Reverse
        $caesar = '';
        foreach (str_split($vigenere) as $char) {
            $caesar .= chr((ord($char) - $key3 + 256) % 256);
        }

        $caesarDecoded = base64_decode($caesar);

        // Twofish Decrypt
        $twofish = new \phpseclib3\Crypt\Twofish('cbc');
        $twofish->setKey($key2);
        $twofish->setIV(str_repeat("\0", 16));
        $aesEncrypted = $twofish->decrypt($caesarDecoded);

        // AES Decrypt
        $aes = new \phpseclib3\Crypt\AES('cbc');
        $aes->setKey($key1);
        $aes->setIV(str_repeat("\0", 16));
        return $aes->decrypt($aesEncrypted);
    }
}
