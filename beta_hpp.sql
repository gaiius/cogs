-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bahan_baku`;
CREATE TABLE `bahan_baku` (
  `id_bahan_baku` varchar(10) NOT NULL,
  `nama_bahan_baku` varchar(50) NOT NULL,
  `stok` decimal(10,2) NOT NULL,
  `satuan_stok` varchar(10) NOT NULL,
  `satuan_beli` varchar(10) NOT NULL,
  `konversi` decimal(10,2) NOT NULL,
  `harga_beli` decimal(18,2) NOT NULL,
  `harga_average` decimal(18,2) NOT NULL,
  PRIMARY KEY (`id_bahan_baku`),
  KEY `fk_satuan_stok` (`satuan_stok`),
  KEY `fk_satuan_beli` (`satuan_beli`),
  CONSTRAINT `fk_satuan_beli` FOREIGN KEY (`satuan_beli`) REFERENCES `satuan` (`id_satuan`),
  CONSTRAINT `fk_satuan_stok` FOREIGN KEY (`satuan_stok`) REFERENCES `satuan` (`id_satuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bahan_baku` (`id_bahan_baku`, `nama_bahan_baku`, `stok`, `satuan_stok`, `satuan_beli`, `konversi`, `harga_beli`, `harga_average`) VALUES
('B001',	'Milk Flavour Powder',	7770.00,	'GR',	'KG',	1000.00,	200.00,	194.71),
('B002',	'Butter Flavour Powder',	972.00,	'GR',	'KG',	1000.00,	185.50,	185.50),
('B003',	'Egg Mlik Flavour Powder',	1000.00,	'GR',	'KG',	1000.00,	185.50,	185.50),
('B004',	'Coconut Flavour Powder',	1000.00,	'GR',	'KG',	1000.00,	185.50,	185.50),
('B005',	'Cream Cheese Flavour Powder',	1000.00,	'GR',	'KG',	1000.00,	185.50,	185.50),
('B006',	'Green Tea Flavour Powder',	1000.00,	'GR',	'KG',	1000.00,	338.00,	338.00),
('B007',	'Black Tea Flavour Powder',	970.00,	'GR',	'KG',	1000.00,	271.00,	271.00),
('B008',	'Fresh Mlik Flavour Powder',	1000.00,	'GR',	'KG',	1000.00,	59.00,	59.00),
('B009',	'Vanilla Flavour Powder',	972.00,	'GR',	'KG',	1000.00,	69.00,	69.00),
('B010',	'Orange Flavoured Oil',	1000.00,	'GR',	'KG',	1000.00,	202.00,	202.00),
('B011',	'Egg Milk Flavoured Oil',	5000.00,	'GR',	'KG',	1000.00,	32.00,	32.00),
('B012',	'Coffee Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B013',	'Chocolate Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B014',	'Blueberry Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B015',	'Peach Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B016',	'Red Apple Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B017',	'Kiwi Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B018',	'Cantaloupe Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	71.00,	71.00),
('B019',	'Taro Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	71.00,	71.00),
('B020',	'Strawberry Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B021',	'Banana Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B022',	'Mango Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B023',	'Cheese Flavour Powder',	1000.00,	'GR',	'KG',	1000.00,	185.50,	185.50),
('B024',	'Pineapple Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B025',	'Orange Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B026',	'Lemon Flavoured Gel',	500.00,	'GR',	'KG',	1000.00,	78.00,	78.00),
('B027',	'Five Spices Seasoning Powder',	500.00,	'GR',	'KG',	1000.00,	75.00,	75.00),
('B028',	'Spicy Seasoning Powder',	500.00,	'GR',	'KG',	1000.00,	75.00,	75.00),
('B029',	'Curry Marinade Seasoning Powder',	300.00,	'GR',	'KG',	1000.00,	16.50,	16.50),
('B030',	'Shallot Seasoning Powder',	400.00,	'GR',	'KG',	1000.00,	77.50,	77.50),
('B031',	'Dried Laver Seasoning Powder',	500.00,	'GR',	'KG',	1000.00,	75.00,	75.00),
('B032',	'Cream of Tar Tar Powder',	1000.00,	'GR',	'KG',	1000.00,	62.50,	62.50),
('B033',	'Baking Powder',	1000.00,	'GR',	'KG',	1000.00,	20.00,	20.00),
('B034',	'Instant Jelly Powder',	1000.00,	'GR',	'KG',	1000.00,	94.00,	94.00),
('B035',	'Instant Custard Powder',	5000.00,	'GR',	'KG',	1000.00,	33.00,	33.00),
('B036',	'Instant Pudding Powder',	1000.00,	'GR',	'KG',	1000.00,	62.50,	62.50),
('B037',	'Taros Powder',	1000.00,	'GR',	'KG',	1000.00,	73.00,	73.00),
('B038',	'Snowy Moon Cake Powder',	2000.00,	'GR',	'KG',	1000.00,	41.75,	41.75),
('B039',	'Bread Yeast Improver Powder',	340.00,	'GR',	'KG',	1000.00,	34.00,	34.00),
('B040',	'Improver',	1000.00,	'GR',	'KG',	1000.00,	37.50,	37.50),
('B041',	'Lemon Filling',	7000.00,	'GR',	'KG',	1000.00,	39.00,	39.00),
('B042',	'Blueberry Filling',	6000.00,	'GR',	'KG',	1000.00,	40.00,	40.00),
('B043',	'Orange Filling',	6000.00,	'GR',	'KG',	1000.00,	39.00,	39.00),
('B044',	'Strawberry Filling',	6000.00,	'GR',	'KG',	1000.00,	40.00,	40.00),
('B045',	'Apricot Filling',	6000.00,	'GR',	'KG',	1000.00,	40.00,	40.00),
('B046',	'Dark Cherry Filling',	6000.00,	'GR',	'KG',	1000.00,	40.00,	40.00),
('B047',	'Red Cherry Filling',	6000.00,	'GR',	'KG',	1000.00,	40.00,	40.00),
('B048',	'Raspberry filling',	6000.00,	'GR',	'KG',	1000.00,	43.00,	43.00),
('B049',	'Lemon Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B050',	'Cantaloupe Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B051',	'Orange Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B052',	'Strawberry Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B053',	'Diaphanous Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B054',	'Grape Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B055',	'Chocolate Crystal Topping',	2970.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B056',	'Blueberry Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B057',	'Banana Crystal Topping',	3000.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B058',	'Dark Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B059',	'White Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B060',	'Lemon Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B061',	'Dark Black Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B062',	'Strawberry Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B063',	'Taro Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B064',	'Orange Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B065',	'Cantaloupe Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B066',	'Lavender Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B067',	'Peanut Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B068',	'Pink Rose Baking Chocolate',	1000.00,	'GR',	'KG',	1000.00,	46.50,	46.50),
('B069',	'Pattern & Piping Chocolate',	1000.00,	'GR',	'KG',	1000.00,	54.00,	54.00),
('B070',	'Filling Chocolate',	5000.00,	'GR',	'KG',	1000.00,	29.00,	29.00),
('B071',	'Bean Chocolate',	1000.00,	'GR',	'KG',	1000.00,	58.50,	58.50),
('B072',	'Dehydrated Shallot',	400.00,	'GR',	'KG',	1000.00,	45.00,	45.00),
('B073',	'Gelatine Powder',	1000.00,	'GR',	'KG',	1000.00,	118.00,	118.00),
('B074',	'Peanut Butter Salty/Sweet',	3000.00,	'GR',	'KG',	1000.00,	38.00,	38.00),
('B075',	'Coldgeli Neutral',	7000.00,	'GR',	'KG',	1000.00,	34.00,	34.00),
('B076',	'Mocca Coffee Gel',	1000.00,	'GR',	'KG',	1000.00,	145.00,	145.00),
('B077',	'Beef Floss',	1000.00,	'GR',	'KG',	1000.00,	81.00,	81.00),
('B078',	'Beef Floss Spicy',	1000.00,	'GR',	'KG',	1000.00,	89.00,	89.00),
('B079',	'Chicken Floss ',	1000.00,	'GR',	'KG',	1000.00,	81.00,	81.00),
('B080',	'Chicken Floss Spicy',	1000.00,	'GR',	'KG',	1000.00,	89.00,	89.00),
('B081',	'Chocineal Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B082',	'Orange Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B083',	'Pink Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B084',	'Blue Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B085',	'Indigo Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B086',	'Mauve Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B087',	'Green Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B088',	'Deep Yellow Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B089',	'Light Yellow Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B090',	'Chocolate Brown Colouring',	100.00,	'GR',	'KG',	1000.00,	265.00,	265.00),
('B091',	'Strawberry Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B092',	'Grape Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B093',	'Orange Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B094',	'Lemon Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B095',	'Apple Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B096',	'Green Tea Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B097',	'Blueberry Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B098',	'Chocolate Dusting Powder',	60.00,	'GR',	'KG',	1000.00,	325.00,	325.00),
('B099',	'White Lotus Seed',	5000.00,	'GR',	'KG',	1000.00,	54.00,	54.00),
('B100',	'Red Lotus Seed',	5000.00,	'GR',	'KG',	1000.00,	51.00,	51.00),
('B101',	'White Sweetened Bean',	5000.00,	'GR',	'KG',	1000.00,	49.00,	49.00),
('B102',	'Red Sweetened Bean',	5000.00,	'GR',	'KG',	1000.00,	31.00,	31.00),
('B103',	'Strawberry',	5000.00,	'GR',	'KG',	1000.00,	46.00,	46.00),
('B104',	'Orange',	5000.00,	'GR',	'KG',	1000.00,	46.00,	46.00),
('B105',	'Pineaple',	5000.00,	'GR',	'KG',	1000.00,	46.00,	46.00),
('B106',	'Pineapple & Granule',	5000.00,	'GR',	'KG',	1000.00,	46.00,	46.00),
('B107',	'Kiwi',	5000.00,	'GR',	'KG',	1000.00,	42.00,	42.00),
('B108',	'Mango',	5000.00,	'GR',	'KG',	1000.00,	46.00,	46.00),
('B109',	'Pumpkin',	5000.00,	'GR',	'KG',	1000.00,	42.00,	42.00),
('B110',	'Green Tea',	5000.00,	'GR',	'KG',	1000.00,	46.00,	46.00),
('B111',	'Cantaloupe',	5000.00,	'GR',	'KG',	1000.00,	42.00,	42.00),
('B112',	'Terigu Cakra',	22620.00,	'GR',	'KG',	1000.00,	4.00,	4.00),
('B113',	'Terigu Segitiga Biru',	25000.00,	'GR',	'KG',	1000.00,	3.00,	3.00),
('B114',	'Yeast ZAF',	480.00,	'GR',	'KG',	1000.00,	44.00,	44.00),
('B115',	'Margarine Palmia',	17750.00,	'GR',	'KG',	1000.00,	17.00,	17.00),
('B116',	'Margarine Gold Bullion',	14800.00,	'GR',	'KG',	1000.00,	10.00,	10.00),
('B117',	'Margarine Blue Band',	14510.00,	'GR',	'KG',	1000.00,	9.00,	9.00),
('B118',	'Susu Bubuk Indomilk',	24840.00,	'GR',	'KG',	1000.00,	32.00,	32.00),
('B119',	'Garam',	4970.00,	'GR',	'KG',	1000.00,	3.00,	3.00),
('B120',	'Gula Pasir',	48556.00,	'GR',	'KG',	1000.00,	6.00,	6.00),
('B121',	'Gula Halus',	49194.00,	'GR',	'KG',	1000.00,	6.00,	6.00),
('B122',	'Telur',	4600.00,	'GR',	'KG',	1000.00,	7.00,	7.00),
('B123',	'Instant Patato Mix',	3000.00,	'GR',	'KG',	1000.00,	58.00,	58.00),
('B124',	'Instant Fruit Mix',	3000.00,	'GR',	'KG',	1000.00,	58.00,	58.00),
('B125',	'Instant Crystal Mix',	3000.00,	'GR',	'KG',	1000.00,	58.00,	58.00),
('B126',	'Salad Oil',	4800.00,	'GR',	'LTR',	1000.00,	21.00,	21.00),
('B127',	'Tes',	1000.00,	'GR',	'KG',	1000.00,	50000.00,	50000.00),
('B128',	'Tes 2',	1000.00,	'GR',	'KG',	1000.00,	60000.00,	60.00);

DROP TABLE IF EXISTS `detail_pembelian`;
CREATE TABLE `detail_pembelian` (
  `id_pembelian` varchar(10) NOT NULL,
  `id_bahan_baku` varchar(10) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  `jumlah_diretur` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_pembelian`,`id_bahan_baku`),
  KEY `id_bahan_baku` (`id_bahan_baku`),
  CONSTRAINT `detail_pembelian_ibfk_1` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`),
  CONSTRAINT `detail_pembelian_ibfk_2` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `detail_pembelian` (`id_pembelian`, `id_bahan_baku`, `jumlah`, `harga`, `subtotal`, `jumlah_diretur`) VALUES
('PB00001',	'B001',	1.00,	185500.00,	185500.00,	0.00),
('PB00001',	'B002',	1.00,	185500.00,	185500.00,	0.00),
('PB00001',	'B003',	1.00,	185500.00,	185500.00,	0.00),
('PB00001',	'B004',	1.00,	185500.00,	185500.00,	0.00),
('PB00001',	'B005',	1.00,	185500.00,	185500.00,	0.00),
('PB00001',	'B023',	1.00,	185500.00,	185500.00,	0.00),
('PB00002',	'B006',	1.00,	338000.00,	338000.00,	0.00),
('PB00003',	'B001',	2.00,	185000.00,	370000.00,	0.00),
('PB00004',	'B001',	5.00,	200000.00,	1000000.00,	0.00),
('PB00005',	'B127',	1.00,	50000.00,	50000.00,	0.00),
('PB00006',	'B128',	1.00,	60000.00,	60000.00,	0.00);

DROP TABLE IF EXISTS `detail_pemesanan_bahan`;
CREATE TABLE `detail_pemesanan_bahan` (
  `id_pemesanan_bahan` varchar(10) NOT NULL,
  `id_bahan_baku` varchar(10) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  PRIMARY KEY (`id_pemesanan_bahan`,`id_bahan_baku`),
  KEY `id_bahan_baku` (`id_bahan_baku`),
  CONSTRAINT `detail_pemesanan_bahan_ibfk_1` FOREIGN KEY (`id_pemesanan_bahan`) REFERENCES `pemesanan_bahan` (`id_pemesanan_bahan`),
  CONSTRAINT `detail_pemesanan_bahan_ibfk_2` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `detail_pemesanan_bahan` (`id_pemesanan_bahan`, `id_bahan_baku`, `jumlah`, `harga`, `subtotal`) VALUES
('PS00001',	'B001',	1.00,	185500.00,	185500.00),
('PS00001',	'B002',	1.00,	185500.00,	185500.00),
('PS00001',	'B003',	1.00,	185500.00,	185500.00),
('PS00001',	'B004',	1.00,	185500.00,	185500.00),
('PS00001',	'B005',	1.00,	185500.00,	185500.00),
('PS00001',	'B023',	1.00,	185500.00,	185500.00),
('PS00002',	'B006',	1.00,	338000.00,	338000.00),
('PS00003',	'B001',	2.00,	185000.00,	370000.00),
('PS00004',	'B001',	5.00,	200000.00,	1000000.00),
('PS00005',	'B127',	1.00,	50000.00,	50000.00),
('PS00006',	'B128',	1.00,	60000.00,	60000.00);

DROP TABLE IF EXISTS `detail_produksi`;
CREATE TABLE `detail_produksi` (
  `id_detail_produksi` varchar(10) NOT NULL,
  `id_produksi` varchar(10) NOT NULL,
  `id_roti` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_bahan_baku` decimal(18,2) NOT NULL,
  `total_overhead` decimal(18,2) NOT NULL,
  `total_hpp` decimal(18,2) NOT NULL,
  PRIMARY KEY (`id_detail_produksi`),
  KEY `id_produksi` (`id_produksi`),
  KEY `id_roti` (`id_roti`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `detail_produksi` (`id_detail_produksi`, `id_produksi`, `id_roti`, `jumlah`, `total_bahan_baku`, `total_overhead`, `total_hpp`) VALUES
('PR00001',	'PR00001',	'R002',	10,	20113.40,	3550.00,	23663.40),
('PR00002',	'PR00002',	'R004',	10,	22261.70,	4100.00,	26361.70),
('PR00003',	'PR00003',	'R006',	20,	88484.00,	7100.00,	95584.00);

DROP TABLE IF EXISTS `detail_produksi_bahan_baku`;
CREATE TABLE `detail_produksi_bahan_baku` (
  `id_detail_produksi_bahan_baku` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_produksi` varchar(10) NOT NULL,
  `id_bahan_baku` varchar(10) NOT NULL,
  `jumlah_bahan_baku` decimal(10,2) NOT NULL,
  `harga_bahan_baku` decimal(18,2) NOT NULL,
  `sub_total_bahan_baku` decimal(18,2) NOT NULL,
  PRIMARY KEY (`id_detail_produksi_bahan_baku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `detail_produksi_bahan_baku` (`id_detail_produksi_bahan_baku`, `id_detail_produksi`, `id_bahan_baku`, `jumlah_bahan_baku`, `harga_bahan_baku`, `sub_total_bahan_baku`) VALUES
(38,	'PR00001',	'B001',	20.00,	185.17,	3703.40),
(39,	'PR00001',	'B039',	10.00,	34.00,	340.00),
(40,	'PR00001',	'B112',	1250.00,	4.00,	5000.00),
(41,	'PR00001',	'B114',	20.00,	44.00,	880.00),
(42,	'PR00001',	'B118',	100.00,	32.00,	3200.00),
(43,	'PR00001',	'B119',	30.00,	3.00,	90.00),
(44,	'PR00001',	'B120',	450.00,	6.00,	2700.00),
(45,	'PR00001',	'B122',	600.00,	7.00,	4200.00),
(46,	'PR00002',	'B001',	10.00,	185.17,	1851.70),
(47,	'PR00002',	'B007',	30.00,	271.00,	8130.00),
(48,	'PR00002',	'B055',	30.00,	17.00,	510.00),
(49,	'PR00002',	'B112',	130.00,	4.00,	520.00),
(50,	'PR00002',	'B115',	250.00,	17.00,	4250.00),
(51,	'PR00002',	'B116',	200.00,	10.00,	2000.00),
(52,	'PR00002',	'B118',	60.00,	32.00,	1920.00),
(53,	'PR00002',	'B121',	280.00,	6.00,	1680.00),
(54,	'PR00002',	'B122',	200.00,	7.00,	1400.00),
(55,	'PR00003',	'B001',	200.00,	185.17,	37034.00),
(56,	'PR00003',	'B029',	200.00,	16.50,	3300.00),
(57,	'PR00003',	'B030',	100.00,	77.50,	7750.00),
(58,	'PR00003',	'B072',	600.00,	45.00,	27000.00),
(59,	'PR00003',	'B112',	1000.00,	4.00,	4000.00),
(60,	'PR00003',	'B121',	400.00,	6.00,	2400.00),
(61,	'PR00003',	'B122',	400.00,	7.00,	2800.00),
(62,	'PR00003',	'B126',	200.00,	21.00,	4200.00);

DROP TABLE IF EXISTS `detail_produksi_overhead`;
CREATE TABLE `detail_produksi_overhead` (
  `id_detail_produksi_overhead` int(11) NOT NULL AUTO_INCREMENT,
  `id_overhead` varchar(10) NOT NULL,
  `jumlah_overhead` decimal(10,2) NOT NULL,
  `harga_overhead` decimal(18,2) NOT NULL,
  `sub_total_overhead` decimal(18,2) NOT NULL,
  `id_detail_produksi` varchar(10) NOT NULL,
  PRIMARY KEY (`id_detail_produksi_overhead`),
  UNIQUE KEY `fk_detail_overhead_produksi2` (`id_detail_produksi`),
  KEY `fk_detail_overhead_produksi` (`id_overhead`),
  CONSTRAINT `detail_produksi_overhead_ibfk_1` FOREIGN KEY (`id_detail_produksi`) REFERENCES `detail_produksi` (`id_detail_produksi`),
  CONSTRAINT `detail_produksi_overhead_ibfk_2` FOREIGN KEY (`id_overhead`) REFERENCES `overhead` (`id_overhead`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `detail_produksi_overhead` (`id_detail_produksi_overhead`, `id_overhead`, `jumlah_overhead`, `harga_overhead`, `sub_total_overhead`, `id_detail_produksi`) VALUES
(8,	'O0002',	10.00,	300.00,	3000.00,	'PR00001'),
(10,	'O0002',	10.00,	300.00,	3000.00,	'PR00002'),
(12,	'O0002',	20.00,	300.00,	6000.00,	'PR00003');

DROP TABLE IF EXISTS `detail_retur_pembelian`;
CREATE TABLE `detail_retur_pembelian` (
  `id_retur_pembelian` varchar(10) NOT NULL,
  `id_bahan_baku` varchar(10) NOT NULL,
  `jumlah_retur` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_retur_pembelian`,`id_bahan_baku`),
  KEY `id_bahan_baku` (`id_bahan_baku`),
  CONSTRAINT `detail_retur_pembelian_ibfk_1` FOREIGN KEY (`id_retur_pembelian`) REFERENCES `retur_pembelian` (`id_retur_pembelian`),
  CONSTRAINT `detail_retur_pembelian_ibfk_2` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `konversi_satuan`;
CREATE TABLE `konversi_satuan` (
  `id_konversi` int(11) NOT NULL AUTO_INCREMENT,
  `satuan_stok` varchar(10) NOT NULL,
  `satuan_beli` varchar(10) NOT NULL,
  `konversi` int(11) NOT NULL,
  PRIMARY KEY (`id_konversi`),
  KEY `fk_satuan_beli` (`satuan_beli`),
  KEY `fk_satuan_stok` (`satuan_stok`) USING BTREE,
  CONSTRAINT `konversi_satuan_ibfk_1` FOREIGN KEY (`satuan_stok`) REFERENCES `satuan` (`id_satuan`),
  CONSTRAINT `konversi_satuan_ibfk_2` FOREIGN KEY (`satuan_beli`) REFERENCES `satuan` (`id_satuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `konversi_satuan` (`id_konversi`, `satuan_stok`, `satuan_beli`, `konversi`) VALUES
(1,	'GR',	'KG',	1000),
(2,	'GR',	'LTR',	1000),
(3,	'GR',	'GR',	1),
(4,	'KG',	'KG',	1),
(5,	'LTR',	'LTR',	1);

DROP TABLE IF EXISTS `overhead`;
CREATE TABLE `overhead` (
  `id_overhead` varchar(10) NOT NULL,
  `nama_overhead` varchar(50) NOT NULL,
  `biaya_overhead` decimal(18,2) NOT NULL,
  `satuan_overhead` varchar(30) NOT NULL,
  PRIMARY KEY (`id_overhead`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `overhead` (`id_overhead`, `nama_overhead`, `biaya_overhead`, `satuan_overhead`) VALUES
('O0001',	'Listrik',	1.10,	'watt'),
('O0002',	'Plastik',	300.00,	'Plastik'),
('O0003',	'Elpiji',	120.00,	'Session');

DROP TABLE IF EXISTS `pembayaran_hutang`;
CREATE TABLE `pembayaran_hutang` (
  `id_pembayaran_hutang` varchar(10) NOT NULL,
  `tanggal_pembayaran_hutang` date NOT NULL,
  `id_pembelian` varchar(10) NOT NULL,
  `jumlah_pembayaran` decimal(18,2) NOT NULL,
  PRIMARY KEY (`id_pembayaran_hutang`),
  KEY `fk_pembeuyaran` (`id_pembelian`),
  CONSTRAINT `pembayaran_hutang_ibfk_1` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian` (
  `id_pembelian` varchar(10) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `id_supplier` varchar(10) NOT NULL,
  `id_pemesanan_bahan` varchar(10) DEFAULT NULL,
  `total` decimal(18,2) NOT NULL,
  `jenis_pembayaran` varchar(30) NOT NULL,
  `dibayar` decimal(18,2) NOT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `id_pengguna` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pembelian`),
  KEY `fk_pembelian_supplier` (`id_supplier`),
  KEY `fk_pembelian_pemesanan` (`id_pemesanan_bahan`),
  KEY `fk_pembelian_pengguna` (`id_pengguna`),
  CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_pemesanan_bahan`) REFERENCES `pemesanan_bahan` (`id_pemesanan_bahan`),
  CONSTRAINT `pembelian_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pembelian` (`id_pembelian`, `tanggal_pembelian`, `id_supplier`, `id_pemesanan_bahan`, `total`, `jenis_pembayaran`, `dibayar`, `tanggal_jatuh_tempo`, `id_pengguna`) VALUES
('PB00001',	'2016-02-01',	'S0002',	'PS00001',	1113000.00,	'Tunai',	1113000.00,	'2016-02-01',	'manajer'),
('PB00002',	'2016-02-01',	'S0002',	'PS00002',	338000.00,	'Tunai',	338000.00,	'2016-02-01',	'manajer'),
('PB00003',	'2016-02-01',	'S0001',	'PS00003',	370000.00,	'Tunai',	370000.00,	'2016-02-01',	'manajer'),
('PB00004',	'2016-02-03',	'S0001',	'PS00004',	1000000.00,	'Tunai',	1000000.00,	'2016-02-03',	'manajer'),
('PB00005',	'2016-02-03',	'S0002',	'PS00005',	50000.00,	'Tunai',	50000.00,	'2016-02-03',	'manajer'),
('PB00006',	'2016-02-03',	'S0002',	'PS00006',	60000.00,	'Tunai',	60000.00,	'2016-02-03',	'manajer');

DROP TABLE IF EXISTS `pemesanan_bahan`;
CREATE TABLE `pemesanan_bahan` (
  `id_pemesanan_bahan` varchar(10) NOT NULL,
  `tanggal_pemesanan_bahan` date NOT NULL,
  `id_supplier` varchar(10) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `status_pemesanan_bahan` varchar(30) NOT NULL,
  PRIMARY KEY (`id_pemesanan_bahan`),
  KEY `fk_pemesanan_bahan` (`id_supplier`),
  CONSTRAINT `pemesanan_bahan_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pemesanan_bahan` (`id_pemesanan_bahan`, `tanggal_pemesanan_bahan`, `id_supplier`, `total`, `status_pemesanan_bahan`) VALUES
('PS00001',	'2016-02-01',	'S0002',	1113000.00,	'Finish'),
('PS00002',	'2016-02-01',	'S0002',	338000.00,	'Finish'),
('PS00003',	'2016-02-01',	'S0001',	370000.00,	'Finish'),
('PS00004',	'2016-02-03',	'S0001',	1000000.00,	'Finish'),
('PS00005',	'2016-02-03',	'S0002',	50000.00,	'Finish'),
('PS00006',	'2016-02-03',	'S0002',	60000.00,	'Finish');

DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna` (
  `id_pengguna` varchar(50) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `jenis_pengguna` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `password`, `jenis_pengguna`) VALUES
('manajer',	'david',	'123',	'manajer'),
('supervisor',	'david k',	'123',	'supervisor');

DROP TABLE IF EXISTS `penyesuaian_stok`;
CREATE TABLE `penyesuaian_stok` (
  `id_penyesuaian_stok` varchar(10) NOT NULL,
  `id_bahan_baku` varchar(10) NOT NULL,
  `tanggal_penyesuaian_stok` date NOT NULL,
  `jumlah_penyesuaian` decimal(10,2) NOT NULL,
  `id_pengguna` varchar(10) NOT NULL,
  PRIMARY KEY (`id_penyesuaian_stok`),
  KEY `fk_penyesuaian_bahan` (`id_bahan_baku`),
  KEY `fk_penyesuaian_pengguna` (`id_pengguna`) USING BTREE,
  CONSTRAINT `penyesuaian_stok_ibfk_1` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`),
  CONSTRAINT `penyesuaian_stok_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `produksi`;
CREATE TABLE `produksi` (
  `id_produksi` varchar(10) NOT NULL,
  `tanggal_produksi` date NOT NULL,
  `status_produksi` varchar(30) NOT NULL,
  `id_pengguna` varchar(50) NOT NULL,
  PRIMARY KEY (`id_produksi`),
  KEY `fk_produksi_pengguna` (`id_pengguna`) USING BTREE,
  CONSTRAINT `produksi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `produksi` (`id_produksi`, `tanggal_produksi`, `status_produksi`, `id_pengguna`) VALUES
('PR00001',	'2016-02-01',	'Finish',	'manajer'),
('PR00002',	'2016-02-01',	'Finish',	'manajer'),
('PR00003',	'2016-02-01',	'Finish',	'manajer');

DROP TABLE IF EXISTS `retur_pembelian`;
CREATE TABLE `retur_pembelian` (
  `id_retur_pembelian` varchar(10) NOT NULL,
  `tanggal_retur_pembelian` date NOT NULL,
  `id_pembelian` varchar(10) NOT NULL,
  `status_retur` varchar(30) NOT NULL,
  PRIMARY KEY (`id_retur_pembelian`),
  KEY `fk_retur_pembelian` (`id_pembelian`),
  CONSTRAINT `retur_pembelian_ibfk_1` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `roti`;
CREATE TABLE `roti` (
  `id_roti` varchar(10) NOT NULL,
  `nama_roti` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_roti`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `roti` (`id_roti`, `nama_roti`, `stok`, `harga_jual`) VALUES
('R001',	'Cinnamon',	14,	5000.00),
('R002',	'Roti Tawar',	10,	8000.00),
('R003',	'Muffin Choco Bean',	0,	6000.00),
('R004',	'Black Tea Long Pastry',	10,	6000.00),
('R005',	'Polo Black & White',	0,	5000.00),
('R006',	'Green Garden',	20,	5000.00);

DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan` (
  `id_satuan` varchar(10) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_satuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
('GR',	'Gram'),
('KG',	'Kilogram'),
('LTR',	'Liter');

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id_supplier` varchar(10) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat_supplier` varchar(100) NOT NULL,
  `telp_supplier` varchar(30) NOT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`, `telp_supplier`) VALUES
('S0001',	'Budi H',	'Jakarta',	'021323232'),
('S0002',	'Erna',	'Jakarta',	'02132429');

-- 2016-12-22 02:12:49
