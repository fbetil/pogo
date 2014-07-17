<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1405522888.
 * Generated on 2014-07-16 17:01:28 
 */
class PropelMigration_1405522888
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'pogo' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `files`;

DROP TABLE IF EXISTS `milestones`;

DROP TABLE IF EXISTS `notes`;

DROP TABLE IF EXISTS `tasks`;

DROP TABLE IF EXISTS `users`;

RENAME TABLE `projects` TO `project`;

RENAME TABLE `actors` TO `actor`;

RENAME TABLE `profiles` TO `profile`;

RENAME TABLE `roles` TO `role`;

RENAME TABLE `sessions` TO `session`;

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

CREATE TABLE `milestone`
(
    `milestoneid` INTEGER NOT NULL AUTO_INCREMENT,
    `milestonename` VARCHAR(255) NOT NULL,
    `milestonedescription` TEXT,
    `milestoneduedate` DATE NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`milestoneid`),
    INDEX `milestone_FI_1` (`projectid`)
) ENGINE=MyISAM;

CREATE TABLE `task`
(
    `taskid` INTEGER NOT NULL AUTO_INCREMENT,
    `taskname` VARCHAR(255) NOT NULL,
    `taskdescription` TEXT,
    `taskstartdate` DATE,
    `taskduedate` DATE,
    `taskprogress` INTEGER NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`taskid`),
    INDEX `task_FI_1` (`projectid`)
) ENGINE=MyISAM;

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

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'pogo' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `file`;

DROP TABLE IF EXISTS `milestone`;

DROP TABLE IF EXISTS `task`;

DROP TABLE IF EXISTS `note`;

DROP TABLE IF EXISTS `user`;

RENAME TABLE `project` TO `projects`;

RENAME TABLE `actor` TO `actors`;

RENAME TABLE `profile` TO `profiles`;

RENAME TABLE `role` TO `roles`;

RENAME TABLE `session` TO `sessions`;

CREATE TABLE `files`
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
    INDEX `files_FI_1` (`actorid`),
    INDEX `files_FI_2` (`projectid`)
) ENGINE=MyISAM;

CREATE TABLE `milestones`
(
    `milestoneid` INTEGER NOT NULL AUTO_INCREMENT,
    `milestonename` VARCHAR(255) NOT NULL,
    `milestonedescription` TEXT,
    `milestoneduedate` DATE NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`milestoneid`),
    INDEX `milestones_FI_1` (`projectid`)
) ENGINE=MyISAM;

CREATE TABLE `notes`
(
    `noteid` INTEGER NOT NULL AUTO_INCREMENT,
    `notename` TEXT NOT NULL,
    `notecontent` TEXT NOT NULL,
    `actorid` INTEGER NOT NULL,
    `notepublishedat` DATETIME NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`noteid`),
    INDEX `notes_FI_1` (`actorid`),
    INDEX `notes_FI_2` (`projectid`)
) ENGINE=MyISAM;

CREATE TABLE `tasks`
(
    `taskid` INTEGER NOT NULL AUTO_INCREMENT,
    `taskname` VARCHAR(255) NOT NULL,
    `taskdescription` TEXT,
    `taskstartdate` DATE,
    `taskduedate` DATE,
    `taskprogress` INTEGER NOT NULL,
    `projectid` INTEGER NOT NULL,
    PRIMARY KEY (`taskid`),
    INDEX `tasks_FI_1` (`projectid`)
) ENGINE=MyISAM;

CREATE TABLE `users`
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
    UNIQUE INDEX `indexlogin` (`userlogin`(20)),
    UNIQUE INDEX `indexactorid` (`actorid`),
    UNIQUE INDEX `indexuseremail` (`useremail`(50))
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}