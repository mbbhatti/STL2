/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Data for the table `answer` */
TRUNCATE `answer`;
insert  into `answer`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`answer`,`answer_id`,`cycle`,`day`,`user`,`study`,`app_version`) values (1,'2018-01-08 14:03:54','2018-01-16 13:11:35',NULL,1,'22','1000',0,NULL,342,1,'Version 1.0 (112)'),(93,'2018-01-09 07:32:16','2018-01-09 08:56:18',NULL,2,'Jan 9, 2018','7000',2,NULL,341,1,'Version 1.0 (108)'),(100,'2018-01-11 09:13:36','2018-01-16 15:36:46',NULL,1,'7','2070',0,NULL,347,1,'Version 1.0 (112)'),(106,'2018-01-11 10:27:36','2018-01-11 10:36:27',NULL,1,'4','2010',0,NULL,343,1,'Version 1.0 (110)'),(110,'2018-01-11 10:38:10','2018-01-11 10:38:10',NULL,0,'4','2010',0,NULL,348,1,'Version 1.0 (110)'),(114,'2018-01-11 10:47:25','2018-01-11 10:47:25',NULL,0,'4','2010',0,NULL,349,1,'Version 1.0 (110)'),(1001,'2019-02-04 16:32:22','2019-02-04 16:32:22',NULL,0,'10','6071',1,-5,723,1,'Version 1.0.1 (121)'),(1930,'2020-01-13 14:53:12','2020-01-13 14:53:12',NULL,0,'0','2030',1,1,951,1,'Version 1.0.1 (145)');

/*Data for the table `choice` */
TRUNCATE `choice`;
insert  into `choice`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`name`,`text`,`order`,`type`,`answer_id`,`answer_value`,`meta_question`,`min`,`max`,`default`) values (1,'2017-03-02 14:51:10','2017-03-31 16:33:45',NULL,1,'1010_1','your.size',0,'bmi_size',NULL,NULL,1,140,200,NULL),(2,'2017-03-02 14:51:11','2017-03-31 16:33:55',NULL,1,'1010_2','your.weight',100,'bmi_weight',NULL,NULL,NULL,40,110,NULL),(3,'2017-03-02 14:51:14','2017-03-31 15:00:17',NULL,2,'1011_1','high.school.or.above',100,'choice',NULL,'1',NULL,NULL,NULL,NULL),(4,'2017-03-02 14:55:20','2017-03-31 15:00:29',NULL,2,'1011_2','other',200,'choice',NULL,'2',NULL,NULL,NULL,NULL),(5,'2017-03-02 15:14:47','2017-03-02 15:14:47',NULL,0,'2020','stomach.cramps',100,'choice','2020','1',NULL,NULL,NULL,NULL),(6,'2017-03-02 15:15:13','2017-03-02 15:15:13',NULL,0,'2021','general.pain.in.lower.belly',200,'choice','2021','1',NULL,NULL,NULL,NULL),(7,'2017-03-02 15:15:55','2017-03-02 15:15:55',NULL,0,'2022','lower.back.pain',300,'choice','2022','1',NULL,NULL,NULL,NULL),(8,'2017-03-02 15:16:24','2017-03-02 15:16:24',NULL,0,'2023','headache',400,'choice','2023','1',NULL,NULL,NULL,NULL),(9,'2017-03-02 15:16:50','2017-03-02 15:16:50',NULL,0,'2024','nausea.vomiting',500,'choice','2024','1',NULL,NULL,NULL,NULL),(10,'2017-03-02 15:18:20','2017-03-31 15:01:33',NULL,4,'2025','other.symptoms',600,'choice','2025','1',NULL,NULL,NULL,NULL);

/*Data for the table `choice_question` */
TRUNCATE `choice_question`;
insert  into `choice_question`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`meta_question`,`type`,`answer_id`) values (1,'2017-01-27 12:04:40','2017-03-31 16:34:00',NULL,3,2,'bmi','1010'),(2,'2017-01-27 12:04:48','2017-03-31 15:00:00',NULL,3,3,'radio','1011'),(3,'2017-03-02 15:19:48','2017-07-04 15:34:07',NULL,3,6,'multiple',NULL),(4,'2017-03-03 14:15:52','2017-03-31 16:31:58',NULL,2,7,'button','2030'),(5,'2017-03-07 15:54:47','2017-03-31 14:16:49',NULL,3,8,'multiple',NULL),(6,'2017-03-17 15:39:15','2017-03-31 15:02:31',NULL,2,9,'button','2040'),(7,'2017-03-17 15:47:46','2017-05-29 08:36:55',NULL,2,10,'steps',NULL),(8,'2017-03-17 15:47:47','2017-03-17 15:47:47',NULL,1,11,'multiple',NULL),(9,'2017-03-17 15:57:15','2017-04-28 11:36:17',NULL,4,12,'list',NULL),(10,'2017-03-17 16:14:56','2017-03-31 16:36:03',NULL,1,13,'button','2050');

