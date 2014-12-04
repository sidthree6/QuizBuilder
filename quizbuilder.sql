-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2014 at 01:52 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quizbuilder`
--

-- --------------------------------------------------------

--
-- Table structure for table `quiz_catagory`
--

CREATE TABLE IF NOT EXISTS `quiz_catagory` (
`cid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `datecreated` datetime NOT NULL,
  `totalquizandflash` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `quiz_catagory`
--

INSERT INTO `quiz_catagory` (`cid`, `mid`, `title`, `datecreated`, `totalquizandflash`) VALUES
(34, 1, 'Sample Quiz', '2014-12-04 01:51:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_member`
--

CREATE TABLE IF NOT EXISTS `quiz_member` (
`mid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `joindate` datetime NOT NULL,
  `lastlogin` datetime NOT NULL,
  `logged` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `quiz_member`
--

INSERT INTO `quiz_member` (`mid`, `username`, `password`, `type`, `joindate`, `lastlogin`, `logged`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '2014-11-28 00:00:00', '2014-12-04 01:51:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_quizes`
--

CREATE TABLE IF NOT EXISTS `quiz_quizes` (
`qid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `question` text NOT NULL,
  `answerOne` text NOT NULL,
  `answerTwo` text NOT NULL,
  `answerThree` text NOT NULL,
  `answerFour` text NOT NULL,
  `answerFive` text NOT NULL,
  `correctanswer` tinyint(4) NOT NULL,
  `mcortf` tinyint(1) NOT NULL,
  `datecreated` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `quiz_quizes`
--

INSERT INTO `quiz_quizes` (`qid`, `mid`, `cid`, `question`, `answerOne`, `answerTwo`, `answerThree`, `answerFour`, `answerFive`, `correctanswer`, `mcortf`, `datecreated`) VALUES
(61, 1, 34, 'Sample Multiple Choice Question', 'Option One', 'Option Two', 'Option Three', 'Option Four', '', 1, 1, '2014-12-04'),
(62, 1, 34, 'Sample True/False Question', 'True', 'False', '', '', '', 1, 2, '2014-12-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quiz_catagory`
--
ALTER TABLE `quiz_catagory`
 ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `quiz_member`
--
ALTER TABLE `quiz_member`
 ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `quiz_quizes`
--
ALTER TABLE `quiz_quizes`
 ADD PRIMARY KEY (`qid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz_catagory`
--
ALTER TABLE `quiz_catagory`
MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `quiz_member`
--
ALTER TABLE `quiz_member`
MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `quiz_quizes`
--
ALTER TABLE `quiz_quizes`
MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
