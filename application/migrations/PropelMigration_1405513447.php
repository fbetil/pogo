<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1405513447.
 * Generated on 2014-07-16 14:24:07 
 */
class PropelMigration_1405513447
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

DROP TABLE IF EXISTS `project_file`;

DROP TABLE IF EXISTS `project_milestone`;

DROP TABLE IF EXISTS `project_note`;

DROP TABLE IF EXISTS `project_task`;

DROP TABLE IF EXISTS `status`;

ALTER TABLE `files`
    ADD `projectid` INTEGER NOT NULL AFTER `actorid`;

CREATE INDEX `files_FI_2` ON `files` (`projectid`);

ALTER TABLE `milestones`
    ADD `projectid` INTEGER NOT NULL AFTER `milestoneduedate`;

CREATE INDEX `milestones_FI_1` ON `milestones` (`projectid`);

ALTER TABLE `notes`
    ADD `projectid` INTEGER NOT NULL AFTER `notepublishedat`;

CREATE INDEX `notes_FI_2` ON `notes` (`projectid`);

ALTER TABLE `tasks`
    ADD `projectid` INTEGER NOT NULL AFTER `taskprogress`;

CREATE INDEX `tasks_FI_1` ON `tasks` (`projectid`);

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

DROP INDEX `files_FI_2` ON `files`;

ALTER TABLE `files` DROP `projectid`;

DROP INDEX `milestones_FI_1` ON `milestones`;

ALTER TABLE `milestones` DROP `projectid`;

DROP INDEX `notes_FI_2` ON `notes`;

ALTER TABLE `notes` DROP `projectid`;

DROP INDEX `tasks_FI_1` ON `tasks`;

ALTER TABLE `tasks` DROP `projectid`;

CREATE TABLE `project_file`
(
    `projectfileid` INTEGER NOT NULL AUTO_INCREMENT,
    `projectid` INTEGER NOT NULL,
    `fileid` INTEGER NOT NULL,
    PRIMARY KEY (`projectfileid`),
    INDEX `project_file_FI_1` (`projectid`),
    INDEX `project_file_FI_2` (`fileid`)
) ENGINE=MyISAM;

CREATE TABLE `project_milestone`
(
    `projectmilestoneid` INTEGER NOT NULL AUTO_INCREMENT,
    `projectid` INTEGER NOT NULL,
    `milestoneid` INTEGER NOT NULL,
    PRIMARY KEY (`projectmilestoneid`),
    INDEX `project_milestone_FI_1` (`projectid`),
    INDEX `project_milestone_FI_2` (`milestoneid`)
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

CREATE TABLE `project_task`
(
    `projecttaskid` INTEGER NOT NULL AUTO_INCREMENT,
    `projectid` INTEGER NOT NULL,
    `taskid` INTEGER NOT NULL,
    PRIMARY KEY (`projecttaskid`),
    INDEX `project_task_FI_1` (`projectid`),
    INDEX `project_task_FI_2` (`taskid`)
) ENGINE=MyISAM;

CREATE TABLE `status`
(
    `statusid` INTEGER NOT NULL AUTO_INCREMENT,
    `statuscode` VARCHAR(1) NOT NULL,
    `statuslabel` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`statusid`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}