<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1403699918.
 * Generated on 2014-06-25 14:38:38 
 */
class PropelMigration_1403699918
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

ALTER TABLE `files`
    ADD `filesize` INTEGER NOT NULL AFTER `filemimetype`;

ALTER TABLE `projects` CHANGE `projectcomment` `projectdescription` TEXT;

ALTER TABLE `projects`
    ADD `projectcode` VARCHAR(50) NOT NULL AFTER `projectid`,
    ADD `projectstartdate` DATE NOT NULL AFTER `projectdescription`,
    ADD `projectduedate` DATE AFTER `projectstartdate`,
    ADD `projectenddate` DATE AFTER `projectduedate`,
    ADD `projectprogress` DATE NOT NULL AFTER `projectenddate`;

CREATE TABLE `milestones`
(
    `milestoneid` INTEGER NOT NULL AUTO_INCREMENT,
    `milestonename` VARCHAR(255) NOT NULL,
    `milestonedescription` TEXT,
    `milestonestartdate` DATE,
    `milestoneduedate` DATE,
    `milestoneenddate` DATE,
    PRIMARY KEY (`milestoneid`)
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

DROP TABLE IF EXISTS `milestones`;

DROP TABLE IF EXISTS `project_milestone`;

ALTER TABLE `files` DROP `filesize`;

ALTER TABLE `projects` CHANGE `projectdescription` `projectcomment` TEXT;

ALTER TABLE `projects` DROP `projectcode`;

ALTER TABLE `projects` DROP `projectstartdate`;

ALTER TABLE `projects` DROP `projectduedate`;

ALTER TABLE `projects` DROP `projectenddate`;

ALTER TABLE `projects` DROP `projectprogress`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}