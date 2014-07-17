<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1403703531.
 * Generated on 2014-06-25 15:38:51 
 */
class PropelMigration_1403703531
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

CREATE TABLE `project_task`
(
    `projecttaskid` INTEGER NOT NULL AUTO_INCREMENT,
    `projectid` INTEGER NOT NULL,
    `taskid` INTEGER NOT NULL,
    PRIMARY KEY (`projecttaskid`),
    INDEX `project_task_FI_1` (`projectid`),
    INDEX `project_task_FI_2` (`taskid`)
) ENGINE=MyISAM;

CREATE TABLE `project_note`
(
    `projectnoteid` INTEGER NOT NULL AUTO_INCREMENT,
    `projectid` INTEGER NOT NULL,
    `noteid` INTEGER NOT NULL,
    PRIMARY KEY (`projectnoteid`),
    INDEX `project_note_FI_1` (`projectid`),
    INDEX `project_note_FI_2` (`noteid`)
) ENGINE=MyISAM;

CREATE TABLE `tasks`
(
    `taskid` INTEGER NOT NULL AUTO_INCREMENT,
    `taskname` VARCHAR(255) NOT NULL,
    `taskdescription` TEXT,
    `taskstartdate` DATE,
    `taskduedate` DATE,
    `taskenddate` DATE,
    PRIMARY KEY (`taskid`)
) ENGINE=MyISAM;

CREATE TABLE `task_actor`
(
    `taskactorid` INTEGER NOT NULL AUTO_INCREMENT,
    `taskid` INTEGER NOT NULL,
    `actorid` INTEGER NOT NULL,
    PRIMARY KEY (`taskactorid`),
    INDEX `task_actor_FI_1` (`taskid`),
    INDEX `task_actor_FI_2` (`actorid`)
) ENGINE=MyISAM;

CREATE TABLE `notes`
(
    `noteid` INTEGER NOT NULL AUTO_INCREMENT,
    `notename` VARCHAR(255) NOT NULL,
    `notecontent` TEXT,
    `notepublishedat` DATETIME,
    PRIMARY KEY (`noteid`)
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

DROP TABLE IF EXISTS `project_task`;

DROP TABLE IF EXISTS `project_note`;

DROP TABLE IF EXISTS `tasks`;

DROP TABLE IF EXISTS `task_actor`;

DROP TABLE IF EXISTS `notes`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}