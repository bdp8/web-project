-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`username`, `password`, `id`) VALUES
('user', 'password', 1);


-- --------------------------------------------------------

--
-- Структура на таблица `test`
--

CREATE TABLE `test` (
  `name` varchar(200) NOT NULL,
  `password` varchar(150) NOT NULL DEFAULT 'pass',
  `genre` varchar(30) NOT NULL,
  `author` varchar(60) NOT NULL,
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индекси за таблица `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

-- --------------------------------------------------------

--
-- Структура на таблица `question`
--

CREATE TABLE `question` (
  `test_id` int(11) NOT NULL,
  `fn` int(11) NOT NULL,
  `seq_num` int(11) NOT NULL,
  `motive` varchar(300) NOT NULL,
  `name` varchar(200) NOT NULL,
  `answer1` varchar(200) DEFAULT NULL,
  `answer2` varchar(200) DEFAULT NULL,
  `answer3` varchar(200) DEFAULT NULL,
  `answer4` varchar(200) DEFAULT NULL,
  `correctAnswer` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `ifCorrect` varchar(300) NOT NULL,
  `ifNotCorrect` varchar(300) NOT NULL,
  `note` varchar(300) NOT NULL,
  `type` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Индекси за таблица `test`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
-- --------------------------------------------------------

--
-- Структура на таблица `records`
--

CREATE TABLE `records` (
  `fn` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `school` varchar(200) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `kurs` int(11) NOT NULL,
  `adm_group` int(11) NOT NULL,
  `taken_test` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