/*Data for the table `choice_question_choice` */
TRUNCATE `choice_question_choice`;
insert  into `choice_question_choice`(`choice_question`,`choice`) values (2,3),(2,4),(1,1),(1,2),(3,5),(3,6),(3,7),(3,8),(3,9),(3,10);

/*Data for the table `configuration` */
TRUNCATE `configuration`;
insert  into `configuration`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`key`,`value`) values (1,'2017-06-27 14:24:37','2017-07-11 10:14:05',NULL,1,'itemsWithoutDay','1000\r\n1010\r\n1011\r\n2000\r\n2010\r\n2020\r\n2021\r\n2022\r\n2023\r\n2024\r\n2025\r\n2026\r\n2040\r\n2041\r\n2042\r\n2043\r\n2044\r\n2045\r\n2046\r\n2050\r\n2051\r\n2052\r\n2070\r\n2080\r\n2100\r\n2110\r\n3000\r\n3001\r\n3002\r\n3003\r\n3004\r\n3005\r\n3006\r\n3007\r\n3008\r\n3009\r\n3010\r\n3011\r\n3012\r\n3013\r\n3020\r\n3021\r\n3022\r\n3023\r\n3024\r\n3025\r\n3026\r\n3027\r\n3028\r\n3029\r\n3030\r\n3031\r\n3032\r\n3033\r\n4000\r\n4010\r\n4011\r\n4012\r\n4013\r\n4002\r\n4020\r\n4021\r\n4022\r\n4023\r\n4003\r\n4030\r\n4031\r\n4032\r\n4033\r\n5000\r\n5010\r\n5020\r\n5021\r\n5022\r\n5023\r\n5024\r\n5030\r\n5031\r\n5040\r\n5050\r\n5051\r\n6000\r\n6010\r\n6011\r\n6020\r\n6021\r\n6030\r\n6031\r\n6040\r\n6041\r\n6050\r\n6051\r\n6060\r\n6061\r\n7000\r\n7010'),(2,'2017-06-27 14:25:30','2020-02-03 10:12:44',NULL,2,'mandatoryItems','1001\r\n2090\r\n2080\r\n2070\r\n2000\r\n2010\r\n7000'),(3,'2017-06-27 14:25:58','2017-07-24 11:06:29',NULL,1,'menstruationStart','7000'),(4,'2017-06-27 14:26:18','2017-07-24 11:06:34',NULL,1,'menstruationEnd','7010'),(5,'2017-06-27 14:26:39','2017-06-27 14:26:39',NULL,0,'pregnancy','2060'),(6,'2017-06-27 14:26:59','2017-06-27 14:26:59',NULL,0,'bmi','1010'),(7,'2017-06-27 14:27:20','2017-06-27 14:27:20',NULL,0,'height','1010_1'),(8,'2017-06-27 14:27:41','2017-06-27 14:27:41',NULL,0,'weight','1010_2'),(9,'2017-06-27 14:28:03','2017-06-27 14:28:03',NULL,0,'cycleLength','2000'),(10,'2017-06-27 14:28:22','2017-06-27 14:28:22',NULL,0,'bleedingDuration','2010');

/*Data for the table `feature` */
TRUNCATE `feature`;
insert  into `feature`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`name`) values (1,'2017-04-06 11:50:02','2017-04-06 11:50:02',NULL,0,'acupressure'),(2,'2017-04-06 11:50:15','2017-04-06 11:50:15',NULL,0,'recommendations');

/*Data for the table `free_input_question` */
TRUNCATE `free_input_question`;
insert  into `free_input_question`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`meta_question`,`text`,`type`,`answer_id`,`min`,`max`) values (1,'2017-01-26 16:17:57','2017-03-22 14:52:51',NULL,2,1,'your.age.years','integer','1000',18,34),(2,'2017-03-02 14:59:53','2017-03-22 14:53:18',NULL,2,4,'textinput.days','integer','2000',15,50),(3,'2017-03-02 15:11:51','2017-03-22 14:53:36',NULL,1,5,'textinput.days','integer','2010',NULL,10);

