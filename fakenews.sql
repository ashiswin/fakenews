-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 18, 2018 at 12:33 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 7.0.27-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fakenews`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `url_link` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upvote` int(11) NOT NULL DEFAULT '0',
  `downvote` int(11) NOT NULL DEFAULT '0',
  `no_visits` int(11) NOT NULL DEFAULT '0',
  `reported_by` text NOT NULL,
  `category` text,
  `score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `url_link`, `date_added`, `upvote`, `downvote`, `no_visits`, `reported_by`, `category`, `score`) VALUES
(6, 'Facebook user apologises for doctoring City Harvest news article', 'The doctored Lianhe Wanbao headline (left) and the real headline (right). The part circled in blue says a PAP lawyer "saved" them, referring to the six accused in the City Harvest case, whereas the actual headline states that it was an outdated law that "saved" them from heavier sentences.', 'http://www.straitstimes.com/politics/facebook-user-apologises-for-doctoring-city-harvest-news-article', '2018-02-06 10:57:40', 19, 9, 236, '', 'Trending,Controversial', 0),
(8, 'Winter Olympics: Friendly North Korea ''is fake'', says former bomber', 'This year''s Winter Olympics in South Korea has seen friendly overtures from the North, but Kim Hyun-hui is not convinced.', 'http://www.bbc.com/news/av/42940993/winter-olympics-friendly-north-korea-is-fake-says-former-bomber', '2018-02-07 12:42:12', 1, 6, 7, '', 'Politics', 0),
(61, 'China Anbang crackdown: Who might be next?', 'China''s biggest conglomerates have been snapping up businesses around the world, including some in fairly sexy sectors.\n\nDespite growing so big and borrowing so much, they were seen as untouchable because of their political connections.', 'http://www.bbc.com/news/business-43207506', '2018-02-28 03:17:43', 1, 0, 7, 'Simon Atkinson', 'Trending,Politics', 0),
(62, 'Moon to get 4G mobile network', 'Mobile giants Vodafone and Nokia have laid out plans to launch a 4G mobile network on the Moon in 2019.\n\nThe network will be used by lunar rovers to stream data back to a base station.', 'http://www.bbc.com/news/av/technology-43211192/moon-to-get-4g-mobile-network', '2018-02-28 03:19:53', 0, 2, 0, 'Astronaut', 'Trending,Technology', 0),
(63, 'The â€˜exorcismâ€™ that turned into murder', 'When a young Nicaraguan woman became mentally ill, the pastor in her village decided to carry out an exorcism to expel to her â€œdemonsâ€.\n\nShe was starved and so badly burned that she soon died, causing a national outcry. \n\nI visited the remote village where the woman grew up, to find out how misogyny, belief in the devil and poor education led to murder.', 'http://www.bbc.com/news/av/technology-43211192/moon-to-get-4g-mobile-network', '2018-02-28 03:21:27', 0, 0, 4, 'Vicky Baker', 'Trending,Controversial', 0),
(64, 'Spy poisoning: Russian diplomats expelled across US and Europe', 'The United States and its European allies are expelling dozens of Russian diplomats in a co-ordinated response to the poisoning of a former Russian spy in the UK.', 'http://www.bbc.com/news/world-us-canada-43545565', '2018-03-26 17:37:06', 0, 0, 0, 'tester Lim', '', 0),
(65, 'Malaysia seeks 10 year-jail terms for ''fake news''', 'Malaysia''s government has proposed new legislation to combat "fake news", with offenders facing up to 10 years in prison.', 'http://www.bbc.com/news/world-asia-43538109', '2018-03-26 17:38:11', 1, 1, 0, 'tester Lim', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `articleVotes`
--

CREATE TABLE IF NOT EXISTS `articleVotes` (
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `upvote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articleVotes`
--

INSERT INTO `articleVotes` (`article_id`, `user_id`, `upvote`) VALUES
(65, 2, 0),
(65, 1, 1),
(6, 1, 1),
(6, 1, 1),
(6, 1, 1),
(6, 1, 1),
(6, 9, 1),
(6, 9, 1),
(6, 1, 0),
(6, 1, 1),
(6, 1, 1),
(6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `articleId` int(11) NOT NULL,
  `content` text NOT NULL,
  `title` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upvote` int(11) NOT NULL DEFAULT '0',
  `downvote` int(11) NOT NULL DEFAULT '0',
  `child_of` int(11) DEFAULT NULL,
  `children` int(11) NOT NULL DEFAULT '0',
  `child_comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `userId`, `articleId`, `content`, `title`, `date_added`, `upvote`, `downvote`, `child_of`, `children`, `child_comments`) VALUES
(2, 1, 1, 'test comment', 'test title', '2018-02-05 09:32:25', 3, 2, NULL, 5, ''),
(3, 1, 1, 'test comment', 'test title', '2018-02-05 09:34:23', 0, 0, NULL, 0, ''),
(5, 1, 1, 'test comment', 'test title', '2018-02-05 09:42:57', 0, 0, 2, 0, ''),
(11, 1, 1, 'test comment', 'test title', '2018-02-05 13:06:56', 0, 0, 2, 0, ''),
(16, 1, 3, 'my comments are the funniest', 'title is awesome', '2018-02-11 06:40:40', 0, 0, 0, 0, ''),
(18, 1, 4, 'my comments are the funniest', 'title is awesome', '2018-02-11 06:41:16', 0, 0, 0, 0, ''),
(19, 1, 4, 'my comments are the funniest', 'title is awesome', '2018-02-11 06:49:13', 0, 0, 0, 0, ''),
(20, 1, 4, 'my comments are the funniest', 'title is awesome', '2018-02-11 06:49:20', 0, 0, 0, 0, ''),
(21, 1, 4, 'my comments are the funniest', 'title is awesome', '2018-02-11 06:51:10', 0, 0, 0, 0, ''),
(22, 1, 1, 'test comment', 'test title', '2018-02-11 07:04:36', 0, 0, 2, 0, ''),
(23, 1, 4, 'my comments are the funniest', 'title is awesome', '2018-02-11 10:06:00', 0, 0, 0, 0, ''),
(30, 1, 3, 'hihi', '', '2018-02-14 15:15:12', 0, 0, 0, 0, ''),
(31, 1, 3, 'whatever', '', '2018-02-14 15:19:22', 0, 0, 0, 0, ''),
(32, 1, 3, 'testing\n', '', '2018-02-14 15:22:33', 0, 0, 0, 0, ''),
(37, 1, 3, 'hi', '', '2018-02-15 15:28:40', 0, 0, 0, 0, ''),
(38, 1, 3, 'what\n', '', '2018-02-15 15:29:07', 0, 0, 0, 0, ''),
(39, 1, 3, 'test', '', '2018-02-15 15:30:00', 0, 0, 0, 0, ''),
(49, 1, 6, 'hello', '', '2018-03-14 12:05:46', 0, 0, 48, 0, NULL),
(50, 1, 6, 'hello', '', '2018-03-14 12:06:07', 0, 0, 48, 0, NULL),
(53, 1, 8, 'Blah blah blah\n', '', '2018-03-16 07:00:49', 2, 5, 0, 0, NULL),
(55, 1, 6, 'no\n', '', '2018-03-28 13:49:37', 1, 0, 0, 0, '56'),
(56, 1, 6, 'aye', '', '2018-03-28 13:49:50', 1, 1, 55, 0, NULL),
(57, 1, 6, 'hello', '', '2018-04-27 10:22:24', 0, 0, 54, 0, NULL),
(58, 0, 0, 'hello', 'hello', '2018-04-27 11:18:21', 0, 0, 0, 0, NULL),
(59, 0, 0, 'a', 'a', '2018-04-27 11:19:14', 0, 0, 0, 0, NULL),
(60, 0, 0, 'a', 'a', '2018-04-27 11:20:43', 0, 0, 0, 0, NULL),
(61, 1, 6, 'hey', 'hey', '2018-04-27 11:28:45', 0, 0, 0, 0, '65'),
(62, 1, 6, 'cool', 'undefined', '2018-04-27 14:36:47', 0, 0, 0, 0, NULL),
(63, 1, 6, 'the', 'undefined', '2018-04-27 14:37:12', 0, 0, 0, 0, NULL),
(64, 1, 6, 'hello\n', 'undefined', '2018-04-27 15:02:24', 0, 0, 61, 0, NULL),
(65, 1, 6, 'no\n', 'undefined', '2018-04-27 15:11:47', 0, 0, 61, 0, NULL),
(66, 1, 6, 'testing child comments', 'testing child comments', '2018-04-28 15:08:35', 0, 0, 54, 0, NULL),
(67, 1, 6, 'testing child comments', 'testing child comments', '2018-04-28 15:12:00', 0, 0, 54, 0, NULL),
(68, 1, 6, 'testing child comments', 'undefined', '2018-04-29 03:41:15', 0, 0, 54, 0, NULL),
(69, 1, 6, 'hello', 'hello', '2018-04-29 09:55:23', 0, 0, 0, 0, NULL),
(70, 13, 6, 'whatever', 'Hello', '2018-04-29 09:57:32', 0, 0, 0, 0, NULL),
(71, 13, 6, 'Whatever', 'Hello', '2018-04-29 09:59:14', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `commentVotes`
--

CREATE TABLE IF NOT EXISTS `commentVotes` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `upvote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commentVotes`
--

INSERT INTO `commentVotes` (`comment_id`, `user_id`, `upvote`) VALUES
(56, 1, 1),
(56, 2, 0),
(54, 0, 1),
(54, 0, 1),
(55, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `passwordHash` text NOT NULL,
  `salt` text NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `passwordHash`, `salt`, `admin`) VALUES
(1, 'tester', 'Lim', 'test@gmail.com', '0a5b5ebfad06e7348789bdbb8742d1aeaf7470c1a1b646a21e90d5b12d7347999658c12a446e19387e5c33789b7fa0f2f1fb480d95d96629d392febd905029bb', '7uHnab9utN', 0),
(2, 'Rayson', 'Lim', 'rayson.ljk@gmail.com', 'f2258013325b182052e4f234e6eb3e6fdeedd1b07d7baf951ef23d6326155aa17f689c57108249114624b199663f6e1fd0734bb6b19e7d87c300dd2473249a84', 'hTqRtfeYN2', 1),
(9, 'angelia', 'lau', 'email@email.com', '37b32494399900f1114f536d7bc274be60f4264fe2a471ddd769bce178593e1de2ab597aa2ad8c4578ccea5f44f907ed702f06878cf791ec0863fef8c90956cc', 'cUyECBz79C', 0),
(10, 'testerAdmin', 'testerAdmin', 'testerAdmin@mail.com', '869a98657d354663884897d17c837f00cffe507412e0603970d739921a41c38ca9e17df008a66ed0afb94c3753a80c268d357f4e6546ad56923ca340ce1bba85', 'fC5RCkBLUL', 1),
(11, 'angelia', 'lau', 'newmod@mail.com', 'f4ab256ef5c09ea03817e96e49695cb3f9a377c5c2324c48aadcd9617be4eefac706955cf4358cd1a12c6a48c84ce5accbb3862b33ba64786acf1b5f0816ee46', 'c8NuxfdnH8', 1),
(12, 'angelia', 'lau', 'newmod2@mail.com', 'da98579a772f5bd9ccb4733e68a65953cc5169363063f9208946b58184f1e75838951599e2074943d94615a12e272074e11d16339a3e31aee6130aea6e7c5fbf', 'zq78AVReC4', 1),
(13, 'yin', 'ji sheng', 'whatever@gmail.com', 'ba591ff7773b7c1378a0b3fb33efa87d78aa2b82dfc5701b0080c96f34990b5577d8134257eeca4bc4d48c31de5874838b922ce8836bf4f7a81c9f0b48afd9ab', 'esuFArxP6f', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
