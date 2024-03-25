-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2022 at 11:13 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `application_list`
--

CREATE TABLE `application_list` (
  `id` int(30) NOT NULL,
  `club_id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `year_level` text NOT NULL,
  `section` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `email` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Confirmed, 2 = Approved, 3 = Denied',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_list`
--

INSERT INTO `application_list` (`id`, `club_id`, `firstname`, `middlename`, `lastname`, `gender`, `year_level`, `section`, `message`, `email`, `contact`, `address`, `status`, `date_created`, `date_updated`) VALUES
(2, 5, 'Mike', 'D', 'Williams', 'Male', 'First Year', 'A', 'Sed nec dapibus nunc. Nulla dapibus aliquam nisi, a gravida arcu interdum sollicitudin. Donec vel sem euismod risus auctor hendrerit quis ac elit. In ut semper urna, ac blandit dolor. Nam porttitor commodo convallis. Vestibulum iaculis leo sed eros efficitur porta. Aenean tempor laoreet sagittis. Maecenas blandit, nisi sed iaculis lacinia, mi arcu tempor magna, id mattis justo ipsum at metus. Phasellus quis semper dui. Curabitur faucibus augue lorem, ut dignissim justo mollis vitae. Vestibulum laoreet tellus pellentesque mi lacinia, sodales accumsan tortor pulvinar. Donec at ante in arcu scelerisque pretium a vel ex.', 'mwilliams@sample.com', '09123456789', 'Sample Address', 2, '2022-04-07 15:55:42', '2022-04-07 16:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `club_list`
--

CREATE TABLE `club_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `logo_path` text DEFAULT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `club_list`
--

INSERT INTO `club_list` (`id`, `name`, `description`, `status`, `logo_path`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Film Club', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquam nulla sed arcu venenatis, in pretium magna aliquam. Aliquam aliquet sagittis justo, quis venenatis tortor pulvinar et. Nulla est nibh, mattis sed felis malesuada, laoreet sodales ex. Donec tempus massa sed velit malesuada, eu elementum nisl pretium. Nunc venenatis risus sed est ornare molestie. In hac habitasse platea dictumst. Curabitur euismod porttitor erat vitae venenatis.', 1, 'uploads/club-logos/1.png?v=1649308690', 0, '2022-04-07 10:16:48', '2022-04-07 13:18:10'),
(2, 'Chess Club', 'Nunc vitae iaculis nisi. Duis consectetur magna a mauris ultricies pulvinar. Mauris enim diam, aliquam et libero in, fringilla hendrerit enim. Aenean non risus metus. In pellentesque ut eros at scelerisque. Phasellus non felis non odio posuere blandit id vel erat. Fusce tortor nibh, efficitur a sapien in, molestie vulputate leo. Sed mattis facilisis dapibus. Cras ultrices ultricies ante, nec facilisis ligula pharetra a. Nam vitae nisl lobortis, luctus elit eget, iaculis nisl. Nulla pretium metus non finibus auctor. Phasellus mauris mauris, tempor eu purus a, placerat faucibus purus.', 1, 'uploads/club-logos/2.png?v=1649308837', 0, '2022-04-07 10:17:58', '2022-04-07 13:20:37'),
(3, 'test', 'test', 2, NULL, 1, '2022-04-07 10:27:02', '2022-04-07 10:27:07'),
(4, 'Science Club', 'Suspendisse in quam diam. Nam dapibus nisl enim, eu interdum mi tincidunt fermentum. Morbi sit amet urna ut orci aliquam venenatis eu vitae dui. Fusce mattis libero elit, at blandit mi varius nec. Nunc justo nunc, convallis in lectus at, lacinia ultricies leo. In pharetra ligula sit amet quam cursus, dapibus interdum quam fermentum.', 1, 'uploads/club-logos/4.png?v=1649309883', 0, '2022-04-07 13:38:03', '2022-04-07 13:38:03'),
(5, 'Math Club', 'Suspendisse tortor risus, interdum nec est ac, pretium auctor tellus. Pellentesque eros leo, fermentum ut arcu et, eleifend fermentum dui. Fusce in rhoncus nunc. Etiam sed tincidunt nisl.', 1, 'uploads/club-logos/5.png?v=1649313207', 0, '2022-04-07 14:33:27', '2022-04-07 14:33:27'),
(6, 'Dance Club', 'Nullam id molestie lectus. Sed euismod convallis sollicitudin. Nunc rhoncus dapibus nulla. Curabitur in dignissim dolor, a commodo odio. Phasellus non euismod leo. Curabitur ultrices suscipit ipsum non congue.', 1, 'uploads/club-logos/6.png?v=1649313916', 0, '2022-04-07 14:39:09', '2022-04-07 14:45:16'),
(7, 'Book Club', 'Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis sit amet erat ullamcorper, feugiat tortor vitae, ultrices purus. Phasellus at orci et nunc pretium viverra. Cras ex massa, congue id accumsan vitae, consequat id felis.', 1, 'uploads/club-logos/7.png?v=1649313736', 0, '2022-04-07 14:39:18', '2022-04-07 14:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'School Club Application System'),
(6, 'short_name', 'SCAS - PHP'),
(11, 'logo', 'uploads/system-logo.png?v=1649297034'),
(14, 'cover', 'uploads/system-cover.png?v=1649297035');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Admin, 2= Club''s Admin',
  `club_id` int(30) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `type`, `club_id`, `last_login`, `date_added`, `date_updated`) VALUES
(1, 'Administrator', '', 'Admin', 'admin', '$2y$10$n2s5dbrCwxWa7i6Fr/U44O8miS9d9zB07ZQbGzrFg4LLu6rPTdFkq', 'uploads/users/avatar-1.png?v=1648628905', 1, NULL, '2022-03-30 03:48:55', '2022-03-30 09:49:16', '2022-03-30 16:28:25'),
(2, 'Mark', 'D', 'Cooper', 'mcooper', '$2y$10$GNiKmxuFNQxaMa25OjFqdetYWAHcCBSabSaL2zHqVR4xLw0lmTDua', 'uploads/users/avatar-2.png?v=1649302185', 2, 5, NULL, '2022-04-07 11:11:45', '2022-04-07 16:57:52'),
(4, 'Claire', '', 'Blake', 'cblake', '$2y$10$XbcaaJpp3FlpNa7m7ZV0ROZ/gbr3zjBWpbGMybb97rX510qD1gjj2', 'uploads/users/avatar-4.png?v=1649304006', 2, 1, NULL, '2022-04-07 12:00:06', '2022-04-07 16:48:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application_list`
--
ALTER TABLE `application_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `club_list`
--
ALTER TABLE `club_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application_list`
--
ALTER TABLE `application_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `club_list`
--
ALTER TABLE `club_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_list`
--
ALTER TABLE `application_list`
  ADD CONSTRAINT `application_club_id_fk` FOREIGN KEY (`club_id`) REFERENCES `club_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_club_id_fk` FOREIGN KEY (`club_id`) REFERENCES `club_list` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
