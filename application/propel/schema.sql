
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- project
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project`
(
    `projectid` INTEGER NOT NULL AUTO_INCREMENT,
    `projectcode` VARCHAR(14) NOT NULL,
    `projectname` VARCHAR(255) NOT NULL,
    `projectdescription` TEXT,
    PRIMARY KEY (`projectid`),
    UNIQUE INDEX `indexcode` (`projectcode`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- project_actor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `project_actor`;

CREATE TABLE `project_actor`
(
    `projectactorid` INTEGER NOT NULL AUTO_INCREMENT,
    `projectid` INTEGER NOT NULL,
    `actorid` INTEGER NOT NULL,
    `projectactorrole` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`projectactorid`),
    INDEX `project_actor_FI_1` (`projectid`),
    INDEX `project_actor_FI_2` (`actorid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- actor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `actor`;

CREATE TABLE `actor`
(
    `actorid` INTEGER NOT NULL AUTO_INCREMENT,
    `actorfirstname` VARCHAR(50) NOT NULL,
    `actorname` VARCHAR(50) NOT NULL,
    `actororganization` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`actorid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- file
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file`
(
    `fileid` INTEGER NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(255) NOT NULL,
    `filefolder` VARCHAR(255),
    `filecontent` LONGBLOB NOT NULL,
    `filemimetype` VARCHAR(255) NOT NULL,
    `filesize` INTEGER NOT NULL,
    `fileversion` INTEGER NOT NULL,
    `actorid` INTEGER NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`fileid`),
    INDEX `file_FI_1` (`actorid`),
    INDEX `file_FI_2` (`projectid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- milestone
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `milestone`;

CREATE TABLE `milestone`
(
    `milestoneid` INTEGER NOT NULL AUTO_INCREMENT,
    `milestonename` VARCHAR(255) NOT NULL,
    `milestonedescription` TEXT,
    `milestoneduedate` DATETIME NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`milestoneid`),
    INDEX `milestone_FI_1` (`projectid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- task
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `task`;

CREATE TABLE `task`
(
    `taskid` INTEGER NOT NULL AUTO_INCREMENT,
    `taskname` VARCHAR(255) NOT NULL,
    `taskdescription` TEXT,
    `taskstartdate` DATETIME,
    `taskduedate` DATETIME,
    `taskprogress` INTEGER NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`taskid`),
    INDEX `task_FI_1` (`projectid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- task_actor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `task_actor`;

CREATE TABLE `task_actor`
(
    `taskactorid` INTEGER NOT NULL AUTO_INCREMENT,
    `taskid` INTEGER NOT NULL,
    `actorid` INTEGER NOT NULL,
    PRIMARY KEY (`taskactorid`),
    INDEX `task_actor_FI_1` (`taskid`),
    INDEX `task_actor_FI_2` (`actorid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- note
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `note`;

CREATE TABLE `note`
(
    `noteid` INTEGER NOT NULL AUTO_INCREMENT,
    `notename` TEXT NOT NULL,
    `notecontent` TEXT NOT NULL,
    `actorid` INTEGER NOT NULL,
    `notepublishedat` DATETIME NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`noteid`),
    INDEX `note_FI_1` (`actorid`),
    INDEX `note_FI_2` (`projectid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `userid` INTEGER NOT NULL AUTO_INCREMENT,
    `userlogin` VARCHAR(20) NOT NULL,
    `userfirstname` VARCHAR(50) NOT NULL,
    `username` VARCHAR(50) NOT NULL,
    `userpassword` VARCHAR(32) NOT NULL,
    `useremail` VARCHAR(50) NOT NULL,
    `actorid` INTEGER NOT NULL,
    `userproperties` TEXT NOT NULL,
    PRIMARY KEY (`userid`),
    UNIQUE INDEX `indexlogin` (`userlogin`),
    UNIQUE INDEX `indexemail` (`useremail`),
    UNIQUE INDEX `indexactorid` (`actorid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile`
(
    `profileid` INTEGER NOT NULL AUTO_INCREMENT,
    `profilename` VARCHAR(255) NOT NULL,
    `profilecomment` VARCHAR(255),
    PRIMARY KEY (`profileid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role`
(
    `roleid` INTEGER NOT NULL AUTO_INCREMENT,
    `rolename` VARCHAR(255) NOT NULL,
    `rolecomment` VARCHAR(255),
    PRIMARY KEY (`roleid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile`
(
    `userprofileid` INTEGER NOT NULL AUTO_INCREMENT,
    `userid` INTEGER NOT NULL,
    `profileid` INTEGER NOT NULL,
    PRIMARY KEY (`userprofileid`),
    INDEX `user_profile_FI_1` (`userid`),
    INDEX `user_profile_FI_2` (`profileid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- profile_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `profile_role`;

CREATE TABLE `profile_role`
(
    `profileroleid` INTEGER NOT NULL AUTO_INCREMENT,
    `profileid` INTEGER NOT NULL,
    `roleid` INTEGER NOT NULL,
    `profilerolerestrictions` TEXT,
    PRIMARY KEY (`profileroleid`),
    INDEX `profile_role_FI_1` (`profileid`),
    INDEX `profile_role_FI_2` (`roleid`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- session
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session`
(
    `session_id` VARCHAR(40) DEFAULT '0' NOT NULL,
    `ip_address` VARCHAR(45) DEFAULT '0' NOT NULL,
    `user_agent` VARCHAR(120) NOT NULL,
    `last_activity` INTEGER DEFAULT 0 NOT NULL,
    `user_data` TEXT NOT NULL,
    PRIMARY KEY (`session_id`),
    INDEX `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
