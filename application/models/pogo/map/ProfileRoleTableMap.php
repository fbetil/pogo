<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'profile_role' table.
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
class ProfileRoleTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.ProfileRoleTableMap';

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
        $this->setName('profile_role');
        $this->setPhpName('ProfileRole');
        $this->setClassname('PoGo\\ProfileRole');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('profileroleid', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('profileid', 'ProfileId', 'INTEGER', 'profile', 'profileid', true, null, null);
        $this->addForeignKey('roleid', 'RoleId', 'INTEGER', 'role', 'roleid', true, null, null);
        $this->addColumn('profilerolerestrictions', 'Restrictions', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Profile', 'PoGo\\Profile', RelationMap::MANY_TO_ONE, array('profileid' => 'profileid', ), null, null);
        $this->addRelation('Role', 'PoGo\\Role', RelationMap::MANY_TO_ONE, array('roleid' => 'roleid', ), null, null);
    } // buildRelations()

} // ProfileRoleTableMap
