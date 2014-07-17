<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project_note' table.
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
class ProjectNoteTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.ProjectNoteTableMap';

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
        $this->setName('project_note');
        $this->setPhpName('ProjectNote');
        $this->setClassname('PoGo\\ProjectNote');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('projectnoteid', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('projectid', 'ProjectId', 'INTEGER', 'projects', 'projectid', true, null, null);
        $this->addForeignKey('noteid', 'NoteId', 'INTEGER', 'notes', 'noteid', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Project', 'PoGo\\Projects', RelationMap::MANY_TO_ONE, array('projectid' => 'projectid', ), null, null);
        $this->addRelation('Note', 'PoGo\\Notes', RelationMap::MANY_TO_ONE, array('noteid' => 'noteid', ), null, null);
    } // buildRelations()

} // ProjectNoteTableMap
