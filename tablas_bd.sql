

--
-- Table structure for table `CONF_SMTP`
--

DROP TABLE IF EXISTS `CONF_SMTP`;
CREATE TABLE IF NOT EXISTS `CONF_SMTP` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `HOSTNAME` varchar(150) NOT NULL,
  `PORT` int(3) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `Auth` varchar(5) NOT NULL DEFAULT 'true',
  `SMTPSecure` varchar(10) NOT NULL DEFAULT 'false',
  `SMTPDebug` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CONF_SMTP`
--

INSERT INTO `CONF_SMTP` (`ID`, `HOSTNAME`, `PORT`, `USERNAME`, `PASSWORD`, `Auth`, `SMTPSecure`, `SMTPDebug`) VALUES
(1, 'mail.daoutel.net', 587, 'info@daoutel.net', 'vito1603', 'true', 'false', 0);

-- --------------------------------------------------------

--
-- Table structure for table `CTA_GL_CONF`
--

DROP TABLE IF EXISTS `CTA_GL_CONF`;
CREATE TABLE IF NOT EXISTS `CTA_GL_CONF` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CTA_CXP` varchar(8) NOT NULL,
  `CTA_PUR` varchar(8) NOT NULL,
  `CTA_TAX` varchar(8) NOT NULL,
  `ID_compania` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `FAC_DET_CONF`
--

DROP TABLE IF EXISTS `FAC_DET_CONF`;
CREATE TABLE IF NOT EXISTS `FAC_DET_CONF` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DIV_LINE` int(11) NOT NULL,
  `NO_LINES` int(4) NOT NULL,
  `ID_compania` int(11) NOT NULL,
  PRIMARY KEY (`ID`,`ID_compania`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MOD_MENU_CONF`
--

DROP TABLE IF EXISTS `MOD_MENU_CONF`;
CREATE TABLE IF NOT EXISTS `MOD_MENU_CONF` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `mod_sales` varchar(7) NOT NULL,
  `mod_fact` varchar(7) NOT NULL,
  `mod_invt` varchar(7) NOT NULL,
  `mod_rept` varchar(7) NOT NULL,
  `mod_stock` varchar(7) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MSG_SOL_DELIVERY`
--

DROP TABLE IF EXISTS `MSG_SOL_DELIVERY`;
CREATE TABLE IF NOT EXISTS `MSG_SOL_DELIVERY` (
  `ID_STATUS` int(11) NOT NULL,
  `ITEM` int(11) NOT NULL,
  `USER` int(11) NOT NULL,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NO_SOL` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `MSG_SOL_DELI_REG`
--

