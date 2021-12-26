-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:8889
-- 生成日期： 2021-12-03 17:10:37
-- 服务器版本： 5.7.34
-- PHP 版本： 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `quizdb`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetBelowForty` ()  BEGIN
       SELECT user_id, quiz_id, score FROM Test WHERE score_percent < 40;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `DeletedQuiz`
--

CREATE TABLE `DeletedQuiz` (
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `DeletedQuiz`
--

INSERT INTO `DeletedQuiz` (`quiz_id`, `user_id`, `deleted_date`) VALUES
(31, 'a', '2021-12-04 00:15:09'),
(32, 'a', '2021-12-04 00:15:09'),
(33, 'e', '2021-12-04 00:29:04');

-- --------------------------------------------------------

--
-- 表的结构 `Options`
--

CREATE TABLE `Options` (
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `option_id` int(10) UNSIGNED NOT NULL,
  `option_context` varchar(200) NOT NULL,
  `option_mark` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Options`
--

INSERT INTO `Options` (`quiz_id`, `question_id`, `option_id`, `option_context`, `option_mark`) VALUES
(16, 1, 1, 'Java', 0),
(16, 1, 2, 'PHP', 10),
(16, 1, 3, 'JavaScript', 10),
(16, 2, 1, 'Yes!', 100),
(16, 2, 2, 'No...', 0),
(16, 3, 1, 'Of course!', 100),
(16, 3, 2, 'Not really...', 0);

-- --------------------------------------------------------

--
-- 表的结构 `Questions`
--

CREATE TABLE `Questions` (
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `question_context` varchar(200) NOT NULL,
  `solution` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Questions`
--

INSERT INTO `Questions` (`quiz_id`, `question_id`, `question_context`, `solution`) VALUES
(16, 1, 'Which one is the best programming language?', 2),
(16, 2, 'Are you going well?', 2),
(16, 3, 'Is everything fine?', 2);

-- --------------------------------------------------------

--
-- 表的结构 `Quiz`
--

CREATE TABLE `Quiz` (
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `quiz_name` varchar(200) NOT NULL,
  `quiz_author` varchar(50) NOT NULL,
  `author_id` varchar(50) NOT NULL,
  `quiz_available` tinyint(1) NOT NULL,
  `quiz_duration` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Quiz`
--

INSERT INTO `Quiz` (`quiz_id`, `quiz_name`, `quiz_author`, `author_id`, `quiz_available`, `quiz_duration`) VALUES
(16, 'Advanced Quiz', 'axton', 'a', 1, 60),
(20, 'C++', 'axton', 'a', 0, 120),
(22, 'Final Test', 'dxton', 'd', 0, 0),
(23, 'Advanced AI', 'dxton', 'd', 1, 120);

--
-- 触发器 `Quiz`
--
DELIMITER $$
CREATE TRIGGER `auditQuizDelete` AFTER DELETE ON `Quiz` FOR EACH ROW insert into DeletedQuiz 
            set quiz_id=OLD.quiz_id, 
                user_id=OLD.author_id, 
                deleted_date=NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `Test`
--

CREATE TABLE `Test` (
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `attempt_date` date NOT NULL,
  `score` int(10) UNSIGNED NOT NULL,
  `score_percent` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Test`
--

INSERT INTO `Test` (`quiz_id`, `user_id`, `attempt_date`, `score`, `score_percent`) VALUES
(10, 'd', '2021-12-03', 16, 8),
(16, 'a', '2021-12-03', 100, 45),
(20, 'b', '2021-12-03', 35, 30);

-- --------------------------------------------------------

--
-- 表的结构 `User`
--

CREATE TABLE `User` (
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `isStaff` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `User`
--

INSERT INTO `User` (`user_id`, `user_name`, `password`, `isStaff`) VALUES
('a', 'axton', 'a', 1),
('b', 'bxton', 'b', 0),
('c', 'cxton', 'd', 0),
('d', 'dxton', 'd', 1),
('e', 'exton', 'e', 1);

--
-- 转储表的索引
--

--
-- 表的索引 `DeletedQuiz`
--
ALTER TABLE `DeletedQuiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `user_id_DeletedQuiz_User_user_id` (`user_id`);

--
-- 表的索引 `Options`
--
ALTER TABLE `Options`
  ADD PRIMARY KEY (`quiz_id`,`question_id`,`option_id`);

--
-- 表的索引 `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`quiz_id`,`question_id`);

--
-- 表的索引 `Quiz`
--
ALTER TABLE `Quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `author_id_User_user_id` (`author_id`);

--
-- 表的索引 `Test`
--
ALTER TABLE `Test`
  ADD PRIMARY KEY (`quiz_id`,`user_id`),
  ADD KEY `user_id_Test_User_user_id` (`user_id`);

--
-- 表的索引 `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `Quiz`
--
ALTER TABLE `Quiz`
  MODIFY `quiz_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 限制导出的表
--

--
-- 限制表 `DeletedQuiz`
--
ALTER TABLE `DeletedQuiz`
  ADD CONSTRAINT `user_id_DeletedQuiz_User_user_id` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- 限制表 `Options`
--
ALTER TABLE `Options`
  ADD CONSTRAINT `quiz_id_Options_Question_quiz_id` FOREIGN KEY (`quiz_id`,`question_id`) REFERENCES `Questions` (`quiz_id`, `question_id`) ON DELETE CASCADE;

--
-- 限制表 `Questions`
--
ALTER TABLE `Questions`
  ADD CONSTRAINT `quiz_id_Questions_Quiz_quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `Quiz` (`quiz_id`) ON DELETE CASCADE;

--
-- 限制表 `Quiz`
--
ALTER TABLE `Quiz`
  ADD CONSTRAINT `author_id_User_user_id` FOREIGN KEY (`author_id`) REFERENCES `User` (`user_id`);

--
-- 限制表 `Test`
--
ALTER TABLE `Test`
  ADD CONSTRAINT `user_id_Test_User_user_id` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
