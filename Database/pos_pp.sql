-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2023 at 07:27 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_pp`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(5) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`, `date_created`, `date_modified`) VALUES
(1, 'Noodle', '2023-02-02 06:26:28', '2023-02-02 05:26:40'),
(2, 'Snack', '2023-02-02 06:27:46', '2023-02-02 05:27:52'),
(3, 'Ice Cream', '2023-02-02 06:28:06', '2023-02-02 05:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int(5) NOT NULL,
  `nama_member` varchar(255) NOT NULL,
  `no_whatsapp` varchar(15) NOT NULL,
  `email_member` varchar(100) NOT NULL,
  `status_member` enum('Y','N') NOT NULL,
  `no_member` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama_member`, `no_whatsapp`, `email_member`, `status_member`, `no_member`) VALUES
(1, 'Richo', '08974633211', 'richo@gmail.com', 'Y', '0223001'),
(2, 'Berliana', '08287655499', 'berliana@gmail.com', 'Y', '0223002');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `total_pembayaran` varchar(50) NOT NULL,
  `total_diskon` varchar(50) NOT NULL,
  `no_pembayaran` varchar(20) NOT NULL,
  `status_bayar` enum('Y','N') NOT NULL,
  `tgl_pembayaran` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_user`, `total_pembayaran`, `total_diskon`, `no_pembayaran`, `status_bayar`, `tgl_pembayaran`) VALUES
(1, 1, '56000', '5600', '0202231244001', 'Y', '2023-03-27 12:26:14'),
(2, 3, '45000', '4500', '0202231246002', 'N', '2023-03-27 12:26:14'),
(3, 3, '99999', '9999', '0202231248003', 'Y', '2023-03-27 12:26:14'),
(4, 2, '42900', '4290', '0202231250004', 'N', '2023-03-27 12:26:14'),
(5, 1, '43000', '4300', '0202231250005', 'Y', '2023-03-27 12:26:14');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produk_id` int(5) NOT NULL,
  `kode_produk` varchar(25) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kategori_id` int(5) NOT NULL,
  `harga_modal` varchar(50) NOT NULL,
  `harga_jual` varchar(50) NOT NULL,
  `stok` int(10) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `expired_date` date NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produk_id`, `kode_produk`, `nama_produk`, `kategori_id`, `harga_modal`, `harga_jual`, `stok`, `gambar`, `expired_date`, `date_created`, `date_modified`) VALUES
(1, '89686010947', 'Indomie Goreng Spesial', 1, '2300', '2700', 1000, 'IndomieGorengSpesial.png', '2024-02-29', '2023-02-02 07:01:43', '2023-02-02 06:11:11'),
(2, '8992112206001', 'Indomie Soto', 1, '2200', '2600', 995, 'IndomieSoto.png', '2023-02-21', '2023-02-02 07:11:17', '2023-02-02 06:12:42'),
(3, '8992981206023', 'Tango Wafer Chocolate', 2, '8888', '10000', 388, 'TangoWaferChocolate.png', '2025-04-19', '2023-02-02 07:12:53', '2023-02-02 06:16:26'),
(4, '8992928206231', 'Oreo Ice Cream', 2, '8250', '9000', 558, 'OreoIceCream.png', '2025-05-29', '2023-02-02 07:16:30', '2023-02-02 06:18:38'),
(5, '8999482206023', 'Cornetto Oreo', 3, '11400', '12000', 500, 'CornettoOreo.png', '2025-06-19', '2023-02-02 07:18:45', '2023-02-02 06:21:09');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id_setting` int(5) NOT NULL,
  `option_key` varchar(255) NOT NULL,
  `option_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(5) NOT NULL,
  `id_produk` int(5) NOT NULL,
  `id_pembayaran` int(5) NOT NULL,
  `jml_pesan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_produk`, `id_pembayaran`, `jml_pesan`) VALUES
(1, 1, 1, 5),
(2, 2, 2, 7),
(3, 3, 3, 5),
(4, 1, 4, 3),
(5, 3, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(200) NOT NULL,
  `email_user` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `email_user`, `password`, `role`) VALUES
(1, 'Fiora', 'fiora@gmail.com', 'c06d7a9ccec88dec9738524d0d1674a56f54204d', 'Admin'),
(2, 'Putri', 'putri@gmail.com', 'e328dd94fe3c1a738abfc36279a21010b6bb2bf9', 'Kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produk_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id_setting` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
