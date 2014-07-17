<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'profiles' table.
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
class ProfilesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.ProfilesTableMap';

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
        $this->setName('profiles');
        $this->setPhpName('Profiles');
        $this->setClassname('PoGo\\Profiles');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('profileid', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('profilename', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('profilecomment', 'Comment', 'VARCHAR', false, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserProfile', 'PoGo\\UserProfile', RelationMap::ONE_TO_MANY, array('profileid' => 'profileid', ), null, null, 'UserProfiles');
        $this->addRelation('ProfileRole', 'PoGo\\ProfileRole', RelationMap::ONE_TO_MANY, array('profileid' => 'profileid', ), null, null, 'ProfileRoles');
    } // buildRelations()

} // ProfilesTableMap
