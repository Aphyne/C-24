-- =============================================
-- Database: klinik_dashboard
-- File SQL untuk dashboard klinik lengkap
-- Urutan: Tabel dulu, kemudian Views di akhir
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ========================================
-- STRUKTUR TABEL UTAMA
-- ========================================

-- --------------------------------------------------------
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
(15, 'RM015', 'Hendra Wijaya', 'Laki-laki', '1983-11-11', 'Jl. Cikini No. 486, Jakarta Pusat', '086678901234', 'hendra.wijaya@email.com', 'Arsitek', 'Janda/Duda', 'O-', 'Wijaya Sister', '086678901235', '2024-04-10 14:25:00'),

-- Tambahan data pasien untuk distribusi usia yang lebih beragam
(16, 'RM016', 'Santi Dewi', 'Perempuan', '2010-03-15', 'Jl. Anak Sehat No. 123, Jakarta Barat', '087123456789', 'santi.dewi@email.com', 'Pelajar', 'Belum Menikah', 'A+', 'Dewi Mother', '087123456790', '2024-04-15 09:30:00'),
(17, 'RM017', 'Budi Kecil', 'Laki-laki', '2015-07-20', 'Jl. Taman Kanak No. 456, Jakarta Timur', '087234567890', 'budi.kecil@email.com', 'Pelajar', 'Belum Menikah', 'B+', 'Kecil Father', '087234567891', '2024-04-20 10:15:00'),
(18, 'RM018', 'Aisyah Putri', 'Perempuan', '2008-12-03', 'Jl. SD Negeri No. 789, Jakarta Selatan', '087345678901', 'aisyah.putri@email.com', 'Pelajar', 'Belum Menikah', 'O+', 'Putri Mother', '087345678902', '2024-04-25 11:00:00'),
(19, 'RM019', 'Dika Pratama', 'Laki-laki', '2012-05-18', 'Jl. SMP Mandiri No. 321, Jakarta Pusat', '087456789012', 'dika.pratama@email.com', 'Pelajar', 'Belum Menikah', 'AB+', 'Pratama Father', '087456789013', '2024-05-01 08:45:00'),
(20, 'RM020', 'Fatimah Zahra', 'Perempuan', '2011-09-25', 'Jl. Madrasah No. 654, Jakarta Utara', '087567890123', 'fatimah.zahra@email.com', 'Pelajar', 'Belum Menikah', 'A-', 'Zahra Mother', '087567890124', '2024-05-05 14:20:00'),

-- Kelompok remaja (13-24 tahun)
(21, 'RM021', 'Rizki Maulana', 'Laki-laki', '2005-01-30', 'Jl. SMA Negeri No. 987, Jakarta Barat', '087678901234', 'rizki.maulana@email.com', 'Pelajar', 'Belum Menikah', 'B-', 'Maulana Father', '087678901235', '2024-05-10 16:10:00'),
(22, 'RM022', 'Nabila Sari', 'Perempuan', '2003-04-12', 'Jl. Universitas No. 147, Jakarta Timur', '087789012345', 'nabila.sari@email.com', 'Mahasiswa', 'Belum Menikah', 'O-', 'Sari Mother', '087789012346', '2024-05-15 09:30:00'),
(23, 'RM023', 'Arief Rachman', 'Laki-laki', '2001-06-21', 'Jl. Kampus No. 258, Jakarta Selatan', '087890123456', 'arief.rachman@email.com', 'Mahasiswa', 'Belum Menikah', 'AB-', 'Rachman Father', '087890123457', '2024-05-20 13:15:00'),
(24, 'RM024', 'Indira Safitri', 'Perempuan', '2007-08-17', 'Jl. SMP Plus No. 369, Jakarta Pusat', '087901234567', 'indira.safitri@email.com', 'Pelajar', 'Belum Menikah', 'A+', 'Safitri Mother', '087901234568', '2024-05-25 10:45:00'),
(25, 'RM025', 'Fajar Nugroho', 'Laki-laki', '2004-10-05', 'Jl. SMK Teknik No. 741, Jakarta Utara', '088012345678', 'fajar.nugroho@email.com', 'Pelajar', 'Belum Menikah', 'B+', 'Nugroho Father', '088012345679', '2024-06-01 15:20:00'),

-- Kelompok dewasa muda (25-45 tahun) - tambahan
(26, 'RM026', 'Ratna Sari', 'Perempuan', '1998-02-14', 'Jl. Profesional No. 852, Jakarta Selatan', '088123456789', 'ratna.sari@email.com', 'Konsultan', 'Belum Menikah', 'O+', 'Sari Sister', '088123456790', '2024-06-05 11:55:00'),
(27, 'RM027', 'Andi Firmansyah', 'Laki-laki', '1996-12-28', 'Jl. Startup No. 963, Jakarta Barat', '088234567890', 'andi.firmansyah@email.com', 'Entrepreneur', 'Belum Menikah', 'AB+', 'Firmansyah Father', '088234567891', '2024-06-10 08:10:00'),
(28, 'RM028', 'Desi Ratnasari', 'Perempuan', '1999-07-07', 'Jl. Digital No. 159, Jakarta Timur', '088345678901', 'desi.ratnasari@email.com', 'Content Creator', 'Belum Menikah', 'A-', 'Ratnasari Mother', '088345678902', '2024-06-15 12:40:00'),
(29, 'RM029', 'Yoga Pratama', 'Laki-laki', '1989-11-11', 'Jl. Fitness No. 753, Jakarta Pusat', '088456789012', 'yoga.pratama@email.com', 'Personal Trainer', 'Menikah', 'B-', 'Pratama Wife', '088456789013', '2024-06-20 14:25:00'),
(30, 'RM030', 'Mira Handayani', 'Perempuan', '1993-03-03', 'Jl. Beauty No. 486, Jakarta Selatan', '088567890123', 'mira.handayani@email.com', 'Beautician', 'Menikah', 'O-', 'Handayani Husband', '088567890124', '2024-06-25 16:50:00'),

