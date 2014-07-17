<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'users' table.
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
class UsersTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.UsersTableMap';

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
        $this->setName('users');
        $this->setPhpName('Users');
        $this->setClassname('PoGo\\Users');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('userid', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('userlogin', 'Login', 'VARCHAR', true, 20, null);
        $this->addColumn('userfirstname', 'FirstName', 'VARCHAR', true, 50, null);
        $this->addColumn('username', 'Name', 'VARCHAR', true, 50, null);
        $this->addColumn('userpassword', 'Password', 'VARCHAR', true, 32, null);
        $this->addColumn('useremail', 'Email', 'VARCHAR', true, 50, null);
        $this->addForeignKey('actorid', 'ActorId', 'INTEGER', 'actors', 'actorid', true, null, null);
        $this->addColumn('userproperties', 'Properties', 'LONGVARCHAR', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Actor', 'PoGo\\Actors', RelationMap::MANY_TO_ONE, array('actorid' => 'actorid', ), null, null);
        $this->addRelation('UserProfile', 'PoGo\\UserProfile', RelationMap::ONE_TO_MANY, array('userid' => 'userid', ), null, null, 'UserProfiles');
    } // buildRelations()

} // UsersTableMap