/*Data for the table `group` */
TRUNCATE `group`;
insert  into `group`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`name`) values (1,'2017-02-09 16:33:32','2017-04-06 11:50:53',NULL,2,'acupressure'),(2,'2017-02-09 16:33:38','2017-04-06 11:51:00',NULL,2,'recommendations'),(3,'2017-02-09 16:33:44','2017-04-06 11:51:11',NULL,2,'acupressure_recommendations');

/*Data for the table `group_configuration` */
TRUNCATE `group_configuration`;
insert  into `group_configuration`(`group`,`configuration`) values (1,5),(3,5),(2,5),(1,6),(3,6),(2,6),(1,7),(3,7),(2,7),(1,8),(3,8),(2,8),(1,9),(3,9),(2,9),(1,10),(3,10),(2,10),(1,1),(3,1),(2,1),(1,3),(3,3),(2,3),(1,4),(3,4),(2,4),(1,2),(3,2),(2,2);

/*Data for the table `group_feature` */
TRUNCATE `group_feature`;
insert  into `group_feature`(`group`,`feature`) values (1,1),(2,2),(3,1),(3,2);

/*Data for the table `localization` */
TRUNCATE `localization`;
insert  into `localization`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`locale`,`key`,`text`) values (1,'2017-03-16 14:43:06','2017-03-16 14:43:06',NULL,0,'de-de','high.school.or.above','Fachhochschulreife, Hochschulreife, abgeschlossene Lehre/Berufsfachschule oder darüber'),(2,'2017-03-16 14:43:06','2017-03-16 14:43:06',NULL,0,'de-de','other','andere'),(3,'2017-03-16 14:43:07','2017-03-16 14:43:07',NULL,0,'de-de','stomach.cramps','Bauchkrämpfe'),(4,'2017-03-16 14:43:07','2017-03-16 14:43:07',NULL,0,'de-de','general.pain.in.lower.belly','allgemein Schmerzen im Unterbauch'),(5,'2017-03-16 14:43:07','2017-03-16 14:43:07',NULL,0,'de-de','lower.back.pain','Rückenschmerzen im unteren Rücken'),(6,'2017-03-16 14:43:07','2017-03-16 14:43:07',NULL,0,'de-de','headache','Kopfschmerzen'),(7,'2017-03-16 14:43:07','2017-03-16 14:43:07',NULL,0,'de-de','nausea.vomiting','Übelkeit/Erbrechen'),(8,'2017-03-16 14:43:07','2017-03-31 13:46:38',NULL,2,'de-de','namely.textinput','nämlich: [_]'),(9,'2017-03-16 14:43:07','2017-03-16 14:43:07',NULL,0,'de-de','textinput.only','[_]'),(10,'2017-03-16 14:43:07','2017-03-16 14:43:07',NULL,0,'de-de','no','Nein');

/*Data for the table `meta_question` */
TRUNCATE `meta_question`;
insert  into `meta_question`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`name`,`label`,`moment`,`published`,`order`,`headline`) values (1,'2017-01-26 16:16:14','2019-08-21 12:34:56',NULL,5,'1000','your.age','',1,10,NULL),(2,'2017-01-26 17:16:14','2017-03-29 09:39:36',NULL,6,'1010','bmi.calculated.from.size.and.weight','',1,100,NULL),(3,'2017-01-27 12:03:28','2017-03-07 14:51:39',NULL,6,'1011','what.is.the.highest.level.of.formal.education.you.have.completed.so.far','',1,200,NULL),(4,'2017-03-02 14:58:26','2017-03-07 14:51:44',NULL,5,'2000','how.long.is.your.cycle.usually.the.time.from.the.first.day.of.period.until.the.beginning.of.the.next.period','',1,300,NULL),(5,'2017-03-02 15:01:07','2017-03-07 14:51:49',NULL,5,'2010','how.long.is.your.period.usually','',1,400,NULL),(6,'2017-03-02 15:13:41','2017-03-07 14:51:54',NULL,3,'2020-2026','what.kind.of.period.pain.and.discomfort.do.you.usually.experience','',1,500,NULL),(7,'2017-03-03 14:12:28','2017-03-31 16:32:16',NULL,6,'2030','did.you.experience .pain.or.other.discomfort.today','',1,0,NULL),(8,'2017-03-07 15:47:24','2017-03-07 15:47:24',NULL,0,'2030_1','if.yes','',1,0,NULL),(9,'2017-03-17 14:59:05','2017-03-17 15:48:06',NULL,2,'2040','do.you.use.hormonal.contraceptives','',1,600,NULL),(10,'2017-03-17 15:36:47','2017-05-29 08:38:59',NULL,3,'2041-2046',NULL,'',1,0,NULL),(11,'2017-03-17 15:36:48','2017-03-17 15:36:48',NULL,1,'2041-2044','why.do.you.use.hormonal.contraceptives','',1,0,NULL),(12,'2017-03-17 15:55:34','2017-05-24 11:14:19',NULL,1,'2045-2046','how.long.have.you.been.using.hormonal.contraceptives','',1,0,NULL),(13,'2017-03-17 16:12:03','2017-03-17 16:17:18',NULL,1,'2050','have.you.ever.been.pregnant','',1,800,NULL),(14,'2017-03-17 16:12:37','2017-03-17 16:12:37',NULL,0,'2051-2052','if.yes','',1,0,NULL),(15,'2017-03-17 16:20:35','2017-03-17 16:20:35',NULL,0,'2060','are.you.pregnant','',1,0,NULL),(16,'2017-03-17 16:41:49','2017-03-17 16:41:49',NULL,0,'2070','how.intense.was.the.average.pain.of.the.painful.days.during.your.last.period','',1,900,NULL),(17,'2017-03-17 16:45:11','2017-03-17 16:45:11',NULL,0,'2080','during.your.last.period.how.intense.was.the.worst.pain.you.experienced','',1,1000,NULL),(18,'2017-03-17 16:48:59','2017-03-17 16:48:59',NULL,0,'2090','what.was.the.average.intensity.of.your.period.pain.today','',1,100,NULL),(19,'2017-03-17 17:13:45','2017-03-17 17:13:45',NULL,0,'2100','on.how.many.days.have.you.had.period.pain.during.your.last.period','',1,1100,NULL),(20,'2017-03-17 17:19:36','2017-03-17 17:19:36',NULL,0,'2110','on.how.many.days.were.you.absent.from.work.or.education.due.to.period.pain.during.your.last.period','',1,1200,NULL);

