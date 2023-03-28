-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2023 at 08:45 AM
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
(3, 'Ice Cream', '2023-02-02 06:28:06', '2023-02-02 05:28:15'),
(6, 'mixue bandung 1', '2023-02-25 09:20:35', '2023-02-25 03:23:39'),
(8, 'mineral', '2023-02-25 10:38:57', '2023-02-25 03:50:12'),
(9, 'mineral', '2023-02-25 10:41:28', '2023-02-25 03:49:22'),
(10, 'bebek', '2023-02-25 10:41:56', '2023-02-25 03:48:12'),
(11, 'ayam', '2023-02-25 10:46:29', '2023-02-25 03:46:29');

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
(1, 'Lamda', '08974633211', 'lamda@gmail.com', 'Y', '0223001'),
(2, 'Berliana', '08287655499', 'berliana@gmail.com', 'Y', '0223002'),
(3, 'aqil rahman', '083180119574', 'aqilrahaman@kojolah.com', 'Y', '0223003');

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
(1, 1, '56000', '5600', '0202231244001', 'Y', '2023-02-14 19:20:01'),
(2, 3, '45000', '4500', '0202231246002', 'N', '2023-02-14 19:20:01'),
(3, 3, '99999', '9999', '0202231248003', 'Y', '2023-02-15 19:20:01'),
(4, 2, '42900', '4290', '0202231250004', 'N', '2023-02-15 19:20:01'),
(5, 1, '43000', '4300', '0202231250005', 'Y', '2023-02-16 19:20:01'),
(15, 1, '13400', '0', '202302260010', 'Y', '2023-02-17 19:20:01'),
(16, 1, '10800', '0', '202302260011', 'Y', '2023-02-27 19:20:01'),
(17, 1, '10800', '0', '202302260012', 'Y', '2023-02-27 19:20:01'),
(21, 1, '13400', '0', '202302260012', 'Y', '2023-02-27 19:20:01');

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
(1, '89686010947', 'Susu', 1, '2300', '2700', 50, '20230327171253_susu.png', '2023-03-01', '2023-02-02 07:01:43', '2023-03-27 10:20:30'),
(2, '8992112206001', 'Indomie Soto', 1, '2200', '2600', 20, '20230327171253_susu.png', '2023-02-21', '2023-02-02 07:11:17', '2023-03-27 10:20:33'),
(3, '8992981206023', 'Tango Wafer Chocolate', 2, '8888', '10000', 388, 'TangoWaferChocolate.png', '2025-04-19', '2023-02-02 07:12:53', '2023-02-02 06:16:26'),
(4, '8992928206231', 'Oreo Ice Cream', 2, '8250', '9000', 558, 'OreoIceCream.png', '2025-05-29', '2023-02-02 07:16:30', '2023-02-02 06:18:38'),
(5, '8999482206023', 'Cornetto Oreo', 3, '11400', '12000', 500, 'CornettoOreo.png', '2025-06-19', '2023-02-02 07:18:45', '2023-02-02 06:21:09'),
(11, '33222', 'chocolate lucky sundae', 6, '6000', '16000', 2000, '', '2023-03-27', '0000-00-00 00:00:00', '2023-03-26 12:21:57'),
(21, '2323', 'produk 23', 6, '3000', '4000', 200, '20230327164313_wallpaper-laptop-hitam.jpg', '2023-04-08', '2023-03-27 16:43:13', '2023-03-27 09:43:13'),
(22, '2424', 'susu 24', 3, '8000', '9000', 200, '20230327171253_susu.png', '2023-04-01', '2023-03-27 17:12:53', '2023-03-27 10:12:53');

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
(2, 2, 1, 7),
(3, 3, 3, 5),
(4, 1, 4, 3),
(5, 3, 5, 1),
(14, 1, 15, 4),
(15, 2, 15, 1),
(16, 1, 16, 4),
(17, 1, 17, 4),
(24, 1, 21, 4),
(25, 2, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(200) NOT NULL,
  `email_user` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Employee') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `email_user`, `password`, `role`) VALUES
(1, 'Fiora', 'fioberlianaa93@gmail.com', 'c5585f1016847c479709ddf04a5991d708d85980', 'Administrator'),
(2, 'Putri', 'putri@gmail.com', 'e328dd94fe3c1a738abfc36279a21010b6bb2bf9', 'Employee'),
(3, 'aqil rahman', 'aqilrahman23@gmail.com', '990df0ca5582615aa7366805e366ea4ef5cbaaf2', 'Employee'),
(6, 'admin', 'admin@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator');

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
  MODIFY `kategori_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id_setting` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
