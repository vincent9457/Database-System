-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3306
-- 產生時間： 2025 年 07 月 13 日 00:51
-- 伺服器版本： 10.11.11-MariaDB-0ubuntu0.24.04.2
-- PHP 版本： 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `D1248993`
--

-- --------------------------------------------------------

--
-- 資料表結構 `Admin`
--

CREATE TABLE `Admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Admin`
--

INSERT INTO `Admin` (`admin_id`, `username`, `password`, `teacher_id`) VALUES
(2, 'T3790', '$2y$10$Xk57IedAAhgUq6kA8NQ5ROUmcgBaxf9fOT1M0jiEy4oNCaOv9sfB.', 2),
(5, 'T2515', '$2y$10$f/NlrYBUguvJhEus.SOEEO7cCSYX4V5kJkXuFUP4IiaPsY6N65sNK', 61),
(6, 'T3767', '$2y$10$1xyCjKARb0JhkXdcHU1RRuJptJTkF6iW1bhhqv8Y9InKJLNOEgmcq', 7),
(10, '陳錫民', '$2y$10$EXi9pOMSnThl.9LUFJn8KesP1bhfHqhx/AtCrj3OYZ.g9bgmAMFnG', 26),
(11, 'T3897', '$2y$10$ipfREDRWbsRRxcULK.xzIuWQmYhVpeevJjyr4ROl8gEv9NHEw6H7G', 5),
(13, 'Admin', '$2y$10$UzjHT7hAfuzlwi8WMFlLDOeusD4vANfcE.Fw1FHQzy/03qi.McgKm', 69),
(14, 'handsome_chao', '$2y$10$b7jrI82RvmBoeAUsG50/VO3sVbgcGc5kpFkXi7iDDM5n5JBZarNYe', 11);

-- --------------------------------------------------------

--
-- 資料表結構 `BookPaper`
--

