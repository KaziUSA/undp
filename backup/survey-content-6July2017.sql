
--
-- Table structure for table `issue_map_name`
--

DROP TABLE IF EXISTS `issue_map_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_map_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Dumping data for table `issue_map_name`
--

LOCK TABLES `issue_map_name` WRITE;
/*!40000 ALTER TABLE `issue_map_name` DISABLE KEYS */;
INSERT INTO `issue_map_name` VALUES (1,'Central Development Region');
/*!40000 ALTER TABLE `issue_map_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_type`
--

DROP TABLE IF EXISTS `issue_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `chartType` int(11) NOT NULL,
  `surveyNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surveyDetail` longtext COLLATE utf8_unicode_ci,
  `surveyMen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surveyWomen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isHomepage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_type`
--

LOCK TABLES `issue_type` WRITE;
/*!40000 ALTER TABLE `issue_type` DISABLE KEYS */;
INSERT INTO `issue_type` VALUES (1,'Reconstruction',2017,4,1,'2100','Surveys completed across 14 earthquake affected districts in  January 2017','50','50',0),(2,'Livelihood',2017,4,1,'2100','Surveys completed using Kobo Toolbox across 14 earthquake affected districts in March 2017','50','50',0),(3,'Protection',2017,3,1,'2100','Surveys completed across 14 earthquake affected districts in January-February 2017','50','50',1),(4,'Reconstruction',2017,2,1,'2100','Surveys completed across 14 earthquake affected districts in January 2017','50','50',0),(5,'Reconstruction',2017,5,1,'2100','Survey completed across 14 earthquake affected districts in April 2017','50','50',0);
/*!40000 ALTER TABLE `issue_type` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `issue_question`
--

DROP TABLE IF EXISTS `issue_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key_findings_month` int(11) DEFAULT NULL,
  `key_findings` longtext COLLATE utf8_unicode_ci,
  `issue_type_id` int(11) DEFAULT NULL,
  `issue_map_name_id` int(11) DEFAULT NULL,
  `image_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_desc` longtext COLLATE utf8_unicode_ci,
  `image_credit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_615F63E560B4C972` (`issue_type_id`),
  KEY `IDX_615F63E53C77312E` (`issue_map_name_id`),
  CONSTRAINT `FK_615F63E53C77312E` FOREIGN KEY (`issue_map_name_id`) REFERENCES `issue_map_name` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_615F63E560B4C972` FOREIGN KEY (`issue_type_id`) REFERENCES `issue_type` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table `issue_question`
--

LOCK TABLES `issue_question` WRITE;
/*!40000 ALTER TABLE `issue_question` DISABLE KEYS */;
INSERT INTO `issue_question` VALUES (1,'Besides building your home, What is your biggest reconstruction priority?',3,'<p>The stress on needing sufficient water supply has never been greater. A total of 40 percent of respondents cited water supply as their top community reconstruction need. There is no signifciant difference between female and male respondents in the prioritization of water as the main community reconstruction need.</p>\r\n\r\n<p>District wise analysis illustrates that out of 14 districts, 12 districts regard water as the primary concern. It was only in Bhaktapur and Lalitpur where the priorities of roads and schools respectively emerged as top concerns. Furthermore, the pattern holds across all caste/ethnic groups as well. Water emerged as a concern soon after the earthquake and has been growing in significance ever since. This is the first time the Community Perception Survey has illustrated such unanimous results across districts and ethnic groups, on any question.</p>\r\n\r\n<p>In Gumda, Gorkha focus group discussion revealed that the community was waiting for monsoon to begin reconstruction so that they could collect enough water to build. Currently they must walk at least one hour each way to the nearest river to bath, and fetch water for drinking and cooking.</p>',1,1,NULL,'People in Gumda VDC of Gorkha district busy constructing their house.','CFP/RCO','cfp Screen Shot 2017-06-14 at 4.02.51 PM-June-14-2017-16-04-05.png'),(2,'Are your main reconstruction needs being addressed?',1,'<p>Across 2100 respondents in 14 districts, 52 percent of people say that their main reconstruction needs are being addressed. This marks the first time that the question on &ldquo;main needs&rdquo; has tipped the scales from majority negative to majority positive responses. While there is still a long way to go, it is encouraging to observe this incremental progress through the regular Community Perception Survey.</p>\r\n\r\n<p>Differences between different groups do present themselves. For instance, urban populations are found to be less satisfied (46 percent positive) than rural populations (53 percent positive). There are also particular districts that emerge as more positive than others; in particular, Okhaldhunga, Ramechhap and Sindhupalchok (80, 72 and 65 percent respectively), with Sindhupalchok and Dhading displaying the highest proportion of &ldquo;completely yes&rdquo; responses (8%).</p>\r\n\r\n<p>Regarding reconstruction needs, financial resources stood first as 82 percent of respondents noted it as one of their top two needs, followed by building materials (39 percent). Compared to the previous round (January 2017), the relative weighting of these priorities is decreasing (from financial resources 93 percent and building materials 49 percent), but they remain top priorities.</p>',1,1,NULL,NULL,NULL,''),(3,'Do you have the information you needs to access reconstruction support?',3,'<p>Information needs have seen a significant improvement over just the past two months, from 58 percent to 71 percent of people saying they have the information they need to access support. Despite this overall improvement, the recurrent trend of women feeling less informed than their male counterparts is observed in this round. Similarly, older people are less informed than younger people, and Dalit, Gurung, Tamang and other Janajati report feeling less informed than high caste and Newari respondents.</p>\r\n\r\n<p>This round, for the first time, CFP collected information on respondents&rsquo; mother tongue. Among those whose mother tongue was Newari and Magar, there was no negative impact on their access to information, in fact they were more positive about their ability to access the information they need than those whose first language was Nepali. However, there was a negative correlation between access to information and those whose mother tongues were Gurung and Tamang</p>\r\n\r\n<p>Finally, there is also a noticeable difference between urban and rural populations in their ability to access the information they need. While 78 percent of urban people reported having the information they needed, only 69 percent of rural people felt the same way.</p>',1,1,NULL,NULL,NULL,NULL),(4,'Have you consulted an engineer for your housing reconstruction needs?',3,'<p>Across 14 districts, 46 percent of respondents have already consulted an engineer for their housing reconstruction needs. This is a nine percentage point improvement over the last round of data collection, only two months ago. A further 11 percent plan to consult, and fewer than .5 percent of respondents have no plans to consult an engineer. This is an encouraging 5nding that illustrates the importance earthquake affected communities are putting on building their homes properly.</p>\r\n\r\n<p>Again, there are some important caveats that should be carefully considered: women are less likely than men to have already consulted an engineer, and urban respondents are also approximately 10 percent less likely to have consulted an engineer than rural respondents.</p>\r\n\r\n<p>Although respondents in all districts cited lack of availability of engineers to some extent, in Nuwakot and Sindhupalchok this concern was most prevalent, with 20 percent of those who have not consulted citing this as the top reason why they had not. Partners further report that their bene5ciaries in Sindhupalchok have begun reconstruction without engineers because of this, and are now worried their homes will not meet the guidelines.</p>\r\n\r\n<p>Focus group discussion participants in Bigu, Dolakha were unhappy with the engineer consultation process because they had been given contradictory advice so many times that they had been forced to tear down newly constructed homes and start rebuilding again. If engineers from various sources are not giving the same advice there is a signi5cant risk that affected communities will lose faith in consultations and reconstruct without adherence to safer building practices.</p>',1,1,NULL,NULL,NULL,NULL),(5,'When do you plan to reconstruct your house?',3,'<p>Across 2100 respondents in 14 districts 13 percent have already completed their reconstruction. For those who have have been delayed in their reconstruction, the main reasons are cited as: shortage of skilled labour, shortage of building materials and waiting to apply for a subsidy loan from the government.</p>\r\n\r\n<p>In this round, 12 percent of respondents still believe that they will wait until they receive the second tranche to begin rebuilding. This is an improvement over last round&rsquo;s 17 percent, but the 5nding highlights the fact that important information barriers remain for some. Women were more likely than men to believe they could wait for the second tranche to begin reconstruction. Dalit and Tamang respondents were also more likely than other caste/ethnic groups to believe they could wait for the second tranche. Similarly, rural people were more likely than those living in urban areas to believe they could wait for the second tranche to begin.</p>\r\n\r\n<p>This triangulates the question on information needs being met. The same groups who feel they do not have suf5cient information are those that mis-understand the grant process, and do not realize that they will not get the second tranche unless they begin the reconstruction process, and have their foundation signed off by a government engineer.</p>\r\n\r\n<p>Rural respondents were most likely to state that they plan to complete their reconstruction only after suf5cient availability of labour/masons (16 percent). Whereas urban respondents were most likely to plan to complete their reconstruction after taking subsidy loan from the government (19 percent).</p>',1,1,NULL,NULL,NULL,NULL),(6,'Have you received any housing reconstruction support?',3,'<p>A total of 80 percent of respondents have received some form of reconstruction support, this is up from 69 percent two months ago, indicating that progress towards all affected people receiving support is being made at a good rate.</p>\r\n\r\n<p>Rural people are 20 percent more likely to have received some form of reconstruction support than those living in urban areas.</p>\r\n\r\n<p>The government housing grant is the primary source of support respondents have received (98 percent). Most have received only the %rst tranche, and among them 13 percent have had three house inspections, 20 percent have had two, 21 percent have had one and 38 percent have had no inspections.</p>\r\n\r\n<p>Among the 11 percent of respondents who had not received any reconstruction support, 57 percent cited unaddressed grievances as the main cause.</p>',1,NULL,NULL,NULL,NULL,NULL),(7,'Have you been able to commit any of your own resources?',3,'<p>Across 14 districts, 50 percent of people have been able to commit their own resources to their housing reconstruction project, a slight increase, of 4 percent, over last round. Far more men than women have been able to commit their own resources.</p>\r\n\r\n<p>Janajatis have been able to commit their own resources more frequently than any other caste/ethnic group. Those who have already completed their reconstruction were the most likely by far to report committing their own resources to do so (80 percent). However, 51 percent of those have committed their own funds from a loan, which gives a worrying snapshot of the status of borrowing for reconstruction.</p>\r\n\r\n<p>In Bigu, Dolakha focus group discussions revealed a communal practice of all members putting their effort into collectively building one member&rsquo;s house at a time. This was seen as a good practice to be encouraged and replicated elsewhere. However, a signi%cant drawback to inclusion also came to light. Houses of single women in the community were not in the queue for collective reconstruction, as those women were not seen able able to contribute to their neighbors reconstruction projects.</p>',1,1,NULL,NULL,NULL,NULL),(9,'Problems related to children in post-earthquake period',3,'<p>Acress 14 earthquake affected disctricts and 2100 respondents, 24 percent believe they have problems related to the children in their household.</p>',3,1,NULL,NULL,NULL,NULL),(10,'Are your main reconstruction needs being addressed?',1,'<p>A total of 40 percent</p>',4,1,NULL,NULL,NULL,NULL),(11,'Are you aware of how to build using safer building practices?',3,'<p>Seventy percent of respondents report having knowledge of safer building practices. This is an improvement from 64 percent just two months ago. As usual, women are far less con%dent than their male counterparts in their knowledge of safer building practices.</p>\r\n\r\n<p>As with all information related questions: women, elderly, lower caste, disadvantaged indigenous and to some extent rural people have less knowledge of safer building practices.</p>\r\n\r\n<p>At the district level, Sindhuli overwhelmingly reports being least informed on safer building practices.</p>\r\n\r\n<p>Radio, Village Development Committee (VDC) and community members were the most frequently cited sources of information that respondents had learned about safe building practices from.</p>',1,1,NULL,NULL,NULL,NULL),(12,'Do you have the information you needs to access reconstruction support?',1,'<p>Understanding of the process</p>',4,1,NULL,NULL,NULL,NULL),(13,'Have you consulted an engineer for your housing reconstruction needs?',1,'<p>An encouraging 37 percent</p>',4,1,NULL,NULL,NULL,NULL),(14,'What are your overall plans for your housing reconstruction?',1,'<p>Fifty-four percent of respondents</p>',4,1,NULL,NULL,NULL,NULL),(15,'Have you received any housing reconstruction support?',1,'<p>A total of 69 percent</p>',4,1,NULL,NULL,NULL,NULL),(16,'Have you been able to commit any of your own resources?',1,'<p>Forty-six percent of respondents</p>',4,1,NULL,NULL,NULL,NULL),(17,'Are you aware of how to build using safer construction practices?',1,'<p>A total of 64 percent</p>',4,1,NULL,NULL,NULL,NULL),(18,'Do you face any barriers to receiving support?',1,'<p>While an encouraging 62 percent</p>',4,NULL,NULL,NULL,'NDRI',NULL),(19,'Are you satisfied with grant dispersal process?',1,'<p>Sixty-four percent of people are satisfied with the grant<br />\r\ndispersal process, another steady improvement over the<br />\r\nprevious round of data collection. However, those in rural<br />\r\nareas are more satisfied than those in urban areas (67 vs.<br />\r\n56 percent).</p>\r\n\r\n<p>The current status of respondents&rsquo; homes proved to be a<br />\r\nstrong indicator of their level of satisfaction. Those who<br />\r\nhave already completed, or at least started, their<br />\r\nreconstruction are much more positive about the process<br />\r\nthan those who are still awaiting further support to begin<br />\r\nrebuilding.</p>\r\n\r\n<p>The major complaints with the process among the 34 percent who were not satisfied included first tranche insufficient to being work (30 percent), lengthy/time consuming process (29 percent) and complicated nature (29 percent). Partners also reported that beneficiaries in Dolakha claim there has been favoritism in drafting the grant beneficiary list and are upset that some who do not meet the selection criteria have been enlisted.</p>',4,1,NULL,NULL,NULL,NULL),(20,'Besides building your home, What is your biggest reconstruction priority?',1,'<p>When it comes to the reconstruction</p>',4,1,NULL,NULL,NULL,NULL),(21,'Overall, is post-earthquake reconstruction process making progress?',1,'<p>The perception of progress on reconstruction among affected communities has seen an impressive improvement over the past six months. Today, 62 percent of respondents feel progress is being made, up from 49 percent two months ago and an astounding improvement of nearly 40 percent from the mere 22 percent of people who felt progress was being made six months ago.</p>\r\n\r\n<p>Of the 30 percent who feel there has not been progress, unclear government policies was cited by 54 percent as among the top two barriers to progress. Other barriers were identi%ed by respondents as delays in fund disbursement and lack of money to finish their house.</p>',1,1,NULL,NULL,NULL,NULL),(22,'Problem with violence within the community',2,NULL,3,NULL,NULL,NULL,NULL,NULL),(23,'Tension within the community related to recovery and reconstruction support',2,NULL,3,NULL,NULL,NULL,NULL,NULL),(24,'Exclusion or discrimination in the community related to reconstruction support',2,NULL,3,NULL,NULL,NULL,NULL,NULL),(25,'Mistreatment in the recovery process',2,NULL,3,NULL,NULL,NULL,NULL,NULL),(26,'Feedback to the government on the reconstruction process',2,NULL,3,NULL,NULL,NULL,NULL,NULL),(27,'Feedback to I/NGOS on the reconstruction process',2,NULL,3,NULL,NULL,NULL,NULL,NULL),(28,'Are your daily food needs being met?',6,NULL,2,NULL,NULL,NULL,NULL,NULL),(29,'How much of your own food do you grow?',3,NULL,2,NULL,NULL,NULL,NULL,NULL),(30,'Primary Source of Livelihood',3,NULL,2,NULL,NULL,NULL,NULL,NULL),(31,'Earthquake impact on livelihood',3,NULL,2,NULL,NULL,NULL,NULL,NULL),(32,'Constraints to livelihood recovery',3,NULL,2,NULL,NULL,NULL,NULL,NULL),(33,'Resilience of livelihood to another disaster',3,NULL,2,NULL,NULL,NULL,NULL,NULL),(34,'Migration to support family recovery',3,NULL,2,NULL,NULL,NULL,NULL,NULL),(35,'Service receiving from I/NGOs',3,NULL,2,NULL,NULL,NULL,NULL,NULL),(36,'Do you face any barriers to receiving support?',3,'<p>Almost three quarters of respondents did not feel they faced any barriers to receiving support. Once again, this continues the positive trend observed across all reconstruction questions, with a 12 percentage point improvement over the past two months.</p>\r\n\r\n<p>Interestingly, there was no difference in the level of perceived barriers among urban and rural respondents. However, by district some variance was observed. While 88 percent of Rasuwa respondents felt they faced no barriers, 38 percent of Makwanpur respondents felt they did face barriers.</p>\r\n\r\n<p>Feedback from partners suggests that several<br />\r\nbene%ciaries in Nuwakot, Sindhuli, Ramechhap, Dolakha,<br />\r\nSindhupalchok and Makwanpur remain confused on how<br />\r\nto get the second tranche. Some have used their %rst<br />\r\ntranche in other household needs and are now seeking<br />\r\ninformation on how to get the next installments.<br />\r\n&nbsp;</p>',1,1,NULL,NULL,NULL,NULL),(37,'Are you satisfied with the grant dispersal process?',3,'<p>Sixty-four percent of people are satisfied with the grant dispersal process, another steady improvement over the previous round of data collection. However, those in rural areas are more satisfied than those in urban areas (67 vs. 56 percent).</p>\r\n\r\n<p>The current status of respondents&rsquo; homes proved to be a strong indicator of their level of satisfaction. Those who have already completed, or at least started, their reconstruction are much more positive about the process than those who are still awaiting further support to begin rebuilding.</p>\r\n\r\n<p>The major complaints with the process among the 34 percent who were not satisfied included first tranche insufficient to being work (30 percent), lengthy/time consuming process (29 percent) and complicated nature (29 percent). Partners also reported that beneficiaries in Dolakha claim there has been favoritism in drafting the grant beneficiary list and are upset that some who do not meet the selection criteria have been enlisted.</p>',1,1,NULL,NULL,NULL,NULL),(38,'Overall, is the post-earthquake reconstruction process making progress?',3,'<p>The perception of progress on reconstruction among affected communities has seen an impressive improvement over the past six months. Today, 62 percent of respondents feel progress is being made, up from 49 percent two months ago and an astounding improvement of nearly 40 percent from the mere 22 percent of people who felt progress was being made six months ago.</p>\r\n\r\n<p>Of the 30 percent who feel there has not been progress, unclear government policies was cited by 54 percent as among the top two barriers to progress. Other barriers were identi%ed by respondents as delays in fund disbursement and lack of money to finish their house.</p>',4,1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `issue_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_chart_question`
--

DROP TABLE IF EXISTS `issue_chart_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_chart_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_question_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chartType` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1961E8E67C6CA31B` (`issue_question_id`),
  CONSTRAINT `FK_1961E8E67C6CA31B` FOREIGN KEY (`issue_question_id`) REFERENCES `issue_question` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_chart_question`
--

LOCK TABLES `issue_chart_question` WRITE;
/*!40000 ALTER TABLE `issue_chart_question` DISABLE KEYS */;
INSERT INTO `issue_chart_question` VALUES (1,1,'Biggest community reconstruction priority besides houses',3),(2,4,'Have you consulted an engineer for your housing reconstruction needs?',4),(3,4,'Availability of engineers by district',3),(4,2,'Are your main reconstruction needs being addressed?',2),(5,9,'Do you have any problems related to children in your household or family in the post-earthquake period?',1),(6,10,'Are your main reconstruction needs being addressed?',2),(7,3,'Do you have the information you need to access reconstruction support?',2),(8,5,'When do you expect to complete your reconstruction?',3),(9,5,'Waiting for second tranche to begin rebuilding by caste/ethnicity',3),(11,NULL,'Have you been able to commit your own resources?',1),(13,7,'Have you been to commit your own resources?',2),(14,11,'Are you aware of how to build using safer construction practices?',2),(15,6,'Have you received any housing reconstruction support?',1),(16,2,'Needs met by status of the house',5),(17,36,'Do you face any barriers to receiving reconstruction support?',1),(19,19,'Satisfied with grant process?',1),(20,37,'Satisfied with grant process?',1),(21,21,'Reconstruction making progress?',1),(26,3,'Access to information by urban/rural',5),(27,3,'Access to information by gender',5),(28,37,'Satisfiaction by status of house',5),(29,38,'Reconstruction making progress?',1),(30,21,'Perception of progress over time',5),(31,28,'Are your daily food needs being met in your family?',2),(32,30,'Primary source of livelihood before and after earthquake',5),(33,30,'Own or rent farmland',2);
/*!40000 ALTER TABLE `issue_chart_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_chart_option`
--

DROP TABLE IF EXISTS `issue_chart_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_chart_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_chart_question_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E9640074673C4111` (`issue_chart_question_id`),
  CONSTRAINT `FK_E9640074673C4111` FOREIGN KEY (`issue_chart_question_id`) REFERENCES `issue_chart_question` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_chart_option`
--

LOCK TABLES `issue_chart_option` WRITE;
/*!40000 ALTER TABLE `issue_chart_option` DISABLE KEYS */;
INSERT INTO `issue_chart_option` VALUES (1,1,'Water supply','39'),(2,1,'Schools','20'),(3,1,'Roads','10'),(4,1,'Hospitals / Health centre','8'),(5,2,'No','41'),(6,2,'Yes','46'),(7,2,'Plan to consult','11'),(8,2,'Don\'t plan to consult','1'),(9,2,'Don\'t know','1'),(10,3,'Okhaldhunga','76'),(11,3,'Sindhuli','67'),(12,3,'Lalitpur','85'),(13,3,'Kathmandu','69'),(14,4,'Completely yes','4'),(15,4,'Somewhat yes','48'),(16,4,'Not very much','28'),(17,4,'Not at all','19'),(18,4,'Dont know/Refused','1'),(19,5,'No','73'),(20,5,'Yes','24'),(21,5,'Neutral','1'),(22,5,'Don\'t know','2'),(23,6,'Not addressed','55'),(24,6,'Neutral','4'),(25,6,'Addressed','41'),(26,6,'Don\'t know/Refused','1'),(27,7,'Completely yes','13'),(28,7,'Somewhat yes','58'),(29,7,'Not very much','16'),(30,7,'Not at all','8'),(31,7,'Don\'t know/refused','5'),(32,9,'Brahmin','13'),(33,9,'Chhetri','10'),(34,9,'Dalit','16'),(35,9,'Gurung','11'),(36,9,'Other Janajati','11'),(37,9,'Tamang','17'),(38,13,'Completely yes','3'),(39,11,'Not very much','29'),(40,13,'Somewhat yes','47'),(41,13,'Not at all','20'),(42,13,'Don\'t know/refused','1'),(43,8,'1-5 months','28'),(44,8,'6-11 months','13'),(45,8,'1 Year','20'),(46,8,'2 Years','15'),(47,8,'3 Years','4'),(48,8,'3+ Years','2'),(49,8,'Don\'t know','20'),(50,13,'Not very much','29'),(51,14,'Completely yes','13'),(52,14,'Somewhat yes','57'),(53,14,'Not very much','20'),(54,14,'Not at all','6'),(55,14,'Don\'t know/refused','4'),(56,15,'Yes','80'),(57,15,'NO','8'),(58,15,'Not yet, but expected','10'),(59,15,'Not yet, not expected','2'),(60,16,'No',NULL),(61,16,'Yes',NULL),(62,19,'Completely yes','11'),(63,19,'Somewhat yes','53'),(64,19,'Not very much','21'),(65,19,'Not at all','13'),(66,19,'Don\'t know/refused','2'),(67,20,'Completely yes','11'),(68,20,'Somewhat yes','53'),(69,20,'Somewhat yes','53'),(70,20,'Not very much','21'),(71,20,'Not at all','13'),(72,20,'Don\'t know/refused','2'),(73,21,'Completely yes','4'),(74,21,'Somewhat yes','58'),(75,21,'Not very much','25'),(76,21,'Don\'t know/refused','8'),(77,NULL,'Don\'t know',NULL),(78,NULL,'Don\'t know',NULL),(79,NULL,'No',NULL),(80,NULL,'Yes',NULL),(81,NULL,'Rural',NULL),(82,NULL,'Urban',NULL),(83,NULL,'Rural',NULL),(84,26,'Rural',NULL),(85,26,'Urban',NULL),(86,27,'Female',NULL),(87,27,'Male',NULL),(88,28,'No',NULL),(89,28,'Yes',NULL),(90,31,'No','19'),(91,31,'Yes','80'),(92,31,'Don\'t know','1'),(93,32,'Before earthquake',NULL),(94,32,'After earthquake',NULL),(95,33,'Own','88'),(96,33,'Rent','6'),(97,33,'None','6');
/*!40000 ALTER TABLE `issue_chart_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_chart_overview`
--

DROP TABLE IF EXISTS `issue_chart_overview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_chart_overview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_type_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4855701360B4C972` (`issue_type_id`),
  KEY `IDX_48557013B08FA272` (`district_id`),
  CONSTRAINT `FK_4855701360B4C972` FOREIGN KEY (`issue_type_id`) REFERENCES `issue_type` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_48557013B08FA272` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_chart_overview`
--

LOCK TABLES `issue_chart_overview` WRITE;
/*!40000 ALTER TABLE `issue_chart_overview` DISABLE KEYS */;
INSERT INTO `issue_chart_overview` VALUES (1,3,30,'14'),(2,3,23,'11'),(3,3,24,'11'),(4,3,36,'11'),(5,3,28,'10'),(6,3,22,'8'),(7,3,21,'7'),(8,3,27,'6'),(9,3,29,'5'),(10,3,29,'5'),(11,3,25,'4'),(12,3,26,'3'),(13,3,31,'3'),(15,3,12,'3');
/*!40000 ALTER TABLE `issue_chart_overview` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table `issue_chart_sub_option`
--

DROP TABLE IF EXISTS `issue_chart_sub_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_chart_sub_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_chart_option_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2FD845F57F66A014` (`issue_chart_option_id`),
  CONSTRAINT `FK_2FD845F57F66A014` FOREIGN KEY (`issue_chart_option_id`) REFERENCES `issue_chart_option` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_chart_sub_option`
--

LOCK TABLES `issue_chart_sub_option` WRITE;
/*!40000 ALTER TABLE `issue_chart_sub_option` DISABLE KEYS */;
INSERT INTO `issue_chart_sub_option` VALUES (1,60,'Reconstruction Completed','34'),(2,60,'Reconstruction Started','39'),(3,60,'Heavily Damaged','47'),(4,60,'Completely Destroyed (rubble not cleared)','58'),(5,60,'Completely Destroyed (rubble cleared)','49'),(6,61,'Reconstruction Completed','66'),(7,61,'Reconstruction Started','60'),(8,61,'Heavily Damaged','51'),(9,61,'Completely Destroyed (rubble not cleared)','41'),(10,61,'Completely Destroyed (rubble cleared)','50'),(11,77,'Urban','78'),(12,77,'Rural','69'),(13,78,'Rural','7'),(14,78,'Urban','3'),(15,79,'Rural','25'),(16,79,'Urban','20'),(17,80,'Rural','69'),(18,80,'Urban','78'),(19,81,'Don\'t know','7'),(20,81,'Don\'t know','3'),(21,84,'Don\'t know','7'),(22,84,'No','25'),(23,84,'Yes','79'),(24,85,'Don\'t know','3'),(25,85,'No','20'),(26,85,'Yes','78'),(27,86,'Yes','67'),(28,86,'No','26'),(29,86,'Don\'t know','7'),(30,87,'Yes','76'),(31,87,'No','21'),(32,87,'Don\'t know','3'),(33,88,'RECONSTRUCTION STARTED','22'),(34,88,'RECONSTRUCTION COMPLETED','26'),(35,88,'HEAVILY DAMAGED','37'),(36,88,'COMPELTELY DESTROYED(RUBBEL NOT CLEARED)','37'),(37,88,'COMPELTELY DESTROYED(RUBBEL NOT CLEARED)','37'),(38,88,'COMPETELY DESTROYED(RUBBLE CLEARED)','33'),(39,89,'RECONSTRUCTION STARTED','78'),(40,89,'RECONSTRUCTION COMPLETED','73'),(41,89,'HEAVILY DAMAGED','62'),(42,89,'COMPELTELY DESTROYED(RUBBEL NOT CLEARED)','61'),(43,89,'COMPETELY DESTROYED(RUBBLE CLEARED)','64'),(44,93,'Business','6'),(45,93,'Labour','6'),(46,93,'Agriculture','67'),(47,94,'Business','6'),(48,94,'Labour','7'),(49,94,'Agriculture','69');
/*!40000 ALTER TABLE `issue_chart_sub_option` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `issue_infographics_title`
--

DROP TABLE IF EXISTS `issue_infographics_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_infographics_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_question_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B86A5FEF7C6CA31B` (`issue_question_id`),
  CONSTRAINT `FK_B86A5FEF7C6CA31B` FOREIGN KEY (`issue_question_id`) REFERENCES `issue_question` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_infographics_title`
--

LOCK TABLES `issue_infographics_title` WRITE;
/*!40000 ALTER TABLE `issue_infographics_title` DISABLE KEYS */;
INSERT INTO `issue_infographics_title` VALUES (1,6,'Reason for not receiving housing reconstruction support',2),(2,6,'Source of support',2),(3,6,'Type of support received',2),(4,1,'District hightlights',1),(5,7,'District hightlights',3),(6,2,'Top reconstruction needs',2),(7,9,'Main concerns related to children',2),(8,10,'Financial resources (93%)',2),(9,10,'Top reconstruction needs',2),(10,4,'Why have you not consulted?',2),(11,3,'Top information needs',2),(12,7,'Resources committed',2),(13,11,'How do you plan to use these  practices?',2),(14,11,'Where did you get this information?',1),(15,19,'Why are you not satisfied with the grant dispersal process?',2),(16,37,'Why are you not satisfied with the grant dispersal process?',2),(17,21,'Top things preventing progress',2),(18,36,'District highlights',1),(19,28,'Things needed to meet food needs',2),(20,28,'District highlights',3),(21,30,'District highlights',1);
/*!40000 ALTER TABLE `issue_infographics_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_infographics`
--

DROP TABLE IF EXISTS `issue_infographics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_infographics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_infographics_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `imageUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E79D581F8DE7193F` (`issue_infographics_id`),
  CONSTRAINT `FK_E79D581F8DE7193F` FOREIGN KEY (`issue_infographics_id`) REFERENCES `issue_infographics_title` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_infographics`
--

LOCK TABLES `issue_infographics` WRITE;
/*!40000 ALTER TABLE `issue_infographics` DISABLE KEYS */;
INSERT INTO `issue_infographics` VALUES (1,4,'Respondents in Nuwakot (63%), Makwanpur and Ramechhap (51%) prioritized water most strongly among all districts','default-infographics-July-5-2017-15-45-01.png',NULL),(2,4,'Respondents in Dolakha (24%), Okhaldunga (21%) and Ramechhap (21%) prioritized roads most strongly among all districts','',NULL),(3,1,'Unaddressed grievance (57%)','',NULL),(4,1,'Name missing on eligibility list (30%)','',NULL),(5,1,'Ongoing banking process (12%)','',NULL),(6,2,'Government grant (98%)','',NULL),(7,2,'I/NGO (10%)','',NULL),(8,2,'Media/private sector/community (4%)','',NULL),(9,3,'Cash transfer (99%)','',NULL),(10,3,'Consultation (8%)','',NULL),(11,3,'Info on safe building practices (4%)','',NULL),(12,5,'of respondents in Nuwakot have committed their own resources','','72'),(13,5,'of respondents in Rasuwa have committed their own resources','','64'),(14,5,'of respondents in Lalitpur have NOT committed their own resources','','88'),(15,5,'of respondents in Makwanpur have NOT committed their own resources','','67'),(16,6,'Financial resources (82%)','',NULL),(17,6,'Building materials (39%)','',NULL),(18,7,'37% are concerned about lack of psycho-social support','',NULL),(19,7,'27% are concerned about food insecurity','',NULL),(20,7,'26% are concerned about the health care','',NULL),(21,9,'Financial resources (93%)','',NULL),(22,9,'Building materials (49%)','',NULL),(23,9,'Skilled labour (16%)','',NULL),(24,9,'Technical knowledge (12%)','',NULL),(25,9,'Land to build on (9%)','',NULL),(26,10,'Have not started rebuilding (68%)','',NULL),(27,11,'If I am eligible or not (21%)','',NULL),(28,11,'When will I get support (17%)','',NULL),(29,10,'No availability of\r\nengineers (21%)','',NULL),(30,12,'labour','','55'),(31,12,'Money/loan','','51'),(32,12,'Own Materials','','49'),(34,13,'Consulting engineer before building (72%)','',NULL),(35,13,'Employing trained masons (46%)','',NULL),(36,13,'Use all safer building practice elements (34%)','',NULL),(37,14,'40% got safer building practice information\r\nfrom a community or family member','',NULL),(38,14,'50% got safer building practice information\r\nfrom the radio','',NULL),(39,14,'43% got safer building practice information\r\nfrom their VDC','',NULL),(40,15,'First tranche\r\ninsufficient to\r\nbegin work (30%)','',NULL),(41,15,'Lengthy/time\r\nconsuming process\r\n(29%)','',NULL),(42,15,'Complicated in\r\nnature (29%)','',NULL),(43,16,'First tranche\r\ninsufficient to\r\nbegin work (30%)','',NULL),(44,16,'Lengthy/time\r\nconsuming process\r\n(29%)','',NULL),(45,16,'Complicated in\r\nnature (29%)','',NULL),(46,17,'Government plans\r\nunclear (34%','',NULL),(47,17,'Delays in fund\r\ndisbursement\r\n(17%)','',NULL),(48,19,'49% require paid\r\nwork','',NULL),(49,19,'35% require\r\nnew skills','',NULL),(50,19,'32% require land','',NULL);
/*!40000 ALTER TABLE `issue_infographics` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table `issue_map_districts`
--

DROP TABLE IF EXISTS `issue_map_districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_map_districts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_map_name_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1CE1E15C3C77312E` (`issue_map_name_id`),
  KEY `IDX_1CE1E15CB08FA272` (`district_id`),
  CONSTRAINT `FK_1CE1E15C3C77312E` FOREIGN KEY (`issue_map_name_id`) REFERENCES `issue_map_name` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_1CE1E15CB08FA272` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_map_districts`
--

LOCK TABLES `issue_map_districts` WRITE;
/*!40000 ALTER TABLE `issue_map_districts` DISABLE KEYS */;
INSERT INTO `issue_map_districts` VALUES (1,1,36),(2,1,31),(3,1,30),(4,1,29),(5,1,28),(6,1,27),(7,1,26),(8,1,25),(9,1,24),(10,1,23),(11,1,22),(12,1,21),(13,1,20),(14,1,12);
/*!40000 ALTER TABLE `issue_map_districts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_map_sayings`
--

DROP TABLE IF EXISTS `issue_map_sayings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_map_sayings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_question_id` int(11) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saying` longtext COLLATE utf8_unicode_ci NOT NULL,
  `hrrp` longtext COLLATE utf8_unicode_ci,
  `district_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DD3165347C6CA31B` (`issue_question_id`),
  KEY `IDX_DD316534B08FA272` (`district_id`),
  CONSTRAINT `FK_DD3165347C6CA31B` FOREIGN KEY (`issue_question_id`) REFERENCES `issue_question` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_DD316534B08FA272` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_map_sayings`
--

LOCK TABLES `issue_map_sayings` WRITE;
/*!40000 ALTER TABLE `issue_map_sayings` DISABLE KEYS */;
INSERT INTO `issue_map_sayings` VALUES (1,1,'Fulpingkatti','There is scarcity of water, due to which it is difficult to reconstruct our house.\r\n\r\nMore priority needs to be given to educational institutes like schools.','The issue of water has been raised with the Governement of Nepal and Partner Organizations. They hope to work out a plan to maximize investment in reconstruction and repair of water supply infrastructure to support reconstruction.',23),(2,2,'Godawari','Most of us (Dalit) do not have land ownership documents.','If a household does not have a land ownership document,',25),(3,2,'Fulpingkatti','It is difficult to reconstruct house due to water shortage.',NULL,23),(4,2,'Barpak','I am not included in the beneficiary list though I am a real earthquake victim.',NULL,36),(5,10,'Batase','Will government provide a house reconstruction loan at a minimal rate?','Yes, the \'Refinancing Procedures for the',23),(6,3,'Fulpingkatti','We heard a rumor that those\r\nwho make wooden house will not\r\nreceive second installment. Is\r\nthat true?\r\n\r\nWe made one storey wooden house\r\nwhich is not approved by saying it is not\r\nconstructed on the basis of building\r\ncode/design. Do we get second\r\ninstallment?','This is not true. Timber houses can be\r\nbuilt compliant with standards and\r\nreceive the second installment.\r\nDUDBC design catalogue volume 2\r\nincludes timber house designs and this\r\nwill be incorporated into the inspection\r\nchecklists. Once the inspection\r\nchecklists have been updated to\r\ninclude timber construction the\r\ninspection of timber houses will move\r\nahead.\r\n\r\nThe second tranche will only be\r\nprovided if the house has been\r\nconstructed as per the prescribed\r\nstandards. If the house has not\r\nbeen approved the engineer\r\nshould have provided advice on\r\nthe corrections required to make\r\nthe building compliant. Once these\r\nhave been implemented and\r\napproved you will be able to\r\nreceive the second tranche.',23),(7,4,'Majhi feda','Different engineers have\r\ndifferent advice regarding\r\nhouse reconstruction. Now we\r\nare confused, about whom to\r\nlisten to.','Khoi ta',24),(8,4,'Goganpani','I heard a rumor that engineer\r\nwill not pass building design if\r\nwe do not give them money.','The NRA CEO has said that any\r\nissues like this should be raised to the\r\nCDO who has the right to take relevant\r\naction against employees that are not\r\ncarrying out their job properly. He has\r\nalready spoken to all CDOs and asked\r\nthem to be very strict on these kind of\r\nthings.',30),(9,5,'Bajrabarahi','If we get cash support soon then\r\nwe can start reconstructing our\r\nhouse.',NULL,25),(10,5,'Bhimeshwor','Those who are not able to\r\nreconstruct house, government\r\nneeds to give sufficient amount of\r\ncash support.','There is provision in the NGO\r\nMobilization Guidelines for partner\r\norganisations to provide a top-up\r\ngrant of an additional 50,000 NPRs for\r\nvulnerable and remote households.\r\nNRA also advocates for partners to\r\nsupport households by providing\r\ntrained masons to support with\r\nsupervision of construction work.',22),(11,5,'Bhadrakali','We do not have money to construct\r\nthe housing model provided by the\r\ngovernment.The government cash\r\nsupport is very small and it is very\r\ndifficult for the poor people.',NULL,20),(12,6,'Maidi','For earthquake affected people all\r\nthe construction materials need to\r\nbe made available at a reasonable\r\nprice.','The ‘Refinancing Procedures for the\r\nreconstruction of private houses destroyed\r\nby the earthquakes, 2072’ provide for loans,\r\nat 2% interest rate, of up to 2.5 million NPRs\r\nwithin the Kathmandu Valley and 1.5 million\r\nNPRs outside of the Kathmandu Valley. The\r\nprocedures also provide for a 300,000 NPRs\r\nloan to members of micro credit financial\r\ninstitutions.',30),(13,6,'Magapauwa','The grant needs to be distributed\r\nequally to all beneficiaries. Masons\r\nand building materials are required.',NULL,22),(14,6,'Maalu','We need government cash\r\nsupport soon because we are\r\nnot able to take bank loan.',NULL,22),(15,7,'Bajrabarahi','Cash support provided by the\r\ngovernment is not even enough to\r\ndemolish house. How can we\r\nreconstruct house?','The cash grant is not intended to cover the\r\nfull cost of construction, It is intended to\r\nprovide and equitable level of support to\r\nall eligible households. The ‘Refinancing\r\nProcedures for the reconstruction of\r\nprivate houses destroyed by the\r\nearthquakes, 2072’ provide for loans, at\r\n2% interest rate, of up to 2.5 million NPRs\r\nwithin the Kathmandu Valley and 1.5\r\nmillion NPRs outside of the Kathmandu\r\nValley. The procedures also provide for a\r\n300,000 NPRs loan to members of micro\r\ncredit financial institutions.',25),(16,7,'Boch','We want to build our capacity\r\n througn technical knowledge.','Partner Organisations and\r\nGovernment of Nepal are\r\nproviding various capacity\r\nbuilding activities across the\r\nearthquake affected districts.\r\nFor more information on\r\nthese activities in your district\r\nyou can contact the HRRP\r\nDistrict Coordinator and the\r\nNRA District Chief.',22),(17,11,'Fulpingkatti','We have a landslide issue. Hence\r\nwe want government to declare\r\nthis region as vulnerable. This\r\nregion also has a problem in\r\naccess to road, which is adding\r\ndifficulty in reconstruction.','The NRA had conducted a geo-hazard\r\nrisk assessment in more than 500\r\nlocations across 15 districts to assess\r\nsites and categorize into three\r\ncategories.\r\nCategory I: safe communities/villages\r\nwhere reconstruction can begin any\r\ntime;\r\nCategory II: communities/villages where\r\nreconstruction can begin only after\r\napplying suitable countermeasures to\r\nexisting geo-hazards;\r\nCategory III: unsafe\r\ncommunities/villages where\r\nreconstruction is not recommended.\r\nThe assessment also identified potential\r\nrelocation sites, where required. The\r\nrelocation procedures state that families\r\nin category III are eligible for the\r\nrelocation grant of NRs. 200,000, where\r\nor not they are eligible for the housing\r\nreconstruction grant. You can contact\r\nthe NRA district office for more\r\ninformation on this.',23),(18,11,'Bhadrakali','We want government to\r\nconstruct safer building for us.',NULL,20),(19,19,'Godawari','If we get the cash support\r\nsoon then we can start\r\nreconstructing house.',NULL,25),(20,19,'Deurali N.P','I need second installement as\r\nsoon as possible.',NULL,21),(21,19,'Suryabinayak','We need lumpsum cash in one\r\ninstallment.',NULL,26),(22,37,'Godawari','If we get the cash support\r\nsoon then we can start\r\nreconstructing house.',NULL,25),(23,37,'Deurali N.P','I need second installement as\r\nsoon as possible.',NULL,21),(24,37,'Suryabinayak','We need lumpsum cash in one\r\ninstallment.',NULL,26),(25,21,'Phulkharka','Why is the government taking\r\nso much time to distribute\r\ncash support?',NULL,30),(26,21,'Boch','There is too much delay in\r\ndistribution of the second\r\ninstallment',NULL,22),(27,38,'Gumda','We are somehow fullfling our\r\ndaily food needs. There is not\r\nmuch difficulty for small nuclear\r\nfamilies, but it is difficult for\r\nlarge/extended families.',NULL,36),(28,28,'Gumda','We are somehow fulfilling our\r\ndaily food needs. There is not\r\nmuch difficulty for small nuclear\r\nfamilies, but it is difficult for\r\nlarge/extended families.',NULL,36),(29,28,'Baseri','We need a proper irrigation channel.',NULL,30),(30,28,'Sitalpati','We have difficulty in access to\r\nfood. We want food.',NULL,20),(31,30,'Gumda','Will government provide\r\nemployment opportunities\r\nto the earthquake affected families?',NULL,36),(32,30,'Boch','I think self-employment\r\nopportunities are required.',NULL,22),(33,30,'Pangretar','I do not have any source of income so i am unable to reconstruct my\r\nhouse. I expect government help.',NULL,23),(34,31,'Gumda','Due to earthquake I lost my\r\nseed, food and grain store\r\ninside my house and I have\r\nhad to take a loan to\r\ncomplete the house.',NULL,36);
/*!40000 ALTER TABLE `issue_map_sayings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_news`
--

DROP TABLE IF EXISTS `issue_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `imageUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `audioUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtubeUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `audioName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4534519C989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_news`
--

LOCK TABLES `issue_news` WRITE;
/*!40000 ALTER TABLE `issue_news` DISABLE KEYS */;
INSERT INTO `issue_news` VALUES (6,'Nepal Community Feedback on Protection: June 2017','<p>Short on time? Catch the highlights of the Protection, June 2017 report in this short video</p>',NULL,NULL,'https://www.youtube.com/watch?v=bGgO-vxos2Q','2017-07-04 17:51:40',NULL,'Nepal-Community-Feedback-on-Protection-June-2017',NULL,NULL),(7,'Correction or Exception Manual for Masonary Structure','<p>Correction/Exception Manual for Masonary Structure for<br />\r\nhouses that have been built under the HOUSING RECONSTRUCTION PROGRAMME.&nbsp;</p>','Screen Shot 2017-07-05 at 12.01.52 PM-July-5-2017-12-08-57.png',NULL,NULL,'2017-07-05 12:08:57','2017-07-05 16:06:09','Correction-Exception-Manual-for-Masonary-Structure',NULL,'http://bit.ly/2r41ZcR'),(8,'Information from Ministry of Urban Development (MoUD)','<p>Information from Ministry of Urban Development (MoUD) regarding first and second tranche.&nbsp;</p>','18762842_329640977470446_7078648510932844544_n-July-5-2017-12-18-57.jpg',NULL,NULL,'2017-07-05 12:18:58','2017-07-05 16:06:41','Information-from-Ministry-of-Urban-Development-MoUD',NULL,'http://202.45.144.197/nfdnfis/clpiu/index.htm'),(9,'Reconstruction - May 2017 Report','<p>Check out the latest report on earthquake affected communities perceptions on reconstruction related issues from the Common Feedback Project.&nbsp;</p>','Screen Shot 2017-07-05 at 12.21.53 PM-July-5-2017-12-22-14.png',NULL,NULL,'2017-07-05 12:22:14','2017-07-05 16:07:07','reconstruction-may-2017-report',NULL,'http://bit.ly/2rD3Lgx'),(10,'Post-quake Nepal: No country for old women','<p>An interesting article citing CFP findings that draws attention to women, and particularly older women&#39;s, issues of inclusion in the reconstruction process.&nbsp;</p>','nepal_elderly_4-July-5-2017-12-25-38.jpg',NULL,NULL,'2017-07-05 12:25:38','2017-07-05 16:07:27','post-quake-nepal-no-country-old-women',NULL,'https://www.irinnews.org/feature/2017/03/01/post-quake-nepal-no-country-old-women'),(11,'Community Perceptions of the Reconstruction','<p>It was great to present our latest report on Community Perceptions of the Reconstruction at Oxfam&rsquo;s Humanitarian Team Planning Meeting this morning. Thank you&nbsp;<a href=\"https://www.facebook.com/OxfamInNepal/\">Oxfam in Nepal</a>&nbsp;for your consistent commitment to include the voices of affected people in your planning. It was amazing to get so many thoughtful questions and see such a high level of engagement and interest in how to better serve earthquake affected communities.&nbsp;<br />\r\n<br />\r\nRead our latest report for yourself, here:&nbsp;<a href=\"http://cfp.org.np/uploads/documents/Reconstruction1-February-10-2017-18-00-36.pdf\" onclick=\"LinkshimAsyncLink.referrer_log(this, &quot;http:\\/\\/cfp.org.np\\/uploads\\/documents\\/Reconstruction1-February-10-2017-18-00-36.pdf&quot;, &quot;\\/si\\/ajax\\/l\\/render_linkshim_log\\/?u=http\\u00253A\\u00252F\\u00252Fcfp.org.np\\u00252Fuploads\\u00252Fdocuments\\u00252FReconstruction1-February-10-2017-18-00-36.pdf&amp;h=ATO5KrVg3jH6Js56cB79a2BYf2wIxvDqZeQrOQQL0PN6OvxcqzwxUvWVzJgHyobSwh9iC-_mI8DHcaw20U4SVdz3YKdipD_yMDFpOpgTyfv5ebww8IOXirSY9GUw__a9Ry1fA219crmJods&amp;enc=AZOjI3leL45DbFWIPxjiuEnJAGJX0RKP7CsmEq4fapjDfiAURWd1npltGe7qJ02c08ptMXJeadYur-6dbd13My7XJuAFK8iEMDu6TiLjaJZ5xfnNvHhCswU5RQqFGqd3K5LrbX_f5HMPGYwBgduq7twT&amp;d&quot;);\" rel=\"nofollow noopener nofollow\" target=\"_blank\">http://cfp.org.np/uploads/documents/Reconstruction1-February-10-2017-18-00-36.pdf</a></p>','Communities-Perception-July-5-2017-12-29-05.jpg',NULL,NULL,'2017-07-05 12:29:05','2017-07-06 12:08:46','Community-Perceptions-of-the-Reconstruction',NULL,NULL);
/*!40000 ALTER TABLE `issue_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_people`
--

DROP TABLE IF EXISTS `issue_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_question_id` int(11) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `saying` longtext COLLATE utf8_unicode_ci NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DAE6E0017C6CA31B` (`issue_question_id`),
  KEY `IDX_DAE6E001B08FA272` (`district_id`),
  CONSTRAINT `FK_DAE6E0017C6CA31B` FOREIGN KEY (`issue_question_id`) REFERENCES `issue_question` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_DAE6E001B08FA272` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_people`
--

LOCK TABLES `issue_people` WRITE;
/*!40000 ALTER TABLE `issue_people` DISABLE KEYS */;
INSERT INTO `issue_people` VALUES (1,1,'Fulpingkatti, Sindhupalchowk','There is scarcity of water, due to which it is difficult to reconstruct our house.',23);
/*!40000 ALTER TABLE `issue_people` ENABLE KEYS */;
UNLOCK TABLES;




ALTER TABLE district ADD color VARCHAR(255) NOT NULL;

INSERT INTO `page` (`slug`, `title`, `description`, `path`) VALUES
('perception-survey-methodology', '<p>PERCEPTION SURVEY METHODOLOGY</p>', '<p>To undertake the Community Perception Survey, 40 enumerators were trained over five days and deployed across the 14 priority earthquake affected districts to collect data over the course of 12 days from a total of 2100 respondents using a probability proportionate to size (PPS) methodology. All data collection is completed with mobile tablets using KoBoToolbox.<br></p><p><br></p><h4>Sampling<br></h4><p>All VDCs in the 14 priority affected districts in which 60 percent or more of the households are eligible for the housing reconstruction grant will be considered part of the survey’s operating area, and eligible for random selection. <br></p><p>The population of each district will be considered the total population of all eligible VDCs, as per the 2011 census. The first 2000 samples of the survey will then be distributed by district proportionally. <br></p><p>The remaining 100 surveys will be allocated to districts where the total proportional sample size is under 100 respondents, in order to boost the population for an adequate district level analysis of the findings. <br></p><p>The number of VDCs selected in each district will vary, depending upon the number of samples allocated to each district. Each VDC will have a minimum of two wards sampled, and each ward a minimum of 10 surveys completed. Both VDCs and wards will be randomly selected from the list of eligible VDCs. <br></p><p>Twenty-five percent of the total sample will be allocated for municipalities, and municipalities will be randomly selected where there is more than one municipality in a district. In municipalities a minimum of three wards will be sampled, with a minimum of 10 surveys collected per ward.<br></p><p><br></p><h4>Selection of households and respondents<br></h4><p>Once wards have been selected, enumerators will identify an entry point in their given ward, targeting aschool, temple or other communal spot to initiate the individual interview process. At that point they will spin a bottle. The enumerator will walk in the direction the bottle points to once it has finished spinning until a home is found to initiate the interview process. <br></p><p>The first house selected will form a basis to identify other households to complete the survey of that ward. After identifying a first house for interview then enumerator will leave the house, turn right and skip the next two houses, completing the next interview at the third house. The enumerator will have leverage to move to next adjoining ward to complete the interview process if in the ward the sample household numbers are not covered. <br></p><p>Once in the household enumerators interviews an individual aged 15 years and above from the pool of all eligible respondents present in the home at the time of the survey. The enumerators select respondents from different age groups and genders at each home, to ensure the sample is demographically diverse and reflects the population from the survey area.<br></p>', NULL);