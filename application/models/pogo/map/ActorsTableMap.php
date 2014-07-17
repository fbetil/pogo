<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'actors' table.
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
class ActorsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.ActorsTableMap';

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
        $this->setName('actors');
        $this->setPhpName('Actors');
        $this->setClassname('PoGo\\Actors');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('actorid', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('actorfirstname', 'FirstName', 'VARCHAR', true, 50, null);
        $this->addColumn('actorname', 'Name', 'VARCHAR', true, 50, null);
        $this->addColumn('actorentity', 'Entity', 'VARCHAR', true, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProjectActor', 'PoGo\\ProjectActor', RelationMap::ONE_TO_MANY, array('actorid' => 'actorid', ), null, null, 'ProjectActors');
        $this->addRelation('Files', 'PoGo\\Files', RelationMap::ONE_TO_MANY, array('actorid' => 'actorid', ), null, null, 'Filess');
        $this->addRelation('TaskActor', 'PoGo\\TaskActor', RelationMap::ONE_TO_MANY, array('actorid' => 'actorid', ), null, null, 'TaskActors');
        $this->addRelation('Notes', 'PoGo\\Notes', RelationMap::ONE_TO_MANY, array('actorid' => 'actorid', ), null, null, 'Notess');
        $this->addRelation('Users', 'PoGo\\Users', RelationMap::ONE_TO_MANY, array('actorid' => 'actorid', ), null, null, 'Userss');
    } // buildRelations()

} // ActorsTableMap
