<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'note' table.
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
class NoteTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.NoteTableMap';

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
        $this->setName('note');
        $this->setPhpName('Note');
        $this->setClassname('PoGo\\Note');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('noteid', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('notename', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addColumn('notecontent', 'Content', 'LONGVARCHAR', true, null, null);
        $this->addForeignKey('actorid', 'ActorId', 'INTEGER', 'actor', 'actorid', true, null, null);
        $this->addColumn('notepublishedat', 'PublishedAt', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('projectid', 'ProjectId', 'INTEGER', 'project', 'projectid', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Actor', 'PoGo\\Actor', RelationMap::MANY_TO_ONE, array('actorid' => 'actorid', ), null, null);
        $this->addRelation('Project', 'PoGo\\Project', RelationMap::MANY_TO_ONE, array('projectid' => 'projectid', ), null, null);
    } // buildRelations()

} // NoteTableMap
