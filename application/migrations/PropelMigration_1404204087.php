<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1404204087.
 * Generated on 2014-07-01 10:41:27 
 */
class PropelMigration_1404204087
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

ALTER TABLE `notes` CHANGE `notename` `notename` TEXT NOT NULL;

ALTER TABLE `notes` CHANGE `notecontent` `notecontent` TEXT NOT NULL;

ALTER TABLE `notes` CHANGE `notepublishedat` `notepublishedat` DATETIME NOT NULL;

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

ALTER TABLE `notes` CHANGE `notename` `notename` VARCHAR(255) NOT NULL;

ALTER TABLE `notes` CHANGE `notecontent` `notecontent` TEXT;

ALTER TABLE `notes` CHANGE `notepublishedat` `notepublishedat` DATETIME;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}