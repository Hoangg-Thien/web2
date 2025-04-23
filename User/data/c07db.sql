-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2025 lúc 08:47 AM
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
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(50) NOT NULL,
  `total_amount` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`product_id`, `order_id`, `total_amount`, `quantity`, `unit_price`) VALUES
('F001', 5, 320000, 2, 160000),
('F002', 9, 1280000, 8, 160000),
('F004', 5, 135000, 3, 45000),
('F006', 7, 800000, 5, 160000),
('F007', 9, 450000, 10, 45000),
('F009', 7, 450000, 10, 45000),
('F010', 6, 325000, 5, 45000),
('F011', 4, 180000, 4, 45000),
('F013', 4, 90000, 2, 45000),
('F014', 8, 360000, 8, 45000),
('F015', 8, 90000, 2, 45000),
('F017', 6, 1600000, 10, 160000),
('F020', 10, 600000, 20, 30000),
('F026', 10, 400000, 2, 200000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `district`
--

CREATE TABLE `district` (
  `district_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Quận huyện';

--
-- Đang đổ dữ liệu cho bảng `district`
--

INSERT INTO `district` (`district_id`, `province_id`, `name`) VALUES
(1, 1, 'Quận Ba Đình'),
(2, 1, 'Quận Hoàn Kiếm'),
(3, 1, 'Quận Tây Hồ'),
(4, 1, 'Quận Long Biên'),
(5, 1, 'Quận Cầu Giấy'),
(6, 1, 'Quận Đống Đa'),
(7, 1, 'Quận Hai Bà Trưng'),
(8, 1, 'Quận Hoàng Mai'),
(9, 1, 'Quận Thanh Xuân'),
(10, 1, 'Huyện Sóc Sơn'),
(11, 1, 'Huyện Đông Anh'),
(12, 1, 'Huyện Gia Lâm'),
(13, 1, 'Quận Nam Từ Liêm'),
(14, 1, 'Huyện Thanh Trì'),
(15, 1, 'Quận Bắc Từ Liêm'),
(16, 1, 'Huyện Mê Linh'),
(17, 1, 'Quận Hà Đông'),
(18, 1, 'Thị xã Sơn Tây'),
(19, 1, 'Huyện Ba Vì'),
(20, 1, 'Huyện Phúc Thọ'),
(21, 1, 'Huyện Đan Phượng'),
(22, 1, 'Huyện Hoài Đức'),
(23, 1, 'Huyện Quốc Oai'),
(24, 1, 'Huyện Thạch Thất'),
(25, 1, 'Huyện Chương Mỹ'),
(26, 1, 'Huyện Thanh Oai'),
(27, 1, 'Huyện Thường Tín'),
(28, 1, 'Huyện Phú Xuyên'),
(29, 1, 'Huyện Ứng Hòa'),
(30, 1, 'Huyện Mỹ Đức'),
(31, 2, 'Thành phố Hà Giang'),
(32, 2, 'Huyện Đồng Văn'),
(33, 2, 'Huyện Mèo Vạc'),
(34, 2, 'Huyện Yên Minh'),
(35, 2, 'Huyện Quản Bạ'),
(36, 2, 'Huyện Vị Xuyên'),
(37, 2, 'Huyện Bắc Mê'),
(38, 2, 'Huyện Hoàng Su Phì'),
(39, 2, 'Huyện Xín Mần'),
(40, 2, 'Huyện Bắc Quang'),
(41, 2, 'Huyện Quang Bình'),
(42, 3, 'Thành phố Cao Bằng'),
(43, 3, 'Huyện Bảo Lâm'),
(44, 3, 'Huyện Bảo Lạc'),
(45, 3, 'Huyện Hà Quảng'),
(46, 3, 'Huyện Trùng Khánh'),
(47, 3, 'Huyện Hạ Lang'),
(48, 3, 'Huyện Quảng Hòa'),
(49, 3, 'Huyện Hoà An'),
(50, 3, 'Huyện Nguyên Bình'),
(51, 3, 'Huyện Thạch An'),
(52, 4, 'Thành Phố Bắc Kạn'),
(53, 4, 'Huyện Pác Nặm'),
(54, 4, 'Huyện Ba Bể'),
(55, 4, 'Huyện Ngân Sơn'),
(56, 4, 'Huyện Bạch Thông'),
(57, 4, 'Huyện Chợ Đồn'),
(58, 4, 'Huyện Chợ Mới'),
(59, 4, 'Huyện Na Rì'),
(60, 5, 'Thành phố Tuyên Quang'),
(61, 5, 'Huyện Lâm Bình'),
(62, 5, 'Huyện Na Hang'),
(63, 5, 'Huyện Chiêm Hóa'),
(64, 5, 'Huyện Hàm Yên'),
(65, 5, 'Huyện Yên Sơn'),
(66, 5, 'Huyện Sơn Dương'),
(67, 6, 'Thành phố Lào Cai'),
(68, 6, 'Huyện Bát Xát'),
(69, 6, 'Huyện Mường Khương'),
(70, 6, 'Huyện Si Ma Cai'),
(71, 6, 'Huyện Bắc Hà'),
(72, 6, 'Huyện Bảo Thắng'),
(73, 6, 'Huyện Bảo Yên'),
(74, 6, 'Thị xã Sa Pa'),
(75, 6, 'Huyện Văn Bàn'),
(76, 7, 'Thành phố Điện Biên Phủ'),
(77, 7, 'Thị Xã Mường Lay'),
(78, 7, 'Huyện Mường Nhé'),
(79, 7, 'Huyện Mường Chà'),
(80, 7, 'Huyện Tủa Chùa'),
(81, 7, 'Huyện Tuần Giáo'),
(82, 7, 'Huyện Điện Biên'),
(83, 7, 'Huyện Điện Biên Đông'),
(84, 7, 'Huyện Mường Ảng'),
(85, 7, 'Huyện Nậm Pồ'),
(86, 8, 'Thành phố Lai Châu'),
(87, 8, 'Huyện Tam Đường'),
(88, 8, 'Huyện Mường Tè'),
(89, 8, 'Huyện Sìn Hồ'),
(90, 8, 'Huyện Phong Thổ'),
(91, 8, 'Huyện Than Uyên'),
(92, 8, 'Huyện Tân Uyên'),
(93, 8, 'Huyện Nậm Nhùn'),
(94, 9, 'Thành phố Sơn La'),
(95, 9, 'Huyện Quỳnh Nhai'),
(96, 9, 'Huyện Thuận Châu'),
(97, 9, 'Huyện Mường La'),
(98, 9, 'Huyện Bắc Yên'),
(99, 9, 'Huyện Phù Yên'),
(100, 9, 'Huyện Mộc Châu'),
(101, 9, 'Huyện Yên Châu'),
(102, 9, 'Huyện Mai Sơn'),
(103, 9, 'Huyện Sông Mã'),
(104, 9, 'Huyện Sốp Cộp'),
(105, 9, 'Huyện Vân Hồ'),
(106, 10, 'Thành phố Yên Bái'),
(107, 10, 'Thị xã Nghĩa Lộ'),
(108, 10, 'Huyện Lục Yên'),
(109, 10, 'Huyện Văn Yên'),
(110, 10, 'Huyện Mù Căng Chải'),
(111, 10, 'Huyện Trấn Yên'),
(112, 10, 'Huyện Trạm Tấu'),
(113, 10, 'Huyện Văn Chấn'),
(114, 10, 'Huyện Yên Bình'),
(115, 11, 'Thành phố Hòa Bình'),
(116, 11, 'Huyện Đà Bắc'),
(117, 11, 'Huyện Lương Sơn'),
(118, 11, 'Huyện Kim Bôi'),
(119, 11, 'Huyện Cao Phong'),
(120, 11, 'Huyện Tân Lạc'),
(121, 11, 'Huyện Mai Châu'),
(122, 11, 'Huyện Lạc Sơn'),
(123, 11, 'Huyện Yên Thủy'),
(124, 11, 'Huyện Lạc Thủy'),
(125, 12, 'Thành phố Thái Nguyên'),
(126, 12, 'Thành phố Sông Công'),
(127, 12, 'Huyện Định Hóa'),
(128, 12, 'Huyện Phú Lương'),
(129, 12, 'Huyện Đồng Hỷ'),
(130, 12, 'Huyện Võ Nhai'),
(131, 12, 'Huyện Đại Từ'),
(132, 12, 'Thị xã Phổ Yên'),
(133, 12, 'Huyện Phú Bình'),
(134, 13, 'Thành phố Lạng Sơn'),
(135, 13, 'Huyện Tràng Định'),
(136, 13, 'Huyện Bình Gia'),
(137, 13, 'Huyện Văn Lãng'),
(138, 13, 'Huyện Cao Lộc'),
(139, 13, 'Huyện Văn Quan'),
(140, 13, 'Huyện Bắc Sơn'),
(141, 13, 'Huyện Hữu Lũng'),
(142, 13, 'Huyện Chi Lăng'),
(143, 13, 'Huyện Lộc Bình'),
(144, 13, 'Huyện Đình Lập'),
(145, 14, 'Thành phố Hạ Long'),
(146, 14, 'Thành phố Móng Cái'),
(147, 14, 'Thành phố Cẩm Phả'),
(148, 14, 'Thành phố Uông Bí'),
(149, 14, 'Huyện Bình Liêu'),
(150, 14, 'Huyện Tiên Yên'),
(151, 14, 'Huyện Đầm Hà'),
(152, 14, 'Huyện Hải Hà'),
(153, 14, 'Huyện Ba Chẽ'),
(154, 14, 'Huyện Vân Đồn'),
(155, 14, 'Thị xã Đông Triều'),
(156, 14, 'Thị xã Quảng Yên'),
(157, 14, 'Huyện Cô Tô'),
(158, 15, 'Thành phố Bắc Giang'),
(159, 15, 'Huyện Yên Thế'),
(160, 15, 'Huyện Tân Yên'),
(161, 15, 'Huyện Lạng Giang'),
(162, 15, 'Huyện Lục Nam'),
(163, 15, 'Huyện Lục Ngạn'),
(164, 15, 'Huyện Sơn Động'),
(165, 15, 'Huyện Yên Dũng'),
(166, 15, 'Huyện Việt Yên'),
(167, 15, 'Huyện Hiệp Hòa'),
(168, 16, 'Thành phố Việt Trì'),
(169, 16, 'Thị xã Phú Thọ'),
(170, 16, 'Huyện Đoan Hùng'),
(171, 16, 'Huyện Hạ Hoà'),
(172, 16, 'Huyện Thanh Ba'),
(173, 16, 'Huyện Phù Ninh'),
(174, 16, 'Huyện Yên Lập'),
(175, 16, 'Huyện Cẩm Khê'),
(176, 16, 'Huyện Tam Nông'),
(177, 16, 'Huyện Lâm Thao'),
(178, 16, 'Huyện Thanh Sơn'),
(179, 16, 'Huyện Thanh Thuỷ'),
(180, 16, 'Huyện Tân Sơn'),
(181, 17, 'Thành phố Vĩnh Yên'),
(182, 17, 'Thành phố Phúc Yên'),
(183, 17, 'Huyện Lập Thạch'),
(184, 17, 'Huyện Tam Dương'),
(185, 17, 'Huyện Tam Đảo'),
(186, 17, 'Huyện Bình Xuyên'),
(187, 17, 'Huyện Yên Lạc'),
(188, 17, 'Huyện Vĩnh Tường'),
(189, 17, 'Huyện Sông Lô'),
(190, 18, 'Thành phố Bắc Ninh'),
(191, 18, 'Huyện Yên Phong'),
(192, 18, 'Huyện Quế Võ'),
(193, 18, 'Huyện Tiên Du'),
(194, 18, 'Thành phố Từ Sơn'),
(195, 18, 'Huyện Thuận Thành'),
(196, 18, 'Huyện Gia Bình'),
(197, 18, 'Huyện Lương Tài'),
(198, 19, 'Thành phố Hải Dương'),
(199, 19, 'Thành phố Chí Linh'),
(200, 19, 'Huyện Nam Sách'),
(201, 19, 'Thị xã Kinh Môn'),
(202, 19, 'Huyện Kim Thành'),
(203, 19, 'Huyện Thanh Hà'),
(204, 19, 'Huyện Cẩm Giàng'),
(205, 19, 'Huyện Bình Giang'),
(206, 19, 'Huyện Gia Lộc'),
(207, 19, 'Huyện Tứ Kỳ'),
(208, 19, 'Huyện Ninh Giang'),
(209, 19, 'Huyện Thanh Miện'),
(210, 20, 'Quận Hồng Bàng'),
(211, 20, 'Quận Ngô Quyền'),
(212, 20, 'Quận Lê Chân'),
(213, 20, 'Quận Hải An'),
(214, 20, 'Quận Kiến An'),
(215, 20, 'Quận Đồ Sơn'),
(216, 20, 'Quận Dương Kinh'),
(217, 20, 'Huyện Thuỷ Nguyên'),
(218, 20, 'Huyện An Dương'),
(219, 20, 'Huyện An Lão'),
(220, 20, 'Huyện Kiến Thuỵ'),
(221, 20, 'Huyện Tiên Lãng'),
(222, 20, 'Huyện Vĩnh Bảo'),
(223, 20, 'Huyện Cát Hải'),
(224, 20, 'Huyện Bạch Long Vĩ'),
(225, 21, 'Thành phố Hưng Yên'),
(226, 21, 'Huyện Văn Lâm'),
(227, 21, 'Huyện Văn Giang'),
(228, 21, 'Huyện Yên Mỹ'),
(229, 21, 'Thị xã Mỹ Hào'),
(230, 21, 'Huyện Ân Thi'),
(231, 21, 'Huyện Khoái Châu'),
(232, 21, 'Huyện Kim Động'),
(233, 21, 'Huyện Tiên Lữ'),
(234, 21, 'Huyện Phù Cừ'),
(235, 22, 'Thành phố Thái Bình'),
(236, 22, 'Huyện Quỳnh Phụ'),
(237, 22, 'Huyện Hưng Hà'),
(238, 22, 'Huyện Đông Hưng'),
(239, 22, 'Huyện Thái Thụy'),
(240, 22, 'Huyện Tiền Hải'),
(241, 22, 'Huyện Kiến Xương'),
(242, 22, 'Huyện Vũ Thư'),
(243, 23, 'Thành phố Phủ Lý'),
(244, 23, 'Thị xã Duy Tiên'),
(245, 23, 'Huyện Kim Bảng'),
(246, 23, 'Huyện Thanh Liêm'),
(247, 23, 'Huyện Bình Lục'),
(248, 23, 'Huyện Lý Nhân'),
(249, 24, 'Thành phố Nam Định'),
(250, 24, 'Huyện Mỹ Lộc'),
(251, 24, 'Huyện Vụ Bản'),
(252, 24, 'Huyện Ý Yên'),
(253, 24, 'Huyện Nghĩa Hưng'),
(254, 24, 'Huyện Nam Trực'),
(255, 24, 'Huyện Trực Ninh'),
(256, 24, 'Huyện Xuân Trường'),
(257, 24, 'Huyện Giao Thủy'),
(258, 24, 'Huyện Hải Hậu'),
(259, 25, 'Thành phố Ninh Bình'),
(260, 25, 'Thành phố Tam Điệp'),
(261, 25, 'Huyện Nho Quan'),
(262, 25, 'Huyện Gia Viễn'),
(263, 25, 'Huyện Hoa Lư'),
(264, 25, 'Huyện Yên Khánh'),
(265, 25, 'Huyện Kim Sơn'),
(266, 25, 'Huyện Yên Mô'),
(267, 26, 'Thành phố Thanh Hóa'),
(268, 26, 'Thị xã Bỉm Sơn'),
(269, 26, 'Thành phố Sầm Sơn'),
(270, 26, 'Huyện Mường Lát'),
(271, 26, 'Huyện Quan Hóa'),
(272, 26, 'Huyện Bá Thước'),
(273, 26, 'Huyện Quan Sơn'),
(274, 26, 'Huyện Lang Chánh'),
(275, 26, 'Huyện Ngọc Lặc'),
(276, 26, 'Huyện Cẩm Thủy'),
(277, 26, 'Huyện Thạch Thành'),
(278, 26, 'Huyện Hà Trung'),
(279, 26, 'Huyện Vĩnh Lộc'),
(280, 26, 'Huyện Yên Định'),
(281, 26, 'Huyện Thọ Xuân'),
(282, 26, 'Huyện Thường Xuân'),
(283, 26, 'Huyện Triệu Sơn'),
(284, 26, 'Huyện Thiệu Hóa'),
(285, 26, 'Huyện Hoằng Hóa'),
(286, 26, 'Huyện Hậu Lộc'),
(287, 26, 'Huyện Nga Sơn'),
(288, 26, 'Huyện Như Xuân'),
(289, 26, 'Huyện Như Thanh'),
(290, 26, 'Huyện Nông Cống'),
(291, 26, 'Huyện Đông Sơn'),
(292, 26, 'Huyện Quảng Xương'),
(293, 26, 'Thị xã Nghi Sơn'),
(294, 27, 'Thành phố Vinh'),
(295, 27, 'Thị xã Cửa Lò'),
(296, 27, 'Thị xã Thái Hoà'),
(297, 27, 'Huyện Quế Phong'),
(298, 27, 'Huyện Quỳ Châu'),
(299, 27, 'Huyện Kỳ Sơn'),
(300, 27, 'Huyện Tương Dương'),
(301, 27, 'Huyện Nghĩa Đàn'),
(302, 27, 'Huyện Quỳ Hợp'),
(303, 27, 'Huyện Quỳnh Lưu'),
(304, 27, 'Huyện Con Cuông'),
(305, 27, 'Huyện Tân Kỳ'),
(306, 27, 'Huyện Anh Sơn'),
(307, 27, 'Huyện Diễn Châu'),
(308, 27, 'Huyện Yên Thành'),
(309, 27, 'Huyện Đô Lương'),
(310, 27, 'Huyện Thanh Chương'),
(311, 27, 'Huyện Nghi Lộc'),
(312, 27, 'Huyện Nam Đàn'),
(313, 27, 'Huyện Hưng Nguyên'),
(314, 27, 'Thị xã Hoàng Mai'),
(315, 28, 'Thành phố Hà Tĩnh'),
(316, 28, 'Thị xã Hồng Lĩnh'),
(317, 28, 'Huyện Hương Sơn'),
(318, 28, 'Huyện Đức Thọ'),
(319, 28, 'Huyện Vũ Quang'),
(320, 28, 'Huyện Nghi Xuân'),
(321, 28, 'Huyện Can Lộc'),
(322, 28, 'Huyện Hương Khê'),
(323, 28, 'Huyện Thạch Hà'),
(324, 28, 'Huyện Cẩm Xuyên'),
(325, 28, 'Huyện Kỳ Anh'),
(326, 28, 'Huyện Lộc Hà'),
(327, 28, 'Thị xã Kỳ Anh'),
(328, 29, 'Thành Phố Đồng Hới'),
(329, 29, 'Huyện Minh Hóa'),
(330, 29, 'Huyện Tuyên Hóa'),
(331, 29, 'Huyện Quảng Trạch'),
(332, 29, 'Huyện Bố Trạch'),
(333, 29, 'Huyện Quảng Ninh'),
(334, 29, 'Huyện Lệ Thủy'),
(335, 29, 'Thị xã Ba Đồn'),
(336, 30, 'Thành phố Đông Hà'),
(337, 30, 'Thị xã Quảng Trị'),
(338, 30, 'Huyện Vĩnh Linh'),
(339, 30, 'Huyện Hướng Hóa'),
(340, 30, 'Huyện Gio Linh'),
(341, 30, 'Huyện Đa Krông'),
(342, 30, 'Huyện Cam Lộ'),
(343, 30, 'Huyện Triệu Phong'),
(344, 30, 'Huyện Hải Lăng'),
(345, 30, 'Huyện Cồn Cỏ'),
(346, 31, 'Thành phố Huế'),
(347, 31, 'Huyện Phong Điền'),
(348, 31, 'Huyện Quảng Điền'),
(349, 31, 'Huyện Phú Vang'),
(350, 31, 'Thị xã Hương Thủy'),
(351, 31, 'Thị xã Hương Trà'),
(352, 31, 'Huyện A Lưới'),
(353, 31, 'Huyện Phú Lộc'),
(354, 31, 'Huyện Nam Đông'),
(355, 32, 'Quận Liên Chiểu'),
(356, 32, 'Quận Thanh Khê'),
(357, 32, 'Quận Hải Châu'),
(358, 32, 'Quận Sơn Trà'),
(359, 32, 'Quận Ngũ Hành Sơn'),
(360, 32, 'Quận Cẩm Lệ'),
(361, 32, 'Huyện Hòa Vang'),
(362, 32, 'Huyện Hoàng Sa'),
(363, 33, 'Thành phố Tam Kỳ'),
(364, 33, 'Thành phố Hội An'),
(365, 33, 'Huyện Tây Giang'),
(366, 33, 'Huyện Đông Giang'),
(367, 33, 'Huyện Đại Lộc'),
(368, 33, 'Thị xã Điện Bàn'),
(369, 33, 'Huyện Duy Xuyên'),
(370, 33, 'Huyện Quế Sơn'),
(371, 33, 'Huyện Nam Giang'),
(372, 33, 'Huyện Phước Sơn'),
(373, 33, 'Huyện Hiệp Đức'),
(374, 33, 'Huyện Thăng Bình'),
(375, 33, 'Huyện Tiên Phước'),
(376, 33, 'Huyện Bắc Trà My'),
(377, 33, 'Huyện Nam Trà My'),
(378, 33, 'Huyện Núi Thành'),
(379, 33, 'Huyện Phú Ninh'),
(380, 33, 'Huyện Nông Sơn'),
(381, 34, 'Thành phố Quảng Ngãi'),
(382, 34, 'Huyện Bình Sơn'),
(383, 34, 'Huyện Trà Bồng'),
(384, 34, 'Huyện Sơn Tịnh'),
(385, 34, 'Huyện Tư Nghĩa'),
(386, 34, 'Huyện Sơn Hà'),
(387, 34, 'Huyện Sơn Tây'),
(388, 34, 'Huyện Minh Long'),
(389, 34, 'Huyện Nghĩa Hành'),
(390, 34, 'Huyện Mộ Đức'),
(391, 34, 'Thị xã Đức Phổ'),
(392, 34, 'Huyện Ba Tơ'),
(393, 34, 'Huyện Lý Sơn'),
(394, 35, 'Thành phố Quy Nhơn'),
(395, 35, 'Huyện An Lão'),
(396, 35, 'Thị xã Hoài Nhơn'),
(397, 35, 'Huyện Hoài Ân'),
(398, 35, 'Huyện Phù Mỹ'),
(399, 35, 'Huyện Vĩnh Thạnh'),
(400, 35, 'Huyện Tây Sơn'),
(401, 35, 'Huyện Phù Cát'),
(402, 35, 'Thị xã An Nhơn'),
(403, 35, 'Huyện Tuy Phước'),
(404, 35, 'Huyện Vân Canh'),
(405, 36, 'Thành phố Tuy Hoà'),
(406, 36, 'Thị xã Sông Cầu'),
(407, 36, 'Huyện Đồng Xuân'),
(408, 36, 'Huyện Tuy An'),
(409, 36, 'Huyện Sơn Hòa'),
(410, 36, 'Huyện Sông Hinh'),
(411, 36, 'Huyện Tây Hoà'),
(412, 36, 'Huyện Phú Hoà'),
(413, 36, 'Thị xã Đông Hòa'),
(414, 37, 'Thành phố Nha Trang'),
(415, 37, 'Thành phố Cam Ranh'),
(416, 37, 'Huyện Cam Lâm'),
(417, 37, 'Huyện Vạn Ninh'),
(418, 37, 'Thị xã Ninh Hòa'),
(419, 37, 'Huyện Khánh Vĩnh'),
(420, 37, 'Huyện Diên Khánh'),
(421, 37, 'Huyện Khánh Sơn'),
(422, 37, 'Huyện Trường Sa'),
(423, 38, 'Thành phố Phan Rang-Tháp Chàm'),
(424, 38, 'Huyện Bác Ái'),
(425, 38, 'Huyện Ninh Sơn'),
(426, 38, 'Huyện Ninh Hải'),
(427, 38, 'Huyện Ninh Phước'),
(428, 38, 'Huyện Thuận Bắc'),
(429, 38, 'Huyện Thuận Nam'),
(430, 39, 'Thành phố Phan Thiết'),
(431, 39, 'Thị xã La Gi'),
(432, 39, 'Huyện Tuy Phong'),
(433, 39, 'Huyện Bắc Bình'),
(434, 39, 'Huyện Hàm Thuận Bắc'),
(435, 39, 'Huyện Hàm Thuận Nam'),
(436, 39, 'Huyện Tánh Linh'),
(437, 39, 'Huyện Đức Linh'),
(438, 39, 'Huyện Hàm Tân'),
(439, 39, 'Huyện Phú Quí'),
(440, 40, 'Thành phố Kon Tum'),
(441, 40, 'Huyện Đắk Glei'),
(442, 40, 'Huyện Ngọc Hồi'),
(443, 40, 'Huyện Đắk Tô'),
(444, 40, 'Huyện Kon Plông'),
(445, 40, 'Huyện Kon Rẫy'),
(446, 40, 'Huyện Đắk Hà'),
(447, 40, 'Huyện Sa Thầy'),
(448, 40, 'Huyện Tu Mơ Rông'),
(449, 40, 'Huyện Ia H\' Drai'),
(450, 41, 'Thành phố Pleiku'),
(451, 41, 'Thị xã An Khê'),
(452, 41, 'Thị xã Ayun Pa'),
(453, 41, 'Huyện KBang'),
(454, 41, 'Huyện Đăk Đoa'),
(455, 41, 'Huyện Chư Păh'),
(456, 41, 'Huyện Ia Grai'),
(457, 41, 'Huyện Mang Yang'),
(458, 41, 'Huyện Kông Chro'),
(459, 41, 'Huyện Đức Cơ'),
(460, 41, 'Huyện Chư Prông'),
(461, 41, 'Huyện Chư Sê'),
(462, 41, 'Huyện Đăk Pơ'),
(463, 41, 'Huyện Ia Pa'),
(464, 41, 'Huyện Krông Pa'),
(465, 41, 'Huyện Phú Thiện'),
(466, 41, 'Huyện Chư Pưh'),
(467, 42, 'Thành phố Buôn Ma Thuột'),
(468, 42, 'Thị Xã Buôn Hồ'),
(469, 42, 'Huyện Ea H\'leo'),
(470, 42, 'Huyện Ea Súp'),
(471, 42, 'Huyện Buôn Đôn'),
(472, 42, 'Huyện Cư M\'gar'),
(473, 42, 'Huyện Krông Búk'),
(474, 42, 'Huyện Krông Năng'),
(475, 42, 'Huyện Ea Kar'),
(476, 42, 'Huyện M\'Đrắk'),
(477, 42, 'Huyện Krông Bông'),
(478, 42, 'Huyện Krông Pắc'),
(479, 42, 'Huyện Krông A Na'),
(480, 42, 'Huyện Lắk'),
(481, 42, 'Huyện Cư Kuin'),
(482, 43, 'Thành phố Gia Nghĩa'),
(483, 43, 'Huyện Đăk Glong'),
(484, 43, 'Huyện Cư Jút'),
(485, 43, 'Huyện Đắk Mil'),
(486, 43, 'Huyện Krông Nô'),
(487, 43, 'Huyện Đắk Song'),
(488, 43, 'Huyện Đắk R\'Lấp'),
(489, 43, 'Huyện Tuy Đức'),
(490, 44, 'Thành phố Đà Lạt'),
(491, 44, 'Thành phố Bảo Lộc'),
(492, 44, 'Huyện Đam Rông'),
(493, 44, 'Huyện Lạc Dương'),
(494, 44, 'Huyện Lâm Hà'),
(495, 44, 'Huyện Đơn Dương'),
(496, 44, 'Huyện Đức Trọng'),
(497, 44, 'Huyện Di Linh'),
(498, 44, 'Huyện Bảo Lâm'),
(499, 44, 'Huyện Đạ Huoai'),
(500, 44, 'Huyện Đạ Tẻh'),
(501, 44, 'Huyện Cát Tiên'),
(502, 45, 'Thị xã Phước Long'),
(503, 45, 'Thành phố Đồng Xoài'),
(504, 45, 'Thị xã Bình Long'),
(505, 45, 'Huyện Bù Gia Mập'),
(506, 45, 'Huyện Lộc Ninh'),
(507, 45, 'Huyện Bù Đốp'),
(508, 45, 'Huyện Hớn Quản'),
(509, 45, 'Huyện Đồng Phú'),
(510, 45, 'Huyện Bù Đăng'),
(511, 45, 'Huyện Chơn Thành'),
(512, 45, 'Huyện Phú Riềng'),
(513, 46, 'Thành phố Tây Ninh'),
(514, 46, 'Huyện Tân Biên'),
(515, 46, 'Huyện Tân Châu'),
(516, 46, 'Huyện Dương Minh Châu'),
(517, 46, 'Huyện Châu Thành'),
(518, 46, 'Thị xã Hòa Thành'),
(519, 46, 'Huyện Gò Dầu'),
(520, 46, 'Huyện Bến Cầu'),
(521, 46, 'Thị xã Trảng Bàng'),
(522, 47, 'Thành phố Thủ Dầu Một'),
(523, 47, 'Huyện Bàu Bàng'),
(524, 47, 'Huyện Dầu Tiếng'),
(525, 47, 'Thị xã Bến Cát'),
(526, 47, 'Huyện Phú Giáo'),
(527, 47, 'Thị xã Tân Uyên'),
(528, 47, 'Thành phố Dĩ An'),
(529, 47, 'Thành phố Thuận An'),
(530, 47, 'Huyện Bắc Tân Uyên'),
(531, 48, 'Thành phố Biên Hòa'),
(532, 48, 'Thành phố Long Khánh'),
(533, 48, 'Huyện Tân Phú'),
(534, 48, 'Huyện Vĩnh Cửu'),
(535, 48, 'Huyện Định Quán'),
(536, 48, 'Huyện Trảng Bom'),
(537, 48, 'Huyện Thống Nhất'),
(538, 48, 'Huyện Cẩm Mỹ'),
(539, 48, 'Huyện Long Thành'),
(540, 48, 'Huyện Xuân Lộc'),
(541, 48, 'Huyện Nhơn Trạch'),
(542, 49, 'Thành phố Vũng Tàu'),
(543, 49, 'Thành phố Bà Rịa'),
(544, 49, 'Huyện Châu Đức'),
(545, 49, 'Huyện Xuyên Mộc'),
(546, 49, 'Huyện Long Điền'),
(547, 49, 'Huyện Đất Đỏ'),
(548, 49, 'Thị xã Phú Mỹ'),
(549, 49, 'Huyện Côn Đảo'),
(550, 50, 'Quận 1'),
(551, 50, 'Quận 12'),
(552, 50, 'Quận Gò Vấp'),
(553, 50, 'Quận Bình Thạnh'),
(554, 50, 'Quận Tân Bình'),
(555, 50, 'Quận Tân Phú'),
(556, 50, 'Quận Phú Nhuận'),
(557, 50, 'Thành phố Thủ Đức'),
(558, 50, 'Quận 3'),
(559, 50, 'Quận 10'),
(560, 50, 'Quận 11'),
(561, 50, 'Quận 4'),
(562, 50, 'Quận 5'),
(563, 50, 'Quận 6'),
(564, 50, 'Quận 8'),
(565, 50, 'Quận Bình Tân'),
(566, 50, 'Quận 7'),
(567, 50, 'Huyện Củ Chi'),
(568, 50, 'Huyện Hóc Môn'),
(569, 50, 'Huyện Bình Chánh'),
(570, 50, 'Huyện Nhà Bè'),
(571, 50, 'Huyện Cần Giờ'),
(572, 51, 'Thành phố Tân An'),
(573, 51, 'Thị xã Kiến Tường'),
(574, 51, 'Huyện Tân Hưng'),
(575, 51, 'Huyện Vĩnh Hưng'),
(576, 51, 'Huyện Mộc Hóa'),
(577, 51, 'Huyện Tân Thạnh'),
(578, 51, 'Huyện Thạnh Hóa'),
(579, 51, 'Huyện Đức Huệ'),
(580, 51, 'Huyện Đức Hòa'),
(581, 51, 'Huyện Bến Lức'),
(582, 51, 'Huyện Thủ Thừa'),
(583, 51, 'Huyện Tân Trụ'),
(584, 51, 'Huyện Cần Đước'),
(585, 51, 'Huyện Cần Giuộc'),
(586, 51, 'Huyện Châu Thành'),
(587, 52, 'Thành phố Mỹ Tho'),
(588, 52, 'Thị xã Gò Công'),
(589, 52, 'Thị xã Cai Lậy'),
(590, 52, 'Huyện Tân Phước'),
(591, 52, 'Huyện Cái Bè'),
(592, 52, 'Huyện Cai Lậy'),
(593, 52, 'Huyện Châu Thành'),
(594, 52, 'Huyện Chợ Gạo'),
(595, 52, 'Huyện Gò Công Tây'),
(596, 52, 'Huyện Gò Công Đông'),
(597, 52, 'Huyện Tân Phú Đông'),
(598, 53, 'Thành phố Bến Tre'),
(599, 53, 'Huyện Châu Thành'),
(600, 53, 'Huyện Chợ Lách'),
(601, 53, 'Huyện Mỏ Cày Nam'),
(602, 53, 'Huyện Giồng Trôm'),
(603, 53, 'Huyện Bình Đại'),
(604, 53, 'Huyện Ba Tri'),
(605, 53, 'Huyện Thạnh Phú'),
(606, 53, 'Huyện Mỏ Cày Bắc'),
(607, 54, 'Thành phố Trà Vinh'),
(608, 54, 'Huyện Càng Long'),
(609, 54, 'Huyện Cầu Kè'),
(610, 54, 'Huyện Tiểu Cần'),
(611, 54, 'Huyện Châu Thành'),
(612, 54, 'Huyện Cầu Ngang'),
(613, 54, 'Huyện Trà Cú'),
(614, 54, 'Huyện Duyên Hải'),
(615, 54, 'Thị xã Duyên Hải'),
(616, 55, 'Thành phố Vĩnh Long'),
(617, 55, 'Huyện Long Hồ'),
(618, 55, 'Huyện Mang Thít'),
(619, 55, 'Huyện  Vũng Liêm'),
(620, 55, 'Huyện Tam Bình'),
(621, 55, 'Thị xã Bình Minh'),
(622, 55, 'Huyện Trà Ôn'),
(623, 55, 'Huyện Bình Tân'),
(624, 56, 'Thành phố Cao Lãnh'),
(625, 56, 'Thành phố Sa Đéc'),
(626, 56, 'Thành phố Hồng Ngự'),
(627, 56, 'Huyện Tân Hồng'),
(628, 56, 'Huyện Hồng Ngự'),
(629, 56, 'Huyện Tam Nông'),
(630, 56, 'Huyện Tháp Mười'),
(631, 56, 'Huyện Cao Lãnh'),
(632, 56, 'Huyện Thanh Bình'),
(633, 56, 'Huyện Lấp Vò'),
(634, 56, 'Huyện Lai Vung'),
(635, 56, 'Huyện Châu Thành'),
(636, 57, 'Thành phố Long Xuyên'),
(637, 57, 'Thành phố Châu Đốc'),
(638, 57, 'Huyện An Phú'),
(639, 57, 'Thị xã Tân Châu'),
(640, 57, 'Huyện Phú Tân'),
(641, 57, 'Huyện Châu Phú'),
(642, 57, 'Huyện Tịnh Biên'),
(643, 57, 'Huyện Tri Tôn'),
(644, 57, 'Huyện Châu Thành'),
(645, 57, 'Huyện Chợ Mới'),
(646, 57, 'Huyện Thoại Sơn'),
(647, 58, 'Thành phố Rạch Giá'),
(648, 58, 'Thành phố Hà Tiên'),
(649, 58, 'Huyện Kiên Lương'),
(650, 58, 'Huyện Hòn Đất'),
(651, 58, 'Huyện Tân Hiệp'),
(652, 58, 'Huyện Châu Thành'),
(653, 58, 'Huyện Giồng Riềng'),
(654, 58, 'Huyện Gò Quao'),
(655, 58, 'Huyện An Biên'),
(656, 58, 'Huyện An Minh'),
(657, 58, 'Huyện Vĩnh Thuận'),
(658, 58, 'Thành phố Phú Quốc'),
(659, 58, 'Huyện Kiên Hải'),
(660, 58, 'Huyện U Minh Thượng'),
(661, 58, 'Huyện Giang Thành'),
(662, 59, 'Quận Ninh Kiều'),
(663, 59, 'Quận Ô Môn'),
(664, 59, 'Quận Bình Thuỷ'),
(665, 59, 'Quận Cái Răng'),
(666, 59, 'Quận Thốt Nốt'),
(667, 59, 'Huyện Vĩnh Thạnh'),
(668, 59, 'Huyện Cờ Đỏ'),
(669, 59, 'Huyện Phong Điền'),
(670, 59, 'Huyện Thới Lai'),
(671, 60, 'Thành phố Vị Thanh'),
(672, 60, 'Thành phố Ngã Bảy'),
(673, 60, 'Huyện Châu Thành A'),
(674, 60, 'Huyện Châu Thành'),
(675, 60, 'Huyện Phụng Hiệp'),
(676, 60, 'Huyện Vị Thuỷ'),
(677, 60, 'Huyện Long Mỹ'),
(678, 60, 'Thị xã Long Mỹ'),
(679, 61, 'Thành phố Sóc Trăng'),
(680, 61, 'Huyện Châu Thành'),
(681, 61, 'Huyện Kế Sách'),
(682, 61, 'Huyện Mỹ Tú'),
(683, 61, 'Huyện Cù Lao Dung'),
(684, 61, 'Huyện Long Phú'),
(685, 61, 'Huyện Mỹ Xuyên'),
(686, 61, 'Thị xã Ngã Năm'),
(687, 61, 'Huyện Thạnh Trị'),
(688, 61, 'Thị xã Vĩnh Châu'),
(689, 61, 'Huyện Trần Đề'),
(690, 62, 'Thành phố Bạc Liêu'),
(691, 62, 'Huyện Hồng Dân'),
(692, 62, 'Huyện Phước Long'),
(693, 62, 'Huyện Vĩnh Lợi'),
(694, 62, 'Thị xã Giá Rai'),
(695, 62, 'Huyện Đông Hải'),
(696, 62, 'Huyện Hoà Bình'),
(697, 63, 'Thành phố Cà Mau'),
(698, 63, 'Huyện U Minh'),
(699, 63, 'Huyện Thới Bình'),
(700, 63, 'Huyện Trần Văn Thời'),
(701, 63, 'Huyện Cái Nước'),
(702, 63, 'Huyện Đầm Dơi'),
(703, 63, 'Huyện Năm Căn'),
(704, 63, 'Huyện Phú Tân'),
(705, 63, 'Huyện Ngọc Hiển'),
(706, 50, 'Quận 2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `order_id` int(50) NOT NULL,
  `order_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `product_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `district` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PaymentMethod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `customerName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `receipter` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`order_id`, `order_status`, `order_date`, `product_id`, `user_name`, `district`, `city`, `PaymentMethod`, `phone`, `address`, `customerName`, `receipter`) VALUES
(4, 'Chưa xác nhận', '2025-03-01 20:35:42', 'F013', 'huyle123', 'Quận Tân Phú', 'Hồ Chí Minh', 'Banking', '0908654857', '22a Lê Trọng Tấn', 'Lê Minh Huy', ''),
(5, 'Đã hủy', '2025-03-10 20:36:15', 'F003', 'huong8181', 'Quận 1', 'Hồ Chí Minh', 'COD', '0867854386', '929 Tôn Đức Thắng', 'Khúc Thị Hương', ''),
(6, 'Giao thành công', '2025-03-12 20:37:59', 'F007', 'tuan8181', 'Quận Bình Thạnh', 'Hồ Chí Minh', 'COD', '0965428791', '2 Nguyễn Hữu Cảnh', 'Phạm Đức Tuấn', 'Phạm Đức Tuấn'),
(7, 'Đã xác nhận', '2025-03-18 20:38:23', 'F013', 'thieu8181', 'Quận 8', 'Hồ Chí Minh', 'COD', '0816576543', '667 Phạm Văn Đồng', 'Nguyễn Gia Thiệu', ''),
(8, 'Giao thành công', '2025-03-25 20:38:48', 'F005', 'quan123', 'Quận Tân Bình', 'Hồ Chí Minh', 'Banking', '0389542657', '99a Lê Văn Sĩ', 'Trần Minh Quân', 'Nguyễn Gia Đạt'),
(9, 'Đã xác nhận', '2025-04-11 06:57:44', 'F007', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'COD', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', ''),
(10, 'Đã xác nhận', '2025-04-13 06:57:44', 'F020', 'hoag123', 'Quận 2', 'Hồ Chí Minh', 'COD', '0906784527', '176 Trần Não', 'Nguyễn Minh Hoàng', '');

-- --------------------------------------------------------


--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATEREATE TABLE `loaisanpham` (
  `category_id` int(11) NOT NULL,
  `name_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`category_id`, `name_type`, `description`) VALUES
(1, 'Trái Cây Nhập Khẩu', 'Trái cây ngon từ nước ngoài'),
(2, 'Trái Cây Việt', 'Trái cây ngon nội địa'),
(3, 'Trái Cây Ngon', 'Trái cây ưu việt'),
(4, 'Rau Củ', 'Rau củ sạch'),
(5, 'Hạt', 'Hạt bổ'),
(6, 'Trái Cây Khô', 'Trái cây khô');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hashPass` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_role` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `district` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`fullname`, `user_name`, `user_pass`, `hashPass`, `user_email`, `user_address`, `phone`, `user_role`, `user_status`, `district`, `city`) VALUES
('Nguyễn Minh Hoàng', 'hoag123', 'hoag123@', '', 'hoangnguyen@gmail.com', '176 Trần Não', '0906784527', 'Khách hàng', 'Hoạt động', 'Quận 2', 'Hồ Chí Minh'),
('Khúc Thị Hương', 'huong8181', 'huong123@', '', 'huongkhuc@gmail.com', '929 Tôn Đức Thắng', '0867854386', 'Khách hàng', 'Hoạt động', 'Quận 1', 'Hồ Chí Minh'),
('Lê Minh Huy', 'huyle123', 'huy12345', '', 'huyle@gmail.com', '22a Lê Trọng Tấn', '0908654857', 'Khách hàng', 'Hoạt động', 'Quận Tân Phú', 'Hồ Chí Minh'),
('Lưu Gia Huy', 'luuhuy2005', 'huyhuy123', '$2y$10$zIVomGpZ/tNTme1f6Ntfp.LdlLiJoFh3YrowJ0V2W./xK9dPlFtIG', 'huyhuy123@gmail.com', '123 Âu Cơ', '0909123456', 'Quản lý', 'Hoạt động', 'Quận 5', 'Hồ Chí Minh'),
('Trần Minh Quân', 'quan123', 'quan123@', '', 'quantran@gmail.com', '99a Lê Văn Sĩ', '0389542657', 'Khách Hàng', 'Hoạt động', 'Quận Tân Bình', 'Hồ Chí Minh'),
('Nguyễn Gia Thiệu', 'thieu8181', 'thieu123@', '', 'thieunguyen@gmail.com', '667 Phạm Văn Đồng', '0816576543', 'Khách Hàng', 'Hoạt động', 'Quận 8', 'Hồ Chí Minh'),
('Phạm Đức Tuấn', 'tuan8181', 'tuan123@', '', 'tuanpham@gmail.com', '2 Nguyễn Hữu Cảnh', '0965428791', 'Khách Hàng', 'Hoạt động', 'Quận Bình Thạnh', 'Hồ Chí Minh'),
('Châu Uy Vủ', 'uyvu123', 'haha123', '$2y$10$N8ksrPd1cFYtuNo0Rmeb7Ogpp/1bHUyJYrxj3Hw43V6iuUHaMWcgy', 'uyvu@gmail.com', '123 Lạc Long Quân', '0909123457', 'Quản lý', 'Đã khóa', 'Quận 11', 'Hồ Chí Minh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `province`
--

CREATE TABLE `province` (
  `province_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tỉnh thành';

--
-- Đang đổ dữ liệu cho bảng `province`
--

INSERT INTO `province` (`province_id`, `name`) VALUES
(1, ' Hà Nội'),
(2, ' Hà Giang'),
(3, ' Cao Bằng'),
(4, ' Bắc Kạn'),
(5, ' Tuyên Quang'),
(6, ' Lào Cai'),
(7, ' Điện Biên'),
(8, ' Lai Châu'),
(9, ' Sơn La'),
(10, ' Yên Bái'),
(11, ' Hoà Bình'),
(12, ' Thái Nguyên'),
(13, ' Lạng Sơn'),
(14, ' Quảng Ninh'),
(15, ' Bắc Giang'),
(16, ' Phú Thọ'),
(17, ' Vĩnh Phúc'),
(18, ' Bắc Ninh'),
(19, ' Hải Dương'),
(20, ' Hải Phòng'),
(21, ' Hưng Yên'),
(22, ' Thái Bình'),
(23, ' Hà Nam'),
(24, ' Nam Định'),
(25, ' Ninh Bình'),
(26, ' Thanh Hóa'),
(27, ' Nghệ An'),
(28, ' Hà Tĩnh'),
(29, ' Quảng Bình'),
(30, ' Quảng Trị'),
(31, ' Thừa Thiên Huế'),
(32, ' Đà Nẵng'),
(33, ' Quảng Nam'),
(34, ' Quảng Ngãi'),
(35, ' Bình Định'),
(36, ' Phú Yên'),
(37, ' Khánh Hòa'),
(38, ' Ninh Thuận'),
(39, ' Bình Thuận'),
(40, ' Kon Tum'),
(41, ' Gia Lai'),
(42, ' Đắk Lắk'),
(43, ' Đắk Nông'),
(44, ' Lâm Đồng'),
(45, ' Bình Phước'),
(46, ' Tây Ninh'),
(47, ' Bình Dương'),
(48, ' Đồng Nai'),
(49, ' Bà Rịa - Vũng Tàu'),
(50, ' Hồ Chí Minh'),
(51, ' Long An'),
(52, ' Tiền Giang'),
(53, ' Bến Tre'),
(54, ' Trà Vinh'),
(55, ' Vĩnh Long'),
(56, ' Đồng Tháp'),
(57, ' An Giang'),
(58, ' Kiên Giang'),
(59, ' Cần Thơ'),
(60, ' Hậu Giang'),
(61, ' Sóc Trăng'),
(62, ' Bạc Liêu'),
(63, ' Cà Mau');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_price` float NOT NULL,
  `product_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(255) AFTER `product_image`
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`product_id`, `category_id`, `product_name`, `product_image`, `product_status`, `product_price`, `product_type`, `product_description`, `image_url`) VALUES
('F001', 0, 'Chuối Chín Nam Mỹ', 'trai-chuoi.jpg', 'Còn hàng', 160000, 'Trái Cây Nhập Khẩu', '', 'trai-chuoi.jpg'),
('F002', 0, 'Kiwi', 'trai-kiwi.jpg', 'Còn hàng', 160000, 'Trái Cây Nhập Khẩu', '', 'trai-kiwi.jpg'),
('F003', 0, 'Lựu Ai Cập', 'trai-luu.jpg', 'Hết hàng', 160000, 'Trái Cây Nhập Khẩu', '', 'trai-luu.jpg'),
('F004', 0, 'Mận Đỏ An Phước', 'trai-man-do.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', '', 'trai-man-do.jpg'),
('F005', 0, 'Mãng Cầu Xiêm', 'trai-mang-cau.jpg', 'Còn hàng', 45000, 'Trái Cây Ngon', '', 'trai-mang-cau.jpg'),
('F006', 0, 'Nho Mỹ', 'trai-nho-My.jpg', 'Hết hàng', 160000, 'Trái Cây Nhập Khẩu', '', 'trai-nho-My.jpg'),
('F007', 0, 'Ổi Xá Lị', 'trai-oi.jpg', 'Còn hàng', 45000, 'Trái Cây Ngon', '', 'trai-oi.jpg'),
('F008', 0, 'Thanh Long Ruột Đỏ', 'trai-thanh-long.jpg', 'Còn hàng', 45000, 'Trái Cây Ngon', '', 'trai-thanh-long.jpg'),
('F009', 0, 'Bòn Bon', 'trai-bon-bon.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', '', 'trai-bon-bon.jpg'),
('F010', 0, 'Quýt Đường', 'trai-quyt.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', '', 'trai-quyt.jpg'),
('F011', 0, 'Dưa hấu Long An', 'trai-dua-hau.jpg', 'Còn hàng', 45000, 'Trái Cây Ngon', '', 'trai-dua-hau.jpg'),
('F012', 0, 'Chôm chôm', 'trai-chom-chom.jpg', 'Hết hàng', 45000, 'Trái Cây Ngon', '', 'trai-chom-chom.jpg'),
('F013', 0, 'Xoài cát', 'trai-xoai.jpg', 'Hết hàng', 45000, 'Trái Cây Ngon', '', 'trai-xoai.jpg'),
('F014', 0, 'Dâu tây Đà Lạt', 'dau-tay.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', '', 'dau-tay.jpg'),
('F015', 0, 'Mận Hà Nội', 'man-Ha-Noi.jpg', 'Còn hàng', 45000, 'Trái Cây Việt', '', 'man-Ha-Noi.jpg'),
('F016', 0, 'Bưởi da xanh', 'hinh-trai-buoi.jpg', 'Hết hàng', 45000, 'Trái Cây Việt', '', 'hinh-trai-buoi.jpg'),
('F017', 0, 'Táo Envy', 'trai-tao.jpg', 'Hết hàng', 160000, 'Trái Cây Nhập Khẩu', '', 'trai-tao.jpg'),
('F018', 0, 'Cherry Úc', 'trai-cherry-Uc.jpg', 'Còn hàng', 160000, 'Trái Cây Nhập Khẩu', '', 'trai-cherry-Uc.jpg'),
('F019', 0, 'Cà Rốt', 'carot.jpg', 'Còn hàng', 30000, 'Rau Củ', '', 'carot.jpg'),
('F020', 0, 'Cà Chua', 'cachua.png', 'Còn hàng', 30000, 'Rau Củ', '', 'cachua.png'),
('F021', 0, 'Khoai Tây', 'khoaitay.jpg', 'Còn hàng', 31000, 'Rau Củ', '', 'khoaitay.jpg'),
('F022', 0, 'Súp Lơ Xanh', 'suploxanh.jpg', 'Hết hàng', 30000, 'Rau Củ', '', 'suploxanh.jpg'),
('F023', 0, 'Củ Su Hào', 'cusuhao.jpg', 'Hết hàng', 32000, 'Rau Củ', '', 'cusuhao.jpg'),
('F024', 0, 'Xà Lách', 'xalach.jpg', 'Còn hàng', 35000, 'Rau Củ', '', 'xalach.jpg'),
('F025', 0, 'Hạt Óc Chó', 'walnut.jpg', 'Còn hàng', 200000, 'Hạt', '', 'walnut.jpg'),
('F026', 0, 'Hạnh Nhân', 'hanh-nhan.jpg', 'Hết hàng', 240000, 'Hạt', '', 'hanh-nhan.jpg'),
('F027', 0, 'Hạt Điều', 'hat-dieu.jpg', 'Còn hàng', 250000, 'Hạt', '', 'hat-dieu.jpg'),
('F028', 0, 'Hạt Mác Ca', 'hat-mac-ca.jpg', 'Còn hàng', 100000, 'Hạt', '', 'hat-mac-ca.jpg'),
('F029', 0, 'Hạt Dẻ', 'hat-de.jpg', 'Còn hàng', 80000, 'Hạt', '', 'hat-de.jpg'),
('F030', 0, 'Hạt Hồ Đào', 'hat-ho-dao.jpg', 'Hết hàng', 180000, 'Hạt', '', 'hat-ho-dao.jpg'),
('F031', 0, 'Xoài sấy', 'xoai-say.jpg', 'Còn hàng', 130000, 'Trái cây khô', '', 'xoai-say.jpg'),
('F032', 0, 'Táo sấy', 'tao-say.jpg', 'Còn hàng', 150000, 'Trái cây khô', '', 'tao-say.jpg'),
('F033', 0, 'Dâu sấy', 'dau-say.jpg', 'Còn hàng', 450000, 'Trái cây khô', '', 'dau-say.jpg'),
('F034', 0, 'Nho vàng sấy', 'nho-say.jpg', 'Còn hàng', 300000, 'Trái cây khô', '', 'nho-say.jpg'),
('F035', 0, 'Mít sấy', 'mit-say.jpg', 'Còn hàng', 400000, 'Trái cây khô', '', 'mit-say.jpg'),
('F036', 0, 'Kiwi sấy', 'kiwi-say.jpg', 'Còn hàng', 600000, 'Trái cây khô', '', 'kiwi-say.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `excerpt` TEXT,
    `content` TEXT,
    `image_url` VARCHAR(255),
    `category` VARCHAR(50),
    `is_featured` BOOLEAN DEFAULT FALSE,
    `views` INT DEFAULT 0,
    `comments` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`product_id`,`order_id`),
  ADD KEY `fk_pro1` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`district_id`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_product` (`product_id`),
  ADD KEY `fk_usernamee` (`user_name`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`user_name`);

--
-- Chỉ mục cho bảng `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`province_id`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `district`
--
ALTER TABLE `district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=707;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `order_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `province`
--
ALTER TABLE `province`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `fk_pro1` FOREIGN KEY (`product_id`) REFERENCES `sanpham` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `sanpham` (`product_id`),
  ADD CONSTRAINT `fk_usernamee` FOREIGN KEY (`user_name`) REFERENCES `nguoidung` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO news (title, excerpt, content, image_url, category, is_featured, views, comments) VALUES
('Mùa Hè Này Nên Ăn Trái Cây Gì?', 'Khám phá top 10 loại trái cây tốt nhất cho sức khỏe trong mùa hè...', 'Nội dung chi tiết...', '../img/banner-quang-cao.webp', 'Sức khỏe', 1, 1234, 23),
('Cà Rốt - Nguồn Beta Carotene Dồi Dào', 'Tìm hiểu về lợi ích sức khỏe tuyệt vời từ cà rốt và cách chế biến...', 'Nội dung chi tiết...', '../img/tải xuống.jpg', 'Rau củ', 0, 567, 12),
('Dưa Hấu - Thần Dược Giải Nhiệt Mùa Hè', 'Khám phá công dụng tuyệt vời của dưa hấu trong việc giải nhiệt...', 'Nội dung chi tiết...', '../img/trai-dua-hau.webp', 'Trái cây', 0, 789, 15);

INSERT INTO `products` (
  `product_id`, 
  `product_name`, 
  `description`, 
  `image_url`, 
  `price`, 
  `stock_quantity`, 
  `category`,
  `nutrition_info`,
  `benefits`,
  `storage_tips`
) VALUES (
  'F001',
  'Cà Rốt Tươi',
  'Cà rốt không chỉ là một loại rau củ quen thuộc trong bữa ăn hàng ngày mà còn là nguồn dưỡng chất quý giá cho sức khỏe. Với hàm lượng beta-carotene dồi dào, cà rốt được mệnh danh là "thần dược" cho đôi mắt và làn da.',
  '../img/tải xuống.jpg',
  25000,
  100,
  'Rau củ',
  '{"calories": "41", "water": "88%", "carbs": "9.6g", "fiber": "2.8g"}',
  '[{"icon": "eye", "title": "Tăng cường thị lực", "description": "Beta-carotene chuyển hóa thành vitamin A, giúp bảo vệ và cải thiện thị lực."}, {"icon": "shield-alt", "title": "Tăng cường miễn dịch", "description": "Vitamin C và các chất chống oxy hóa giúp tăng cường hệ miễn dịch."}, {"icon": "heartbeat", "title": "Tốt cho tim mạch", "description": "Chất xơ và kali giúp duy trì huyết áp ổn định."}]',
  '[{"icon": "search", "title": "Chọn cà rốt", "items": ["Chọn củ cứng, không mềm", "Màu cam đậm, đồng nhất", "Không có vết nứt hoặc đốm", "Lá xanh tươi (nếu còn)"]}, {"icon": "box", "title": "Bảo quản", "items": ["Bảo quản trong tủ lạnh", "Không rửa trước khi bảo quản", "Cắt bỏ lá xanh (nếu có)", "Để trong túi nilon có lỗ thoát khí"]}]'
);

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(50) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` float NOT NULL,
  `status` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`user_id`) REFERENCES `nguoidung` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `order_items` (
  `order_id` int(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `total_price` float NOT NULL,
  PRIMARY KEY (`order_id`, `product_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  FOREIGN KEY (`product_id`) REFERENCES `sanpham` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` (
  `order_id`, 
  `user_id`, 
  `order_date`, 
  `total_amount`, 
  `status`, 
  `payment_method`, 
  `shipping_address`, 
  `phone_number`
) VALUES 
(1, 'hoag123', '2024-04-01 10:00:00', 500000, 'Hoàn thành', 'COD', '176 Trần Não, Quận 2, Hồ Chí Minh', '0906784527'),
(2, 'hoag123', '2024-04-05 14:30:00', 750000, 'Đang xử lý', 'Banking', '176 Trần Não, Quận 2, Hồ Chí Minh', '0906784527'),
(3, 'hoag123', '2024-04-10 09:15:00', 300000, 'Đã hủy', 'COD', '176 Trần Não, Quận 2, Hồ Chí Minh', '0906784527');

INSERT INTO `order_items` (
  `order_id`, 
  `product_id`, 
  `quantity`, 
  `unit_price`, 
  `total_price`
) VALUES 
(1, 'F001', 2, 25000, 50000),
(1, 'F002', 1, 160000, 160000),
(2, 'F003', 3, 160000, 480000),
(2, 'F004', 2, 45000, 90000),
(3, 'F005', 1, 45000, 45000);

UPDATE `sanpham` 
SET `image_url` = CONCAT('../img/', `product_image`)
WHERE `product_image` IS NOT NULL;

ALTER TABLE `sanpham` 
ADD COLUMN `image_url` varchar(255) AFTER `product_image`;

CREATE TABLE `tomato_tips` (
  `tip_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) DEFAULT '0',
  `comments` int(11) DEFAULT '0',
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tomato_tips` (`title`, `content`, `category`, `image_url`) VALUES
('Mẹo Bảo Quản Cà Chua Tươi Lâu', 'Cà chua là một loại quả phổ biến trong bữa ăn hàng ngày, nhưng việc bảo quản cà chua tươi lâu không phải là điều dễ dàng. Bài viết này sẽ chia sẻ những mẹo hữu ích giúp bạn bảo quản cà chua được tươi ngon trong thời gian dài.', 'intro', '../img/Ca-chua.jpg'),
('Cách chọn cà chua để bảo quản', 'Chọn quả còn cuống xanh, vỏ căng bóng không nhăn, không có vết nứt hoặc đốm, màu sắc đều không có vết thâm. Tách riêng quả chín và chưa chín, loại bỏ quả bị dập hư, giữ cuống để tránh vi khuẩn, không rửa nước trước khi bảo quản.', 'selection', NULL),
('Điều kiện bảo quản', 'Nhiệt độ lý tưởng: 20-25°C, tránh ánh nắng trực tiếp, đặt nơi thoáng mát, không để gần nguồn nhiệt. Độ ẩm thích hợp: 85-90%, tránh nơi quá ẩm ướt, không để trong túi kín, thông thoáng để tránh nấm mốc.', 'storage', NULL),
('Các phương pháp bảo quản', 'Đặt cuống lên trên, xếp một lớp không chồng lên nhau, dùng rổ hoặc khay có lỗ thoát khí, kiểm tra và loại bỏ quả hư thường xuyên. Chỉ bảo quản lạnh khi quả đã chín, nhiệt độ tủ lạnh: 5-7°C, để trong ngăn rau củ, không để quá lâu trong tủ lạnh.', 'methods', NULL),
('Những điều cần tránh', 'Không rửa nước trước khi bảo quản, không để gần các loại quả khác, không bảo quản trong túi nilon kín, không đặt dưới ánh nắng trực tiếp. Nên kiểm tra thường xuyên, phân loại theo độ chín, giữ cuống khi bảo quản, đặt nơi thoáng mát.', 'avoid', NULL),
('Thời gian bảo quản', 'Nhiệt độ phòng: Cà chua chưa chín: 5-7 ngày, Cà chua chín: 2-3 ngày, Cà chua cắt: 1-2 ngày. Trong tủ lạnh: Cà chua chín: 7-10 ngày, Cà chua cắt: 3-4 ngày, Cà chua nấu chín: 5-7 ngày.', 'duration', NULL);

CREATE TABLE product_details (
    product_id VARCHAR(10) PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    nutrition_info JSON,
    benefits JSON,
    storage_tips JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    views INT DEFAULT 0,
    comments INT DEFAULT 0
);

INSERT INTO product_details (product_id, category, title, description, image_url, nutrition_info, benefits, storage_tips) 
VALUES (
    'F009',
    'Trái cây giải nhiệt',
    'Dưa Hấu - Thần Dược Giải Nhiệt Mùa Hè',
    'Dưa hấu không chỉ là loại trái cây giải khát yêu thích mùa hè mà còn là nguồn cung cấp dưỡng chất tuyệt vời cho sức khỏe. Hãy cùng khám phá những giá trị dinh dưỡng và cách chọn dưa hấu ngon, bổ dưỡng cho cả gia đình.',
    '../img/trai-dua-hau.webp',
    '{
        "water": "92%",
        "calories": "30",
        "vitamin_c": "25%",
        "fiber": "0.4g",
        "sugar": "6g",
        "protein": "0.6g"
    }',
    '{
        "hydration": "Giải nhiệt cơ thể",
        "heart_health": "Tốt cho tim mạch",
        "exercise": "Hỗ trợ vận động",
        "digestion": "Hỗ trợ tiêu hóa",
        "skin": "Tốt cho da"
    }',
    '{
        "selection": [
            "Vỏ xanh đậm, bóng đều",
            "Đốm vàng càng đậm càng ngon",
            "Gõ phát ra tiếng \"bồm bộp\"",
            "Cầm nặng tay so với kích thước"
        ],
        "storage": [
            "Nhiệt độ phòng: 3-5 ngày",
            "Tủ lạnh: 2-3 tuần",
            "Đã cắt: 3-5 ngày trong tủ lạnh"
        ],
        "usage": [
            "Ăn trực tiếp",
            "Làm nước ép",
            "Thêm vào salad"
        ]
    }'
);

-- Add payment methods table
CREATE TABLE IF NOT EXISTS payment_methods (
    method_id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default payment methods
INSERT INTO payment_methods (method_name, description) VALUES
('Tiền mặt', 'Thanh toán khi nhận hàng'),
('Chuyển khoản', 'Chuyển khoản ngân hàng'),
('Ví điện tử', 'Thanh toán qua ví điện tử'),
('Thẻ tín dụng', 'Thanh toán bằng thẻ tín dụng');

-- Add payment status to orders table
ALTER TABLE orders
ADD COLUMN payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
ADD COLUMN payment_method_id INT,
ADD COLUMN payment_date TIMESTAMP NULL,
ADD COLUMN transaction_id VARCHAR(100),
ADD FOREIGN KEY (payment_method_id) REFERENCES payment_methods(method_id);

-- Add payment history table
CREATE TABLE IF NOT EXISTS payment_history (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method_id INT NOT NULL,
    transaction_id VARCHAR(100),
    status ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(method_id)
);

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nutrition_info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `benefits` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `storage_tips` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `views` int(11) DEFAULT 0,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `description`, `price`, `stock_quantity`, `image_url`, `nutrition_info`, `benefits`, `storage_tips`) VALUES
('F002', 'Khoai tây', 'Rau củ', 'Khoai tây tươi ngon, giàu dinh dưỡng', 30000, 100, '../img/potatoheader.png', '{"Calories":"77 kcal","Protein":"2 g","Carbohydrates":"17 g","Fiber":"2.2 g","Vitamin C":"19.7 mg","Potassium":"421 mg"}', '["Tốt cho tim mạch","Hỗ trợ tiêu hóa","Cung cấp năng lượng","Tốt cho da"]', '["Bảo quản nơi khô ráo, thoáng mát","Tránh ánh nắng trực tiếp","Không nên rửa trước khi bảo quản","Nhiệt độ lý tưởng: 7-10 độ C"]');
