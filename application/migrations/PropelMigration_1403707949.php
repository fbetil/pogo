<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1403707949.
 * Generated on 2014-06-25 16:52:29 
 */
class PropelMigration_1403707949
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

ALTER TABLE `milestones` CHANGE `milestonestartdate` `milestonestartdate` DATE NOT NULL;

ALTER TABLE `milestones` CHANGE `milestoneduedate` `milestoneduedate` DATE NOT NULL;

ALTER TABLE `notes`
    ADD `actorid` INTEGER NOT NULL AFTER `notecontent`;

CREATE INDEX `notes_FI_1` ON `notes` (`actorid`);

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

ALTER TABLE `milestones` CHANGE `milestonestartdate` `milestonestartdate` DATE;

ALTER TABLE `milestones` CHANGE `milestoneduedate` `milestoneduedate` DATE;

DROP INDEX `notes_FI_1` ON `notes`;

ALTER TABLE `notes` DROP `actorid`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}