-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2017 at 04:01 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enrico-blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url_name` varchar(510) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `url_name`) VALUES
(1, 'Videogiochi', 'Videogiochi'),
(2, 'Cinema', 'Cinema'),
(3, 'Tecnologia', 'Tecnologia');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(125) NOT NULL,
  `url_title` varchar(510) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `text` text NOT NULL,
  `id_category` int(11) NOT NULL,
  `author` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `url_title`, `date`, `time`, `text`, `id_category`, `author`) VALUES
(3, 'News del mio blog', 'News-del-mio-blog', '2017-01-04', '11:34:01', 'Ciao!\r\n\r\nQuesto &egrave; un blog un p&ograve;... particolare! parlo un po di tutto quello che mi interessa!', 0, 'Enrico'),
(4, 'Nintendo padroneggia Unreal Engine', 'Nintendo-padroneggia-Unreal-Engine', '2017-02-07', '15:13:01', 'Nintendo Switch, com''&egrave; noto, &egrave; compatibile con una serie di tecnologie di sviluppo molto popolari in Occidente, come l''Unreal Engine di Epic Games.\r\n\r\nQuesto, tra i vari benefici, permette agli sviluppatori di realizzare giochi per Switch molto pi&ugrave; facilmente rispetto alle precedenti piattaforme della Grande N.\r\n\r\nNe ha parlato, nel corso di una Q&A con gli investitori a Kyoto, Shigeru Miyamoto, spiegando che "gli sviluppatori software di Nintendo hanno padroneggiato tecnologie allo stato d ell''arte come l''Unreal Engine".\r\n\r\nSecondo Miyamoto, sebbene si dica spesso che in Occidente gli sviluppatori hanno un livello di competenza superiore rispetto ai colleghi asiatici, "le loro skill possono ora essere paragonate" e "i nostri sviluppatori sono pi&ugrave; entusiasti che mai di poter creare software".', 1, 'Enrico'),
(5, 'Dunkirk: aggiornamenti dal set', 'Dunkirk:-aggiornamenti-dal-set', '2017-02-07', '15:17:26', 'Harry Styles attore sul set di Dunkirk, il nuovo film di Christopher Nolan atteso nelle sale ad Agosto 2017.\r\n\r\nSvestiti (momentaneamente) i panni del cantante, Harry sta indossato quelli dellâ€™attore per interpretare Tommy, uno dei personaggi coinvolti nellâ€™operazione Dynamo, nota anche come â€œevacuazione di Dunkerqueâ€ avvenuta nel 1940 durante le prime fasi della Seconda Guerra Mondiale e che in 8 giorni riuscÃ¬ a salvare la vita a 338,226 soldati.\r\n\r\nIl film &egrave; attualmente in lavorazione nei luoghi in cui sono avvenuti realmente i fatti. Per esigenze di copione, Harry si &egrave; tagliato i capelli.', 2, 'Enrico'),
(6, 'Il cavaliere del â€œTrono di Spadeâ€ documenta la Groenlandia per Google', 'Il-cavaliere-del-â€œTrono-di-Spadeâ€-documenta-la-Groenlandia-per-Google', '2017-02-07', '15:21:12', 'Google Maps ha recentemente completato la mappatura Street View dei paesaggi della Groenlandia. Il progetto &egrave; stato raccontato attraverso gli occhi di Nikolaj Coster-Waldau, star de Â«Il Trono di SpadeÂ» e recentemente nominato Goodwill Ambassador dellâ€™Onu. Lâ€™attore ha collaborato con la societ&agrave; californiana per dimostrare lâ€™impatto del cambiamento climatico di questo luogo a lui particolarmente caro, come racconta nel blog.', 3, 'Enrico');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `level`) VALUES
(1, 'Enrico', '50fe245e8660da1e8c98b8562f48002ca1cea652', 'e.ipodda@googlemail.com', 'admin'),
(2, 'Gino', '50fe245e8660da1e8c98b8562f48002ca1cea652', 'ginetto@gmail.com', 'usr');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
