SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Structure of the `logs` table
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure of the  `params` table
--

CREATE TABLE `params` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure of the `params` table
--

INSERT INTO `params` (`name`, `value`) VALUES
('timer_call', '20');

-- --------------------------------------------------------

--
-- Structure of the `payload` table
--

CREATE TABLE `payload` (
  `id` int(11) NOT NULL,
  `payload_name` text NOT NULL,
  `payload_content` longtext NOT NULL,
  `payload_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure of the `server_list` table
--

CREATE TABLE `server_list` (
  `id` int(11) NOT NULL,
  `server_name` text NOT NULL,
  `server_ip` varchar(25) NOT NULL,
  `server_users` int(11) NOT NULL,
  `payload_call` int(11) NOT NULL,
  `last_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure of the `users` table
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure of the `users` table
-- The default login for this is: admin:admin
-- So user is admin, password is admin
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'a14435e669434777c3b492cbcbe284c3656b462acaf2c76eb233e59e53edfbc1:2976bccd8b8dfee289e1300da93e62f7086afade');

--
-- Index for exported tables
--

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `payload`
--
ALTER TABLE `payload`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `server_list`
--
ALTER TABLE `server_list`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `payload`
--
ALTER TABLE `payload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `server_list`
--
ALTER TABLE `server_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;