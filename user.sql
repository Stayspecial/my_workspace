

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_name` varchar(155) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `country_id`, `city_name`) VALUES
(1, 1, 'Mumbai'),
(2, 1, 'Pune'),
(3, 3, 'Melbourne'),
(4, 3, 'Sydney'),
(7, 2, 'Tokyo'),
(6, 3, 'Darwin '),
(8, 2, 'Nara');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(155) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`) VALUES
(1, 'India'),
(2, 'Japan'),
(3, 'Australia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `dob` date NOT NULL,
  `age` int(3) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `education` varchar(100) NOT NULL,
  `pin_code` int(6) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `country` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `address`, `dob`, `age`, `status`, `education`, `pin_code`, `profile`, `country`, `city`, `added_on`, `updated_on`) VALUES
(1, 'simar  D', 'simar_203@gmail.com', 'B-201,test address', '2002-09-03', 19, 'active', 'Undergraduate', 410201, '', 1, 2, '2021-09-16 07:45:45', '2021-09-16 08:05:46'),
(2, 'Jayesh Sharma', 'jayesh@pgpl.com', 'C-205,J. K .park', '2001-09-18', 19, 'active', 'Diploma', 410244, 'Penguins.jpg', 1, 1, '2021-09-16 08:02:40', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
