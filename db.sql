--
-- Tabellenstruktur für Tabelle `auth`
--

CREATE TABLE `auth` (
  `id` int(10) UNSIGNED NOT NULL,
  `salt` char(40) CHARACTER SET ascii NOT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `t_point` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `user_pass` char(40) CHARACTER SET ascii NOT NULL,
  `user_pepper` char(40) CHARACTER SET ascii NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `a_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_pass`, `user_pepper`, `last_login`, `a_date`) VALUES
(1, 'coombo', '7e76b5185cf418187f48f4475594bcb019527edb', '2fb5e13419fc89246865e7a324f476ec624e8740', '2017-02-02 16:21:03', '0000-00-00 00:00:00');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;