DROP TABLE IF EXISTS `MSG_SOL_DELI_REG`;
CREATE TABLE IF NOT EXISTS `MSG_SOL_DELI_REG` (
  `NO_SOL` int(11) NOT NULL,
  `ITEM` int(11) NOT NULL,
  `USER` int(11) NOT NULL,
  `USER_RECV` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `MSG_SOL_DETAIL`
--

DROP TABLE IF EXISTS `MSG_SOL_DETAIL`;
CREATE TABLE IF NOT EXISTS `MSG_SOL_DETAIL` (
  `NO_SOL` int(11) NOT NULL,
  `PRODUCT` varchar(50) NOT NULL,
  `ITEMID` int(11) NOT NULL,
  `DEST_EMPRESA` varchar(40) NOT NULL,
  `DEST_DIR` varchar(100) NOT NULL,
  `DEST_NAME` varchar(40) NOT NULL,
  `DEST_TELF` varchar(20) NOT NULL,
  `NOTA` varchar(255) DEFAULT NULL,
  `STATUS` int(11) NOT NULL DEFAULT '1',
  `closed` int(11) DEFAULT '0',
  `desc_closed` varchar(255) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `USER_CLOSED` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`NO_SOL`,`ITEMID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `MSG_SOL_GEN_STATUS`
--

DROP TABLE IF EXISTS `MSG_SOL_GEN_STATUS`;
CREATE TABLE IF NOT EXISTS `MSG_SOL_GEN_STATUS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `STATUS` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MSG_SOL_GEN_STATUS`
--

INSERT INTO `MSG_SOL_GEN_STATUS` (`ID`, `STATUS`) VALUES
(1, 'SOLICITUD PENDIENTE'),
(2, 'EN PROCESO'),
(3, 'EN TRANSITO'),
(4, 'FINALIZADO'),
(5, 'CANCELADO');

-- --------------------------------------------------------

--
-- Table structure for table `MSG_SOL_HEADER`
--

DROP TABLE IF EXISTS `MSG_SOL_HEADER`;
CREATE TABLE IF NOT EXISTS `MSG_SOL_HEADER` (
  `NO_SOL` int(11) NOT NULL AUTO_INCREMENT,
  `DATE` datetime NOT NULL,
  `ORI_DIR` varchar(100) NOT NULL,
  `ORI_NAME` varchar(40) NOT NULL,
  `ORI_TELF` varchar(20) NOT NULL,
  `ORI_MAIL` varchar(100) NOT NULL,
  `ORI_NOTA` varchar(255) NOT NULL,
  `NOPIEZA` int(11) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `USER` int(11) NOT NULL,
  `ST_CLOSED` int(11) NOT NULL DEFAULT '0',
  `DESC_CLOSED` varchar(1024) NOT NULL,
  `USER_CLOSED` int(11) NOT NULL,
  PRIMARY KEY (`NO_SOL`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `MSG_SOL_STARTED`
--

DROP TABLE IF EXISTS `MSG_SOL_STARTED`;
CREATE TABLE IF NOT EXISTS `MSG_SOL_STARTED` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NO_SOL` int(11) NOT NULL,
  `USER` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `MSG_SOL_STATUS`
--

DROP TABLE IF EXISTS `MSG_SOL_STATUS`;
CREATE TABLE IF NOT EXISTS `MSG_SOL_STATUS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `STATUS` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MSG_SOL_STATUS`
--

INSERT INTO `MSG_SOL_STATUS` (`ID`, `STATUS`) VALUES
(3, 'ENTREGADO'),
(4, 'CANCELADO'),
(1, 'NO RETIRADO'),
(2, 'EN TRANSITO');

-- --------------------------------------------------------

--
-- Table structure for table `SAX_USER`
--

DROP TABLE IF EXISTS `SAX_USER`;
CREATE TABLE IF NOT EXISTS `SAX_USER` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `onoff` int(11) NOT NULL DEFAULT '1',
  `role` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `notif_oc` int(11) NOT NULL DEFAULT '0',
  `notif_fc` int(11) NOT NULL DEFAULT '0',
  `role_purc` int(11) NOT NULL,
  `role_fiel` int(11) NOT NULL DEFAULT '0',
  `last_login` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ORI_DIR1` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ORI_DIR2` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ORI_DIR3` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ORI_DIR4` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ORI_DIR5` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ORI_TELF` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Recover_key` varchar(10000) COLLATE utf8_spanish_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `SAX_USER`
--

INSERT INTO `SAX_USER` (`id`, `name`, `lastname`, `email`, `pass`, `onoff`, `role`, `notif_oc`, `notif_fc`, `role_purc`, `role_fiel`, `last_login`, `ORI_DIR1`, `ORI_DIR2`, `ORI_DIR3`, `ORI_DIR4`, `ORI_DIR5`, `ORI_TELF`, `Recover_key`) VALUES
(1, 'Reinaldo', 'Daou', 'reinaldo.daou@gmail.com', '07298c6cae93ca9d5c0992818497fa87', 1, 'admin', 1, 0, 0, 0, '2017-06-16 23:25:34', 'Mexico', 'Col. del Valle', 'Benito Juarez', '03100', 'cerca del superama', '5547852971', '0'),
(21, 'alex', 'pina', 'jonels29@hotmail.com', 'b75bd008d5fecb1f50cf026532e8ae67', 1, 'user', 0, 0, 0, 0, '2017-05-21 00:47:26', 'ccs', 'ccs', 'ccs', 'ccs', 'ccs', '582126721292', '0'),
(22, 'alex', 'pina', 'jonels29@gmail.com', 'b75bd008d5fecb1f50cf026532e8ae67', 1, 'user_admin', 0, 0, 0, 0, '2017-06-13 01:14:48', 'ccs', 'ccs', 'ccs', 'ccs', 'ccs', '582126721292', '0'),
(24, 'yilmara', 'gonzalez', 'gpyilmara17@gmail.com', '4b53badb8bd7d0a55db6192d6dc60f39', 1, 'user', 0, 0, 0, 0, '2017-05-20 03:06:14', 'panama', 'panama', 'panama', 'panama', 'casa amarilla', '69805663', '0'),
(29, 'Luis', 'Armuelles', 'larmuelles@gmail.com', '58991e95ec0d8fe718c68b7d03811a74', 1, 'user', 0, 0, 0, 0, '2017-05-20 22:12:26', 'Betania', 'Miraflores, Nuevo Altos de Miraflores', 'Panama', '-', 'La calle de la U Latina', '6090-4349', '0');

-- --------------------------------------------------------

--
-- Table structure for table `SYS_COMP_INFO`
--

DROP TABLE IF EXISTS `SYS_COMP_INFO`;
CREATE TABLE IF NOT EXISTS `SYS_COMP_INFO` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `id_company_sage` int(11) DEFAULT NULL,
  `Tel` varchar(45) DEFAULT NULL,
  `Fax` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `company_info`
--

CREATE TABLE IF NOT EXISTS `company_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `id_company_sage` int(11) DEFAULT NULL,
  `Tel` varchar(45) DEFAULT NULL,
  `Fax` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `company_name`, `address`, `id_company_sage`, `Tel`, `Fax`, `email`) VALUES
(1, 'Prueba Sage', 'Ciudad de Panama, Panama', 1, '507-398-0408', '', 'info@daoutel.net');