-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Okt 2024 pada 13.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cuti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_jenis_cuti` int(11) DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `lama_cuti` int(11) NOT NULL DEFAULT 0,
  `sisa_cuti` int(11) NOT NULL DEFAULT 0,
  `alasan` text DEFAULT NULL,
  `id_persetujuan` int(11) DEFAULT NULL,
  `catatan_pimpinan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id`, `id_user`, `id_jenis_cuti`, `tanggal_pengajuan`, `tanggal_mulai`, `tanggal_selesai`, `lama_cuti`, `sisa_cuti`, `alasan`, `id_persetujuan`, `catatan_pimpinan`) VALUES
(1, 4, 1, '2024-09-24', '2024-10-01', '2024-10-07', 7, 5, 'Cuti tahunan untuk istirahat', 1, 'Cuti yang diajukan disetujui');

--
-- Trigger `cuti`
--
DELIMITER $$
CREATE TRIGGER `hitung_cuti` BEFORE INSERT ON `cuti` FOR EACH ROW BEGIN
    DECLARE total_cuti INT;

    -- Ambil durasi dari jenis cuti yang dipilih
    SELECT durasi INTO total_cuti
    FROM jenis_cuti
    WHERE id_jenis_cuti = NEW.id_jenis_cuti;

    -- Tentukan lama cuti dan hitung sisa cuti berdasarkan jenis cuti
    IF NEW.id_jenis_cuti = 1 THEN
        -- Cuti Tahunan
        SET NEW.lama_cuti = total_cuti;
        SET NEW.sisa_cuti = total_cuti - NEW.lama_cuti;
    ELSEIF NEW.id_jenis_cuti = 2 THEN
        -- Cuti Sakit
        SET NEW.lama_cuti = total_cuti;
        SET NEW.sisa_cuti = total_cuti - NEW.lama_cuti;
    ELSEIF NEW.id_jenis_cuti = 3 THEN
        -- Cuti Melahirkan
        SET NEW.lama_cuti = total_cuti;
        SET NEW.sisa_cuti = total_cuti - NEW.lama_cuti;
    ELSEIF NEW.id_jenis_cuti = 4 THEN
        -- Cuti Besar
        SET NEW.lama_cuti = total_cuti;
        SET NEW.sisa_cuti = total_cuti - NEW.lama_cuti;
    ELSEIF NEW.id_jenis_cuti = 5 THEN
        -- Cuti Alasan Penting
        SET NEW.lama_cuti = total_cuti;
        SET NEW.sisa_cuti = total_cuti - NEW.lama_cuti;
    ELSEIF NEW.id_jenis_cuti = 6 THEN
        -- Cuti Diluar Tanggungan Negara
        SET NEW.lama_cuti = 0;
        SET NEW.sisa_cuti = 0;
    END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`) VALUES