-- Kelompok paruh baya (46-65 tahun) - tambahan
(31, 'RM031', 'Pak Bambang', 'Laki-laki', '1970-05-15', 'Jl. Veteran No. 123, Jakarta Pusat', '089123456789', 'bambang@email.com', 'Pensiunan TNI', 'Menikah', 'A+', 'Bu Bambang', '089123456790', '2024-07-01 08:30:00'),
(32, 'RM032', 'Ibu Suminah', 'Perempuan', '1965-09-22', 'Jl. Pensiunan No. 456, Jakarta Barat', '089234567890', 'suminah@email.com', 'Pensiunan Guru', 'Janda/Duda', 'B+', 'Suminah Son', '089234567891', '2024-07-05 09:15:00'),
(33, 'RM033', 'Pak Sukardi', 'Laki-laki', '1968-11-08', 'Jl. Industri No. 789, Jakarta Timur', '089345678901', 'sukardi@email.com', 'Supervisor Pabrik', 'Menikah', 'O+', 'Bu Sukardi', '089345678902', '2024-07-10 10:00:00'),
(34, 'RM034', 'Ibu Rukmini', 'Perempuan', '1972-12-03', 'Jl. Ibu Rumah Tangga No. 321, Jakarta Selatan', '089456789012', 'rukmini@email.com', 'Ibu Rumah Tangga', 'Menikah', 'AB+', 'Pak Rukmini', '089456789013', '2024-07-15 11:30:00'),
(35, 'RM035', 'Pak Agus Salim', 'Laki-laki', '1963-05-18', 'Jl. Manager No. 654, Jakarta Utara', '089567890123', 'agus.salim2@email.com', 'Manager Bank', 'Menikah', 'A-', 'Bu Agus', '089567890124', '2024-07-20 14:20:00'),

-- Kelompok lansia (65+ tahun)
(36, 'RM036', 'Mbah Karno', 'Laki-laki', '1950-09-25', 'Jl. Lansia Sejahtera No. 987, Jakarta Pusat', '090123456789', 'karno@email.com', 'Pensiunan PNS', 'Janda/Duda', 'B-', 'Karno Son', '090123456790', '2024-07-25 08:45:00'),
(37, 'RM037', 'Nenek Siti', 'Perempuan', '1955-01-30', 'Jl. Nenek Moyang No. 147, Jakarta Barat', '090234567890', 'nenek.siti@email.com', 'Pensiunan', 'Janda/Duda', 'O-', 'Siti Granddaughter', '090234567891', '2024-08-01 16:10:00'),
(38, 'RM038', 'Kakek Ahmad', 'Laki-laki', '1948-04-12', 'Jl. Kakek Bijak No. 258, Jakarta Timur', '090345678901', 'kakek.ahmad@email.com', 'Pensiunan Dokter', 'Menikah', 'AB-', 'Nenek Ahmad', '090345678902', '2024-08-05 09:30:00'),
(39, 'RM039', 'Mbah Putri', 'Perempuan', '1952-06-21', 'Jl. Mbah Putri No. 369, Jakarta Selatan', '090456789012', 'mbah.putri@email.com', 'Pensiunan Perawat', 'Janda/Duda', 'A+', 'Putri Son', '090456789013', '2024-08-10 13:15:00'),
(40, 'RM040', 'Pak Tua Wijaya', 'Laki-laki', '1945-08-17', 'Jl. Veteran Tua No. 741, Jakarta Utara', '090567890123', 'tua.wijaya@email.com', 'Veteran', 'Menikah', 'B+', 'Bu Tua', '090567890124', '2024-08-15 10:45:00'),

-- Tambahan data pasien dengan variasi pekerjaan dan usia
(41, 'RM041', 'Kevin Pratama', 'Laki-laki', '2009-03-10', 'Jl. Gamers No. 555, Jakarta Barat', '091123456789', 'kevin.pratama@email.com', 'Pelajar', 'Belum Menikah', 'A+', 'Pratama Mother', '091123456790', '2024-08-20 14:25:00'),
(42, 'RM042', 'Luna Maharani', 'Perempuan', '2006-11-15', 'Jl. Princess No. 666, Jakarta Timur', '091234567890', 'luna.maharani@email.com', 'Pelajar', 'Belum Menikah', 'O+', 'Maharani Father', '091234567891', '2024-08-25 12:40:00'),
(43, 'RM043', 'Dr. Handoko', 'Laki-laki', '1974-02-28', 'Jl. Spesialis No. 777, Jakarta Pusat', '091345678901', 'dr.handoko@email.com', 'Dokter Spesialis', 'Menikah', 'AB+', 'Dr. Handoko Wife', '091345678902', '2024-09-01 08:15:00'),
(44, 'RM044', 'Chef Maria', 'Perempuan', '1991-07-12', 'Jl. Kuliner No. 888, Jakarta Selatan', '091456789012', 'chef.maria@email.com', 'Chef Restaurant', 'Belum Menikah', 'B+', 'Maria Sister', '091456789013', '2024-09-05 15:30:00'),
(45, 'RM045', 'Pilot Andi', 'Laki-laki', '1987-10-05', 'Jl. Terbang No. 999, Jakarta Utara', '091567890123', 'pilot.andi@email.com', 'Pilot Komersial', 'Menikah', 'A-', 'Andi Wife', '091567890124', '2024-09-10 11:20:00'),
(46, 'RM046', 'Guru Ratna', 'Perempuan', '1979-05-20', 'Jl. Pendidikan No. 111, Jakarta Barat', '092123456789', 'guru.ratna@email.com', 'Guru SMA', 'Menikah', 'O-', 'Ratna Husband', '092123456790', '2024-09-15 13:45:00'),
(47, 'RM047', 'Arsitek Budi', 'Laki-laki', '1984-08-30', 'Jl. Desain No. 222, Jakarta Timur', '092234567890', 'arsitek.budi@email.com', 'Arsitek Senior', 'Menikah', 'AB-', 'Budi Wife', '092234567891', '2024-09-20 16:50:00'),
(48, 'RM048', 'Psikolog Sari', 'Perempuan', '1990-12-14', 'Jl. Mental Health No. 333, Jakarta Pusat', '092345678901', 'psikolog.sari@email.com', 'Psikolog Klinis', 'Belum Menikah', 'A+', 'Sari Mother', '092345678902', '2024-09-25 09:10:00'),
(49, 'RM049', 'Insinyur Dika', 'Laki-laki', '1986-03-25', 'Jl. Teknik No. 444, Jakarta Selatan', '092456789012', 'insinyur.dika@email.com', 'Insinyur Sipil', 'Menikah', 'B-', 'Dika Wife', '092456789013', '2024-10-01 14:35:00'),
(50, 'RM050', 'Farmasis Dewi', 'Perempuan', '1992-09-08', 'Jl. Apotik No. 555, Jakarta Utara', '092567890123', 'farmasis.dewi@email.com', 'Apoteker', 'Belum Menikah', 'O+', 'Dewi Father', '092567890124', '2024-10-05 12:25:00'),

