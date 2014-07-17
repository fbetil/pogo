<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1404468164.
 * Generated on 2014-07-04 12:02:44 
 */
class PropelMigration_1404468164
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

ALTER TABLE `milestones` DROP `milestonestartdate`;

ALTER TABLE `milestones` DROP `milestoneenddate`;

ALTER TABLE `tasks` DROP `taskenddate`;

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

ALTER TABLE `milestones`
    ADD `milestonestartdate` DATE NOT NULL AFTER `milestonedescription`,
    ADD `milestoneenddate` DATE AFTER `milestoneduedate`;

ALTER TABLE `tasks`
    ADD `taskenddate` DATE AFTER `taskduedate`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}