(1, 'Pegawai'),
(2, 'Kepala Ruangan'),
(3, 'Kasubbag Umum'),
(4, 'Kepala Kepelayanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_cuti`
--

CREATE TABLE `jenis_cuti` (
  `id` int(11) NOT NULL,
  `nama_jenis_cuti` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `durasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_cuti`
--

INSERT INTO `jenis_cuti` (`id`, `nama_jenis_cuti`, `keterangan`, `durasi`) VALUES
(1, 'Cuti Tahunan', 'Cuti yang diambil setiap tahun.', 12),
(2, 'Cuti Sakit', 'Cuti yang diambil karena alasan kesehatan.', 30),
(3, 'Cuti Melahirkan', 'Cuti untuk pegawai wanita yang melahirkan.', 90),
(4, 'Cuti Besar', 'Cuti yang diambil dalam waktu lama untuk keperluan tertentu.', 30),
(5, 'Cuti Alasan Penting', 'Cuti untuk alasan mendesak atau penting.', 14),
(6, 'Cuti Diluar Tanggungan Negara', 'Cuti tanpa pembayaran dari negara.', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `nip` varchar(20) NOT NULL,
  `status_pegawai` enum('Tetap','THL') NOT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `id_user`, `id_jabatan`, `id_ruangan`, `nip`, `status_pegawai`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `telepon`, `email`) VALUES
(1, 4, 1, 1, '123456789', 'Tetap', 'Jl. Kebon Jeruk No. 10', '2001-09-01', 'Perempuan', '08123456789', 'rina01@gmail.com'),
(2, 5, 1, 1, '987654321', 'THL', 'Jl. Melati No. 5', '2001-06-21', 'Laki-laki', '08129876543', 'dedi02@gmail.com'),
(3, 6, 1, 2, '192837465', 'Tetap', 'Jl. Mangga No. 12', '2001-10-02', 'Perempuan', '08123412345', 'lina03@gmail.com'),
(4, 1, 2, 1, '192837465', 'Tetap', 'Jl. Mangga No. 12', '1987-09-02', 'Laki-laki', '08123412345', 'budikr1@gmail.com'),
(5, 2, 3, 4, '192837465', 'Tetap', 'Jl. Mangga No. 12', '1980-07-10', 'Laki-laki', '08123412345', 'andiksbu1@gmail.com'),
(6, 3, 4, 5, '564738291', 'Tetap', 'Jl. Mawar No. 7', '1980-10-15', 'Perempuan', '08129875432', 'sitikk1@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_ruangan_jabatan`
--

CREATE TABLE `pegawai_ruangan_jabatan` (
  `id_user` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `persetujuan`
--

CREATE TABLE `persetujuan` (
  `id` int(11) NOT NULL,
  `id_cuti` int(11) NOT NULL,
  `id_jenis_cuti` int(11) DEFAULT NULL,
  `id_pimpinan1` int(11) NOT NULL,
  `id_pimpinan2` int(11) NOT NULL,
  `id_pimpinan3` int(11) NOT NULL,
  `status_pimpinan1` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `status_pimpinan2` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `status_pimpinan3` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal_persetujuan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `persetujuan`
--

INSERT INTO `persetujuan` (`id`, `id_cuti`, `id_jenis_cuti`, `id_pimpinan1`, `id_pimpinan2`, `id_pimpinan3`, `status_pimpinan1`, `status_pimpinan2`, `status_pimpinan3`, `tanggal_persetujuan`) VALUES
(1, 1, 1, 2, 3, 4, 'disetujui', 'disetujui', 'disetujui', '2024-09-26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pimpinan_ruangan`
--

CREATE TABLE `pimpinan_ruangan` (
  `id_user` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekapitulasi_cuti`
--

CREATE TABLE `rekapitulasi_cuti` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_cuti` int(11) NOT NULL,
  `id_jenis_cuti` int(11) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `total_hari` int(11) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `status_cuti` varchar(50) NOT NULL,
  `alasan_pengajuan` text DEFAULT NULL,
  `tanggal_dikonfirmasi` date DEFAULT NULL,
  `id_pimpinan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(4) NOT NULL,
  `nama_role` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `nama_role`) VALUES
(1, 'Pegawai'),
(2, 'Admin'),
(3, 'Pimpinan1'),
(4, 'Pimpinan2'),
(5, 'Pimpinan3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int(11) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id`, `nama_ruangan`) VALUES
(1, 'Ruangan IT'),
(2, 'Ruangan Perawat'),
(3, 'Ruangan Loket'),
(4, 'Ruangan Umum'),
(5, 'Ruangan Pelayanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `id_role` int(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_role`, `username`, `email`, `password`, `nama`) VALUES
(1, 3, 'budi', 'budikr1@gmail.com', 'budi123', 'Budi Santoso'),
(2, 4, 'andi', 'andiksbu1@gmail.com', 'andi123', 'Andi Saputra'),
(3, 5, 'siti', 'sitikk1@gmail.com', 'siti123', 'Siti Rahmawati'),
(4, 1, 'rina', 'rina01@gmail.com', 'rina', 'Rina Wijaya'),
(5, 1, 'dedi', 'dedi02@gmail.com', 'dedi', 'Dedi Suryadi'),
(6, 1, 'lina', 'lina03@gmail.com', 'lina', 'Lina Agustina'),
(7, 2, 'admin', 'admin02@gmail.com', 'admin123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_jenis_cuti` (`id_jenis_cuti`),
  ADD KEY `id_persetujuan` (`id_persetujuan`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_cuti`
--
ALTER TABLE `jenis_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indeks untuk tabel `pegawai_ruangan_jabatan`
--
ALTER TABLE `pegawai_ruangan_jabatan`
  ADD PRIMARY KEY (`id_user`,`id_ruangan`,`id_jabatan`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `persetujuan`
--
ALTER TABLE `persetujuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengajuan_cuti` (`id_cuti`),
  ADD KEY `id_pimpinan1` (`id_pimpinan1`),
  ADD KEY `id_pimpinan2` (`id_pimpinan2`),
  ADD KEY `id_pimpinan3` (`id_pimpinan3`),
  ADD KEY `fk_id_cuti` (`id_jenis_cuti`);

--
-- Indeks untuk tabel `pimpinan_ruangan`
--
ALTER TABLE `pimpinan_ruangan`
  ADD PRIMARY KEY (`id_user`,`id_ruangan`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indeks untuk tabel `rekapitulasi_cuti`
--
ALTER TABLE `rekapitulasi_cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`),
  ADD KEY `id_cuti` (`id_cuti`),
  ADD KEY `id_jenis_cuti` (`id_jenis_cuti`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jenis_cuti`
--
ALTER TABLE `jenis_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `persetujuan`
--
ALTER TABLE `persetujuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rekapitulasi_cuti`
--
ALTER TABLE `rekapitulasi_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cuti_ibfk_2` FOREIGN KEY (`id_jenis_cuti`) REFERENCES `jenis_cuti` (`id`),
  ADD CONSTRAINT `id_persetujuan` FOREIGN KEY (`id_persetujuan`) REFERENCES `persetujuan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pegawai_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`),
  ADD CONSTRAINT `pegawai_ibfk_3` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id`);

--
-- Ketidakleluasaan untuk tabel `pegawai_ruangan_jabatan`
--
ALTER TABLE `pegawai_ruangan_jabatan`
  ADD CONSTRAINT `pegawai_ruangan_jabatan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pegawai_ruangan_jabatan_ibfk_2` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id`),
  ADD CONSTRAINT `pegawai_ruangan_jabatan_ibfk_3` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`);

--
-- Ketidakleluasaan untuk tabel `persetujuan`
--
ALTER TABLE `persetujuan`
  ADD CONSTRAINT `fk_id_cuti` FOREIGN KEY (`id_jenis_cuti`) REFERENCES `cuti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persetujuan_ibfk_1` FOREIGN KEY (`id_cuti`) REFERENCES `cuti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `persetujuan_ibfk_2` FOREIGN KEY (`id_pimpinan1`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `persetujuan_ibfk_3` FOREIGN KEY (`id_pimpinan2`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `persetujuan_ibfk_4` FOREIGN KEY (`id_pimpinan3`) REFERENCES `pegawai` (`id`);

--
-- Ketidakleluasaan untuk tabel `pimpinan_ruangan`
--
ALTER TABLE `pimpinan_ruangan`
  ADD CONSTRAINT `pimpinan_ruangan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pimpinan_ruangan_ibfk_2` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id`);

--
-- Ketidakleluasaan untuk tabel `rekapitulasi_cuti`
--
ALTER TABLE `rekapitulasi_cuti`
  ADD CONSTRAINT `rekapitulasi_cuti_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `rekapitulasi_cuti_ibfk_2` FOREIGN KEY (`id_cuti`) REFERENCES `cuti` (`id`),
  ADD CONSTRAINT `rekapitulasi_cuti_ibfk_3` FOREIGN KEY (`id_jenis_cuti`) REFERENCES `jenis_cuti` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
