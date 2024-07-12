
-- Database: `homecoms`

-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `user_id` int(11) DEFAULT NULL,
  `mid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalamt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `wid` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `salary` varchar(50) NOT NULL,
  `days` int(11) NOT NULL,
  `totalsal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE `timeline` (
  `tid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expected_days` int(11) NOT NULL,
  `current_status` enum('To be done','Completed') NOT NULL DEFAULT 'To be done',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `uploadfiles`
--

CREATE TABLE `uploadfiles` (
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `fid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `homeowner_name` varchar(100) NOT NULL,
  `homeowner_contact` bigint(100) NOT NULL,
  `construction_address` text NOT NULL,
  `num_storeys` int(11) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `deadline` int(11) NOT NULL,
  `engineer_name` varchar(100) NOT NULL,
  `engineer_contact` bigint(100) NOT NULL,
  `contractor_name` varchar(100) NOT NULL,
  `contractor_contact` bigint(100) NOT NULL,
  `extension` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`user_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `materials_ibfk_1` (`user_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`wid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `uploadfiles`
--
ALTER TABLE `uploadfiles`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uploadfiles`
--
ALTER TABLE `uploadfiles`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `timeline`
--
ALTER TABLE `timeline`
  ADD CONSTRAINT `timeline_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `uploadfiles`
--
ALTER TABLE `uploadfiles`
  ADD CONSTRAINT `uploadfiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
