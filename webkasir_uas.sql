-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jul 2024 pada 14.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webkasir_uas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_reports`
--

CREATE TABLE `sales_reports` (
  `id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `total_income` decimal(10,2) NOT NULL,
  `rice_sold` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sales_reports`
--

INSERT INTO `sales_reports` (`id`, `report_date`, `total_income`, `rice_sold`) VALUES
(0, '2024-07-15', 4528000.00, '[{\"rice_name\":\"Beras Ekonomis Rojolele 5 KG\",\"total_quantity\":\"3\"},{\"rice_name\":\"Beras Rojolele Pulen 10 KG\",\"total_quantity\":\"10\"},{\"rice_name\":\"Beras Super Rojolele 10 KG\",\"total_quantity\":\"5\"},{\"rice_name\":\"Beras Super Rojolele 25 KG\",\"total_quantity\":\"5\"}]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `customer_id` varchar(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `notelp_pelanggan` varchar(13) NOT NULL,
  `customer_address` text NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `status` enum('Pending','Delivered') NOT NULL DEFAULT 'Pending',
  `totalKeseluruhan` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `customer_id`, `customer_name`, `notelp_pelanggan`, `customer_address`, `order_date`, `delivery_date`, `status`, `totalKeseluruhan`, `amount_paid`) VALUES
(14, 'PO0001', 'P0001', 'Nadya', '08387144087', 'Villa Mutiara Jaya, Cibitung', '2024-06-28', '2024-06-29', 'Delivered', 1625000.00, 1650000.00),
(15, 'PO0002', 'P0002', 'Hanifa', '087779235243', 'Tambun', '2024-07-08', '2024-07-10', 'Delivered', 228000.00, 400000.00),
(16, 'PO0003', 'P0003', 'Christian', '087727263587', 'Bekasi', '2024-07-08', '2024-07-10', 'Pending', 1950000.00, 2000000.00),
(17, 'PO0004', 'P0004', 'Ferina', '08387144087', 'Bekasi', '2024-07-15', '2024-07-16', 'Pending', 725000.00, 750000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `rice_code` varchar(50) NOT NULL,
  `rice_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaction_items`
--

INSERT INTO `transaction_items` (`id`, `transaction_id`, `rice_code`, `rice_name`, `quantity`, `price`, `total`) VALUES
(64, '14', 'BR003', 'Beras Rojolele Pulen 10 KG', 5, 145000.00, 725000.00),
(65, '14', 'BR004', 'Beras Super Rojolele 10 KG', 5, 180000.00, 900000.00),
(66, '16', 'BR006', 'Beras Super Rojolele 25 KG', 5, 390000.00, 1950000.00),
(69, '15', 'BR001', 'Beras Ekonomis Rojolele 5 KG', 3, 76000.00, 228000.00),
(70, '17', 'BR003', 'Beras Rojolele Pulen 10 KG', 5, 145000.00, 725000.00);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `sales_reports`
--
ALTER TABLE `sales_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