/*Data for the table `meta_question_group` */
TRUNCATE `meta_question_group`;
insert  into `meta_question_group`(`meta_question`,`group`) values (3,1),(3,3),(3,2),(4,1),(4,3),(4,2),(5,1),(5,3),(5,2),(6,1),(6,3),(6,2),(9,1),(9,3),(9,2),(2,1),(2,3),(2,2),(7,1),(7,3),(7,2),(1,1),(1,3),(1,2);

/*Data for the table `next_group` */
TRUNCATE `next_group`;
insert  into `next_group`(`id`,`group_name`,`used`,`invalid`) values (1,'acupressure',1,1),(2,'acupressure',0,0),(3,'recommendations',0,0),(4,'recommendations',0,0),(5,'acupressure_recommendations',0,0),(6,'acupressure_recommendations',0,0),(7,'acupressure',0,0),(8,'recommendations',0,0),(9,'acupressure_recommendations',0,0),(10,'acupressure',0,0);

/*Data for the table `questionnaire` */
TRUNCATE `questionnaire`;
insert  into `questionnaire`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`name`,`label`,`order`,`moment`,`study`) values (1,'2017-01-26 16:15:10','2017-03-03 12:33:10',NULL,1,'Baseline','general.questions.about.yourself',0,'baseline',1),(2,'2017-03-03 12:32:44','2017-03-03 14:04:09',NULL,1,'Daily on the 5 days before the calculated menstruation','daily.on.the.5.days.before.the.calculated.menstruation',100,'daily_calculated_five_days_before_menstruation',1),(3,'2017-03-03 12:33:48','2017-03-03 14:04:32',NULL,1,'On the calculated -5th day before menstruation','on.the.calculated.5th.day.before.menstruation',200,'calculated_five_days_before_menstruation',1),(4,'2017-03-03 12:53:28','2017-03-03 14:04:40',NULL,1,'On the calculated 1st day of menstruation','on.the.calculated.1st.day.of.menstruation',300,'calculated_first_day_of_menstruation',1),(5,'2017-03-03 12:53:51','2017-03-03 14:04:46',NULL,1,'Daily during menstruation','daily.during.menstruation',400,'daily_during_menstruation',1),(6,'2017-03-03 12:54:10','2017-03-03 14:04:52',NULL,1,'End of each menstruation','end.of.each.menstruation',500,'end_of_each_menstruation',1),(7,'2017-03-03 12:54:32','2017-03-03 14:04:58',NULL,1,'End of every 3rd menstruation','end.of.every.3rd.menstruation',600,'end_of_every_third_menstruation',1),(8,'2017-04-13 15:50:08','2017-04-13 15:50:08',NULL,0,'miscellaneous','miscellaneous',700,'miscellaneous',1);

