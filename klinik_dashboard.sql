-- Database: klinik_dashboard
-- File SQL untuk dashboard klinik lengkap
-- Urutan: Tabel dulu, kemudian Views di akhir

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ========================================
-- STRUKTUR TABEL UTAMA
-- ========================================

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `metode_pembayaran` enum('cash','transfer','debit','credit') DEFAULT 'cash',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `vendor_supplier` varchar(100) DEFAULT NULL,
  `departemen` varchar(50) DEFAULT 'umum',
  `status` enum('pending','approved','paid','rejected') DEFAULT 'pending',
  `approved_by` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `tanggal`, `kategori`, `keterangan`, `jumlah`, `metode_pembayaran`, `bukti_pembayaran`, `vendor_supplier`, `departemen`, `status`, `approved_by`, `created_by`) VALUES
(1, '2024-01-01', 'Obat-obatan', 'Pembelian obat generik bulan Januari', 15000000.00, 'transfer', NULL, 'PT. Kimia Farma', 'farmasi', 'paid', 'manager', 'admin'),
(2, '2024-01-01', 'Alat Medis', 'Pembelian alat medis habis pakai', 8500000.00, 'transfer', NULL, 'PT. Medical Equipment', 'medis', 'paid', 'manager', 'admin'),
(3, '2024-01-01', 'Gaji Staff', 'Gaji karyawan bulan Januari', 45000000.00, 'transfer', NULL, 'Internal', 'hrd', 'paid', 'manager', 'admin'),
(4, '2024-01-15', 'Listrik & Air', 'Tagihan listrik dan air bulan Januari', 2500000.00, 'transfer', NULL, 'PLN & PDAM', 'umum', 'paid', 'supervisor', 'admin'),
(5, '2024-01-20', 'Maintenance', 'Perawatan alat-alat medis', 3200000.00, 'cash', NULL, 'CV. Teknik Medis', 'teknik', 'paid', 'supervisor', 'admin'),
(6, '2024-02-01', 'Obat-obatan', 'Restok obat-obatan bulan Februari', 18000000.00, 'transfer', NULL, 'PT. Sanbe Farma', 'farmasi', 'paid', 'manager', 'admin'),
(7, '2024-02-01', 'Gaji Staff', 'Gaji karyawan bulan Februari', 45000000.00, 'transfer', NULL, 'Internal', 'hrd', 'paid', 'manager', 'admin'),
(8, '2024-02-10', 'Marketing', 'Promosi dan iklan klinik', 5000000.00, 'debit', NULL, 'PT. Digital Marketing', 'marketing', 'paid', 'manager', 'admin'),
(9, '2024-02-15', 'Training', 'Pelatihan staff medis', 7500000.00, 'transfer', NULL, 'Lembaga Pelatihan Medis', 'hrd', 'paid', 'manager', 'admin'),
(10, '2024-03-01', 'Gaji Staff', 'Gaji karyawan bulan Maret', 47000000.00, 'transfer', NULL, 'Internal', 'hrd', 'paid', 'manager', 'admin'),
(11, '2024-03-05', 'Renovasi', 'Renovasi ruang tunggu', 12000000.00, 'transfer', NULL, 'CV. Kontraktor Bangunan', 'umum', 'paid', 'manager', 'admin'),
(12, '2024-03-15', 'Obat-obatan', 'Pembelian obat khusus', 22000000.00, 'transfer', NULL, 'PT. Dexa Medica', 'farmasi', 'paid', 'manager', 'admin'),
(13, '2024-04-01', 'Gaji Staff', 'Gaji karyawan bulan April', 47000000.00, 'transfer', NULL, 'Internal', 'hrd', 'paid', 'manager', 'admin'),
(14, '2024-04-10', 'Asuransi', 'Premi asuransi klinik', 8000000.00, 'transfer', NULL, 'PT. Asuransi Kesehatan', 'umum', 'paid', 'manager', 'admin'),
(15, '2024-04-20', 'IT Support', 'Upgrade sistem informasi', 15000000.00, 'transfer', NULL, 'PT. IT Solutions', 'it', 'paid', 'manager', 'admin'),
(16, '2024-05-01', 'Gaji Staff', 'Gaji karyawan bulan Mei', 48000000.00, 'transfer', NULL, 'Internal', 'hrd', 'paid', 'manager', 'admin'),
(17, '2024-05-15', 'Cleaning Service', 'Jasa kebersihan bulan Mei', 3500000.00, 'cash', NULL, 'CV. Cleaning Pro', 'umum', 'paid', 'supervisor', 'admin'),
(18, '2024-06-01', 'Gaji Staff', 'Gaji karyawan bulan Juni', 48000000.00, 'transfer', NULL, 'Internal', 'hrd', 'paid', 'manager', 'admin'),
(19, '2024-06-10', 'Obat-obatan', 'Restok obat emergency', 25000000.00, 'transfer', NULL, 'PT. Novell Pharmaceutical', 'farmasi', 'paid', 'manager', 'admin'),
(20, '2024-07-01', 'Gaji Staff', 'Gaji karyawan bulan Juli', 50000000.00, 'transfer', NULL, 'Internal', 'hrd', 'approved', 'manager', 'admin'),
(21, '2024-07-05', 'Listrik & Air', 'Tagihan utilitas bulan Juli', 2800000.00, 'transfer', NULL, 'PLN & PDAM', 'umum', 'pending', NULL, 'admin'),
(22, '2024-07-08', 'Obat-obatan', 'Order obat untuk stok', 20000000.00, 'transfer', NULL, 'PT. Kimia Farma', 'farmasi', 'pending', NULL, 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pasien`
--

CREATE TABLE `tb_pasien` (
  `id_pasien` int(11) NOT NULL,
  `no_rm` varchar(20) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `status_pernikahan` enum('Belum Menikah','Menikah','Cerai','Janda/Duda') DEFAULT 'Belum Menikah',
  `golongan_darah` enum('A','B','AB','O','A+','B+','AB+','O+','A-','B-','AB-','O-') DEFAULT NULL,
  `emergency_contact` varchar(100) DEFAULT NULL,
  `emergency_phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pasien`
--

INSERT INTO `tb_pasien` (`id_pasien`, `no_rm`, `nama_pasien`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_hp`, `email`, `pekerjaan`, `status_pernikahan`, `golongan_darah`, `emergency_contact`, `emergency_phone`, `created_at`) VALUES
(1, 'RM001', 'Ahmad Fauzi', 'Laki-laki', '1985-03-15', 'Jl. Merdeka No. 123, Jakarta Pusat', '081234567890', 'ahmad.fauzi@email.com', 'Pegawai Swasta', 'Menikah', 'A+', 'Siti Fauzi', '081234567891', '2024-01-15 08:30:00'),
(2, 'RM002', 'Siti Aminah', 'Perempuan', '1990-07-22', 'Jl. Sudirman No. 456, Jakarta Selatan', '082345678901', 'siti.aminah@email.com', 'Guru', 'Menikah', 'B+', 'Budi Aminah', '082345678902', '2024-01-20 09:15:00'),
(3, 'RM003', 'Budi Santoso', 'Laki-laki', '1978-11-08', 'Jl. Thamrin No. 789, Jakarta Barat', '083456789012', 'budi.santoso@email.com', 'Wiraswasta', 'Menikah', 'O+', 'Rina Santoso', '083456789013', '2024-02-01 10:00:00'),
(4, 'RM004', 'Dewi Lestari', 'Perempuan', '1995-12-03', 'Jl. Gatot Subroto No. 321, Jakarta Timur', '084567890123', 'dewi.lestari@email.com', 'Mahasiswa', 'Belum Menikah', 'AB+', 'Lestari Dewi', '084567890124', '2024-02-10 11:30:00'),
(5, 'RM005', 'Eko Prasetyo', 'Laki-laki', '1982-05-18', 'Jl. HR Rasuna Said No. 654, Jakarta Selatan', '085678901234', 'eko.prasetyo@email.com', 'PNS', 'Menikah', 'A-', 'Maya Prasetyo', '085678901235', '2024-02-15 14:20:00'),
(6, 'RM006', 'Maya Sari', 'Perempuan', '1988-09-25', 'Jl. Casablanca No. 987, Jakarta Selatan', '086789012345', 'maya.sari@email.com', 'Dokter', 'Menikah', 'B-', 'Indra Sari', '086789012346', '2024-02-20 08:45:00'),
(7, 'RM007', 'Indra Gunawan', 'Laki-laki', '1992-01-30', 'Jl. Kemang No. 147, Jakarta Selatan', '087890123456', 'indra.gunawan@email.com', 'Engineer', 'Belum Menikah', 'O-', 'Gunawan Sr', '087890123457', '2024-03-01 16:10:00'),
(8, 'RM008', 'Rina Wijaya', 'Perempuan', '1987-04-12', 'Jl. Pondok Indah No. 258, Jakarta Selatan', '088901234567', 'rina.wijaya@email.com', 'Akuntan', 'Cerai', 'AB-', 'Wijaya Mother', '088901234568', '2024-03-05 09:30:00'),
(9, 'RM009', 'Joko Widodo', 'Laki-laki', '1975-06-21', 'Jl. Menteng No. 369, Jakarta Pusat', '089012345678', 'joko.widodo@email.com', 'Pengusaha', 'Menikah', 'A+', 'Iriana Widodo', '089012345679', '2024-03-10 13:15:00'),
(10, 'RM010', 'Sri Mulyani', 'Perempuan', '1980-08-17', 'Jl. Senayan No. 741, Jakarta Pusat', '081123456789', 'sri.mulyani@email.com', 'Menteri', 'Menikah', 'B+', 'Mulyani Husband', '081123456790', '2024-03-15 10:45:00'),
(11, 'RM011', 'Agus Salim', 'Laki-laki', '1993-10-05', 'Jl. Kuningan No. 852, Jakarta Selatan', '082234567890', 'agus.salim@email.com', 'Marketing', 'Belum Menikah', 'O+', 'Salim Father', '082234567891', '2024-03-20 15:20:00'),
(12, 'RM012', 'Lina Handayani', 'Perempuan', '1991-02-14', 'Jl. Blok M No. 963, Jakarta Selatan', '083345678901', 'lina.handayani@email.com', 'Designer', 'Menikah', 'AB+', 'Rudi Handayani', '083345678902', '2024-03-25 11:55:00'),
(13, 'RM013', 'Rudi Hermawan', 'Laki-laki', '1986-12-28', 'Jl. Pancoran No. 159, Jakarta Selatan', '084456789012', 'rudi.hermawan@email.com', 'Pilot', 'Menikah', 'A-', 'Sari Hermawan', '084456789013', '2024-04-01 08:10:00'),
(14, 'RM014', 'Sari Indah', 'Perempuan', '1994-07-07', 'Jl. Tebet No. 753, Jakarta Selatan', '085567890123', 'sari.indah@email.com', 'Perawat', 'Belum Menikah', 'B-', 'Indah Mother', '085567890124', '2024-04-05 12:40:00'),
(15, 'RM015', 'Hendra Wijaya', 'Laki-laki', '1983-11-11', 'Jl. Cikini No. 486, Jakarta Pusat', '086678901234', 'hendra.wijaya@email.com', 'Arsitek', 'Janda/Duda', 'O-', 'Wijaya Sister', '086678901235', '2024-04-10 14:25:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dokter`
--

CREATE TABLE `tb_dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `spesialisasi` varchar(50) NOT NULL,
  `no_sip` varchar(50) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jadwal_praktek` text DEFAULT NULL,
  `tarif_konsultasi` decimal(10,2) DEFAULT 0.00,
  `pengalaman_tahun` int(11) DEFAULT 0,
  `pendidikan` varchar(200) DEFAULT NULL,
  `status_dokter` enum('aktif','nonaktif','cuti') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_dokter`
--

INSERT INTO `tb_dokter` (`id_dokter`, `nama_dokter`, `spesialisasi`, `no_sip`, `no_hp`, `email`, `alamat`, `jadwal_praktek`, `tarif_konsultasi`, `pengalaman_tahun`, `pendidikan`, `status_dokter`) VALUES
(1, 'Dr. Ahmad Fauzan, Sp.PD', 'Penyakit Dalam', 'SIP/001/2020', '081234567890', 'dr.ahmad@klinik24.com', 'Jl. Medika No. 123, Jakarta', 'Senin-Jumat: 08:00-16:00', 200000.00, 8, 'S1 Kedokteran UNAIR, Sp.PD RSCM', 'aktif'),
(2, 'Dr. Siti Rahma, Sp.A', 'Anak', 'SIP/002/2019', '082345678901', 'dr.siti@klinik24.com', 'Jl. Pediatrik No. 456, Jakarta', 'Senin-Sabtu: 09:00-17:00', 180000.00, 10, 'S1 Kedokteran UI, Sp.A RSCM', 'aktif'),
(3, 'Dr. Budi Santoso, Sp.OG', 'Kandungan', 'SIP/003/2021', '083456789012', 'dr.budi@klinik24.com', 'Jl. Obstetri No. 789, Jakarta', 'Selasa-Jumat: 08:00-15:00', 250000.00, 12, 'S1 Kedokteran UGM, Sp.OG RSUP Dr. Sardjito', 'aktif'),
(4, 'Dr. Maya Dewi, Sp.M', 'Mata', 'SIP/004/2022', '084567890123', 'dr.maya@klinik24.com', 'Jl. Oftalmologi No. 321, Jakarta', 'Senin-Kamis: 10:00-18:00', 220000.00, 6, 'S1 Kedokteran UNPAD, Sp.M JEC', 'aktif'),
(5, 'Dr. Eko Prasetyo, Sp.JP', 'Jantung', 'SIP/005/2018', '085678901234', 'dr.eko@klinik24.com', 'Jl. Kardiologi No. 654, Jakarta', 'Rabu-Sabtu: 07:00-14:00', 300000.00, 15, 'S1 Kedokteran UNHAS, Sp.JP RSUPN Cipto Mangunkusumo', 'aktif'),
(6, 'Dr. Rina Marlina, Sp.KK', 'Kulit dan Kelamin', 'SIP/006/2020', '086789012345', 'dr.rina@klinik24.com', 'Jl. Dermatologi No. 987, Jakarta', 'Senin-Jumat: 09:00-16:00', 190000.00, 7, 'S1 Kedokteran USU, Sp.KK RSUD Dr. Soetomo', 'aktif'),
(7, 'Dr. Indra Gunawan, Sp.THT', 'THT', 'SIP/007/2021', '087890123456', 'dr.indra@klinik24.com', 'Jl. ORL No. 147, Jakarta', 'Selasa-Sabtu: 08:00-15:00', 170000.00, 9, 'S1 Kedokteran UNDIP, Sp.THT RSUP Dr. Kariadi', 'aktif'),
(8, 'Dr. Lina Sari, Sp.S', 'Saraf', 'SIP/008/2019', '088901234567', 'dr.lina@klinik24.com', 'Jl. Neurologi No. 258, Jakarta', 'Senin-Rabu: 08:00-16:00', 280000.00, 11, 'S1 Kedokteran UNAIR, Sp.S RSUD Dr. Soetomo', 'aktif'),
(9, 'Dr. Joko Susanto, Sp.U', 'Urologi', 'SIP/009/2022', '089012345678', 'dr.joko@klinik24.com', 'Jl. Urologi No. 369, Jakarta', 'Kamis-Sabtu: 09:00-17:00', 240000.00, 8, 'S1 Kedokteran UGM, Sp.U RSUP Dr. Sardjito', 'aktif'),
(10, 'Dr. Sri Handayani, Sp.Rad', 'Radiologi', 'SIP/010/2020', '081123456789', 'dr.sri@klinik24.com', 'Jl. Radiologi No. 741, Jakarta', 'Senin-Jumat: 07:00-15:00', 160000.00, 13, 'S1 Kedokteran UI, Sp.Rad RSCM', 'aktif'),
(11, 'Dr. Agus Salim, Sp.An', 'Anestesi', 'SIP/011/2021', '082234567890', 'dr.agus@klinik24.com', 'Jl. Anestesi No. 852, Jakarta', 'Senin-Jumat: 06:00-14:00', 150000.00, 10, 'S1 Kedokteran UNPAD, Sp.An RSHS', 'aktif'),
(12, 'Dr. Hendra Wijaya, Sp.P', 'Paru', 'SIP/012/2019', '083345678901', 'dr.hendra@klinik24.com', 'Jl. Pulmonologi No. 963, Jakarta', 'Selasa-Kamis: 08:00-16:00', 210000.00, 14, 'S1 Kedokteran UNHAS, Sp.P RSUP Wahidin Sudirohusodo', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_obat`
--

CREATE TABLE `tb_obat` (
  `id_obat` int(11) NOT NULL,
  `kode_obat` varchar(20) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `bentuk_obat` enum('Tablet','Kapsul','Sirup','Suntik','Salep','Tetes','Inhaler','Suppositoria') NOT NULL,
  `dosis` varchar(50) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT 'pcs',
  `harga_satuan` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stok` int(11) NOT NULL DEFAULT 0,
  `stok_minimum` int(11) DEFAULT 10,
  `expired_date` date DEFAULT NULL,
  `produsen` varchar(100) DEFAULT NULL,
  `no_batch` varchar(50) DEFAULT NULL,
  `indikasi` text DEFAULT NULL,
  `kontraindikasi` text DEFAULT NULL,
  `efek_samping` text DEFAULT NULL,
  `cara_pakai` text DEFAULT NULL,
  `status_obat` enum('aktif','nonaktif','restricted') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_obat`
--

INSERT INTO `tb_obat` (`id_obat`, `kode_obat`, `nama_obat`, `kategori`, `bentuk_obat`, `dosis`, `satuan`, `harga_satuan`, `stok`, `stok_minimum`, `expired_date`, `produsen`, `no_batch`, `indikasi`, `kontraindikasi`, `efek_samping`, `cara_pakai`, `status_obat`) VALUES
(1, 'OBT001', 'Paracetamol 500mg', 'Analgesik', 'Tablet', '500mg', 'tablet', 2500.00, 150, 20, '2025-12-31', 'Kimia Farma', 'KF001-2024', 'Demam, nyeri ringan hingga sedang', 'Gangguan fungsi hati berat', 'Ruam kulit, mual', '3x1 tablet setelah makan', 'aktif'),
(2, 'OBT002', 'Amoxicillin 500mg', 'Antibiotik', 'Kapsul', '500mg', 'kapsul', 8500.00, 80, 15, '2025-11-30', 'Sanbe Farma', 'SF002-2024', 'Infeksi bakteri', 'Alergi penisilin', 'Diare, mual, muntah', '3x1 kapsul sebelum makan', 'aktif'),
(3, 'OBT003', 'OBH Combi', 'Antitusif', 'Sirup', '60ml', 'botol', 15000.00, 45, 10, '2025-10-31', 'OT Pharmaceutical', 'OT003-2024', 'Batuk berdahak', 'Hipersensitif terhadap komponen obat', 'Mengantuk, pusing', '3x1 sendok makan', 'aktif'),
(4, 'OBT004', 'Antasida DOEN', 'Antasida', 'Tablet', '500mg', 'tablet', 3000.00, 120, 25, '2026-01-31', 'DOEN Pharmaceuticals', 'DP004-2024', 'Maag, gastritis', 'Gangguan ginjal berat', 'Konstipasi, diare', '3x1 tablet setelah makan', 'aktif'),
(5, 'OBT005', 'Betadine Solution', 'Antiseptik', 'Tetes', '15ml', 'botol', 12000.00, 60, 12, '2025-09-30', 'Mahakam Beta Farma', 'MBF005-2024', 'Antiseptik luka luar', 'Alergi iodine', 'Iritasi kulit', 'Oleskan pada luka 2-3x sehari', 'aktif'),
(6, 'OBT006', 'Salbutamol Inhaler', 'Bronkodilator', 'Inhaler', '100mcg', 'puff', 45000.00, 30, 8, '2025-08-31', 'GlaxoSmithKline', 'GSK006-2024', 'Asma, sesak napas', 'Hipersensitif terhadap salbutamol', 'Jantung berdebar, tremor', '1-2 puff saat sesak napas', 'aktif'),
(7, 'OBT007', 'Ibuprofen 400mg', 'Anti-inflamasi', 'Tablet', '400mg', 'tablet', 4500.00, 90, 18, '2025-12-15', 'Dexa Medica', 'DM007-2024', 'Nyeri, inflamasi, demam', 'Tukak lambung, gangguan ginjal', 'Nyeri lambung, pusing', '3x1 tablet sesudah makan', 'aktif'),
(8, 'OBT008', 'Vitamin C 1000mg', 'Vitamin', 'Tablet', '1000mg', 'tablet', 5000.00, 200, 30, '2026-06-30', 'Blackmores', 'BM008-2024', 'Suplemen vitamin C', 'Batu ginjal oksalat', 'Diare pada dosis tinggi', '1x1 tablet setelah makan', 'aktif'),
(9, 'OBT009', 'Captopril 25mg', 'ACE Inhibitor', 'Tablet', '25mg', 'tablet', 6500.00, 75, 15, '2025-07-31', 'Novell Pharmaceutical', 'NP009-2024', 'Hipertensi, gagal jantung', 'Angioedema, kehamilan', 'Batuk kering, hipotensi', '2x1 tablet sebelum makan', 'aktif'),
(10, 'OBT010', 'Omeprazole 20mg', 'PPI', 'Kapsul', '20mg', 'kapsul', 7500.00, 65, 12, '2025-11-15', 'Bernofarm', 'BF010-2024', 'GERD, tukak lambung', 'Hipersensitif terhadap omeprazole', 'Sakit kepala, diare', '1x1 kapsul sebelum makan pagi', 'aktif'),
(11, 'OBT011', 'Cetirizine 10mg', 'Antihistamin', 'Tablet', '10mg', 'tablet', 3500.00, 100, 20, '2025-12-20', 'Tempo Scan Pacific', 'TSP011-2024', 'Alergi, rhinitis', 'Hipersensitif terhadap cetirizine', 'Mengantuk, mulut kering', '1x1 tablet malam hari', 'aktif'),
(12, 'OBT012', 'Dexamethasone 0.5mg', 'Kortikosteroid', 'Tablet', '0.5mg', 'tablet', 8000.00, 40, 10, '2025-10-15', 'Pharos Indonesia', 'PI012-2024', 'Inflamasi, alergi berat', 'Infeksi sistemik, diabetes tidak terkontrol', 'Peningkatan gula darah, osteoporosis', 'Sesuai petunjuk dokter', 'restricted'),
(13, 'OBT013', 'Loratadine 10mg', 'Antihistamin', 'Tablet', '10mg', 'tablet', 4000.00, 85, 15, '2026-02-28', 'Schering-Plough', 'SP013-2024', 'Rhinitis alergi, urtikaria', 'Hipersensitif terhadap loratadine', 'Sakit kepala, kelelahan', '1x1 tablet per hari', 'aktif'),
(14, 'OBT014', 'Simvastatin 20mg', 'Statin', 'Tablet', '20mg', 'tablet', 9500.00, 55, 12, '2025-09-15', 'Merck Sharp & Dohme', 'MSD014-2024', 'Kolesterol tinggi', 'Penyakit hati aktif, kehamilan', 'Nyeri otot, gangguan pencernaan', '1x1 tablet malam hari', 'aktif'),
(15, 'OBT015', 'Metformin 500mg', 'Antidiabetik', 'Tablet', '500mg', 'tablet', 5500.00, 95, 20, '2025-08-20', 'Indofarma', 'IF015-2024', 'Diabetes mellitus tipe 2', 'Gagal ginjal, asidosis laktat', 'Mual, diare, nyeri perut', '2x1 tablet bersama makan', 'aktif'),
(16, 'OBT016', 'Amlodipine 5mg', 'CCB', 'Tablet', '5mg', 'tablet', 6000.00, 70, 15, '2025-11-10', 'Pfizer Indonesia', 'PF016-2024', 'Hipertensi, angina', 'Syok kardiogenik, stenosis aorta berat', 'Edema perifer, pusing', '1x1 tablet pagi hari', 'aktif'),
(17, 'OBT017', 'Ranitidine 150mg', 'H2 Blocker', 'Tablet', '150mg', 'tablet', 4200.00, 80, 18, '2025-07-25', 'Sanbe Farma', 'SF017-2024', 'Tukak peptik, GERD', 'Hipersensitif terhadap ranitidine', 'Sakit kepala, konstipasi', '2x1 tablet setelah makan', 'aktif'),
(18, 'OBT018', 'Diclofenac Sodium 50mg', 'NSAID', 'Tablet', '50mg', 'tablet', 5800.00, 60, 12, '2025-10-05', 'Novartis Indonesia', 'NI018-2024', 'Nyeri inflamasi, arthritis', 'Tukak peptik, gangguan ginjal berat', 'Nyeri epigastrium, pusing', '3x1 tablet sesudah makan', 'aktif'),
(19, 'OBT019', 'Chloramphenicol Eye Drop', 'Antibiotik', 'Tetes', '5ml', 'botol', 18000.00, 35, 8, '2025-06-30', 'Cendo', 'CD019-2024', 'Infeksi mata bakterial', 'Hipersensitif terhadap chloramphenicol', 'Iritasi mata ringan', '1-2 tetes tiap 4 jam', 'aktif'),
(20, 'OBT020', 'Hydrocortisone Cream 2.5%', 'Kortikosteroid', 'Salep', '2.5%', 'tube', 22000.00, 25, 6, '2025-12-10', 'Johnson & Johnson', 'JJ020-2024', 'Eksim, dermatitis', 'Infeksi kulit viral/bakteri', 'Atrofi kulit, stretch mark', 'Oleskan tipis 2-3x sehari', 'aktif'),
(21, 'OBT021', 'Domperidone 10mg', 'Prokinetik', 'Tablet', '10mg', 'tablet', 3800.00, 90, 20, '2025-11-25', 'Kalbe Farma', 'KF021-2024', 'Mual, muntah, dispepsia', 'Prolaktinoma, perdarahan GI', 'Sakit kepala, mulut kering', '3x1 tablet sebelum makan', 'aktif'),
(22, 'OBT022', 'Ketoconazole Shampoo 2%', 'Antifungi', 'Sirup', '60ml', 'botol', 35000.00, 20, 5, '2025-09-10', 'Janssen-Cilag', 'JC022-2024', 'Ketombe, dermatitis seboroik', 'Hipersensitif terhadap ketoconazole', 'Iritasi kulit kepala', 'Gunakan 2x seminggu', 'aktif'),
(23, 'OBT023', 'Furosemide 40mg', 'Diuretik', 'Tablet', '40mg', 'tablet', 4500.00, 50, 10, '2025-08-15', 'Aventis Pharma', 'AP023-2024', 'Edema, hipertensi', 'Anuria, gangguan elektrolit berat', 'Hipokalemia, dehidrasi', '1-2x1 tablet pagi hari', 'aktif'),
(24, 'OBT024', 'Salicyl Acid 2% Lotion', 'Keratolitik', 'Tetes', '30ml', 'botol', 28000.00, 15, 4, '2025-07-20', 'Galderma', 'GD024-2024', 'Jerawat, psoriasis', 'Hipersensitif terhadap salisilat', 'Kering, iritasi kulit', 'Oleskan malam hari', 'aktif'),
(25, 'OBT025', 'Insulin Aspart', 'Antidiabetik', 'Suntik', '100U/ml', 'vial', 120000.00, 12, 3, '2025-06-15', 'Novo Nordisk', 'NN025-2024', 'Diabetes mellitus', 'Hipoglikemia', 'Hipoglikemia, reaksi injeksi', 'Injeksi subkutan sebelum makan', 'restricted');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_staff`
--

CREATE TABLE `tb_staff` (
  `id_staff` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama_staff` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jabatan` varchar(50) NOT NULL,
  `departemen` varchar(50) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `gaji_pokok` decimal(12,2) DEFAULT 0.00,
  `status_staff` enum('aktif','nonaktif','cuti','pensiun') DEFAULT 'aktif',
  `pendidikan_terakhir` varchar(100) DEFAULT NULL,
  `sertifikasi` text DEFAULT NULL,
  `emergency_contact` varchar(100) DEFAULT NULL,
  `emergency_phone` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_staff`
--

INSERT INTO `tb_staff` (`id_staff`, `nip`, `nama_staff`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_hp`, `email`, `jabatan`, `departemen`, `tanggal_masuk`, `gaji_pokok`, `status_staff`, `pendidikan_terakhir`, `sertifikasi`, `emergency_contact`, `emergency_phone`) VALUES
(1, 'STF001', 'Nurse Ana Kristina', 'Perempuan', '1990-05-15', 'Jl. Perawat No. 123, Jakarta', '081234567890', 'ana.kristina@klinik24.com', 'Perawat Senior', 'Keperawatan', '2020-01-15', 5500000.00, 'aktif', 'D3 Keperawatan', 'Sertifikat BLS, ACLS', 'Kristina Mother', '081234567891'),
(2, 'STF002', 'Ahmad Pharmacy', 'Laki-laki', '1988-03-22', 'Jl. Apoteker No. 456, Jakarta', '082345678901', 'ahmad.pharmacy@klinik24.com', 'Apoteker', 'Farmasi', '2019-06-01', 6500000.00, 'aktif', 'S1 Farmasi', 'Sertifikat Apoteker, BNSP', 'Ahmad Wife', '082345678902'),
(3, 'STF003', 'Siti Kasir', 'Perempuan', '1992-07-10', 'Jl. Administrasi No. 789, Jakarta', '083456789012', 'siti.kasir@klinik24.com', 'Kasir', 'Keuangan', '2021-03-10', 4200000.00, 'aktif', 'SMK Akuntansi', 'Sertifikat Kasir', 'Siti Father', '083456789013'),
(4, 'STF004', 'Budi Teknisi', 'Laki-laki', '1985-11-08', 'Jl. Laboratorium No. 321, Jakarta', '084567890123', 'budi.teknisi@klinik24.com', 'Teknisi Lab', 'Laboratorium', '2018-09-15', 4800000.00, 'aktif', 'D3 Teknologi Lab Medik', 'Sertifikat ATLM', 'Budi Wife', '084567890124'),
(5, 'STF005', 'Dewi Radiografer', 'Perempuan', '1987-12-03', 'Jl. Radiologi No. 654, Jakarta', '085678901234', 'dewi.radiografer@klinik24.com', 'Radiografer', 'Radiologi', '2020-07-20', 5200000.00, 'aktif', 'D3 Radiologi', 'Sertifikat Radiografer', 'Dewi Husband', '085678901235'),
(6, 'STF006', 'Eko Security', 'Laki-laki', '1983-09-25', 'Jl. Keamanan No. 987, Jakarta', '086789012345', 'eko.security@klinik24.com', 'Security', 'Keamanan', '2019-01-10', 3800000.00, 'aktif', 'SMA', 'Sertifikat Satpam Garda', 'Eko Mother', '086789012346'),
(7, 'STF007', 'Maya Cleaning', 'Perempuan', '1991-01-30', 'Jl. Kebersihan No. 147, Jakarta', '087890123456', 'maya.cleaning@klinik24.com', 'Cleaning Service', 'Umum', '2021-11-05', 3500000.00, 'aktif', 'SMP', 'Sertifikat Cleaning Service', 'Maya Sister', '087890123457'),
(8, 'STF008', 'Indra IT Support', 'Laki-laki', '1989-04-12', 'Jl. Teknologi No. 258, Jakarta', '088901234567', 'indra.it@klinik24.com', 'IT Support', 'IT', '2020-02-28', 6000000.00, 'aktif', 'S1 Informatika', 'Sertifikat Network+, A+', 'Indra Wife', '088901234568'),
(9, 'STF009', 'Rina Admin', 'Perempuan', '1986-06-21', 'Jl. Administrasi No. 369, Jakarta', '089012345678', 'rina.admin@klinik24.com', 'Admin', 'Administrasi', '2018-12-01', 4500000.00, 'aktif', 'D3 Sekretaris', 'Sertifikat Administrasi', 'Rina Father', '089012345679'),
(10, 'STF010', 'Joko Driver', 'Laki-laki', '1982-08-17', 'Jl. Transport No. 741, Jakarta', '081123456789', 'joko.driver@klinik24.com', 'Driver Ambulance', 'Transport', '2019-05-15', 4000000.00, 'aktif', 'SMA', 'SIM B1, Sertifikat P3K', 'Joko Wife', '081123456790'),
(11, 'STF011', 'Sri Nutrition', 'Perempuan', '1990-10-05', 'Jl. Gizi No. 852, Jakarta', '082234567890', 'sri.nutrition@klinik24.com', 'Ahli Gizi', 'Gizi', '2021-08-12', 5800000.00, 'aktif', 'S1 Gizi', 'Sertifikat Dietisien', 'Sri Husband', '082234567891'),
(12, 'STF012', 'Agus Maintenance', 'Laki-laki', '1984-02-14', 'Jl. Teknik No. 963, Jakarta', '083345678901', 'agus.maintenance@klinik24.com', 'Teknisi Maintenance', 'Teknik', '2020-04-20', 4300000.00, 'aktif', 'SMK Teknik', 'Sertifikat Teknisi Listrik', 'Agus Mother', '083345678902'),
(13, 'STF013', 'Lina Physiotherapy', 'Perempuan', '1988-12-28', 'Jl. Fisioterapi No. 159, Jakarta', '084456789012', 'lina.physio@klinik24.com', 'Fisioterapis', 'Rehabilitasi', '2019-10-30', 5600000.00, 'aktif', 'S1 Fisioterapi', 'Sertifikat Fisioterapis', 'Lina Father', '084456789013'),
(14, 'STF014', 'Rudi Public Relations', 'Laki-laki', '1987-07-07', 'Jl. Humas No. 753, Jakarta', '085567890123', 'rudi.pr@klinik24.com', 'Humas', 'Marketing', '2020-09-10', 5300000.00, 'aktif', 'S1 Komunikasi', 'Sertifikat Public Relations', 'Rudi Wife', '085567890124'),
(15, 'STF015', 'Sari Manager', 'Perempuan', '1985-11-11', 'Jl. Manajemen No. 486, Jakarta', '086678901234', 'sari.manager@klinik24.com', 'Manager Operasional', 'Manajemen', '2018-01-08', 8500000.00, 'aktif', 'S1 Manajemen', 'Sertifikat Manajemen RS', 'Sari Husband', '086678901235');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` enum('admin','pembayaran','pendaftaran','pemeriksaan','kasir','apoteker','dokter') NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profile` varchar(255) DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif','suspended') DEFAULT 'aktif',
  `last_login` timestamp NULL DEFAULT NULL,
  `login_count` int(11) DEFAULT 0,
  `ip_address_last` varchar(45) DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT 'system'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

-- Sample data user dengan password plain text untuk kompatibilitas dengan sistem login yang ada
-- Note: Dalam implementasi production, gunakan password yang di-hash
INSERT INTO `tb_user` (`id_user`, `username`, `password`, `jabatan`, `nama_lengkap`, `email`, `no_hp`, `alamat`, `foto_profile`, `status_aktif`, `last_login`, `login_count`, `ip_address_last`, `password_changed_at`, `created_by`) VALUES
(1, 'admin', 'admin', 'admin', 'Administrator System', 'admin@klinik24.com', '081234567890', 'Jl. Kesehatan No. 1, Jakarta', NULL, 'aktif', '2025-01-08 10:30:00', 45, '192.168.1.100', '2025-01-01 08:00:00', 'system'),
(2, 'kasir', 'kasir', 'pembayaran', 'Siti Kasir', 'kasir@klinik24.com', '081234567891', 'Jl. Mawar No. 12, Jakarta', NULL, 'aktif', '2025-01-08 09:15:00', 23, '192.168.1.101', '2025-01-01 08:00:00', 'admin'),
(3, 'pendaftaran', 'pendaftaran', 'pendaftaran', 'Budi Pendaftaran', 'pendaftaran@klinik24.com', '081234567892', 'Jl. Melati No. 15, Jakarta', NULL, 'aktif', '2025-01-08 08:45:00', 67, '192.168.1.102', '2025-01-01 08:00:00', 'admin'),
(4, 'pemeriksaan', 'pemeriksaan', 'pemeriksaan', 'Dr. Rina Pemeriksaan', 'pemeriksaan@klinik24.com', '081234567893', 'Jl. Anggrek No. 8, Jakarta', NULL, 'aktif', '2025-01-08 07:30:00', 89, '192.168.1.103', '2025-01-01 08:00:00', 'admin'),
(5, 'evina', 'evina', 'pembayaran', 'Evina Kasir', 'evina@klinik24.com', '081234567894', 'Jl. Dahlia No. 20, Jakarta', NULL, 'aktif', '2025-01-07 16:20:00', 34, '192.168.1.104', '2025-01-01 08:00:00', 'admin'),
(6, 'pegawai', 'pegawai', 'pembayaran', 'Ahmad Pegawai', 'pegawai@klinik24.com', '081234567895', 'Jl. Tulip No. 25, Jakarta', NULL, 'aktif', '2025-01-07 15:45:00', 12, '192.168.1.105', '2025-01-01 08:00:00', 'admin'),
(7, 'apoteker1', 'apoteker123', 'apoteker', 'Apt. Sarah Apoteker', 'apoteker@klinik24.com', '081234567896', 'Jl. Kenanga No. 30, Jakarta', NULL, 'aktif', '2025-01-08 08:00:00', 56, '192.168.1.106', '2025-01-01 08:00:00', 'admin'),
(8, 'dokter1', 'dokter123', 'dokter', 'Dr. Joko Widodo', 'dokter1@klinik24.com', '081234567897', 'Jl. Flamboyan No. 35, Jakarta', NULL, 'aktif', '2025-01-08 07:00:00', 78, '192.168.1.107', '2025-01-01 08:00:00', 'admin'),
(9, 'supervisor', 'supervisor123', 'admin', 'Supervisor Klinik', 'supervisor@klinik24.com', '081234567898', 'Jl. Sakura No. 40, Jakarta', NULL, 'aktif', '2025-01-07 18:30:00', 29, '192.168.1.108', '2025-01-01 08:00:00', 'admin'),
(10, 'manager', 'manager123', 'admin', 'Manager Operasional', 'manager@klinik24.com', '081234567899', 'Jl. Teratai No. 45, Jakarta', NULL, 'aktif', '2025-01-07 17:15:00', 41, '192.168.1.109', '2025-01-01 08:00:00', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_login_log`
--

CREATE TABLE `user_login_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `logout_time` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `status_login` enum('success','failed','logout') NOT NULL,
  `session_duration` int(11) DEFAULT NULL,
  `login_method` enum('web','mobile','api') DEFAULT 'web',
  `failure_reason` varchar(255) DEFAULT NULL,
  `browser_info` varchar(255) DEFAULT NULL,
  `location_info` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_login_log`
--

-- Sample data login log dengan pola login yang realistis
INSERT INTO `user_login_log` (`id`, `user_id`, `username`, `login_time`, `logout_time`, `ip_address`, `user_agent`, `status_login`, `session_duration`, `login_method`, `failure_reason`, `browser_info`, `location_info`) VALUES
(1, 1, 'admin', '2025-01-08 08:30:00', '2025-01-08 17:45:00', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 555, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(2, 1, 'admin', '2025-01-07 08:15:00', '2025-01-07 17:25:00', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 550, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(3, 2, 'kasir', '2025-01-08 09:15:00', '2025-01-08 17:00:00', '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 465, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(4, 3, 'pendaftaran', '2025-01-08 08:45:00', '2025-01-08 16:30:00', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 465, 'web', NULL, 'Firefox 115.0', 'Jakarta, ID'),
(5, 4, 'pemeriksaan', '2025-01-08 07:30:00', '2025-01-08 15:45:00', '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 495, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(6, 7, 'apoteker1', '2025-01-08 08:00:00', '2025-01-08 16:00:00', '192.168.1.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 480, 'web', NULL, 'Edge 126.0', 'Jakarta, ID'),
(7, 8, 'dokter1', '2025-01-08 07:00:00', '2025-01-08 14:30:00', '192.168.1.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 450, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(8, 1, 'admin', '2025-01-07 22:15:00', NULL, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'failed', NULL, 'web', 'Wrong password', 'Chrome 126.0', 'Jakarta, ID'),
(9, 5, 'evina', '2025-01-07 16:20:00', '2025-01-07 23:45:00', '192.168.1.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 445, 'web', NULL, 'Safari 17.0', 'Jakarta, ID'),
(10, 6, 'pegawai', '2025-01-07 15:45:00', '2025-01-07 23:30:00', '192.168.1.105', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 465, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(11, 9, 'supervisor', '2025-01-07 18:30:00', '2025-01-08 01:15:00', '192.168.1.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 405, 'web', NULL, 'Firefox 115.0', 'Jakarta, ID'),
(12, 10, 'manager', '2025-01-07 17:15:00', '2025-01-08 00:45:00', '192.168.1.109', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 450, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(13, 2, 'kasir', '2025-01-06 09:00:00', '2025-01-06 17:30:00', '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 510, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(14, 3, 'pendaftaran', '2025-01-06 08:30:00', '2025-01-06 16:45:00', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 495, 'web', NULL, 'Firefox 115.0', 'Jakarta, ID'),
(15, NULL, 'unknown_user', '2025-01-06 14:22:00', NULL, '203.0.113.45', 'Mozilla/5.0 (Unknown) Bot/1.0', 'failed', NULL, 'web', 'Invalid username', 'Unknown Bot', 'Unknown'),
(16, 4, 'pemeriksaan', '2025-01-05 07:45:00', '2025-01-05 16:00:00', '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 495, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(17, 1, 'admin', '2025-01-05 09:00:00', '2025-01-05 18:30:00', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 570, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(18, 7, 'apoteker1', '2025-01-04 08:15:00', '2025-01-04 16:30:00', '192.168.1.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 495, 'web', NULL, 'Edge 126.0', 'Jakarta, ID'),
(19, 8, 'dokter1', '2025-01-04 06:45:00', '2025-01-04 14:15:00', '192.168.1.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 450, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(20, 2, 'kasir', '2025-01-03 22:15:00', NULL, '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'failed', NULL, 'web', 'Account locked', 'Chrome 126.0', 'Jakarta, ID');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role_permissions`
--

CREATE TABLE `user_role_permissions` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `permission_type` enum('view','create','edit','delete','export','admin') NOT NULL,
  `is_granted` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_role_permissions`
--

INSERT INTO `user_role_permissions` (`id`, `role_name`, `module_name`, `permission_type`, `is_granted`, `description`) VALUES
(1, 'admin', 'dashboard', 'view', 1, 'Akses dashboard utama'),
(2, 'admin', 'pasien', 'view', 1, 'Lihat data pasien'),
(3, 'admin', 'pasien', 'create', 1, 'Tambah data pasien'),
(4, 'admin', 'pasien', 'edit', 1, 'Edit data pasien'),
(5, 'admin', 'pasien', 'delete', 1, 'Hapus data pasien'),
(6, 'admin', 'dokter', 'view', 1, 'Lihat data dokter'),
(7, 'admin', 'dokter', 'create', 1, 'Tambah data dokter'),
(8, 'admin', 'dokter', 'edit', 1, 'Edit data dokter'),
(9, 'admin', 'dokter', 'delete', 1, 'Hapus data dokter'),
(10, 'admin', 'obat', 'view', 1, 'Lihat data obat'),
(11, 'admin', 'obat', 'create', 1, 'Tambah data obat'),
(12, 'admin', 'obat', 'edit', 1, 'Edit data obat'),
(13, 'admin', 'obat', 'delete', 1, 'Hapus data obat'),
(14, 'admin', 'staff', 'view', 1, 'Lihat data staff'),
(15, 'admin', 'staff', 'create', 1, 'Tambah data staff'),
(16, 'admin', 'staff', 'edit', 1, 'Edit data staff'),
(17, 'admin', 'staff', 'delete', 1, 'Hapus data staff'),
(18, 'admin', 'pemeriksaan', 'view', 1, 'Lihat data pemeriksaan'),
(19, 'admin', 'pemeriksaan', 'create', 1, 'Tambah data pemeriksaan'),
(20, 'admin', 'pemeriksaan', 'edit', 1, 'Edit data pemeriksaan'),
(21, 'admin', 'pemeriksaan', 'delete', 1, 'Hapus data pemeriksaan'),
(22, 'admin', 'keuntungan', 'view', 1, 'Lihat laporan keuntungan'),
(23, 'admin', 'keuntungan', 'export', 1, 'Export laporan keuntungan'),
(24, 'admin', 'pengeluaran', 'view', 1, 'Lihat data pengeluaran'),
(25, 'admin', 'pengeluaran', 'create', 1, 'Tambah data pengeluaran'),
(26, 'admin', 'pengeluaran', 'edit', 1, 'Edit data pengeluaran'),
(27, 'admin', 'pengeluaran', 'delete', 1, 'Hapus data pengeluaran'),
(28, 'admin', 'user', 'view', 1, 'Lihat data user'),
(29, 'admin', 'user', 'create', 1, 'Tambah data user'),
(30, 'admin', 'user', 'edit', 1, 'Edit data user'),
(31, 'admin', 'user', 'delete', 1, 'Hapus data user'),
(32, 'pembayaran', 'dashboard', 'view', 1, 'Akses dashboard'),
(33, 'pembayaran', 'pasien', 'view', 1, 'Lihat data pasien'),
(34, 'pembayaran', 'pengeluaran', 'view', 1, 'Lihat data pengeluaran'),
(35, 'pembayaran', 'pengeluaran', 'create', 1, 'Tambah data pengeluaran'),
(36, 'pembayaran', 'pengeluaran', 'edit', 1, 'Edit data pengeluaran'),
(37, 'pembayaran', 'keuntungan', 'view', 1, 'Lihat laporan keuntungan'),
(38, 'pendaftaran', 'dashboard', 'view', 1, 'Akses dashboard'),
(39, 'pendaftaran', 'pasien', 'view', 1, 'Lihat data pasien'),
(40, 'pendaftaran', 'pasien', 'create', 1, 'Tambah data pasien'),
(41, 'pendaftaran', 'pasien', 'edit', 1, 'Edit data pasien'),
(42, 'pendaftaran', 'dokter', 'view', 1, 'Lihat data dokter'),
(43, 'pemeriksaan', 'dashboard', 'view', 1, 'Akses dashboard'),
(44, 'pemeriksaan', 'pasien', 'view', 1, 'Lihat data pasien'),
(45, 'pemeriksaan', 'dokter', 'view', 1, 'Lihat data dokter'),
(46, 'pemeriksaan', 'pemeriksaan', 'view', 1, 'Lihat data pemeriksaan'),
(47, 'pemeriksaan', 'pemeriksaan', 'create', 1, 'Tambah data pemeriksaan'),
(48, 'pemeriksaan', 'pemeriksaan', 'edit', 1, 'Edit data pemeriksaan'),
(49, 'apoteker', 'dashboard', 'view', 1, 'Akses dashboard'),
(50, 'apoteker', 'obat', 'view', 1, 'Lihat data obat'),
(51, 'apoteker', 'obat', 'create', 1, 'Tambah data obat'),
(52, 'apoteker', 'obat', 'edit', 1, 'Edit data obat'),
(53, 'dokter', 'dashboard', 'view', 1, 'Akses dashboard'),
(54, 'dokter', 'pasien', 'view', 1, 'Lihat data pasien'),
(55, 'dokter', 'pemeriksaan', 'view', 1, 'Lihat data pemeriksaan'),
(56, 'dokter', 'pemeriksaan', 'create', 1, 'Tambah data pemeriksaan'),
(57, 'dokter', 'pemeriksaan', 'edit', 1, 'Edit data pemeriksaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_session_management`
--

CREATE TABLE `user_session_management` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_session_management`
--

INSERT INTO `user_session_management` (`id`, `user_id`, `session_id`, `session_token`, `ip_address`, `user_agent`, `is_active`, `created_at`, `expires_at`, `last_activity`) VALUES
(1, 1, 'sess_admin_20250708_103000', 'token_abc123def456ghi789', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 1, '2025-07-08 10:30:00', '2025-07-08 18:30:00', '2025-07-08 15:45:00'),
(2, 2, 'sess_kasir_20250708_091500', 'token_xyz789uvw456rst123', '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 1, '2025-07-08 09:15:00', '2025-07-08 17:15:00', '2025-07-08 16:30:00'),
(3, 3, 'sess_pendaftaran_20250708_084500', 'token_mno345pqr678stu901', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 1, '2025-07-08 08:45:00', '2025-07-08 16:45:00', '2025-07-08 16:15:00'),
(4, 4, 'sess_pemeriksaan_20250708_073000', 'token_def123ghi456jkl789', '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 1, '2025-07-08 07:30:00', '2025-07-08 15:30:00', '2025-07-08 15:00:00');

-- --------------------------------------------------------

--
-- Tabel untuk Sistem Keuntungan dan Analitik Keuangan
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuntungan`
--

CREATE TABLE `keuntungan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `sumber_keuntungan` enum('Penjualan Obat','Pemeriksaan Cepat','Vaksinasi','Konsultasi Dokter','Kesehatan Korporat','Alat Kesehatan & Vitamin','Lainnya') NOT NULL,
  `sub_layanan` varchar(255) DEFAULT NULL,
  `jumlah_keuntungan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_transaksi` int(11) DEFAULT 0,
  `biaya_operasional` decimal(15,2) DEFAULT 0.00,
  `keuntungan_bersih` decimal(15,2) NOT NULL DEFAULT 0.00,
  `persentase_margin` decimal(5,2) DEFAULT 0.00,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keuntungan`
--

INSERT INTO `keuntungan` (`id`, `tanggal`, `sumber_keuntungan`, `sub_layanan`, `jumlah_keuntungan`, `jumlah_transaksi`, `biaya_operasional`, `keuntungan_bersih`, `persentase_margin`, `bulan`, `tahun`, `keterangan`) VALUES
(1, '2025-01-31', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 18000000.00, 50, 8000000.00, 10000000.00, 55.56, 1, 2025, 'Penjualan obat bulan Januari'),
(2, '2025-01-31', 'Konsultasi Dokter', 'Konsultasi Umum', 6000000.00, 15, 2000000.00, 4000000.00, 66.67, 1, 2025, 'Konsultasi dokter Januari'),
(3, '2025-01-31', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 4000000.00, 20, 1500000.00, 2500000.00, 62.50, 1, 2025, 'Pemeriksaan cepat Januari'),
(4, '2025-01-31', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 2500000.00, 10, 1000000.00, 1500000.00, 60.00, 1, 2025, 'Vaksinasi Januari'),
(5, '2025-01-31', 'Kesehatan Korporat', 'Medical Checkup Karyawan', 3500000.00, 1, 1200000.00, 2300000.00, 65.71, 1, 2025, 'MCU korporat Januari'),
(6, '2025-01-31', 'Alat Kesehatan & Vitamin', 'Alat Medis Kecil, Vitamin', 2000000.00, 8, 800000.00, 1200000.00, 60.00, 1, 2025, 'Alat kesehatan Januari'),
(7, '2025-02-28', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 20000000.00, 55, 8500000.00, 11500000.00, 57.50, 2, 2025, 'Penjualan obat bulan Februari'),
(8, '2025-02-28', 'Konsultasi Dokter', 'Konsultasi Umum', 6500000.00, 18, 2200000.00, 4300000.00, 66.15, 2, 2025, 'Konsultasi dokter Februari'),
(9, '2025-02-28', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 4500000.00, 22, 1600000.00, 2900000.00, 64.44, 2, 2025, 'Pemeriksaan cepat Februari'),
(10, '2025-02-28', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 3000000.00, 12, 1100000.00, 1900000.00, 63.33, 2, 2025, 'Vaksinasi Februari'),
(11, '2025-02-28', 'Kesehatan Korporat', 'Medical Checkup Karyawan', 4000000.00, 1, 1300000.00, 2700000.00, 67.50, 2, 2025, 'MCU korporat Februari'),
(12, '2025-02-28', 'Alat Kesehatan & Vitamin', 'Alat Medis Kecil, Vitamin', 2500000.00, 10, 900000.00, 1600000.00, 64.00, 2, 2025, 'Alat kesehatan Februari'),
(13, '2025-03-31', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 22000000.00, 60, 9000000.00, 13000000.00, 59.09, 3, 2025, 'Penjualan obat bulan Maret'),
(14, '2025-03-31', 'Konsultasi Dokter', 'Konsultasi Umum', 7000000.00, 20, 2400000.00, 4600000.00, 65.71, 3, 2025, 'Konsultasi dokter Maret'),
(15, '2025-03-31', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 5000000.00, 25, 1800000.00, 3200000.00, 64.00, 3, 2025, 'Pemeriksaan cepat Maret'),
(16, '2025-03-31', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 3500000.00, 14, 1200000.00, 2300000.00, 65.71, 3, 2025, 'Vaksinasi Maret'),
(17, '2025-03-31', 'Kesehatan Korporat', 'Medical Checkup Karyawan', 4500000.00, 1, 1400000.00, 3100000.00, 68.89, 3, 2025, 'MCU korporat Maret'),
(18, '2025-03-31', 'Alat Kesehatan & Vitamin', 'Alat Medis Kecil, Vitamin', 3000000.00, 12, 1000000.00, 2000000.00, 66.67, 3, 2025, 'Alat kesehatan Maret'),
(19, '2025-04-30', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 24000000.00, 65, 9500000.00, 14500000.00, 60.42, 4, 2025, 'Penjualan obat bulan April'),
(20, '2025-04-30', 'Konsultasi Dokter', 'Konsultasi Umum', 7500000.00, 22, 2600000.00, 4900000.00, 65.33, 4, 2025, 'Konsultasi dokter April'),
(21, '2025-04-30', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 5500000.00, 28, 2000000.00, 3500000.00, 63.64, 4, 2025, 'Pemeriksaan cepat April'),
(22, '2025-04-30', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 4000000.00, 16, 1300000.00, 2700000.00, 67.50, 4, 2025, 'Vaksinasi April'),
(23, '2025-04-30', 'Kesehatan Korporat', 'Medical Checkup Karyawan', 5000000.00, 1, 1500000.00, 3500000.00, 70.00, 4, 2025, 'MCU korporat April'),
(24, '2025-04-30', 'Alat Kesehatan & Vitamin', 'Alat Medis Kecil, Vitamin', 3500000.00, 14, 1100000.00, 2400000.00, 68.57, 4, 2025, 'Alat kesehatan April'),
(25, '2025-05-31', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 23000000.00, 62, 9200000.00, 13800000.00, 60.00, 5, 2025, 'Penjualan obat bulan Mei'),
(26, '2025-05-31', 'Konsultasi Dokter', 'Konsultasi Umum', 7200000.00, 21, 2500000.00, 4700000.00, 65.28, 5, 2025, 'Konsultasi dokter Mei'),
(27, '2025-05-31', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 5200000.00, 26, 1900000.00, 3300000.00, 63.46, 5, 2025, 'Pemeriksaan cepat Mei'),
(28, '2025-05-31', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 3800000.00, 15, 1250000.00, 2550000.00, 67.11, 5, 2025, 'Vaksinasi Mei'),
(29, '2025-05-31', 'Kesehatan Korporat', 'Medical Checkup Karyawan', 4800000.00, 1, 1450000.00, 3350000.00, 69.79, 5, 2025, 'MCU korporat Mei'),
(30, '2025-05-31', 'Alat Kesehatan & Vitamin', 'Alat Medis Kecil, Vitamin', 3200000.00, 13, 1050000.00, 2150000.00, 67.19, 5, 2025, 'Alat kesehatan Mei'),
(31, '2025-06-30', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 26000000.00, 70, 10000000.00, 16000000.00, 61.54, 6, 2025, 'Penjualan obat bulan Juni'),
(32, '2025-06-30', 'Konsultasi Dokter', 'Konsultasi Umum', 8000000.00, 24, 2800000.00, 5200000.00, 65.00, 6, 2025, 'Konsultasi dokter Juni'),
(33, '2025-06-30', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 6000000.00, 30, 2200000.00, 3800000.00, 63.33, 6, 2025, 'Pemeriksaan cepat Juni'),
(34, '2025-06-30', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 4500000.00, 18, 1400000.00, 3100000.00, 68.89, 6, 2025, 'Vaksinasi Juni'),
(35, '2025-06-30', 'Kesehatan Korporat', 'Medical Checkup Karyawan', 5500000.00, 1, 1600000.00, 3900000.00, 70.91, 6, 2025, 'MCU korporat Juni'),
(36, '2025-06-30', 'Alat Kesehatan & Vitamin', 'Alat Medis Kecil, Vitamin', 4000000.00, 16, 1200000.00, 2800000.00, 70.00, 6, 2025, 'Alat kesehatan Juni'),
(37, '2025-07-08', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 8000000.00, 22, 3200000.00, 4800000.00, 60.00, 7, 2025, 'Penjualan obat minggu pertama Juli'),
(38, '2025-07-08', 'Konsultasi Dokter', 'Konsultasi Umum', 2500000.00, 8, 900000.00, 1600000.00, 64.00, 7, 2025, 'Konsultasi dokter minggu pertama Juli'),
(39, '2025-07-08', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 1800000.00, 9, 650000.00, 1150000.00, 63.89, 7, 2025, 'Pemeriksaan cepat minggu pertama Juli'),
(40, '2025-07-08', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 1200000.00, 5, 400000.00, 800000.00, 66.67, 7, 2025, 'Vaksinasi minggu pertama Juli');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuntungan_layanan_summary`
--

CREATE TABLE `keuntungan_layanan_summary` (
  `id` int(11) NOT NULL,
  `layanan` varchar(100) NOT NULL,
  `sub_layanan` varchar(255) DEFAULT NULL,
  `total_keuntungan_tahun` decimal(15,2) DEFAULT 0.00,
  `total_transaksi_tahun` int(11) DEFAULT 0,
  `rata_keuntungan_bulanan` decimal(15,2) DEFAULT 0.00,
  `persentase_kontribusi` decimal(5,2) DEFAULT 0.00,
  `trend_pertumbuhan` enum('naik','turun','stabil') DEFAULT 'stabil',
  `margin_profit_rata` decimal(5,2) DEFAULT 0.00,
  `tahun` int(4) NOT NULL,
  `icon_class` varchar(50) DEFAULT NULL,
  `color_theme` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keuntungan_layanan_summary`
--

INSERT INTO `keuntungan_layanan_summary` (`id`, `layanan`, `sub_layanan`, `total_keuntungan_tahun`, `total_transaksi_tahun`, `rata_keuntungan_bulanan`, `persentase_kontribusi`, `trend_pertumbuhan`, `margin_profit_rata`, `tahun`, `icon_class`, `color_theme`) VALUES
(1, 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 180000000.00, 500, 15000000.00, 50.00, 'naik', 58.50, 2025, 'fas fa-pills', '#5A9BFF'),
(2, 'Konsultasi Dokter', 'Konsultasi Umum', 60000000.00, 150, 5000000.00, 16.67, 'naik', 65.20, 2025, 'fas fa-user-md', '#E35B5B'),
(3, 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 40000000.00, 200, 3333333.33, 11.11, 'stabil', 63.80, 2025, 'fas fa-heartbeat', '#5ACF85'),
(4, 'Kesehatan Korporat', 'Medical Checkup Karyawan', 35000000.00, 5, 2916666.67, 9.72, 'naik', 68.90, 2025, 'fas fa-building', '#8A5BFF'),
(5, 'Vaksinasi', 'Vaksin Flu, Hepatitis', 25000000.00, 100, 2083333.33, 6.94, 'naik', 66.40, 2025, 'fas fa-syringe', '#FFD350'),
(6, 'Alat Kesehatan & Vitamin', 'Alat Medis Kecil, Vitamin', 20000000.00, 80, 1666666.67, 5.56, 'naik', 66.80, 2025, 'fas fa-first-aid', '#FF9240');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuntungan_bulanan_analytics`
--

CREATE TABLE `keuntungan_bulanan_analytics` (
  `id` int(11) NOT NULL,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `nama_bulan` varchar(20) NOT NULL,
  `total_keuntungan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_biaya_operasional` decimal(15,2) DEFAULT 0.00,
  `keuntungan_bersih` decimal(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_transaksi` int(11) DEFAULT 0,
  `rata_keuntungan_per_transaksi` decimal(10,2) DEFAULT 0.00,
  `pertumbuhan_vs_bulan_lalu` decimal(5,2) DEFAULT 0.00,
  `target_bulanan` decimal(15,2) DEFAULT 25000000.00,
  `pencapaian_target_persen` decimal(5,2) DEFAULT 0.00,
  `ranking_bulan` int(2) DEFAULT 0,
  `insight_otomatis` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keuntungan_bulanan_analytics`
--

INSERT INTO `keuntungan_bulanan_analytics` (`id`, `tahun`, `bulan`, `nama_bulan`, `total_keuntungan`, `total_biaya_operasional`, `keuntungan_bersih`, `jumlah_transaksi`, `rata_keuntungan_per_transaksi`, `pertumbuhan_vs_bulan_lalu`, `target_bulanan`, `pencapaian_target_persen`, `ranking_bulan`, `insight_otomatis`) VALUES
(1, 2025, 1, 'Januari', 40000000.00, 15500000.00, 24500000.00, 104, 384615.38, 0.00, 25000000.00, 160.00, 1, 'Januari memulai tahun dengan baik. Penjualan obat mendominasi revenue.'),
(2, 2025, 2, 'Februari', 45000000.00, 16700000.00, 28300000.00, 118, 381355.93, 12.50, 25000000.00, 180.00, 2, 'Februari menunjukkan pertumbuhan 12.5%. Konsultasi dokter meningkat signifikan.'),
(3, 2025, 3, 'Maret', 50000000.00, 18000000.00, 32000000.00, 132, 378787.88, 11.11, 25000000.00, 200.00, 3, 'Maret mencapai 200% target. Semua layanan tumbuh konsisten.'),
(4, 2025, 4, 'April', 55000000.00, 19500000.00, 35500000.00, 146, 376712.33, 10.00, 25000000.00, 220.00, 4, 'April mempertahankan momentum positif. MCU korporat mulai berkontribusi besar.'),
(5, 2025, 5, 'Mei', 52000000.00, 18500000.00, 33500000.00, 138, 376811.59, -5.45, 25000000.00, 208.00, 11, 'Mei sedikit turun namun masih di atas target. Perlu evaluasi strategi.'),
(6, 2025, 6, 'Juni', 60000000.00, 21000000.00, 39000000.00, 158, 379746.84, 15.38, 25000000.00, 240.00, 5, 'Juni mencatat rekor tertinggi semester pertama. Semua indikator positif.'),
(7, 2025, 7, 'Juli', 13500000.00, 5150000.00, 8350000.00, 44, 306818.18, -77.50, 25000000.00, 54.00, 12, 'Juli baru berjalan 8 hari. Proyeksi bulanan masih on-track.'),
(8, 2024, 1, 'Januari', 35000000.00, 14000000.00, 21000000.00, 95, 368421.05, 0.00, 20000000.00, 175.00, 6, 'Baseline tahun 2024. Performa solid untuk awal tahun.'),
(9, 2024, 2, 'Februari', 40000000.00, 15500000.00, 24500000.00, 108, 370370.37, 14.29, 20000000.00, 200.00, 7, 'Februari 2024 menunjukkan akselerasi yang baik.'),
(10, 2024, 3, 'Maret', 42000000.00, 16000000.00, 26000000.00, 112, 375000.00, 5.00, 20000000.00, 210.00, 8, 'Maret 2024 stabil dengan pertumbuhan moderat.'),
(11, 2024, 12, 'Desember', 70000000.00, 24000000.00, 46000000.00, 180, 388888.89, 7.69, 20000000.00, 350.00, 9, 'Desember 2024 mencatat rekor tertinggi tahun. Momentum liburan memberikan kontribusi besar.'),
(12, 2024, 11, 'November', 65000000.00, 22500000.00, 42500000.00, 165, 393939.39, 4.84, 20000000.00, 325.00, 10, 'November 2024 persiapan menuju puncak akhir tahun.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuntungan_target_kpi`
--

CREATE TABLE `keuntungan_target_kpi` (
  `id` int(11) NOT NULL,
  `tahun` int(4) NOT NULL,
  `target_tahunan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `target_bulanan_rata` decimal(15,2) NOT NULL DEFAULT 0.00,
  `pencapaian_sampai_saat_ini` decimal(15,2) DEFAULT 0.00,
  `persentase_pencapaian` decimal(5,2) DEFAULT 0.00,
  `proyeksi_akhir_tahun` decimal(15,2) DEFAULT 0.00,
  `gap_vs_target` decimal(15,2) DEFAULT 0.00,
  `bulan_terbaik` varchar(20) DEFAULT NULL,
  `bulan_terburuk` varchar(20) DEFAULT NULL,
  `layanan_andalan` varchar(100) DEFAULT NULL,
  `rekomendasi_strategis` text DEFAULT NULL,
  `status_target` enum('on_track','behind','ahead','critical') DEFAULT 'on_track',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keuntungan_target_kpi`
--

INSERT INTO `keuntungan_target_kpi` (`id`, `tahun`, `target_tahunan`, `target_bulanan_rata`, `pencapaian_sampai_saat_ini`, `persentase_pencapaian`, `proyeksi_akhir_tahun`, `gap_vs_target`, `bulan_terbaik`, `bulan_terburuk`, `layanan_andalan`, `rekomendasi_strategis`, `status_target`) VALUES
(1, 2025, 320000000.00, 26666666.67, 315500000.00, 98.59, 380000000.00, 60000000.00, 'Juni', 'Januari', 'Penjualan Obat', 'Target tahunan kemungkinan besar tercapai. Fokus pada diversifikasi layanan untuk sustainability jangka panjang. Tingkatkan kapasitas MCU korporat dan layanan vaksinasi.', 'ahead'),
(2, 2024, 280000000.00, 23333333.33, 285000000.00, 101.79, 285000000.00, 5000000.00, 'Desember', 'Januari', 'Penjualan Obat', 'Target 2024 berhasil dilampaui. Momentum positif menjadi baseline untuk target 2025 yang lebih ambisius.', 'ahead');

-- --------------------------------------------------------

--
-- Index dan Auto Increment untuk tabel keuntungan
--

--
-- Indexes for table `keuntungan`
--
ALTER TABLE `keuntungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `sumber_keuntungan` (`sumber_keuntungan`),
  ADD KEY `bulan_tahun` (`bulan`, `tahun`),
  ADD KEY `tahun` (`tahun`);

--
-- Indexes for table `keuntungan_layanan_summary`
--
ALTER TABLE `keuntungan_layanan_summary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layanan` (`layanan`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `persentase_kontribusi` (`persentase_kontribusi`);

--
-- Indexes for table `keuntungan_bulanan_analytics`
--
ALTER TABLE `keuntungan_bulanan_analytics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun_bulan` (`tahun`, `bulan`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `bulan` (`bulan`),
  ADD KEY `ranking_bulan` (`ranking_bulan`);

--
-- Indexes for table `keuntungan_target_kpi`
--
ALTER TABLE `keuntungan_target_kpi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun` (`tahun`);

--
-- AUTO_INCREMENT untuk tabel keuntungan
--

--
-- AUTO_INCREMENT untuk tabel `keuntungan`
--
ALTER TABLE `keuntungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `keuntungan_layanan_summary`
--
ALTER TABLE `keuntungan_layanan_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `keuntungan_bulanan_analytics`
--
ALTER TABLE `keuntungan_bulanan_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `keuntungan_target_kpi`
--
ALTER TABLE `keuntungan_target_kpi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` enum('admin','pendaftaran','pemeriksaan','pembayaran') NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `jabatan`, `nama_lengkap`, `email`, `telepon`, `alamat`, `status`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Administrator Klinik', 'admin@klinik.com', '081234567890', 'Jl. Sehat No. 1', 'aktif'),
(2, 'pendaftaran1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pendaftaran', 'Siti Pendaftaran', 'pendaftaran@klinik.com', '081234567891', 'Jl. Sehat No. 2', 'aktif'),
(3, 'pemeriksaan1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pemeriksaan', 'Dr. Pemeriksaan', 'pemeriksaan@klinik.com', '081234567892', 'Jl. Sehat No. 3', 'aktif'),
(4, 'pembayaran1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pembayaran', 'Kasir Klinik', 'pembayaran@klinik.com', '081234567893', 'Jl. Sehat No. 4', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `no_rm` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `status_pernikahan` enum('belum_menikah','menikah','janda','duda') DEFAULT 'belum_menikah',
  `golongan_darah` enum('A','B','AB','O') DEFAULT NULL,
  `alergi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `no_rm`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `telepon`, `pekerjaan`, `status_pernikahan`, `golongan_darah`, `alergi`) VALUES
(1, 'RM001', 'Ahmad Santoso', '1985-03-15', 'L', 'Jl. Merdeka No. 10', '081234567801', 'Pegawai Swasta', 'menikah', 'A', NULL),
(2, 'RM002', 'Siti Nurhaliza', '1992-07-20', 'P', 'Jl. Sudirman No. 25', '081234567802', 'Guru', 'menikah', 'B', 'Seafood'),
(3, 'RM003', 'Budi Prakoso', '1978-11-05', 'L', 'Jl. Gatot Subroto No. 5', '081234567803', 'Wiraswasta', 'menikah', 'O', NULL),
(4, 'RM004', 'Andi Wijaya', '1998-08-22', 'L', 'Jl. Pahlawan No. 15', '081234567804', 'Mahasiswa', 'belum_menikah', 'B', NULL),
(5, 'RM005', 'Sari Dewi', '1991-12-03', 'P', 'Jl. Diponegoro No. 8', '081234567805', 'Dokter', 'menikah', 'AB', NULL),
(6, 'RM006', 'Budi Hartono', '1982-06-18', 'L', 'Jl. Ahmad Yani No. 12', '081234567806', 'Pengusaha', 'menikah', 'A', 'Obat keras'),
(7, 'RM007', 'Lina Marlina', '1995-04-10', 'P', 'Jl. Kartini No. 7', '081234567807', 'Perawat', 'belum_menikah', 'O', NULL),
(8, 'RM008', 'Rizky Hidayat', '1988-09-25', 'L', 'Jl. Veteran No. 20', '081234567808', 'Pilot', 'menikah', 'B', NULL),
(9, 'RM009', 'Intan Permata', '1993-11-14', 'P', 'Jl. Gajah Mada No. 3', '081234567809', 'Apoteker', 'menikah', 'A', 'Debu'),
(10, 'RM010', 'Dedi Kurniawan', '1980-01-30', 'L', 'Jl. Imam Bonjol No. 16', '081234567810', 'Insinyur', 'menikah', 'AB', NULL),
(11, 'RM011', 'Maya Sari', '1997-05-08', 'P', 'Jl. Cut Nyak Dien No. 11', '081234567811', 'Desainer', 'belum_menikah', 'O', NULL),
(12, 'RM012', 'Fajar Ramadhan', '1986-03-12', 'L', 'Jl. Hasanuddin No. 9', '081234567812', 'Akuntan', 'menikah', 'A', NULL),
(13, 'RM013', 'Dewi Kartika', '1994-07-21', 'P', 'Jl. Thamrin No. 14', '081234567813', 'Marketing', 'belum_menikah', 'B', 'Makanan laut'),
(14, 'RM014', 'Eko Prasetyo', '1983-10-05', 'L', 'Jl. Pancasila No. 6', '081234567814', 'Guru', 'menikah', 'O', NULL),
(15, 'RM015', 'Ratna Sari', '1990-12-28', 'P', 'Jl. Kemerdekaan No. 18', '081234567815', 'Psikolog', 'menikah', 'AB', NULL),
(16, 'RM016', 'Agus Setiawan', '1979-02-14', 'L', 'Jl. Proklamasi No. 4', '081234567816', 'Polisi', 'menikah', 'A', NULL),
(17, 'RM017', 'Nina Safitri', '1996-08-03', 'P', 'Jl. Budi Utomo No. 13', '081234567817', 'Fotografer', 'belum_menikah', 'B', NULL),
(18, 'RM018', 'Hendra Wijaya', '1987-11-19', 'L', 'Jl. Dr. Wahidin No. 21', '081234567818', 'Arsitek', 'menikah', 'O', 'Udang'),
(19, 'RM019', 'Sinta Dewi', '1992-04-07', 'P', 'Jl. RA Kartini No. 2', '081234567819', 'Bidan', 'menikah', 'A', NULL),
(20, 'RM020', 'Bambang Sutrisno', '1981-09-16', 'L', 'Jl. Pemuda No. 17', '081234567820', 'Supir', 'menikah', 'B', NULL),
(21, 'RM021', 'Laras Putri', '1999-01-11', 'P', 'Jl. Teuku Umar No. 8', '081234567821', 'Mahasiswa', 'belum_menikah', 'O', NULL),
(22, 'RM022', 'Yoga Pratama', '1984-06-24', 'L', 'Jl. Hang Tuah No. 12', '081234567822', 'Chef', 'belum_menikah', 'AB', 'Kacang'),
(23, 'RM023', 'Putri Ayu', '1993-03-18', 'P', 'Jl. Diponegoro No. 19', '081234567823', 'Lawyer', 'menikah', 'A', NULL),
(24, 'RM024', 'Rudi Hermawan', '1989-07-29', 'L', 'Jl. Sudirman No. 5', '081234567824', 'Teknisi', 'menikah', 'B', NULL),
(25, 'RM025', 'Dian Sastika', '1995-12-06', 'P', 'Jl. Gatot Subroto No. 22', '081234567825', 'Journalist', 'belum_menikah', 'O', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `kode_dokter` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `spesialisasi` varchar(100) NOT NULL,
  `str_dokter` varchar(50) DEFAULT NULL,
  `sip_dokter` varchar(50) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jadwal_praktek` text DEFAULT NULL,
  `tarif` decimal(10,2) DEFAULT 0.00,
  `status` enum('aktif','nonaktif','cuti') DEFAULT 'aktif',
  `total_jam_bulan` int(11) DEFAULT 0,
  `target_jam_bulan` int(11) DEFAULT 500,
  `kehadiran_persen` decimal(5,2) DEFAULT 0.00,
  `pertumbuhan_pasien_persen` decimal(5,2) DEFAULT 0.00,
  `total_pasien_bulan` int(11) DEFAULT 0,
  `rating` decimal(3,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `kode_dokter`, `nama`, `spesialisasi`, `str_dokter`, `sip_dokter`, `telepon`, `email`, `alamat`, `jadwal_praktek`, `tarif`, `status`, `total_jam_bulan`, `target_jam_bulan`, `kehadiran_persen`, `pertumbuhan_pasien_persen`, `total_pasien_bulan`, `rating`) VALUES
(1, 'D001', 'Dr. Andi', 'Umum', 'STR123456', 'SIP654321', '081234567890', 'dr.andi@klinik.com', 'Jl. Melati No.10', 'Senin-Jumat 08:00-12:00', 75000.00, 'aktif', 450, 500, 95.00, 12.00, 120, 5.00),
(2, 'D002', 'Dr. Budi', 'Gigi', 'STR223344', 'SIP445566', '081298765432', 'dr.budi@klinik.com', 'Jl. Kenanga No.5', 'Selasa 13:00-17:00, Jumat 08:00-12:00', 80000.00, 'nonaktif', 380, 500, 85.00, 5.00, 150, 4.00),
(3, 'D003', 'Dr. Citra', 'Anak', 'STR334455', 'SIP556677', '081356789012', 'dr.citra@klinik.com', 'Jl. Mawar No.20', 'Rabu 08:00-12:00', 90000.00, 'aktif', 520, 500, 98.00, 18.00, 140, 4.80),
(4, 'DOK004', 'Dr. Maya Sari, Sp.M', 'Mata', 'STR445566', 'SIP778899', '081234567904', 'dr.maya@klinik.com', 'Jl. Dokter No. 4', 'Senin-Jumat 10:00-18:00', 180000.00, 'aktif', 480, 500, 92.00, 15.00, 110, 4.60),
(5, 'DOK005', 'Dr. Hendra Kusuma, Sp.JP', 'Jantung', 'STR556677', 'SIP889900', '081234567905', 'dr.hendra@klinik.com', 'Jl. Dokter No. 5', 'Senin-Kamis 08:00-16:00', 250000.00, 'aktif', 460, 500, 96.00, 10.00, 95, 4.90),
(6, 'DOK006', 'Dr. Lisa Putri, Sp.KG', 'Gigi Spesialis', 'STR667788', 'SIP990011', '081234567906', 'dr.lisa@klinik.com', 'Jl. Dokter No. 6', 'Senin-Rabu 09:00-15:00', 160000.00, 'aktif', 390, 500, 88.00, 8.00, 125, 4.30),
(7, 'DOK007', 'Dr. Rudi Santoso, Sp.PD', 'Penyakit Dalam', 'STR778899', 'SIP001122', '081234567907', 'dr.rudi@klinik.com', 'Jl. Dokter No. 7', 'Kamis-Sabtu 08:00-16:00', 150000.00, 'aktif', 470, 500, 94.00, 14.00, 130, 4.70),
(8, 'DOK008', 'Dr. Nina Sari, Sp.A', 'Anak Spesialis', 'STR889900', 'SIP112233', '081234567908', 'dr.nina@klinik.com', 'Jl. Dokter No. 8', 'Senin-Jumat 13:00-17:00', 185000.00, 'aktif', 440, 500, 91.00, 13.00, 105, 4.50),
(9, 'DOK009', 'Dr. Eko Wijaya', 'Umum', 'STR990011', 'SIP223344', '081234567909', 'dr.eko@klinik.com', 'Jl. Dokter No. 9', 'Sabtu-Minggu 08:00-14:00', 75000.00, 'cuti', 350, 500, 75.00, 2.00, 80, 4.10),
(10, 'DOK010', 'Dr. Sinta Dewi, Sp.OG', 'Kandungan', 'STR001122', 'SIP334455', '081234567910', 'dr.sinta@klinik.com', 'Jl. Dokter No. 10', 'Selasa-Kamis 09:00-15:00', 200000.00, 'aktif', 490, 500, 97.00, 16.00, 115, 4.85),
(11, 'DOK011', 'Dr. Hari Kusuma', 'Umum', 'STR112233', 'SIP445566', '081234567911', 'dr.hari@klinik.com', 'Jl. Dokter No. 11', 'Senin-Rabu 16:00-20:00', 75000.00, 'aktif', 420, 500, 89.00, 7.00, 100, 4.20),
(12, 'DOK012', 'Dr. Fitri Handayani, Sp.JP', 'Jantung', 'STR223344', 'SIP556677', '081234567912', 'dr.fitri@klinik.com', 'Jl. Dokter No. 12', 'Jumat-Minggu 08:00-12:00', 250000.00, 'aktif', 510, 500, 99.00, 20.00, 135, 4.95);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `kode_obat` varchar(20) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `bentuk_obat` enum('Tablet','Kapsul','Syrup','Salep','Injeksi','Drops','Cream','Gel','Lainnya') DEFAULT 'Tablet',
  `satuan` varchar(20) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `stok_minimum` int(11) NOT NULL DEFAULT 10,
  `tanggal_expired` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `terjual_bulan_ini` int(11) DEFAULT 0,
  `persentase_trend` decimal(5,2) DEFAULT 0.00,
  `trend_direction` enum('up','down','stable') DEFAULT 'stable',
  `last_restock_date` date DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `kode_obat`, `nama_obat`, `kategori`, `bentuk_obat`, `satuan`, `harga_beli`, `harga_jual`, `stok`, `stok_minimum`, `tanggal_expired`, `supplier`, `deskripsi`, `terjual_bulan_ini`, `persentase_trend`, `trend_direction`, `last_restock_date`, `sku`) VALUES
(1, 'OBT-PAR-500', 'Paracetamol 500mg', 'Pain Relief', 'Tablet', 'Box', 12000.00, 15000.00, 8, 20, '2025-08-15', 'MediPharm Inc.', 'Obat penurun panas dan pereda nyeri', 120, 15.00, 'up', '2025-01-10', 'MED-PAR-500'),
(2, 'OBT-AMX-500', 'Amoxicillin 500mg', 'Antibiotics', 'Kapsul', 'Box', 20000.00, 25000.00, 28, 15, '2025-06-30', 'HealthCare Distributors', 'Antibiotik untuk infeksi bakteri', 95, 8.00, 'up', '2025-02-01', 'MED-AMX-500'),
(3, 'OBT-AMB-SYR', 'Ambroxol Syrup', 'Respiratory', 'Syrup', 'Botol', 18000.00, 22000.00, 3, 20, '2025-07-10', 'PharmaCorp Ltd.', 'Obat batuk berdahak', 65, 12.00, 'up', '2024-10-15', 'MED-AMB-SYR'),
(4, 'OBT-VTC-1000', 'Vitamin C 1000mg', 'Vitamins', 'Tablet', 'Box', 35000.00, 45000.00, 7, 30, '2025-12-31', 'VitaHealth Corp.', 'Suplemen vitamin C dosis tinggi', 38, 6.00, 'up', '2024-11-20', 'MED-VTC-1000'),
(5, 'OBT-MIC-SAL', 'Salep Miconazole', 'Dermatology', 'Salep', 'Tube', 28000.00, 35000.00, 5, 15, '2025-09-20', 'DermaCare Solutions', 'Obat jamur kulit', 42, -5.00, 'down', '2024-12-05', 'MED-MIC-SAL'),
(6, 'OBT-IBU-400', 'Ibuprofen 400mg', 'Pain Relief', 'Tablet', 'Box', 14000.00, 18000.00, 12, 25, '2025-02-28', 'MediPharm Inc.', 'Anti inflamasi dan pereda nyeri', 78, 2.00, 'stable', '2025-01-15', 'MED-IBU-400'),
(7, 'OBT-MET-500', 'Metformin 500mg', 'Diabetes', 'Tablet', 'Box', 22000.00, 28000.00, 6, 30, '2025-10-30', 'DiabetesCare Inc.', 'Obat diabetes tipe 2', 25, -3.00, 'down', '2024-09-10', 'MED-MET-500'),
(8, 'OBT-CET-10', 'Cetirizine 10mg', 'Allergy', 'Tablet', 'Box', 9000.00, 12000.00, 9, 25, '2025-03-15', 'AllergyFree Ltd.', 'Antihistamin untuk alergi', 32, 4.00, 'up', '2025-01-05', 'MED-CET-10'),
(9, 'OBT-OME-20', 'Omeprazole 20mg', 'Gastric', 'Kapsul', 'Box', 22000.00, 28000.00, 41, 20, '2025-11-25', 'GastroMed Inc.', 'Obat maag dan GERD', 35, 1.00, 'stable', '2025-02-20', 'MED-OME-20'),
(10, 'OBT-CAP-25', 'Captopril 25mg', 'Hipertensi', 'Tablet', 'Box', 15000.00, 20000.00, 18, 25, '2025-08-25', 'CardioMed Solutions', 'Obat tekanan darah tinggi', 28, 7.00, 'up', '2025-01-30', 'MED-CAP-25'),
(11, 'OBT-DEX-5', 'Dexamethasone 5mg', 'Anti-inflammatory', 'Tablet', 'Box', 18000.00, 24000.00, 15, 20, '2025-09-15', 'InflamaCare Ltd.', 'Kortikosteroid anti inflamasi', 22, 3.00, 'stable', '2025-02-10', 'MED-DEX-5'),
(12, 'OBT-SAL-100', 'Salbutamol 100mcg', 'Respiratory', 'Inhaler', 'Unit', 45000.00, 60000.00, 8, 15, '2025-07-20', 'RespiraCare Inc.', 'Bronkodilator untuk asma', 18, 9.00, 'up', '2024-12-15', 'MED-SAL-100'),
(13, 'OBT-LOR-10', 'Loratadine 10mg', 'Allergy', 'Tablet', 'Box', 16000.00, 22000.00, 25, 20, '2025-11-10', 'AllergyFree Ltd.', 'Antihistamin non-sedatif', 30, 5.00, 'up', '2025-02-25', 'MED-LOR-10'),
(14, 'OBT-ATO-20', 'Atorvastatin 20mg', 'Cholesterol', 'Tablet', 'Box', 35000.00, 45000.00, 12, 20, '2025-10-05', 'CardioMed Solutions', 'Obat kolesterol tinggi', 20, 2.00, 'stable', '2025-01-20', 'MED-ATO-20'),
(15, 'OBT-PRE-5', 'Prednisolone 5mg', 'Anti-inflammatory', 'Tablet', 'Box', 20000.00, 26000.00, 22, 25, '2025-09-30', 'InflamaCare Ltd.', 'Kortikosteroid untuk peradangan', 15, -2.00, 'down', '2025-02-05', 'MED-PRE-5'),
(16, 'OBT-AMP-250', 'Ampicillin 250mg', 'Antibiotics', 'Kapsul', 'Box', 15000.00, 20000.00, 32, 25, '2025-12-15', 'HealthCare Distributors', 'Antibiotik penisilin', 28, 6.00, 'up', '2025-01-25', 'MED-AMP-250'),
(17, 'OBT-DOM-10', 'Domperidone 10mg', 'Gastric', 'Tablet', 'Box', 12000.00, 16000.00, 24, 20, '2025-08-20', 'GastroMed Inc.', 'Obat mual dan muntah', 22, 4.00, 'up', '2025-02-15', 'MED-DOM-10'),
(18, 'OBT-FLU-500', 'Fluconazole 500mg', 'Dermatology', 'Kapsul', 'Box', 45000.00, 60000.00, 18, 15, '2025-07-30', 'DermaCare Solutions', 'Antijamur sistemik', 12, 8.00, 'up', '2025-01-18', 'MED-FLU-500'),
(19, 'OBT-GLI-5', 'Glimepiride 5mg', 'Diabetes', 'Tablet', 'Box', 25000.00, 32000.00, 14, 20, '2025-09-10', 'DiabetesCare Inc.', 'Obat diabetes sulfonilurea', 18, 3.00, 'stable', '2025-02-08', 'MED-GLI-5'),
(20, 'OBT-ASP-100', 'Asam Mefenamat 100mg', 'Pain Relief', 'Tablet', 'Strip', 8000.00, 12000.00, 45, 30, '2025-06-25', 'MediPharm Inc.', 'Obat anti inflamasi dan pereda nyeri', 35, 7.00, 'up', '2025-02-12', 'MED-ASP-100');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_obat`
--

CREATE TABLE `kategori_obat` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT 'fas fa-pills',
  `color` varchar(20) DEFAULT '#5459AC',
  `jumlah_obat` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori_obat`
--

INSERT INTO `kategori_obat` (`id`, `nama_kategori`, `deskripsi`, `icon`, `color`, `jumlah_obat`) VALUES
(1, 'Pain Relief', 'Obat pereda nyeri dan anti-inflamasi', 'fas fa-heartbeat', '#e74c3c', 3),
(2, 'Antibiotics', 'Antibiotik untuk infeksi bakteri', 'fas fa-flask', '#17a2b8', 1),
(3, 'Respiratory', 'Obat untuk gangguan pernapasan', 'fas fa-lungs', '#f39c12', 2),
(4, 'Vitamins', 'Suplemen vitamin dan mineral', 'fas fa-shield-alt', '#27ae60', 1),
(5, 'Dermatology', 'Obat untuk kulit dan kelamin', 'fas fa-hand-holding-medical', '#9b59b6', 1),
(6, 'Allergy', 'Obat untuk alergi dan antihistamin', 'fas fa-leaf', '#f1c40f', 2),
(7, 'Gastric', 'Obat untuk gangguan pencernaan', 'fas fa-stomach', '#16a085', 1),
(8, 'Diabetes', 'Obat untuk diabetes dan gula darah', 'fas fa-syringe', '#34495e', 1),
(9, 'Hipertensi', 'Obat untuk tekanan darah tinggi', 'fas fa-heart', '#e91e63', 1),
(10, 'Anti-inflammatory', 'Obat anti peradangan', 'fas fa-fire-extinguisher', '#ff5722', 2),
(11, 'Cholesterol', 'Obat untuk kolesterol tinggi', 'fas fa-chart-line', '#795548', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat_sales_tracking`
--

CREATE TABLE `obat_sales_tracking` (
  `id` int(11) NOT NULL,
  `obat_id` int(11) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `jumlah_terjual` int(11) NOT NULL,
  `total_revenue` decimal(12,2) NOT NULL,
  `profit_margin` decimal(5,2) DEFAULT 0.00,
  `periode` enum('harian','mingguan','bulanan') DEFAULT 'harian',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat_sales_tracking`
--

INSERT INTO `obat_sales_tracking` (`id`, `obat_id`, `tanggal_penjualan`, `jumlah_terjual`, `total_revenue`, `profit_margin`, `periode`) VALUES
(1, 1, '2025-01-15', 5, 75000.00, 20.00, 'harian'),
(2, 1, '2025-01-14', 8, 120000.00, 20.00, 'harian'),
(3, 1, '2025-01-13', 3, 45000.00, 20.00, 'harian'),
(4, 2, '2025-01-15', 4, 100000.00, 20.00, 'harian'),
(5, 2, '2025-01-14', 6, 150000.00, 20.00, 'harian'),
(6, 3, '2025-01-15', 2, 44000.00, 18.18, 'harian'),
(7, 4, '2025-01-15', 3, 135000.00, 22.22, 'harian'),
(8, 5, '2025-01-14', 2, 70000.00, 20.00, 'harian'),
(9, 6, '2025-01-13', 4, 72000.00, 22.22, 'harian'),
(10, 7, '2025-01-12', 1, 28000.00, 21.43, 'harian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat_inventory_alerts`
--

CREATE TABLE `obat_inventory_alerts` (
  `id` int(11) NOT NULL,
  `obat_id` int(11) NOT NULL,
  `alert_type` enum('low_stock','expiring','critical','out_of_stock') NOT NULL,
  `alert_message` text NOT NULL,
  `priority` enum('low','medium','high','critical') DEFAULT 'medium',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat_inventory_alerts`
--

INSERT INTO `obat_inventory_alerts` (`id`, `obat_id`, `alert_type`, `alert_message`, `priority`, `is_read`) VALUES
(1, 1, 'low_stock', 'Paracetamol 500mg stok tinggal 8 box, di bawah batas minimum 20 box', 'high', 0),
(2, 3, 'low_stock', 'Ambroxol Syrup stok tinggal 3 botol, di bawah batas minimum 20 botol', 'critical', 0),
(3, 4, 'low_stock', 'Vitamin C 1000mg stok tinggal 7 box, di bawah batas minimum 30 box', 'high', 0),
(4, 5, 'low_stock', 'Salep Miconazole stok tinggal 5 tube, di bawah batas minimum 15 tube', 'high', 0),
(5, 7, 'low_stock', 'Metformin 500mg stok tinggal 6 box, di bawah batas minimum 30 box', 'high', 0),
(6, 6, 'expiring', 'Ibuprofen 400mg akan kadaluarsa pada 2025-02-28', 'medium', 0),
(7, 8, 'expiring', 'Cetirizine 10mg akan kadaluarsa pada 2025-03-15', 'medium', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat_restock_history`
--

CREATE TABLE `obat_restock_history` (
  `id` int(11) NOT NULL,
  `obat_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `tanggal_restock` date NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `harga_beli_per_unit` decimal(10,2) NOT NULL,
  `total_cost` decimal(12,2) NOT NULL,
  `batch_number` varchar(50) DEFAULT NULL,
  `tanggal_expired_batch` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat_restock_history`
--

INSERT INTO `obat_restock_history` (`id`, `obat_id`, `supplier_id`, `tanggal_restock`, `jumlah_masuk`, `harga_beli_per_unit`, `total_cost`, `batch_number`, `tanggal_expired_batch`, `keterangan`, `created_by`) VALUES
(1, 1, 1, '2025-01-10', 50, 12000.00, 600000.00, 'PAR-500-2025-001', '2025-08-15', 'Restock rutin bulanan', 1),
(2, 2, 2, '2025-02-01', 40, 20000.00, 800000.00, 'AMX-500-2025-001', '2025-06-30', 'Restock karena permintaan tinggi', 1),
(3, 3, 3, '2024-10-15', 30, 18000.00, 540000.00, 'AMB-SYR-2024-003', '2025-07-10', 'Restock musim flu', 1),
(4, 4, 4, '2024-11-20', 80, 35000.00, 2800000.00, 'VTC-1000-2024-002', '2025-12-31', 'Restock vitamin untuk musim hujan', 1),
(5, 5, 5, '2024-12-05', 25, 28000.00, 700000.00, 'MIC-SAL-2024-004', '2025-09-20', 'Restock obat jamur', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_ulasan_rating`
--

CREATE TABLE `pasien_ulasan_rating` (
  `id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `kunjungan_id` int(11) DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT 0.0,
  `ulasan` text DEFAULT NULL,
  `kategori_ulasan` enum('pelayanan','dokter','fasilitas','administrasi','keseluruhan') DEFAULT 'keseluruhan',
  `is_anonymous` tinyint(1) DEFAULT 0,
  `status_kunjungan` enum('Baru','Kembali') DEFAULT 'Baru',
  `tanggal_kunjungan` date NOT NULL,
  `mood_rating` enum('sangat_puas','puas','biasa','tidak_puas','sangat_tidak_puas') DEFAULT 'biasa',
  `recommend_to_others` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pasien_ulasan_rating`
--

INSERT INTO `pasien_ulasan_rating` (`id`, `pasien_id`, `kunjungan_id`, `rating`, `ulasan`, `kategori_ulasan`, `is_anonymous`, `status_kunjungan`, `tanggal_kunjungan`, `mood_rating`, `recommend_to_others`) VALUES
(1, 4, NULL, 4.8, 'Pelayanan cepat dan ramah.', 'pelayanan', 0, 'Baru', '2025-06-10', 'sangat_puas', 1),
(2, 5, NULL, 4.3, 'Dokter menjelaskan dengan jelas.', 'dokter', 0, 'Kembali', '2025-06-12', 'puas', 1),
(3, 6, NULL, 3.5, 'Antri cukup lama.', 'administrasi', 0, 'Baru', '2025-06-15', 'biasa', 1),
(4, 7, NULL, 2.2, 'Kurang ramah saat pendaftaran.', 'administrasi', 0, 'Kembali', '2025-06-09', 'tidak_puas', 0),
(5, 8, NULL, 5.0, 'Dokter sangat profesional dan pelayanan cepat.', 'keseluruhan', 0, 'Baru', '2025-06-08', 'sangat_puas', 1),
(6, 9, NULL, 1.8, 'Menunggu terlalu lama dan kurang penjelasan.', 'pelayanan', 0, 'Kembali', '2025-06-05', 'sangat_tidak_puas', 0),
(7, 1, NULL, 4.5, 'Fasilitas lengkap dan bersih.', 'fasilitas', 0, 'Kembali', '2025-06-20', 'puas', 1),
(8, 2, NULL, 4.7, 'Dokter sabar dan detail menjelaskan kondisi.', 'dokter', 0, 'Kembali', '2025-06-18', 'sangat_puas', 1),
(9, 10, NULL, 3.8, 'Parkir agak susah tapi pelayanan OK.', 'fasilitas', 0, 'Baru', '2025-06-22', 'puas', 1),
(10, 11, NULL, 4.2, 'Perawat sangat membantu dan ramah.', 'pelayanan', 0, 'Baru', '2025-06-25', 'puas', 1),
(11, 12, NULL, 3.0, 'Biasa saja, tidak ada yang istimewa.', 'keseluruhan', 1, 'Kembali', '2025-06-28', 'biasa', 1),
(12, 13, NULL, 4.9, 'Sangat puas dengan hasil pemeriksaan.', 'dokter', 0, 'Baru', '2025-07-01', 'sangat_puas', 1),
(13, 14, NULL, 2.5, 'Sistem antrian tidak jelas.', 'administrasi', 0, 'Kembali', '2025-07-03', 'tidak_puas', 0),
(14, 15, NULL, 4.6, 'Proses pendaftaran cepat dan mudah.', 'administrasi', 0, 'Baru', '2025-07-05', 'puas', 1),
(15, 16, NULL, 3.9, 'Dokter kompeten tapi ruang tunggu kurang nyaman.', 'fasilitas', 0, 'Kembali', '2025-07-07', 'puas', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_demografi_stats`
--

CREATE TABLE `pasien_demografi_stats` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `kelompok_usia` enum('0-12','13-24','25-45','46-65','65+') NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `jumlah_pasien` int(11) NOT NULL DEFAULT 0,
  `jumlah_kunjungan` int(11) NOT NULL DEFAULT 0,
  `rata_rating` decimal(3,2) DEFAULT 0.00,
  `persentase_pasien_baru` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pasien_demografi_stats`
--

INSERT INTO `pasien_demografi_stats` (`id`, `periode_bulan`, `kelompok_usia`, `jenis_kelamin`, `jumlah_pasien`, `jumlah_kunjungan`, `rata_rating`, `persentase_pasien_baru`) VALUES
(1, '2025-07', '0-12', 'L', 2, 3, 4.20, 66.67),
(2, '2025-07', '0-12', 'P', 2, 2, 4.50, 50.00),
(3, '2025-07', '13-24', 'L', 6, 8, 4.30, 75.00),
(4, '2025-07', '13-24', 'P', 6, 9, 4.10, 66.67),
(5, '2025-07', '25-45', 'L', 8, 12, 4.00, 62.50),
(6, '2025-07', '25-45', 'P', 7, 11, 4.25, 57.14),
(7, '2025-07', '46-65', 'L', 1, 2, 3.80, 100.00),
(8, '2025-07', '46-65', 'P', 1, 1, 4.60, 0.00),
(9, '2025-07', '65+', 'L', 3, 4, 3.90, 33.33),
(10, '2025-07', '65+', 'P', 3, 5, 4.40, 66.67);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_kunjungan_history`
--

CREATE TABLE `pasien_kunjungan_history` (
  `id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jenis_kunjungan` enum('Baru','Kembali','Kontrol','Emergency') DEFAULT 'Baru',
  `keluhan_utama` text DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `tindakan` text DEFAULT NULL,
  `dokter_id` int(11) DEFAULT NULL,
  `biaya_total` decimal(10,2) DEFAULT 0.00,
  `status_pembayaran` enum('lunas','cicil','belum_bayar') DEFAULT 'belum_bayar',
  `rating_kunjungan` decimal(2,1) DEFAULT NULL,
  `ulasan_kunjungan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pasien_kunjungan_history`
--

INSERT INTO `pasien_kunjungan_history` (`id`, `pasien_id`, `tanggal_kunjungan`, `jenis_kunjungan`, `keluhan_utama`, `diagnosa`, `tindakan`, `dokter_id`, `biaya_total`, `status_pembayaran`, `rating_kunjungan`, `ulasan_kunjungan`) VALUES
(1, 1, '2025-06-01', 'Baru', 'Demam dan batuk', 'ISPA', 'Pemeriksaan fisik, resep obat', 1, 150000.00, 'lunas', 4.5, 'Dokter ramah dan menjelaskan dengan baik'),
(2, 2, '2025-06-03', 'Baru', 'Sakit kepala', 'Migrain', 'Konsultasi dan resep obat', 2, 200000.00, 'lunas', 4.8, 'Pelayanan sangat memuaskan'),
(3, 3, '2025-06-05', 'Kembali', 'Kontrol tekanan darah', 'Hipertensi', 'Cek TD, konsultasi diet', 3, 100000.00, 'lunas', 4.2, 'Dokter sangat perhatian'),
(4, 4, '2025-06-10', 'Baru', 'Pemeriksaan rutin', 'Sehat', 'Medical check up', 1, 350000.00, 'lunas', 4.8, 'Pelayanan cepat dan ramah'),
(5, 5, '2025-06-12', 'Kembali', 'Konsultasi hasil lab', 'Normal', 'Konsultasi hasil', 2, 75000.00, 'lunas', 4.3, 'Dokter menjelaskan dengan jelas'),
(6, 6, '2025-06-15', 'Baru', 'Sakit perut', 'Gastritis', 'Pemeriksaan dan resep', 4, 180000.00, 'lunas', 3.5, 'Antri cukup lama'),
(7, 7, '2025-06-09', 'Kembali', 'Kontrol luka', 'Luka sembuh', 'Ganti perban', 5, 50000.00, 'lunas', 2.2, 'Kurang ramah saat pendaftaran'),
(8, 8, '2025-06-08', 'Baru', 'Cek jantung', 'Jantung sehat', 'EKG dan konsultasi', 3, 250000.00, 'lunas', 5.0, 'Dokter sangat profesional dan pelayanan cepat'),
(9, 9, '2025-06-05', 'Kembali', 'Konsultasi resep', 'Diabetes kontrol', 'Adjust dosis obat', 6, 120000.00, 'lunas', 1.8, 'Menunggu terlalu lama dan kurang penjelasan'),
(10, 10, '2025-06-20', 'Kembali', 'Kontrol gula darah', 'Diabetes stabil', 'Cek gula, konsultasi', 6, 90000.00, 'lunas', 4.5, 'Fasilitas lengkap dan bersih'),
(11, 11, '2025-06-25', 'Baru', 'Konsultasi gizi', 'Underweight', 'Diet konsultasi', 7, 150000.00, 'lunas', 4.2, 'Perawat sangat membantu dan ramah'),
(12, 12, '2025-06-28', 'Kembali', 'Kontrol kolesterol', 'Kolesterol tinggi', 'Lab dan konsultasi', 8, 200000.00, 'lunas', 3.0, 'Biasa saja, tidak ada yang istimewa'),
(13, 13, '2025-07-01', 'Baru', 'Alergi kulit', 'Dermatitis', 'Pemeriksaan kulit, salep', 9, 180000.00, 'lunas', 4.9, 'Sangat puas dengan hasil pemeriksaan'),
(14, 14, '2025-07-03', 'Kembali', 'Kontrol mata', 'Minus bertambah', 'Cek mata, resep kacamata', 10, 300000.00, 'cicil', 2.5, 'Sistem antrian tidak jelas'),
(15, 15, '2025-07-05', 'Baru', 'Konsultasi kehamilan', 'Hamil 8 minggu', 'USG dan konsultasi', 11, 250000.00, 'lunas', 4.6, 'Proses pendaftaran cepat dan mudah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_resep`
--

CREATE TABLE `pasien_resep` (
  `id` int(11) NOT NULL,
  `kunjungan_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `tanggal_resep` date NOT NULL,
  `obat_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `aturan_pakai` varchar(255) DEFAULT NULL,
  `durasi_hari` int(11) DEFAULT NULL,
  `status` enum('aktif','selesai','batal') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pasien_resep`
--

INSERT INTO `pasien_resep` (`id`, `kunjungan_id`, `pasien_id`, `dokter_id`, `tanggal_resep`, `obat_id`, `jumlah`, `aturan_pakai`, `durasi_hari`, `status`) VALUES
(1, 1, 1, 1, '2025-07-08', 1, 10, '1 tablet 3 kali sehari', 7, 'aktif'),
(2, 2, 2, 2, '2025-07-08', 2, 5, '1 kapsul 2 kali sehari', 5, 'aktif'),
(3, 3, 3, 1, '2025-07-08', 3, 15, '1 tablet sesudah makan', 10, 'aktif'),
(4, 4, 4, 3, '2025-07-08', 4, 20, '1 salep oles 2 kali sehari', 7, 'aktif'),
(5, 5, 5, 4, '2025-07-08', 5, 25, '1 tablet 3 kali sehari', 14, 'aktif'),
(6, 6, 6, 5, '2025-07-08', 6, 30, '1 kapsul sebelum makan', 30, 'aktif'),
(7, 7, 7, 6, '2025-07-08', 7, 1, '1 suntik intravena', 1, 'aktif'),
(8, 8, 8, 7, '2025-07-08', 8, 2, '1 tetes mata 3 kali sehari', 7, 'aktif'),
(9, 9, 9, 1, '2025-07-08', 9, 3, '1 tablet 2 kali sehari', 5, 'aktif'),
(10, 10, 10, 2, '2025-07-08', 10, 4, '1 kapsul sesudah makan', 10, 'aktif'),
(11, 11, 1, 1, '2025-07-09', 1, 10, '1 tablet 3 kali sehari', 7, 'aktif'),
(12, 12, 3, 1, '2025-07-09', 2, 5, '1 kapsul 2 kali sehari', 5, 'aktif'),
(13, 13, 5, 4, '2025-07-09', 3, 15, '1 tablet sesudah makan', 10, 'aktif'),
(14, 14, 7, 6, '2025-07-09', 4, 20, '1 salep oles 2 kali sehari', 7, 'aktif'),
(15, 15, 9, 1, '2025-07-10', 5, 25, '1 tablet 3 kali sehari', 14, 'aktif'),
(16, 16, 2, 2, '2025-07-10', 6, 30, '1 kapsul sebelum makan', 30, 'aktif'),
(17, 17, 4, 3, '2025-07-10', 7, 1, '1 suntik intravena', 1, 'aktif'),
(18, 18, 6, 5, '2025-07-10', 8, 2, '1 tetes mata 3 kali sehari', 7, 'aktif'),
(19, 19, 1, 1, '2025-07-11', 9, 3, '1 tablet 2 kali sehari', 5, 'aktif'),
(20, 20, 2, 2, '2025-07-11', 10, 4, '1 kapsul sesudah makan', 10, 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_detail_analytics`
--

CREATE TABLE `pemeriksaan_detail_analytics` (
  `id` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `durasi_konsultasi` int(11) DEFAULT 0,
  `kategori_keluhan` enum('Demam','Batuk','Pusing','Mual','Flu','Pencernaan','Pernapasan','Jantung','Lainnya') DEFAULT 'Lainnya',
  `tingkat_urgensi` enum('Rendah','Sedang','Tinggi','Darurat') DEFAULT 'Rendah',
  `status_pemeriksaan` enum('Menunggu','Berlangsung','Selesai','Batal') DEFAULT 'Menunggu',
  `resep_diberikan` tinyint(1) DEFAULT 0,
  `biaya_konsultasi` decimal(10,2) DEFAULT 0.00,
  `rating_pelayanan` decimal(2,1) DEFAULT NULL,
  `catatan_khusus` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_detail_analytics`
--

INSERT INTO `pemeriksaan_detail_analytics` (`id`, `id_pemeriksaan`, `pasien_id`, `dokter_id`, `tanggal_periksa`, `jam_mulai`, `jam_selesai`, `durasi_konsultasi`, `kategori_keluhan`, `tingkat_urgensi`, `status_pemeriksaan`, `resep_diberikan`, `biaya_konsultasi`, `rating_pelayanan`, `catatan_khusus`) VALUES
(1, 1, 1, 1, '2025-07-08', '08:45:00', '09:00:00', 15, 'Demam', 'Sedang', 'Selesai', 1, 150000.00, 4.5, 'Pasien responsif terhadap pengobatan'),
(2, 2, 2, 2, '2025-07-08', '09:15:00', '09:35:00', 20, 'Pernapasan', 'Sedang', 'Selesai', 1, 175000.00, 4.2, 'Anak kooperatif selama pemeriksaan'),
(3, 3, 3, 1, '2025-07-08', '10:30:00', '10:55:00', 25, 'Jantung', 'Tinggi', 'Selesai', 1, 150000.00, 4.8, 'Perlu monitoring tekanan darah rutin'),
(4, 4, 4, 3, '2025-07-08', '10:00:00', '10:30:00', 30, 'Lainnya', 'Sedang', 'Selesai', 1, 200000.00, 4.0, 'Edukasi kebersihan gigi diberikan'),
(5, 5, 5, 4, '2025-07-08', '10:45:00', '11:20:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 300000.00, 4.7, 'Resep kacamata diberikan'),
(6, 6, 6, 5, '2025-07-08', '11:15:00', '11:40:00', 25, 'Lainnya', 'Sedang', 'Selesai', 1, 180000.00, 3.8, 'Alergi makanan perlu dihindari'),
(7, 7, 7, 6, '2025-07-08', '11:45:00', '12:25:00', 40, 'Jantung', 'Darurat', 'Selesai', 1, 250000.00, 4.9, 'Rujukan kardiolog segera'),
(8, 8, 8, 7, '2025-07-08', '12:15:00', '13:00:00', 45, 'Lainnya', 'Rendah', 'Selesai', 1, 350000.00, 4.6, 'Kehamilan berjalan normal'),
(9, 9, 9, 1, '2025-07-08', '13:30:00', '13:52:00', 22, 'Pernapasan', 'Sedang', 'Selesai', 1, 190000.00, 4.3, 'Hindari paparan asap rokok'),
(10, 10, 10, 2, '2025-07-08', '14:00:00', '14:18:00', 18, 'Demam', 'Tinggi', 'Selesai', 1, 160000.00, 4.1, 'Monitor suhu tubuh anak'),
(11, 11, 1, 1, '2025-07-09', '08:30:00', '08:50:00', 20, 'Flu', 'Sedang', 'Selesai', 1, 145000.00, 4.4, 'Kondisi membaik'),
(12, 12, 3, 1, '2025-07-09', '09:00:00', '09:25:00', 25, 'Pusing', 'Sedang', 'Selesai', 1, 155000.00, 4.2, 'Tekanan darah terkontrol'),
(13, 13, 5, 4, '2025-07-09', '10:00:00', '10:35:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 285000.00, 4.8, 'Kontrol mata rutin'),
(14, 14, 7, 6, '2025-07-09', '11:00:00', '11:30:00', 30, 'Jantung', 'Tinggi', 'Selesai', 1, 275000.00, 4.7, 'EKG hasil membaik'),
(15, 15, 9, 1, '2025-07-10', '08:45:00', '09:05:00', 20, 'Batuk', 'Sedang', 'Selesai', 1, 165000.00, 4.3, 'Batuk berkurang');

-- ========================================
-- VIEWS UNTUK DASHBOARD DAN ANALYTICS
-- ========================================

-- View untuk dashboard user management
CREATE VIEW `view_user_dashboard_summary` AS
SELECT 
    COUNT(*) as total_users,
    COUNT(CASE WHEN status_aktif = 'aktif' THEN 1 END) as users_aktif,
    COUNT(CASE WHEN status_aktif = 'nonaktif' THEN 1 END) as users_nonaktif,
    COUNT(CASE WHEN status_aktif = 'suspended' THEN 1 END) as users_suspended,
    COUNT(CASE WHEN last_login >= DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 END) as active_last_24h,
    COUNT(CASE WHEN last_login >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as active_last_week,
    (SELECT COUNT(*) FROM user_login_log WHERE login_time >= CURDATE()) as login_attempts_today,
    (SELECT COUNT(*) FROM user_login_log WHERE status_login = 'failed' AND login_time >= CURDATE()) as failed_logins_today
FROM tb_user;

-- View untuk user activity summary
CREATE VIEW `view_user_activity_summary` AS
SELECT 
    u.id_user,
    u.username,
    u.nama_lengkap,
    u.jabatan,
    u.status_aktif,
    u.last_login,
    u.login_count,
    u.ip_address_last,
    (SELECT COUNT(*) FROM user_login_log WHERE user_id = u.id_user AND login_time >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as logins_last_30_days,
    (SELECT COUNT(*) FROM user_login_log WHERE user_id = u.id_user AND status_login = 'failed' AND login_time >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as failed_attempts_last_30_days,
    (SELECT AVG(session_duration) FROM user_login_log WHERE user_id = u.id_user AND session_duration IS NOT NULL) as avg_session_duration,
    DATEDIFF(CURDATE(), DATE(u.last_login)) as days_since_last_login
FROM tb_user u
ORDER BY u.last_login DESC;

-- View untuk dashboard summary utama
CREATE VIEW `view_dashboard_summary` AS
SELECT 
    (SELECT COUNT(*) FROM tb_pasien) as total_pasien,
    (SELECT COUNT(*) FROM tb_dokter) as total_dokter,
    (SELECT COUNT(*) FROM tb_obat) as total_obat,
    (SELECT COUNT(*) FROM tb_staff) as total_staff,
    (SELECT COUNT(*) FROM tb_pendaftaran WHERE DATE(tanggal_pendaftaran) = CURDATE()) as pendaftaran_hari_ini,
    (SELECT COUNT(*) FROM tb_pemeriksaan WHERE DATE(tanggal_pemeriksaan) = CURDATE()) as pemeriksaan_hari_ini,
    (SELECT COALESCE(SUM(total_bayar), 0) FROM pembayaran WHERE DATE(tanggal_bayar) = CURDATE()) as pendapatan_hari_ini,
    (SELECT COUNT(*) FROM tb_user WHERE status_aktif = 'aktif') as total_user_aktif;

-- View untuk pasien analytics
CREATE VIEW `view_pasien_analytics` AS
SELECT 
    COUNT(*) as total_pasien,
    COUNT(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 END) as pasien_laki,
    COUNT(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 END) as pasien_perempuan,
    AVG(YEAR(CURDATE()) - YEAR(tanggal_lahir)) as rata_rata_umur,
    COUNT(CASE WHEN DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as pasien_baru_30_hari,
    COUNT(CASE WHEN DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) as pasien_baru_7_hari
FROM tb_pasien;

-- View untuk dokter analytics
CREATE VIEW `view_dokter_analytics` AS
SELECT 
    COUNT(*) as total_dokter,
    COUNT(CASE WHEN status_dokter = 'aktif' THEN 1 END) as dokter_aktif,
    COUNT(DISTINCT spesialisasi) as total_spesialisasi,
    AVG(pengalaman_tahun) as rata_rata_pengalaman,
    COUNT(CASE WHEN jadwal_praktek LIKE '%Senin%' THEN 1 END) as dokter_senin,
    COUNT(CASE WHEN jadwal_praktek LIKE '%Selasa%' THEN 1 END) as dokter_selasa,
    COUNT(CASE WHEN jadwal_praktek LIKE '%Rabu%' THEN 1 END) as dokter_rabu
FROM tb_dokter;

-- View untuk obat analytics
CREATE VIEW `view_obat_analytics` AS
SELECT 
    COUNT(*) as total_obat,
    COUNT(CASE WHEN stok > 0 THEN 1 END) as obat_tersedia,
    COUNT(CASE WHEN stok <= 10 THEN 1 END) as obat_stok_rendah,
    COUNT(CASE WHEN expired_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as obat_akan_expired,
    COUNT(CASE WHEN expired_date <= CURDATE() THEN 1 END) as obat_expired,
    SUM(stok * harga_satuan) as total_nilai_stok,
    COUNT(DISTINCT kategori) as total_kategori
FROM tb_obat;

-- View untuk staff analytics
CREATE VIEW `view_staff_analytics` AS
SELECT 
    COUNT(*) as total_staff,
    COUNT(CASE WHEN status_staff = 'aktif' THEN 1 END) as staff_aktif,
    COUNT(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 END) as staff_laki,
    COUNT(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 END) as staff_perempuan,
    COUNT(DISTINCT departemen) as total_departemen,
    AVG(YEAR(CURDATE()) - YEAR(tanggal_lahir)) as rata_rata_umur_staff
FROM tb_staff;

-- View untuk pemeriksaan analytics
CREATE VIEW `view_pemeriksaan_analytics` AS
SELECT 
    COUNT(*) as total_pemeriksaan,
    COUNT(CASE WHEN DATE(tgl_pemeriksaan) = CURDATE() THEN 1 END) as pemeriksaan_hari_ini,
    COUNT(CASE WHEN DATE(tgl_pemeriksaan) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) as pemeriksaan_7_hari,
    COUNT(CASE WHEN DATE(tgl_pemeriksaan) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as pemeriksaan_30_hari,
    COUNT(DISTINCT id_pasien) as total_pasien_unik,
    COUNT(DISTINCT id_dokter) as total_dokter_aktif,
    AVG(biaya_pemeriksaan) as rata_rata_biaya
FROM tb_pemeriksaan;

-- View untuk keuangan analytics
CREATE VIEW `view_keuangan_analytics` AS
SELECT 
    (SELECT COALESCE(SUM(total_bayar), 0) FROM pembayaran WHERE DATE(tanggal_bayar) = CURDATE()) as pendapatan_hari_ini,
    (SELECT COALESCE(SUM(total_bayar), 0) FROM pembayaran WHERE DATE(tanggal_bayar) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)) as pendapatan_7_hari,
    (SELECT COALESCE(SUM(total_bayar), 0) FROM pembayaran WHERE DATE(tanggal_bayar) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as pendapatan_30_hari,
    (SELECT COALESCE(SUM(jumlah_keuntungan), 0) FROM keuntungan WHERE DATE(tanggal) = CURDATE()) as keuntungan_hari_ini,
    (SELECT COALESCE(SUM(jumlah_keuntungan), 0) FROM keuntungan WHERE DATE(tanggal) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as keuntungan_30_hari,
    (SELECT COALESCE(SUM(jumlah), 0) FROM pengeluaran WHERE DATE(tanggal) = CURDATE()) as pengeluaran_hari_ini,
    (SELECT COALESCE(SUM(jumlah), 0) FROM pengeluaran WHERE DATE(tanggal) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as pengeluaran_30_hari;
(16, 16, 2, 2, '2025-07-10', '09:30:00', '09:55:00', 25, 'Demam', 'Sedang', 'Menunggu', 0, 140000.00, NULL, 'Menunggu hasil lab'),
(17, 17, 4, 3, '2025-07-10', '10:15:00', '10:45:00', 30, 'Lainnya', 'Rendah', 'Berlangsung', 0, 195000.00, NULL, 'Scaling gigi'),
(18, 18, 6, 5, '2025-07-10', '11:00:00', '11:20:00', 20, 'Lainnya', 'Rendah', 'Berlangsung', 0, 175000.00, NULL, 'Follow up dermatitis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_diagnosa_stats`
--

CREATE TABLE `pemeriksaan_diagnosa_stats` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `diagnosa` varchar(100) NOT NULL,
  `jumlah_kasus` int(11) DEFAULT 0,
  `persentase` decimal(5,2) DEFAULT 0.00,
  `tingkat_kesembuhan` decimal(5,2) DEFAULT 0.00,
  `rata_biaya` decimal(10,2) DEFAULT 0.00,
  `rata_durasi` int(11) DEFAULT 0,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `trend_bulanan` enum('naik','turun','stabil') DEFAULT 'stabil',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_diagnosa_stats`
--

INSERT INTO `pemeriksaan_diagnosa_stats` (`id`, `periode_bulan`, `diagnosa`, `jumlah_kasus`, `persentase`, `tingkat_kesembuhan`, `rata_biaya`, `rata_durasi`, `tingkat_kepuasan`, `trend_bulanan`) VALUES
(1, '2025-07', 'ISPA', 45, 22.50, 92.50, 168000.00, 22, 4.3, 'naik'),
(2, '2025-07', 'Demam', 38, 19.00, 95.20, 152000.00, 18, 4.2, 'stabil'),
(3, '2025-07', 'Hipertensi', 32, 16.00, 88.50, 165000.00, 25, 4.5, 'turun'),
(4, '2025-07', 'Gastritis', 28, 14.00, 89.30, 175000.00, 20, 4.1, 'stabil'),
(5, '2025-07', 'Dermatitis', 25, 12.50, 85.60, 182000.00, 28, 3.9, 'naik'),
(6, '2025-07', 'Miopia', 18, 9.00, 100.00, 285000.00, 35, 4.6, 'stabil'),
(7, '2025-07', 'Karies Dentis', 14, 7.00, 94.40, 195000.00, 30, 4.2, 'turun'),
(8, '2025-06', 'ISPA', 42, 21.00, 90.20, 162000.00, 20, 4.1, 'stabil'),
(9, '2025-06', 'Demam', 40, 20.00, 93.80, 148000.00, 17, 4.0, 'naik'),
(10, '2025-06', 'Hipertensi', 35, 17.50, 86.20, 160000.00, 24, 4.3, 'stabil'),
(11, '2025-06', 'Gastritis', 30, 15.00, 87.50, 170000.00, 22, 3.9, 'naik'),
(12, '2025-06', 'Dermatitis', 22, 11.00, 82.40, 178000.00, 26, 3.8, 'stabil'),
(13, '2025-06', 'Miopia', 16, 8.00, 100.00, 280000.00, 33, 4.5, 'turun'),
(14, '2025-06', 'Karies Dentis', 15, 7.50, 92.20, 188000.00, 28, 4.0, 'stabil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_waktu_tunggu_stats`
--

CREATE TABLE `pemeriksaan_waktu_tunggu_stats` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam` time NOT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0 COMMENT 'dalam menit',
  `jumlah_pasien` int(11) DEFAULT 0,
  `tingkat_kepuasan_waktu` decimal(3,2) DEFAULT 0.00,
  `status_antrian` enum('lancar','sedang','padat','sangat_padat') DEFAULT 'lancar',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_waktu_tunggu_stats`
--

INSERT INTO `pemeriksaan_waktu_tunggu_stats` (`id`, `tanggal`, `hari`, `jam`, `rata_waktu_tunggu`, `jumlah_pasien`, `tingkat_kepuasan_waktu`, `status_antrian`) VALUES
(1, '2025-07-07', 'Senin', '08:00:00', 10, 3, 4.2, 'lancar'),
(2, '2025-07-07', 'Senin', '09:00:00', 12, 5, 4.0, 'sedang'),
(3, '2025-07-07', 'Senin', '10:00:00', 13, 6, 3.8, 'sedang'),
(4, '2025-07-07', 'Senin', '11:00:00', 15, 7, 3.5, 'padat'),
(5, '2025-07-07', 'Senin', '17:00:00', 21, 9, 3.2, 'padat'),
(6, '2025-07-07', 'Senin', '18:00:00', 22, 10, 3.0, 'sangat_padat'),
(7, '2025-07-08', 'Selasa', '08:00:00', 9, 2, 4.3, 'lancar'),
(8, '2025-07-08', 'Selasa', '09:00:00', 10, 4, 4.1, 'lancar'),
(9, '2025-07-08', 'Selasa', '10:00:00', 12, 5, 3.9, 'sedang'),
(10, '2025-07-08', 'Selasa', '17:00:00', 20, 8, 3.3, 'padat'),
(11, '2025-07-08', 'Selasa', '18:00:00', 21, 9, 3.1, 'padat'),
(12, '2025-07-09', 'Rabu', '08:00:00', 8, 2, 4.4, 'lancar'),
(13, '2025-07-09', 'Rabu', '09:00:00', 9, 3, 4.2, 'lancar'),
(14, '2025-07-09', 'Rabu', '10:00:00', 11, 4, 4.0, 'sedang'),
(15, '2025-07-09', 'Rabu', '17:00:00', 20, 7, 3.4, 'padat'),
(16, '2025-07-09', 'Rabu', '18:00:00', 21, 8, 3.2, 'padat'),
(17, '2025-07-10', 'Kamis', '08:00:00', 11, 4, 3.9, 'sedang'),
(18, '2025-07-10', 'Kamis', '09:00:00', 12, 5, 3.7, 'sedang'),
(19, '2025-07-10', 'Kamis', '10:00:00', 14, 6, 3.5, 'padat'),
(20, '2025-07-10', 'Kamis', '17:00:00', 22, 9, 3.1, 'padat'),
(21, '2025-07-10', 'Kamis', '18:00:00', 23,  10, 2.9, 'sangat_padat'),
(22, '2025-07-11', 'Jumat', '08:00:00', 13, 5, 3.6, 'sedang'),
(23, '2025-07-11', 'Jumat', '09:00:00', 14, 6, 3.4, 'sedang'),
(24, '2025-07-11', 'Jumat', '10:00:00', 15, 7, 3.2, 'padat'),
(25, '2025-07-11', 'Jumat', '17:00:00', 25, 12, 2.8, 'sangat_padat'),
(26, '2025-07-11', 'Jumat', '18:00:00', 27, 14, 2.5, 'sangat_padat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_monthly_insights`
--

CREATE TABLE `pemeriksaan_monthly_insights` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `total_pemeriksaan` int(11) DEFAULT 0,
  `rata_durasi_konsultasi` int(11) DEFAULT 0,
  `total_pendapatan` decimal(12,2) DEFAULT 0.00,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `pemeriksaan_selesai` int(11) DEFAULT 0,
  `pemeriksaan_batal` int(11) DEFAULT 0,
  `diagnosa_terbanyak` varchar(100) DEFAULT NULL,
  `jam_tersibuk` time DEFAULT NULL,
  `hari_tersibuk` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0,
  `jumlah_rujukan` int(11) DEFAULT 0,
  `tingkat_kedatangan_ulang` decimal(5,2) DEFAULT 0.00,
  `efisiensi_pelayanan` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_monthly_insights`
--

INSERT INTO `pemeriksaan_monthly_insights` (`id`, `periode_bulan`, `total_pemeriksaan`, `rata_durasi_konsultasi`, `total_pendapatan`, `tingkat_kepuasan`, `pemeriksaan_selesai`, `pemeriksaan_batal`, `diagnosa_terbanyak`, `jam_tersibuk`, `hari_tersibuk`, `rata_waktu_tunggu`, `jumlah_rujukan`, `tingkat_kedatangan_ulang`, `efisiensi_pelayanan`) VALUES
(1, '2025-07', 200, 25, 36500000.00, 4.2, 185, 15, 'ISPA', '18:00:00', 'Jumat', 16, 22, 32.50, 87.20),
(2, '2025-06', 180, 23, 32400000.00, 4.1, 168, 12, 'Demam', '17:30:00', 'Jumat', 15, 18, 28.70, 85.60),
(3, '2025-05', 165, 24, 29800000.00, 4.0, 155, 10, 'ISPA', '18:00:00', 'Kamis', 17, 15, 25.40, 83.90),
(4, '2025-04', 155, 22, 27600000.00, 3.9, 148, 7, 'Gastritis', '17:00:00', 'Jumat', 14, 12, 22.80, 86.40);

-- --------------------------------------------------------

--
-- Index dan Auto Increment untuk tabel pemeriksaan
--

--
-- Indexes for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD UNIQUE KEY `kd_pemeriksaan` (`kd_pemeriksaan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `tgl_pemeriksaan` (`tgl_pemeriksaan`),
  ADD KEY `status_periksa` (`status_periksa`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `kd_pendaftaran` (`kd_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`),
  ADD KEY `tgl_pendaftaran` (`tgl_pendaftaran`);

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `nm_pasien` (`nm_pasien`),
  ADD KEY `jk_pasien` (`jk_pasien`);

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `nm_dokter` (`nm_dokter`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tb_poli`
--
ALTER TABLE `tb_poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `nm_poli` (`nm_poli`);

--
-- Indexes for table `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemeriksaan` (`id_pemeriksaan`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `tanggal_periksa` (`tanggal_periksa`),
  ADD KEY `kategori_keluhan` (`kategori_keluhan`),
  ADD KEY `status_pemeriksaan` (`status_pemeriksaan`);

--
-- Indexes for table `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periode_bulan` (`periode_bulan`),
  ADD KEY `diagnosa` (`diagnosa`);

--
-- Indexes for table `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `hari` (`hari`),
  ADD KEY `jam` (`jam`);

--
-- Indexes for table `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode_bulan` (`periode_bulan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pasien`
--
ALTER TABLE `tb_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_poli`
--
ALTER TABLE `tb_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Foreign Key untuk tabel pemeriksaan
--

--
-- Ketidakleluasaan untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tb_dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_3` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD CONSTRAINT `tb_dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE SET NULL;

COMMIT;

-- ========================================
-- VIEWS UNTUK ANALITIK KEUNTUNGAN
-- ========================================

-- ========================================
-- VIEWS UNTUK ANALITIK PENGELUARAN DAN PEMBAYARAN
-- ========================================

-- View untuk dashboard pengeluaran summary
CREATE VIEW `view_pengeluaran_dashboard_summary` AS
SELECT 
    YEAR(CURDATE()) as tahun_aktif,
    (SELECT SUM(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE())) as total_pengeluaran_tahun,
    (SELECT SUM(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE()) AND bulan = MONTH(CURDATE())) as pengeluaran_bulan_ini,
    (SELECT SUM(jumlah) FROM pengeluaran WHERE DATE(tanggal) = CURDATE()) as pengeluaran_hari_ini,
    (SELECT COUNT(*) FROM pengeluaran WHERE tahun = YEAR(CURDATE())) as total_transaksi_tahun,
    (SELECT AVG(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE())) as rata_pengeluaran_per_transaksi,
    (SELECT kategori_pengeluaran FROM pengeluaran WHERE tahun = YEAR(CURDATE()) GROUP BY kategori_pengeluaran ORDER BY SUM(jumlah) DESC LIMIT 1) as kategori_terbesar;

-- View untuk trend pengeluaran bulanan
CREATE VIEW `view_pengeluaran_trend_bulanan` AS
SELECT 
    p.tahun,
    p.bulan,
    MONTHNAME(STR_TO_DATE(p.bulan, '%m')) as nama_bulan,
    SUM(p.jumlah) as total_pengeluaran,
    COUNT(p.id) as total_transaksi,
    AVG(p.jumlah) as rata_pengeluaran_per_transaksi,
    pbs.pertumbuhan_vs_bulan_lalu,
    pbs.status_budget,
    pbs.variance_budget
FROM pengeluaran p
LEFT JOIN pengeluaran_bulanan_summary pbs ON p.tahun = pbs.tahun AND p.bulan = pbs.bulan
WHERE p.tahun >= YEAR(CURDATE()) - 1
GROUP BY p.tahun, p.bulan
ORDER BY p.tahun DESC, p.bulan DESC;

-- View untuk distribusi pengeluaran per kategori
CREATE VIEW `view_pengeluaran_distribusi_kategori` AS
SELECT 
    kategori_pengeluaran as kategori,
    COUNT(*) as jumlah_transaksi,
    SUM(jumlah) as total_pengeluaran,
    AVG(jumlah) as rata_pengeluaran,
    MIN(jumlah) as pengeluaran_terendah,
    MAX(jumlah) as pengeluaran_tertinggi,
    (SUM(jumlah) / (SELECT SUM(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE())) * 100) as persentase_dari_total,
    MIN(tanggal) as transaksi_pertama,
    MAX(tanggal) as transaksi_terakhir
FROM pengeluaran 
WHERE tahun = YEAR(CURDATE())
GROUP BY kategori_pengeluaran
ORDER BY total_pengeluaran DESC;

-- View untuk top vendor berdasarkan nilai transaksi
CREATE VIEW `view_pengeluaran_top_vendor` AS
SELECT 
    vendor_supplier as vendor,
    kategori_pengeluaran as kategori_utama,
    COUNT(*) as jumlah_transaksi,
    SUM(jumlah) as total_pembelian,
    AVG(jumlah) as rata_nilai_transaksi,
    MIN(tanggal) as transaksi_pertama,
    MAX(tanggal) as transaksi_terakhir,
    COUNT(CASE WHEN status_pembayaran = 'Paid' THEN 1 END) as transaksi_lunas,
    COUNT(CASE WHEN status_pembayaran = 'Pending' THEN 1 END) as transaksi_pending
FROM pengeluaran 
WHERE tahun = YEAR(CURDATE()) AND vendor_supplier IS NOT NULL
GROUP BY vendor_supplier, kategori_pengeluaran
ORDER BY total_pembelian DESC
LIMIT 15;

-- View untuk analisis status pembayaran
CREATE VIEW `view_pengeluaran_status_pembayaran` AS
SELECT 
    status_pembayaran,
    COUNT(*) as jumlah_transaksi,
    SUM(jumlah) as total_nilai,
    AVG(jumlah) as rata_nilai,
    AVG(DATEDIFF(COALESCE(tanggal_bayar, CURDATE()), tanggal)) as rata_hari_pembayaran,
    COUNT(CASE WHEN tanggal_jatuh_tempo < CURDATE() AND status_pembayaran = 'Pending' THEN 1 END) as overdue_count,
    SUM(CASE WHEN tanggal_jatuh_tempo < CURDATE() AND status_pembayaran = 'Pending' THEN jumlah ELSE 0 END) as overdue_amount
FROM pengeluaran 
WHERE tahun = YEAR(CURDATE())
GROUP BY status_pembayaran
ORDER BY total_nilai DESC;

-- View untuk analisis metode pembayaran
CREATE VIEW `view_pengeluaran_metode_pembayaran` AS
SELECT 
    metode_pembayaran,
    COUNT(*) as jumlah_transaksi,
    SUM(jumlah) as total_nilai,
    AVG(jumlah) as rata_nilai_per_transaksi,
    (SUM(jumlah) / (SELECT SUM(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE())) * 100) as persentase_penggunaan,
    COUNT(CASE WHEN status_pembayaran = 'Paid' THEN 1 END) as transaksi_sukses,
    (COUNT(CASE WHEN status_pembayaran = 'Paid' THEN 1 END) / COUNT(*) * 100) as success_rate
FROM pengeluaran 
WHERE tahun = YEAR(CURDATE())
GROUP BY metode_pembayaran
ORDER BY total_nilai DESC;

-- View untuk cash flow harian
CREATE VIEW `view_pengeluaran_cash_flow_harian` AS
SELECT 
    tanggal,
    DAYNAME(tanggal) as hari,
    COUNT(*) as jumlah_transaksi,
    SUM(jumlah) as total_pengeluaran,
    SUM(CASE WHEN kategori_pengeluaran = 'Obat & Alkes' THEN jumlah ELSE 0 END) as pengeluaran_obat,
    SUM(CASE WHEN kategori_pengeluaran = 'Gaji Karyawan' THEN jumlah ELSE 0 END) as pengeluaran_gaji,
    SUM(CASE WHEN kategori_pengeluaran = 'Operasional' THEN jumlah ELSE 0 END) as pengeluaran_operasional,
    AVG(jumlah) as rata_per_transaksi
FROM pengeluaran 
WHERE tahun = YEAR(CURDATE()) AND bulan = MONTH(CURDATE())
GROUP BY tanggal
ORDER BY tanggal DESC;

-- View untuk budget monitoring
CREATE VIEW `view_pengeluaran_budget_monitoring` AS
SELECT 
    pbp.kategori,
    pbp.budget_tahunan,
    pbp.budget_bulanan_rata,
    pbp.realisasi_sampai_saat_ini,
    pbp.persentase_realisasi,
    pbp.proyeksi_akhir_tahun,
    pbp.variance_vs_budget,
    pbp.status_budget,
    (SELECT SUM(jumlah) FROM pengeluaran WHERE kategori_pengeluaran = pbp.kategori AND tahun = pbp.tahun AND bulan = MONTH(CURDATE())) as realisasi_bulan_ini,
    (pbp.budget_bulanan_rata - (SELECT SUM(jumlah) FROM pengeluaran WHERE kategori_pengeluaran = pbp.kategori AND tahun = pbp.tahun AND bulan = MONTH(CURDATE()))) as sisa_budget_bulan_ini,
    pbp.rekomendasi_aksi,
    pbp.pic_responsible
FROM pengeluaran_budget_planning pbp
WHERE pbp.tahun = YEAR(CURDATE())
ORDER BY pbp.persentase_realisasi DESC;

-- View untuk vendor performance analysis
CREATE VIEW `view_pengeluaran_vendor_performance` AS
SELECT 
    pva.vendor_name,
    pva.kategori_utama,
    pva.total_pembelian_tahun,
    pva.jumlah_transaksi,
    pva.rata_nilai_transaksi,
    pva.last_transaction_date,
    pva.rating_performance,
    pva.payment_terms,
    pva.kontrak_status,
    pva.contact_person,
    pva.phone_number,
    DATEDIFF(CURDATE(), pva.last_transaction_date) as hari_sejak_transaksi_terakhir,
    (SELECT COUNT(*) FROM pengeluaran WHERE vendor_supplier = pva.vendor_name AND status_pembayaran = 'Paid' AND tahun = YEAR(CURDATE())) as transaksi_lunas,
    (SELECT COUNT(*) FROM pengeluaran WHERE vendor_supplier = pva.vendor_name AND status_pembayaran = 'Pending' AND tahun = YEAR(CURDATE())) as transaksi_pending,
    pva.notes
FROM pengeluaran_vendor_analytics pva
WHERE pva.tahun = YEAR(CURDATE())
ORDER BY pva.total_pembelian_tahun DESC;

-- View untuk expense forecasting
CREATE VIEW `view_pengeluaran_forecasting` AS
SELECT 
    kategori_pengeluaran as kategori,
    tahun,
    bulan,
    SUM(jumlah) as pengeluaran_aktual,
    LAG(SUM(jumlah), 1) OVER (PARTITION BY kategori_pengeluaran ORDER BY tahun, bulan) as pengeluaran_bulan_lalu,
    LAG(SUM(jumlah), 12) OVER (PARTITION BY kategori_pengeluaran ORDER BY tahun, bulan) as pengeluaran_tahun_lalu,
    (SUM(jumlah) - LAG(SUM(jumlah), 1) OVER (PARTITION BY kategori_pengeluaran ORDER BY tahun, bulan)) / 
     NULLIF(LAG(SUM(jumlah), 1) OVER (PARTITION BY kategori_pengeluaran ORDER BY tahun, bulan), 0) * 100 as growth_mom,
    (SUM(jumlah) - LAG(SUM(jumlah), 12) OVER (PARTITION BY kategori_pengeluaran ORDER BY tahun, bulan)) / 
     NULLIF(LAG(SUM(jumlah), 12) OVER (PARTITION BY kategori_pengeluaran ORDER BY tahun, bulan), 0) * 100 as growth_yoy,
    AVG(SUM(jumlah)) OVER (PARTITION BY kategori_pengeluaran ORDER BY tahun, bulan ROWS BETWEEN 2 PRECEDING AND CURRENT ROW) as moving_average_3bulan
FROM pengeluaran
GROUP BY kategori_pengeluaran, tahun, bulan
ORDER BY kategori_pengeluaran, tahun DESC, bulan DESC;

-- View untuk insights dan recommendations
CREATE VIEW `view_pengeluaran_insights` AS
SELECT 
    'budget_status' as insight_type,
    CONCAT('Status budget: ', 
           COUNT(CASE WHEN status_budget = 'over_budget' THEN 1 END), ' kategori over budget, ',
           COUNT(CASE WHEN status_budget = 'under_budget' THEN 1 END), ' kategori under budget') as insight_message,
    COUNT(CASE WHEN status_budget = 'over_budget' THEN 1 END) as metric_value,
    CASE 
        WHEN COUNT(CASE WHEN status_budget = 'over_budget' THEN 1 END) > 2 THEN 'danger'
        WHEN COUNT(CASE WHEN status_budget = 'over_budget' THEN 1 END) > 0 THEN 'warning'
        ELSE 'success'
    END as status_color
FROM pengeluaran_budget_planning 
WHERE tahun = YEAR(CURDATE())

UNION ALL

SELECT 
    'vendor_concentration' as insight_type,
    CONCAT('Vendor dominan: ', vendor_supplier, ' dengan kontribusi ', 
           ROUND((total_pembelian / (SELECT SUM(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE()) AND vendor_supplier IS NOT NULL) * 100), 1), 
           '% dari total pembelian') as insight_message,
    ROUND((total_pembelian / (SELECT SUM(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE()) AND vendor_supplier IS NOT NULL) * 100), 1) as metric_value,
    CASE 
        WHEN (total_pembelian / (SELECT SUM(jumlah) FROM pengeluaran WHERE tahun = YEAR(CURDATE()) AND vendor_supplier IS NOT NULL) * 100) > 50 THEN 'warning'
        ELSE 'info'
    END as status_color
FROM (
    SELECT vendor_supplier, SUM(jumlah) as total_pembelian
    FROM pengeluaran 
    WHERE tahun = YEAR(CURDATE()) AND vendor_supplier IS NOT NULL
    GROUP BY vendor_supplier
    ORDER BY total_pembelian DESC
    LIMIT 1
) top_vendor

UNION ALL

SELECT 
    'payment_efficiency' as insight_type,
    CONCAT('Efisiensi pembayaran: ', 
           ROUND((COUNT(CASE WHEN status_pembayaran = 'Paid' THEN 1 END) / COUNT(*) * 100), 1), 
           '% transaksi telah dibayar, rata-rata ', 
           ROUND(AVG(DATEDIFF(COALESCE(tanggal_bayar, CURDATE()), tanggal)), 0), ' hari') as insight_message,
    ROUND((COUNT(CASE WHEN status_pembayaran = 'Paid' THEN 1 END) / COUNT(*) * 100), 1) as metric_value,
    CASE 
        WHEN (COUNT(CASE WHEN status_pembayaran = 'Paid' THEN 1 END) / COUNT(*) * 100) > 90 THEN 'success'
        WHEN (COUNT(CASE WHEN status_pembayaran = 'Paid' THEN 1 END) / COUNT(*) * 100) > 75 THEN 'info'
        ELSE 'warning'
    END as status_color
FROM pengeluaran 
WHERE tahun = YEAR(CURDATE());

-- ========================================
-- INDEX DAN AUTO_INCREMENT UNTUK TABEL PENGELUARAN
-- ========================================

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD UNIQUE KEY `no_rm` (`no_rm`),
  ADD KEY `nama_pasien` (`nama_pasien`),
  ADD KEY `jenis_kelamin` (`jenis_kelamin`),
  ADD KEY `tanggal_lahir` (`tanggal_lahir`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD UNIQUE KEY `no_sip` (`no_sip`),
  ADD KEY `nama_dokter` (`nama_dokter`),
  ADD KEY `spesialisasi` (`spesialisasi`),
  ADD KEY `status_dokter` (`status_dokter`);

--
-- Indexes for table `tb_obat`
--
ALTER TABLE `tb_obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD UNIQUE KEY `kode_obat` (`kode_obat`),
  ADD KEY `nama_obat` (`nama_obat`),
  ADD KEY `kategori` (`kategori`),
  ADD KEY `stok` (`stok`),
  ADD KEY `expired_date` (`expired_date`),
  ADD KEY `status_obat` (`status_obat`);

--
-- Indexes for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD PRIMARY KEY (`id_staff`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `nama_staff` (`nama_staff`),
  ADD KEY `departemen` (`departemen`),
  ADD KEY `status_staff` (`status_staff`);

--
-- Indexes for table `tb_poli`
--
ALTER TABLE `tb_poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `nama_poli` (`nama_poli`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `no_antrian` (`no_antrian`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`),
  ADD KEY `tanggal_pendaftaran` (`tanggal_pendaftaran`),
  ADD KEY `status_pendaftaran` (`status_pendaftaran`);

--
-- Indexes for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `tanggal_pemeriksaan` (`tanggal_pemeriksaan`),
  ADD KEY `status_pemeriksaan` (`status_pemeriksaan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemeriksaan` (`id_pemeriksaan`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `tanggal_bayar` (`tanggal_bayar`),
  ADD KEY `metode_pembayaran` (`metode_pembayaran`),
  ADD KEY `status_pembayaran` (`status_pembayaran`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `kategori` (`kategori`),
  ADD KEY `departemen` (`departemen`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT untuk semua tabel
--

ALTER TABLE `tb_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `tb_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `tb_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `tb_staff`
  MODIFY `id_staff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `tb_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `tb_pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- FOREIGN KEY CONSTRAINTS
--

ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tb_dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_3` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE CASCADE;

ALTER TABLE `tb_pemeriksaan`
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `tb_dokter` (`id_dokter`) ON DELETE CASCADE;

ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemeriksaan`) REFERENCES `tb_pemeriksaan` (`id_pemeriksaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE;

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `kategori_pengeluaran` (`kategori_pengeluaran`),
  ADD KEY `vendor_supplier` (`vendor_supplier`),
  ADD KEY `status_pembayaran` (`status_pembayaran`),
  ADD KEY `bulan_tahun` (`bulan`, `tahun`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `tanggal_jatuh_tempo` (`tanggal_jatuh_tempo`);

--
-- Indexes for table `pengeluaran_kategori_analytics`
--
ALTER TABLE `pengeluaran_kategori_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori` (`kategori`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `persentase_dari_total` (`persentase_dari_total`);

--
-- Indexes for table `pengeluaran_bulanan_summary`
--
ALTER TABLE `pengeluaran_bulanan_summary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun_bulan` (`tahun`, `bulan`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `bulan` (`bulan`),
  ADD KEY `status_budget` (`status_budget`);

--
-- Indexes for table `pengeluaran_vendor_analytics`
--
ALTER TABLE `pengeluaran_vendor_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_name` (`vendor_name`),
  ADD KEY `kategori_utama` (`kategori_utama`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `rating_performance` (`rating_performance`),
  ADD KEY `kontrak_status` (`kontrak_status`);

--
-- Indexes for table `pengeluaran_budget_planning`
--
ALTER TABLE `pengeluaran_budget_planning`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun_kategori` (`tahun`, `kategori`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `kategori` (`kategori`),
  ADD KEY `status_budget` (`status_budget`);

--
-- AUTO_INCREMENT untuk tabel pengeluaran
--

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_kategori_analytics`
--
ALTER TABLE `pengeluaran_kategori_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_bulanan_summary`
--
ALTER TABLE `pengeluaran_bulanan_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_vendor_analytics`
--
ALTER TABLE `pengeluaran_vendor_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_budget_planning`
--
ALTER TABLE `pengeluaran_budget_planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- ========================================
-- CONSTRAINT DAN FOREIGN KEY UNTUK TABEL PENGELUARAN
-- ========================================

-- Constraints untuk memastikan data konsistensi
ALTER TABLE `pengeluaran` 
  ADD CONSTRAINT `chk_pengeluaran_positive` CHECK (`jumlah` >= 0),
  ADD CONSTRAINT `chk_bulan_valid_pengeluaran` CHECK (`bulan` >= 1 AND `bulan` <= 12),
  ADD CONSTRAINT `chk_tahun_valid_pengeluaran` CHECK (`tahun` >= 2020 AND `tahun` <= 2050),
  ADD CONSTRAINT `chk_tanggal_bayar_valid` CHECK (`tanggal_bayar` IS NULL OR `tanggal_bayar` >= `tanggal`);

-- View untuk dashboard keuntungan summary
CREATE VIEW `view_keuntungan_dashboard_summary` AS
SELECT 
    YEAR(CURDATE()) as tahun_aktif,
    (SELECT SUM(keuntungan_bersih) FROM keuntungan WHERE tahun = YEAR(CURDATE())) as total_keuntungan_tahun,
    (SELECT SUM(keuntungan_bersih) FROM keuntungan WHERE tahun = YEAR(CURDATE()) AND bulan = MONTH(CURDATE())) as keuntungan_bulan_ini,
    (SELECT SUM(keuntungan_bersih) FROM keuntungan WHERE DATE(tanggal) = CURDATE()) as keuntungan_hari_ini,
    (SELECT COUNT(*) FROM keuntungan WHERE tahun = YEAR(CURDATE())) as total_transaksi_tahun,
    (SELECT AVG(keuntungan_bersih) FROM keuntungan WHERE tahun = YEAR(CURDATE())) as rata_keuntungan_per_bulan,
    (SELECT layanan FROM keuntungan_layanan_summary WHERE tahun = YEAR(CURDATE()) ORDER BY total_keuntungan_tahun DESC LIMIT 1) as layanan_terlaris;

-- View untuk trend keuntungan bulanan
CREATE VIEW `view_keuntungan_trend_bulanan` AS
SELECT 
    k.tahun,
    k.bulan,
    MONTHNAME(STR_TO_DATE(k.bulan, '%m')) as nama_bulan,
    SUM(k.keuntungan_bersih) as total_keuntungan,
    SUM(k.jumlah_transaksi) as total_transaksi,
    AVG(k.persentase_margin) as rata_margin,
    kba.pertumbuhan_vs_bulan_lalu,
    kba.pencapaian_target_persen,
    kba.ranking_bulan
FROM keuntungan k
LEFT JOIN keuntungan_bulanan_analytics kba ON k.tahun = kba.tahun AND k.bulan = kba.bulan
WHERE k.tahun >= YEAR(CURDATE()) - 1
GROUP BY k.tahun, k.bulan
ORDER BY k.tahun DESC, k.bulan DESC;

-- View untuk distribusi keuntungan per layanan
CREATE VIEW `view_keuntungan_distribusi_layanan` AS
SELECT 
    sumber_keuntungan as layanan,
    COUNT(*) as jumlah_transaksi,
    SUM(jumlah_keuntungan) as total_pendapatan,
    SUM(keuntungan_bersih) as total_keuntungan_bersih,
    AVG(persentase_margin) as rata_margin,
    (SUM(keuntungan_bersih) / (SELECT SUM(keuntungan_bersih) FROM keuntungan WHERE tahun = YEAR(CURDATE())) * 100) as persentase_kontribusi,
    MIN(tanggal) as transaksi_pertama,
    MAX(tanggal) as transaksi_terakhir
FROM keuntungan 
WHERE tahun = YEAR(CURDATE())
GROUP BY sumber_keuntungan
ORDER BY total_keuntungan_bersih DESC;

-- View untuk top 5 hari dengan keuntungan tertinggi
CREATE VIEW `view_keuntungan_top_hari` AS
SELECT 
    tanggal,
    DAYNAME(tanggal) as hari,
    COUNT(*) as jumlah_transaksi,
    SUM(jumlah_keuntungan) as total_pendapatan,
    SUM(keuntungan_bersih) as total_keuntungan_bersih,
    SUM(biaya_operasional) as total_biaya_operasional,
    AVG(persentase_margin) as rata_margin
FROM keuntungan 
WHERE tahun = YEAR(CURDATE())
GROUP BY tanggal
ORDER BY total_keuntungan_bersih DESC
LIMIT 10;

-- View untuk analisis margin profit per layanan
CREATE VIEW `view_keuntungan_margin_analysis` AS
SELECT 
    sumber_keuntungan as layanan,
    sub_layanan,
    COUNT(*) as jumlah_transaksi,
    AVG(persentase_margin) as rata_margin,
    MIN(persentase_margin) as margin_terendah,
    MAX(persentase_margin) as margin_tertinggi,
    STDDEV(persentase_margin) as variasi_margin,
    SUM(jumlah_keuntungan) as total_pendapatan,
    SUM(biaya_operasional) as total_biaya,
    SUM(keuntungan_bersih) as total_keuntungan_bersih,
    (SUM(keuntungan_bersih) / SUM(jumlah_keuntungan) * 100) as margin_aktual
FROM keuntungan 
WHERE tahun = YEAR(CURDATE())
GROUP BY sumber_keuntungan, sub_layanan
ORDER BY margin_aktual DESC;

-- View untuk perbandingan tahun-ke-tahun (YoY)
CREATE VIEW `view_keuntungan_yoy_comparison` AS
SELECT 
    bulan,
    MONTHNAME(STR_TO_DATE(bulan, '%m')) as nama_bulan,
    SUM(CASE WHEN tahun = YEAR(CURDATE()) THEN keuntungan_bersih ELSE 0 END) as keuntungan_tahun_ini,
    SUM(CASE WHEN tahun = YEAR(CURDATE()) - 1 THEN keuntungan_bersih ELSE 0 END) as keuntungan_tahun_lalu,
    SUM(CASE WHEN tahun = YEAR(CURDATE()) THEN jumlah_transaksi ELSE 0 END) as transaksi_tahun_ini,
    SUM(CASE WHEN tahun = YEAR(CURDATE()) - 1 THEN jumlah_transaksi ELSE 0 END) as transaksi_tahun_lalu,
    (SUM(CASE WHEN tahun = YEAR(CURDATE()) THEN keuntungan_bersih ELSE 0 END) - 
     SUM(CASE WHEN tahun = YEAR(CURDATE()) - 1 THEN keuntungan_bersih ELSE 0 END)) / 
     NULLIF(SUM(CASE WHEN tahun = YEAR(CURDATE()) - 1 THEN keuntungan_bersih ELSE 0 END), 0) * 100 as pertumbuhan_persen
FROM keuntungan 
WHERE tahun IN (YEAR(CURDATE()), YEAR(CURDATE()) - 1)
GROUP BY bulan
ORDER BY bulan;

-- View untuk proyeksi keuntungan berdasarkan trend
CREATE VIEW `view_keuntungan_proyeksi` AS
SELECT 
    tahun,
    bulan,
    total_keuntungan,
    LAG(total_keuntungan, 1) OVER (ORDER BY tahun, bulan) as keuntungan_bulan_sebelum,
    LAG(total_keuntungan, 12) OVER (ORDER BY tahun, bulan) as keuntungan_tahun_lalu,
    (total_keuntungan - LAG(total_keuntungan, 1) OVER (ORDER BY tahun, bulan)) / 
     NULLIF(LAG(total_keuntungan, 1) OVER (ORDER BY tahun, bulan), 0) * 100 as growth_mom,
    (total_keuntungan - LAG(total_keuntungan, 12) OVER (ORDER BY tahun, bulan)) / 
     NULLIF(LAG(total_keuntungan, 12) OVER (ORDER BY tahun, bulan), 0) * 100 as growth_yoy,
    AVG(total_keuntungan) OVER (ORDER BY tahun, bulan ROWS BETWEEN 2 PRECEDING AND CURRENT ROW) as moving_average_3bulan
FROM keuntungan_bulanan_analytics
ORDER BY tahun DESC, bulan DESC;

-- View untuk analisis KPI dan pencapaian target
CREATE VIEW `view_keuntungan_kpi_dashboard` AS
SELECT 
    ktk.tahun,
    ktk.target_tahunan,
    ktk.pencapaian_sampai_saat_ini,
    ktk.persentase_pencapaian,
    ktk.proyeksi_akhir_tahun,
    ktk.gap_vs_target,
    ktk.bulan_terbaik,
    ktk.bulan_terburuk,
    ktk.layanan_andalan,
    ktk.status_target,
    (SELECT COUNT(*) FROM keuntungan_bulanan_analytics WHERE tahun = ktk.tahun AND pencapaian_target_persen >= 100) as bulan_mencapai_target,
    (SELECT AVG(pencapaian_target_persen) FROM keuntungan_bulanan_analytics WHERE tahun = ktk.tahun) as rata_pencapaian_bulanan,
    (ktk.pencapaian_sampai_saat_ini / (MONTH(CURDATE()) / 12)) as proyeksi_linear
FROM keuntungan_target_kpi ktk
ORDER BY ktk.tahun DESC;

-- View untuk insights dan rekomendasi otomatis
CREATE VIEW `view_keuntungan_insights` AS
SELECT 
    'trend_bulanan' as insight_type,
    CONCAT('Trend keuntungan ', 
           CASE 
               WHEN AVG(pertumbuhan_vs_bulan_lalu) > 10 THEN 'sangat positif'
               WHEN AVG(pertumbuhan_vs_bulan_lalu) > 5 THEN 'positif'
               WHEN AVG(pertumbuhan_vs_bulan_lalu) > 0 THEN 'stabil'
               ELSE 'perlu perhatian'
           END,
           ' dengan rata-rata pertumbuhan ', 
           ROUND(AVG(pertumbuhan_vs_bulan_lalu), 2), '% per bulan') as insight_message,
    ROUND(AVG(pertumbuhan_vs_bulan_lalu), 2) as metric_value,
    CASE 
        WHEN AVG(pertumbuhan_vs_bulan_lalu) > 5 THEN 'success'
        WHEN AVG(pertumbuhan_vs_bulan_lalu) > 0 THEN 'warning'
        ELSE 'danger'
    END as status_color
FROM keuntungan_bulanan_analytics 
WHERE tahun = YEAR(CURDATE())

UNION ALL

SELECT 
    'layanan_dominan' as insight_type,
    CONCAT('Layanan ', layanan, ' mendominasi dengan kontribusi ', 
           ROUND(persentase_kontribusi, 1), '% dari total keuntungan') as insight_message,
    persentase_kontribusi as metric_value,
    'info' as status_color
FROM keuntungan_layanan_summary 
WHERE tahun = YEAR(CURDATE()) 
ORDER BY persentase_kontribusi DESC 
LIMIT 1

UNION ALL

SELECT 
    'pencapaian_target' as insight_type,
    CONCAT('Pencapaian target tahun ini: ', 
           ROUND(persentase_pencapaian, 1), '% - Status: ', 
           CASE status_target 
               WHEN 'ahead' THEN 'Melampaui Target'
               WHEN 'on_track' THEN 'Sesuai Target'
               WHEN 'behind' THEN 'Di Bawah Target'
               ELSE 'Kritis'
           END) as insight_message,
    persentase_pencapaian as metric_value,
    CASE status_target 
        WHEN 'ahead' THEN 'success'
        WHEN 'on_track' THEN 'info'
        WHEN 'behind' THEN 'warning'
        ELSE 'danger'
    END as status_color
FROM keuntungan_target_kpi 
WHERE tahun = YEAR(CURDATE());

-- ========================================
-- AUTO_INCREMENT TAMBAHAN UNTUK TABEL KEUNTUNGAN
-- ========================================

--
-- AUTO_INCREMENT untuk tabel `keuntungan_bulanan_analytics`
--
ALTER TABLE `keuntungan_bulanan_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `keuntungan_target_kpi`
--
ALTER TABLE `keuntungan_target_kpi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- ========================================
-- FOREIGN KEY DAN CONSTRAINT UNTUK TABEL KEUNTUNGAN
-- ========================================

-- Constraints untuk memastikan data konsistensi
ALTER TABLE `keuntungan` 
  ADD CONSTRAINT `chk_keuntungan_positive` CHECK (`jumlah_keuntungan` >= 0),
  ADD CONSTRAINT `chk_margin_range` CHECK (`persentase_margin` >= 0 AND `persentase_margin` <= 100),
  ADD CONSTRAINT `chk_bulan_valid` CHECK (`bulan` >= 1 AND `bulan` <= 12),
  ADD CONSTRAINT `chk_tahun_valid` CHECK (`tahun` >= 2020 AND `tahun` <= 2050);

-- ========================================
-- COMMIT PERUBAHAN
-- ========================================

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
--
-- VIEWS untuk Dashboard Pemeriksaan
--
-- --------------------------------------------------------

--
-- View: Ringkasan Pemeriksaan
--

CREATE VIEW `view_pemeriksaan_summary` AS
SELECT 
    COUNT(*) as total_pemeriksaan,
    COUNT(CASE WHEN status_periksa = 1 THEN 1 END) as pemeriksaan_selesai,
    COUNT(CASE WHEN status_periksa = 0 THEN 1 END) as pemeriksaan_pending,
    ROUND(AVG(durasi_pemeriksaan), 1) as rata_durasi,
    SUM(biaya_pemeriksaan) as total_pendapatan,
    DATE(NOW()) as tanggal_update
FROM tb_pemeriksaan 
WHERE MONTH(tgl_pemeriksaan) = MONTH(NOW()) 
  AND YEAR(tgl_pemeriksaan) = YEAR(NOW());

--
-- View: Analisis Diagnosa Terpopuler
--

CREATE VIEW `view_diagnosa_popular` AS
SELECT 
    diagnosa,
    COUNT(*) as jumlah_kasus,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM tb_pemeriksaan WHERE MONTH(tgl_pemeriksaan) = MONTH(NOW()))), 2) as persentase,
    ROUND(AVG(biaya_pemeriksaan), 0) as rata_biaya,
    ROUND(AVG(durasi_pemeriksaan), 1) as rata_durasi
FROM tb_pemeriksaan 
WHERE MONTH(tgl_pemeriksaan) = MONTH(NOW()) 
  AND YEAR(tgl_pemeriksaan) = YEAR(NOW())
  AND diagnosa IS NOT NULL
GROUP BY diagnosa
ORDER BY jumlah_kasus DESC
LIMIT 10;

--
-- View: Waktu Tunggu per Jam
--

CREATE VIEW `view_waktu_tunggu_jam` AS
SELECT 
    HOUR(jam_pemeriksaan) as jam,
    COUNT(*) as jumlah_pasien,
    ROUND(AVG(durasi_pemeriksaan), 1) as rata_durasi,
    CASE 
        WHEN COUNT(*) <= 3 THEN 'Lancar'
        WHEN COUNT(*) <= 6 THEN 'Sedang' 
        WHEN COUNT(*) <= 10 THEN 'Padat'
        ELSE 'Sangat Padat'
    END as status_antrian
FROM tb_pemeriksaan 
WHERE tgl_pemeriksaan >= DATE_SUB(NOW(), INTERVAL 7 DAY)
  AND jam_pemeriksaan IS NOT NULL
GROUP BY HOUR(jam_pemeriksaan)
ORDER BY jam;

--
-- View: Performance Dokter dalam Pemeriksaan
--

CREATE VIEW `view_dokter_performance_pemeriksaan` AS
SELECT 
    d.nm_dokter,
    p.nm_poli,
    COUNT(*) as total_pemeriksaan,
    COUNT(CASE WHEN tp.status_periksa = 1 THEN 1 END) as pemeriksaan_selesai,
    ROUND(AVG(tp.durasi_pemeriksaan), 1) as rata_durasi,
    SUM(tp.biaya_pemeriksaan) as total_pendapatan,
    ROUND((COUNT(CASE WHEN tp.status_periksa = 1 THEN 1 END) * 100.0 / COUNT(*)), 2) as tingkat_completion
FROM tb_dokter d
JOIN tb_poli p ON d.id_poli = p.id_poli
JOIN tb_pendaftaran pd ON d.id_dokter = pd.id_dokter
JOIN tb_pemeriksaan tp ON pd.id_pendaftaran = tp.id_pendaftaran
WHERE MONTH(tp.tgl_pemeriksaan) = MONTH(NOW()) 
  AND YEAR(tp.tgl_pemeriksaan) = YEAR(NOW())
GROUP BY d.id_dokter, d.nm_dokter, p.nm_poli
ORDER BY total_pemeriksaan DESC;

--
-- View: Statistik Keluhan Pasien
--

CREATE VIEW `view_keluhan_stats` AS
SELECT 
    keluhan,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM tb_pemeriksaan WHERE MONTH(tgl_pemeriksaan) = MONTH(NOW()))), 2) as persentase,
    ROUND(AVG(durasi_pemeriksaan), 1) as rata_durasi_periksa
FROM tb_pemeriksaan 
WHERE MONTH(tgl_pemeriksaan) = MONTH(NOW()) 
  AND YEAR(tgl_pemeriksaan) = YEAR(NOW())
  AND keluhan IS NOT NULL
GROUP BY keluhan
ORDER BY jumlah DESC
LIMIT 15;

--
-- View: Trend Pemeriksaan Harian
--

CREATE VIEW `view_pemeriksaan_trend_harian` AS
SELECT 
    tgl_pemeriksaan,
    DAYNAME(tgl_pemeriksaan) as hari,
    COUNT(*) as total_pemeriksaan,
    COUNT(CASE WHEN status_periksa = 1 THEN 1 END) as selesai,
    COUNT(CASE WHEN status_periksa = 0 THEN 1 END) as pending,
    SUM(biaya_pemeriksaan) as pendapatan_harian,
    ROUND(AVG(durasi_pemeriksaan), 1) as rata_durasi
FROM tb_pemeriksaan 
WHERE tgl_pemeriksaan >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY tgl_pemeriksaan
ORDER BY tgl_pemeriksaan DESC;

--
-- View: Analisis Poli Terpopuler
--

CREATE VIEW `view_poli_popular_pemeriksaan` AS
SELECT 
    p.nm_poli,
    COUNT(*) as total_pemeriksaan,
    COUNT(CASE WHEN tp.status_periksa = 1 THEN 1 END) as pemeriksaan_selesai,
    ROUND(AVG(tp.durasi_pemeriksaan), 1) as rata_durasi,
    SUM(tp.biaya_pemeriksaan) as total_pendapatan,
    ROUND(AVG(tp.biaya_pemeriksaan), 0) as rata_biaya_per_pemeriksaan
FROM tb_poli p
JOIN tb_pendaftaran pd ON p.id_poli = pd.id_poli
JOIN tb_pemeriksaan tp ON pd.id_pendaftaran = tp.id_pendaftaran
WHERE MONTH(tp.tgl_pemeriksaan) = MONTH(NOW()) 
  AND YEAR(tp.tgl_pemeriksaan) = YEAR(NOW())
GROUP BY p.id_poli, p.nm_poli
ORDER BY total_pemeriksaan DESC;

--
-- View: Insight Pemeriksaan Bulanan
--

CREATE VIEW `view_pemeriksaan_insights` AS
SELECT 
    DATE_FORMAT(tgl_pemeriksaan, '%Y-%m') as periode,
    COUNT(*) as total_pemeriksaan,
    COUNT(CASE WHEN status_periksa = 1 THEN 1 END) as selesai,
    COUNT(CASE WHEN status_periksa = 0 THEN 1 END) as pending,
    ROUND(AVG(durasi_pemeriksaan), 1) as rata_durasi,
    SUM(biaya_pemeriksaan) as total_pendapatan,
    (SELECT diagnosa FROM tb_pemeriksaan WHERE DATE_FORMAT(tgl_pemeriksaan, '%Y-%m') = periode GROUP BY diagnosa ORDER BY COUNT(*) DESC LIMIT 1) as diagnosa_terbanyak,
    ROUND((COUNT(CASE WHEN status_periksa = 1 THEN 1 END) * 100.0 / COUNT(*)), 2) as completion_rate
FROM tb_pemeriksaan 
WHERE tgl_pemeriksaan >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
GROUP BY DATE_FORMAT(tgl_pemeriksaan, '%Y-%m')
ORDER BY periode DESC;

--
-- View untuk dashboard metrics
--

-- View untuk menghitung total pasien
CREATE VIEW `v_total_pasien` AS
SELECT COUNT(*) as total_pasien FROM `pasien`;

-- View untuk menghitung total dokter aktif
CREATE VIEW `v_total_dokter_aktif` AS
SELECT COUNT(*) as total_dokter FROM `dokter` WHERE `status` = 'aktif';

-- View untuk menghitung obat stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT COUNT(*) as obat_kritis FROM `obat` WHERE `stok` <= `stok_minimum`;

-- View untuk keuntungan tahun ini
CREATE VIEW `v_keuntungan_tahun_ini` AS
SELECT SUM(keuntungan_bersih) as total_keuntungan 
FROM `keuntungan` 
WHERE `tahun` = YEAR(CURDATE());

-- View untuk pengeluaran tahun ini
CREATE VIEW `v_pengeluaran_tahun_ini` AS
SELECT SUM(jumlah) as total_pengeluaran 
FROM `pengeluaran` 
WHERE YEAR(tanggal) = YEAR(CURDATE());

-- View untuk pasien hari ini
CREATE VIEW `v_pasien_hari_ini` AS
SELECT COUNT(*) as pasien_hari_ini 
FROM `pendaftaran` 
WHERE DATE(tanggal_daftar) = CURDATE();

-- View untuk pemeriksaan selesai hari ini
CREATE VIEW `v_pemeriksaan_hari_ini` AS
SELECT COUNT(*) as pemeriksaan_selesai 
FROM `pemeriksaan` 
WHERE DATE(tanggal_periksa) = CURDATE() AND status = 'selesai';

-- View untuk pengeluaran hari ini
CREATE VIEW `v_pengeluaran_hari_ini` AS
SELECT COALESCE(SUM(jumlah), 0) as pengeluaran_hari_ini 
FROM `pengeluaran` 
WHERE DATE(tanggal) = CURDATE();

-- View untuk total dokter aktif (sesuai dokter.php)
CREATE VIEW `v_dokter_performance_summary` AS
SELECT 
    COUNT(CASE WHEN status = 'aktif' THEN 1 END) as total_dokter_aktif,
    COUNT(CASE WHEN status = 'nonaktif' THEN 1 END) as total_dokter_nonaktif,
    COUNT(CASE WHEN status = 'cuti' THEN 1 END) as total_dokter_cuti,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN kehadiran_persen END), 2) as rata_kehadiran,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN total_pasien_bulan END), 0) as rata_pasien_per_dokter,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN rating END), 2) as rata_rating_dokter
FROM `dokter`;

-- View untuk dokter dengan kinerja terbaik
CREATE VIEW `v_top_dokter_performance` AS
SELECT 
    d.id,
    d.nama,
    d.spesialisasi,
    d.total_jam_bulan,
    d.target_jam_bulan,
    d.kehadiran_persen,
    d.pertumbuhan_pasien_persen,
    d.total_pasien_bulan,
    d.rating,
    CASE 
        WHEN d.rating >= 4.8 AND d.kehadiran_persen >= 95 THEN 'Top Performer'
        WHEN d.rating >= 4.5 AND d.kehadiran_persen >= 90 THEN 'Sangat Baik'
        WHEN d.rating >= 4.0 AND d.kehadiran_persen >= 85 THEN 'Baik'
        WHEN d.rating >= 3.5 AND d.kehadiran_persen >= 80 THEN 'Cukup'
        ELSE 'Perlu Monitoring'
    END as kinerja_kategori
FROM `dokter` d
WHERE d.status = 'aktif'
ORDER BY d.rating DESC, d.kehadiran_persen DESC, d.total_pasien_bulan DESC
LIMIT 10;

-- View untuk jadwal dokter hari ini
CREATE VIEW `v_jadwal_dokter_hari_ini` AS
SELECT 
    d.nama as nama_dokter,
    d.spesialisasi,
    jd.shift,
    jd.jam_mulai,
    jd.jam_selesai,
    CASE 
        WHEN jd.shift = 'Overload' THEN 'danger'
        WHEN jd.shift = 'Double Shift' THEN 'danger'
        WHEN jd.shift = 'Sore' THEN 'warning'
        WHEN jd.shift = 'Malam' THEN 'info'
        ELSE 'success'
    END as badge_class
FROM `jadwal_dokter` jd
JOIN `dokter` d ON jd.dokter_id = d.id
WHERE jd.hari = CASE 
    WHEN DAYOFWEEK(CURDATE()) = 1 THEN 'Minggu'
    WHEN DAYOFWEEK(CURDATE()) = 2 THEN 'Senin'
    WHEN DAYOFWEEK(CURDATE()) = 3 THEN 'Selasa'
    WHEN DAYOFWEEK(CURDATE()) = 4 THEN 'Rabu'
    WHEN DAYOFWEEK(CURDATE()) = 5 THEN 'Kamis'
    WHEN DAYOFWEEK(CURDATE()) = 6 THEN 'Jumat'
    WHEN DAYOFWEEK(CURDATE()) = 7 THEN 'Sabtu'
END
AND jd.status = 'aktif'
AND d.status = 'aktif';

-- View untuk kehadiran dokter bulan ini
CREATE VIEW `v_kehadiran_dokter_bulan_ini` AS
SELECT 
    d.nama as nama_dokter,
    COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) as total_hadir,
    COUNT(CASE WHEN kd.status_kehadiran = 'izin' THEN 1 END) as total_izin,
    COUNT(CASE WHEN kd.status_kehadiran = 'sakit' THEN 1 END) as total_sakit,
    COUNT(CASE WHEN kd.status_kehadiran = 'alpha' THEN 1 END) as total_alpha,
    COUNT(*) as total_hari_kerja,
    ROUND((COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) / COUNT(*)) * 100, 2) as persentase_kehadiran
FROM `dokter` d
LEFT JOIN `kehadiran_dokter` kd ON d.id = kd.dokter_id 
    AND MONTH(kd.tanggal) = MONTH(CURDATE()) 
    AND YEAR(kd.tanggal) = YEAR(CURDATE())
WHERE d.status = 'aktif'
GROUP BY d.id, d.nama
ORDER BY persentase_kehadiran DESC;

-- View untuk ringkasan obat (sesuai obat.php)
CREATE VIEW `v_obat_summary` AS
SELECT 
    COUNT(*) as total_obat,
    COUNT(DISTINCT kategori) as total_kategori_penyakit,
    COUNT(DISTINCT bentuk_obat) as total_kategori_bentuk,
    COUNT(DISTINCT CONCAT(nama_obat, '-', kategori)) as total_jenis_unik,
    COUNT(CASE WHEN stok <= stok_minimum THEN 1 END) as obat_kritis,
    COUNT(CASE WHEN tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as obat_kadaluarsa
FROM `obat`;

-- View untuk distribusi bentuk obat (untuk chart)
CREATE VIEW `v_distribusi_bentuk_obat` AS
SELECT 
    bentuk_obat as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY bentuk_obat
ORDER BY jumlah DESC;

-- View untuk distribusi kategori penyakit (untuk chart)
CREATE VIEW `v_distribusi_kategori_penyakit` AS
SELECT 
    kategori as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY kategori
ORDER BY jumlah DESC;

-- View untuk top obat terlaris
CREATE VIEW `v_top_obat_terlaris` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.terjual_bulan_ini,
    o.satuan,
    o.stok as stok_tersisa,
    o.harga_jual as harga,
    o.supplier,
    o.trend_direction as trend,
    o.persentase_trend,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
ORDER BY o.terjual_bulan_ini DESC
LIMIT 10;

-- View untuk obat dengan stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.stok as stok_tersisa,
    o.stok_minimum,
    o.tanggal_expired as exp_date,
    o.supplier,
    o.last_restock_date,
    o.harga_jual as harga,
    CASE 
        WHEN o.stok = 0 THEN 'out_of_stock'
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 'critical'
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 'expiring'
        ELSE 'low'
    END as status,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
WHERE o.stok <= o.stok_minimum 
   OR o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
ORDER BY 
    CASE 
        WHEN o.stok = 0 THEN 1
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 2
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 3
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 4
        ELSE 5
    END,
    o.stok ASC;

-- View untuk sales tracking harian
CREATE VIEW `v_obat_sales_daily` AS
SELECT 
    o.nama_obat,
    o.sku,
    o.kategori,
    ost.tanggal_penjualan as tanggal,
    SUM(ost.jumlah_terjual) as total_terjual,
    SUM(ost.total_revenue) as total_revenue,
    AVG(ost.profit_margin) as avg_profit_margin
FROM `obat_sales_tracking` ost
JOIN `obat` o ON ost.obat_id = o.id
WHERE ost.tanggal_penjualan >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY o.id, ost.tanggal_penjualan
ORDER BY ost.tanggal_penjualan DESC, total_revenue DESC;

-- View untuk ringkasan pasien (sesuai pasien.php)
CREATE VIEW `v_pasien_summary` AS
SELECT 
    COUNT(DISTINCT p.id) as total_pasien,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru_bulan_ini,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali_bulan_ini,
    ROUND(AVG(pur.rating), 2) as rata_rating,
    COUNT(CASE WHEN pur.rating < 3.0 THEN 1 END) as rating_kurang_3,
    ROUND(
        (COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) THEN 1 END) - 
         COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END)) * 100.0 / 
        NULLIF(COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END), 0), 2
    ) as kenaikan_pasien_persen
FROM `pasien` p
LEFT JOIN `pasien_kunjungan_history` pkh ON p.id = pkh.pasien_id
LEFT JOIN `pasien_ulasan_rating` pur ON p.id = pur.pasien_id;

-- View untuk distribusi usia pasien (untuk chart)
CREATE VIEW `v_distribusi_usia_pasien` AS
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 12 THEN '0-12'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 24 THEN '13-24'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 45 THEN '25-45'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 65 THEN '46-65'
        ELSE '65+'
    END as kelompok_usia,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY kelompok_usia
ORDER BY 
    CASE kelompok_usia
        WHEN '0-12' THEN 1
        WHEN '13-24' THEN 2
        WHEN '25-45' THEN 3
        WHEN '46-65' THEN 4
        WHEN '65+' THEN 5
    END;

-- View untuk distribusi gender pasien (untuk chart)
CREATE VIEW `v_distribusi_gender_pasien` AS
SELECT 
    CASE p.jenis_kelamin
        WHEN 'L' THEN 'Laki-laki'
        WHEN 'P' THEN 'Perempuan'
        ELSE 'Lainnya'
    END as gender,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY p.jenis_kelamin;

-- View untuk ulasan pasien terbaru
CREATE VIEW `v_ulasan_pasien_terbaru` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.recommend_to_others,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
ORDER BY pur.tanggal_kunjungan DESC, pur.created_at DESC;

-- View untuk ulasan positif (rating >= 4)
CREATE VIEW `v_ulasan_positif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating >= 4.0
ORDER BY pur.rating DESC, pur.tanggal_kunjungan DESC;

-- View untuk ulasan negatif (rating < 4)
CREATE VIEW `v_ulasan_negatif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating < 4.0
ORDER BY pur.rating ASC, pur.tanggal_kunjungan DESC;

-- View untuk insights MIS pasien
CREATE VIEW `v_pasien_insights` AS
SELECT 
    pim.periode_bulan,
    pim.total_pasien,
    pim.pasien_baru,
    pim.pasien_kembali,
    pim.pertumbuhan_pasien_persen,
    pim.rata_rating,
    pim.rating_kurang_3,
    pim.rasio_pasien_pria_persen,
    pim.total_kunjungan,
    pim.rata_biaya_kunjungan,
    pim.tingkat_kepuasan_persen,
    pim.rekomendasi_persen,
    CASE 
        WHEN pim.pertumbuhan_pasien_persen < 0 THEN 'Menurun'
        WHEN pim.pertumbuhan_pasien_persen >= 10 THEN 'Tinggi'
        WHEN pim.pertumbuhan_pasien_persen >= 5 THEN 'Sedang'
        ELSE 'Rendah'
    END as kategori_pertumbuhan,
    CASE 
        WHEN pim.rata_rating >= 4.5 THEN 'Sangat Puas'
        WHEN pim.rata_rating >= 4.0 THEN 'Puas'
        WHEN pim.rata_rating >= 3.5 THEN 'Cukup'
        ELSE 'Perlu Perbaikan'
    END as kategori_kepuasan,
    CASE 
        WHEN pim.rasio_pasien_pria_persen < 40 THEN 'Perlu Program Khusus Pria'
        WHEN pim.rasio_pasien_pria_persen > 60 THEN 'Perlu Program Khusus Wanita'
        ELSE 'Seimbang'
    END as rekomendasi_gender
FROM `pasien_insights_metrics` pim
WHERE pim.periode_bulan = DATE_FORMAT(CURDATE(), '%Y-%m')
LIMIT 1;

-- View untuk kunjungan pasien hari ini
CREATE VIEW `v_kunjungan_hari_ini` AS
SELECT 
    p.nama as nama_pasien,
    p.no_rm,
    pkh.jenis_kunjungan,
    pkh.keluhan_utama,
    d.nama as nama_dokter,
    pkh.biaya_total,
    pkh.status_pembayaran,
    pkh.rating_kunjungan,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
LEFT JOIN `dokter` d ON pkh.dokter_id = d.id
WHERE DATE(pkh.tanggal_kunjungan) = CURDATE()
ORDER BY pkh.created_at DESC;

-- View untuk statistik pasien per bulan
CREATE VIEW `v_statistik_pasien_bulanan` AS
SELECT 
    DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m') as periode,
    COUNT(DISTINCT pkh.pasien_id) as total_pasien_unik,
    COUNT(*) as total_kunjungan,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali,
    AVG(pkh.biaya_total) as rata_biaya,
    AVG(pkh.rating_kunjungan) as rata_rating,
    COUNT(CASE WHEN p.jenis_kelamin = 'L' THEN 1 END) as total_pria,
    COUNT(CASE WHEN p.jenis_kelamin = 'P' THEN 1 END) as total_wanita
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
WHERE pkh.tanggal_kunjungan >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m')
ORDER BY periode DESC;

-- --------------------------------------------------------

--
-- Tabel Analitik untuk Pemeriksaan Dashboard
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_detail_analytics`
--

CREATE TABLE `pemeriksaan_detail_analytics` (
  `id` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `durasi_konsultasi` int(11) DEFAULT 0,
  `kategori_keluhan` enum('Demam','Batuk','Pusing','Mual','Flu','Pencernaan','Pernapasan','Jantung','Lainnya') DEFAULT 'Lainnya',
  `tingkat_urgensi` enum('Rendah','Sedang','Tinggi','Darurat') DEFAULT 'Rendah',
  `status_pemeriksaan` enum('Menunggu','Berlangsung','Selesai','Batal') DEFAULT 'Menunggu',
  `resep_diberikan` tinyint(1) DEFAULT 0,
  `biaya_konsultasi` decimal(10,2) DEFAULT 0.00,
  `rating_pelayanan` decimal(2,1) DEFAULT NULL,
  `catatan_khusus` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_detail_analytics`
--

INSERT INTO `pemeriksaan_detail_analytics` (`id`, `id_pemeriksaan`, `pasien_id`, `dokter_id`, `tanggal_periksa`, `jam_mulai`, `jam_selesai`, `durasi_konsultasi`, `kategori_keluhan`, `tingkat_urgensi`, `status_pemeriksaan`, `resep_diberikan`, `biaya_konsultasi`, `rating_pelayanan`, `catatan_khusus`) VALUES
(1, 1, 1, 1, '2025-07-08', '08:45:00', '09:00:00', 15, 'Demam', 'Sedang', 'Selesai', 1, 150000.00, 4.5, 'Pasien responsif terhadap pengobatan'),
(2, 2, 2, 2, '2025-07-08', '09:15:00', '09:35:00', 20, 'Pernapasan', 'Sedang', 'Selesai', 1, 175000.00, 4.2, 'Anak kooperatif selama pemeriksaan'),
(3, 3, 3, 1, '2025-07-08', '10:30:00', '10:55:00', 25, 'Jantung', 'Tinggi', 'Selesai', 1, 150000.00, 4.8, 'Perlu monitoring tekanan darah rutin'),
(4, 4, 4, 3, '2025-07-08', '10:00:00', '10:30:00', 30, 'Lainnya', 'Sedang', 'Selesai', 1, 200000.00, 4.0, 'Edukasi kebersihan gigi diberikan'),
(5, 5, 5, 4, '2025-07-08', '10:45:00', '11:20:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 300000.00, 4.7, 'Resep kacamata diberikan'),
(6, 6, 6, 5, '2025-07-08', '11:15:00', '11:40:00', 25, 'Lainnya', 'Sedang', 'Selesai', 1, 180000.00, 3.8, 'Alergi makanan perlu dihindari'),
(7, 7, 7, 6, '2025-07-08', '11:45:00', '12:25:00', 40, 'Jantung', 'Darurat', 'Selesai', 1, 250000.00, 4.9, 'Rujukan kardiolog segera'),
(8, 8, 8, 7, '2025-07-08', '12:15:00', '13:00:00', 45, 'Lainnya', 'Rendah', 'Selesai', 1, 350000.00, 4.6, 'Kehamilan berjalan normal'),
(9, 9, 9, 1, '2025-07-08', '13:30:00', '13:52:00', 22, 'Pernapasan', 'Sedang', 'Selesai', 1, 190000.00, 4.3, 'Hindari paparan asap rokok'),
(10, 10, 10, 2, '2025-07-08', '14:00:00', '14:18:00', 18, 'Demam', 'Tinggi', 'Selesai', 1, 160000.00, 4.1, 'Monitor suhu tubuh anak'),
(11, 11, 1, 1, '2025-07-09', '08:30:00', '08:50:00', 20, 'Flu', 'Sedang', 'Selesai', 1, 145000.00, 4.4, 'Kondisi membaik'),
(12, 12, 3, 1, '2025-07-09', '09:00:00', '09:25:00', 25, 'Pusing', 'Sedang', 'Selesai', 1, 155000.00, 4.2, 'Tekanan darah terkontrol'),
(13, 13, 5, 4, '2025-07-09', '10:00:00', '10:35:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 285000.00, 4.8, 'Kontrol mata rutin'),
(14, 14, 7, 6, '2025-07-09', '11:00:00', '11:30:00', 30, 'Jantung', 'Tinggi', 'Selesai', 1, 275000.00, 4.7, 'EKG hasil membaik'),
(15, 15, 9, 1, '2025-07-10', '08:45:00', '09:05:00', 20, 'Batuk', 'Sedang', 'Selesai', 1, 165000.00, 4.3, 'Batuk berkurang'),
(16, 16, 2, 2, '2025-07-10', '09:30:00', '09:55:00', 25, 'Demam', 'Sedang', 'Menunggu', 0, 140000.00, NULL, 'Menunggu hasil lab'),
(17, 17, 4, 3, '2025-07-10', '10:15:00', '10:45:00', 30, 'Lainnya', 'Rendah', 'Berlangsung', 0, 195000.00, NULL, 'Scaling gigi'),
(18, 18, 6, 5, '2025-07-10', '11:00:00', '11:20:00', 20, 'Lainnya', 'Rendah', 'Berlangsung', 0, 175000.00, NULL, 'Follow up dermatitis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_diagnosa_stats`
--

CREATE TABLE `pemeriksaan_diagnosa_stats` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `diagnosa` varchar(100) NOT NULL,
  `jumlah_kasus` int(11) DEFAULT 0,
  `persentase` decimal(5,2) DEFAULT 0.00,
  `tingkat_kesembuhan` decimal(5,2) DEFAULT 0.00,
  `rata_biaya` decimal(10,2) DEFAULT 0.00,
  `rata_durasi` int(11) DEFAULT 0,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `trend_bulanan` enum('naik','turun','stabil') DEFAULT 'stabil',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_diagnosa_stats`
--

INSERT INTO `pemeriksaan_diagnosa_stats` (`id`, `periode_bulan`, `diagnosa`, `jumlah_kasus`, `persentase`, `tingkat_kesembuhan`, `rata_biaya`, `rata_durasi`, `tingkat_kepuasan`, `trend_bulanan`) VALUES
(1, '2025-07', 'ISPA', 45, 22.50, 92.50, 168000.00, 22, 4.3, 'naik'),
(2, '2025-07', 'Demam', 38, 19.00, 95.20, 152000.00, 18, 4.2, 'stabil'),
(3, '2025-07', 'Hipertensi', 32, 16.00, 88.50, 165000.00, 25, 4.5, 'turun'),
(4, '2025-07', 'Gastritis', 28, 14.00, 89.30, 175000.00, 20, 4.1, 'stabil'),
(5, '2025-07', 'Dermatitis', 25, 12.50, 85.60, 182000.00, 28, 3.9, 'naik'),
(6, '2025-07', 'Miopia', 18, 9.00, 100.00, 285000.00, 35, 4.6, 'stabil'),
(7, '2025-07', 'Karies Dentis', 14, 7.00, 94.40, 195000.00, 30, 4.2, 'turun'),
(8, '2025-06', 'ISPA', 42, 21.00, 90.20, 162000.00, 20, 4.1, 'stabil'),
(9, '2025-06', 'Demam', 40, 20.00, 93.80, 148000.00, 17, 4.0, 'naik'),
(10, '2025-06', 'Hipertensi', 35, 17.50, 86.20, 160000.00, 24, 4.3, 'stabil'),
(11, '2025-06', 'Gastritis', 30, 15.00, 87.50, 170000.00, 22, 3.9, 'naik'),
(12, '2025-06', 'Dermatitis', 22, 11.00, 82.40, 178000.00, 26, 3.8, 'stabil'),
(13, '2025-06', 'Miopia', 16, 8.00, 100.00, 280000.00, 33, 4.5, 'turun'),
(14, '2025-06', 'Karies Dentis', 15, 7.50, 92.20, 188000.00, 28, 4.0, 'stabil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_waktu_tunggu_stats`
--

CREATE TABLE `pemeriksaan_waktu_tunggu_stats` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam` time NOT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0 COMMENT 'dalam menit',
  `jumlah_pasien` int(11) DEFAULT 0,
  `tingkat_kepuasan_waktu` decimal(3,2) DEFAULT 0.00,
  `status_antrian` enum('lancar','sedang','padat','sangat_padat') DEFAULT 'lancar',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_waktu_tunggu_stats`
--

INSERT INTO `pemeriksaan_waktu_tunggu_stats` (`id`, `tanggal`, `hari`, `jam`, `rata_waktu_tunggu`, `jumlah_pasien`, `tingkat_kepuasan_waktu`, `status_antrian`) VALUES
(1, '2025-07-07', 'Senin', '08:00:00', 10, 3, 4.2, 'lancar'),
(2, '2025-07-07', 'Senin', '09:00:00', 12, 5, 4.0, 'sedang'),
(3, '2025-07-07', 'Senin', '10:00:00', 13, 6, 3.8, 'sedang'),
(4, '2025-07-07', 'Senin', '11:00:00', 15, 7, 3.5, 'padat'),
(5, '2025-07-07', 'Senin', '17:00:00', 21, 9, 3.2, 'padat'),
(6, '2025-07-07', 'Senin', '18:00:00', 22, 10, 3.0, 'sangat_padat'),
(7, '2025-07-08', 'Selasa', '08:00:00', 9, 2, 4.3, 'lancar'),
(8, '2025-07-08', 'Selasa', '09:00:00', 10, 4, 4.1, 'lancar'),
(9, '2025-07-08', 'Selasa', '10:00:00', 12, 5, 3.9, 'sedang'),
(10, '2025-07-08', 'Selasa', '17:00:00', 20, 8, 3.3, 'padat'),
(11, '2025-07-08', 'Selasa', '18:00:00', 21, 9, 3.1, 'padat'),
(12, '2025-07-09', 'Rabu', '08:00:00', 8, 2, 4.4, 'lancar'),
(13, '2025-07-09', 'Rabu', '09:00:00', 9, 3, 4.2, 'lancar'),
(14, '2025-07-09', 'Rabu', '10:00:00', 11, 4, 4.0, 'sedang'),
(15, '2025-07-09', 'Rabu', '17:00:00', 20, 7, 3.4, 'padat'),
(16, '2025-07-09', 'Rabu', '18:00:00', 21, 8, 3.2, 'padat'),
(17, '2025-07-10', 'Kamis', '08:00:00', 11, 4, 3.9, 'sedang'),
(18, '2025-07-10', 'Kamis', '09:00:00', 12, 5, 3.7, 'sedang'),
(19, '2025-07-10', 'Kamis', '10:00:00', 14, 6, 3.5, 'padat'),
(20, '2025-07-10', 'Kamis', '17:00:00', 22, 9, 3.1, 'padat'),
(21, '2025-07-10', 'Kamis', '18:00:00', 23, 10, 2.9, 'sangat_padat'),
(22, '2025-07-11', 'Jumat', '08:00:00', 13, 5, 3.6, 'sedang'),
(23, '2025-07-11', 'Jumat', '09:00:00', 14, 6, 3.4, 'sedang'),
(24, '2025-07-11', 'Jumat', '10:00:00', 15, 7, 3.2, 'padat'),
(25, '2025-07-11', 'Jumat', '17:00:00', 25, 12, 2.8, 'sangat_padat'),
(26, '2025-07-11', 'Jumat', '18:00:00', 27, 14, 2.5, 'sangat_padat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_monthly_insights`
--

CREATE TABLE `pemeriksaan_monthly_insights` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `total_pemeriksaan` int(11) DEFAULT 0,
  `rata_durasi_konsultasi` int(11) DEFAULT 0,
  `total_pendapatan` decimal(12,2) DEFAULT 0.00,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `pemeriksaan_selesai` int(11) DEFAULT 0,
  `pemeriksaan_batal` int(11) DEFAULT 0,
  `diagnosa_terbanyak` varchar(100) DEFAULT NULL,
  `jam_tersibuk` time DEFAULT NULL,
  `hari_tersibuk` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0,
  `jumlah_rujukan` int(11) DEFAULT 0,
  `tingkat_kedatangan_ulang` decimal(5,2) DEFAULT 0.00,
  `efisiensi_pelayanan` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_monthly_insights`
--

INSERT INTO `pemeriksaan_monthly_insights` (`id`, `periode_bulan`, `total_pemeriksaan`, `rata_durasi_konsultasi`, `total_pendapatan`, `tingkat_kepuasan`, `pemeriksaan_selesai`, `pemeriksaan_batal`, `diagnosa_terbanyak`, `jam_tersibuk`, `hari_tersibuk`, `rata_waktu_tunggu`, `jumlah_rujukan`, `tingkat_kedatangan_ulang`, `efisiensi_pelayanan`) VALUES
(1, '2025-07', 200, 25, 36500000.00, 4.2, 185, 15, 'ISPA', '18:00:00', 'Jumat', 16, 22, 32.50, 87.20),
(2, '2025-06', 180, 23, 32400000.00, 4.1, 168, 12, 'Demam', '17:30:00', 'Jumat', 15, 18, 28.70, 85.60),
(3, '2025-05', 165, 24, 29800000.00, 4.0, 155, 10, 'ISPA', '18:00:00', 'Kamis', 17, 15, 25.40, 83.90),
(4, '2025-04', 155, 22, 27600000.00, 3.9, 148, 7, 'Gastritis', '17:00:00', 'Jumat', 14, 12, 22.80, 86.40);

-- --------------------------------------------------------

--
-- Index dan Auto Increment untuk tabel pemeriksaan
--

--
-- Indexes for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD UNIQUE KEY `kd_pemeriksaan` (`kd_pemeriksaan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `tgl_pemeriksaan` (`tgl_pemeriksaan`),
  ADD KEY `status_periksa` (`status_periksa`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `kd_pendaftaran` (`kd_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`),
  ADD KEY `tgl_pendaftaran` (`tgl_pendaftaran`);

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `nm_pasien` (`nm_pasien`),
  ADD KEY `jk_pasien` (`jk_pasien`);

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `nm_dokter` (`nm_dokter`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tb_poli`
--
ALTER TABLE `tb_poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `nm_poli` (`nm_poli`);

--
-- Indexes for table `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemeriksaan` (`id_pemeriksaan`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `tanggal_periksa` (`tanggal_periksa`),
  ADD KEY `kategori_keluhan` (`kategori_keluhan`),
  ADD KEY `status_pemeriksaan` (`status_pemeriksaan`);

--
-- Indexes for table `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periode_bulan` (`periode_bulan`),
  ADD KEY `diagnosa` (`diagnosa`);

--
-- Indexes for table `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `hari` (`hari`),
  ADD KEY `jam` (`jam`);

--
-- Indexes for table `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode_bulan` (`periode_bulan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pasien`
--
ALTER TABLE `tb_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_poli`
--
ALTER TABLE `tb_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Foreign Key untuk tabel pemeriksaan
--

--
-- Ketidakleluasaan untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tb_dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_3` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD CONSTRAINT `tb_dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE SET NULL;

COMMIT;

--
-- View untuk dashboard metrics
--

-- View untuk menghitung total pasien
CREATE VIEW `v_total_pasien` AS
SELECT COUNT(*) as total_pasien FROM `pasien`;

-- View untuk menghitung total dokter aktif
CREATE VIEW `v_total_dokter_aktif` AS
SELECT COUNT(*) as total_dokter FROM `dokter` WHERE `status` = 'aktif';

-- View untuk menghitung obat stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT COUNT(*) as obat_kritis FROM `obat` WHERE `stok` <= `stok_minimum`;

-- View untuk keuntungan tahun ini
CREATE VIEW `v_keuntungan_tahun_ini` AS
SELECT SUM(keuntungan_bersih) as total_keuntungan 
FROM `keuntungan` 
WHERE `tahun` = YEAR(CURDATE());

-- View untuk pengeluaran tahun ini
CREATE VIEW `v_pengeluaran_tahun_ini` AS
SELECT SUM(jumlah) as total_pengeluaran 
FROM `pengeluaran` 
WHERE YEAR(tanggal) = YEAR(CURDATE());

-- View untuk pasien hari ini
CREATE VIEW `v_pasien_hari_ini` AS
SELECT COUNT(*) as pasien_hari_ini 
FROM `pendaftaran` 
WHERE DATE(tanggal_daftar) = CURDATE();

-- View untuk pemeriksaan selesai hari ini
CREATE VIEW `v_pemeriksaan_hari_ini` AS
SELECT COUNT(*) as pemeriksaan_selesai 
FROM `pemeriksaan` 
WHERE DATE(tanggal_periksa) = CURDATE() AND status = 'selesai';

-- View untuk pengeluaran hari ini
CREATE VIEW `v_pengeluaran_hari_ini` AS
SELECT COALESCE(SUM(jumlah), 0) as pengeluaran_hari_ini 
FROM `pengeluaran` 
WHERE DATE(tanggal) = CURDATE();

-- View untuk total dokter aktif (sesuai dokter.php)
CREATE VIEW `v_dokter_performance_summary` AS
SELECT 
    COUNT(CASE WHEN status = 'aktif' THEN 1 END) as total_dokter_aktif,
    COUNT(CASE WHEN status = 'nonaktif' THEN 1 END) as total_dokter_nonaktif,
    COUNT(CASE WHEN status = 'cuti' THEN 1 END) as total_dokter_cuti,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN kehadiran_persen END), 2) as rata_kehadiran,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN total_pasien_bulan END), 0) as rata_pasien_per_dokter,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN rating END), 2) as rata_rating_dokter
FROM `dokter`;

-- View untuk dokter dengan kinerja terbaik
CREATE VIEW `v_top_dokter_performance` AS
SELECT 
    d.id,
    d.nama,
    d.spesialisasi,
    d.total_jam_bulan,
    d.target_jam_bulan,
    d.kehadiran_persen,
    d.pertumbuhan_pasien_persen,
    d.total_pasien_bulan,
    d.rating,
    CASE 
        WHEN d.rating >= 4.8 AND d.kehadiran_persen >= 95 THEN 'Top Performer'
        WHEN d.rating >= 4.5 AND d.kehadiran_persen >= 90 THEN 'Sangat Baik'
        WHEN d.rating >= 4.0 AND d.kehadiran_persen >= 85 THEN 'Baik'
        WHEN d.rating >= 3.5 AND d.kehadiran_persen >= 80 THEN 'Cukup'
        ELSE 'Perlu Monitoring'
    END as kinerja_kategori
FROM `dokter` d
WHERE d.status = 'aktif'
ORDER BY d.rating DESC, d.kehadiran_persen DESC, d.total_pasien_bulan DESC
LIMIT 10;

-- View untuk jadwal dokter hari ini
CREATE VIEW `v_jadwal_dokter_hari_ini` AS
SELECT 
    d.nama as nama_dokter,
    d.spesialisasi,
    jd.shift,
    jd.jam_mulai,
    jd.jam_selesai,
    CASE 
        WHEN jd.shift = 'Overload' THEN 'danger'
        WHEN jd.shift = 'Double Shift' THEN 'danger'
        WHEN jd.shift = 'Sore' THEN 'warning'
        WHEN jd.shift = 'Malam' THEN 'info'
        ELSE 'success'
    END as badge_class
FROM `jadwal_dokter` jd
JOIN `dokter` d ON jd.dokter_id = d.id
WHERE jd.hari = CASE 
    WHEN DAYOFWEEK(CURDATE()) = 1 THEN 'Minggu'
    WHEN DAYOFWEEK(CURDATE()) = 2 THEN 'Senin'
    WHEN DAYOFWEEK(CURDATE()) = 3 THEN 'Selasa'
    WHEN DAYOFWEEK(CURDATE()) = 4 THEN 'Rabu'
    WHEN DAYOFWEEK(CURDATE()) = 5 THEN 'Kamis'
    WHEN DAYOFWEEK(CURDATE()) = 6 THEN 'Jumat'
    WHEN DAYOFWEEK(CURDATE()) = 7 THEN 'Sabtu'
END
AND jd.status = 'aktif'
AND d.status = 'aktif';

-- View untuk kehadiran dokter bulan ini
CREATE VIEW `v_kehadiran_dokter_bulan_ini` AS
SELECT 
    d.nama as nama_dokter,
    COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) as total_hadir,
    COUNT(CASE WHEN kd.status_kehadiran = 'izin' THEN 1 END) as total_izin,
    COUNT(CASE WHEN kd.status_kehadiran = 'sakit' THEN 1 END) as total_sakit,
    COUNT(CASE WHEN kd.status_kehadiran = 'alpha' THEN 1 END) as total_alpha,
    COUNT(*) as total_hari_kerja,
    ROUND((COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) / COUNT(*)) * 100, 2) as persentase_kehadiran
FROM `dokter` d
LEFT JOIN `kehadiran_dokter` kd ON d.id = kd.dokter_id 
    AND MONTH(kd.tanggal) = MONTH(CURDATE()) 
    AND YEAR(kd.tanggal) = YEAR(CURDATE())
WHERE d.status = 'aktif'
GROUP BY d.id, d.nama
ORDER BY persentase_kehadiran DESC;

-- View untuk ringkasan obat (sesuai obat.php)
CREATE VIEW `v_obat_summary` AS
SELECT 
    COUNT(*) as total_obat,
    COUNT(DISTINCT kategori) as total_kategori_penyakit,
    COUNT(DISTINCT bentuk_obat) as total_kategori_bentuk,
    COUNT(DISTINCT CONCAT(nama_obat, '-', kategori)) as total_jenis_unik,
    COUNT(CASE WHEN stok <= stok_minimum THEN 1 END) as obat_kritis,
    COUNT(CASE WHEN tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as obat_kadaluarsa
FROM `obat`;

-- View untuk distribusi bentuk obat (untuk chart)
CREATE VIEW `v_distribusi_bentuk_obat` AS
SELECT 
    bentuk_obat as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY bentuk_obat
ORDER BY jumlah DESC;

-- View untuk distribusi kategori penyakit (untuk chart)
CREATE VIEW `v_distribusi_kategori_penyakit` AS
SELECT 
    kategori as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY kategori
ORDER BY jumlah DESC;

-- View untuk top obat terlaris
CREATE VIEW `v_top_obat_terlaris` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.terjual_bulan_ini,
    o.satuan,
    o.stok as stok_tersisa,
    o.harga_jual as harga,
    o.supplier,
    o.trend_direction as trend,
    o.persentase_trend,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
ORDER BY o.terjual_bulan_ini DESC
LIMIT 10;

-- View untuk obat dengan stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.stok as stok_tersisa,
    o.stok_minimum,
    o.tanggal_expired as exp_date,
    o.supplier,
    o.last_restock_date,
    o.harga_jual as harga,
    CASE 
        WHEN o.stok = 0 THEN 'out_of_stock'
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 'critical'
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 'expiring'
        ELSE 'low'
    END as status,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
WHERE o.stok <= o.stok_minimum 
   OR o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
ORDER BY 
    CASE 
        WHEN o.stok = 0 THEN 1
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 2
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 3
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 4
        ELSE 5
    END,
    o.stok ASC;

-- View untuk sales tracking harian
CREATE VIEW `v_obat_sales_daily` AS
SELECT 
    o.nama_obat,
    o.sku,
    o.kategori,
    ost.tanggal_penjualan as tanggal,
    SUM(ost.jumlah_terjual) as total_terjual,
    SUM(ost.total_revenue) as total_revenue,
    AVG(ost.profit_margin) as avg_profit_margin
FROM `obat_sales_tracking` ost
JOIN `obat` o ON ost.obat_id = o.id
WHERE ost.tanggal_penjualan >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY o.id, ost.tanggal_penjualan
ORDER BY ost.tanggal_penjualan DESC, total_revenue DESC;

-- View untuk ringkasan pasien (sesuai pasien.php)
CREATE VIEW `v_pasien_summary` AS
SELECT 
    COUNT(DISTINCT p.id) as total_pasien,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru_bulan_ini,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali_bulan_ini,
    ROUND(AVG(pur.rating), 2) as rata_rating,
    COUNT(CASE WHEN pur.rating < 3.0 THEN 1 END) as rating_kurang_3,
    ROUND(
        (COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) THEN 1 END) - 
         COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END)) * 100.0 / 
        NULLIF(COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END), 0), 2
    ) as kenaikan_pasien_persen
FROM `pasien` p
LEFT JOIN `pasien_kunjungan_history` pkh ON p.id = pkh.pasien_id
LEFT JOIN `pasien_ulasan_rating` pur ON p.id = pur.pasien_id;

-- View untuk distribusi usia pasien (untuk chart)
CREATE VIEW `v_distribusi_usia_pasien` AS
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 12 THEN '0-12'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 24 THEN '13-24'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 45 THEN '25-45'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 65 THEN '46-65'
        ELSE '65+'
    END as kelompok_usia,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY kelompok_usia
ORDER BY 
    CASE kelompok_usia
        WHEN '0-12' THEN 1
        WHEN '13-24' THEN 2
        WHEN '25-45' THEN 3
        WHEN '46-65' THEN 4
        WHEN '65+' THEN 5
    END;

-- View untuk distribusi gender pasien (untuk chart)
CREATE VIEW `v_distribusi_gender_pasien` AS
SELECT 
    CASE p.jenis_kelamin
        WHEN 'L' THEN 'Laki-laki'
        WHEN 'P' THEN 'Perempuan'
        ELSE 'Lainnya'
    END as gender,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY p.jenis_kelamin;

-- View untuk ulasan pasien terbaru
CREATE VIEW `v_ulasan_pasien_terbaru` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.recommend_to_others,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
ORDER BY pur.tanggal_kunjungan DESC, pur.created_at DESC;

-- View untuk ulasan positif (rating >= 4)
CREATE VIEW `v_ulasan_positif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating >= 4.0
ORDER BY pur.rating DESC, pur.tanggal_kunjungan DESC;

-- View untuk ulasan negatif (rating < 4)
CREATE VIEW `v_ulasan_negatif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating < 4.0
ORDER BY pur.rating ASC, pur.tanggal_kunjungan DESC;

-- View untuk insights MIS pasien
CREATE VIEW `v_pasien_insights` AS
SELECT 
    pim.periode_bulan,
    pim.total_pasien,
    pim.pasien_baru,
    pim.pasien_kembali,
    pim.pertumbuhan_pasien_persen,
    pim.rata_rating,
    pim.rating_kurang_3,
    pim.rasio_pasien_pria_persen,
    pim.total_kunjungan,
    pim.rata_biaya_kunjungan,
    pim.tingkat_kepuasan_persen,
    pim.rekomendasi_persen,
    CASE 
        WHEN pim.pertumbuhan_pasien_persen < 0 THEN 'Menurun'
        WHEN pim.pertumbuhan_pasien_persen >= 10 THEN 'Tinggi'
        WHEN pim.pertumbuhan_pasien_persen >= 5 THEN 'Sedang'
        ELSE 'Rendah'
    END as kategori_pertumbuhan,
    CASE 
        WHEN pim.rata_rating >= 4.5 THEN 'Sangat Puas'
        WHEN pim.rata_rating >= 4.0 THEN 'Puas'
        WHEN pim.rata_rating >= 3.5 THEN 'Cukup'
        ELSE 'Perlu Perbaikan'
    END as kategori_kepuasan,
    CASE 
        WHEN pim.rasio_pasien_pria_persen < 40 THEN 'Perlu Program Khusus Pria'
        WHEN pim.rasio_pasien_pria_persen > 60 THEN 'Perlu Program Khusus Wanita'
        ELSE 'Seimbang'
    END as rekomendasi_gender
FROM `pasien_insights_metrics` pim
WHERE pim.periode_bulan = DATE_FORMAT(CURDATE(), '%Y-%m')
LIMIT 1;

-- View untuk kunjungan pasien hari ini
CREATE VIEW `v_kunjungan_hari_ini` AS
SELECT 
    p.nama as nama_pasien,
    p.no_rm,
    pkh.jenis_kunjungan,
    pkh.keluhan_utama,
    d.nama as nama_dokter,
    pkh.biaya_total,
    pkh.status_pembayaran,
    pkh.rating_kunjungan,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
LEFT JOIN `dokter` d ON pkh.dokter_id = d.id
WHERE DATE(pkh.tanggal_kunjungan) = CURDATE()
ORDER BY pkh.created_at DESC;

-- View untuk statistik pasien per bulan
CREATE VIEW `v_statistik_pasien_bulanan` AS
SELECT 
    DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m') as periode,
    COUNT(DISTINCT pkh.pasien_id) as total_pasien_unik,
    COUNT(*) as total_kunjungan,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali,
    AVG(pkh.biaya_total) as rata_biaya,
    AVG(pkh.rating_kunjungan) as rata_rating,
    COUNT(CASE WHEN p.jenis_kelamin = 'L' THEN 1 END) as total_pria,
    COUNT(CASE WHEN p.jenis_kelamin = 'P' THEN 1 END) as total_wanita
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
WHERE pkh.tanggal_kunjungan >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m')
ORDER BY periode DESC;

-- --------------------------------------------------------

--
-- Tabel Analitik untuk Pemeriksaan Dashboard
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_detail_analytics`
--

CREATE TABLE `pemeriksaan_detail_analytics` (
  `id` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `durasi_konsultasi` int(11) DEFAULT 0,
  `kategori_keluhan` enum('Demam','Batuk','Pusing','Mual','Flu','Pencernaan','Pernapasan','Jantung','Lainnya') DEFAULT 'Lainnya',
  `tingkat_urgensi` enum('Rendah','Sedang','Tinggi','Darurat') DEFAULT 'Rendah',
  `status_pemeriksaan` enum('Menunggu','Berlangsung','Selesai','Batal') DEFAULT 'Menunggu',
  `resep_diberikan` tinyint(1) DEFAULT 0,
  `biaya_konsultasi` decimal(10,2) DEFAULT 0.00,
  `rating_pelayanan` decimal(2,1) DEFAULT NULL,
  `catatan_khusus` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_detail_analytics`
--

INSERT INTO `pemeriksaan_detail_analytics` (`id`, `id_pemeriksaan`, `pasien_id`, `dokter_id`, `tanggal_periksa`, `jam_mulai`, `jam_selesai`, `durasi_konsultasi`, `kategori_keluhan`, `tingkat_urgensi`, `status_pemeriksaan`, `resep_diberikan`, `biaya_konsultasi`, `rating_pelayanan`, `catatan_khusus`) VALUES
(1, 1, 1, 1, '2025-07-08', '08:45:00', '09:00:00', 15, 'Demam', 'Sedang', 'Selesai', 1, 150000.00, 4.5, 'Pasien responsif terhadap pengobatan'),
(2, 2, 2, 2, '2025-07-08', '09:15:00', '09:35:00', 20, 'Pernapasan', 'Sedang', 'Selesai', 1, 175000.00, 4.2, 'Anak kooperatif selama pemeriksaan'),
(3, 3, 3, 1, '2025-07-08', '10:30:00', '10:55:00', 25, 'Jantung', 'Tinggi', 'Selesai', 1, 150000.00, 4.8, 'Perlu monitoring tekanan darah rutin'),
(4, 4, 4, 3, '2025-07-08', '10:00:00', '10:30:00', 30, 'Lainnya', 'Sedang', 'Selesai', 1, 200000.00, 4.0, 'Edukasi kebersihan gigi diberikan'),
(5, 5, 5, 4, '2025-07-08', '10:45:00', '11:20:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 300000.00, 4.7, 'Resep kacamata diberikan'),
(6, 6, 6, 5, '2025-07-08', '11:15:00', '11:40:00', 25, 'Lainnya', 'Sedang', 'Selesai', 1, 180000.00, 3.8, 'Alergi makanan perlu dihindari'),
(7, 7, 7, 6, '2025-07-08', '11:45:00', '12:25:00', 40, 'Jantung', 'Darurat', 'Selesai', 1, 250000.00, 4.9, 'Rujukan kardiolog segera'),
(8, 8, 8, 7, '2025-07-08', '12:15:00', '13:00:00', 45, 'Lainnya', 'Rendah', 'Selesai', 1, 350000.00, 4.6, 'Kehamilan berjalan normal'),
(9, 9, 9, 1, '2025-07-08', '13:30:00', '13:52:00', 22, 'Pernapasan', 'Sedang', 'Selesai', 1, 190000.00, 4.3, 'Hindari paparan asap rokok'),
(10, 10, 10, 2, '2025-07-08', '14:00:00', '14:18:00', 18, 'Demam', 'Tinggi', 'Selesai', 1, 160000.00, 4.1, 'Monitor suhu tubuh anak'),
(11, 11, 1, 1, '2025-07-09', '08:30:00', '08:50:00', 20, 'Flu', 'Sedang', 'Selesai', 1, 145000.00, 4.4, 'Kondisi membaik'),
(12, 12, 3, 1, '2025-07-09', '09:00:00', '09:25:00', 25, 'Pusing', 'Sedang', 'Selesai', 1, 155000.00, 4.2, 'Tekanan darah terkontrol'),
(13, 13, 5, 4, '2025-07-09', '10:00:00', '10:35:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 285000.00, 4.8, 'Kontrol mata rutin'),
(14, 14, 7, 6, '2025-07-09', '11:00:00', '11:30:00', 30, 'Jantung', 'Tinggi', 'Selesai', 1, 275000.00, 4.7, 'EKG hasil membaik'),
(15, 15, 9, 1, '2025-07-10', '08:45:00', '09:05:00', 20, 'Batuk', 'Sedang', 'Selesai', 1, 165000.00, 4.3, 'Batuk berkurang'),
(16, 16, 2, 2, '2025-07-10', '09:30:00', '09:55:00', 25, 'Demam', 'Sedang', 'Menunggu', 0, 140000.00, NULL, 'Menunggu hasil lab'),
(17, 17, 4, 3, '2025-07-10', '10:15:00', '10:45:00', 30, 'Lainnya', 'Rendah', 'Berlangsung', 0, 195000.00, NULL, 'Scaling gigi'),
(18, 18, 6, 5, '2025-07-10', '11:00:00', '11:20:00', 20, 'Lainnya', 'Rendah', 'Berlangsung', 0, 175000.00, NULL, 'Follow up dermatitis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_diagnosa_stats`
--

CREATE TABLE `pemeriksaan_diagnosa_stats` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `diagnosa` varchar(100) NOT NULL,
  `jumlah_kasus` int(11) DEFAULT 0,
  `persentase` decimal(5,2) DEFAULT 0.00,
  `tingkat_kesembuhan` decimal(5,2) DEFAULT 0.00,
  `rata_biaya` decimal(10,2) DEFAULT 0.00,
  `rata_durasi` int(11) DEFAULT 0,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `trend_bulanan` enum('naik','turun','stabil') DEFAULT 'stabil',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_diagnosa_stats`
--

INSERT INTO `pemeriksaan_diagnosa_stats` (`id`, `periode_bulan`, `diagnosa`, `jumlah_kasus`, `persentase`, `tingkat_kesembuhan`, `rata_biaya`, `rata_durasi`, `tingkat_kepuasan`, `trend_bulanan`) VALUES
(1, '2025-07', 'ISPA', 45, 22.50, 92.50, 168000.00, 22, 4.3, 'naik'),
(2, '2025-07', 'Demam', 38, 19.00, 95.20, 152000.00, 18, 4.2, 'stabil'),
(3, '2025-07', 'Hipertensi', 32, 16.00, 88.50, 165000.00, 25, 4.5, 'turun'),
(4, '2025-07', 'Gastritis', 28, 14.00, 89.30, 175000.00, 20, 4.1, 'stabil'),
(5, '2025-07', 'Dermatitis', 25, 12.50, 85.60, 182000.00, 28, 3.9, 'naik'),
(6, '2025-07', 'Miopia', 18, 9.00, 100.00, 285000.00, 35, 4.6, 'stabil'),
(7, '2025-07', 'Karies Dentis', 14, 7.00, 94.40, 195000.00, 30, 4.2, 'turun'),
(8, '2025-06', 'ISPA', 42, 21.00, 90.20, 162000.00, 20, 4.1, 'stabil'),
(9, '2025-06', 'Demam', 40, 20.00, 93.80, 148000.00, 17, 4.0, 'naik'),
(10, '2025-06', 'Hipertensi', 35, 17.50, 86.20, 160000.00, 24, 4.3, 'stabil'),
(11, '2025-06', 'Gastritis', 30, 15.00, 87.50, 170000.00, 22, 3.9, 'naik'),
(12, '2025-06', 'Dermatitis', 22, 11.00, 82.40, 178000.00, 26, 3.8, 'stabil'),
(13, '2025-06', 'Miopia', 16, 8.00, 100.00, 280000.00, 33, 4.5, 'turun'),
(14, '2025-06', 'Karies Dentis', 15, 7.50, 92.20, 188000.00, 28, 4.0, 'stabil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_waktu_tunggu_stats`
--

CREATE TABLE `pemeriksaan_waktu_tunggu_stats` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam` time NOT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0 COMMENT 'dalam menit',
  `jumlah_pasien` int(11) DEFAULT 0,
  `tingkat_kepuasan_waktu` decimal(3,2) DEFAULT 0.00,
  `status_antrian` enum('lancar','sedang','padat','sangat_padat') DEFAULT 'lancar',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_waktu_tunggu_stats`
--

INSERT INTO `pemeriksaan_waktu_tunggu_stats` (`id`, `tanggal`, `hari`, `jam`, `rata_waktu_tunggu`, `jumlah_pasien`, `tingkat_kepuasan_waktu`, `status_antrian`) VALUES
(1, '2025-07-07', 'Senin', '08:00:00', 10, 3, 4.2, 'lancar'),
(2, '2025-07-07', 'Senin', '09:00:00', 12, 5, 4.0, 'sedang'),
(3, '2025-07-07', 'Senin', '10:00:00', 13, 6, 3.8, 'sedang'),
(4, '2025-07-07', 'Senin', '11:00:00', 15, 7, 3.5, 'padat'),
(5, '2025-07-07', 'Senin', '17:00:00', 21, 9, 3.2, 'padat'),
(6, '2025-07-07', 'Senin', '18:00:00', 22, 10, 3.0, 'sangat_padat'),
(7, '2025-07-08', 'Selasa', '08:00:00', 9, 2, 4.3, 'lancar'),
(8, '2025-07-08', 'Selasa', '09:00:00', 10, 4, 4.1, 'lancar'),
(9, '2025-07-08', 'Selasa', '10:00:00', 12, 5, 3.9, 'sedang'),
(10, '2025-07-08', 'Selasa', '17:00:00', 20, 8, 3.3, 'padat'),
(11, '2025-07-08', 'Selasa', '18:00:00', 21, 9, 3.1, 'padat'),
(12, '2025-07-09', 'Rabu', '08:00:00', 8, 2, 4.4, 'lancar'),
(13, '2025-07-09', 'Rabu', '09:00:00', 9, 3, 4.2, 'lancar'),
(14, '2025-07-09', 'Rabu', '10:00:00', 11, 4, 4.0, 'sedang'),
(15, '2025-07-09', 'Rabu', '17:00:00', 20, 7, 3.4, 'padat'),
(16, '2025-07-09', 'Rabu', '18:00:00', 21, 8, 3.2, 'padat'),
(17, '2025-07-10', 'Kamis', '08:00:00', 11, 4, 3.9, 'sedang'),
(18, '2025-07-10', 'Kamis', '09:00:00', 12, 5, 3.7, 'sedang'),
(19, '2025-07-10', 'Kamis', '10:00:00', 14, 6, 3.5, 'padat'),
(20, '2025-07-10', 'Kamis', '17:00:00', 22, 9, 3.1, 'padat'),
(21, '2025-07-10', 'Kamis', '18:00:00', 23, 10, 2.9, 'sangat_padat'),
(22, '2025-07-11', 'Jumat', '08:00:00', 13, 5, 3.6, 'sedang'),
(23, '2025-07-11', 'Jumat', '09:00:00', 14, 6, 3.4, 'sedang'),
(24, '2025-07-11', 'Jumat', '10:00:00', 15, 7, 3.2, 'padat'),
(25, '2025-07-11', 'Jumat', '17:00:00', 25, 12, 2.8, 'sangat_padat'),
(26, '2025-07-11', 'Jumat', '18:00:00', 27, 14, 2.5, 'sangat_padat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_monthly_insights`
--

CREATE TABLE `pemeriksaan_monthly_insights` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `total_pemeriksaan` int(11) DEFAULT 0,
  `rata_durasi_konsultasi` int(11) DEFAULT 0,
  `total_pendapatan` decimal(12,2) DEFAULT 0.00,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `pemeriksaan_selesai` int(11) DEFAULT 0,
  `pemeriksaan_batal` int(11) DEFAULT 0,
  `diagnosa_terbanyak` varchar(100) DEFAULT NULL,
  `jam_tersibuk` time DEFAULT NULL,
  `hari_tersibuk` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0,
  `jumlah_rujukan` int(11) DEFAULT 0,
  `tingkat_kedatangan_ulang` decimal(5,2) DEFAULT 0.00,
  `efisiensi_pelayanan` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_monthly_insights`
--

INSERT INTO `pemeriksaan_monthly_insights` (`id`, `periode_bulan`, `total_pemeriksaan`, `rata_durasi_konsultasi`, `total_pendapatan`, `tingkat_kepuasan`, `pemeriksaan_selesai`, `pemeriksaan_batal`, `diagnosa_terbanyak`, `jam_tersibuk`, `hari_tersibuk`, `rata_waktu_tunggu`, `jumlah_rujukan`, `tingkat_kedatangan_ulang`, `efisiensi_pelayanan`) VALUES
(1, '2025-07', 200, 25, 36500000.00, 4.2, 185, 15, 'ISPA', '18:00:00', 'Jumat', 16, 22, 32.50, 87.20),
(2, '2025-06', 180, 23, 32400000.00, 4.1, 168, 12, 'Demam', '17:30:00', 'Jumat', 15, 18, 28.70, 85.60),
(3, '2025-05', 165, 24, 29800000.00, 4.0, 155, 10, 'ISPA', '18:00:00', 'Kamis', 17, 15, 25.40, 83.90),
(4, '2025-04', 155, 22, 27600000.00, 3.9, 148, 7, 'Gastritis', '17:00:00', 'Jumat', 14, 12, 22.80, 86.40);

-- --------------------------------------------------------

--
-- Index dan Auto Increment untuk tabel pemeriksaan
--

--
-- Indexes for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD UNIQUE KEY `kd_pemeriksaan` (`kd_pemeriksaan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `tgl_pemeriksaan` (`tgl_pemeriksaan`),
  ADD KEY `status_periksa` (`status_periksa`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `kd_pendaftaran` (`kd_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`),
  ADD KEY `tgl_pendaftaran` (`tgl_pendaftaran`);

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `nm_pasien` (`nm_pasien`),
  ADD KEY `jk_pasien` (`jk_pasien`);

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `nm_dokter` (`nm_dokter`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tb_poli`
--
ALTER TABLE `tb_poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `nm_poli` (`nm_poli`);

--
-- Indexes for table `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemeriksaan` (`id_pemeriksaan`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `tanggal_periksa` (`tanggal_periksa`),
  ADD KEY `kategori_keluhan` (`kategori_keluhan`),
  ADD KEY `status_pemeriksaan` (`status_pemeriksaan`);

--
-- Indexes for table `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periode_bulan` (`periode_bulan`),
  ADD KEY `diagnosa` (`diagnosa`);

--
-- Indexes for table `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `hari` (`hari`),
  ADD KEY `jam` (`jam`);

--
-- Indexes for table `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode_bulan` (`periode_bulan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pasien`
--
ALTER TABLE `tb_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_poli`
--
ALTER TABLE `tb_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Foreign Key untuk tabel pemeriksaan
--

--
-- Ketidakleluasaan untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tb_dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_3` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD CONSTRAINT `tb_dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE SET NULL;

COMMIT;

--
-- View untuk dashboard metrics
--

-- View untuk menghitung total pasien
CREATE VIEW `v_total_pasien` AS
SELECT COUNT(*) as total_pasien FROM `pasien`;

-- View untuk menghitung total dokter aktif
CREATE VIEW `v_total_dokter_aktif` AS
SELECT COUNT(*) as total_dokter FROM `dokter` WHERE `status` = 'aktif';

-- View untuk menghitung obat stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT COUNT(*) as obat_kritis FROM `obat` WHERE `stok` <= `stok_minimum`;

-- View untuk keuntungan tahun ini
CREATE VIEW `v_keuntungan_tahun_ini` AS
SELECT SUM(keuntungan_bersih) as total_keuntungan 
FROM `keuntungan` 
WHERE `tahun` = YEAR(CURDATE());

-- View untuk pengeluaran tahun ini
CREATE VIEW `v_pengeluaran_tahun_ini` AS
SELECT SUM(jumlah) as total_pengeluaran 
FROM `pengeluaran` 
WHERE YEAR(tanggal) = YEAR(CURDATE());

-- View untuk pasien hari ini
CREATE VIEW `v_pasien_hari_ini` AS
SELECT COUNT(*) as pasien_hari_ini 
FROM `pendaftaran` 
WHERE DATE(tanggal_daftar) = CURDATE();

-- View untuk pemeriksaan selesai hari ini
CREATE VIEW `v_pemeriksaan_hari_ini` AS
SELECT COUNT(*) as pemeriksaan_selesai 
FROM `pemeriksaan` 
WHERE DATE(tanggal_periksa) = CURDATE() AND status = 'selesai';

-- View untuk pengeluaran hari ini
CREATE VIEW `v_pengeluaran_hari_ini` AS
SELECT COALESCE(SUM(jumlah), 0) as pengeluaran_hari_ini 
FROM `pengeluaran` 
WHERE DATE(tanggal) = CURDATE();

-- View untuk total dokter aktif (sesuai dokter.php)
CREATE VIEW `v_dokter_performance_summary` AS
SELECT 
    COUNT(CASE WHEN status = 'aktif' THEN 1 END) as total_dokter_aktif,
    COUNT(CASE WHEN status = 'nonaktif' THEN 1 END) as total_dokter_nonaktif,
    COUNT(CASE WHEN status = 'cuti' THEN 1 END) as total_dokter_cuti,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN kehadiran_persen END), 2) as rata_kehadiran,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN total_pasien_bulan END), 0) as rata_pasien_per_dokter,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN rating END), 2) as rata_rating_dokter
FROM `dokter`;

-- View untuk dokter dengan kinerja terbaik
CREATE VIEW `v_top_dokter_performance` AS
SELECT 
    d.id,
    d.nama,
    d.spesialisasi,
    d.total_jam_bulan,
    d.target_jam_bulan,
    d.kehadiran_persen,
    d.pertumbuhan_pasien_persen,
    d.total_pasien_bulan,
    d.rating,
    CASE 
        WHEN d.rating >= 4.8 AND d.kehadiran_persen >= 95 THEN 'Top Performer'
        WHEN d.rating >= 4.5 AND d.kehadiran_persen >= 90 THEN 'Sangat Baik'
        WHEN d.rating >= 4.0 AND d.kehadiran_persen >= 85 THEN 'Baik'
        WHEN d.rating >= 3.5 AND d.kehadiran_persen >= 80 THEN 'Cukup'
        ELSE 'Perlu Monitoring'
    END as kinerja_kategori
FROM `dokter` d
WHERE d.status = 'aktif'
ORDER BY d.rating DESC, d.kehadiran_persen DESC, d.total_pasien_bulan DESC
LIMIT 10;

-- View untuk jadwal dokter hari ini
CREATE VIEW `v_jadwal_dokter_hari_ini` AS
SELECT 
    d.nama as nama_dokter,
    d.spesialisasi,
    jd.shift,
    jd.jam_mulai,
    jd.jam_selesai,
    CASE 
        WHEN jd.shift = 'Overload' THEN 'danger'
        WHEN jd.shift = 'Double Shift' THEN 'danger'
        WHEN jd.shift = 'Sore' THEN 'warning'
        WHEN jd.shift = 'Malam' THEN 'info'
        ELSE 'success'
    END as badge_class
FROM `jadwal_dokter` jd
JOIN `dokter` d ON jd.dokter_id = d.id
WHERE jd.hari = CASE 
    WHEN DAYOFWEEK(CURDATE()) = 1 THEN 'Minggu'
    WHEN DAYOFWEEK(CURDATE()) = 2 THEN 'Senin'
    WHEN DAYOFWEEK(CURDATE()) = 3 THEN 'Selasa'
    WHEN DAYOFWEEK(CURDATE()) = 4 THEN 'Rabu'
    WHEN DAYOFWEEK(CURDATE()) = 5 THEN 'Kamis'
    WHEN DAYOFWEEK(CURDATE()) = 6 THEN 'Jumat'
    WHEN DAYOFWEEK(CURDATE()) = 7 THEN 'Sabtu'
END
AND jd.status = 'aktif'
AND d.status = 'aktif';

-- View untuk kehadiran dokter bulan ini
CREATE VIEW `v_kehadiran_dokter_bulan_ini` AS
SELECT 
    d.nama as nama_dokter,
    COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) as total_hadir,
    COUNT(CASE WHEN kd.status_kehadiran = 'izin' THEN 1 END) as total_izin,
    COUNT(CASE WHEN kd.status_kehadiran = 'sakit' THEN 1 END) as total_sakit,
    COUNT(CASE WHEN kd.status_kehadiran = 'alpha' THEN 1 END) as total_alpha,
    COUNT(*) as total_hari_kerja,
    ROUND((COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) / COUNT(*)) * 100, 2) as persentase_kehadiran
FROM `dokter` d
LEFT JOIN `kehadiran_dokter` kd ON d.id = kd.dokter_id 
    AND MONTH(kd.tanggal) = MONTH(CURDATE()) 
    AND YEAR(kd.tanggal) = YEAR(CURDATE())
WHERE d.status = 'aktif'
GROUP BY d.id, d.nama
ORDER BY persentase_kehadiran DESC;

-- View untuk ringkasan obat (sesuai obat.php)
CREATE VIEW `v_obat_summary` AS
SELECT 
    COUNT(*) as total_obat,
    COUNT(DISTINCT kategori) as total_kategori_penyakit,
    COUNT(DISTINCT bentuk_obat) as total_kategori_bentuk,
    COUNT(DISTINCT CONCAT(nama_obat, '-', kategori)) as total_jenis_unik,
    COUNT(CASE WHEN stok <= stok_minimum THEN 1 END) as obat_kritis,
    COUNT(CASE WHEN tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as obat_kadaluarsa
FROM `obat`;

-- View untuk distribusi bentuk obat (untuk chart)
CREATE VIEW `v_distribusi_bentuk_obat` AS
SELECT 
    bentuk_obat as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY bentuk_obat
ORDER BY jumlah DESC;

-- View untuk distribusi kategori penyakit (untuk chart)
CREATE VIEW `v_distribusi_kategori_penyakit` AS
SELECT 
    kategori as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY kategori
ORDER BY jumlah DESC;

-- View untuk top obat terlaris
CREATE VIEW `v_top_obat_terlaris` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.terjual_bulan_ini,
    o.satuan,
    o.stok as stok_tersisa,
    o.harga_jual as harga,
    o.supplier,
    o.trend_direction as trend,
    o.persentase_trend,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
ORDER BY o.terjual_bulan_ini DESC
LIMIT 10;

-- View untuk obat dengan stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.stok as stok_tersisa,
    o.stok_minimum,
    o.tanggal_expired as exp_date,
    o.supplier,
    o.last_restock_date,
    o.harga_jual as harga,
    CASE 
        WHEN o.stok = 0 THEN 'out_of_stock'
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 'critical'
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 'expiring'
        ELSE 'low'
    END as status,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
WHERE o.stok <= o.stok_minimum 
   OR o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
ORDER BY 
    CASE 
        WHEN o.stok = 0 THEN 1
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 2
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 3
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 4
        ELSE 5
    END,
    o.stok ASC;

-- View untuk sales tracking harian
CREATE VIEW `v_obat_sales_daily` AS
SELECT 
    o.nama_obat,
    o.sku,
    o.kategori,
    ost.tanggal_penjualan as tanggal,
    SUM(ost.jumlah_terjual) as total_terjual,
    SUM(ost.total_revenue) as total_revenue,
    AVG(ost.profit_margin) as avg_profit_margin
FROM `obat_sales_tracking` ost
JOIN `obat` o ON ost.obat_id = o.id
WHERE ost.tanggal_penjualan >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY o.id, ost.tanggal_penjualan
ORDER BY ost.tanggal_penjualan DESC, total_revenue DESC;

-- View untuk ringkasan pasien (sesuai pasien.php)
CREATE VIEW `v_pasien_summary` AS
SELECT 
    COUNT(DISTINCT p.id) as total_pasien,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru_bulan_ini,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali_bulan_ini,
    ROUND(AVG(pur.rating), 2) as rata_rating,
    COUNT(CASE WHEN pur.rating < 3.0 THEN 1 END) as rating_kurang_3,
    ROUND(
        (COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) THEN 1 END) - 
         COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END)) * 100.0 / 
        NULLIF(COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END), 0), 2
    ) as kenaikan_pasien_persen
FROM `pasien` p
LEFT JOIN `pasien_kunjungan_history` pkh ON p.id = pkh.pasien_id
LEFT JOIN `pasien_ulasan_rating` pur ON p.id = pur.pasien_id;

-- View untuk distribusi usia pasien (untuk chart)
CREATE VIEW `v_distribusi_usia_pasien` AS
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 12 THEN '0-12'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 24 THEN '13-24'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 45 THEN '25-45'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 65 THEN '46-65'
        ELSE '65+'
    END as kelompok_usia,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY kelompok_usia
ORDER BY 
    CASE kelompok_usia
        WHEN '0-12' THEN 1
        WHEN '13-24' THEN 2
        WHEN '25-45' THEN 3
        WHEN '46-65' THEN 4
        WHEN '65+' THEN 5
    END;

-- View untuk distribusi gender pasien (untuk chart)
CREATE VIEW `v_distribusi_gender_pasien` AS
SELECT 
    CASE p.jenis_kelamin
        WHEN 'L' THEN 'Laki-laki'
        WHEN 'P' THEN 'Perempuan'
        ELSE 'Lainnya'
    END as gender,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY p.jenis_kelamin;

-- View untuk ulasan pasien terbaru
CREATE VIEW `v_ulasan_pasien_terbaru` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.recommend_to_others,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
ORDER BY pur.tanggal_kunjungan DESC, pur.created_at DESC;

-- View untuk ulasan positif (rating >= 4)
CREATE VIEW `v_ulasan_positif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating >= 4.0
ORDER BY pur.rating DESC, pur.tanggal_kunjungan DESC;

-- View untuk ulasan negatif (rating < 4)
CREATE VIEW `v_ulasan_negatif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating < 4.0
ORDER BY pur.rating ASC, pur.tanggal_kunjungan DESC;

-- View untuk insights MIS pasien
CREATE VIEW `v_pasien_insights` AS
SELECT 
    pim.periode_bulan,
    pim.total_pasien,
    pim.pasien_baru,
    pim.pasien_kembali,
    pim.pertumbuhan_pasien_persen,
    pim.rata_rating,
    pim.rating_kurang_3,
    pim.rasio_pasien_pria_persen,
    pim.total_kunjungan,
    pim.rata_biaya_kunjungan,
    pim.tingkat_kepuasan_persen,
    pim.rekomendasi_persen,
    CASE 
        WHEN pim.pertumbuhan_pasien_persen < 0 THEN 'Menurun'
        WHEN pim.pertumbuhan_pasien_persen >= 10 THEN 'Tinggi'
        WHEN pim.pertumbuhan_pasien_persen >= 5 THEN 'Sedang'
        ELSE 'Rendah'
    END as kategori_pertumbuhan,
    CASE 
        WHEN pim.rata_rating >= 4.5 THEN 'Sangat Puas'
        WHEN pim.rata_rating >= 4.0 THEN 'Puas'
        WHEN pim.rata_rating >= 3.5 THEN 'Cukup'
        ELSE 'Perlu Perbaikan'
    END as kategori_kepuasan,
    CASE 
        WHEN pim.rasio_pasien_pria_persen < 40 THEN 'Perlu Program Khusus Pria'
        WHEN pim.rasio_pasien_pria_persen > 60 THEN 'Perlu Program Khusus Wanita'
        ELSE 'Seimbang'
    END as rekomendasi_gender
FROM `pasien_insights_metrics` pim
WHERE pim.periode_bulan = DATE_FORMAT(CURDATE(), '%Y-%m')
LIMIT 1;

-- View untuk kunjungan pasien hari ini
CREATE VIEW `v_kunjungan_hari_ini` AS
SELECT 
    p.nama as nama_pasien,
    p.no_rm,
    pkh.jenis_kunjungan,
    pkh.keluhan_utama,
    d.nama as nama_dokter,
    pkh.biaya_total,
    pkh.status_pembayaran,
    pkh.rating_kunjungan,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
LEFT JOIN `dokter` d ON pkh.dokter_id = d.id
WHERE DATE(pkh.tanggal_kunjungan) = CURDATE()
ORDER BY pkh.created_at DESC;

-- View untuk statistik pasien per bulan
CREATE VIEW `v_statistik_pasien_bulanan` AS
SELECT 
    DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m') as periode,
    COUNT(DISTINCT pkh.pasien_id) as total_pasien_unik,
    COUNT(*) as total_kunjungan,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali,
    AVG(pkh.biaya_total) as rata_biaya,
    AVG(pkh.rating_kunjungan) as rata_rating,
    COUNT(CASE WHEN p.jenis_kelamin = 'L' THEN 1 END) as total_pria,
    COUNT(CASE WHEN p.jenis_kelamin = 'P' THEN 1 END) as total_wanita
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
WHERE pkh.tanggal_kunjungan >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m')
ORDER BY periode DESC;

-- --------------------------------------------------------

--
-- Tabel Analitik untuk Pemeriksaan Dashboard
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_detail_analytics`
--

CREATE TABLE `pemeriksaan_detail_analytics` (
  `id` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `durasi_konsultasi` int(11) DEFAULT 0,
  `kategori_keluhan` enum('Demam','Batuk','Pusing','Mual','Flu','Pencernaan','Pernapasan','Jantung','Lainnya') DEFAULT 'Lainnya',
  `tingkat_urgensi` enum('Rendah','Sedang','Tinggi','Darurat') DEFAULT 'Rendah',
  `status_pemeriksaan` enum('Menunggu','Berlangsung','Selesai','Batal') DEFAULT 'Menunggu',
  `resep_diberikan` tinyint(1) DEFAULT 0,
  `biaya_konsultasi` decimal(10,2) DEFAULT 0.00,
  `rating_pelayanan` decimal(2,1) DEFAULT NULL,
  `catatan_khusus` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_detail_analytics`
--

INSERT INTO `pemeriksaan_detail_analytics` (`id`, `id_pemeriksaan`, `pasien_id`, `dokter_id`, `tanggal_periksa`, `jam_mulai`, `jam_selesai`, `durasi_konsultasi`, `kategori_keluhan`, `tingkat_urgensi`, `status_pemeriksaan`, `resep_diberikan`, `biaya_konsultasi`, `rating_pelayanan`, `catatan_khusus`) VALUES
(1, 1, 1, 1, '2025-07-08', '08:45:00', '09:00:00', 15, 'Demam', 'Sedang', 'Selesai', 1, 150000.00, 4.5, 'Pasien responsif terhadap pengobatan'),
(2, 2, 2, 2, '2025-07-08', '09:15:00', '09:35:00', 20, 'Pernapasan', 'Sedang', 'Selesai', 1, 175000.00, 4.2, 'Anak kooperatif selama pemeriksaan'),
(3, 3, 3, 1, '2025-07-08', '10:30:00', '10:55:00', 25, 'Jantung', 'Tinggi', 'Selesai', 1, 150000.00, 4.8, 'Perlu monitoring tekanan darah rutin'),
(4, 4, 4, 3, '2025-07-08', '10:00:00', '10:30:00', 30, 'Lainnya', 'Sedang', 'Selesai', 1, 200000.00, 4.0, 'Edukasi kebersihan gigi diberikan'),
(5, 5, 5, 4, '2025-07-08', '10:45:00', '11:20:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 300000.00, 4.7, 'Resep kacamata diberikan'),
(6, 6, 6, 5, '2025-07-08', '11:15:00', '11:40:00', 25, 'Lainnya', 'Sedang', 'Selesai', 1, 180000.00, 3.8, 'Alergi makanan perlu dihindari'),
(7, 7, 7, 6, '2025-07-08', '11:45:00', '12:25:00', 40, 'Jantung', 'Darurat', 'Selesai', 1, 250000.00, 4.9, 'Rujukan kardiolog segera'),
(8, 8, 8, 7, '2025-07-08', '12:15:00', '13:00:00', 45, 'Lainnya', 'Rendah', 'Selesai', 1, 350000.00, 4.6, 'Kehamilan berjalan normal'),
(9, 9, 9, 1, '2025-07-08', '13:30:00', '13:52:00', 22, 'Pernapasan', 'Sedang', 'Selesai', 1, 190000.00, 4.3, 'Hindari paparan asap rokok'),
(10, 10, 10, 2, '2025-07-08', '14:00:00', '14:18:00', 18, 'Demam', 'Tinggi', 'Selesai', 1, 160000.00, 4.1, 'Monitor suhu tubuh anak'),
(11, 11, 1, 1, '2025-07-09', '08:30:00', '08:50:00', 20, 'Flu', 'Sedang', 'Selesai', 1, 145000.00, 4.4, 'Kondisi membaik'),
(12, 12, 3, 1, '2025-07-09', '09:00:00', '09:25:00', 25, 'Pusing', 'Sedang', 'Selesai', 1, 155000.00, 4.2, 'Tekanan darah terkontrol'),
(13, 13, 5, 4, '2025-07-09', '10:00:00', '10:35:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 285000.00, 4.8, 'Kontrol mata rutin'),
(14, 14, 7, 6, '2025-07-09', '11:00:00', '11:30:00', 30, 'Jantung', 'Tinggi', 'Selesai', 1, 275000.00, 4.7, 'EKG hasil membaik'),
(15, 15, 9, 1, '2025-07-10', '08:45:00', '09:05:00', 20, 'Batuk', 'Sedang', 'Selesai', 1, 165000.00, 4.3, 'Batuk berkurang'),
(16, 16, 2, 2, '2025-07-10', '09:30:00', '09:55:00', 25, 'Demam', 'Sedang', 'Menunggu', 0, 140000.00, NULL, 'Menunggu hasil lab'),
(17, 17, 4, 3, '2025-07-10', '10:15:00', '10:45:00', 30, 'Lainnya', 'Rendah', 'Berlangsung', 0, 195000.00, NULL, 'Scaling gigi'),
(18, 18, 6, 5, '2025-07-10', '11:00:00', '11:20:00', 20, 'Lainnya', 'Rendah', 'Berlangsung', 0, 175000.00, NULL, 'Follow up dermatitis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_diagnosa_stats`
--

CREATE TABLE `pemeriksaan_diagnosa_stats` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `diagnosa` varchar(100) NOT NULL,
  `jumlah_kasus` int(11) DEFAULT 0,
  `persentase` decimal(5,2) DEFAULT 0.00,
  `tingkat_kesembuhan` decimal(5,2) DEFAULT 0.00,
  `rata_biaya` decimal(10,2) DEFAULT 0.00,
  `rata_durasi` int(11) DEFAULT 0,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `trend_bulanan` enum('naik','turun','stabil') DEFAULT 'stabil',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_diagnosa_stats`
--

INSERT INTO `pemeriksaan_diagnosa_stats` (`id`, `periode_bulan`, `diagnosa`, `jumlah_kasus`, `persentase`, `tingkat_kesembuhan`, `rata_biaya`, `rata_durasi`, `tingkat_kepuasan`, `trend_bulanan`) VALUES
(1, '2025-07', 'ISPA', 45, 22.50, 92.50, 168000.00, 22, 4.3, 'naik'),
(2, '2025-07', 'Demam', 38, 19.00, 95.20, 152000.00, 18, 4.2, 'stabil'),
(3, '2025-07', 'Hipertensi', 32, 16.00, 88.50, 165000.00, 25, 4.5, 'turun'),
(4, '2025-07', 'Gastritis', 28, 14.00, 89.30, 175000.00, 20, 4.1, 'stabil'),
(5, '2025-07', 'Dermatitis', 25, 12.50, 85.60, 182000.00, 28, 3.9, 'naik'),
(6, '2025-07', 'Miopia', 18, 9.00, 100.00, 285000.00, 35, 4.6, 'stabil'),
(7, '2025-07', 'Karies Dentis', 14, 7.00, 94.40, 195000.00, 30, 4.2, 'turun'),
(8, '2025-06', 'ISPA', 42, 21.00, 90.20, 162000.00, 20, 4.1, 'stabil'),
(9, '2025-06', 'Demam', 40, 20.00, 93.80, 148000.00, 17, 4.0, 'naik'),
(10, '2025-06', 'Hipertensi', 35, 17.50, 86.20, 160000.00, 24, 4.3, 'stabil'),
(11, '2025-06', 'Gastritis', 30, 15.00, 87.50, 170000.00, 22, 3.9, 'naik'),
(12, '2025-06', 'Dermatitis', 22, 11.00, 82.40, 178000.00, 26, 3.8, 'stabil'),
(13, '2025-06', 'Miopia', 16, 8.00, 100.00, 280000.00, 33, 4.5, 'turun'),
(14, '2025-06', 'Karies Dentis', 15, 7.50, 92.20, 188000.00, 28, 4.0, 'stabil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_waktu_tunggu_stats`
--

CREATE TABLE `pemeriksaan_waktu_tunggu_stats` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam` time NOT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0 COMMENT 'dalam menit',
  `jumlah_pasien` int(11) DEFAULT 0,
  `tingkat_kepuasan_waktu` decimal(3,2) DEFAULT 0.00,
  `status_antrian` enum('lancar','sedang','padat','sangat_padat') DEFAULT 'lancar',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_waktu_tunggu_stats`
--

INSERT INTO `pemeriksaan_waktu_tunggu_stats` (`id`, `tanggal`, `hari`, `jam`, `rata_waktu_tunggu`, `jumlah_pasien`, `tingkat_kepuasan_waktu`, `status_antrian`) VALUES
(1, '2025-07-07', 'Senin', '08:00:00', 10, 3, 4.2, 'lancar'),
(2, '2025-07-07', 'Senin', '09:00:00', 12, 5, 4.0, 'sedang'),
(3, '2025-07-07', 'Senin', '10:00:00', 13, 6, 3.8, 'sedang'),
(4, '2025-07-07', 'Senin', '11:00:00', 15, 7, 3.5, 'padat'),
(5, '2025-07-07', 'Senin', '17:00:00', 21, 9, 3.2, 'padat'),
(6, '2025-07-07', 'Senin', '18:00:00', 22, 10, 3.0, 'sangat_padat'),
(7, '2025-07-08', 'Selasa', '08:00:00', 9, 2, 4.3, 'lancar'),
(8, '2025-07-08', 'Selasa', '09:00:00', 10, 4, 4.1, 'lancar'),
(9, '2025-07-08', 'Selasa', '10:00:00', 12, 5, 3.9, 'sedang'),
(10, '2025-07-08', 'Selasa', '17:00:00', 20, 8, 3.3, 'padat'),
(11, '2025-07-08', 'Selasa', '18:00:00', 21, 9, 3.1, 'padat'),
(12, '2025-07-09', 'Rabu', '08:00:00', 8, 2, 4.4, 'lancar'),
(13, '2025-07-09', 'Rabu', '09:00:00', 9, 3, 4.2, 'lancar'),
(14, '2025-07-09', 'Rabu', '10:00:00', 11, 4, 4.0, 'sedang'),
(15, '2025-07-09', 'Rabu', '17:00:00', 20, 7, 3.4, 'padat'),
(16, '2025-07-09', 'Rabu', '18:00:00', 21, 8, 3.2, 'padat'),
(17, '2025-07-10', 'Kamis', '08:00:00', 11, 4, 3.9, 'sedang'),
(18, '2025-07-10', 'Kamis', '09:00:00', 12, 5, 3.7, 'sedang'),
(19, '2025-07-10', 'Kamis', '10:00:00', 14, 6, 3.5, 'padat'),
(20, '2025-07-10', 'Kamis', '17:00:00', 22, 9, 3.1, 'padat'),
(21, '2025-07-10', 'Kamis', '18:00:00', 23, 10, 2.9, 'sangat_padat'),
(22, '2025-07-11', 'Jumat', '08:00:00', 13, 5, 3.6, 'sedang'),
(23, '2025-07-11', 'Jumat', '09:00:00', 14, 6, 3.4, 'sedang'),
(24, '2025-07-11', 'Jumat', '10:00:00', 15, 7, 3.2, 'padat'),
(25, '2025-07-11', 'Jumat', '17:00:00', 25, 12, 2.8, 'sangat_padat'),
(26, '2025-07-11', 'Jumat', '18:00:00', 27, 14, 2.5, 'sangat_padat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_monthly_insights`
--

CREATE TABLE `pemeriksaan_monthly_insights` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `total_pemeriksaan` int(11) DEFAULT 0,
  `rata_durasi_konsultasi` int(11) DEFAULT 0,
  `total_pendapatan` decimal(12,2) DEFAULT 0.00,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `pemeriksaan_selesai` int(11) DEFAULT 0,
  `pemeriksaan_batal` int(11) DEFAULT 0,
  `diagnosa_terbanyak` varchar(100) DEFAULT NULL,
  `jam_tersibuk` time DEFAULT NULL,
  `hari_tersibuk` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0,
  `jumlah_rujukan` int(11) DEFAULT 0,
  `tingkat_kedatangan_ulang` decimal(5,2) DEFAULT 0.00,
  `efisiensi_pelayanan` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_monthly_insights`
--

INSERT INTO `pemeriksaan_monthly_insights` (`id`, `periode_bulan`, `total_pemeriksaan`, `rata_durasi_konsultasi`, `total_pendapatan`, `tingkat_kepuasan`, `pemeriksaan_selesai`, `pemeriksaan_batal`, `diagnosa_terbanyak`, `jam_tersibuk`, `hari_tersibuk`, `rata_waktu_tunggu`, `jumlah_rujukan`, `tingkat_kedatangan_ulang`, `efisiensi_pelayanan`) VALUES
(1, '2025-07', 200, 25, 36500000.00, 4.2, 185, 15, 'ISPA', '18:00:00', 'Jumat', 16, 22, 32.50, 87.20),
(2, '2025-06', 180, 23, 32400000.00, 4.1, 168, 12, 'Demam', '17:30:00', 'Jumat', 15, 18, 28.70, 85.60),
(3, '2025-05', 165, 24, 29800000.00, 4.0, 155, 10, 'ISPA', '18:00:00', 'Kamis', 17, 15, 25.40, 83.90),
(4, '2025-04', 155, 22, 27600000.00, 3.9, 148, 7, 'Gastritis', '17:00:00', 'Jumat', 14, 12, 22.80, 86.40);

-- --------------------------------------------------------

--
-- Index dan Auto Increment untuk tabel pemeriksaan
--

--
-- Indexes for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD UNIQUE KEY `kd_pemeriksaan` (`kd_pemeriksaan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `tgl_pemeriksaan` (`tgl_pemeriksaan`),
  ADD KEY `status_periksa` (`status_periksa`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `kd_pendaftaran` (`kd_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`),
  ADD KEY `tgl_pendaftaran` (`tgl_pendaftaran`);

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `nm_pasien` (`nm_pasien`),
  ADD KEY `jk_pasien` (`jk_pasien`);

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `nm_dokter` (`nm_dokter`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tb_poli`
--
ALTER TABLE `tb_poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `nm_poli` (`nm_poli`);

--
-- Indexes for table `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemeriksaan` (`id_pemeriksaan`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `tanggal_periksa` (`tanggal_periksa`),
  ADD KEY `kategori_keluhan` (`kategori_keluhan`),
  ADD KEY `status_pemeriksaan` (`status_pemeriksaan`);

--
-- Indexes for table `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periode_bulan` (`periode_bulan`),
  ADD KEY `diagnosa` (`diagnosa`);

--
-- Indexes for table `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `hari` (`hari`),
  ADD KEY `jam` (`jam`);

--
-- Indexes for table `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode_bulan` (`periode_bulan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pasien`
--
ALTER TABLE `tb_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_poli`
--
ALTER TABLE `tb_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Foreign Key untuk tabel pemeriksaan
--

--
-- Ketidakleluasaan untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tb_dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_3` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD CONSTRAINT `tb_dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE SET NULL;

COMMIT;

--
-- View untuk dashboard metrics
--

-- View untuk menghitung total pasien
CREATE VIEW `v_total_pasien` AS
SELECT COUNT(*) as total_pasien FROM `pasien`;

-- View untuk menghitung total dokter aktif
CREATE VIEW `v_total_dokter_aktif` AS
SELECT COUNT(*) as total_dokter FROM `dokter` WHERE `status` = 'aktif';

-- View untuk menghitung obat stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT COUNT(*) as obat_kritis FROM `obat` WHERE `stok` <= `stok_minimum`;

-- View untuk keuntungan tahun ini
CREATE VIEW `v_keuntungan_tahun_ini` AS
SELECT SUM(keuntungan_bersih) as total_keuntungan 
FROM `keuntungan` 
WHERE `tahun` = YEAR(CURDATE());

-- View untuk pengeluaran tahun ini
CREATE VIEW `v_pengeluaran_tahun_ini` AS
SELECT SUM(jumlah) as total_pengeluaran 
FROM `pengeluaran` 
WHERE YEAR(tanggal) = YEAR(CURDATE());

-- View untuk pasien hari ini
CREATE VIEW `v_pasien_hari_ini` AS
SELECT COUNT(*) as pasien_hari_ini 
FROM `pendaftaran` 
WHERE DATE(tanggal_daftar) = CURDATE();

-- View untuk pemeriksaan selesai hari ini
CREATE VIEW `v_pemeriksaan_hari_ini` AS
SELECT COUNT(*) as pemeriksaan_selesai 
FROM `pemeriksaan` 
WHERE DATE(tanggal_periksa) = CURDATE() AND status = 'selesai';

-- View untuk pengeluaran hari ini
CREATE VIEW `v_pengeluaran_hari_ini` AS
SELECT COALESCE(SUM(jumlah), 0) as pengeluaran_hari_ini 
FROM `pengeluaran` 
WHERE DATE(tanggal) = CURDATE();

-- View untuk total dokter aktif (sesuai dokter.php)
CREATE VIEW `v_dokter_performance_summary` AS
SELECT 
    COUNT(CASE WHEN status = 'aktif' THEN 1 END) as total_dokter_aktif,
    COUNT(CASE WHEN status = 'nonaktif' THEN 1 END) as total_dokter_nonaktif,
    COUNT(CASE WHEN status = 'cuti' THEN 1 END) as total_dokter_cuti,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN kehadiran_persen END), 2) as rata_kehadiran,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN total_pasien_bulan END), 0) as rata_pasien_per_dokter,
    ROUND(AVG(CASE WHEN status = 'aktif' THEN rating END), 2) as rata_rating_dokter
FROM `dokter`;

-- View untuk dokter dengan kinerja terbaik
CREATE VIEW `v_top_dokter_performance` AS
SELECT 
    d.id,
    d.nama,
    d.spesialisasi,
    d.total_jam_bulan,
    d.target_jam_bulan,
    d.kehadiran_persen,
    d.pertumbuhan_pasien_persen,
    d.total_pasien_bulan,
    d.rating,
    CASE 
        WHEN d.rating >= 4.8 AND d.kehadiran_persen >= 95 THEN 'Top Performer'
        WHEN d.rating >= 4.5 AND d.kehadiran_persen >= 90 THEN 'Sangat Baik'
        WHEN d.rating >= 4.0 AND d.kehadiran_persen >= 85 THEN 'Baik'
        WHEN d.rating >= 3.5 AND d.kehadiran_persen >= 80 THEN 'Cukup'
        ELSE 'Perlu Monitoring'
    END as kinerja_kategori
FROM `dokter` d
WHERE d.status = 'aktif'
ORDER BY d.rating DESC, d.kehadiran_persen DESC, d.total_pasien_bulan DESC
LIMIT 10;

-- View untuk jadwal dokter hari ini
CREATE VIEW `v_jadwal_dokter_hari_ini` AS
SELECT 
    d.nama as nama_dokter,
    d.spesialisasi,
    jd.shift,
    jd.jam_mulai,
    jd.jam_selesai,
    CASE 
        WHEN jd.shift = 'Overload' THEN 'danger'
        WHEN jd.shift = 'Double Shift' THEN 'danger'
        WHEN jd.shift = 'Sore' THEN 'warning'
        WHEN jd.shift = 'Malam' THEN 'info'
        ELSE 'success'
    END as badge_class
FROM `jadwal_dokter` jd
JOIN `dokter` d ON jd.dokter_id = d.id
WHERE jd.hari = CASE 
    WHEN DAYOFWEEK(CURDATE()) = 1 THEN 'Minggu'
    WHEN DAYOFWEEK(CURDATE()) = 2 THEN 'Senin'
    WHEN DAYOFWEEK(CURDATE()) = 3 THEN 'Selasa'
    WHEN DAYOFWEEK(CURDATE()) = 4 THEN 'Rabu'
    WHEN DAYOFWEEK(CURDATE()) = 5 THEN 'Kamis'
    WHEN DAYOFWEEK(CURDATE()) = 6 THEN 'Jumat'
    WHEN DAYOFWEEK(CURDATE()) = 7 THEN 'Sabtu'
END
AND jd.status = 'aktif'
AND d.status = 'aktif';

-- View untuk kehadiran dokter bulan ini
CREATE VIEW `v_kehadiran_dokter_bulan_ini` AS
SELECT 
    d.nama as nama_dokter,
    COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) as total_hadir,
    COUNT(CASE WHEN kd.status_kehadiran = 'izin' THEN 1 END) as total_izin,
    COUNT(CASE WHEN kd.status_kehadiran = 'sakit' THEN 1 END) as total_sakit,
    COUNT(CASE WHEN kd.status_kehadiran = 'alpha' THEN 1 END) as total_alpha,
    COUNT(*) as total_hari_kerja,
    ROUND((COUNT(CASE WHEN kd.status_kehadiran = 'hadir' THEN 1 END) / COUNT(*)) * 100, 2) as persentase_kehadiran
FROM `dokter` d
LEFT JOIN `kehadiran_dokter` kd ON d.id = kd.dokter_id 
    AND MONTH(kd.tanggal) = MONTH(CURDATE()) 
    AND YEAR(kd.tanggal) = YEAR(CURDATE())
WHERE d.status = 'aktif'
GROUP BY d.id, d.nama
ORDER BY persentase_kehadiran DESC;

-- View untuk ringkasan obat (sesuai obat.php)
CREATE VIEW `v_obat_summary` AS
SELECT 
    COUNT(*) as total_obat,
    COUNT(DISTINCT kategori) as total_kategori_penyakit,
    COUNT(DISTINCT bentuk_obat) as total_kategori_bentuk,
    COUNT(DISTINCT CONCAT(nama_obat, '-', kategori)) as total_jenis_unik,
    COUNT(CASE WHEN stok <= stok_minimum THEN 1 END) as obat_kritis,
    COUNT(CASE WHEN tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as obat_kadaluarsa
FROM `obat`;

-- View untuk distribusi bentuk obat (untuk chart)
CREATE VIEW `v_distribusi_bentuk_obat` AS
SELECT 
    bentuk_obat as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY bentuk_obat
ORDER BY jumlah DESC;

-- View untuk distribusi kategori penyakit (untuk chart)
CREATE VIEW `v_distribusi_kategori_penyakit` AS
SELECT 
    kategori as nama,
    COUNT(*) as jumlah,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM obat)), 2) as persentase
FROM `obat`
GROUP BY kategori
ORDER BY jumlah DESC;

-- View untuk top obat terlaris
CREATE VIEW `v_top_obat_terlaris` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.terjual_bulan_ini,
    o.satuan,
    o.stok as stok_tersisa,
    o.harga_jual as harga,
    o.supplier,
    o.trend_direction as trend,
    o.persentase_trend,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
ORDER BY o.terjual_bulan_ini DESC
LIMIT 10;

-- View untuk obat dengan stok kritis
CREATE VIEW `v_obat_stok_kritis` AS
SELECT 
    o.id,
    o.nama_obat as nama,
    o.sku,
    o.kategori,
    o.stok as stok_tersisa,
    o.stok_minimum,
    o.tanggal_expired as exp_date,
    o.supplier,
    o.last_restock_date,
    o.harga_jual as harga,
    CASE 
        WHEN o.stok = 0 THEN 'out_of_stock'
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 'critical'
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 'expiring'
        ELSE 'low'
    END as status,
    CASE 
        WHEN o.bentuk_obat = 'Tablet' THEN 'fas fa-tablets'
        WHEN o.bentuk_obat = 'Kapsul' THEN 'fas fa-capsules'
        WHEN o.bentuk_obat = 'Syrup' THEN 'fas fa-prescription-bottle'
        WHEN o.bentuk_obat = 'Salep' THEN 'fas fa-pump-medical'
        WHEN o.bentuk_obat = 'Injeksi' THEN 'fas fa-syringe'
        ELSE 'fas fa-pills'
    END as icon,
    CASE 
        WHEN o.kategori = 'Pain Relief' THEN '#e74c3c'
        WHEN o.kategori = 'Antibiotics' THEN '#3498db'
        WHEN o.kategori = 'Respiratory' THEN '#f39c12'
        WHEN o.kategori = 'Vitamins' THEN '#27ae60'
        WHEN o.kategori = 'Dermatology' THEN '#9b59b6'
        WHEN o.kategori = 'Gastric' THEN '#16a085'
        WHEN o.kategori = 'Allergy' THEN '#f1c40f'
        WHEN o.kategori = 'Diabetes' THEN '#34495e'
        WHEN o.kategori = 'Hipertensi' THEN '#e67e22'
        ELSE '#5459AC'
    END as color
FROM `obat` o
WHERE o.stok <= o.stok_minimum 
   OR o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
ORDER BY 
    CASE 
        WHEN o.stok = 0 THEN 1
        WHEN o.stok <= (o.stok_minimum * 0.5) THEN 2
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 3
        WHEN o.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 4
        ELSE 5
    END,
    o.stok ASC;

-- View untuk sales tracking harian
CREATE VIEW `v_obat_sales_daily` AS
SELECT 
    o.nama_obat,
    o.sku,
    o.kategori,
    ost.tanggal_penjualan as tanggal,
    SUM(ost.jumlah_terjual) as total_terjual,
    SUM(ost.total_revenue) as total_revenue,
    AVG(ost.profit_margin) as avg_profit_margin
FROM `obat_sales_tracking` ost
JOIN `obat` o ON ost.obat_id = o.id
WHERE ost.tanggal_penjualan >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY o.id, ost.tanggal_penjualan
ORDER BY ost.tanggal_penjualan DESC, total_revenue DESC;

-- View untuk ringkasan pasien (sesuai pasien.php)
CREATE VIEW `v_pasien_summary` AS
SELECT 
    COUNT(DISTINCT p.id) as total_pasien,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru_bulan_ini,
    COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
               AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) 
               AND pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali_bulan_ini,
    ROUND(AVG(pur.rating), 2) as rata_rating,
    COUNT(CASE WHEN pur.rating < 3.0 THEN 1 END) as rating_kurang_3,
    ROUND(
        (COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(CURDATE()) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(CURDATE()) THEN 1 END) - 
         COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                    AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END)) * 100.0 / 
        NULLIF(COUNT(CASE WHEN MONTH(pkh.tanggal_kunjungan) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND YEAR(pkh.tanggal_kunjungan) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END), 0), 2
    ) as kenaikan_pasien_persen
FROM `pasien` p
LEFT JOIN `pasien_kunjungan_history` pkh ON p.id = pkh.pasien_id
LEFT JOIN `pasien_ulasan_rating` pur ON p.id = pur.pasien_id;

-- View untuk distribusi usia pasien (untuk chart)
CREATE VIEW `v_distribusi_usia_pasien` AS
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 12 THEN '0-12'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 24 THEN '13-24'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 45 THEN '25-45'
        WHEN TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) <= 65 THEN '46-65'
        ELSE '65+'
    END as kelompok_usia,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY kelompok_usia
ORDER BY 
    CASE kelompok_usia
        WHEN '0-12' THEN 1
        WHEN '13-24' THEN 2
        WHEN '25-45' THEN 3
        WHEN '46-65' THEN 4
        WHEN '65+' THEN 5
    END;

-- View untuk distribusi gender pasien (untuk chart)
CREATE VIEW `v_distribusi_gender_pasien` AS
SELECT 
    CASE p.jenis_kelamin
        WHEN 'L' THEN 'Laki-laki'
        WHEN 'P' THEN 'Perempuan'
        ELSE 'Lainnya'
    END as gender,
    COUNT(*) as jumlah_pasien,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM pasien)), 2) as persentase
FROM `pasien` p
GROUP BY p.jenis_kelamin;

-- View untuk ulasan pasien terbaru
CREATE VIEW `v_ulasan_pasien_terbaru` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.recommend_to_others,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
ORDER BY pur.tanggal_kunjungan DESC, pur.created_at DESC;

-- View untuk ulasan positif (rating >= 4)
CREATE VIEW `v_ulasan_positif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating >= 4.0
ORDER BY pur.rating DESC, pur.tanggal_kunjungan DESC;

-- View untuk ulasan negatif (rating < 4)
CREATE VIEW `v_ulasan_negatif` AS
SELECT 
    p.nama,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender,
    pur.status_kunjungan as kunjungan,
    pur.rating,
    pur.ulasan,
    pur.tanggal_kunjungan as tanggal,
    pur.mood_rating,
    pur.kategori_ulasan
FROM `pasien_ulasan_rating` pur
JOIN `pasien` p ON pur.pasien_id = p.id
WHERE pur.rating < 4.0
ORDER BY pur.rating ASC, pur.tanggal_kunjungan DESC;

-- View untuk insights MIS pasien
CREATE VIEW `v_pasien_insights` AS
SELECT 
    pim.periode_bulan,
    pim.total_pasien,
    pim.pasien_baru,
    pim.pasien_kembali,
    pim.pertumbuhan_pasien_persen,
    pim.rata_rating,
    pim.rating_kurang_3,
    pim.rasio_pasien_pria_persen,
    pim.total_kunjungan,
    pim.rata_biaya_kunjungan,
    pim.tingkat_kepuasan_persen,
    pim.rekomendasi_persen,
    CASE 
        WHEN pim.pertumbuhan_pasien_persen < 0 THEN 'Menurun'
        WHEN pim.pertumbuhan_pasien_persen >= 10 THEN 'Tinggi'
        WHEN pim.pertumbuhan_pasien_persen >= 5 THEN 'Sedang'
        ELSE 'Rendah'
    END as kategori_pertumbuhan,
    CASE 
        WHEN pim.rata_rating >= 4.5 THEN 'Sangat Puas'
        WHEN pim.rata_rating >= 4.0 THEN 'Puas'
        WHEN pim.rata_rating >= 3.5 THEN 'Cukup'
        ELSE 'Perlu Perbaikan'
    END as kategori_kepuasan,
    CASE 
        WHEN pim.rasio_pasien_pria_persen < 40 THEN 'Perlu Program Khusus Pria'
        WHEN pim.rasio_pasien_pria_persen > 60 THEN 'Perlu Program Khusus Wanita'
        ELSE 'Seimbang'
    END as rekomendasi_gender
FROM `pasien_insights_metrics` pim
WHERE pim.periode_bulan = DATE_FORMAT(CURDATE(), '%Y-%m')
LIMIT 1;

-- View untuk kunjungan pasien hari ini
CREATE VIEW `v_kunjungan_hari_ini` AS
SELECT 
    p.nama as nama_pasien,
    p.no_rm,
    pkh.jenis_kunjungan,
    pkh.keluhan_utama,
    d.nama as nama_dokter,
    pkh.biaya_total,
    pkh.status_pembayaran,
    pkh.rating_kunjungan,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as usia,
    CASE p.jenis_kelamin WHEN 'L' THEN 'Laki-laki' WHEN 'P' THEN 'Perempuan' ELSE 'Lainnya' END as gender
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
LEFT JOIN `dokter` d ON pkh.dokter_id = d.id
WHERE DATE(pkh.tanggal_kunjungan) = CURDATE()
ORDER BY pkh.created_at DESC;

-- View untuk statistik pasien per bulan
CREATE VIEW `v_statistik_pasien_bulanan` AS
SELECT 
    DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m') as periode,
    COUNT(DISTINCT pkh.pasien_id) as total_pasien_unik,
    COUNT(*) as total_kunjungan,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Baru' THEN 1 END) as pasien_baru,
    COUNT(CASE WHEN pkh.jenis_kunjungan = 'Kembali' THEN 1 END) as pasien_kembali,
    AVG(pkh.biaya_total) as rata_biaya,
    AVG(pkh.rating_kunjungan) as rata_rating,
    COUNT(CASE WHEN p.jenis_kelamin = 'L' THEN 1 END) as total_pria,
    COUNT(CASE WHEN p.jenis_kelamin = 'P' THEN 1 END) as total_wanita
FROM `pasien_kunjungan_history` pkh
JOIN `pasien` p ON pkh.pasien_id = p.id
WHERE pkh.tanggal_kunjungan >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(pkh.tanggal_kunjungan, '%Y-%m')
ORDER BY periode DESC;

-- --------------------------------------------------------

--
-- Tabel Analitik untuk Pemeriksaan Dashboard
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_detail_analytics`
--

CREATE TABLE `pemeriksaan_detail_analytics` (
  `id` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `durasi_konsultasi` int(11) DEFAULT 0,
  `kategori_keluhan` enum('Demam','Batuk','Pusing','Mual','Flu','Pencernaan','Pernapasan','Jantung','Lainnya') DEFAULT 'Lainnya',
  `tingkat_urgensi` enum('Rendah','Sedang','Tinggi','Darurat') DEFAULT 'Rendah',
  `status_pemeriksaan` enum('Menunggu','Berlangsung','Selesai','Batal') DEFAULT 'Menunggu',
  `resep_diberikan` tinyint(1) DEFAULT 0,
  `biaya_konsultasi` decimal(10,2) DEFAULT 0.00,
  `rating_pelayanan` decimal(2,1) DEFAULT NULL,
  `catatan_khusus` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_detail_analytics`
--

INSERT INTO `pemeriksaan_detail_analytics` (`id`, `id_pemeriksaan`, `pasien_id`, `dokter_id`, `tanggal_periksa`, `jam_mulai`, `jam_selesai`, `durasi_konsultasi`, `kategori_keluhan`, `tingkat_urgensi`, `status_pemeriksaan`, `resep_diberikan`, `biaya_konsultasi`, `rating_pelayanan`, `catatan_khusus`) VALUES
(1, 1, 1, 1, '2025-07-08', '08:45:00', '09:00:00', 15, 'Demam', 'Sedang', 'Selesai', 1, 150000.00, 4.5, 'Pasien responsif terhadap pengobatan'),
(2, 2, 2, 2, '2025-07-08', '09:15:00', '09:35:00', 20, 'Pernapasan', 'Sedang', 'Selesai', 1, 175000.00, 4.2, 'Anak kooperatif selama pemeriksaan'),
(3, 3, 3, 1, '2025-07-08', '10:30:00', '10:55:00', 25, 'Jantung', 'Tinggi', 'Selesai', 1, 150000.00, 4.8, 'Perlu monitoring tekanan darah rutin'),
(4, 4, 4, 3, '2025-07-08', '10:00:00', '10:30:00', 30, 'Lainnya', 'Sedang', 'Selesai', 1, 200000.00, 4.0, 'Edukasi kebersihan gigi diberikan'),
(5, 5, 5, 4, '2025-07-08', '10:45:00', '11:20:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 300000.00, 4.7, 'Resep kacamata diberikan'),
(6, 6, 6, 5, '2025-07-08', '11:15:00', '11:40:00', 25, 'Lainnya', 'Sedang', 'Selesai', 1, 180000.00, 3.8, 'Alergi makanan perlu dihindari'),
(7, 7, 7, 6, '2025-07-08', '11:45:00', '12:25:00', 40, 'Jantung', 'Darurat', 'Selesai', 1, 250000.00, 4.9, 'Rujukan kardiolog segera'),
(8, 8, 8, 7, '2025-07-08', '12:15:00', '13:00:00', 45, 'Lainnya', 'Rendah', 'Selesai', 1, 350000.00, 4.6, 'Kehamilan berjalan normal'),
(9, 9, 9, 1, '2025-07-08', '13:30:00', '13:52:00', 22, 'Pernapasan', 'Sedang', 'Selesai', 1, 190000.00, 4.3, 'Hindari paparan asap rokok'),
(10, 10, 10, 2, '2025-07-08', '14:00:00', '14:18:00', 18, 'Demam', 'Tinggi', 'Selesai', 1, 160000.00, 4.1, 'Monitor suhu tubuh anak'),
(11, 11, 1, 1, '2025-07-09', '08:30:00', '08:50:00', 20, 'Flu', 'Sedang', 'Selesai', 1, 145000.00, 4.4, 'Kondisi membaik'),
(12, 12, 3, 1, '2025-07-09', '09:00:00', '09:25:00', 25, 'Pusing', 'Sedang', 'Selesai', 1, 155000.00, 4.2, 'Tekanan darah terkontrol'),
(13, 13, 5, 4, '2025-07-09', '10:00:00', '10:35:00', 35, 'Lainnya', 'Rendah', 'Selesai', 1, 285000.00, 4.8, 'Kontrol mata rutin'),
(14, 14, 7, 6, '2025-07-09', '11:00:00', '11:30:00', 30, 'Jantung', 'Tinggi', 'Selesai', 1, 275000.00, 4.7, 'EKG hasil membaik'),
(15, 15, 9, 1, '2025-07-10', '08:45:00', '09:05:00', 20, 'Batuk', 'Sedang', 'Selesai', 1, 165000.00, 4.3, 'Batuk berkurang'),
(16, 16, 2, 2, '2025-07-10', '09:30:00', '09:55:00', 25, 'Demam', 'Sedang', 'Menunggu', 0, 140000.00, NULL, 'Menunggu hasil lab'),
(17, 17, 4, 3, '2025-07-10', '10:15:00', '10:45:00', 30, 'Lainnya', 'Rendah', 'Berlangsung', 0, 195000.00, NULL, 'Scaling gigi'),
(18, 18, 6, 5, '2025-07-10', '11:00:00', '11:20:00', 20, 'Lainnya', 'Rendah', 'Berlangsung', 0, 175000.00, NULL, 'Follow up dermatitis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_diagnosa_stats`
--

CREATE TABLE `pemeriksaan_diagnosa_stats` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `diagnosa` varchar(100) NOT NULL,
  `jumlah_kasus` int(11) DEFAULT 0,
  `persentase` decimal(5,2) DEFAULT 0.00,
  `tingkat_kesembuhan` decimal(5,2) DEFAULT 0.00,
  `rata_biaya` decimal(10,2) DEFAULT 0.00,
  `rata_durasi` int(11) DEFAULT 0,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `trend_bulanan` enum('naik','turun','stabil') DEFAULT 'stabil',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_diagnosa_stats`
--

INSERT INTO `pemeriksaan_diagnosa_stats` (`id`, `periode_bulan`, `diagnosa`, `jumlah_kasus`, `persentase`, `tingkat_kesembuhan`, `rata_biaya`, `rata_durasi`, `tingkat_kepuasan`, `trend_bulanan`) VALUES
(1, '2025-07', 'ISPA', 45, 22.50, 92.50, 168000.00, 22, 4.3, 'naik'),
(2, '2025-07', 'Demam', 38, 19.00, 95.20, 152000.00, 18, 4.2, 'stabil'),
(3, '2025-07', 'Hipertensi', 32, 16.00, 88.50, 165000.00, 25, 4.5, 'turun'),
(4, '2025-07', 'Gastritis', 28, 14.00, 89.30, 175000.00, 20, 4.1, 'stabil'),
(5, '2025-07', 'Dermatitis', 25, 12.50, 85.60, 182000.00, 28, 3.9, 'naik'),
(6, '2025-07', 'Miopia', 18, 9.00, 100.00, 285000.00, 35, 4.6, 'stabil'),
(7, '2025-07', 'Karies Dentis', 14, 7.00, 94.40, 195000.00, 30, 4.2, 'turun'),
(8, '2025-06', 'ISPA', 42, 21.00, 90.20, 162000.00, 20, 4.1, 'stabil'),
(9, '2025-06', 'Demam', 40, 20.00, 93.80, 148000.00, 17, 4.0, 'naik'),
(10, '2025-06', 'Hipertensi', 35, 17.50, 86.20, 160000.00, 24, 4.3, 'stabil'),
(11, '2025-06', 'Gastritis', 30, 15.00, 87.50, 170000.00, 22, 3.9, 'naik'),
(12, '2025-06', 'Dermatitis', 22, 11.00, 82.40, 178000.00, 26, 3.8, 'stabil'),
(13, '2025-06', 'Miopia', 16, 8.00, 100.00, 280000.00, 33, 4.5, 'turun'),
(14, '2025-06', 'Karies Dentis', 15, 7.50, 92.20, 188000.00, 28, 4.0, 'stabil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_waktu_tunggu_stats`
--

CREATE TABLE `pemeriksaan_waktu_tunggu_stats` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam` time NOT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0 COMMENT 'dalam menit',
  `jumlah_pasien` int(11) DEFAULT 0,
  `tingkat_kepuasan_waktu` decimal(3,2) DEFAULT 0.00,
  `status_antrian` enum('lancar','sedang','padat','sangat_padat') DEFAULT 'lancar',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_waktu_tunggu_stats`
--

INSERT INTO `pemeriksaan_waktu_tunggu_stats` (`id`, `tanggal`, `hari`, `jam`, `rata_waktu_tunggu`, `jumlah_pasien`, `tingkat_kepuasan_waktu`, `status_antrian`) VALUES
(1, '2025-07-07', 'Senin', '08:00:00', 10, 3, 4.2, 'lancar'),
(2, '2025-07-07', 'Senin', '09:00:00', 12, 5, 4.0, 'sedang'),
(3, '2025-07-07', 'Senin', '10:00:00', 13, 6, 3.8, 'sedang'),
(4, '2025-07-07', 'Senin', '11:00:00', 15, 7, 3.5, 'padat'),
(5, '2025-07-07', 'Senin', '17:00:00', 21, 9, 3.2, 'padat'),
(6, '2025-07-07', 'Senin', '18:00:00', 22, 10, 3.0, 'sangat_padat'),
(7, '2025-07-08', 'Selasa', '08:00:00', 9, 2, 4.3, 'lancar'),
(8, '2025-07-08', 'Selasa', '09:00:00', 10, 4, 4.1, 'lancar'),
(9, '2025-07-08', 'Selasa', '10:00:00', 12, 5, 3.9, 'sedang'),
(10, '2025-07-08', 'Selasa', '17:00:00', 20, 8, 3.3, 'padat'),
(11, '2025-07-08', 'Selasa', '18:00:00', 21, 9, 3.1, 'padat'),
(12, '2025-07-09', 'Rabu', '08:00:00', 8, 2, 4.4, 'lancar'),
(13, '2025-07-09', 'Rabu', '09:00:00', 9, 3, 4.2, 'lancar'),
(14, '2025-07-09', 'Rabu', '10:00:00', 11, 4, 4.0, 'sedang'),
(15, '2025-07-09', 'Rabu', '17:00:00', 20, 7, 3.4, 'padat'),
(16, '2025-07-09', 'Rabu', '18:00:00', 21, 8, 3.2, 'padat'),
(17, '2025-07-10', 'Kamis', '08:00:00', 11, 4, 3.9, 'sedang'),
(18, '2025-07-10', 'Kamis', '09:00:00', 12, 5, 3.7, 'sedang'),
(19, '2025-07-10', 'Kamis', '10:00:00', 14, 6, 3.5, 'padat'),
(20, '2025-07-10', 'Kamis', '17:00:00', 22, 9, 3.1, 'padat'),
(21, '2025-07-10', 'Kamis', '18:00:00', 23, 10, 2.9, 'sangat_padat'),
(22, '2025-07-11', 'Jumat', '08:00:00', 13, 5, 3.6, 'sedang'),
(23, '2025-07-11', 'Jumat', '09:00:00', 14, 6, 3.4, 'sedang'),
(24, '2025-07-11', 'Jumat', '10:00:00', 15, 7, 3.2, 'padat'),
(25, '2025-07-11', 'Jumat', '17:00:00', 25, 12, 2.8, 'sangat_padat'),
(26, '2025-07-11', 'Jumat', '18:00:00', 27, 14, 2.5, 'sangat_padat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_monthly_insights`
--

CREATE TABLE `pemeriksaan_monthly_insights` (
  `id` int(11) NOT NULL,
  `periode_bulan` varchar(7) NOT NULL,
  `total_pemeriksaan` int(11) DEFAULT 0,
  `rata_durasi_konsultasi` int(11) DEFAULT 0,
  `total_pendapatan` decimal(12,2) DEFAULT 0.00,
  `tingkat_kepuasan` decimal(3,2) DEFAULT 0.00,
  `pemeriksaan_selesai` int(11) DEFAULT 0,
  `pemeriksaan_batal` int(11) DEFAULT 0,
  `diagnosa_terbanyak` varchar(100) DEFAULT NULL,
  `jam_tersibuk` time DEFAULT NULL,
  `hari_tersibuk` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `rata_waktu_tunggu` int(11) DEFAULT 0,
  `jumlah_rujukan` int(11) DEFAULT 0,
  `tingkat_kedatangan_ulang` decimal(5,2) DEFAULT 0.00,
  `efisiensi_pelayanan` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemeriksaan_monthly_insights`
--

INSERT INTO `pemeriksaan_monthly_insights` (`id`, `periode_bulan`, `total_pemeriksaan`, `rata_durasi_konsultasi`, `total_pendapatan`, `tingkat_kepuasan`, `pemeriksaan_selesai`, `pemeriksaan_batal`, `diagnosa_terbanyak`, `jam_tersibuk`, `hari_tersibuk`, `rata_waktu_tunggu`, `jumlah_rujukan`, `tingkat_kedatangan_ulang`, `efisiensi_pelayanan`) VALUES
(1, '2025-07', 200, 25, 36500000.00, 4.2, 185, 15, 'ISPA', '18:00:00', 'Jumat', 16, 22, 32.50, 87.20),
(2, '2025-06', 180, 23, 32400000.00, 4.1, 168, 12, 'Demam', '17:30:00', 'Jumat', 15, 18, 28.70, 85.60),
(3, '2025-05', 165, 24, 29800000.00, 4.0, 155, 10, 'ISPA', '18:00:00', 'Kamis', 17, 15, 25.40, 83.90),
(4, '2025-04', 155, 22, 27600000.00, 3.9, 148, 7, 'Gastritis', '17:00:00', 'Jumat', 14, 12, 22.80, 86.40);

-- --------------------------------------------------------

--
-- Index dan Auto Increment untuk tabel pemeriksaan
--

--
-- Indexes for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD UNIQUE KEY `kd_pemeriksaan` (`kd_pemeriksaan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `tgl_pemeriksaan` (`tgl_pemeriksaan`),
  ADD KEY `status_periksa` (`status_periksa`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `kd_pendaftaran` (`kd_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`),
  ADD KEY `tgl_pendaftaran` (`tgl_pendaftaran`);

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `nm_pasien` (`nm_pasien`),
  ADD KEY `jk_pasien` (`jk_pasien`);

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `nm_dokter` (`nm_dokter`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tb_poli`
--
ALTER TABLE `tb_poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `nm_poli` (`nm_poli`);

--
-- Indexes for table `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemeriksaan` (`id_pemeriksaan`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `tanggal_periksa` (`tanggal_periksa`),
  ADD KEY `kategori_keluhan` (`kategori_keluhan`),
  ADD KEY `status_pemeriksaan` (`status_pemeriksaan`);

--
-- Indexes for table `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periode_bulan` (`periode_bulan`),
  ADD KEY `diagnosa` (`diagnosa`);

--
-- Indexes for table `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `hari` (`hari`),
  ADD KEY `jam` (`jam`);

--
-- Indexes for table `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode_bulan` (`periode_bulan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pasien`
--
ALTER TABLE `tb_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_poli`
--
ALTER TABLE `tb_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_detail_analytics`
--
ALTER TABLE `pemeriksaan_detail_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_diagnosa_stats`
--
ALTER TABLE `pemeriksaan_diagnosa_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_waktu_tunggu_stats`
--
ALTER TABLE `pemeriksaan_waktu_tunggu_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_monthly_insights`
--
ALTER TABLE `pemeriksaan_monthly_insights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Foreign Key untuk tabel pemeriksaan
--

--
-- Ketidakleluasaan untuk tabel `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tb_dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_pendaftaran_ibfk_3` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD CONSTRAINT `tb_dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`) ON DELETE SET NULL;

COMMIT;
