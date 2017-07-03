SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `favs` (
  `favUID` varchar(34) NOT NULL DEFAULT '',
  `tweetID` bigint(18) NOT NULL,
  `foundDate` int(12) NOT NULL,
  `text` varchar(500) DEFAULT NULL,
  `writer` varchar(50) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `favs`
  ADD PRIMARY KEY (`favUID`);
