SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- `magical_ui`
--
CREATE DATABASE IF NOT EXISTS `magical_ui` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `magical_ui`;

-- --------------------------------------------------------
--
-- `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(7) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `email` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `url` text NOT NULL,
  `project_id` varchar(200) NOT NULL,
  `project_type` varchar(50) NOT NULL,
  `created_tmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- `log_users`
--

DROP TABLE IF EXISTS `log_users`;
CREATE TABLE `log_users` (
  `id` int(15) UNSIGNED NOT NULL,
  `user_id` int(7) UNSIGNED NOT NULL,
  `date_tmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Structure de la table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `project_id` varchar(200) NOT NULL,
  `user_id` int(7) NOT NULL,
  `project_type` varchar(50) NOT NULL,
  `created_tmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_tmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `public_status` int(1) NOT NULL DEFAULT '0' COMMENT '0:inactif,1:prive;2:demande_piblic;3:demande_refusee;4:demande_acceptee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------
--
-- `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(7) UNSIGNED NOT NULL,
  `email` varchar(300) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `salt` varchar(200) NOT NULL,
  `group_id` int(7) NOT NULL,
  `status` int(2) NOT NULL,
  `created_tmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_tmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------
--
-- `newsletter`
--
DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE `newsletter` (
  `email` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`email`);

--
-- Index `log_users`
--
ALTER TABLE `log_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index `projects`
--
ALTER TABLE `projects`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Index `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);


--
-- AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT `log_users`
--
ALTER TABLE `log_users`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;
