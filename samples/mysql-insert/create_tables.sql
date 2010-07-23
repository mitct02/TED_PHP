CREATE TABLE `minutehistory` (
  `timestamp` datetime NOT NULL,
  `power` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `voltage` float NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `secondhistory` (
  `timestamp` datetime NOT NULL,
  `power` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `voltage` float NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;