/*Data for the table `questionnaire_meta_question` */
TRUNCATE `questionnaire_meta_question`;
insert  into `questionnaire_meta_question`(`questionnaire`,`meta_question`) values (1,3),(1,4),(1,5),(1,6),(1,9),(7,9),(1,2),(5,7),(2,7),(1,1);

/*Data for the table `scale_question` */
TRUNCATE `scale_question`;
insert  into `scale_question`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`meta_question`,`min_text`,`min_value`,`max_text`,`max_value`,`answer_id`) values (1,'2017-03-17 16:42:25','2017-03-17 16:42:25',NULL,0,16,'no.pain.at.all',0,'most.intense.pain.imaginable',10,'2070'),(2,'2017-03-17 16:45:45','2017-03-17 16:45:45',NULL,0,17,'no.pain.at.all',0,'most.intense.pain.imaginable',10,'2080'),(3,'2017-03-17 16:49:29','2017-03-17 16:49:29',NULL,0,18,'no.pain.at.all',0,'most.intense.pain.imaginable',10,'2090');

/*Data for the table `study` */
TRUNCATE `study`;
insert  into `study`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`name`,`published`) values (1,'2017-03-08 13:12:30','2017-03-08 13:12:30',NULL,0,'ACUD-2','2017-03-08 13:12:30');

/*Data for the table `user` */
TRUNCATE `user`;
insert  into `user`(`id`,`created_at`,`updated_at`,`deleted_at`,`version`,`key_hash`,`group`,`study`,`left_at`) values (1,'2017-08-07 09:44:42','2017-08-07 09:44:42',NULL,0,'$2y$10$k6hiCgRnK3YMoJtZLbZri.7Z6xbq4X6Nd4Ngy6ci8hbOQNyG00/72',3,1,NULL),(2,'2017-08-08 06:43:44','2017-08-08 06:43:44',NULL,0,'$2y$10$jCPs/iMPeK6sMGpVlXsrvO8lKv9UAlYIU0FIhAQRYYGNpOQ3WhG8W',1,1,NULL),(341,'2018-01-08 11:06:53','2018-01-08 11:06:53',NULL,0,'$2y$10$gu0xwre1lSnJFbZaJyKawurDHXlxb656KpmOMflP2EXvuDNLNryF.',3,1,NULL),(342,'2018-01-08 14:02:30','2018-01-08 14:02:30',NULL,0,'$2y$10$QjHdb1w0SX4yb7ya7mRAB.m3zvMwLGZKhAiXT2WfyNU/y2xIgkc.W',1,1,NULL),(343,'2018-01-08 15:49:48','2018-01-08 15:49:48',NULL,0,'$2y$10$3l28xJoi5ZIsD/FgZ5VZieujn5a6xLpJkw3BI9HIGTyGK2DW7eBPG',1,1,NULL),(347,'2018-01-11 09:12:08','2018-01-11 09:12:08',NULL,0,'$2y$10$JduJ3FC0t0m1yJwFECeGF./sY6LC3E0xsntqGsP672sGZhqlrWGQu',3,1,NULL),(348,'2018-01-11 10:37:30','2018-01-11 10:37:30',NULL,0,'$2y$10$1NvgQlyW8RRYPSunMHr4AuOhepUOhTuU.GUzRYogWC4WV5PWSms26',3,1,NULL),(349,'2018-01-11 10:46:44','2018-01-11 10:46:44',NULL,0,'$2y$10$p8j7s7x.1bQGNm4O.h1KVuaa0hpUKwLxVDdeYXzbFpuo3aGJBwVvu',1,1,NULL),(723,'2019-02-04 16:17:35','2019-02-04 16:17:35',NULL,0,'$2y$10$6MRUP2vJo9SlJB2J7LY1AOBssaJrmgibGHV4jcFVcHYh3JmYmiDF.',1,1,NULL),(951,'2020-01-13 11:42:18','2020-01-13 11:42:18',NULL,0,'$2y$10$6/IS6dHbSgHvwoQ1thb7neBPFzswHZx8ACr.YU418nlE.uCxAeCM2',3,1,NULL),(1001,'2020-04-01 08:36:06','2020-04-01 08:36:06',NULL,0,'$2y$10$cjJkwaJZzZXBtiNQn5BjWOPO3xBFOc0ofLhUPX1ysu9mpAy30swOS',3,1,NULL),(1105,'2020-09-01 02:43:20','2020-09-01 02:43:20',NULL,0,'$2y$10$K0yPOsuIlrMoV7boQQlsyeMm.w3E67FXC0jH00Jk0/Qws/nVntgu6',2,1,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
