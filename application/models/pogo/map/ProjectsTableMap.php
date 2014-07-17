<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'projects' table.
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
class ProjectsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.ProjectsTableMap';

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
        $this->setName('projects');
        $this->setPhpName('Projects');
        $this->setClassname('PoGo\\Projects');
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
        $this->addRelation('Files', 'PoGo\\Files', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Filess');
        $this->addRelation('Milestones', 'PoGo\\Milestones', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Milestoness');
        $this->addRelation('Tasks', 'PoGo\\Tasks', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Taskss');
        $this->addRelation('Notes', 'PoGo\\Notes', RelationMap::ONE_TO_MANY, array('projectid' => 'projectid', ), null, null, 'Notess');
    } // buildRelations()

} // ProjectsTableMap