-- Tambahan data pasien baru untuk bulan Juli 2025 (bulan ini)
(51, 'RM051', 'Andi Baru Juli', 'Laki-laki', '1995-03-15', 'Jl. Pasien Baru No. 123, Jakarta', '081111111111', 'andi.baru@email.com', 'Software Engineer', 'Belum Menikah', 'A+', 'Andi Father', '081111111112', '2025-07-01 08:30:00'),
(52, 'RM052', 'Siti Baru Juli', 'Perempuan', '1992-07-22', 'Jl. Pendaftar Baru No. 456, Jakarta', '082222222222', 'siti.baru@email.com', 'Marketing', 'Menikah', 'B+', 'Siti Husband', '082222222223', '2025-07-02 09:15:00'),
(53, 'RM053', 'Budi Fresh', 'Laki-laki', '1988-11-08', 'Jl. Pasien Fresh No. 789, Jakarta', '083333333333', 'budi.fresh@email.com', 'Designer', 'Menikah', 'O+', 'Fresh Wife', '083333333334', '2025-07-03 10:00:00'),
(54, 'RM054', 'Dewi NewComer', 'Perempuan', '1990-12-03', 'Jl. New Patient No. 321, Jakarta', '084444444444', 'dewi.new@email.com', 'Teacher', 'Belum Menikah', 'AB+', 'Dewi Mother', '084444444445', '2025-07-04 11:30:00'),
(55, 'RM055', 'Riko Latest', 'Laki-laki', '1993-05-18', 'Jl. Latest Patient No. 654, Jakarta', '085555555555', 'riko.latest@email.com', 'Photographer', 'Belum Menikah', 'A-', 'Riko Father', '085555555556', '2025-07-05 14:20:00'),
(56, 'RM056', 'Maya Juli', 'Perempuan', '1989-09-25', 'Jl. Juli Patient No. 987, Jakarta', '086666666666', 'maya.juli@email.com', 'Nurse', 'Menikah', 'B-', 'Juli Husband', '086666666667', '2025-07-06 08:45:00'),
(57, 'RM057', 'Indra Current', 'Laki-laki', '1991-01-30', 'Jl. Current Month No. 147, Jakarta', '087777777777', 'indra.current@email.com', 'Accountant', 'Belum Menikah', 'O-', 'Current Father', '087777777778', '2025-07-07 16:10:00'),
(58, 'RM058', 'Rina Today', 'Perempuan', '1994-04-12', 'Jl. Today Patient No. 258, Jakarta', '088888888888', 'rina.today@email.com', 'Lawyer', 'Menikah', 'AB-', 'Today Husband', '088888888889', '2025-07-08 09:30:00'),
(59, 'RM059', 'Joko Recent', 'Laki-laki', '1987-06-21', 'Jl. Recent Patient No. 369, Jakarta', '089999999999', 'joko.recent@email.com', 'Manager', 'Menikah', 'A+', 'Recent Wife', '089999999990', '2025-07-09 13:15:00'),

-- Tambahan data pasien baru untuk bulan Juni 2025 (bulan lalu)
(60, 'RM060', 'Sri Juni Lalu', 'Perempuan', '1985-08-17', 'Jl. Juni Lalu No. 741, Jakarta', '081000000001', 'sri.juni@email.com', 'Consultant', 'Menikah', 'B+', 'Juni Husband', '081000000002', '2025-06-28 10:45:00'),
(61, 'RM061', 'Agus Juni', 'Laki-laki', '1992-10-05', 'Jl. Last Month No. 852, Jakarta', '082000000001', 'agus.juni@email.com', 'Engineer', 'Belum Menikah', 'O+', 'Juni Father', '082000000002', '2025-06-29 15:20:00'),
(62, 'RM062', 'Lina June', 'Perempuan', '1990-02-14', 'Jl. Previous Month No. 963, Jakarta', '083000000001', 'lina.june@email.com', 'Doctor', 'Menikah', 'AB+', 'June Husband', '083000000002', '2025-06-30 11:55:00');


-- --------------------------------------------------------
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
-- Struktur dari tabel `tb_performance_dokter`
--

