CREATE TABLE `discord_general` (
  `id` int(10) NOT NULL,
  `user` varchar(250) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `hidden` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `discord_general`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `discord_general`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;