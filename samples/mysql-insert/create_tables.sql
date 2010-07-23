CREATE TABLE `second_history` (
  `mtu` smallint(6) NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL,
  `power` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `voltage` float NOT NULL,
  `insert_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mtu`,`timestamp`),
  KEY `IX_insert_ts` (`insert_ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `minute_history` (
  `mtu` smallint(6) NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL,
  `power` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `voltage` float NOT NULL,
  `insert_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mtu`,`timestamp`),
  KEY `IX_insert_ts` (`insert_ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;