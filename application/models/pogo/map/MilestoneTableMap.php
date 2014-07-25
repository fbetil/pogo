<?php

namespace PoGo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'milestone' table.
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
class MilestoneTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pogo.map.MilestoneTableMap';

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
        $this->setName('milestone');
        $this->setPhpName('Milestone');
        $this->setClassname('PoGo\\Milestone');
        $this->setPackage('pogo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('milestoneid', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('milestonename', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('milestonedescription', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('milestoneduedate', 'DueDate', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('projectid', 'ProjectId', 'INTEGER', 'project', 'projectid', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Project', 'PoGo\\Project', RelationMap::MANY_TO_ONE, array('projectid' => 'projectid', ), null, null);
    } // buildRelations()

} // MilestoneTableMap
