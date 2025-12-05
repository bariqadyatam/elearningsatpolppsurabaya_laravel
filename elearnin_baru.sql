-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Waktu pembuatan: 27 Nov 2025 pada 02.07
-- Versi server: 8.0.44
-- Versi PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `elearnin_baru`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('123123|127.0.0.1', 'i:1;', 1757672484),
('123123|127.0.0.1:timer', 'i:1757672484;', 1757672484),
('satpol|127.0.0.1', 'i:1;', 1757563045),
('satpol|127.0.0.1:timer', 'i:1757563045;', 1757563045);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_kelas`
--

CREATE TABLE `kategori_kelas` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_kelas`
--

INSERT INTO `kategori_kelas` (`id`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Kelas 1', 'Kelas 1', '2025-11-12 03:59:08', '2025-11-27 01:46:05'),
(4, 'Kelas 2', 'Kelas 2', '2025-11-27 01:45:56', '2025-11-27 01:45:56'),
(5, 'Kelas 3', 'Kelas 3', '2025-11-27 01:46:16', '2025-11-27 01:46:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_materis`
--

CREATE TABLE `kategori_materis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_materis`
--

INSERT INTO `kategori_materis` (`id`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
(5, 'SOP', 'Standar Operasional Prosedur', '2025-07-27 04:23:04', '2025-11-27 01:46:49'),
(7, 'Perda', 'Peraturan Daerah', '2025-11-27 01:47:15', '2025-11-27 01:47:15'),
(8, 'Penindakan Umum', 'Penindakan Umum', '2025-11-27 01:47:33', '2025-11-27 01:47:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_regus`
--

CREATE TABLE `kategori_regus` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_kelas_id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_regus`
--

INSERT INTO `kategori_regus` (`id`, `kategori_kelas_id`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
(10, 1, 'Bangsumda', 'Bidang Sumber Daya', '2025-11-11 01:58:04', '2025-11-11 21:16:35'),
(11, 1, 'Gakda', 'Penegakan Peraturan Daerah', '2025-11-11 01:58:59', '2025-11-11 21:16:39'),
(12, 1, 'Tibum', 'Tindak Pidana Umum', '2025-11-11 01:59:14', '2025-11-11 21:16:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `links`
--

CREATE TABLE `links` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `materi_id` int NOT NULL,
  `deskripsi_link` text COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `links`
--

INSERT INTO `links` (`id`, `nama_link`, `materi_id`, `deskripsi_link`, `link`, `created_at`, `updated_at`) VALUES
(1, 'Modul 1', 1, 'Lorem Ipsum', 'uploads/link_materi/1752228506_sample2.pdf', '2025-07-11 03:08:26', '2025-07-11 03:08:26'),
(2, 'Modul 2', 1, 'Test test', 'uploads/link_materi/1752228964_sample3.pdf', '2025-07-11 03:16:04', '2025-07-11 03:16:04'),
(3, 'xcZ', 1, 'czx', 'uploads/link_materi/1752228991_forcast.zip', '2025-07-11 03:16:31', '2025-07-11 03:16:31'),
(4, 'test', 5, 'Test', 'uploads/link_materi/1752237115_sample2.pdf', '2025-07-11 05:31:55', '2025-07-11 05:31:55'),
(5, 'test 2', 5, 'fads', 'uploads/link_materi/1752237135_sample3.pdf', '2025-07-11 05:32:15', '2025-07-11 05:32:15'),
(6, 'fsda', 6, 'fasd', 'uploads/link_materi/1752543821_forcast.zip', '2025-07-14 18:43:41', '2025-07-14 18:43:41'),
(7, 'File SOP', 8, 'ini adalah file sop', 'uploads/link_materi/1753615643_1683353154_54566d3bdfe7e5074cab.pdf', '2025-07-27 04:27:23', '2025-07-27 04:27:23'),
(9, 'SOP', 12, 'test', 'uploads/link_materi/1755217679_1683353154_54566d3bdfe7e5074cab.pdf', '2025-08-15 00:27:59', '2025-08-15 00:27:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materis`
--

CREATE TABLE `materis` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori_materi_id` bigint UNSIGNED NOT NULL,
  `kategori_kelas_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sertif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pernyataan_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_sertifikat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_tanda_tangan` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `materis`
--

INSERT INTO `materis` (`id`, `judul`, `isi`, `video`, `kategori_materi_id`, `kategori_kelas_id`, `created_at`, `updated_at`, `thumbnail`, `images`, `no_sertif`, `pernyataan_sertifikat`, `keterangan_sertifikat`, `foto_tanda_tangan`, `start_date`, `end_date`) VALUES
(16, 'tester123', '<h3>1. Pengantar Kewaspadaan Dini</h3><p><strong>Apa itu Kewaspadaan Dini?</strong>&nbsp;Kewaspadaan dini adalah serangkaian upaya dan tindakan yang dilakukan untuk mendeteksi potensi ancaman, tantangan, hambatan, dan gangguan secara awal. Tujuannya adalah agar tindakan pencegahan dapat dilakukan sebelum permasalahan menjadi lebih besar dan mengganggu stabilitas keamanan dan ketertiban di masyarakat.</p><p><strong>Mengapa Kewaspadaan Dini Penting?</strong></p><ul><li>Meningkatkan ketangguhan wilayah terhadap ancaman dan konflik</li><li>Memperkuat peran serta masyarakat dan pemerintah daerah</li><li>Mengurangi dampak negatif dari berbagai potensi gangguan keamanan</li><li>Membantu dalam pengambilan keputusan yang cepat dan tepat</li></ul><h3>2. Fungsi dan Tujuan Kewaspadaan Dini</h3><p><strong>Fungsi:</strong></p><ul><li>Pendeteksian dan identifikasi awal potensi ancaman</li><li>Menilai dan menganalisis situasi yang berkembang</li><li>Memberikan peringatan dini kepada pihak terkait</li><li>Melakukan langkah-langkah pencegahan dan mitigasi</li></ul><p><strong>Tujuan:</strong>&nbsp;Memastikan situasi stabil dan aman di wilayah kelurahan serta memperkuat sinergi antara pemerintah dan masyarakat dalam menjaga kestabilan sosial.</p><h3>3. Peran ASN dan Masyarakat dalam Kewaspadaan Dini</h3><ul><li><strong>ASN Pemkot Surabaya:</strong>&nbsp;Membangun koordinasi, mengumpulkan dan menganalisis informasi, serta melakukan tindakan pencegahan.</li><li><strong>Tokoh Masyarakat:</strong>&nbsp;Memberikan informasi yang akurat dan membantu deteksi awal masalah.</li><li><strong>Ketua RT/RW, Tokoh Agama, Pemuda:</strong>&nbsp;Menjadi penghubung informasi dan menjadi perpanjangan tangan dalam penerapan kewaspadaan.</li></ul><h3>4. Langkah-Langkah Kewaspadaan Dini</h3><h4>A. Pengumpulan Informasi (Baket/Informasi)</h4><ul><li>Melakukan wawancara, surveilans, pengamatan langsung</li><li>Mengidentifikasi tanda, gejala, dan fakta yang muncul di masyarakat</li><li>Memilah informasi berdasarkan fakta dan opini</li></ul><h4>B. Pemetaan Wilayah dan Potensi Konflik</h4><ul><li>Mengidentifikasi batas wilayah, objek vital, tempat hiburan, dan lokasi rawan kriminal serta bencana</li><li>Mengetahui jumlah warga, mayoritas pekerjaan, agama, dan konflik yang sedang berlangsung</li></ul><h4>C. Analisis dan Penilaian</h4><ul><li>Melakukan analisis relevansi dan validitas informasi</li><li>Menilai tingkat kerawanan dan potensi konflik dalam wilayah</li></ul><h4>D. Upaya Pencegahan</h4><ul><li>Menyusun langkah-langkah pencegahan berdasarkan hasil analisis</li><li>Melibatkan masyarakat dan tokoh masyarakat dalam pencegahan konflik</li></ul><h3>5. Pemetaan dan Data Informasi</h3><p>Berikut adalah data yang perlu dikumpulkan untuk mendukung kewaspadaan dini:</p><ul><li>Informasi tentang tokoh masyarakat dan kontaknya</li><li>Jumlah kepala keluarga, penduduk, dan karakteristiknya</li><li>Batas wilayah dan objek penting di sekitar</li><li>Informasi tentang konflik yang pernah terjadi dan potensi konflik yang sedang ada</li><li>Kondisi wilayah dan faktor penyebabnya</li></ul><h3>6. Upaya Pencegahan dan Mitigasi Konflik</h3><p>Langkah-langkah yang dapat diambil meliputi:</p><ul><li>Sosialisasi dan komunikasi yang efektif kepada masyarakat</li><li>Meningkatkan pengawasan dan patroli wilayah</li><li>Melibatkan tokoh masyarakat dalam menjaga kondusivitas</li><li>Melakukan kegiatan preventif dan resolusi konflik secara dini</li></ul>', 'https://www.youtube.com/watch?v=PHluwqTGCBY', 5, 1, '2025-08-21 15:30:19', '2025-11-11 22:50:02', 'thumbnails/VrL1oky5QuFPwmAhp7SBlt1jb9eNCPcFBtt5dRk5.png', '[\"materi_images\\/sF0gFAIOfMPY0oGCNgGorgKBDJih6DHln2djJ6vh.png\",\"materi_images\\/OBwXrhgJc6ZGsB6TjcUVq23DybF0LvrYjoxYs421.png\"]', 'halo/adfaf.a123', 'haha', 'haha', 'foto_tanda_tangan/p356fpu9UtbJQfupRcmB79ohs0Pgxw5hujAqAFeX.png', '2025-09-11', '2025-12-31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_22_112215_create_kategori_regus_table', 1),
(5, '2025_06_22_112215_create_personels_table', 1),
(6, '2025_06_22_112216_create_kategori_materis_table', 1),
(7, '2025_06_22_112216_create_materis_table', 1),
(8, '2025_06_22_112217_create_personel_materi_table', 1),
(9, '2025_06_22_112217_create_quizzes_table', 1),
(10, '2025_08_21_153154_add_unique_id_to_sertifikats_table', 2),
(11, '2025_08_21_153556_change_number_length_in_sertifikats_table', 3),
(12, '2025_09_11_031320_add_keterangan_to_kategori_regus_table', 4),
(13, '2025_09_11_032639_add_keterangan_to_kategori_materis_table', 5),
(14, '2025_09_12_005741_add_tanggal_to_materis_table', 6),
(15, '2025_09_12_012250_add_date_range_to_materis_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelajarans`
--

CREATE TABLE `pembelajarans` (
  `id` int NOT NULL,
  `personel_id` int NOT NULL,
  `mingguke` int NOT NULL,
  `catatan` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelajarans`
--

INSERT INTO `pembelajarans` (`id`, `personel_id`, `mingguke`, `catatan`, `created_at`, `updated_at`) VALUES
(2, 25, 1, 'asdasd', '2025-11-13 02:36:34', '2025-11-13 10:08:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personels`
--

CREATE TABLE `personels` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori_regu` bigint DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personels`
--

INSERT INTO `personels` (`id`, `user_id`, `nama`, `id_kategori_regu`, `tanggal_lahir`, `foto`, `created_at`, `updated_at`) VALUES
(26, 44, 'Bariq Adyatma', 10, '2003-06-08', 'personel/foto/default.jpg', '2025-11-26 06:37:19', '2025-11-26 06:37:19'),
(27, 45, 'Jariyah', 10, '1986-05-28', 'personel/foto/default.jpg', '2025-11-27 01:45:04', '2025-11-27 01:45:04'),
(28, 46, 'EMAS DESCY RAHMAWATI, S.Sos', 10, '1993-12-16', 'personel/foto/default.jpg', '2025-11-27 01:57:10', '2025-11-27 01:57:10'),
(29, 47, 'LUTFIA MAWARDANI S.I.Kom', 10, '1993-12-18', 'personel/foto/default.jpg', '2025-11-27 01:58:07', '2025-11-27 01:58:07'),
(30, 48, 'SEPTY NUR DAYANA', 10, '1989-09-22', 'personel/foto/default.jpg', '2025-11-27 01:58:59', '2025-11-27 01:58:59'),
(31, 49, 'LAILIA ROCHMA', 10, '1994-04-13', 'personel/foto/default.jpg', '2025-11-27 01:59:29', '2025-11-27 01:59:29'),
(32, 50, 'MAHELLA TIARA', 10, '1996-05-18', 'personel/foto/default.jpg', '2025-11-27 02:00:01', '2025-11-27 02:00:01'),
(33, 51, 'MELYANA SEVEN JUNI CHRISTINA MANURUNG', 10, '1989-06-07', 'personel/foto/default.jpg', '2025-11-27 02:00:38', '2025-11-27 02:00:38'),
(34, 52, 'PUTRI AYU NINGRUM', 10, '1995-06-28', 'personel/foto/default.jpg', '2025-11-27 02:01:33', '2025-11-27 02:01:33'),
(35, 53, 'PRAMITA DWI SAGITA', 10, '1995-06-28', 'personel/foto/default.jpg', '2025-11-27 02:02:08', '2025-11-27 02:02:08'),
(36, 55, 'MOHAMAD RIKI EFENDI, S.I.K.', 10, '1995-02-23', 'personel/foto/default.jpg', '2025-11-27 02:03:34', '2025-11-27 02:03:34'),
(37, 56, 'NOVI ARIAYADI, S.I.Kom', 10, '1994-03-28', 'personel/foto/default.jpg', '2025-11-27 02:04:10', '2025-11-27 02:04:10'),
(38, 57, 'FERI PRAMUDI', 10, '1991-03-25', 'personel/foto/default.jpg', '2025-11-27 02:04:41', '2025-11-27 02:04:41'),
(39, 58, 'MOH. HISYAM YAHYA', 10, '1995-04-21', 'personel/foto/default.jpg', '2025-11-27 02:05:10', '2025-11-27 02:05:10'),
(40, 59, 'CHAIRUL BIMA AFRIZAL, S.I.Kom.', 10, '1992-08-24', 'personel/foto/default.jpg', '2025-11-27 02:06:09', '2025-11-27 02:06:09'),
(41, 60, 'HARI NOFIANTO', 10, '1984-11-28', 'personel/foto/default.jpg', '2025-11-27 02:06:43', '2025-11-27 02:06:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personel_materi`
--

CREATE TABLE `personel_materi` (
  `id` bigint UNSIGNED NOT NULL,
  `personel_id` bigint UNSIGNED NOT NULL,
  `test_id` bigint UNSIGNED NOT NULL,
  `sudah_mengerjakan` tinyint(1) NOT NULL DEFAULT '0',
  `skor` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint UNSIGNED NOT NULL,
  `test_id` bigint UNSIGNED NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jawaban` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi` int NOT NULL DEFAULT '60',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `quizzes`
--

INSERT INTO `quizzes` (`id`, `test_id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `bobot`, `jawaban`, `durasi`, `created_at`, `updated_at`) VALUES
(31, 16, 'testtt', 'haha', '7', '6', '2', '', 'A', 25, '2025-09-18 00:54:51', '2025-11-26 06:30:40'),
(32, 16, 'huhu', 'a', 'huhu', 'a', 'a', '', 'B', 20, '2025-09-18 00:55:03', '2025-09-18 00:55:03'),
(33, 16, 'hehe', 'a', 'a', 'hehe', 'a', '', 'C', 20, '2025-09-18 00:55:21', '2025-09-18 00:55:21'),
(41, 16, 'test', '1', '3', '4', '2', NULL, 'A', 25, '2025-11-26 06:30:14', '2025-11-26 06:30:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sertifikats`
--

CREATE TABLE `sertifikats` (
  `id` bigint UNSIGNED NOT NULL,
  `personel_id` bigint UNSIGNED NOT NULL,
  `materi_id` bigint UNSIGNED NOT NULL,
  `number` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `durasi` int DEFAULT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sertifikats`
--

INSERT INTO `sertifikats` (`id`, `personel_id`, `materi_id`, `number`, `durasi`, `unique_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '33', 4, NULL, '2025-07-14 03:22:16', '2025-07-14 03:22:24'),
(2, 5, 16, 'halo/adfaf.a123', NULL, '6016', '2025-08-21 15:36:27', '2025-08-21 15:36:27'),
(3, 10, 16, 'halo/adfaf.a123', NULL, '6740', '2025-08-23 01:30:40', '2025-08-23 01:30:40'),
(4, 14, 16, 'halo/adfaf.a123', NULL, '6461', '2025-08-24 11:30:47', '2025-08-24 11:30:47'),
(5, 15, 16, 'halo/adfaf.a123', NULL, '3662', '2025-08-24 17:02:12', '2025-08-24 17:02:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3QPIaxjBmBJ3lLEw78jIF9vKfVU5TtuL64oL86it', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRGVZSEN3aUtwVkRFTEV2R0tpOHIwYzdHaUVGczVNc2ZYaHhVZVh5NCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764207257),
('6xyHvm7wCRLD0YFIUaKayKncDYZhEbIunDEKBqJA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWhaQ2Z6Z25kUU5rUE94UHJBaHdkdnFZMnZuWHFGTkhyNGRySW02ZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wZXJzb25lbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764208631),
('Drxg6peBQBUiHgbna5mTU8qm8uScX5aKyb7FjJLg', 1, '182.8.98.12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieWtwOXkwdnVLSldjR1dWbE5QakZHSHdiYXNzYXpveXExMllZSUlpUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vZWxlYXJuaW5nc2F0cG9sLnNpdGUvcGVyc29uZWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL2VsZWFybmluZ3NhdHBvbC5zaXRlL2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764209203),
('M6IBSv0TFhGUA06UZvM7utR61sdS2XP36m3ls70z', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMlRiUVRnVEhLT3lKMksyTjY4VFlobUczWGJXaXZ5YmRpc0RScXJNdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXJzb25lbCI7fX0=', 1764145185),
('RWlny7wyYOVV04Bz2y1SjOwZsr4y8SgkVfTlTcDo', NULL, '103.189.123.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOENDSVFnOVNKTE5pa0V3RnY3eGo4amZRMnZhUXJyZnhBU0NpSHJ2MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vZWxlYXJuaW5nc2F0cG9sLnNpdGUvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1764203567);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tests`
--

CREATE TABLE `tests` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_test` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `materi_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tests`
--

INSERT INTO `tests` (`id`, `nama_test`, `materi_id`, `created_at`, `updated_at`) VALUES
(16, 'Test Pertama', 16, '2025-09-18 00:54:29', '2025-11-26 06:29:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pesonel',
  `otp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expired_at` datetime DEFAULT NULL,
  `reset_password_token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `nip`, `img`, `email_verified_at`, `password`, `remember_token`, `role`, `otp_code`, `otp_expired_at`, `reset_password_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'admin', '143234234', '-', NULL, '$2y$12$Ihzw4goCQtLtq/C5SEQCG.Q.tk1iRMtrcx2a.VLsIxkmqMHylxHf.', NULL, 'Admin', NULL, NULL, NULL, '2025-05-23 15:39:49', '2025-11-11 22:15:09'),
(44, 'bariqadyatma@gmail.com', 'bariq', '-', '-', NULL, '$2y$12$NH0kXnCWhUEzlDzQdnWYi.MlrMzCHJBGikU/0g61qP9yyvPnUCYOy', NULL, 'Personel', NULL, NULL, '97MJjOPBUXWb3ZbQ77cvdUqp7hZkILbzEFay20vKquV8ENoVCHxYD2XyswUJiN1s', '2025-11-26 06:37:19', '2025-11-27 00:57:25'),
(45, 'jariyah@gmail.com', 'jariyah', '-', '-', NULL, '$2y$12$aEy8UHABh0JwWvNYsT1m3uXM5668QQXjYllfoW0u7qSd2QOnw4IuG', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 01:45:04', '2025-11-27 01:45:04'),
(46, 'emasdescy@gmail.com', 'emasdescy', '-', '-', NULL, '$2y$12$mf0Ey6FA957Q4ihZtDKtiuGx8EM3ctmLNKGO15BvQI7M7cprLwkRq', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 01:57:10', '2025-11-27 01:57:10'),
(47, 'lutfiamawardani@gmail.com', 'lutfiamawardani', '-', '-', NULL, '$2y$12$ntE/MHbDpvPLG3msDB5jA.c.loTk.QKXiGDDW6YvINMvNwzFVlfFW', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 01:58:07', '2025-11-27 01:58:07'),
(48, 'septynur@gmail.com', 'septynur', '-', '-', NULL, '$2y$12$S0BaPN3Wi9WOEDYd8WT6Q.RsOs3ESSP5YchGFSIPrAFuDwA4sCXmO', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 01:58:59', '2025-11-27 01:58:59'),
(49, 'lailia@gmail.com', 'lailia', '-', '-', NULL, '$2y$12$SOlSQWFmcdvBLGaUHsgARO2EfH2lBhJHlS2paAued.lR9THxRVL.y', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 01:59:29', '2025-11-27 01:59:29'),
(50, 'tiara@gmail.com', 'tiara', '-', '-', NULL, '$2y$12$s8/SWMx/Qk7VPnbc94nSiulS7OcSKgj0AQUf5E2sOIIQJzJyqQZQK', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:00:01', '2025-11-27 02:00:01'),
(51, 'sevenjuni@gmail.com', 'sevenjuni', '-', '-', NULL, '$2y$12$yx/fQsqE3iSEbeJ0C2f0OOwofqRVSfqR7dBDcU56kEwTAsrPP5saC', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:00:38', '2025-11-27 02:00:38'),
(52, 'putriayu@gmail.com', 'putriayu', '-', '-', NULL, '$2y$12$RiT5LiZKBae2blF6St0KvuHE7kOTWDqA2Zro9tKBL2peUzhQXi.UG', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:01:33', '2025-11-27 02:01:33'),
(53, 'pramita@gmail.com', 'pramita', '-', '-', NULL, '$2y$12$ZNx4EVp.KfoKvFEFxDD8zOSbSjeSQ1pljnHx/QUl3cn6/dB1xL2Gi', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:02:08', '2025-11-27 02:02:08'),
(54, 'husnulfuad@gmail.com', 'HUSNUL FUAD DWI ANTARIKSA, S.Kom', '1', '-', NULL, '$2y$12$0SN8GEP0oTaXbIJjXU.zNOCFQx6ryXHVrqv0SRF3yTqoJ98bz/z4q', NULL, 'Admin', NULL, NULL, NULL, '2025-11-27 02:02:37', '2025-11-27 02:02:37'),
(55, 'rikiefendi@gmail.com', 'rikiefendi', '-', '-', NULL, '$2y$12$/pVjQa3pQA83F6iCjC4pN.ogbgYHwj4KuNRYo0n9MkcXk4psKNYHW', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:03:34', '2025-11-27 02:03:34'),
(56, 'noviariayadi@gmail.com', 'noviariayadi', '-', '-', NULL, '$2y$12$9IYWTxIZUlGNqx.RPkc1L.Y7X8Q3sGfTdA5pH4jCcP/oNSoUhX6QO', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:04:10', '2025-11-27 02:04:10'),
(57, 'feripramudi@gmail.com', 'feripramudi', '-', '-', NULL, '$2y$12$/QG91q5sI0Dbxpg.bQPTweq4iLGw.F0TJV.rslI1FFg5cYfvv0YW6', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:04:41', '2025-11-27 02:04:41'),
(58, 'hisyamyahya@gmail.com', 'hisyamyahya', '-', '-', NULL, '$2y$12$E2PsSGMbZQ9t9qD9a/k0.umMSzUd.nT8bTIj3BDEYArJrwv952E5e', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:05:10', '2025-11-27 02:05:10'),
(59, 'chairulbima@gmail.com', 'chairulbima', '-', '-', NULL, '$2y$12$17n0eh6dArEOI1OGJX01Tub4oDy8ouuOHm64ulxrlrGT92TtG6P8e', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:06:09', '2025-11-27 02:06:09'),
(60, 'harinofianto@gmail.com', 'harinofianto', '-', '-', NULL, '$2y$12$VT8ERiHNbYlVLveKJ3BpiuyR.y0JTSJH/3MZXmQPhRhXb2K59A4a2', NULL, 'Personel', NULL, NULL, NULL, '2025-11-27 02:06:43', '2025-11-27 02:06:43');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_kelas`
--
ALTER TABLE `kategori_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_materis`
--
ALTER TABLE `kategori_materis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_regus`
--
ALTER TABLE `kategori_regus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `materis`
--
ALTER TABLE `materis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materis_kategori_materi_id_foreign` (`kategori_materi_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembelajarans`
--
ALTER TABLE `pembelajarans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personels`
--
ALTER TABLE `personels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personels_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `personel_materi`
--
ALTER TABLE `personel_materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personel_materi_personel_id_foreign` (`personel_id`),
  ADD KEY `personel_materi_materi_id_foreign` (`test_id`);

--
-- Indeks untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_materi_id_foreign` (`test_id`);

--
-- Indeks untuk tabel `sertifikats`
--
ALTER TABLE `sertifikats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori_kelas`
--
ALTER TABLE `kategori_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori_materis`
--
ALTER TABLE `kategori_materis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kategori_regus`
--
ALTER TABLE `kategori_regus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `links`
--
ALTER TABLE `links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `materis`
--
ALTER TABLE `materis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pembelajarans`
--
ALTER TABLE `pembelajarans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `personels`
--
ALTER TABLE `personels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `personel_materi`
--
ALTER TABLE `personel_materi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `sertifikats`
--
ALTER TABLE `sertifikats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `materis`
--
ALTER TABLE `materis`
  ADD CONSTRAINT `materis_kategori_materi_id_foreign` FOREIGN KEY (`kategori_materi_id`) REFERENCES `kategori_materis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `personels`
--
ALTER TABLE `personels`
  ADD CONSTRAINT `personels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `personel_materi`
--
ALTER TABLE `personel_materi`
  ADD CONSTRAINT `personel_materi_materi_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `personel_materi_personel_id_foreign` FOREIGN KEY (`personel_id`) REFERENCES `personels` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_materi_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
