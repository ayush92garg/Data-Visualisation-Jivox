| data  | CREATE TABLE `data` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `stateId` int(5) DEFAULT NULL,
  `stateName` varchar(50) DEFAULT NULL,
  `cityId` int(5) DEFAULT NULL,
  `cityName` varchar(50) DEFAULT NULL,
  `AgeGroup` varchar(30) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `population` int(10) DEFAULT NULL,
  `numberOfMale` int(5) DEFAULT NULL,
  `numberOfFemale` int(5) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53371 DEFAULT CHARSET=latin1 |
