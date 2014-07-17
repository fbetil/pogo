<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'sessions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.pogo.map
 */
class SessionsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.SessionsTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('sessions');
        $this->setPhpName('Sessions');
        $this->setClassname('PoGo\\Sessions');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('session_id', 'Id', 'VARCHAR', true, 40, '0');
        $this->addColumn('ip_address', 'IpAddress', 'VARCHAR', true, 45, '0');
        $this->addColumn('user_agent', 'UserAgent', 'VARCHAR', true, 120, null);
        $this->addColumn('last_activity', 'LastActivity', 'INTEGER', true, null, 0);
        $this->addColumn('user_data', 'UserData', 'LONGVARCHAR', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // SessionsTableMap
