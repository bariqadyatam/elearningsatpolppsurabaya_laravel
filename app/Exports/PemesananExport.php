<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemesananExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Pemesanan::with(['penyewa', 'kamar', 'konfirmasiPembayaran']);

        if ($this->bulan) {
            $query->whereMonth('tanggal_masuk', $this->bulan);
        }

        if ($this->tahun) {
            $query->whereYear('tanggal_masuk', $this->tahun);
        }

        return $query->get()->map(function ($item) {
            return [
                'Pemesan' => $item->penyewa->nama ?? '-',
                'Kamar' => $item->kamar->nama_kamar ?? '-',
                'Tanggal Masuk' => $item->tanggal_masuk,
                'Tanggal Keluar' => $item->tanggal_keluar,
                'Status Pembayaran' => $item->status_pembayaran,
                'Tanggal Konfirmasi' => $item->konfirmasiPembayaran->tanggal_konfirmasi ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Pemesan',
            'Kamar',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Status Pembayaran',
            'Tanggal Konfirmasi',
        ];
    }
}
