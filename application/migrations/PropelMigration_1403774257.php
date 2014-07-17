<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1403774257.
 * Generated on 2014-06-26 11:17:37 
 */
class PropelMigration_1403774257
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
    ADD `fileversion` INTEGER NOT NULL AFTER `filesize`,
    ADD `actorid` INTEGER NOT NULL AFTER `fileversion`;

CREATE INDEX `files_FI_1` ON `files` (`actorid`);

ALTER TABLE `projects` DROP `projectprogress`;

ALTER TABLE `tasks`
    ADD `taskprogress` INTEGER NOT NULL AFTER `taskenddate`;

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

DROP INDEX `files_FI_1` ON `files`;

ALTER TABLE `files` DROP `fileversion`;

ALTER TABLE `files` DROP `actorid`;

ALTER TABLE `projects`
    ADD `projectprogress` DATE NOT NULL AFTER `projectenddate`;

ALTER TABLE `tasks` DROP `taskprogress`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}