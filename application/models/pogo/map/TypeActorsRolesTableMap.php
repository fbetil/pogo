<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'typeactorsroles' table.
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
class TypeActorsRolesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.TypeActorsRolesTableMap';

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
        $this->setName('typeactorsroles');
        $this->setPhpName('TypeActorsRoles');
        $this->setClassname('PoGo\\TypeActorsRoles');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('typeactorroleid', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('typeactorrolecode', 'Code', 'VARCHAR', true, 5, null);
        $this->addColumn('typeactorrolelabel', 'Label', 'VARCHAR', true, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProjectActor', 'PoGo\\ProjectActor', RelationMap::ONE_TO_MANY, array('typeactorroleid' => 'typeactorroleid', ), null, null, 'ProjectActors');
    } // buildRelations()

} // TypeActorsRolesTableMap