CREATE TABLE `BookPaper` (
  `paper_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pages` varchar(50) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `BookPaper`
--

INSERT INTO `BookPaper` (`paper_id`, `name`, `pages`, `publish_date`, `publisher`) VALUES
(6, '', '154', '2024-11-01', ''),
(20, 'Recent Developments on Multimedia Security Technologies', '', '2008-10-01', ''),
(25, 'Secure Mechanisms for Electronic Commerce', '', '2006-12-01', ''),
(33, '123', '7', '2025-06-09', '87987');

-- --------------------------------------------------------

--
-- 資料表結構 `BookPaperAuthor`
--

CREATE TABLE `BookPaperAuthor` (
  `paper_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `BookPaperAuthor`
--

INSERT INTO `BookPaperAuthor` (`paper_id`, `author`) VALUES
(6, 'Chang C. C.*'),
(6, 'Cheng T. F.'),
(6, 'Yang B. C.'),
(20, 'Chang C.C.'),
(20, 'Lee J.S.'),
(25, 'Chang C.C.'),
(25, 'Lee J.S.'),
(25, 'Lee W.B'),
(33, '桑慧敏'),
(33, '芷琳');

-- --------------------------------------------------------

--
-- 資料表結構 `ConferencePaper`
--

CREATE TABLE `ConferencePaper` (
  `paper_id` int(11) NOT NULL,
  `conf_date` date DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `conference_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ConferencePaper`
--

INSERT INTO `ConferencePaper` (`paper_id`, `conf_date`, `school`, `conference_name`) VALUES
(1, '1986-06-02', 'Proceedings of 1986 IEEE International Symposium on Information Theory', ''),
(21, '2024-08-01', '國立臺北科技大學', '第三十四屆全國資訊安全會議'),
(22, '2020-09-01', '中山大學', '第三十屆全國資訊安全會議');

-- --------------------------------------------------------

--
-- 資料表結構 `ConferencePaperAuthor`
--

CREATE TABLE `ConferencePaperAuthor` (
  `paper_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ConferencePaperAuthor`
--

INSERT INTO `ConferencePaperAuthor` (`paper_id`, `author`) VALUES
(1, 'C. C. and Lin'),
(1, 'C. H.'),
(1, 'Chang'),
(21, '李榮三'),
(21, '沈彥均'),
(21, '范勻怡'),
(22, '吳威震'),
(22, '吳承翰'),
(22, '李榮三'),
(22, '洪緯哲'),
(22, '蔡國裕');

-- --------------------------------------------------------

--
-- 資料表結構 `Education`
--

CREATE TABLE `Education` (
  `teacher_id` int(11) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `school` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Education`
--

INSERT INTO `Education` (`teacher_id`, `degree`, `school`, `department`) VALUES
(2, '博士', '國立交通大學', '計算機工程學系'),
(2, '學士', '國立清華大學', '應用數學系'),
(2, '碩士', '國立清華大學', '計算機管理決策研究所'),
(5, '博士', '美國普渡大學', '工業工程學系'),
(6, '學士', '國立交通大學', '資訊工程'),
(6, '碩士', '國立交通大學', '資訊工程'),
(6, '碩士', '美國匹茲堡大學', '電腦科學'),
(7, '博士', '台灣大學', '資訊工程學系'),
(7, '碩士', '中正大學', '資訊工程學系'),
(8, '博士', '美國密西根州立大學', '電機工程學系'),
(8, '學士', '國立交通大學', '控制工程'),
(8, '碩士', '美國密西根州立大學', '電機工程學系'),
(9, '博士', '國立中正大學', '電機工程研究所'),
(9, '學士', '國立台灣工業技術學院', '電子工程技術系'),
(9, '碩士', '國立中正大學', '電機工程研究所'),
(10, '博士', '國立中正大學', '資訊工程研究所'),
(10, '學士', '私立中原大學', '資訊工程學系'),
(10, '碩士', '國立中正大學', '資訊工程研究所'),
(11, '博士', '國防大學', '國防科學研究所電子組'),
(11, '學士', '中正理工學院', '資訊科學系'),
(11, '碩士', '國防大學', '電子工程研究所'),
(12, '博士', '國立中正大學', '資訊工程研究所'),
(12, '學士', '東海大學', '資訊工程學系'),
(12, '碩士', '國立中正大學', '資訊工程研究所'),
(13, '博士', '國立成功大學', '電機工程研究所'),
(13, '學士', '國立成功大學', '工程科學系'),
(13, '碩士', '國立成功大學', '電機工程研究所'),
(14, '博士', '暨南國際大學', '資訊工程學系'),
(15, '博士', '國立交通大學', '資訊工程學系'),
(15, '學士', '國立交通大學', '計算機工程系'),
(15, '碩士', '國立交通大學', '資訊工程研究所'),
(16, '博士', '早稻田大學', '情報生產管理學研究院'),
(16, '學士', '國立高雄師範大學', '數學系'),
(16, '碩士', '國立政治大學', '應用數學系'),
(17, '博士', '逢甲大學', '資訊工程學系'),
(19, '博士', '逢甲大學', '資訊工程學系'),
(19, '學士', '逢甲大學', '資訊工程學系'),
(19, '碩士', '逢甲大學', '資訊工程學系'),
(20, '博士', '台灣大學', '電機工程學系'),
(20, '學士', '台灣大學', '電機工程學系'),
(20, '碩士', '台灣大學', '電機工程學系'),
(21, '博士', '逢甲大學', '資訊工程學系'),
(21, '學士', '逢甲大學', '資訊工程學系'),
(21, '碩士', '逢甲大學', '資訊工程學系'),
(22, '博士', '國立中興大學', '電機工程所'),
(22, '碩士', '國立中興大學', '電機工程所'),
(23, '博士', '交通大學', '資訊工程學系'),
(23, '學士', '逢甲大學', '資訊工程學系'),
(23, '碩士', '清華大學', '資訊科學學系'),
(24, '博士', '美國俄亥俄州立大學', '電機工程學系'),
(24, '學士', '國立成功大學', '電機工程學系'),
(24, '碩士', '美國俄亥俄州立大學', '電機工程學系'),
(25, '博士', '美國西北大學', '電機所'),
(26, '博士', '中央大學', '資訊工程學系'),
(26, '碩士', '中央大學', '資訊工程學系'),
(27, '博士', '國立交通大學', '資訊科學與工程研究所'),
(27, '學士', '天主教輔仁大學', '資訊工程學系'),
(27, '碩士', '國立中央大學', '資訊工程研究所'),
(28, '博士', '國立交通大學', '資訊工程研究所'),
(28, '學士', '國立交通大學', '計算機工程系'),
(29, '博士', '國立交通大學', '資訊科學與工程學系'),
(29, '學士', '國立交通大學', '資訊工程學系'),
(29, '碩士', '國立交通大學', '資訊工程研究所'),
(30, '博士', '國立交通大學', '應用數學所'),
(30, '學士', '國立交通大學', '應用數學系'),
(30, '碩士', '國立交通大學', '應用數學所'),
(31, '博士', '逢甲大學', '電機與通訊工程'),
(31, '學士', '國立勤益技術學院', '電子工程系'),
(31, '碩士', '逢甲大學', '通訊工程學系'),
(32, '博士', '交通大學', '生命科學系'),
(32, '學士', '東吳大學', '微生物學系'),
(32, '碩士', '清華大學', '生命科學系'),
(33, '博士', '國立中興大學', '資訊科學與工程研究所'),
(34, '博士', '成功大學', '工程科學系'),
(34, '學士', '逢甲大學', '資訊工程系'),
(34, '碩士', '臺南大學', '資訊教育所'),
(35, '博士', '國立清華大學', '資訊工程研究所'),
(35, '學士', '國立清華大學', '數學系應用數學組'),
(36, '博士', '國立清華大學', '資訊系統與應用學系'),
(36, '學士', '實踐大學', '應用外文系'),
(36, '碩士', '國立交通大學', '語言與文化系'),
(37, '博士', '國立臺灣科技大學', '資訊管理系'),
(37, '學士', '中原大學', '資訊工程學系'),
(37, '碩士', '國立臺灣科技大學', '資訊管理系'),
(38, '博士', '國立交通大學', '資訊科學與工程研究所'),
(38, '學士', '國立交通大學', '資訊工程學系'),
(38, '碩士', '國立交通大學', '多媒體工程研究所'),
(39, '博士', '國立中央大學', '資訊工程研究所'),
(40, '博士', '美國伊利諾理工學院', '計算機科學系'),
(40, '學士', '國立成功大學', '電機工程系'),
(40, '碩士', '美國華盛頓州立大學', '計算機科學系'),
(41, '博士', '美國伊利諾大學芝加哥分校', '電機電腦'),
(41, '學士', '國立交通大學', '控制工程系'),
(41, '碩士', '國立交通大學', '計算機工程'),
(42, '博士', '國立成功大學', '電機所計算機組'),
(42, '學士', '逢甲大學', '資訊工程學系'),
(42, '碩士', '國立成功大學', '資訊工程學系'),
(43, '博士', '國立成功大學', '電腦與通訊工程研究所'),
(43, '學士', '國立台灣科技大學', '電機工程學系'),
(43, '碩士', '國立成功大學', '電腦與通訊工程研究所'),
(44, '學士', '逢甲大學', '資訊工程學系'),
(44, '碩士', '逢甲大學', '資訊工程學系'),
(45, '博士', '逢甲大學', '資訊工程學系'),
(45, '學士', '逢甲大學', '資訊工程學系'),
(45, '碩士', '逢甲大學', '資訊工程學系'),
(47, '博士', '逢甲大學', '資訊工程學系'),
(47, '學士', '國立成功大學', '工程科學系'),
(47, '碩士', '國立成功大學', '資訊工程研究所'),
(48, '博士', '逢甲大學', '電機與通訊工程博士學位學程'),
(48, '學士', '逢甲大學', '電機工程學系'),
(48, '碩士', '逢甲大學', '通訊工程學系'),
(49, '碩士', '逢甲大學', '資訊工程學系'),
(50, '學士', '逢甲大學', '資訊工程學系'),
(50, '碩士', '逢甲大學', '資訊工程學系'),
(52, '博士', '淡江大學', '電機工程學系'),
(52, '碩士', '淡江大學', '電機工程學系'),
(53, '博士', '國立中興大學', '科技管理研究所'),
(53, '學士', '朝陽科技大學', '資訊管理學系'),
(53, '碩士', '國立中正大學', '會計與資訊科技研究所'),
(54, '學士', '逢甲大學', '資訊工程學系'),
(54, '碩士', '逢甲大學', '資訊工程學系'),
(59, '博士', '美國俄亥俄州立大學', '資訊科學系'),
(59, '學士', '國立台灣大學', '資訊工程學系'),
(59, '碩士', '國立清華大學', '資訊科學系'),
(61, '博士', '中正', '資工系'),
(65, '學士', '逢甲大學', '資工系'),
(66, '學士', '逢甲大學', '資工系'),
(67, '學士', '逢甲大學', '資工系');

-- --------------------------------------------------------

--
-- 資料表結構 `Experience`
--

CREATE TABLE `Experience` (
  `category` enum('校內','校外') DEFAULT NULL,
  `organization` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `school` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Experience`
--

INSERT INTO `Experience` (`category`, `organization`, `teacher_id`, `role`, `school`) VALUES
('校外', '亞洲研究院學術委員會', 2, '聯席主席', '美國國家人工智慧科學院'),
('校外', '學術審議委員會', 2, '委員', '教育部'),
('校外', '工業局技術審查委員會', 2, '委員', '經濟部'),
('校外', '工程處', 2, '諮議委員及評議委員', '國科會'),
('校外', '應用數學研究所', 2, '教授', '國立中興大學'),
('校外', '應用數學系', 2, '講師', '國立中興大學'),
('校外', '研考會', 2, '諮詢委員', '行政院'),
('校外', '美商惠普電腦公司', 2, '系統工程師', ''),
('校外', '考選部', 2, '典試委員', '考試院'),
('校外', '自動化研究中心', 2, '主任', '國立中正大學'),
('校內', '董事會', 2, '何宜武先生學術講座', '逢甲大學'),
('校外', '計算機工程學系', 2, '講師', '國立交通大學'),
('校外', '計算機工程研究所', 2, '副教授', '國立交通大學'),
('校外', '財團法人資訊工業策進會', 2, '系統諮詢工程師', ''),
('校外', '資工系', 2, '榮譽教授', '國立東華大學'),
('校外', '資工系', 2, '榮譽講座教授', '國立東華大學'),
('校外', '資訊工程學系', 2, '合聘教授', '國立東華大學'),
('校內', '資訊工程學系', 2, '教授', '逢甲大學'),
('校外', '資訊工程學系', 2, '講座教授', '亞洲大學'),
('校外', '資訊系', 2, '榮譽特聘講座教授', '朝陽科技大學'),
('校外', '電信總局電信技術諮詢委員會', 2, '委員', '交通部'),
('校外', '電子計算機科學系', 2, '講師', '淡江文理學院'),
('校外', '電算中心', 2, '代主任', '國立中正大學'),
('校外', '顧問室', 2, '主任', '教育部'),
('校內', '校務企劃組', 7, '組長', '逢甲大學'),
('校內', '系統維運組', 7, '組長', '逢甲大學'),
('校內', '資源管理中心', 7, '主任', '逢甲大學'),
('校內', '資訊工程學系', 7, '特聘教授', '逢甲大學'),
('校內', '資通安全研究中心', 7, '主任', '逢甲大學'),
('校內', '逢甲大學帆宣智慧城市5G實驗室', 7, '研究員', '逢甲大學');

-- --------------------------------------------------------

--
-- 資料表結構 `ExternalAward`
--

CREATE TABLE `ExternalAward` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `organizer` varchar(100) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `award_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ExternalAward`
--

INSERT INTO `ExternalAward` (`teacher_id`, `name`, `date`, `organizer`, `result`, `award_date`) VALUES
(2, '論文徵文比賽', '2013-05-09', '鈦思科技', '佳作', NULL),
(7, 'GiCS第3屆尋找資安女婕思競賽', '2023-05-06', '國科會與教育部', '佳作', NULL),
(7, 'GiCS第4屆尋找資安女婕思競賽', '2024-04-27', '國科會與教育部', '優勝', NULL),
(7, '第52屆全國技能競賽網路安全類', '2022-08-07', '勞動部', '第二名', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `ExternalAwardStudent`
--

CREATE TABLE `ExternalAwardStudent` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `student` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ExternalAwardStudent`
--

INSERT INTO `ExternalAwardStudent` (`teacher_id`, `name`, `date`, `student`) VALUES
(7, 'GiCS第3屆尋找資安女婕思競賽', '2023-05-06', '資訊三丁 胡庭語'),
(7, 'GiCS第3屆尋找資安女婕思競賽', '2023-05-06', '資訊三甲 鄭筑云'),
(7, 'GiCS第3屆尋找資安女婕思競賽', '2023-05-06', '資訊三甲 陳彥勻'),
(7, 'GiCS第4屆尋找資安女婕思競賽', '2024-04-27', '彰化師大 廖怡晴'),
(7, 'GiCS第4屆尋找資安女婕思競賽', '2024-04-27', '資訊四丁 胡庭語'),
(7, 'GiCS第4屆尋找資安女婕思競賽', '2024-04-27', '資訊四甲 鄭筑云'),
(7, '第52屆全國技能競賽網路安全類', '2022-08-07', '宋振宇'),
(7, '第52屆全國技能競賽網路安全類', '2022-08-07', '蔡仲林');

-- --------------------------------------------------------

--
-- 資料表結構 `IndustryProject`
--

CREATE TABLE `IndustryProject` (
  `project_id` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `IndustryProject`
--

INSERT INTO `IndustryProject` (`project_id`, `role`, `start_date`, `end_date`) VALUES
(10, '主持人', '2025-01-01', '2025-12-01'),
(11, '主持人', '2025-01-01', '2025-07-01');

-- --------------------------------------------------------

--
-- 資料表結構 `InternalAward`
--

CREATE TABLE `InternalAward` (
  `teacher_id` int(11) NOT NULL,
  `award_date` date NOT NULL,
  `name` varchar(100) NOT NULL,
  `award` varchar(100) NOT NULL,
  `organizer` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `InternalAward`
--

INSERT INTO `InternalAward` (`teacher_id`, `award_date`, `name`, `award`, `organizer`, `date`) VALUES
(7, '2024-11-15', '逢甲大學論文著作獎勵傑出獎', 'Behavioral Analysis Zero-Trust Architecture Relying on Adaptive Multifactor and Threat Determination', '逢甲大學', NULL),
(7, '2024-11-15', '逢甲大學論文著作獎勵傑出獎', 'Preserving friendly stacking and weighted shadows in selective scalable secret image sharing', '逢甲大學', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `JournalPaper`
--

CREATE TABLE `JournalPaper` (
  `paper_id` int(11) NOT NULL,
  `publish_date` date DEFAULT NULL,
  `pages` varchar(50) DEFAULT NULL,
  `volume` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `JournalPaper`
--

INSERT INTO `JournalPaper` (`paper_id`, `publish_date`, `pages`, `volume`) VALUES
(8, '2024-10-01', '73-90', '35');

-- --------------------------------------------------------

--
-- 資料表結構 `JournalPaperAuthor`
--

CREATE TABLE `JournalPaperAuthor` (
  `paper_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `JournalPaperAuthor`
--

INSERT INTO `JournalPaperAuthor` (`paper_id`, `author`) VALUES
(8, 'Chang C. C.'),
(8, 'Chen Y.'),
(8, 'Duan H.'),
(8, 'Liu Y.'),
(8, 'Wang D.');

-- --------------------------------------------------------

--
-- 資料表結構 `NSTCProject`
--

CREATE TABLE `NSTCProject` (
  `project_id` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `nstc_code` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `NSTCProject`
--

INSERT INTO `NSTCProject` (`project_id`, `role`, `nstc_code`, `start_date`, `end_date`) VALUES
(9, 'Ruby', '11', '2025-06-01', '2025-06-07'),
(12, '主持人', 'NSTC111-2221-E-035-053-', '2022-08-01', '2023-07-01'),
(13, '主持人', 'NSC100-2221-E-035-067- ', '2011-08-01', '2012-07-01');

-- --------------------------------------------------------

--
-- 資料表結構 `Paper`
--

CREATE TABLE `Paper` (
  `paper_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` enum('專書論文','會議論文','專書和技術報告','期刊論文') DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Paper`
--

INSERT INTO `Paper` (`paper_id`, `title`, `category`, `teacher_id`) VALUES
(1, 'On the Difficulty of Construction Perfect Hashing Functions ', '會議論文', 2),
(6, 'Perfectly Reversible Information Hiding in Data Compression Codes Using Locally Adaptive Coding', '專書論文', 2),
(8, 'SERDA: Secure Enhanced and Robust Data Aggregation Scheme for Smart Grid', '期刊論文', 2),
(20, '資通安全專論彙編之一，國家實驗研究院科技政策研究與資訊中心', '專書論文', 7),
(21, '模擬真實攻防演練以驗證臺灣高等教育場域之資安防護能力', '會議論文', 7),
(22, '基於區塊鏈與智能合約實現具隱密性之雙重隨意組合拍賣平台', '會議論文', 7),
(23, '資安鑑識分析 : 數位工具、情資安全、犯罪偵防與證據追蹤', '專書和技術報告', 7),
(24, '電腦、網路與行動服務安全實務', '專書和技術報告', 7),
(25, '資通安全專論彙編之一，國家實驗研究院科技政策研究與資訊中心', '專書論文', 7),
(33, '123', '專書論文', 5);

-- --------------------------------------------------------

--
-- 資料表結構 `Patent`
--

CREATE TABLE `Patent` (
  `teacher_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `number` varchar(100) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Patent`
--

INSERT INTO `Patent` (`teacher_id`, `title`, `type`, `number`, `start_date`, `end_date`) VALUES
(2, '一種高效的基於博弈框架的醫學圖像分割方法', '發明', '1889287', '2025-12-01', '2035-12-01');

-- --------------------------------------------------------

--
-- 資料表結構 `Project`
--

CREATE TABLE `Project` (
  `project_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` enum('國科會計畫','產學合作') DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Project`
--

INSERT INTO `Project` (`project_id`, `name`, `category`, `teacher_id`) VALUES
(9, '暖陽', '國科會計畫', 61),
(10, '資安服務專案', '產學合作', 7),
(11, '網路安全實務與社會人才培訓計畫', '產學合作', 7),
(12, '植基於深度學習之未知網路攻擊暨惡意程式行為偵察技術', '國科會計畫', 7),
(13, '數位典藏暨版權保護技術', '國科會計畫', 7);

-- --------------------------------------------------------

--
-- 資料表結構 `Schedule`
--

CREATE TABLE `Schedule` (
  `teacher_id` int(11) NOT NULL,
  `weekday` varchar(10) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `start_period` int(11) NOT NULL,
  `end_period` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Schedule`
--

INSERT INTO `Schedule` (`teacher_id`, `weekday`, `course_name`, `class_name`, `start_period`, `end_period`) VALUES
(2, '星期四', '數位浮水印技術專題', '資訊博一', 3, 4),
(7, '星期三', '專題研究(一)', '資訊三合', 5, 5),
(7, '星期二', '專題研究(一)', '資訊三合', 5, 5),
(7, '星期六', '網路安全實務與社會', '資訊四合', 2, 4),
(26, '星期一', '專題研究(一)', '資訊三丁, 資訊三丙, 資訊三乙, 資訊三甲', 7, 13);

-- --------------------------------------------------------

--
-- 資料表結構 `Speech`
--

CREATE TABLE `Speech` (
  `teacher_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `topic` varchar(255) NOT NULL,
  `organizer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Speech`
--

INSERT INTO `Speech` (`teacher_id`, `date`, `topic`, `organizer`) VALUES
(2, '2025-04-01', 'IoT-Based Electronic Health Records Protection Using Compressed Images as Carriers', '朝陽科技大學資訊學院'),
(7, '2008-04-01', '資訊安全技術之發展與應用', '逢甲大學資訊工程學系'),
(7, '2008-06-03', '資訊安全技術之發展與應用', '中區三校聯合資安研討會'),
(7, '2009-06-02', '視覺密碼的最新發展', '教育部顧問室資通安全聯盟中心');

-- --------------------------------------------------------

--
-- 資料表結構 `Teacher`
--

CREATE TABLE `Teacher` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Teacher`
--

INSERT INTO `Teacher` (`teacher_id`, `name`, `email`, `extension`, `position`, `photo`) VALUES
(2, '張真誠', 'alan3c@gmail.com', '#3790', '何宜武先生學術講座', 'uploads/682331e109006_張真誠.jpg'),
(5, '桑慧敏', 'wmsong@o365.fcu.edu.tw', '#3897', '講座教授', 'uploads/68412a7dcb0bd_桑慧敏.jpg'),
(6, '竇其仁', 'crdow@fcu.edu.tw', '#3739', '特聘教授', 'uploads/68412b385d8d3_竇其仁.jpg'),
(7, '李榮三', 'leejs@fcu.edu.tw', '#3767', '特聘教授', 'uploads/68412bcddbbb9_李榮三.jpg'),
(8, '王益文', 'ywang@fcu.edu.tw', '#3763', '副教授', 'uploads/68412d8e35105_王益文.jpg'),
(9, '李俊宏', 'cholee@o365.fcu.edu.tw', '#3778', '副教授', 'uploads/68412e3c273c2_李俊宏.png'),
(10, '李維斌', 'wblee@mail.fcu.edu.tw', '#3751', '教授', 'uploads/68412f00cf212_李維斌.jpg'),
(11, '周兆龍', 'clchou@o365.fcu.edu.tw', '#3772', '副教授', 'uploads/68412f695ba3a_周兆龍.jpg'),
(12, '林哲維', 'jhewlin@fcu.edu.tw', '#3758', '助理教授', 'uploads/68412ff695850_林哲維.jpg'),
(13, '林志敏', 'jimmy@fcu.edu.tw', '#3754', '教授', 'uploads/684131170da55_林志敏.jpg'),
(14, '林峰正', 'fclin@fcu.edu.tw', '#3761', '副教授', 'uploads/6841319b18281_林峰正.png'),
(15, '林明言', 'linmy@fcu.edu.tw', '#3747', '教授', 'uploads/6841320c06595_林明言.jpg'),
(16, '林佩君', 'peiclin@fcu.edu.tw', '#3749', '副教授', 'uploads/6841328f3f427_林佩君.jpg'),
(17, '林佩蓉', 'linpj@fcu.edu.tw', '#3745', '副教授', 'uploads/684132ec58120_林佩蓉.jpg'),
(19, '洪振偉', 'zwhong@o365.fcu.edu.tw', '#3743', '副教授', 'uploads/6841343a70895_洪振偉.jpg'),
(20, '洪維志', 'wchong@o365.fcu.edu.tw', '#3733', '副教授', 'uploads/684134ac6cd12_洪維志.jpg'),
(21, '張志宏', 'chihhchang@fcu.edu.tw', '', '副教授', 'uploads/68413526e123f_張志宏.jpg'),
(22, '張哲誠', 'checchang@fcu.edu.tw', '#3764', '副教授', 'uploads/684135c10ecc9_張哲誠.jpg'),
(23, '陳青文', 'chingwen@fcu.edu.tw', '#3729', '教授', 'uploads/6841366e27cc4_陳青文.jpg'),
(24, '陳啟鏘', 'cychen@fcu.edu.tw', '#3738', '教授', 'uploads/684136cfb37e7_陳啟鏘.jpg'),
(25, '陳德生', 'dschen@fcu.edu.tw', '#3746', '副教授', 'uploads/68413720ba86e_陳德生.jpg'),
(26, '陳錫民', 'hsiminc@fcu.edu.tw', '#3700#3741', '教授兼系主任', 'uploads/6841384607c09_陳錫民.jpg'),
(27, '陳烈武', 'lwuchen@fcu.edu.tw', '#3759', '教授', 'uploads/68413964317bc_陳烈武.jpg'),
(28, '許芳榮', 'frhsu@o365.fcu.edu.tw', '#3755', '教授', 'uploads/68413a014dbc0_許芳榮.jpg'),
(29, '許懷中', 'hjhsu@mail.fcu.edu.tw', '#3750', '副教授', 'uploads/6841887d62281_許懷中.jpg'),
(30, '黃秀芬', 'sfhwang@mail.fcu.edu.tw', '#3752', '教授', 'uploads/684189469bfc8_黃秀芬.jpg'),
(31, '郭崇韋', 'cwkuo@fcu.edu.tw', '#3734', '助理教授', 'uploads/684189b468134_郭崇韋.jpg'),
(32, '游景盛', 'yucs@fcu.edu.tw', '#3742', '副教授', 'uploads/68418a220015c_游景盛.jpg'),
(33, '葉春秀', 'chunhyeh@fcu.edu.tw', '#3736', '副教授', 'uploads/68418a6edec03_葉春秀.jpg'),
(34, '劉明機', 'mingcliu@fcu.edu.tw', '#3768', '副教授', 'uploads/68418aea1de87_劉明機.jpg'),
(35, '劉宗杰', 'tjliu@fcu.edu.tw', '#3765', '教授', 'uploads/68418b3c73f84_劉宗杰.jpg'),
(36, '劉怡芬', 'yfliu@fcu.edu.tw', '#3735', '副教授', 'uploads/68418bdfa362a_劉怡芬.jpg'),
(37, '蔡國裕', 'kytsai@o365.fcu.edu.tw', '#3757', '副教授', 'uploads/68418c841c070_蔡國裕.jpg'),
(38, '蔡明翰', 'minghtsai@o365.fcu.edu.tw', '#3737', '副教授', 'uploads/68418d0914433_蔡明翰.jpg'),
(39, '薛念林', 'nlhsueh@fcu.edu.tw', '#3773', '教授', 'uploads/684191f769f0e_薛念林.jpg'),
(40, '楊濬中', 'tcyang@fcu.edu.tw', '#2003', '榮譽特聘講座', 'uploads/684192c69da78_楊濬中.jpg'),
(41, '劉安之', 'acliu@fcu.edu.tw', '#3780', '榮譽特聘講座', 'uploads/68419359a40c7_劉安之.jpg'),
(42, '楊晴雯', 'cwhello7@gmail.com', '', '兼任教授', 'uploads/6841942aca1e7_楊晴雯.png'),
(43, '蔡明峰', 'tsaimf@fcu.edu.tw', '', '兼任教授', 'uploads/684194a4acb18_蔡明峰.png'),
(44, '吳上玄', 'wuss303@gmail.com', '', '兼任副教授', 'uploads/684195164ae89_吳上玄.jpg'),
(45, '魏國瑞', 'kjwei@o365.fcu.edu.tw', '', '兼任助理教授', 'uploads/6841958179c3a_魏國瑞.jpg'),
(46, '夏偉中', 'weichung.shia@gmail.com', '', '兼任助理教授', 'uploads/684195f389a01_夏偉中.jpg'),
(47, '曾昭文', 'cwtseng.t10@o365.fcu.edu.tw', '', '兼任助理教授', 'uploads/6841966547233_曾昭文.bmp'),
(48, '吳育倫', 'yulun@nehs.tc.edu.tw', '', '兼任助理教授', 'uploads/684196e1d2c7c_吳育倫.jpg'),
(49, '張舜賢', 'sschang@o365.fcu.edu.tw', '', '兼任助理教授', 'uploads/68419733dabd1_無照片.jpg'),
(50, '陳映親', 'ycchen.blythe@gmail.com', '', '兼任講師', 'uploads/68419779cef11_陳映親.jpg'),
(51, '陳星百', 'hsingbai@gmail.com', '', '兼任助理教授', 'uploads/684197b3732eb_無照片.jpg'),
(52, '何丞堯', 't12185@o365.fcu.edu.tw', '', '兼任助理教授', 'uploads/6841980ec54e2_何丞堯.jpg'),
(53, '沈威政', 'iceman.shen@gmail.com', '', '兼任助理教授', 'uploads/6841986e64ce5_沈威政.jpg'),
(54, '周澤捷', 'cjchew@o365.fcu.edu.tw', '', '兼任助理教授', 'uploads/684198bdb1b45_周澤捷.jpg'),
(55, '陳雅真', 'yjchen@fcu.edu.tw', '#3707', '組員', 'uploads/6841993fc8d4c_陳雅真.jpg'),
(56, '黃鎮南', 'cnhuang@fcu.edu.tw', '#3705', '技佐', 'uploads/684199b28b934_黃鎮南.jpg'),
(57, '粘巧鈴', 'clnien@mail.fcu.edu.tw', '#3706', '書記', 'uploads/684199ed29e92_粘巧鈴.jpg'),
(58, '吳振宇', 'wucy@o365.fcu.edu.tw', '#3704', '書記', 'uploads/68419a1d0b3ad_吳振宇.jpg'),
(59, '曾煜棋', '', '', '特約講座', 'uploads/6841ba58a2c97_曾煜棋.jpg'),
(61, '芷琳', '517@gmail.com', '#2515', '教授(退休)', 'uploads/6842eb239667c_468456353_18002588039686601_8074842812112872616_n.jpg'),
(65, '奮延', '777@gmail.com', '#1234', '教授(退休)', 'uploads/684595c831d12_486671952_18016704098686601_5614225320468497045_n.jpg'),
(66, '思瑋', '888@gmail.com', '#5678', '教授(退休)', 'uploads/6845961fba05e_486721735_18016704095686601_9170867199421472535_n.jpg'),
(67, '心樂', '999@gmail.com', '#9876', '教授(退休)', 'uploads/684596741cb7f_486517550_18016704116686601_4215093689549168336_n.jpg'),
(69, '管理員', '', '', '管理員', 'uploads/684a4ae52d19b_管理員.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `TeacherExpertise`
--

CREATE TABLE `TeacherExpertise` (
  `teacher_id` int(11) NOT NULL,
  `expertise` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `TeacherExpertise`
--

INSERT INTO `TeacherExpertise` (`teacher_id`, `expertise`) VALUES
(2, '信息取證與安全 Information Forensics and Security'),
(2, '圖像與信號處理 Image and Signal Processing'),
(2, '深度學習 Deep Learning'),
(2, '資料庫設計 Database Design'),
(2, '電子商務安全 E-Business Security'),
(2, '電子多媒體影像技術 Electronic Imaging Techniques'),
(2, '電腦密碼學 Computer Cryptography'),
(5, '太陽能與半導體製程品質管制與可靠度'),
(5, '機率統計與模擬理論與應用'),
(5, '系統思維'),
(5, '電力節能之最佳設計'),
(5, '青光眼預測分析'),
(6, '學習科技 Learning Technology'),
(6, '智慧聯網 AIoT'),
(6, '行動計算 Mobile Computing'),
(6, '車載網路 Vehicular Ad Hoc Networks'),
(6, '雲端計算 Cloud Computing'),
(7, '區塊鏈技術與應用 Blockchain technique and its application'),
(7, '密碼學 Cryptography'),
(7, '數位影像處理 Image Processing'),
(7, '無線通訊 Wireless Communications'),
(7, '資訊安全 Information Security'),
(7, '電子商務 E-Commerce'),
(8, 'VLSI系統設計 VLSI Design'),
(8, '嵌入式系統設計 Embedded System Design'),
(8, '類神經網路 Neural Network'),
(9, '人工智慧 Artificial Intelligence'),
(9, '智慧代理人 Intelligent Agent'),
(9, '模糊時間序列 Fuzzy Time Series'),
(9, '軟體工程 Software Engineering'),
(10, '密碼學 Cryptography'),
(10, '數位浮水印 Digital Watermark'),
(10, '網路安全 Network Security'),
(10, '資訊安全管理 Information Security Management'),
(11, '影像處理 Image Processing'),
(11, '模式識別 Pattern Recognition'),
(11, '藏密分析 Steganalysis'),
(11, '資訊安全 Information Security'),
(12, '中文故事分析與生成 Chinese Story Analysis and Generation'),
(12, '人工智慧 Artificial Intelligence'),
(12, '自然語言處理 Nature Language Processing'),
(12, '電腦視覺與人臉識別 Computer Vision and Face Recognition'),
(13, '作業系統 Operating System'),
(13, '嵌入式系統 Embedded System'),
(13, '機器人技術與應用 Robot Technology and Applications'),
(13, '計算機算術 Computer Arithmetic'),
(13, '軟體代理人技術與應用 Software Agent Technology and Applications'),
(13, '軟體整合與重用 Software Integration & Reuse'),
(14, '人工智慧、資料分析 Artificial Intelligence & Data Analysis'),
(14, '影像處理、深度學習 Image Processing & Deep Learning'),
(14, '演算法 Algorithm'),
(14, '雲端運算應用 Cloud Computing Applications'),
(15, '可解釋之人工智慧 Explainable AI'),
(15, '巨量資料分析 Big Data Analytics'),
(15, '推薦系統 Recommendation Systems'),
(15, '資料探勘與資料庫 Data Mining & Database'),
(16, '人工智慧開發與應用 Artificial Intelligence Development and Application'),
(16, '大數據分析 Big Data Analytics'),
(16, '感性工學 Kansei Engineering'),
(16, '模糊統計 Fuzzy Statistics'),
(16, '統計建模 Statistical Modeling'),
(17, 'AI影像辨識 AI Image Recognition'),
(17, '延展實境科技 Extended Reality Technology (AR/VR/MR)'),
(17, '無線網狀網路 Wireless Mesh Networks'),
(17, '腦機介面技術 Brain-Computer Interface/EEG'),
(17, '醫療資訊 Medical Information'),
(19, '物聯網應用開發'),
(19, '行動應用設計'),
(19, '資訊教育'),
(19, '軟體工程(軟體系統開發、設計樣式、軟體架構)'),
(19, '電腦輔助語言學習'),
(20, '密碼分析 Cryptanalysis'),
(20, '無線網路 Wireless Networks'),
(20, '硬體安全 Hardware Security'),
(20, '行動網路 Mobile Networks'),
(20, '資訊安全 Information Security'),
(21, '巨量資料 Big Data'),
(21, '智慧醫療 Smart Healthcare'),
(21, '深度學習 Deep Learing'),
(21, '軟體工程 Software Engineering'),
(21, '雲端服務 Cloud Service'),
(22, '嵌入式系統 Embedded Systems'),
(22, '平行分散式系統 Parallel and Distributed Systems'),
(22, '自動駕駛系統 Autonomous Driving System'),
(23, '嵌入式系統與周邊驅動 Kernel and Driver Programming of Embedded Systems'),
(23, '無線隨意行動與感測網路 Wireless Mobile Ad hoc and Sensor Networks'),
(23, '高效能低功率多核心系統 High Performance and Low Power Multi-core Computer Architecture'),
(24, '單晶片系統設計與應用 SOC Design and Applications'),
(24, '影像與視訊處理 Image and Video Processing'),
(24, '計算機算術與VLSI設計 Computer Arithmetic and VLSI Design'),
(25, 'VLSI 電腦輔助設計 VLSI CAD'),
(25, '嵌入式系統 Embedded System'),
(25, '智慧聯網 Intelligent IOT'),
(26, 'DevOps技術 DevOps Technology'),
(26, '分散式運算 Distributed Computing'),
(26, '服務導向運算 Service-oriented Computing'),
(26, '軟體工程 Software Engineering'),
(27, '機器學習與人工智慧 Machine Learning and Artificial Intelligence'),
(27, '無線通訊與行動計算 Wireless Communication and Mobile Computing'),
(27, '車聯網、物聯網與人聯網 Internet of Vehicles Things and People'),
(28, '人工智慧 AI'),
(28, '生物資訊 Bioinformatics'),
(28, '醫學影像 Biomedical Imagimg'),
(28, '雲端運算 Cloud Computing'),
(29, '巨量資料分析及應用 Big Data Analytics and Applications'),
(29, '生心理量測與群眾外包 Psychophysiology and Crowdsourcing'),
(29, '軟體工程 Software Engineering'),
(29, '雲端計算 Cloud Computing'),
(30, '互連結網路 Interconnection Networks'),
(30, '圖學理論 Graph Theory'),
(30, '無線隨意及感測網路 Wireless Ad Hoc and Sensor Networks'),
(30, '計算機演算法 Computer Algorithm'),
(31, '微控制器應用 Microcontroller Applications'),
(31, '惡意流量分析 Malicious Traffic Detection'),
(31, '硬體安全 Hardware Security'),
(31, '積體電路電磁相容 IC-EMC'),
(32, '生物資訊 Bioinformatics'),
(32, '結構生物資訊 Structural Bioinformatics'),
(32, '計算系統生物 Computational Systems Biology'),
(33, '專案管理 Project management'),
(33, '影像處理 Image processing'),
(33, '智能製造 Smart manufacturing'),
(33, '物件導向 Object Oriented'),
(34, '創新學習軟體設計 Innovative Design of Learning Software'),
(34, '情感運算 Affective Computing'),
(34, '教育資料科學 Educational Data Science'),
(34, '認知神經科學 Cognitive Neuroscience'),
(35, '分散式系統 Distributed System'),
(35, '大數據分析 Big Data Analysis'),
(35, '網路安全 Network Security'),
(35, '自我穩定系統 Self-Stabilizing System'),
(36, '機器學習 Machine Learning'),
(36, '機率論 Introduction to Probability'),
(36, '自然口語處理與辨識 Spoken Language Processing and Recognition'),
(36, '計算語言學 Computational Linguistics'),
(36, '語音辨識 Speech Recognition'),
(37, '密碼學 Cryptography'),
(37, '物聯網應用與安全 IoT Application and Security'),
(37, '行動商務與安全 m-commerce Application and Security'),
(38, '擴增實境 Augmented Reality'),
(38, '虛擬實境 Virtual Reality'),
(38, '電腦圖學 Computer Graphic'),
(38, '電腦視覺 Computer Vision'),
(39, '物件設計 Object Design'),
(39, '軟體品質驗證 Software Quality Assurance'),
(39, '軟體工程 Software Engineering'),
(40, '容錯計算 Fault-Tolerant Computing'),
(40, '計算機結構 Computer Architecture'),
(40, '通訊系統 Communication Systems'),
(41, '分散式系統 Distributed System'),
(41, '網路管理 Network Management'),
(41, '資料庫系統 Database System'),
(42, '影像處理 Imege Processing'),
(42, '資料庫設計 Database Design'),
(42, '資訊安全 Information Security'),
(42, '醫療AI Medical Artificial Intelligent'),
(42, '醫療資訊 Medical Informatics'),
(43, '作業系統 Operating System'),
(43, '多媒體訊號處理 Multimedia Signal Processing'),
(43, '嵌入式系統 Embedded System'),
(43, '無線通訊系統 Wireless Communication Systems'),
(43, '車載資通訊系統整合平台 Telematics System Integration Platform'),
(44, 'AIOT 系統整合設計 AIOT system integration design'),
(44, '微處理器系統開發 Microcontroller system development'),
(44, '數位轉型人工智慧 Digital transformation Artificial Intelligence'),
(44, '數位轉型與綠能轉型 Digital transformation and green energy transformation'),
(44, '智慧家庭整合設計 Smart home integrated design'),
(44, '能源管理系統與物聯網節能技術 Energy Management System(EMS) and Internet of Things Energy Saving Technology'),
(45, '密碼學'),
(45, '網路安全'),
(45, '資訊安全管理'),
(45, '電子商務安全'),
(47, '專案管理 Projct Management'),
(47, '無線射頻技術 RadioFrequency IDentification Technology'),
(47, '物件導向方法論 Object-Oriented Methodology'),
(47, '物聯網架構設計 Architecture Design of the Internet of Things'),
(47, '程式語言 Programming Language'),
(47, '軟體工程 Software Engineering'),
(48, '嵌入式系統(Arduino) Embedded System'),
(48, '程式語言(C++、Java、PHP) Computer programming'),
(48, '積體電路電磁相容 Electromagnetic Compatibility of Integrated Circuits'),
(48, '高頻電路設計 High Frequency Circuit Design'),
(49, '中小企業網路建置'),
(49, '中小企業網路管理'),
(49, '伺服器建置'),
(49, '伺服器管理'),
(49, '系統安全'),
(49, '網路安全'),
(49, '計畫專案企劃'),
(49, '資安攻防'),
(50, '視覺密碼'),
(50, '資訊安全'),
(50, '電子商務'),
(52, '估測理論 Estimation Theory'),
(52, '分散式帳本技術 Distributed ledger Technology'),
(52, '感測器融合 Sensor Fusion'),
(52, '機器學習 Machine Learning'),
(52, '機率機器人學 Probabilistic Robotics'),
(53, '企業資源規劃系統 Enterprise Resource Planning(ERP)'),
(53, '企業電子化 Enterprise E-Commerce'),
(53, '智能製造 Intelligent Manufacturing'),
(53, '資訊管理 Information Management'),
(54, '區塊鏈技術與應用 Blockchain technique and its application'),
(54, '密碼學 Cryptography'),
(54, '數位鑑識 Digital Forensic'),
(54, '電子商務 E-Commerce'),
(55, '碩博士班'),
(56, '實驗室管理'),
(56, '招生業務'),
(57, '大學部專題'),
(57, '獎學金申請'),
(57, '產業實習'),
(58, '大學部課務'),
(59, '5G行動科技 5G Mobile Technology'),
(59, '人工智慧服務 AI Service'),
(59, '物聯網 Internet of Things'),
(61, 'UI design'),
(61, '資料庫'),
(65, 'AI'),
(65, '資料庫'),
(66, 'AI'),
(67, 'AI');

-- --------------------------------------------------------

--
-- 資料表結構 `TechReport`
--

CREATE TABLE `TechReport` (
  `paper_id` int(11) NOT NULL,
  `publish_date` date DEFAULT NULL,
  `pages` varchar(50) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publish_place` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `TechReport`
--

INSERT INTO `TechReport` (`paper_id`, `publish_date`, `pages`, `publisher`, `publish_place`) VALUES
(23, '2024-12-01', '288', '博碩文化股份有限公司', '中華民國'),
(24, '2012-09-01', '550', '博碩文化股份有限公司', '中華民國');

-- --------------------------------------------------------

--
-- 資料表結構 `TechReportAuthor`
--

CREATE TABLE `TechReportAuthor` (
  `paper_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `TechReportAuthor`
--

INSERT INTO `TechReportAuthor` (`paper_id`, `author`) VALUES
(23, '周澤捷'),
(23, '李榮三'),
(23, '王旭正'),
(24, '李榮三'),
(24, '楊中皇'),
(24, '王旭正');

-- --------------------------------------------------------

--
-- 資料表結構 `Textbook`
--

CREATE TABLE `Textbook` (
  `textbook_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `Textbook`
--

INSERT INTO `Textbook` (`textbook_id`, `teacher_id`, `name`, `publisher`) VALUES
(6, 7, '資訊生活安全、行動智慧應用與網駭實務', '博碩'),
(7, 7, '資安鑑識分析 : 數位工具、情資安全、犯罪偵防與證據', '博碩'),
(8, 61, '獺獺咪', '666');

-- --------------------------------------------------------

--
-- 資料表結構 `TextbookAuthor`
--

CREATE TABLE `TextbookAuthor` (
  `textbook_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `TextbookAuthor`
--

INSERT INTO `TextbookAuthor` (`textbook_id`, `author`) VALUES
(6, '李榮三'),
(6, '王旭正'),
(6, '魏國瑞'),
(7, '周澤捷'),
(7, '李榮三'),
(7, '王旭正'),
(8, '777');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`);

--
-- 資料表索引 `BookPaper`
--
ALTER TABLE `BookPaper`
  ADD PRIMARY KEY (`paper_id`);

--
-- 資料表索引 `BookPaperAuthor`
--
ALTER TABLE `BookPaperAuthor`
  ADD PRIMARY KEY (`paper_id`,`author`);

--
-- 資料表索引 `ConferencePaper`
--
ALTER TABLE `ConferencePaper`
  ADD PRIMARY KEY (`paper_id`);

--
-- 資料表索引 `ConferencePaperAuthor`
--
ALTER TABLE `ConferencePaperAuthor`
  ADD PRIMARY KEY (`paper_id`,`author`);

--
-- 資料表索引 `Education`
--
ALTER TABLE `Education`
  ADD PRIMARY KEY (`teacher_id`,`degree`,`school`);

--
-- 資料表索引 `Experience`
--
ALTER TABLE `Experience`
  ADD PRIMARY KEY (`teacher_id`,`organization`,`role`);

--
-- 資料表索引 `ExternalAward`
--
ALTER TABLE `ExternalAward`
  ADD PRIMARY KEY (`teacher_id`,`name`,`date`);

--
-- 資料表索引 `ExternalAwardStudent`
--
ALTER TABLE `ExternalAwardStudent`
  ADD PRIMARY KEY (`teacher_id`,`name`,`date`,`student`);

--
-- 資料表索引 `IndustryProject`
--
ALTER TABLE `IndustryProject`
  ADD PRIMARY KEY (`project_id`);

--
-- 資料表索引 `InternalAward`
--
ALTER TABLE `InternalAward`
  ADD PRIMARY KEY (`teacher_id`,`name`,`award_date`,`award`);

--
-- 資料表索引 `JournalPaper`
--
ALTER TABLE `JournalPaper`
  ADD PRIMARY KEY (`paper_id`);

--
-- 資料表索引 `JournalPaperAuthor`
--
ALTER TABLE `JournalPaperAuthor`
  ADD PRIMARY KEY (`paper_id`,`author`);

--
-- 資料表索引 `NSTCProject`
--
ALTER TABLE `NSTCProject`
  ADD PRIMARY KEY (`project_id`);

--
-- 資料表索引 `Paper`
--
ALTER TABLE `Paper`
  ADD PRIMARY KEY (`paper_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- 資料表索引 `Patent`
--
ALTER TABLE `Patent`
  ADD PRIMARY KEY (`teacher_id`,`number`);

--
-- 資料表索引 `Project`
--
ALTER TABLE `Project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- 資料表索引 `Schedule`
--
ALTER TABLE `Schedule`
  ADD PRIMARY KEY (`teacher_id`,`weekday`,`start_period`);

--
-- 資料表索引 `Speech`
--
ALTER TABLE `Speech`
  ADD PRIMARY KEY (`teacher_id`,`date`,`topic`);

--
-- 資料表索引 `Teacher`
--
ALTER TABLE `Teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- 資料表索引 `TeacherExpertise`
--
ALTER TABLE `TeacherExpertise`
  ADD PRIMARY KEY (`teacher_id`,`expertise`);

--
-- 資料表索引 `TechReport`
--
ALTER TABLE `TechReport`
  ADD PRIMARY KEY (`paper_id`);

--
-- 資料表索引 `TechReportAuthor`
--
ALTER TABLE `TechReportAuthor`
  ADD PRIMARY KEY (`paper_id`,`author`);

--
-- 資料表索引 `Textbook`
--
ALTER TABLE `Textbook`
  ADD PRIMARY KEY (`textbook_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- 資料表索引 `TextbookAuthor`
--
ALTER TABLE `TextbookAuthor`
  ADD PRIMARY KEY (`textbook_id`,`author`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `Admin`
--
ALTER TABLE `Admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `Paper`
--
ALTER TABLE `Paper`
  MODIFY `paper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `Project`
--
ALTER TABLE `Project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `Teacher`
--
ALTER TABLE `Teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `Textbook`
--
ALTER TABLE `Textbook`
  MODIFY `textbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `Admin`
--
ALTER TABLE `Admin`
  ADD CONSTRAINT `Admin_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `BookPaper`
--
ALTER TABLE `BookPaper`
  ADD CONSTRAINT `BookPaper_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `Paper` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `BookPaperAuthor`
--
ALTER TABLE `BookPaperAuthor`
  ADD CONSTRAINT `BookPaperAuthor_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `BookPaper` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `ConferencePaper`
--
ALTER TABLE `ConferencePaper`
  ADD CONSTRAINT `ConferencePaper_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `Paper` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `ConferencePaperAuthor`
--
ALTER TABLE `ConferencePaperAuthor`
  ADD CONSTRAINT `ConferencePaperAuthor_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `ConferencePaper` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Education`
--
ALTER TABLE `Education`
  ADD CONSTRAINT `Education_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Experience`
--
ALTER TABLE `Experience`
  ADD CONSTRAINT `Experience_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `ExternalAward`
--
ALTER TABLE `ExternalAward`
  ADD CONSTRAINT `ExternalAward_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `ExternalAwardStudent`
--
ALTER TABLE `ExternalAwardStudent`
  ADD CONSTRAINT `ExternalAwardStudent_ibfk_1` FOREIGN KEY (`teacher_id`,`name`,`date`) REFERENCES `ExternalAward` (`teacher_id`, `name`, `date`) ON DELETE CASCADE;

--
-- 資料表的限制式 `IndustryProject`
--
ALTER TABLE `IndustryProject`
  ADD CONSTRAINT `IndustryProject_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `Project` (`project_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `InternalAward`
--
ALTER TABLE `InternalAward`
  ADD CONSTRAINT `InternalAward_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `JournalPaper`
--
ALTER TABLE `JournalPaper`
  ADD CONSTRAINT `JournalPaper_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `Paper` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `JournalPaperAuthor`
--
ALTER TABLE `JournalPaperAuthor`
  ADD CONSTRAINT `JournalPaperAuthor_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `JournalPaper` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `NSTCProject`
--
ALTER TABLE `NSTCProject`
  ADD CONSTRAINT `NSTCProject_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `Project` (`project_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Paper`
--
ALTER TABLE `Paper`
  ADD CONSTRAINT `Paper_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Patent`
--
ALTER TABLE `Patent`
  ADD CONSTRAINT `Patent_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Project`
--
ALTER TABLE `Project`
  ADD CONSTRAINT `Project_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Schedule`
--
ALTER TABLE `Schedule`
  ADD CONSTRAINT `Schedule_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Speech`
--
ALTER TABLE `Speech`
  ADD CONSTRAINT `Speech_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `TeacherExpertise`
--
ALTER TABLE `TeacherExpertise`
  ADD CONSTRAINT `TeacherExpertise_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `TechReport`
--
ALTER TABLE `TechReport`
  ADD CONSTRAINT `TechReport_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `Paper` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `TechReportAuthor`
--
ALTER TABLE `TechReportAuthor`
  ADD CONSTRAINT `TechReportAuthor_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `TechReport` (`paper_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `Textbook`
--
ALTER TABLE `Textbook`
  ADD CONSTRAINT `Textbook_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `TextbookAuthor`
--
ALTER TABLE `TextbookAuthor`
  ADD CONSTRAINT `TextbookAuthor_ibfk_1` FOREIGN KEY (`textbook_id`) REFERENCES `Textbook` (`textbook_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
