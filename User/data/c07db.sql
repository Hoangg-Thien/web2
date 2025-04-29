-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 27, 2025 lúc 09:52 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `c07db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `product_id` varchar(50) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`product_id`, `order_id`, `total_amount`, `quantity`, `unit_price`) VALUES
('F001', 5, 320000, 2, 160000),
('F002', 9, 1280000, 8, 160000),
('F003', 4, 320000, 2, 160000),
('F004', 5, 135000, 3, 45000),
('F006', 7, 800000, 5, 160000),
('F007', 9, 450000, 14, 45000),
('F008', 6, 135000, 3, 45000),
('F009', 7, 450000, 10, 45000),
('F010', 6, 325000, 5, 45000),
('F011', 4, 180000, 4, 45000),
('F013', 4, 90000, 2, 45000),
('F014', 8, 360000, 8, 45000),
('F015', 8, 90000, 2, 45000),
('F016', 7, 450000, 10, 45000),
('F017', 6, 1600000, 11, 160000),
('F019', 8, 150000, 5, 30000),
('F020', 10, 600000, 20, 30000),
('F021', 14, 310000, 10, 31000),
('F023', 16, 64000, 2, 32000),
('F024', 17, 140000, 4, 35000),
('F025', 11, 400000, 2, 200000),
('F026', 10, 400000, 2, 200000),
('F028', 13, 50000, 5, 100000),
('F031', 15, 260000, 2, 130000),
('F032', 16, 150000, 1, 150000),
('F034', 17, 600000, 2, 300000),
('F035', 12, 800000, 2, 400000),
('F036', 11, 1200000, 2, 600000),
('F001', 18, 320000, 2, 160000),
('F002', 19, 480000, 3, 160000),
('F003', 20, 160000, 1, 160000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `order_id` int(11) NOT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `PaymentMethod` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `receipter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`order_id`, `order_status`, `order_date`, `product_id`, `user_name`, `district`, `city`, `PaymentMethod`, `phone`, `address`, `customerName`, `receipter`) VALUES
(4, 'Chưa xác nhận', '2025-03-01 20:35:42', 'F013', 'huyle123', 'Quận Tân Phú', 'Hồ Chí Minh', 'Chuyển khoản', '0908654857', '22a Lê Trọng Tấn', 'Lê Minh Huy', ''),
(5, 'Đã hủy', '2025-03-10 20:36:15', 'F003', 'huong8181', 'Quận 1', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0867854386', '929 Tôn Đức Thắng', 'Khúc Thị Hương', ''),
(6, 'Giao thành công', '2025-03-12 20:37:59', 'F007', 'tuan8181', 'Quận Bình Thạnh', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0965428791', '2 Nguyễn Hữu Cảnh', 'Phạm Đức Tuấn', 'Phạm Đức Tuấn'),
(7, 'Đã xác nhận', '2025-03-18 20:38:23', 'F013', 'thieu8181', 'Quận 8', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0816576543', '667 Phạm Văn Đồng', 'Nguyễn Gia Thiệu', ''),
(8, 'Giao thành công', '2025-03-25 20:38:48', 'F005', 'quan123', 'Quận Tân Bình', 'Hồ Chí Minh', 'Chuyển khoản', '0389542657', '99a Lê Văn Sĩ', 'Trần Minh Quân', 'Nguyễn Gia Đạt'),
(9, 'Đã xác nhận', '2025-04-11 06:57:44', 'F007', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', ''),
(10, 'Đã xác nhận', '2025-04-13 06:57:44', 'F020', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', ''),
(11, 'Giao thành công', '2025-04-14 10:00:00', 'F007', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', 'Nguyễn Minh Hoàng'),
(12, 'Đã xác nhận', '2025-04-14 11:00:00', 'F020', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', 'Nguyễn Minh Hoàng'),
(13, 'Đã hủy', '2025-04-14 12:00:00', 'F007', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', 'Nguyễn Minh Hoàng'),
(14, 'Đã xác nhận', '2025-04-14 13:00:00', 'F020', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', 'Nguyễn Minh Hoàng'),
(15, 'Chưa xác nhận', '2025-04-15 14:00:00', 'F007', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', 'Nguyễn Minh Hoàng'),
(16, 'Giao thành công', '2025-04-18 13:45:00', 'F010', 'tuan8181', 'Quận Bình Thạnh', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0965428791', '2 Nguyễn Hữu Cảnh', 'Phạm Đức Tuấn', 'Phạm Đức Tuấn'),
(17, 'Đã xác nhận', '2025-04-18 14:00:00', 'F014', 'tuan8181', 'Quận Bình Thạnh', 'Hồ Chí Minh', 'Chuyển khoản', '0965428791', '2 Nguyễn Hữu Cảnh', 'Phạm Đức Tuấn', 'Phạm Đức Tuấn'),
(18, 'Giao thành công', '2025-04-20 10:00:00', 'F001', 'hoa2005', 'Quận 1', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0901234567', '123 Nguyễn Huệ', 'Nguyễn Thị Hoa', 'Nguyễn Thị Hoa'),
(19, 'Đã xác nhận', '2025-04-21 14:30:00', 'F002', 'hoa2005', 'Quận 1', 'Hồ Chí Minh', 'Chuyển khoản', '0901234567', '123 Nguyễn Huệ', 'Nguyễn Thị Hoa', 'Nguyễn Thị Hoa'),
(20, 'Chưa xác nhận', '2025-04-22 09:15:00', 'F003', 'hoa2005', 'Quận 1', 'Hồ Chí Minh', 'Thanh toán khi nhận hàng', '0901234567', '123 Nguyễn Huệ', 'Nguyễn Thị Hoa', 'Nguyễn Thị Hoa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `category_id` int(11) NOT NULL,
  `name_type` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`category_id`, `name_type`, `description`) VALUES
(1, 'Trái Cây Nhập Khẩu', 'Trái cây ngon từ nước ngoài'),
(2, 'Trái Cây Việt', 'Trái cây ngon nội địa'),
(3, 'Rau Củ', 'Rau củ sạch'),
(4, 'Hạt', 'Hạt bổ'),
(5, 'Trái Cây Khô', 'Trái cây khô');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `share_count` int(11) DEFAULT 0,
  `likes` int(11) DEFAULT 0,
  `status` varchar(20) DEFAULT 'published',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--
INSERT INTO `news` (`id`, `title`, `excerpt`, `content`, `image_url`, `category`, `is_featured`, `views`, `comments`, `created_at`, `updated_at`, `share_count`, `likes`, `status`) VALUES
(1, 'Cherry Mỹ - Nữ hoàng của các loại trái cây nhập khẩu', 'Khám phá hương vị ngọt ngào và lợi ích sức khỏe tuyệt vời từ Cherry Mỹ cao cấp', 'Cherry Mỹ được mệnh danh là "nữ hoàng" của các loại trái cây nhập khẩu với màu đỏ đậm sang trọng và vị ngọt thanh đặc trưng. Giàu anthocyanin - chất chống oxy hóa mạnh giúp chống lão hóa, cải thiện giấc ngủ nhờ hàm lượng melatonin tự nhiên cao. Cherry Mỹ còn chứa nhiều vitamin C, kali và chất xơ, hỗ trợ tim mạch và hệ tiêu hóa khỏe mạnh. Được trồng tại các vườn cherry nổi tiếng ở Washington, Oregon với quy trình nghiêm ngặt đảm bảo chất lượng cao nhất.', '../img/trai-cherry-Uc.webp', 'Trái Cây Nhập Khẩu', 1, 0, 0, '2025-04-27 04:03:00', '2025-04-27 04:03:00', 0, 0, 'published'),

(2, 'Táo Envy New Zealand - Vị ngọt tinh tế từ xứ sở Kiwi', 'Táo Envy với vẻ ngoài bắt mắt cùng hương vị đặc biệt đang chinh phục người tiêu dùng sành điệu', 'Táo Envy New Zealand là giống táo cao cấp được phát triển từ việc lai tạo giữa Royal Gala và Braeburn. Với lớp vỏ đỏ ánh hồng quyến rũ, thịt táo trắng ngà giòn mọng và vị ngọt tự nhiên cân bằng. Giàu chất xơ, vitamin C và các chất chống oxy hóa, giúp tăng cường miễn dịch và làm đẹp da. Được trồng trong điều kiện khí hậu lý tưởng của New Zealand, mỗi quả táo đều trải qua quy trình chọn lọc nghiêm ngặt về kích thước và chất lượng.', '../img/trai-tao.jpg', 'Trái Cây Nhập Khẩu', 1, 0, 0, '2025-04-27 04:03:00', '2025-04-27 04:03:00', 0, 0, 'published'),

(3, 'Nho xanh không hạt Úc - Vị ngọt mát từ Nam bán cầu', 'Nho xanh Úc với độ giòn đặc trưng và vị ngọt thanh đang là lựa chọn hàng đầu của người tiêu dùng', 'Nho xanh không hạt Úc nổi tiếng với độ giòn tan trong miệng và vị ngọt tự nhiên không gắt. Được trồng tại thung lũng Murray của Úc, nơi có điều kiện khí hậu Mediterranean lý tưởng cho việc trồng nho. Giàu resveratrol - chất chống oxy hóa mạnh giúp bảo vệ tim mạch, chống lão hóa. Nho còn chứa nhiều vitamin K, C và khoáng chất như kali, canxi hỗ trợ xương khớp chắc khỏe. Mỗi chùm nho đều được chăm sóc cẩn thận và thu hoạch đúng độ chín.', '../img/trai-nho-My.jpg', 'Trái Cây Nhập Khẩu', 1, 0, 0, '2025-04-27 04:03:00', '2025-04-27 04:03:00', 0, 0, 'published'),

(4, 'Lê Nam Phi - Hương vị tinh tế từ châu Phi', 'Lê Nam Phi với vẻ ngoài sang trọng và hương vị độc đáo đang được ưa chuộng trên thị trường', 'Lê Nam Phi có hình dáng thuôn dài đẹp mắt, vỏ màu nâu vàng đặc trưng. Thịt quả trắng ngà, giòn mọng với vị ngọt dịu và hương thơm tinh tế. Giàu chất xơ hòa tan pectin giúp kiểm soát cholesterol và đường huyết. Chứa nhiều vitamin C, K và các khoáng chất như đồng, kali tốt cho tim mạch và xương khớp. Được trồng tại các vùng Western Cape của Nam Phi với công nghệ hiện đại, đảm bảo quả lê đạt tiêu chuẩn xuất khẩu quốc tế.', '../img/trai-le.png', 'Trái Cây Nhập Khẩu', 1, 0, 0, '2025-04-27 04:03:00', '2025-04-27 04:03:00', 0, 0, 'published'),

(5, 'Kiwi vàng New Zealand - Kho báu dinh dưỡng từ thiên nhiên', 'Kiwi vàng với hương vị tropical độc đáo và giá trị dinh dưỡng cao đang được ưa chuộng', 'Kiwi vàng New Zealand có vỏ mượt màu nâu vàng, thịt quả vàng óng với hạt đen nhỏ xếp thành vòng tròn đẹp mắt. Hương vị ngọt mát, có vị chua nhẹ tạo cảm giác sảng khoái. Là nguồn vitamin C dồi dào (gấp 3 lần cam), giàu enzyme actinidin hỗ trợ tiêu hóa và chất xơ. Chứa nhiều kali, vitamin E và axit folic tốt cho tim mạch và thai nhi. Được trồng theo tiêu chuẩn hữu cơ tại New Zealand, đảm bảo an toàn và chất lượng.', '../img/trai-kiwi.jpg', 'Trái Cây Nhập Khẩu', 1, 0, 0, '2025-04-27 04:03:00', '2025-04-27 04:03:00', 0, 0, 'published'),

(6, 'Việt Quất Chile - Siêu thực phẩm từ Nam Mỹ', 'Việt quất Chile với hàm lượng chất chống oxy hóa cao nhất trong các loại trái cây đang được săn đón', 'Việt quất Chile có kích thước lớn đều đặn, màu xanh phủ phấn trắng đặc trưng. Thịt quả mọng nước với vị chua ngọt cân bằng và hương thơm quyến rũ. Được mệnh danh là "vua chống oxy hóa" với hàm lượng anthocyanin và flavonoid cao nhất, giúp chống lão hóa, bảo vệ não và tim mạch. Giàu vitamin C, K và mangan, tốt cho thị lực và hệ miễn dịch. Được trồng tại vùng khí hậu ôn đới của Chile, đảm bảo quả to đều và chất lượng.', '../img/trai-viet-quat.jpg', 'Trái Cây Nhập Khẩu', 1, 0, 0, '2025-04-27 04:03:00', '2025-04-27 04:03:00', 0, 0, 'published');
 

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `fullname` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `hashPass` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `user_status` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`fullname`, `user_name`, `user_pass`, `hashPass`, `user_email`, `user_address`, `phone`, `user_role`, `user_status`, `district`, `city`) VALUES
('hoa', 'hoa2005', '12345', '$2y$10$xK6L6IpwlKFXetxsIh.DkeYKNJikmbC5Lu0XDMYE1v9GM0R95wSeO', 'dothaihoa@gmail.com', 'sdcsjs', '782364372', 'user', '', 'sdadsaccsdcasd', 'aCÁDCWDCWDACDC'),
('Nguyễn Minh Hoàng', 'hoag123', 'hoag123@', '', 'hoangnguyen@gmail.com', '176 Trần Não', '0906784527', 'Khách hàng', 'Hoạt động', 'Quận 2', 'Hồ Chí Minh'),
('Khúc Thị Hương', 'huong8181', 'huong123@', '', 'huongkhuc@gmail.com', '929 Tôn Đức Thắng', '0867854386', 'Khách hàng', 'Hoạt động', 'Quận 1', 'Hồ Chí Minh'),
('Lê Minh Huy', 'huyle123', 'huy12345', '', 'huyle@gmail.com', '22a Lê Trọng Tấn', '0908654857', 'Khách hàng', 'Hoạt động', 'Quận Tân Phú', 'Hồ Chí Minh'),
('Lưu Gia Huy', 'luuhuy2005', 'huyhuy123', '$2y$10$zIVomGpZ/tNTme1f6Ntfp.LdlLiJoFh3YrowJ0V2W./xK9dPlFtIG', 'huyhuy123@gmail.com', '123 Âu Cơ', '0909123456', 'Quản lý', 'Hoạt động', 'Quận 5', 'Hồ Chí Minh'),
('Trần Minh Quân', 'quan123', 'quan123@', '', 'quantran@gmail.com', '99a Lê Văn Sĩ', '0389542657', 'Khách Hàng', 'Hoạt động', 'Quận Tân Bình', 'Hồ Chí Minh'),
('Nguyễn Gia Thiệu', 'thieu8181', 'thieu123@', '', 'thieunguyen@gmail.com', '667 Phạm Văn Đồng', '0816576543', 'Khách Hàng', 'Hoạt động', 'Quận 8', 'Hồ Chí Minh'),
('Phạm Đức Tuấn', 'tuan8181', 'tuan123@', '', 'tuanpham@gmail.com', '2 Nguyễn Hữu Cảnh', '0965428791', 'Khách Hàng', 'Hoạt động', 'Quận Bình Thạnh', 'Hồ Chí Minh'),
('Châu Uy Vủ', 'uyvu123', 'haha123', '$2y$10$N8ksrPd1cFYtuNo0Rmeb7Ogpp/1bHUyJYrxj3Hw43V6iuUHaMWcgy', 'uyvu@gmail.com', '123 Lạc Long Quân', '0909123457', 'Quản lý', 'Đã khóa', 'Quận 11', 'Hồ Chí Minh');

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`user_name`);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `product_id` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_status` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `product_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`product_id`, `category_id`, `product_name`, `product_image`, `product_status`, `product_price`, `product_type`, `product_description`) VALUES
('F001', 1, 'Chuối Chín Nam Mỹ', 'trai-chuoi.jpg', 'Còn hàng', 160000, 'Trái Cây Nhập Khẩu', 'Chuối chín tự nhiên, ngọt thơm'),
('F002', 1, 'Kiwi', 'trai-kiwi.jpg', 'Còn hàng', 160000, 'Trái Cây Nhập Khẩu', 'Kiwi New Zealand, chua ngọt vừa phải'),
('F003', 1, 'Lựu Ai Cập', 'trai-luu.jpg', 'Hết hàng', 160000, 'Trái Cây Nhập Khẩu', 'Lựu đỏ Ai Cập, ngọt thanh'),
('F004', 2, 'Mận Đỏ An Phước', 'trai-man-do.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', 'Mận đỏ An Phước, giòn ngọt'),
('F005', 2, 'Mãng Cầu Xiêm', 'trai-mang-cau.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', 'Mãng cầu xiêm chín tự nhiên'),
('F006', 1, 'Nho Mỹ', 'trai-nho-My.jpg', 'Hết hàng', 160000, 'Trái Cây Nhập Khẩu', 'Nho Mỹ không hạt, ngọt thanh'),
('F007', 2, 'Ổi Xá Lị', 'trai-oi.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', 'Ổi xá lị giòn ngọt'),
('F008', 2, 'Thanh Long Ruột Đỏ', 'trai-thanh-long.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', 'Thanh long ruột đỏ ngọt mát'),
('F009', 2, 'Bòn Bon', 'trai-bon-bon.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', 'Bòn bon chín tự nhiên'),
('F010', 2, 'Quýt Đường', 'trai-quyt.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', 'Quýt đường ngọt thanh'),
('F011', 2, 'Dưa hấu Long An', 'trai-dua-hau.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', 'Dưa hấu Long An ngọt mát'),
('F012', 2, 'Chôm chôm', 'trai-chom-chom.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', 'Chôm chôm chín tự nhiên'),
('F013', 2, 'Xoài cát', 'trai-xoai.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', 'Xoài cát Hòa Lộc ngọt thơm'),
('F014', 2, 'Dâu tây Đà Lạt', 'dau-tay.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', 'Dâu tây Đà Lạt tươi ngon'),
('F015', 2, 'Mận Hà Nội', 'man-Ha-Noi.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', 'Mận Hà Nội giòn ngọt'),
('F016', 2, 'Bưởi da xanh', 'hinh-trai-buoi.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', 'Bưởi da xanh ngọt thanh'),
('F017', 1, 'Táo Envy', 'trai-tao.jpg', 'Hết hàng', 160000, 'Trái Cây Nhập Khẩu', 'Táo Envy Mỹ giòn ngọt'),
('F018', 1, 'Cherry Úc', 'trai-cherry-Uc.jpg', 'Còn hàng', 160000, 'Trái Cây Nhập Khẩu', 'Cherry Úc ngọt thanh'),
('F019', 3, 'Cà Rốt', 'carot.jpg', 'Còn hàng', 30000, 'Rau Củ', 'Cà rốt tươi ngon'),
('F020', 3, 'Cà Chua', 'cachua.png', 'Còn hàng', 30000, 'Rau Củ', 'Cà chua tươi ngon'),
('F021', 3, 'Khoai Tây', 'khoaitay.jpg', 'Còn hàng', 31000, 'Rau Củ', 'Khoai tây tươi ngon'),
('F022', 3, 'Súp Lơ Xanh', 'suploxanh.jpg', 'Hết hàng', 30000, 'Rau Củ', 'Súp lơ xanh tươi ngon'),
('F023', 3, 'Củ Su Hào', 'cusuhao.jpg', 'Hết hàng', 32000, 'Rau Củ', 'Củ su hào tươi ngon'),
('F024', 3, 'Xà Lách', 'xalach.jpg', 'Còn hàng', 35000, 'Rau Củ', 'Xà lách tươi ngon'),
('F025', 4, 'Hạt Óc Chó', 'walnut.jpg', 'Còn hàng', 200000, 'Hạt', 'Hạt óc chó Mỹ'),
('F026', 4, 'Hạnh Nhân', 'hanh-nhan.jpg', 'Hết hàng', 240000, 'Hạt', 'Hạnh nhân Mỹ'),
('F027', 4, 'Hạt Điều', 'hat-dieu.jpg', 'Còn hàng', 250000, 'Hạt', 'Hạt điều Việt Nam'),
('F028', 4, 'Hạt Mác Ca', 'hat-mac-ca.jpg', 'Còn hàng', 100000, 'Hạt', 'Hạt mác ca Úc'),
('F029', 4, 'Hạt Dẻ', 'hat-de.jpg', 'Còn hàng', 80000, 'Hạt', 'Hạt dẻ Việt Nam'),
('F030', 4, 'Hạt Hồ Đào', 'hat-ho-dao.jpg', 'Hết hàng', 180000, 'Hạt', 'Hạt hồ đào Mỹ'),
('F031', 5, 'Xoài sấy', 'xoai-say.jpg', 'Còn hàng', 130000, 'Trái cây khô', 'Xoài sấy dẻo'),
('F032', 5, 'Táo sấy', 'tao-say.jpg', 'Còn hàng', 150000, 'Trái cây khô', 'Táo sấy dẻo'),
('F033', 5, 'Dâu sấy', 'dau-say.jpg', 'Còn hàng', 450000, 'Trái cây khô', 'Dâu sấy dẻo'),
('F034', 5, 'Nho vàng sấy', 'nho-say.jpg', 'Còn hàng', 300000, 'Trái cây khô', 'Nho vàng sấy dẻo'),
('F035', 5, 'Mít sấy', 'mit-say.jpg', 'Còn hàng', 400000, 'Trái cây khô', 'Mít sấy dẻo'),
('F036', 5, 'Kiwi sấy', 'kiwi-say.jpg', 'Còn hàng', 600000, 'Trái cây khô', 'Kiwi sấy dẻo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'approved',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `user_name` (`user_name`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `nguoidung` (`user_name`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`news_id`, `user_name`, `content`, `created_at`, `status`) VALUES
(1, 'hoag123', 'Bài viết rất hay và bổ ích!', '2025-04-27 05:00:00', 'approved'),
(1, 'tuan8181', 'Cảm ơn tác giả đã chia sẻ thông tin hữu ích', '2025-04-27 06:00:00', 'approved'),
(2, 'huong8181', 'Dưa hấu là loại trái cây yêu thích của tôi', '2025-04-27 07:00:00', 'approved'),
(3, 'quan123', 'Quýt rất tốt cho sức khỏe', '2025-04-27 08:00:00', 'approved'),
(4, 'thieu8181', 'Đu đủ là loại trái cây bổ dưỡng', '2025-04-27 09:00:00', 'approved');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `created_at`, `status`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'Administrator', '2025-04-27 04:03:00', 'active'),
(2, 'user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user1@example.com', 'User One', '2025-04-27 04:03:00', 'active');

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `shipping_address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `created_at`, `status`, `payment_method`, `shipping_address`, `phone`) VALUES
(1, 1, '2025-04-27 10:00:00', 'pending', 'credit_card', '123 Main St, City', '1234567890'),
(2, 2, '2025-04-27 11:00:00', 'completed', 'paypal', '456 Oak St, Town', '0987654321');

--
-- Tạo bảng order_items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Thêm dữ liệu mẫu cho bảng order_items
INSERT INTO order_items (order_id, product_name, quantity, price) VALUES
(1, 'Dưa hấu Long An', 1, 300000),
(1, 'Xoài cát Hòa Lộc', 1, 100000),
(1, 'Ổi xá lị', 1, 50000),
(2, 'Bưởi da xanh', 1, 200000),
(2, 'Quýt đường', 1, 150000);

-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`product_id`,`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_product` (`product_id`),
  ADD KEY `fk_usernamee` (`user_name`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `news`
--

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `