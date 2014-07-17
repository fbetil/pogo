<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project_actor' table.
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
class ProjectActorTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.ProjectActorTableMap';

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
        $this->setName('project_actor');
        $this->setPhpName('ProjectActor');
        $this->setClassname('PoGo\\ProjectActor');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('projectactorid', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('projectid', 'ProjectId', 'INTEGER', 'project', 'projectid', true, null, null);
        $this->addForeignKey('actorid', 'ActorId', 'INTEGER', 'actor', 'actorid', true, null, null);
        $this->addColumn('projectactorrole', 'Role', 'VARCHAR', true, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Project', 'PoGo\\Project', RelationMap::MANY_TO_ONE, array('projectid' => 'projectid', ), null, null);
        $this->addRelation('Actor', 'PoGo\\Actor', RelationMap::MANY_TO_ONE, array('actorid' => 'actorid', ), null, null);
    } // buildRelations()

} // ProjectActorTableMap
