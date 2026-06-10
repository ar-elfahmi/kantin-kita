-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2026 at 05:04 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantin_kita`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikels`
--

CREATE TABLE `artikels` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ringkasan` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konten` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_sampul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `author_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikels`
--

INSERT INTO `artikels` (`id`, `judul`, `slug`, `ringkasan`, `konten`, `gambar_sampul`, `kategori`, `status`, `published_at`, `author_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tentang Kantin Kita', 'tentang-kami', 'Kantin Kita memudahkan civitas kampus memesan makanan favorit tanpa antri.', 'Kantin Kita lahir dari kebutuhan civitas kampus untuk memesan makanan dengan cepat dan mudah.\n\nDengan satu platform, kamu bisa melihat menu dari banyak vendor, memesan, dan membayar tanpa harus mengantri panjang.', NULL, 'tentang-kami', 'published', '2026-06-07 12:16:58', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(2, 'Event Vocer belanja', 'event-vocer-belanja', 'test', 'new menu kopi tubruk', 'artikel/2j1vtB00oJR902nw2CmbdRkIrhBnS7bx9RUayceV.jpg', 'tentang-kami', 'published', '2026-06-07 12:28:17', 1, '2026-06-07 12:28:17', '2026-06-10 04:02:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelurahan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodepos` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_blob` longblob,
  `foto_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanans`
--

CREATE TABLE `detail_pesanans` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `harga` int NOT NULL,
  `subtotal` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_pesanans`
--

INSERT INTO `detail_pesanans` (`id`, `pesanan_id`, `menu_id`, `jumlah`, `harga`, `subtotal`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 41, 2, 18000, 36000, NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(2, 2, 42, 1, 15000, 15000, NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(3, 3, 43, 3, 12000, 36000, NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(4, 4, 31, 1, 18000, 18000, NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(5, 4, 35, 1, 5000, 5000, NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(6, 5, 32, 1, 15000, 15000, NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(7, 5, 37, 2, 8000, 16000, NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(8, 6, 26, 1, 18000, 18000, NULL, '2026-06-10 04:06:41', '2026-06-10 04:06:41'),
(9, 6, 27, 1, 24000, 24000, NULL, '2026-06-10 04:06:41', '2026-06-10 04:06:41'),
(10, 7, 50, 1, 10000, 10000, NULL, '2026-06-10 04:13:46', '2026-06-10 04:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `kategori_menus`
--

CREATE TABLE `kategori_menus` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_menus`
--

INSERT INTO `kategori_menus` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Nasi & Lauk', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(2, 'Mie & Bakso', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(3, 'Camilan', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(4, 'Minuman', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(5, 'Dessert', '2026-06-07 12:16:58', '2026-06-07 12:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_toko`
--

CREATE TABLE `kunjungan_toko` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `lokasi_toko_barcode` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_latitude` double NOT NULL,
  `sales_longitude` double NOT NULL,
  `sales_accuracy` double NOT NULL,
  `jarak_meter` double NOT NULL,
  `threshold_efektif` double NOT NULL,
  `status` enum('accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_toko`
--

CREATE TABLE `lokasi_toko` (
  `barcode` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `nama_toko` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `accuracy` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `kategori_menu_id` bigint UNSIGNED DEFAULT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` int NOT NULL,
  `path_gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `id_barang`, `vendor_id`, `kategori_menu_id`, `nama_menu`, `deskripsi`, `harga`, `path_gambar`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'XGQCUTDQ', 1, 1, 'Nasi Rendang Padang', 'Nasi hangat dengan rendang sapi empuk dan sambal ijo.', 26000, 'https://images.pexels.com/photos/1437267/pexels-photo-1437267.jpeg?auto=compress&cs=tinysrgb&w=900&h=600&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(2, 'W5TYLZLE', 1, 1, 'Ayam Bakar Taliwang', 'Ayam bakar bumbu taliwang dengan lalapan dan nasi.', 23000, 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(3, 'PH2TFA3B', 1, 2, 'Soto Betawi', 'Soto kuah santan gurih dengan daging dan kentang goreng.', 22000, 'https://images.unsplash.com/photo-1626804475297-41608ea09aeb?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(4, '5TIJZZWL', 1, 4, 'Es Cendol Gula Aren', 'Cendol segar dengan santan dan gula aren asli.', 12000, 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(5, 'R7G1GSIU', 1, 5, 'Klepon Pandan', 'Klepon lembut isi gula merah, tabur kelapa parut.', 9000, 'https://images.unsplash.com/photo-1541783245831-57d6fb0926d3?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(6, 'HGAJJAAR', 2, 3, 'Classic Beef Burger', 'Burger daging sapi juicy dengan keju dan saus signature.', 32000, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(7, 'IH5SDVNA', 2, 3, 'Chicken Cheese Burger', 'Patty ayam crispy, cheddar, dan mayo garlic.', 29000, 'https://images.unsplash.com/photo-1615297928064-24977384d0da?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(8, 'PC1EVNBR', 2, 3, 'Curly Fries BBQ', 'Kentang goreng spiral dengan bumbu BBQ smoky.', 18000, 'https://images.unsplash.com/photo-1630384060421-cb20d0e0649d?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(9, 'QTFMMGWP', 2, 4, 'Iced Lemon Tea', 'Teh lemon dingin segar untuk teman burger.', 12000, 'https://images.unsplash.com/photo-1499638673689-79a0b5115d87?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(10, '5S3AOYAQ', 2, 5, 'Choco Sundae', 'Es krim vanila dengan saus cokelat dan crumble.', 15000, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(11, 'SGUZUWPS', 3, 4, 'Brown Sugar Boba Milk', 'Susu segar dengan brown sugar syrup dan boba chewy.', 24000, 'https://images.unsplash.com/photo-1558857563-b371033873b8?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(12, 'HYGKYGGO', 3, 4, 'Thai Tea Boba', 'Thai tea creamy dengan topping boba hitam.', 22000, 'https://images.unsplash.com/photo-1525385133512-2f3bdd039054?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(13, 'DZQ1OF1O', 3, 4, 'Matcha Latte Boba', 'Matcha latte premium dengan boba dan foam lembut.', 25000, 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(14, '4NQOWD3H', 3, 4, 'Mango Yakult', 'Perpaduan mangga manis dan yakult menyegarkan.', 21000, 'https://images.unsplash.com/photo-1623065422902-30a2d299bbe4?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(15, 'KMVDAXZP', 3, 5, 'Taro Milk Pudding', 'Pudding taro lembut dengan susu dingin.', 18000, 'https://images.unsplash.com/photo-1464306076886-da185f6a9d05?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(16, 'KKUL1P3S', 4, 2, 'Shoyu Chicken Ramen', 'Ramen kuah shoyu dengan ayam chashu dan telur.', 32000, 'https://images.unsplash.com/photo-1557872943-16a5ac26437e?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(17, 'RNBLRMHB', 4, 2, 'Spicy Miso Ramen', 'Ramen miso pedas dengan irisan ayam dan nori.', 34000, 'https://images.unsplash.com/photo-1623341214825-9f4f963727da?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(18, 'RQLY1ZZY', 4, 3, 'Gyoza Crispy', 'Gyoza goreng renyah isi ayam dan sayur.', 18000, 'https://images.unsplash.com/photo-1627308595229-7830a5c91f9f?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(19, 'IKANW0E9', 4, 4, 'Ocha Dingin', 'Teh hijau dingin tanpa gula, ringan dan segar.', 9000, 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(20, 'DBPI5DQT', 4, 5, 'Mochi Ice Cream', 'Mochi kenyal isi es krim vanila dingin.', 16000, 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&w=900&h=600&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(21, 'ZVCO00LY', 5, 1, 'Chicken Caesar Salad', 'Salad romaine segar dengan ayam panggang dan dressing caesar.', 26000, 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(22, 'RKRDYS4O', 5, 1, 'Grain Bowl Tempe', 'Bowl quinoa, tempe panggang, jagung, dan sayur segar.', 24000, 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(23, 'AECORLSB', 5, 3, 'Edamame Sea Salt', 'Edamame rebus dengan taburan sea salt.', 14000, 'https://images.unsplash.com/photo-1604908177453-7462950a6a3b?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(24, 'CB7OEIDA', 5, 4, 'Infused Lemon Water', 'Air mineral dengan lemon dan mint segar.', 10000, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(25, 'XEDZOR91', 5, 5, 'Greek Yogurt Parfait', 'Yogurt, granola, dan buah segar dalam satu cup.', 18000, 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(26, 'A8B4BTKD', 6, 4, 'Americano Ice', 'Kopi hitam dingin dengan espresso single origin.', 18000, 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(27, 'TGKXNTSS', 6, 4, 'Caramel Latte', 'Latte creamy dengan sentuhan karamel manis.', 24000, 'https://images.pexels.com/photos/1099680/pexels-photo-1099680.jpeg?auto=compress&cs=tinysrgb&w=900&h=600&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(28, '05VBEEON', 6, 4, 'Matcha Espresso Fusion', 'Perpaduan matcha premium dan espresso.', 27000, 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(29, '81WW7FSN', 6, 3, 'Croissant Butter', 'Croissant flaky dengan aroma butter hangat.', 16000, 'https://images.pexels.com/photos/461198/pexels-photo-461198.jpeg?auto=compress&cs=tinysrgb&w=900&h=600&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(30, 'ILFANLPC', 6, 5, 'Chocolate Muffin', 'Muffin cokelat lembut dengan choco chips.', 17000, 'https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(31, 'IKSFFK8A', 7, 1, 'Nasi Gudeg Ayam', 'Gudeg nangka manis khas Jawa dengan ayam kampung yang empuk.', 18000, 'https://api.builder.io/api/v1/image/assets/TEMP/b4868082f44d5fcae80353e16c295d3433235867?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(32, 'YO7ODIGH', 7, 2, 'Mie Ayam Special', 'Mie segar dengan ayam bumbu, sayuran, dan kuah kaldu gurih.', 15000, 'https://api.builder.io/api/v1/image/assets/TEMP/e8073bad16f9206f6db4ed97a46992857a06c541?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(33, 'T60GPZOC', 7, 1, 'Gado-Gado', 'Sayuran segar campur dengan saus kacang kental dan kerupuk.', 12000, 'https://api.builder.io/api/v1/image/assets/TEMP/90cd24b470a76a19da724907cb7eb0904ad6b86c?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(34, 'JU2II60L', 7, 3, 'Sate Ayam', 'Sate ayam bakar dengan saus kacang pedas dan lontong.', 20000, 'https://api.builder.io/api/v1/image/assets/TEMP/a9bee7f0eaa15b4f21efae9546c2163920d61992?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(35, 'AXSS8CRJ', 7, 4, 'Es Teh Manis', 'Teh manis dingin yang menyegarkan, cocok teman makan.', 5000, 'https://api.builder.io/api/v1/image/assets/TEMP/f54094bf7f4c4ebb7a73256c88f3d3e0bb240384?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(36, 'XRW5PTDI', 7, 2, 'Bakso Special', 'Bakso sapi jumbo dengan mie, sayuran segar, dan kuah kaldu.', 16000, 'https://api.builder.io/api/v1/image/assets/TEMP/a4ff2add3eaa657d5f34fabe120343b77624de46?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(37, '6WDRJYXF', 7, 3, 'Pisang Goreng', 'Pisang goreng renyah, camilan manis yang sempurna.', 8000, 'https://api.builder.io/api/v1/image/assets/TEMP/652fb0b468b9036c588a47020389155a651a3a58?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(38, 'FE1ELOPI', 7, 4, 'Es Jeruk Segar', 'Jus jeruk peras segar dengan es batu, kaya vitamin.', 8000, 'https://api.builder.io/api/v1/image/assets/TEMP/a4ff2add3eaa657d5f34fabe120343b77624de46?width=572', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(39, 'SGMTEQ4V', 7, 1, 'Nasi Rawon Surabaya', 'Rawon daging hitam khas Surabaya dengan sambal tauge.', 21000, 'https://images.pexels.com/photos/704569/pexels-photo-704569.jpeg?auto=compress&cs=tinysrgb&w=900&h=600&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(40, 'XDJ5G1HI', 7, 5, 'Es Campur Spesial', 'Es campur buah, cincau, dan sirup segar.', 13000, 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=900&h=600&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(41, '7FXY3FZQ', 8, 1, 'Nasi Goreng Spesial', 'Nasi goreng dengan telur mata sapi, ayam, dan bumbu rahasia khas warung.', 18000, 'https://api.builder.io/api/v1/image/assets/TEMP/ba6382dc578b32751a4c6e03f2066fc64f93e8ce?width=504', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(42, 'FESC38GH', 8, 2, 'Bakso Kuah Spesial', 'Bakso sapi dengan mie, sayuran segar, dan kuah kaldu yang gurih.', 15000, 'https://api.builder.io/api/v1/image/assets/TEMP/3c5c09db60a4a2b7edf59cf09759e90f728ef682?width=504', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(43, 'NBSUTLTC', 8, 1, 'Soto Ayam Lamongan', 'Soto ayam kuning dengan telur, soun, dan sayuran segar berkuah bening.', 12000, 'https://api.builder.io/api/v1/image/assets/TEMP/b7bc82529c259c8ada923ec2170e09044304699d?width=504', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(44, '5RANM2XK', 8, 4, 'Es Teh Manis', 'Teh manis dingin dengan es batu, kesegaran di hari yang panas.', 5000, 'https://api.builder.io/api/v1/image/assets/TEMP/51abe326054c31ac42ba035e0234a59fd2ae076e?width=504', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(45, 'WOBLGSKW', 8, 1, 'Nasi Ayam Geprek', 'Ayam crispy geprek sambal bawang dengan nasi hangat.', 17000, 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(46, 'ZA1JEWRK', 8, 2, 'Mie Goreng Jawa', 'Mie goreng bumbu tradisional dengan topping ayam dan telur.', 15000, 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(47, 'WFW7FJWA', 8, 3, 'Tahu Isi Krispi', 'Tahu isi sayur digoreng garing, cocok untuk teman minum.', 9000, 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(48, 'K2U9KERM', 8, 4, 'Es Jeruk Segar', 'Es jeruk asli dengan rasa manis-asam yang seimbang.', 8000, 'https://images.unsplash.com/photo-1610970881699-44a5587cabec?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(49, 'BJUCY3YA', 8, 5, 'Puding Cokelat', 'Puding cokelat lembut dengan saus vanilla.', 10000, 'https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?w=900&q=80&auto=format&fit=crop', 1, '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(50, '5ZRZSR3C', 6, 4, 'kopi tubruk', 'hangan/es', 10000, 'menus/bUYwmuz3o0ARreTwKz86AVmmMSaRe7LOZyaJoDGD.jpg', 1, '2026-06-07 12:19:27', '2026-06-07 12:19:27'),
(51, 'WTS91CJF', 9, 5, 'ayam', 'makan besar', 100000, NULL, 1, '2026-06-10 04:47:18', '2026-06-10 04:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `menu_toppings`
--

CREATE TABLE `menu_toppings` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int UNSIGNED NOT NULL DEFAULT '0',
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_variants`
--

CREATE TABLE `menu_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_tambahan` int UNSIGNED NOT NULL DEFAULT '0',
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_14_132403_create_kategori_menus_table', 1),
(5, '2026_04_14_132403_create_vendors_table', 1),
(6, '2026_04_14_132404_create_menus_table', 1),
(7, '2026_04_14_132404_create_pesanans_table', 1),
(8, '2026_04_14_132405_create_payments_table', 1),
(9, '2026_04_14_132406_create_detail_pesanans_table', 1),
(10, '2026_05_17_000001_add_id_barang_to_menus_table', 1),
(11, '2026_05_17_000002_backfill_and_enforce_id_barang', 1),
(12, '2026_05_22_000001_create_customers_table', 1),
(13, '2026_05_22_010001_create_kunjungan_toko_tables', 1),
(14, '2026_06_07_000001_add_soft_deletes_to_users_table', 1),
(15, '2026_06_07_000002_create_artikels_table', 1),
(16, '2026_06_07_000003_create_menu_variants_table', 2),
(17, '2026_06_07_000004_create_menu_toppings_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'qris',
  `gross_amount` int NOT NULL,
  `status` enum('pending','settlement','expire','cancel','deny') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `midtrans_response` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `pesanan_id`, `snap_token`, `transaction_id`, `payment_type`, `gross_amount`, `status`, `paid_at`, `midtrans_response`, `created_at`, `updated_at`) VALUES
(1, 1, 'SEED-SNAP-1', NULL, 'qris', 36000, 'pending', NULL, '{\"source\": \"seeder\", \"transaction_status\": \"pending\"}', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(2, 2, 'SEED-SNAP-2', 'SEED-TRX-2', 'qris', 15000, 'settlement', '2026-06-07 12:16:58', '{\"source\": \"seeder\", \"transaction_status\": \"settlement\"}', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(3, 3, 'SEED-SNAP-3', 'SEED-TRX-3', 'qris', 36000, 'settlement', '2026-06-07 12:16:58', '{\"source\": \"seeder\", \"transaction_status\": \"settlement\"}', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(4, 4, 'SEED-SNAP-4', 'SEED-TRX-4', 'qris', 23000, 'settlement', '2026-06-07 12:16:58', '{\"source\": \"seeder\", \"transaction_status\": \"settlement\"}', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(5, 5, 'SEED-SNAP-5', NULL, 'qris', 31000, 'pending', NULL, '{\"source\": \"seeder\", \"transaction_status\": \"pending\"}', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(6, 6, 'a534350a-de10-45b4-bd28-bdad5ae7a1de', 'e62f79cd-1564-4c69-83f2-ca625ffcd151', 'qris', 42000, 'settlement', '2026-06-10 04:07:03', '{\"order_id\": \"KK-6-1781064401\", \"status_code\": \"200\", \"fraud_status\": \"accept\", \"gross_amount\": \"42000.00\", \"payment_type\": \"qris\", \"status_message\": \"Success, transaction is found\", \"transaction_id\": \"e62f79cd-1564-4c69-83f2-ca625ffcd151\", \"transaction_time\": \"2026-06-10 11:06:45\", \"transaction_status\": \"settlement\", \"finish_redirect_url\": \"http://example.com?order_id=KK-6-1781064401&status_code=200&transaction_status=settlement\"}', '2026-06-10 04:06:43', '2026-06-10 04:07:03'),
(7, 7, '44ebd4af-84d1-48bb-ab7c-feccb21d9721', 'e44abcd9-43d6-41c9-8c96-28792d7471d5', 'qris', 10000, 'settlement', '2026-06-10 04:14:03', '{\"order_id\": \"KK-7-1781064826\", \"status_code\": \"200\", \"fraud_status\": \"accept\", \"gross_amount\": \"10000.00\", \"payment_type\": \"qris\", \"status_message\": \"Success, transaction is found\", \"transaction_id\": \"e44abcd9-43d6-41c9-8c96-28792d7471d5\", \"transaction_time\": \"2026-06-10 11:13:49\", \"transaction_status\": \"settlement\", \"finish_redirect_url\": \"http://example.com?order_id=KK-7-1781064826&status_code=200&transaction_status=settlement\"}', '2026-06-10 04:13:46', '2026-06-10 04:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `pesanans`
--

CREATE TABLE `pesanans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `nama_customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `waktu_pengambilan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pesanan` enum('pending','diproses','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanans`
--

INSERT INTO `pesanans` (`id`, `user_id`, `vendor_id`, `nama_customer`, `total`, `catatan`, `waktu_pengambilan`, `status_pesanan`, `created_at`, `updated_at`) VALUES
(1, 10, 8, 'Ahmad', 36000, NULL, '15-20 min', 'pending', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(2, 11, 8, 'Budi', 15000, NULL, '15-20 min', 'diproses', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(3, 12, 8, 'Citra', 36000, NULL, '15-20 min', 'selesai', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(4, 13, 7, 'Dewi', 23000, NULL, '15-20 min', 'diproses', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(5, 14, 7, 'Eka', 31000, NULL, '15-20 min', 'pending', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(6, 16, 6, 'fahmi', 42000, NULL, 'asap', 'diproses', '2026-06-10 04:06:41', '2026-06-10 04:07:03'),
(7, 17, 6, 'fahmi', 10000, NULL, 'asap', 'selesai', '2026-06-10 04:13:46', '2026-06-10 04:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jUwWeRw1yq4CyUzokw0mOaFgeFDFPONd6V5of1gb', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiIxTXp3VGE4YmlhN0U1ZjRoS1FoUXR6Zm5lRm9JT3JwTXc4UWtkS2NHIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwva2FudGluLWtpdGFcL3B1YmxpY1wvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781065853),
('lLXlrQLJiakMOqtLIGXdkDANolNNBk6WrgMy1zpN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiJIMTk1d1NYcWlxQ1ZyNmF3OTFRT3M5M2RTRjcwNFFHaVJjVFhNYlBhIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL29yZGVyXC83Iiwicm91dGUiOiJvcmRlci5zdWNjZXNzIn19', 1781066938);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','vendor','customer','guest') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin Kantin Kita', 'admin@kantinkita.id', NULL, '$2y$12$rCO5IyZs979yucoMBOEI2OHFQAN4FSdQ8BqGrBUGWhRXaBt.I4IG.', 'admin', NULL, '2026-06-07 12:16:56', '2026-06-07 12:16:56', NULL),
(2, 'Warung Nusantara', 'nusantara@kantinkita.id', NULL, '$2y$12$FAUkXdKzWSpEczPZBMpgB.bqHjDOMx6ZJuWbkaOfYu/KEO8yQ57jK', 'vendor', NULL, '2026-06-07 12:16:56', '2026-06-07 12:16:56', NULL),
(3, 'The Burger Hub', 'burgerhub@kantinkita.id', NULL, '$2y$12$4tP4kIeZctJacErShkcIVukhBY161y3sjhvytHdPa6mLZUvCVp7Uq', 'vendor', NULL, '2026-06-07 12:16:56', '2026-06-07 12:16:56', NULL),
(4, 'Bubble Tea Corner', 'bubbletea@kantinkita.id', NULL, '$2y$12$6ifgJu9K5s4cqwwndJok3OGwqJ3hTts7R0eAkCU3zmScp8e2JYhqC', 'vendor', NULL, '2026-06-07 12:16:56', '2026-06-07 12:16:56', NULL),
(5, 'Ramen Station', 'ramen@kantinkita.id', NULL, '$2y$12$gD5usf/pq7cpOLRvD0MF9.o8AFrkm.6K7SVa.DvaGSFfb4Cime95G', 'vendor', NULL, '2026-06-07 12:16:57', '2026-06-07 12:16:57', NULL),
(6, 'Fresh & Healthy', 'freshhealty@kantinkita.id', NULL, '$2y$12$G5ZFPbl9GX8T5ZBq5bt3ieF2h4Hu8phPkX4PUJGPRNWa7PnkEpE/m', 'vendor', NULL, '2026-06-07 12:16:57', '2026-06-07 12:16:57', NULL),
(7, 'Campus Brew', 'campusbrew@kantinkita.id', NULL, '$2y$12$V1sNZ94tUkfb9PTsAZKNcuKKmXl.ly6oUVPDQgjK12kb1k0h3GLlG', 'vendor', NULL, '2026-06-07 12:16:57', '2026-06-09 04:58:02', NULL),
(8, 'Warung Bu Sari', 'busari@kantinkita.id', NULL, '$2y$12$cPKvAtXN0SZV7Cn1lq9H5eCllOPo4EJIfVSgNjQWdl4HCkwttOK1i', 'vendor', NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(9, 'Warung Mbok Sri', 'mboksri@kantinkita.id', NULL, '$2y$12$O5UqH0bjU.2kbQbI0Tf2EOxrJinZvl1zxLjvnqbixd3oeQDqlVwcG', 'vendor', NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(10, 'Ahmad', NULL, NULL, NULL, 'guest', NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(11, 'Budi', NULL, NULL, NULL, 'guest', NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(12, 'Citra', NULL, NULL, NULL, 'guest', NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(13, 'Dewi', NULL, NULL, NULL, 'guest', NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(14, 'Eka', NULL, NULL, NULL, 'guest', NULL, '2026-06-07 12:16:58', '2026-06-07 12:16:58', NULL),
(15, 'fahmi vendor', 'fahmi@kantinkita.id', NULL, '$2y$12$x8TUK56VBXsdMgY4UQ3c1e1V3lxnDqBpAVON31ehhx8Y8vFrCeAPW', 'vendor', NULL, '2026-06-07 12:26:53', '2026-06-09 04:39:50', '2026-06-09 04:39:50'),
(16, 'fahmi', NULL, NULL, NULL, 'guest', NULL, '2026-06-10 04:06:41', '2026-06-10 04:06:41', NULL),
(17, 'fahmi', NULL, NULL, NULL, 'guest', NULL, '2026-06-10 04:13:46', '2026-06-10 04:13:46', NULL),
(18, 'thariq', 'thariq@kantinkita.id', NULL, '$2y$12$CHpxkwquuPU3/zUdsKW3C.juqfmJ368uOGj.ZkRmdSq/buMRSsxIa', 'vendor', NULL, '2026-06-10 04:16:07', '2026-06-10 04:16:07', NULL),
(19, 'farel', 'farel@kantinkita.id', NULL, '$2y$12$La4tTYX19Gfcqy00sjjNtumSh5/Vp54LWARHbKeaGZDfPaM/O1tT.', 'vendor', NULL, '2026-06-10 04:32:25', '2026-06-10 04:32:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_vendor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT '0.0',
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `path_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `user_id`, `nama_vendor`, `deskripsi`, `lokasi`, `kategori`, `rating`, `is_open`, `path_logo`, `created_at`, `updated_at`) VALUES
(1, 2, 'Warung Nusantara', 'Masakan Indonesia autentik dengan nasi goreng khas dan sate tradisional. Bahan segar setiap hari.', 'Gedung A, Lantai 1', 'Indonesia', 4.8, 1, 'https://images.pexels.com/photos/3590401/pexels-photo-3590401.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(2, 3, 'The Burger Hub', 'Burger premium dengan daging sapi berkualitas, sayuran segar, dan saus homemade.', 'Gedung B, Lantai 2', 'Western', 4.6, 1, 'https://api.builder.io/api/v1/image/assets/TEMP/8eae28831fbb7d76231e72013a84088be8fb3d13?width=864', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(3, 4, 'Bubble Tea Corner', 'Bubble tea segar dengan berbagai rasa dan topping. Cocok untuk teman belajar!', 'Gedung A, Lantai 2', 'Minuman', 4.9, 1, 'https://api.builder.io/api/v1/image/assets/TEMP/b5ba4c85139506ab2fd522e5e767ae7d0ecbce34?width=864', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(4, 5, 'Ramen Station', 'Ramen Jepang autentik dengan kuah kaya rasa dan topping segar.', 'Gedung C, Lantai 1', 'Asia', 4.7, 1, 'https://api.builder.io/api/v1/image/assets/TEMP/0c714eb1825d3dd142cfebe8527dc83ba75a69be?width=864', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(5, 6, 'Fresh & Healthy', 'Salad bowl bergizi dan pilihan makanan sehat untuk mahasiswa.', 'Gedung B, Lantai 1', 'Sehat', 4.5, 1, 'https://api.builder.io/api/v1/image/assets/TEMP/ececcd477fc1231e4bbe74a931558732204a0e78?width=864', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(6, 7, 'Campus Brew', 'Kopi premium dan minuman spesial. Tempat ngopi favorit antar jam kuliah.', 'Gedung A, Lantai Dasar', 'Minuman', 5.0, 1, 'https://api.builder.io/api/v1/image/assets/TEMP/ae917f5edf17a276a169dc78fb9e5a9a81fa6485?width=864', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(7, 8, 'Warung Bu Sari', 'Masakan Indonesia autentik dengan bahan segar dan resep turun-temurun.', 'Gedung D, Lantai 1', 'Indonesia', 4.8, 1, 'https://images.pexels.com/photos/262978/pexels-photo-262978.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(8, 9, 'Warung Mbok Sri', 'Warung masakan rumahan khas Jawa dengan cita rasa yang sudah teruji.', 'Gedung A, Lantai Dasar', 'Indonesia', 4.8, 1, 'https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop', '2026-06-07 12:16:58', '2026-06-07 12:16:58'),
(9, 19, 'farel', 'farel', 'farel', 'farel', 0.0, 1, NULL, '2026-06-10 04:32:25', '2026-06-10 04:32:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikels`
--
ALTER TABLE `artikels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `artikels_slug_unique` (`slug`),
  ADD KEY `artikels_author_id_foreign` (`author_id`),
  ADD KEY `artikels_kategori_index` (`kategori`),
  ADD KEY `artikels_status_index` (`status`),
  ADD KEY `artikels_published_at_index` (`published_at`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_vendor_id_index` (`vendor_id`);

--
-- Indexes for table `detail_pesanans`
--
ALTER TABLE `detail_pesanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pesanans_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `detail_pesanans_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_menus`
--
ALTER TABLE `kategori_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kunjungan_toko`
--
ALTER TABLE `kunjungan_toko`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjungan_toko_user_id_foreign` (`user_id`),
  ADD KEY `kunjungan_toko_vendor_id_index` (`vendor_id`),
  ADD KEY `kunjungan_toko_lokasi_toko_barcode_index` (`lokasi_toko_barcode`);

--
-- Indexes for table `lokasi_toko`
--
ALTER TABLE `lokasi_toko`
  ADD PRIMARY KEY (`barcode`),
  ADD KEY `lokasi_toko_vendor_id_index` (`vendor_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_id_barang_unique` (`id_barang`),
  ADD KEY `menus_vendor_id_foreign` (`vendor_id`),
  ADD KEY `menus_kategori_menu_id_foreign` (`kategori_menu_id`);

--
-- Indexes for table `menu_toppings`
--
ALTER TABLE `menu_toppings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_toppings_menu_id_urutan_index` (`menu_id`,`urutan`);

--
-- Indexes for table `menu_variants`
--
ALTER TABLE `menu_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_variants_menu_id_urutan_index` (`menu_id`,`urutan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_pesanan_id_foreign` (`pesanan_id`);

--
-- Indexes for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanans_user_id_foreign` (`user_id`),
  ADD KEY `pesanans_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendors_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikels`
--
ALTER TABLE `artikels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_pesanans`
--
ALTER TABLE `detail_pesanans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_menus`
--
ALTER TABLE `kategori_menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kunjungan_toko`
--
ALTER TABLE `kunjungan_toko`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `menu_toppings`
--
ALTER TABLE `menu_toppings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_variants`
--
ALTER TABLE `menu_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pesanans`
--
ALTER TABLE `pesanans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikels`
--
ALTER TABLE `artikels`
  ADD CONSTRAINT `artikels_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_pesanans`
--
ALTER TABLE `detail_pesanans`
  ADD CONSTRAINT `detail_pesanans_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `detail_pesanans_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kunjungan_toko`
--
ALTER TABLE `kunjungan_toko`
  ADD CONSTRAINT `kunjungan_toko_lokasi_toko_barcode_foreign` FOREIGN KEY (`lokasi_toko_barcode`) REFERENCES `lokasi_toko` (`barcode`) ON DELETE CASCADE,
  ADD CONSTRAINT `kunjungan_toko_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kunjungan_toko_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lokasi_toko`
--
ALTER TABLE `lokasi_toko`
  ADD CONSTRAINT `lokasi_toko_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_kategori_menu_id_foreign` FOREIGN KEY (`kategori_menu_id`) REFERENCES `kategori_menus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `menus_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_toppings`
--
ALTER TABLE `menu_toppings`
  ADD CONSTRAINT `menu_toppings_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_variants`
--
ALTER TABLE `menu_variants`
  ADD CONSTRAINT `menu_variants_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD CONSTRAINT `pesanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pesanans_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
