<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project' table.
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
class ProjectTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.ProjectTableMap';

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
        $this->setName('project');
        $this->setPhpName('Project');
        $this->setClassname('PoGo\\Project');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('projectid', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('projectcode', 'Code', 'VARCHAR', true, 14, null);
        $this->addColumn('projectname', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('projectdescription', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('projectstartdate', 'StartDate', 'DATE', true, null, null);
        $this->addColumn('projectduedate', 'DueDate', 'DATE', false, null, null);
        $this->addColumn('projectenddate', 'EndDate', 'DATE', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProjectActor', 'PoGo\\ProjectActor', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'ProjectActors');
        $this->addRelation('File', 'PoGo\\File', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Files');
        $this->addRelation('Milestone', 'PoGo\\Milestone', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Milestones');
        $this->addRelation('Task', 'PoGo\\Task', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Tasks');
        $this->addRelation('Note', 'PoGo\\Note', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Notes');
    } // buildRelations()

} // ProjectTableMap
