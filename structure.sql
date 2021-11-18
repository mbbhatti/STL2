SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `localization`;
CREATE TABLE `localization` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `locale` varchar(255) NOT NULL,
    `key` varchar(255) NOT NULL,
    `text` text NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE `configuration` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `key` varchar(255) NOT NULL,
    `value` text NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `group_configuration`;
CREATE TABLE `group_configuration` (
    `group` int(11) NOT NULL,
    `configuration` int(11) NOT NULL,
    KEY `fk_group_configuration_group` (`group`),
    KEY `fk_group_configuration_feature` (`configuration`),
    CONSTRAINT `fk_group_configuration_feature` FOREIGN KEY (`configuration`) REFERENCES `configuration` (`id`),
    CONSTRAINT `fk_group_configuration_group` FOREIGN KEY (`group`) REFERENCES `group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `study`;
CREATE TABLE `study` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `published` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `key_hash` varchar(255) NOT NULL,
    `group` int(11) NOT NULL,
    `study` int(11) NOT NULL,
    `left_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_user_group FOREIGN KEY (`group`) REFERENCES `group` (`id`),
    KEY `fk_user_study` (`study`),
    CONSTRAINT `fk_user_study` FOREIGN KEY (`study`) REFERENCES `study` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `next_group`;
CREATE TABLE `next_group` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `group_name` varchar(255) NOT NULL,
    `used` int(1) NOT NULL DEFAULT '0',
    `invalid` int(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `questionnaire`;
CREATE TABLE `questionnaire` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `label` varchar(255) NOT NULL,
    `order` int(11) NOT NULL,
    `moment` enum('baseline','daily_calculated_five_days_before_menstruation','calculated_five_days_before_menstruation','calculated_first_day_of_menstruation','daily_during_menstruation','end_of_each_menstruation','end_of_every_third_menstruation', 'miscellaneous') NOT NULL,
    `study` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_questionnaire_study` (`study`),
    CONSTRAINT `fk_questionnaire_study` FOREIGN KEY (`study`) REFERENCES `study` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `meta_question`;
CREATE TABLE `meta_question` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `label` varchar(255) DEFAULT NULL,
    `moment` varchar(255) NOT NULL,
    `published` int(11) NOT NULL,
    `order` int(11) NOT NULL,
    `headline` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `questionnaire_meta_question`;
CREATE TABLE `questionnaire_meta_question` (
    `questionnaire` int(11) NOT NULL,
    `meta_question` int(11) NOT NULL,
    KEY `fk_questionnaire_meta_question_questionnaire` (`questionnaire`),
    KEY `fk_questionnaire_meta_question_meta_question` (`meta_question`),
    CONSTRAINT `fk_questionnaire_meta_question_meta_question` FOREIGN KEY (`meta_question`) REFERENCES `meta_question` (`id`),
    CONSTRAINT `fk_questionnaire_meta_question_questionnaire` FOREIGN KEY (`questionnaire`) REFERENCES `questionnaire` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `meta_question_group`;
CREATE TABLE `meta_question_group` (
    `meta_question` int(11) NOT NULL,
    `group` int(11) NOT NULL,
    KEY `fk_meta_question_group_group` (`group`),
    KEY `fk_meta_question_group_meta_question` (`meta_question`),
    CONSTRAINT `fk_meta_question_group_group` FOREIGN KEY (`group`) REFERENCES `group` (`id`),
    CONSTRAINT `fk_meta_question_group_meta_question` FOREIGN KEY (`meta_question`) REFERENCES `meta_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `free_input_question`;
CREATE TABLE `free_input_question` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `meta_question` int(11) NOT NULL,
    `text` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
    `answer_id` varchar(255) NOT NULL,
    `min` int(11) DEFAULT NULL,
    `max` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_free_input_question_meta_question` (`meta_question`),
    CONSTRAINT `fk_free_input_question_meta_question` FOREIGN KEY (`meta_question`) REFERENCES `meta_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `choice_question`;
CREATE TABLE `choice_question` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `meta_question` int(11) NOT NULL,
    `type` varchar(255) NOT NULL,
    `answer_id` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_choice_question_meta_question` (`meta_question`),
    CONSTRAINT `fk_choice_question_meta_question` FOREIGN KEY (`meta_question`) REFERENCES `meta_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `choice`;
CREATE TABLE `choice` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `text` varchar(255) DEFAULT NULL,
    `order` int(11) NOT NULL,
    `type` varchar(255) DEFAULT 'choice',
    `answer_id` varchar(255) DEFAULT NULL,
    `answer_value` varchar(255) DEFAULT NULL,
    `meta_question` int(11) DEFAULT NULL,
    `min` int(11) DEFAULT NULL,
    `max` int(11) DEFAULT NULL,
    `default` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_meta_question` (`meta_question`),
    CONSTRAINT `fk_meta_question` FOREIGN KEY (`meta_question`) REFERENCES `meta_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `choice_question_choice`;
CREATE TABLE `choice_question_choice` (
    `choice_question` int(11) NOT NULL,
    `choice` int(11) NOT NULL,
    KEY `fk_choice_question_choice_choice_question` (`choice_question`),
    KEY `fk_choice_question_choice_choice` (`choice`),
    CONSTRAINT `fk_choice_question_choice_choice_question` FOREIGN KEY (`choice_question`) REFERENCES `choice_question` (`id`),
    CONSTRAINT `fk_choice_question_choice_choice` FOREIGN KEY (`choice`) REFERENCES `choice` (`id`)
);

DROP TABLE IF EXISTS `scale_question`;
CREATE TABLE `scale_question` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `meta_question`int(11) NOT NULL,
    `min_text` VARCHAR(255) NOT NULL,
    `min_value` int(11) NOT NULL,
    `max_text` VARCHAR(255) NOT NULL,
    `max_value` int(11) NOT NULL,
    `answer_id` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_scale_question_meta_question` (`meta_question`),
    CONSTRAINT `fk_scale_question_meta_question` FOREIGN KEY (`meta_question`) REFERENCES `meta_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `answer` varchar(255) DEFAULT NULL,
    `answer_id` varchar(255) NOT NULL,
    `cycle` int(11) DEFAULT NULL,
    `day` int(11) DEFAULT NULL,
    `user` int(11) NOT NULL,
    `study` int(11) NOT NULL,
    `app_version` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user` (`user`),
    CONSTRAINT `fk_answer_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
    CONSTRAINT `fk_answer_study` FOREIGN KEY (`study`) REFERENCES `study` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `feature`;
CREATE TABLE `feature` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `version` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `group_feature`;
CREATE TABLE `group_feature` (
    `group` int(11) NOT NULL,
    `feature` int(11) NOT NULL,
    KEY `fk_group_feature_group` (`group`),
    KEY `fk_group_feature_feature` (`feature`),
    CONSTRAINT `fk_group_feature_group` FOREIGN KEY (`group`) REFERENCES `group` (`id`),
    CONSTRAINT `fk_group_feature_feature` FOREIGN KEY (`feature`) REFERENCES `feature` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
