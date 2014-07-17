<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1405579252.
 * Generated on 2014-07-17 08:40:52 
 */
class PropelMigration_1405579252
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

DROP TABLE IF EXISTS `typeactorrole`;

DROP INDEX `project_actor_FI_3` ON `project_actor`;

ALTER TABLE `project_actor`
    ADD `projectactorrole` VARCHAR(255) NOT NULL AFTER `actorid`;

ALTER TABLE `project_actor` DROP `typeactorroleid`;

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

ALTER TABLE `project_actor`
    ADD `typeactorroleid` INTEGER NOT NULL AFTER `actorid`;

ALTER TABLE `project_actor` DROP `projectactorrole`;

CREATE INDEX `project_actor_FI_3` ON `project_actor` (`typeactorroleid`);

CREATE TABLE `typeactorrole`
(
    `typeactorroleid` INTEGER NOT NULL AUTO_INCREMENT,
    `typeactorrolecode` VARCHAR(5) NOT NULL,
    `typeactorrolelabel` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`typeactorroleid`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}