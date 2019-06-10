CREATE TABLE `logintable` (
  `id` char(7) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `resumeDate` date DEFAULT NULL,
  `isVender` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `logintable`
--

INSERT INTO `studentlogintable` (`id`, `password`, `resumeDate`, `isVender`) VALUES
('1742111', 'murata', NULL, FALSE),
('1742119', 'yamashita', NULL, FALSE),
('1742120', 'yamada', NULL, FALSE),
('0120117', 'shimoda', NULL, TRUE);
