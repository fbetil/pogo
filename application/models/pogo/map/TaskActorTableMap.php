<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'task_actor' table.
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
class TaskActorTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.TaskActorTableMap';

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
        $this->setName('task_actor');
        $this->setPhpName('TaskActor');
        $this->setClassname('PoGo\\TaskActor');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('taskactorid', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('taskid', 'TaskId', 'INTEGER', 'task', 'taskid', true, null, null);
        $this->addForeignKey('actorid', 'ActorId', 'INTEGER', 'actor', 'actorid', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Task', 'PoGo\\Task', RelationMap::MANY_TO_ONE, array('taskid' => 'taskid', ), null, null);
        $this->addRelation('Actor', 'PoGo\\Actor', RelationMap::MANY_TO_ONE, array('actorid' => 'actorid', ), null, null);
    } // buildRelations()

} // TaskActorTableMap
