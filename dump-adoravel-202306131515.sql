-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: adoravel
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `detail_transactions`
--

LOCK TABLES `detail_transactions` WRITE;
/*!40000 ALTER TABLE `detail_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (39,'Raka','Pramu',1,2,'raka@gmail.com','Kudus','081249746464',20000,'2023-06-12','2023-06-11 16:12:33','2023-06-11 16:12:33');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genders`
--

LOCK TABLES `genders` WRITE;
/*!40000 ALTER TABLE `genders` DISABLE KEYS */;
INSERT INTO `genders` VALUES (1,'Laki-laki','2023-06-10 00:48:23','2023-06-10 00:48:23'),(2,'Perempuan','2023-06-10 00:48:23','2023-06-10 00:48:23');
/*!40000 ALTER TABLE `genders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_06_08_202005_genders',1),(6,'2023_06_08_202006_pet_owner',1),(7,'2023_06_10_054122_type_pet',1),(8,'2023_06_10_054224_pet_registration',1),(9,'2023_06_10_062036_employees',1),(10,'2023_06_10_063701_service_type',1),(11,'2023_06_10_063703_service_prices',1),(12,'2023_06_10_063759_pet_food',1),(13,'2023_06_10_063760_pet_food_prices',1),(14,'2023_06_10_063906_transaction',1),(15,'2023_06_10_070418_detail_transactions',1),(16,'2023_06_10_081246_food_price_column',2),(17,'2023_06_10_081335_service_price_column',2),(18,'2023_06_10_180423_positions',3),(19,'2023_06_11_215714_create_transaction_methods_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pet_food_prices`
--

LOCK TABLES `pet_food_prices` WRITE;
/*!40000 ALTER TABLE `pet_food_prices` DISABLE KEYS */;
INSERT INTO `pet_food_prices` VALUES (8,1,45000,'2023-06-12 05:03:23','2023-06-12 05:03:23');
/*!40000 ALTER TABLE `pet_food_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pet_foods`
--

LOCK TABLES `pet_foods` WRITE;
/*!40000 ALTER TABLE `pet_foods` DISABLE KEYS */;
INSERT INTO `pet_foods` VALUES (1,'Tuna Delight','Meow Mix','A delicious blend of tuna and other seafood flavors that cats adore.','2023-06-11 04:05:44','2023-06-11 04:05:44'),(2,'Chicken Feast','Whiskas','Tender chicken morsels in a savory gravy, providing complete and balanced nutrition for cats.','2023-06-11 04:05:44','2023-06-11 04:05:44'),(3,'Beefy Bites','Pedigree','Hearty beef-flavored kibble packed with essential nutrients for dogs of all sizes.','2023-06-11 04:05:45','2023-06-11 04:05:45'),(4,'Chicken and Rice Formula','Blue Buffalo','A nutritious blend of chicken and brown rice, promoting healthy digestion and immune system.','2023-06-11 04:05:45','2023-06-11 04:05:45');
/*!40000 ALTER TABLE `pet_foods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pet_owners`
--

LOCK TABLES `pet_owners` WRITE;
/*!40000 ALTER TABLE `pet_owners` DISABLE KEYS */;
INSERT INTO `pet_owners` VALUES (30,'Reynaldi','Rizky',1,'rizkypratama471@gmail.com','Surabaya','081249746464','081249746461','2023-06-11 16:12:59','2023-06-11 16:12:59');
/*!40000 ALTER TABLE `pet_owners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pet_registrations`
--

LOCK TABLES `pet_registrations` WRITE;
/*!40000 ALTER TABLE `pet_registrations` DISABLE KEYS */;
INSERT INTO `pet_registrations` VALUES (15,30,'Bobo',1,'2023-06-12 02:27:35','2023-06-12 02:27:35');
/*!40000 ALTER TABLE `pet_registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pet_types`
--

LOCK TABLES `pet_types` WRITE;
/*!40000 ALTER TABLE `pet_types` DISABLE KEYS */;
INSERT INTO `pet_types` VALUES (1,'anjing','2023-06-10 22:02:03','2023-06-10 22:02:03'),(2,'kucing','2023-06-10 22:02:03','2023-06-10 22:02:03');
/*!40000 ALTER TABLE `pet_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'admin','2023-06-10 11:18:10','2023-06-10 11:18:10'),(2,'marketing','2023-06-10 11:18:10','2023-06-10 11:18:10'),(3,'ceo','2023-06-10 11:23:50','2023-06-10 11:23:50');
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `service_prices`
--

LOCK TABLES `service_prices` WRITE;
/*!40000 ALTER TABLE `service_prices` DISABLE KEYS */;
INSERT INTO `service_prices` VALUES (8,2,50000,'2023-06-12 05:03:07','2023-06-12 05:03:07');
/*!40000 ALTER TABLE `service_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `service_types`
--

LOCK TABLES `service_types` WRITE;
/*!40000 ALTER TABLE `service_types` DISABLE KEYS */;
INSERT INTO `service_types` VALUES (1,'Grooming','Professional grooming services to keep your pets clean, healthy, and looking their best.','2023-06-11 04:10:13','2023-06-11 04:10:13'),(2,'Boarding','Safe and comfortable boarding facilities for pets when owners are away or unable to care for them.','2023-06-11 04:10:13','2023-06-11 04:10:13'),(3,'Training','Training programs to teach pets essential obedience commands and correct behavioral issues.','2023-06-11 04:10:13','2023-06-11 04:10:13'),(4,'Veterinary Care','Comprehensive medical care, including check-ups, vaccinations, and treatment for pets.','2023-06-11 04:10:13','2023-06-11 04:10:13'),(5,'Dog Walking','Regular exercise and walking services to keep dogs healthy, active, and stimulated.','2023-06-11 04:10:13','2023-06-11 04:10:13');
/*!40000 ALTER TABLE `service_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `transaction_methods`
--

LOCK TABLES `transaction_methods` WRITE;
/*!40000 ALTER TABLE `transaction_methods` DISABLE KEYS */;
INSERT INTO `transaction_methods` VALUES (1,'Cash','2023-06-11 16:09:53','2023-06-11 16:09:53'),(2,'Credit Card','2023-06-11 16:09:53','2023-06-11 16:09:53'),(3,'Debit Card','2023-06-11 16:09:53','2023-06-11 16:09:53');
/*!40000 ALTER TABLE `transaction_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (18,30,39,8,15,1,'2023-06-02','2023-06-12 05:20:43','2023-06-12 05:25:47');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'uadmin','uadmin@gmail.com',NULL,'$2y$10$DoDlRD5Tk.otiKZXwwQ2tO/XnWuckTiNEP/Iwc/KBsiC0RZPFIVZq',NULL,'2023-06-10 00:23:21','2023-06-10 00:23:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-13 15:15:35