CREATE TABLE `tb_performance_dokter` (
  `id_performance` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `total_jam_praktik` int(11) DEFAULT 0,
  `target_jam_praktik` int(11) DEFAULT 500,
  `persentase_kehadiran` decimal(5,2) DEFAULT 0.00,
  `total_pasien_bulan_ini` int(11) DEFAULT 0,
  `pertumbuhan_pasien_persen` decimal(5,2) DEFAULT 0.00,
  `rating_pelayanan` decimal(3,1) DEFAULT 0.0,
  `jumlah_review` int(11) DEFAULT 0,
  `status_kinerja` enum('Top Performer','Sangat Baik','Perlu Monitoring','Nonaktif') DEFAULT 'Sangat Baik',
  `bulan_periode` int(2) DEFAULT NULL,
  `tahun_periode` int(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_performance_dokter`
--

INSERT INTO `tb_performance_dokter` (`id_performance`, `id_dokter`, `total_jam_praktik`, `target_jam_praktik`, `persentase_kehadiran`, `total_pasien_bulan_ini`, `pertumbuhan_pasien_persen`, `rating_pelayanan`, `jumlah_review`, `status_kinerja`, `bulan_periode`, `tahun_periode`) VALUES
(1, 1, 485, 500, 96.50, 142, 15.2, 4.7, 89, 'Sangat Baik', 12, 2024),
(2, 2, 520, 500, 98.20, 156, 18.5, 4.9, 124, 'Top Performer', 12, 2024),
(3, 3, 376, 500, 88.40, 98, 8.7, 4.2, 67, 'Perlu Monitoring', 12, 2024),
(4, 4, 445, 500, 92.10, 134, 12.3, 4.5, 78, 'Sangat Baik', 12, 2024),
(5, 5, 512, 500, 97.80, 145, 16.9, 4.8, 102, 'Top Performer', 12, 2024),
(6, 6, 398, 500, 89.60, 87, 6.4, 4.1, 55, 'Perlu Monitoring', 12, 2024),
(7, 7, 467, 500, 94.30, 119, 13.8, 4.6, 83, 'Sangat Baik', 12, 2024),
(8, 8, 503, 500, 96.70, 138, 14.6, 4.7, 95, 'Sangat Baik', 12, 2024),
(9, 9, 429, 500, 91.50, 112, 11.2, 4.4, 71, 'Sangat Baik', 12, 2024),
(10, 10, 478, 500, 95.40, 127, 13.1, 4.6, 86, 'Sangat Baik', 12, 2024),
(11, 11, 523, 500, 98.90, 149, 19.3, 4.9, 118, 'Top Performer', 12, 2024),
(12, 12, 456, 500, 93.20, 133, 12.7, 4.5, 79, 'Sangat Baik', 12, 2024);

-- --------------------------------------------------------
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
-- Sample data user dengan password plain text untuk kompatibilitas dengan sistem login yang ada
-- Note: Dalam implementasi production, gunakan password yang di-hash
--

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
-- Struktur dari tabel `user_login_log`
--

CREATE TABLE `user_login_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
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
-- Sample data login log dengan pola login yang realistis
--

INSERT INTO `user_login_log` (`id`, `user_id`, `username`, `login_time`, `logout_time`, `ip_address`, `user_agent`, `status_login`, `session_duration`, `login_method`, `failure_reason`, `browser_info`, `location_info`) VALUES
(1, 1, 'admin', '2025-01-08 08:30:00', '2025-01-08 17:45:00', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 555, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(2, 1, 'admin', '2025-01-07 08:15:00', '2025-01-07 17:25:00', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 550, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(3, 2, 'kasir', '2025-01-08 09:15:00', '2025-01-08 17:00:00', '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 465, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(4, 3, 'pendaftaran', '2025-01-08 08:45:00', '2025-01-08 16:30:00', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 495, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
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
(16, 4, 'pemeriksaan', '2025-01-05 07:45:00', '2025-01-05 16:00:00', '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success',  495, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(17, 1, 'admin', '2025-01-05 09:00:00', '2025-01-05 18:30:00', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 570, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(18, 7, 'apoteker1', '2025-01-04 08:15:00', '2025-01-04 16:30:00', '192.168.1.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 495, 'web', NULL, 'Edge 126.0', 'Jakarta, ID'),
(19, 8, 'dokter1', '2025-01-04 06:45:00', '2025-01-04 14:15:00', '192.168.1.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success', 450, 'web', NULL, 'Chrome 126.0', 'Jakarta, ID'),
(20, 2, 'kasir', '2025-01-03 22:15:00', NULL, '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'failed', NULL, 'web', 'Account locked', 'Chrome 126.0', 'Jakarta, ID');

-- --------------------------------------------------------
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
(7, 'admin', 'dokter', 'create', 1, 'Tambah data dokter',
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
(29, 'admin', 'user', 'create', 1, 'Tambah data user',
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
(51, 'apoteker', 'obat', 'create', 1, 'Tambah data obat',
(52, 'apoteker', 'obat', 'edit', 1, 'Edit data obat'),
(53, 'dokter', 'dashboard', 'view', 1, 'Akses dashboard'),
(54, 'dokter', 'pasien', 'view', 1, 'Lihat data pasien'),
(55, 'dokter', 'pemeriksaan', 'view', 1, 'Lihat data pemeriksaan'),
(56, 'dokter', 'pemeriksaan', 'create', 1, 'Tambah data pemeriksaan'),
(57, 'dokter', 'pemeriksaan', 'edit', 1, 'Edit data pemeriksaan');

-- --------------------------------------------------------
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
-- Tabel untuk Sistem Keuntungan dan Analitik Keuangan
-- --------------------------------------------------------

-- --------------------------------------------------------
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
(36, '2025-07-08', 'Penjualan Obat', 'Obat Resep, Obat Bebas (OTC)', 8000000.00, 22, 3200000.00, 4800000.00, 60.00, 7, 2025, 'Penjualan obat minggu pertama Juli'),
(37, '2025-07-08', 'Konsultasi Dokter', 'Konsultasi Umum', 2500000.00, 8, 900000.00, 1600000.00, 64.00, 7, 2025, 'Konsultasi dokter minggu pertama Juli'),
(38, '2025-07-08', 'Pemeriksaan Cepat', 'Cek Tekanan Darah, Gula Darah, Kolesterol', 1800000.00, 9, 650000.00, 1150000.00, 63.89, 7, 2025, 'Pemeriksaan cepat minggu pertama Juli'),
(39, '2025-07-08', 'Vaksinasi', 'Vaksin Flu, Hepatitis', 1200000.00, 5, 400000.00, 800000.00, 66.67, 7, 2025, 'Vaksinasi minggu pertama Juli');

-- --------------------------------------------------------
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

-- ========================================
-- TABEL TAMBAHAN UNTUK SISTEM KLINIK
-- ========================================

-- --------------------------------------------------------
-- Struktur dari tabel `tb_poli`
--

CREATE TABLE `tb_poli` (
  `id_poli` int(11) NOT NULL,
  `nama_poli` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_poli`
--

INSERT INTO `tb_poli` (`id_poli`, `nama_poli`, `keterangan`, `status`) VALUES
(1, 'Poli Umum', 'Pelayanan kesehatan umum', 'aktif'),
(2, 'Poli Anak', 'Pelayanan kesehatan anak', 'aktif'),
(3, 'Poli Kandungan', 'Pelayanan kesehatan kandungan dan kebidanan', 'aktif'),
(4, 'Poli Mata', 'Pelayanan kesehatan mata', 'aktif'),
(5, 'Poli Jantung', 'Pelayanan kesehatan jantung', 'aktif'),
(6, 'Poli Kulit', 'Pelayanan kesehatan kulit dan kelamin', 'aktif'),
(7, 'Poli THT', 'Pelayanan kesehatan telinga, hidung, tenggorokan', 'aktif'),
(8, 'Poli Saraf', 'Pelayanan kesehatan saraf', 'aktif');

-- --------------------------------------------------------
-- Struktur dari tabel `tb_pendaftaran`
--

CREATE TABLE `tb_pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `no_antrian` varchar(20) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `tanggal_pendaftaran` date NOT NULL,
  `jam_pendaftaran` time NOT NULL,
  `keluhan` text DEFAULT NULL,
  `status_pendaftaran` enum('menunggu','dipanggil','selesai','batal') DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pendaftaran`
--

INSERT INTO `tb_pendaftaran` (`id_pendaftaran`, `no_antrian`, `id_pasien`, `id_dokter`, `id_poli`, `tanggal_pendaftaran`, `jam_pendaftaran`, `keluhan`, `status_pendaftaran`) VALUES
(1, 'A001', 1, 1, 1, '2025-01-08', '08:30:00', 'Demam dan batuk', 'selesai'),
(2, 'A002', 2, 2, 2, '2025-01-08', '09:00:00', 'Anak demam tinggi', 'selesai'),
(3, 'A003', 3, 1, 1, '2025-01-08', '09:30:00', 'Kontrol tekanan darah', 'selesai'),
(4, 'A004', 4, 3, 3, '2025-01-08', '10:00:00', 'Konsultasi kehamilan', 'selesai'),
(5, 'A005', 5, 4, 4, '2025-01-08', '10:30:00', 'Mata kabur', 'selesai'),
(6, 'A006', 6, 5, 5, '2025-01-08', '11:00:00', 'Nyeri dada', 'selesai'),
(7, 'A007', 7, 6, 6, '2025-01-08', '11:30:00', 'Gatal-gatal', 'selesai'),
(8, 'A008', 8, 7, 7, '2025-01-08', '12:00:00', 'Telinga berdenging', 'selesai'),
(9, 'A009', 9, 8, 8, '2025-01-08', '12:30:00', 'Sakit kepala', 'selesai'),
(10, 'A010', 10, 1, 1, '2025-01-08', '13:00:00', 'Cek kesehatan rutin', 'selesai'),
(11, 'A011', 11, 2, 2, '2025-01-09', '08:30:00', 'Imunisasi anak', 'selesai'),
(12, 'A012', 12, 3, 3, '2025-01-09', '09:00:00', 'Kontrol kehamilan', 'selesai'),
(13, 'A013', 13, 4, 4, '2025-01-09', '09:30:00', 'Periksa mata', 'selesai'),
(14, 'A014', 14, 5, 5, '2025-01-09', '10:00:00', 'Konsultasi jantung', 'selesai'),
(15, 'A015', 15, 6, 6, '2025-01-09', '10:30:00', 'Perawatan kulit', 'selesai'),
(16, 'A016', 1, 1, 1, '2025-01-10', '08:30:00', 'Kontrol kesehatan', 'menunggu'),
(17, 'A017', 2, 2, 2, '2025-01-10', '09:00:00', 'Vaksinasi', 'menunggu'),
(18, 'A018', 3, 1, 1, '2025-01-10', '09:30:00', 'Cek lab', 'dipanggil');

-- --------------------------------------------------------
-- Struktur dari tabel `tb_pemeriksaan`
--

CREATE TABLE `tb_pemeriksaan` (
  `id_pemeriksaan` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tanggal_pemeriksaan` date NOT NULL,
  `jam_pemeriksaan` time NOT NULL,
  `keluhan` text DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `tindakan` text DEFAULT NULL,
  `resep_obat` text DEFAULT NULL,
  `biaya_pemeriksaan` decimal(10,2) DEFAULT 0.00,
  `status_pemeriksaan` enum('menunggu','berlangsung','selesai','batal') DEFAULT 'menunggu',
  `catatan_dokter` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pemeriksaan`
--

INSERT INTO `tb_pemeriksaan` (`id_pemeriksaan`, `id_pendaftaran`, `id_pasien`, `id_dokter`, `tanggal_pemeriksaan`, `jam_pemeriksaan`, `keluhan`, `diagnosa`, `tindakan`, `resep_obat`, `biaya_pemeriksaan`, `status_pemeriksaan`, `catatan_dokter`) VALUES
(1, 1, 1, 1, '2025-01-08', '08:45:00', 'Demam dan batuk', 'ISPA', 'Pemeriksaan fisik, konsultasi', 'Paracetamol, Amoxicillin', 150000.00, 'selesai', 'Pasien disarankan istirahat cukup'),
(2, 2, 2, 2, '2025-01-08', '09:15:00', 'Anak demam tinggi', 'Demam', 'Pemeriksaan fisik, konsultasi', 'Paracetamol sirup', 120000.00, 'selesai', 'Kompres air hangat, banyak minum'),
(3, 3, 3, 1, '2025-01-08', '09:45:00', 'Kontrol tekanan darah', 'Hipertensi', 'Cek TD, konsultasi', 'Captopril', 100000.00, 'selesai', 'Diet rendah garam'),
(4, 4, 4, 3, '2025-01-08', '10:15:00', 'Konsultasi kehamilan', 'Kehamilan normal', 'USG, konsultasi', 'Vitamin prenatal', 200000.00, 'selesai', 'Kehamilan sehat, kontrol rutin'),
(5, 5, 5, 4, '2025-01-08', '10:45:00', 'Mata kabur', 'Miopia', 'Pemeriksaan mata, refraksi', 'Kacamata minus', 180000.00, 'selesai', 'Gunakan kacamata sesuai resep'),
(6, 6, 6, 5, '2025-01-08', '11:15:00', 'Nyeri dada', 'Angina pektoris', 'EKG, konsultasi', 'Isosorbid dinitrat', 250000.00, 'selesai', 'Hindari aktivitas berat'),
(7, 7, 7, 6, '2025-01-08', '11:45:00', 'Gatal-gatal', 'Dermatitis alergi', 'Pemeriksaan kulit', 'Antihistamin, salep', 130000.00, 'selesai', 'Hindari alergen'),
(8, 8, 8, 7, '2025-01-08', '12:15:00', 'Telinga berdenging', 'Tinnitus', 'Pemeriksaan THT', 'Betahistin', 140000.00, 'selesai', 'Hindari suara keras'),
(9, 9, 9, 8, '2025-01-08', '12:45:00', 'Sakit kepala', 'Tension headache', 'Pemeriksaan neurologis', 'Ibuprofen', 160000.00, 'selesai', 'Kelola stress dengan baik'),
(10, 10, 10, 1, '2025-01-08', '13:15:00', 'Cek kesehatan rutin', 'Sehat', 'Medical check up', 'Vitamin C', 300000.00, 'selesai', 'Kondisi kesehatan baik'),
(11, 11, 11, 2, '2025-01-09', '08:45:00', 'Imunisasi anak', 'Sehat', 'Vaksinasi DPT', 'Tidak ada', 80000.00, 'selesai', 'Vaksinasi berhasil'),
(12, 12, 12, 3, '2025-01-09', '09:15:00', 'Kontrol kehamilan', 'Kehamilan normal', 'USG, konsultasi', 'Asam folat', 180000.00, 'selesai', 'Perkembangan janin baik'),
(13, 13, 13, 4, '2025-01-09', '09:45:00', 'Periksa mata', 'Mata sehat', 'Pemeriksaan mata lengkap', 'Tidak ada', 150000.00, 'selesai', 'Mata dalam kondisi sehat'),
(14, 14, 14, 5, '2025-01-09', '10:15:00', 'Konsultasi jantung', 'Jantung sehat', 'EKG, echo', 'Tidak ada', 280000.00, 'selesai', 'Fungsi jantung normal'),
(15, 15, 15, 6, '2025-01-09', '10:45:00', 'Perawatan kulit', 'Jerawat', 'Konsultasi dermatologi', 'Tretinoin gel', 170000.00, 'selesai', 'Gunakan obat sesuai petunjuk');

-- --------------------------------------------------------
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('cash','debit','credit','transfer','qris') DEFAULT 'cash',
  `status_pembayaran` enum('lunas','cicil','belum_bayar') DEFAULT 'belum_bayar',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemeriksaan`, `id_pasien`, `tanggal_bayar`, `total_bayar`, `metode_pembayaran`, `status_pembayaran`, `keterangan`) VALUES
(1, 1, 1, '2025-01-08', 150000.00, 'cash', 'lunas', 'Pembayaran tunai'),
(2, 2, 2, '2025-01-08', 120000.00, 'qris', 'lunas', 'Pembayaran QRIS'),
(3, 3, 3, '2025-01-08', 100000.00, 'debit', 'lunas', 'Pembayaran kartu debit'),
(4, 4, 4, '2025-01-08', 200000.00, 'transfer', 'lunas', 'Transfer bank'),
(5, 5, 5, '2025-01-08', 180000.00, 'cash', 'lunas', 'Pembayaran tunai'),
(6, 6, 6, '2025-01-08', 250000.00, 'credit', 'lunas', 'Kartu kredit'),
(7, 7, 7, '2025-01-08', 130000.00, 'cash', 'lunas', 'Pembayaran tunai'),
(8, 8, 8, '2025-01-08', 140000.00, 'qris', 'lunas', 'Pembayaran QRIS'),
(9, 9, 9, '2025-01-08', 160000.00, 'debit', 'lunas', 'Kartu debit'),
(10, 10, 10, '2025-01-08', 300000.00, 'transfer', 'lunas', 'Transfer bank'),
(11, 11, 11, '2025-01-09', 80000.00, 'cash', 'lunas', 'Pembayaran tunai'),
(12, 12, 12, '2025-01-09', 180000.00, 'qris', 'lunas', 'Pembayaran QRIS'),
(13, 13, 13, '2025-01-09', 150000.00, 'cash', 'lunas', 'Pembayaran tunai'),
(14, 14, 14, '2025-01-09', 280000.00, 'transfer', 'lunas', 'Transfer bank'),
(15, 15, 15, '2025-01-09', 170000.00, 'debit', 'lunas', 'Kartu debit');

-- --------------------------------------------------------
-- Struktur dari tabel `tb_review_pasien`
--

CREATE TABLE `tb_review_pasien` (
  `id_review` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT 4.0,
  `ulasan` text NOT NULL,
  `kategori_layanan` varchar(50) DEFAULT 'Konsultasi Umum',
  `tanggal_kunjungan` date NOT NULL,
  `tanggal_review` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status_review` enum('aktif','nonaktif','pending') DEFAULT 'aktif',
  `helpful_count` int(11) DEFAULT 0,
  `response_klinik` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_review_pasien`
--

INSERT INTO `tb_review_pasien` (`id_review`, `id_pasien`, `rating`, `ulasan`, `kategori_layanan`, `tanggal_kunjungan`, `helpful_count`, `response_klinik`) VALUES
-- Reviews Rating Tinggi (4.0 - 5.0)
(1, 1, 5.0, 'Pelayanan sangat memuaskan! Dokter sangat profesional dan ramah. Fasilitas klinik juga bersih dan nyaman. Waktu tunggu tidak terlalu lama.', 'Konsultasi Umum', '2024-08-15', 12, 'Terima kasih atas feedback positifnya, Pak Ahmad! Kami senang dapat memberikan pelayanan terbaik.'),
(2, 3, 4.8, 'Dokter memberikan penjelasan yang sangat detail tentang kondisi kesehatan saya. Staff administrasi juga sangat membantu dalam proses pendaftaran.', 'Pemeriksaan Spesialis', '2024-08-20', 8, 'Terima kasih Pak Budi. Tim kami memang selalu berusaha memberikan penjelasan yang komprehensif.'),
(3, 6, 4.9, 'Sebagai sesama dokter, saya sangat mengapresiasi profesionalisme tim medis di sini. Diagnosis akurat dan pengobatan efektif.', 'Konsultasi Spesialis', '2024-08-25', 15, 'Terima kasih Dr. Maya atas kepercayaannya. Kami bangga bisa melayani rekan sejawat.'),
(4, 9, 4.7, 'Sistem antrian digital sangat membantu. Tidak perlu menunggu lama dan bisa memantau nomor antrian secara real-time.', 'Pemeriksaan Rutin', '2024-09-01', 10, 'Senang mendengar sistem digital kami membantu, Pak Joko. Inovasi untuk kenyamanan pasien.'),
(5, 12, 4.6, 'Tim perawat sangat caring dan professional. Proses pemeriksaan berjalan lancar dari awal hingga akhir.', 'Konsultasi Umum', '2024-09-05', 7, 'Tim perawat kami memang dilatih untuk memberikan care terbaik. Terima kasih Bu Lina!'),
(6, 15, 4.8, 'Harga treatment reasonable dan kualitas pelayanan excellent. Highly recommended untuk keluarga.', 'Medical Checkup', '2024-09-10', 11, 'Terima kasih atas rekomendasi Pak Hendra. Kami berkomitmen pada value for money.'),
(7, 22, 5.0, 'Sebagai mahasiswa, saya merasa sangat terbantu dengan program konsultasi untuk anak muda. Dokter sangat understanding.', 'Konsultasi Psikologi', '2024-09-15', 14, 'Program khusus mahasiswa memang prioritas kami. Senang bisa membantu Nabila!'),
(8, 26, 4.9, 'Konsultasi gizi sangat membantu untuk program diet sehat saya. Dokter memberikan panduan yang praktis dan mudah diikuti.', 'Konsultasi Gizi', '2024-09-20', 9, 'Tim gizi kami selalu memberikan panduan yang aplikatif. Semangat diet sehatnya Bu Ratna!'),
(9, 29, 4.7, 'Sebagai personal trainer, saya butuh pemeriksaan kesehatan rutin. Klinik ini sangat mendukung gaya hidup aktif saya.', 'Medical Checkup', '2024-09-25', 6, 'Senang bisa mendukung gaya hidup sehat Pak Yoga. Health is wealth!'),
(10, 33, 4.5, 'Pemeriksaan untuk usia 50+ sangat thorough. Tim medis sangat berpengalaman menangani pasien dewasa.', 'Geriatri Checkup', '2024-10-01', 8, 'Tim geriatri kami memang berpengalaman. Terima kasih kepercayaannya Pak Sukardi.'),

-- Reviews Rating Sedang (3.0 - 3.9)
(11, 4, 3.8, 'Pelayanan baik, tapi waktu tunggu agak lama terutama pada jam sibuk. Mungkin perlu penambahan dokter.', 'Konsultasi Umum', '2024-08-18', 5, 'Terima kasih feedback-nya Bu Dewi. Kami sedang evaluasi untuk menambah jadwal dokter.'),
(12, 8, 3.5, 'Fasilitas cukup baik, namun sistem pembayaran masih perlu diperbaiki. Proses agak lama.', 'Pemeriksaan Lab', '2024-08-28', 3, 'Noted Bu Rina. Tim IT sedang upgrade sistem pembayaran untuk proses yang lebih cepat.'),
(13, 14, 3.7, 'Dokter professional, tapi ruang tunggu kurang nyaman. AC terlalu dingin dan kursi kurang empuk.', 'Konsultasi Umum', '2024-09-08', 4, 'Terima kasih Bu Sari. Kami akan evaluasi pengaturan AC dan furniture ruang tunggu.'),
(14, 18, 3.6, 'Pelayanan ramah, tapi parkir agak susah terutama weekend. Mungkin perlu kerja sama dengan gedung sekitar.', 'Vaksinasi Anak', '2024-09-12', 2, 'Feedback penting tentang parkir. Kami sedang koordinasi dengan pengelola gedung.'),
(15, 25, 3.4, 'Konsultasi bagus, tapi biaya agak mahal untuk mahasiswa. Semoga ada program subsidi.', 'Konsultasi Umum', '2024-09-18', 6, 'Kami mempertimbangkan program khusus mahasiswa. Terima kasih saran Fajar.'),

-- Reviews Rating Rendah (2.0 - 2.9)  
(16, 7, 2.8, 'Waktu tunggu sangat lama, hampir 2 jam. Sistem antrian perlu diperbaiki. Staff kurang komunikatif.', 'Konsultasi Umum', '2024-08-22', 1, 'Maaf atas ketidaknyamanan Pak Indra. Kami sedang perbaiki sistem antrian dan training staff.'),
(17, 11, 2.5, 'Dokter terburu-buru, kurang memberikan penjelasan detail. Merasa kurang puas dengan konsultasi.', 'Konsultasi Umum', '2024-09-03', 2, 'Maaf Pak Agus. Kami akan follow up dengan dokter terkait untuk improve consultation quality.'),
(18, 19, 2.7, 'Administrasi rumit, banyak form yang harus diisi berulang. Proses bisa disederhanakan.', 'Pemeriksaan Anak', '2024-09-07', 0, 'Terima kasih feedback tentang administrasi. Tim akan simplifikasi prosedur pendaftaran.'),
(19, 24, 2.9, 'Fasilitas untuk anak-anak masih kurang. Tidak ada playground atau area khusus anak di ruang tunggu.', 'Konsultasi Anak', '2024-09-22', 3, 'Noted tentang fasilitas anak. Kami planning untuk kids corner di ruang tunggu.'),
(20, 31, 2.6, 'Petugas kurang sabar menghadapi lansia. Perlu training khusus untuk elderly care.', 'Geriatri Checkup', '2024-10-03', 1, 'Maaf Pak Bambang. Kami akan intensifkan training elderly care untuk seluruh staff.'),

-- Tambahan review untuk pagination (agar tombol Previous/Next berfungsi)
(36, 51, 4.8, 'Pertama kali berobat di sini dan sangat puas! Dokter sangat profesional dan staff ramah sekali.', 'Konsultasi Umum', '2025-07-01', 15, 'Terima kasih Andi! Senang memberikan pelayanan terbaik.'),
(37, 'RM052', 4.6, 'Pelayanan cepat dan tepat. Tidak perlu menunggu lama dan penjelasan dokter sangat detail.', 'Konsultasi Express', '2025-07-02', 8, 'Terima kasih Bu Siti. Efficiency adalah prioritas kami.'),
(38, 'RM053', 4.9, 'Luar biasa! Appreciate banget dengan interior dan layout klinik yang modern. Pelayanan top notch.', 'Medical Checkup', '2025-07-03', 12, 'Terima kasih Pak Budi. Design dan comfort kami perhatikan.'),
(39, 'RM054', 4.4, 'Dokter sangat sabar menjelaskan kondisi kesehatan dan memberikan saran yang praktis untuk guru.', 'Konsultasi Kesehatan', '2025-07-04', 7, 'Terima kasih Bu Dewi. Edukasi kesehatan adalah prioritas.'),
(40, 'RM055', 4.7, 'Sistem booking online mudah digunakan. Fleksibilitas jadwal sangat membantu photographer mobile.', 'Konsultasi Online', '2025-07-05', 9, 'Technology untuk kemudahan pasien adalah focus kami.'),
(41, 'RM056', 5.0, 'Sebagai sesama tenaga medis, saya appreciate protokol dan SOP yang ketat. Professional!', 'Konsultasi Spesialis', '2025-07-06', 18, 'Recognition dari fellow healthcare professional sangat meaningful.'),
(42, 'RM057', 3.8, 'Pelayanan bagus, tapi parking area agak terbatas. Perlu solusi parkir alternatif.', 'Konsultasi Umum', '2025-07-07', 4, 'Tim management sedang evaluasi solusi parking yang adequate.'),
(43, 'RM058',  4.2, 'Konsultasi legal health issue sangat informatif. Dokter understand aspek hukum kesehatan.', 'Occupational Health', '2025-07-08', 6, 'Tim kami memiliki understanding workplace health regulations.'),
(44, 'RM059', 4.5, 'Efficient service untuk executive. Waktu konsultasi tepat dan comprehensive screening.', 'Executive Checkup', '2025-07-09', 11, 'Executive package designed untuk efficiency dan comprehensiveness.');

-- --------------------------------------------------------
-- VIEW KHUSUS UNTUK MONITORING DAN STATISTIK OBAT
-- ========================================

-- View untuk dashboard utama
CREATE VIEW `v_dashboard_summary` AS
SELECT 
    (SELECT COUNT(*) FROM tb_pasien WHERE DATE(created_at) = CURDATE()) as pasien_hari_ini,
    (SELECT COUNT(*) FROM tb_pendaftaran WHERE tanggal_pendaftaran = CURDATE()) as pendaftaran_hari_ini,
    (SELECT COUNT(*) FROM tb_pemeriksaan WHERE tanggal_pemeriksaan = CURDATE()) as pemeriksaan_hari_ini,
    (SELECT COALESCE(SUM(total_bayar), 0) FROM pembayaran WHERE tanggal_bayar = CURDATE()) as pendapatan_hari_ini,
    (SELECT COUNT(*) FROM tb_obat WHERE stok <= stok_minimum) as obat_stok_menipis,
    (SELECT COUNT(*) FROM tb_dokter WHERE status_dokter = 'aktif') as dokter_aktif,
    (SELECT COUNT(*) FROM tb_user WHERE status_aktif = 'aktif') as user_aktif,
    (SELECT COUNT(*) FROM tb_pendaftaran WHERE status_pendaftaran = 'menunggu' AND tanggal_pendaftaran = CURDATE()) as antrian_menunggu;

-- View untuk laporan keuangan bulanan
CREATE VIEW `v_laporan_keuangan_bulanan` AS
SELECT 
    YEAR(p.tanggal_bayar) as tahun,
    MONTH(p.tanggal_bayar) as bulan,
    MONTHNAME(p.tanggal_bayar) as nama_bulan,
    COUNT(p.id_pembayaran) as total_transaksi,
    SUM(p.total_bayar) as total_pendapatan,
    AVG(p.total_bayar) as rata_pendapatan_per_transaksi,
    (SELECT COALESCE(SUM(jumlah), 0) FROM pengeluaran WHERE YEAR(tanggal) = YEAR(p.tanggal_bayar) AND MONTH(tanggal) = MONTH(p.tanggal_bayar)) as total_pengeluaran,
    (SUM(p.total_bayar) - (SELECT COALESCE(SUM(jumlah), 0) FROM pengeluaran WHERE YEAR(tanggal) = YEAR(p.tanggal_bayar) AND MONTH(tanggal) = MONTH(p.tanggal_bayar))) as keuntungan_bersih
FROM pembayaran p
WHERE p.status_pembayaran = 'lunas'
GROUP BY YEAR(p.tanggal_bayar), MONTH(p.tanggal_bayar)
ORDER BY tahun DESC, bulan DESC;

-- View untuk statistik dokter
CREATE VIEW `v_statistik_dokter` AS
SELECT 
    d.id_dokter,
    d.nama_dokter,
    d.spesialisasi,
    COUNT(pm.id_pemeriksaan) as total_pemeriksaan,
    COALESCE(SUM(py.total_bayar), 0) as total_pendapatan,
    COALESCE(AVG(py.total_bayar), 0) as rata_pendapatan_per_pemeriksaan,
    COUNT(CASE WHEN pm.tanggal_pemeriksaan >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as pemeriksaan_30_hari_terakhir
FROM tb_dokter d
LEFT JOIN tb_pemeriksaan pm ON d.id_dokter = pm.id_dokter
LEFT JOIN pembayaran py ON pm.id_pemeriksaan = py.id_pemeriksaan AND py.status_pembayaran = 'lunas'
WHERE d.status_dokter = 'aktif'
GROUP BY d.id_dokter, d.nama_dokter, d.spesialisasi
ORDER BY total_pemeriksaan DESC;

-- View untuk analisis obat
CREATE VIEW `v_analisis_obat` AS
SELECT 
    o.id_obat,
    o.kode_obat,
    o.nama_obat,
    o.kategori,
    o.stok,
    o.stok_minimum,
    o.harga_satuan,
    CASE 
        WHEN o.stok <= 0 THEN 'Habis'
        WHEN o.stok <= o.stok_minimum THEN 'Stok Menipis'
        WHEN o.stok <= (o.stok_minimum * 2) THEN 'Perlu Restok'
        ELSE 'Stok Aman'
    END as status_stok,
    DATEDIFF(o.expired_date, CURDATE()) as hari_sampai_expired,
    CASE 
        WHEN DATEDIFF(o.expired_date, CURDATE()) <= 0 THEN 'Expired'
        WHEN DATEDIFF(o.expired_date, CURDATE()) <= 30 THEN 'Akan Expired'
        WHEN DATEDIFF(o.expired_date, CURDATE()) <= 90 THEN 'Perhatian'
        ELSE 'Aman'
    END as status_expired
FROM tb_obat o
WHERE o.status_obat = 'aktif'
ORDER BY o.stok ASC, hari_sampai_expired ASC;

-- View untuk laporan pasien
CREATE VIEW `v_laporan_pasien` AS
SELECT 
    p.id_pasien,
    p.no_rm,
    p.nama_pasien,
    p.jenis_kelamin,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as umur,
    COUNT(pd.id_pendaftaran) as total_kunjungan,
    MAX(pd.tanggal_pendaftaran) as kunjungan_terakhir,
    COALESCE(SUM(py.total_bayar), 0) as total_pembayaran,
    GROUP_CONCAT(DISTINCT d.nama_dokter SEPARATOR ', ') as dokter_yang_menangani
FROM tb_pasien p
LEFT JOIN tb_pendaftaran pd ON p.id_pasien = pd.id_pasien
LEFT JOIN tb_pemeriksaan pm ON pd.id_pendaftaran = pm.id_pendaftaran
LEFT JOIN pembayaran py ON pm.id_pemeriksaan = py.id_pemeriksaan AND py.status_pembayaran = 'lunas'
LEFT JOIN tb_dokter d ON pm.id_dokter = d.id_dokter
GROUP BY p.id_pasien, p.no_rm, p.nama_pasien, p.jenis_kelamin, p.tanggal_lahir
ORDER BY total_kunjungan DESC;

-- View untuk monitoring user activity
CREATE VIEW `v_user_activity_summary` AS
SELECT 
    u.id_user,
    u.username,
    u.nama_lengkap,
    u.jabatan,
    u.status_aktif,
    u.last_login,
    u.login_count,
    COUNT(ul.id) as total_login_attempts,
    COUNT(CASE WHEN ul.status_login = 'success' THEN 1 END) as successful_logins,
    COUNT(CASE WHEN ul.status_login = 'failed' THEN 1 END) as failed_logins,
    MAX(ul.login_time) as last_activity,
    AVG(ul.session_duration) as avg_session_duration
FROM tb_user u
LEFT JOIN user_login_log ul ON u.id_user = ul.user_id
GROUP BY u.id_user, u.username, u.nama_lengkap, u.jabatan, u.status_aktif, u.last_login, u.login_count
ORDER BY u.last_login DESC;

-- View khusus untuk monitoring obat (HANYA UNTUK OBAT)
CREATE VIEW IF NOT EXISTS `v_monitoring_obat` AS
SELECT 
    o.id_obat,
    o.nama_obat,
    o.kode_obat,
    o.kategori,
    o.bentuk_obat,
    o.stok,
    o.stok_minimum,
    o.harga_satuan,
    o.produsen,
    COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'keluar' AND MONTH(t.tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(t.tanggal_transaksi) = YEAR(CURDATE()) THEN t.jumlah ELSE 0 END), 0) as terjual_bulan_ini,
    CASE 
        WHEN o.stok <= 0 THEN 'Habis'
        WHEN o.stok <= o.stok_minimum THEN 'Critical'
        WHEN o.stok <= (o.stok_minimum * 2) THEN 'Low'
        WHEN o.stok <= (o.stok_minimum * 5) THEN 'Medium'
        ELSE 'Good'
    END as status_stok
FROM tb_obat o
LEFT JOIN tb_transaksi_obat t ON o.id_obat = t.id_obat
WHERE o.status_obat = 'aktif'
GROUP BY o.id_obat, o.nama_obat, o.kode_obat, o.kategori, o.bentuk_obat, o.stok, o.stok_minimum, o.harga_satuan, o.produsen
ORDER BY terjual_bulan_ini DESC;

-- View untuk statistik obat bulanan (HANYA UNTUK OBAT)
CREATE VIEW IF NOT EXISTS `v_statistik_obat_bulanan` AS
SELECT 
    DATE_FORMAT(t.tanggal_transaksi, '%Y-%m') as periode,
    o.nama_obat,
    o.kategori,
    SUM(CASE WHEN t.jenis_transaksi = 'keluar' THEN t.jumlah ELSE 0 END) as total_terjual,
    SUM(CASE WHEN t.jenis_transaksi = 'keluar' THEN t.total_nilai ELSE 0 END) as total_pendapatan
FROM tb_obat o
LEFT JOIN tb_transaksi_obat t ON o.id_obat = t.id_obat
WHERE o.status_obat = 'aktif'
AND t.tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
GROUP BY DATE_FORMAT(t.tanggal_transaksi, '%Y-%m'), o.nama_obat, o.kategori
ORDER BY periode DESC, total_terjual DESC;

COMMIT;

-- ========================================
-- END OF SQL SCRIPT
-- ========================================
