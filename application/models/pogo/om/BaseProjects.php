<?php

namespace PoGo\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use PoGo\Files;
use PoGo\FilesQuery;
use PoGo\Milestones;
use PoGo\MilestonesQuery;
use PoGo\Notes;
use PoGo\NotesQuery;
use PoGo\ProjectActor;
use PoGo\ProjectActorQuery;
use PoGo\Projects;
use PoGo\ProjectsPeer;
use PoGo\ProjectsQuery;
use PoGo\Tasks;
use PoGo\TasksQuery;

/**
 * Base class that represents a row from the 'projects' table.
 *
 *
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseProjects extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'PoGo\\ProjectsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProjectsPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the projectid field.
     * @var        int
     */
    protected $projectid;

    /**
     * The value for the projectcode field.
     * @var        string
     */
    protected $projectcode;

    /**
     * The value for the projectname field.
     * @var        string
     */
    protected $projectname;

    /**
     * The value for the projectdescription field.
     * @var        string
     */
    protected $projectdescription;

    /**
     * The value for the projectstartdate field.
     * @var        string
     */
    protected $projectstartdate;

    /**
     * The value for the projectduedate field.
     * @var        string
     */
    protected $projectduedate;

    /**
     * The value for the projectenddate field.
     * @var        string
     */
    protected $projectenddate;

    /**
     * @var        PropelObjectCollection|ProjectActor[] Collection to store aggregation of ProjectActor objects.
     */
    protected $collProjectActors;
    protected $collProjectActorsPartial;

    /**
     * @var        PropelObjectCollection|Files[] Collection to store aggregation of Files objects.
     */
    protected $collFiless;
    protected $collFilessPartial;

    /**
     * @var        PropelObjectCollection|Milestones[] Collection to store aggregation of Milestones objects.
     */
    protected $collMilestoness;
    protected $collMilestonessPartial;

    /**
     * @var        PropelObjectCollection|Tasks[] Collection to store aggregation of Tasks objects.
     */
    protected $collTaskss;
    protected $collTaskssPartial;

    /**
     * @var        PropelObjectCollection|Notes[] Collection to store aggregation of Notes objects.
     */
    protected $collNotess;
    protected $collNotessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectActorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $filessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $milestonessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $taskssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $notessScheduledForDeletion = null;

    /**
     * Get the [projectid] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->projectid;
    }

    /**
     * Get the [projectcode] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->projectcode;
    }

    /**
     * Get the [projectname] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->projectname;
    }

    /**
     * Get the [projectdescription] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->projectdescription;
    }

    /**
     * Get the [optionally formatted] temporal [projectstartdate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = '%x')
    {
        if ($this->projectstartdate === null) {
            return null;
        }

        if ($this->projectstartdate === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->projectstartdate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->projectstartdate, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [projectduedate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDueDate($format = '%x')
    {
        if ($this->projectduedate === null) {
            return null;
        }

        if ($this->projectduedate === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->projectduedate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->projectduedate, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [projectenddate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndDate($format = '%x')
    {
        if ($this->projectenddate === null) {
            return null;
        }

        if ($this->projectenddate === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->projectenddate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->projectenddate, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [projectid] column.
     *
     * @param int $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->projectid !== $v) {
            $this->projectid = $v;
            $this->modifiedColumns[] = ProjectsPeer::PROJECTID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [projectcode] column.
     *
     * @param string $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->projectcode !== $v) {
            $this->projectcode = $v;
            $this->modifiedColumns[] = ProjectsPeer::PROJECTCODE;
        }


        return $this;
    } // setCode()

    /**
     * Set the value of [projectname] column.
     *
     * @param string $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->projectname !== $v) {
            $this->projectname = $v;
            $this->modifiedColumns[] = ProjectsPeer::PROJECTNAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [projectdescription] column.
     *
     * @param string $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->projectdescription !== $v) {
            $this->projectdescription = $v;
            $this->modifiedColumns[] = ProjectsPeer::PROJECTDESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Sets the value of [projectstartdate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Projects The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->projectstartdate !== null || $dt !== null) {
            $currentDateAsString = ($this->projectstartdate !== null && $tmpDt = new DateTime($this->projectstartdate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->projectstartdate = $newDateAsString;
                $this->modifiedColumns[] = ProjectsPeer::PROJECTSTARTDATE;
            }
        } // if either are not null


        return $this;
    } // setStartDate()

    /**
     * Sets the value of [projectduedate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Projects The current object (for fluent API support)
     */
    public function setDueDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->projectduedate !== null || $dt !== null) {
            $currentDateAsString = ($this->projectduedate !== null && $tmpDt = new DateTime($this->projectduedate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->projectduedate = $newDateAsString;
                $this->modifiedColumns[] = ProjectsPeer::PROJECTDUEDATE;
            }
        } // if either are not null


        return $this;
    } // setDueDate()

    /**
     * Sets the value of [projectenddate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Projects The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->projectenddate !== null || $dt !== null) {
            $currentDateAsString = ($this->projectenddate !== null && $tmpDt = new DateTime($this->projectenddate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->projectenddate = $newDateAsString;
                $this->modifiedColumns[] = ProjectsPeer::PROJECTENDDATE;
            }
        } // if either are not null


        return $this;
    } // setEndDate()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->projectid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->projectcode = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->projectname = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->projectdescription = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->projectstartdate = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->projectduedate = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->projectenddate = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = ProjectsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Projects object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProjectsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collProjectActors = null;

            $this->collFiless = null;

            $this->collMilestoness = null;

            $this->collTaskss = null;

            $this->collNotess = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProjectsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ProjectsPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->projectActorsScheduledForDeletion !== null) {
                if (!$this->projectActorsScheduledForDeletion->isEmpty()) {
                    ProjectActorQuery::create()
                        ->filterByPrimaryKeys($this->projectActorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectActorsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectActors !== null) {
                foreach ($this->collProjectActors as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->filessScheduledForDeletion !== null) {
                if (!$this->filessScheduledForDeletion->isEmpty()) {
                    FilesQuery::create()
                        ->filterByPrimaryKeys($this->filessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->filessScheduledForDeletion = null;
                }
            }

            if ($this->collFiless !== null) {
                foreach ($this->collFiless as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->milestonessScheduledForDeletion !== null) {
                if (!$this->milestonessScheduledForDeletion->isEmpty()) {
                    MilestonesQuery::create()
                        ->filterByPrimaryKeys($this->milestonessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->milestonessScheduledForDeletion = null;
                }
            }

            if ($this->collMilestoness !== null) {
                foreach ($this->collMilestoness as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->taskssScheduledForDeletion !== null) {
                if (!$this->taskssScheduledForDeletion->isEmpty()) {
                    TasksQuery::create()
                        ->filterByPrimaryKeys($this->taskssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->taskssScheduledForDeletion = null;
                }
            }

            if ($this->collTaskss !== null) {
                foreach ($this->collTaskss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->notessScheduledForDeletion !== null) {
                if (!$this->notessScheduledForDeletion->isEmpty()) {
                    NotesQuery::create()
                        ->filterByPrimaryKeys($this->notessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->notessScheduledForDeletion = null;
                }
            }

            if ($this->collNotess !== null) {
                foreach ($this->collNotess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = ProjectsPeer::PROJECTID;
        if (null !== $this->projectid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProjectsPeer::PROJECTID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProjectsPeer::PROJECTID)) {
            $modifiedColumns[':p' . $index++]  = '`projectid`';
        }
        if ($this->isColumnModified(ProjectsPeer::PROJECTCODE)) {
            $modifiedColumns[':p' . $index++]  = '`projectcode`';
        }
        if ($this->isColumnModified(ProjectsPeer::PROJECTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`projectname`';
        }
        if ($this->isColumnModified(ProjectsPeer::PROJECTDESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`projectdescription`';
        }
        if ($this->isColumnModified(ProjectsPeer::PROJECTSTARTDATE)) {
            $modifiedColumns[':p' . $index++]  = '`projectstartdate`';
        }
        if ($this->isColumnModified(ProjectsPeer::PROJECTDUEDATE)) {
            $modifiedColumns[':p' . $index++]  = '`projectduedate`';
        }
        if ($this->isColumnModified(ProjectsPeer::PROJECTENDDATE)) {
            $modifiedColumns[':p' . $index++]  = '`projectenddate`';
        }

        $sql = sprintf(
            'INSERT INTO `projects` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`projectid`':
                        $stmt->bindValue($identifier, $this->projectid, PDO::PARAM_INT);
                        break;
                    case '`projectcode`':
                        $stmt->bindValue($identifier, $this->projectcode, PDO::PARAM_STR);
                        break;
                    case '`projectname`':
                        $stmt->bindValue($identifier, $this->projectname, PDO::PARAM_STR);
                        break;
                    case '`projectdescription`':
                        $stmt->bindValue($identifier, $this->projectdescription, PDO::PARAM_STR);
                        break;
                    case '`projectstartdate`':
                        $stmt->bindValue($identifier, $this->projectstartdate, PDO::PARAM_STR);
                        break;
                    case '`projectduedate`':
                        $stmt->bindValue($identifier, $this->projectduedate, PDO::PARAM_STR);
                        break;
                    case '`projectenddate`':
                        $stmt->bindValue($identifier, $this->projectenddate, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = ProjectsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collProjectActors !== null) {
                    foreach ($this->collProjectActors as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFiless !== null) {
                    foreach ($this->collFiless as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMilestoness !== null) {
                    foreach ($this->collMilestoness as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTaskss !== null) {
                    foreach ($this->collTaskss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collNotess !== null) {
                    foreach ($this->collNotess as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ProjectsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getCode();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getDescription();
                break;
            case 4:
                return $this->getStartDate();
                break;
            case 5:
                return $this->getDueDate();
                break;
            case 6:
                return $this->getEndDate();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Projects'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Projects'][$this->getPrimaryKey()] = true;
        $keys = ProjectsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCode(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getDescription(),
            $keys[4] => $this->getStartDate(),
            $keys[5] => $this->getDueDate(),
            $keys[6] => $this->getEndDate(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collProjectActors) {
                $result['ProjectActors'] = $this->collProjectActors->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFiless) {
                $result['Filess'] = $this->collFiless->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMilestoness) {
                $result['Milestoness'] = $this->collMilestoness->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTaskss) {
                $result['Taskss'] = $this->collTaskss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collNotess) {
                $result['Notess'] = $this->collNotess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ProjectsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCode($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setDescription($value);
                break;
            case 4:
                $this->setStartDate($value);
                break;
            case 5:
                $this->setDueDate($value);
                break;
            case 6:
                $this->setEndDate($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ProjectsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCode($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setStartDate($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDueDate($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setEndDate($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProjectsPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProjectsPeer::PROJECTID)) $criteria->add(ProjectsPeer::PROJECTID, $this->projectid);
        if ($this->isColumnModified(ProjectsPeer::PROJECTCODE)) $criteria->add(ProjectsPeer::PROJECTCODE, $this->projectcode);
        if ($this->isColumnModified(ProjectsPeer::PROJECTNAME)) $criteria->add(ProjectsPeer::PROJECTNAME, $this->projectname);
        if ($this->isColumnModified(ProjectsPeer::PROJECTDESCRIPTION)) $criteria->add(ProjectsPeer::PROJECTDESCRIPTION, $this->projectdescription);
        if ($this->isColumnModified(ProjectsPeer::PROJECTSTARTDATE)) $criteria->add(ProjectsPeer::PROJECTSTARTDATE, $this->projectstartdate);
        if ($this->isColumnModified(ProjectsPeer::PROJECTDUEDATE)) $criteria->add(ProjectsPeer::PROJECTDUEDATE, $this->projectduedate);
        if ($this->isColumnModified(ProjectsPeer::PROJECTENDDATE)) $criteria->add(ProjectsPeer::PROJECTENDDATE, $this->projectenddate);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ProjectsPeer::DATABASE_NAME);
        $criteria->add(ProjectsPeer::PROJECTID, $this->projectid);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (projectid column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Projects (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCode($this->getCode());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setDueDate($this->getDueDate());
        $copyObj->setEndDate($this->getEndDate());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getProjectActors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectActor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFiless() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFiles($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMilestoness() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMilestones($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTaskss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTasks($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getNotess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNotes($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Projects Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return ProjectsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProjectsPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ProjectActor' == $relationName) {
            $this->initProjectActors();
        }
        if ('Files' == $relationName) {
            $this->initFiless();
        }
        if ('Milestones' == $relationName) {
            $this->initMilestoness();
        }
        if ('Tasks' == $relationName) {
            $this->initTaskss();
        }
        if ('Notes' == $relationName) {
            $this->initNotess();
        }
    }

    /**
     * Clears out the collProjectActors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Projects The current object (for fluent API support)
     * @see        addProjectActors()
     */
    public function clearProjectActors()
    {
        $this->collProjectActors = null; // important to set this to null since that means it is uninitialized
        $this->collProjectActorsPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectActors collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectActors($v = true)
    {
        $this->collProjectActorsPartial = $v;
    }

    /**
     * Initializes the collProjectActors collection.
     *
     * By default this just sets the collProjectActors collection to an empty array (like clearcollProjectActors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectActors($overrideExisting = true)
    {
        if (null !== $this->collProjectActors && !$overrideExisting) {
            return;
        }
        $this->collProjectActors = new PropelObjectCollection();
        $this->collProjectActors->setModel('ProjectActor');
    }

    /**
     * Gets an array of ProjectActor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Projects is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ProjectActor[] List of ProjectActor objects
     * @throws PropelException
     */
    public function getProjectActors($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectActorsPartial && !$this->isNew();
        if (null === $this->collProjectActors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectActors) {
                // return empty collection
                $this->initProjectActors();
            } else {
                $collProjectActors = ProjectActorQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectActorsPartial && count($collProjectActors)) {
                      $this->initProjectActors(false);

                      foreach($collProjectActors as $obj) {
                        if (false == $this->collProjectActors->contains($obj)) {
                          $this->collProjectActors->append($obj);
                        }
                      }

                      $this->collProjectActorsPartial = true;
                    }

                    $collProjectActors->getInternalIterator()->rewind();
                    return $collProjectActors;
                }

                if($partial && $this->collProjectActors) {
                    foreach($this->collProjectActors as $obj) {
                        if($obj->isNew()) {
                            $collProjectActors[] = $obj;
                        }
                    }
                }

                $this->collProjectActors = $collProjectActors;
                $this->collProjectActorsPartial = false;
            }
        }

        return $this->collProjectActors;
    }

    /**
     * Sets a collection of ProjectActor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectActors A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Projects The current object (for fluent API support)
     */
    public function setProjectActors(PropelCollection $projectActors, PropelPDO $con = null)
    {
        $projectActorsToDelete = $this->getProjectActors(new Criteria(), $con)->diff($projectActors);

        $this->projectActorsScheduledForDeletion = unserialize(serialize($projectActorsToDelete));

        foreach ($projectActorsToDelete as $projectActorRemoved) {
            $projectActorRemoved->setProject(null);
        }

        $this->collProjectActors = null;
        foreach ($projectActors as $projectActor) {
            $this->addProjectActor($projectActor);
        }

        $this->collProjectActors = $projectActors;
        $this->collProjectActorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProjectActor objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ProjectActor objects.
     * @throws PropelException
     */
    public function countProjectActors(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectActorsPartial && !$this->isNew();
        if (null === $this->collProjectActors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectActors) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectActors());
            }
            $query = ProjectActorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collProjectActors);
    }

    /**
     * Method called to associate a ProjectActor object to this object
     * through the ProjectActor foreign key attribute.
     *
     * @param    ProjectActor $l ProjectActor
     * @return Projects The current object (for fluent API support)
     */
    public function addProjectActor(ProjectActor $l)
    {
        if ($this->collProjectActors === null) {
            $this->initProjectActors();
            $this->collProjectActorsPartial = true;
        }
        if (!in_array($l, $this->collProjectActors->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectActor($l);
        }

        return $this;
    }

    /**
     * @param	ProjectActor $projectActor The projectActor object to add.
     */
    protected function doAddProjectActor($projectActor)
    {
        $this->collProjectActors[]= $projectActor;
        $projectActor->setProject($this);
    }

    /**
     * @param	ProjectActor $projectActor The projectActor object to remove.
     * @return Projects The current object (for fluent API support)
     */
    public function removeProjectActor($projectActor)
    {
        if ($this->getProjectActors()->contains($projectActor)) {
            $this->collProjectActors->remove($this->collProjectActors->search($projectActor));
            if (null === $this->projectActorsScheduledForDeletion) {
                $this->projectActorsScheduledForDeletion = clone $this->collProjectActors;
                $this->projectActorsScheduledForDeletion->clear();
            }
            $this->projectActorsScheduledForDeletion[]= clone $projectActor;
            $projectActor->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Projects is new, it will return
     * an empty collection; or if this Projects has previously
     * been saved, it will retrieve related ProjectActors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Projects.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectActor[] List of ProjectActor objects
     */
    public function getProjectActorsJoinActor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectActorQuery::create(null, $criteria);
        $query->joinWith('Actor', $join_behavior);

        return $this->getProjectActors($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Projects is new, it will return
     * an empty collection; or if this Projects has previously
     * been saved, it will retrieve related ProjectActors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Projects.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectActor[] List of ProjectActor objects
     */
    public function getProjectActorsJoinTypeActorRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectActorQuery::create(null, $criteria);
        $query->joinWith('TypeActorRole', $join_behavior);

        return $this->getProjectActors($query, $con);
    }

    /**
     * Clears out the collFiless collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Projects The current object (for fluent API support)
     * @see        addFiless()
     */
    public function clearFiless()
    {
        $this->collFiless = null; // important to set this to null since that means it is uninitialized
        $this->collFilessPartial = null;

        return $this;
    }

    /**
     * reset is the collFiless collection loaded partially
     *
     * @return void
     */
    public function resetPartialFiless($v = true)
    {
        $this->collFilessPartial = $v;
    }

    /**
     * Initializes the collFiless collection.
     *
     * By default this just sets the collFiless collection to an empty array (like clearcollFiless());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFiless($overrideExisting = true)
    {
        if (null !== $this->collFiless && !$overrideExisting) {
            return;
        }
        $this->collFiless = new PropelObjectCollection();
        $this->collFiless->setModel('Files');
    }

    /**
     * Gets an array of Files objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Projects is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Files[] List of Files objects
     * @throws PropelException
     */
    public function getFiless($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFilessPartial && !$this->isNew();
        if (null === $this->collFiless || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFiless) {
                // return empty collection
                $this->initFiless();
            } else {
                $collFiless = FilesQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFilessPartial && count($collFiless)) {
                      $this->initFiless(false);

                      foreach($collFiless as $obj) {
                        if (false == $this->collFiless->contains($obj)) {
                          $this->collFiless->append($obj);
                        }
                      }

                      $this->collFilessPartial = true;
                    }

                    $collFiless->getInternalIterator()->rewind();
                    return $collFiless;
                }

                if($partial && $this->collFiless) {
                    foreach($this->collFiless as $obj) {
                        if($obj->isNew()) {
                            $collFiless[] = $obj;
                        }
                    }
                }

                $this->collFiless = $collFiless;
                $this->collFilessPartial = false;
            }
        }

        return $this->collFiless;
    }

    /**
     * Sets a collection of Files objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $filess A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Projects The current object (for fluent API support)
     */
    public function setFiless(PropelCollection $filess, PropelPDO $con = null)
    {
        $filessToDelete = $this->getFiless(new Criteria(), $con)->diff($filess);

        $this->filessScheduledForDeletion = unserialize(serialize($filessToDelete));

        foreach ($filessToDelete as $filesRemoved) {
            $filesRemoved->setProject(null);
        }

        $this->collFiless = null;
        foreach ($filess as $files) {
            $this->addFiles($files);
        }

        $this->collFiless = $filess;
        $this->collFilessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Files objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Files objects.
     * @throws PropelException
     */
    public function countFiless(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFilessPartial && !$this->isNew();
        if (null === $this->collFiless || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFiless) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFiless());
            }
            $query = FilesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collFiless);
    }

    /**
     * Method called to associate a Files object to this object
     * through the Files foreign key attribute.
     *
     * @param    Files $l Files
     * @return Projects The current object (for fluent API support)
     */
    public function addFiles(Files $l)
    {
        if ($this->collFiless === null) {
            $this->initFiless();
            $this->collFilessPartial = true;
        }
        if (!in_array($l, $this->collFiless->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFiles($l);
        }

        return $this;
    }

    /**
     * @param	Files $files The files object to add.
     */
    protected function doAddFiles($files)
    {
        $this->collFiless[]= $files;
        $files->setProject($this);
    }

    /**
     * @param	Files $files The files object to remove.
     * @return Projects The current object (for fluent API support)
     */
    public function removeFiles($files)
    {
        if ($this->getFiless()->contains($files)) {
            $this->collFiless->remove($this->collFiless->search($files));
            if (null === $this->filessScheduledForDeletion) {
                $this->filessScheduledForDeletion = clone $this->collFiless;
                $this->filessScheduledForDeletion->clear();
            }
            $this->filessScheduledForDeletion[]= clone $files;
            $files->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Projects is new, it will return
     * an empty collection; or if this Projects has previously
     * been saved, it will retrieve related Filess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Projects.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Files[] List of Files objects
     */
    public function getFilessJoinActor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FilesQuery::create(null, $criteria);
        $query->joinWith('Actor', $join_behavior);

        return $this->getFiless($query, $con);
    }

    /**
     * Clears out the collMilestoness collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Projects The current object (for fluent API support)
     * @see        addMilestoness()
     */
    public function clearMilestoness()
    {
        $this->collMilestoness = null; // important to set this to null since that means it is uninitialized
        $this->collMilestonessPartial = null;

        return $this;
    }

    /**
     * reset is the collMilestoness collection loaded partially
     *
     * @return void
     */
    public function resetPartialMilestoness($v = true)
    {
        $this->collMilestonessPartial = $v;
    }

    /**
     * Initializes the collMilestoness collection.
     *
     * By default this just sets the collMilestoness collection to an empty array (like clearcollMilestoness());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMilestoness($overrideExisting = true)
    {
        if (null !== $this->collMilestoness && !$overrideExisting) {
            return;
        }
        $this->collMilestoness = new PropelObjectCollection();
        $this->collMilestoness->setModel('Milestones');
    }

    /**
     * Gets an array of Milestones objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Projects is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Milestones[] List of Milestones objects
     * @throws PropelException
     */
    public function getMilestoness($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMilestonessPartial && !$this->isNew();
        if (null === $this->collMilestoness || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMilestoness) {
                // return empty collection
                $this->initMilestoness();
            } else {
                $collMilestoness = MilestonesQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMilestonessPartial && count($collMilestoness)) {
                      $this->initMilestoness(false);

                      foreach($collMilestoness as $obj) {
                        if (false == $this->collMilestoness->contains($obj)) {
                          $this->collMilestoness->append($obj);
                        }
                      }

                      $this->collMilestonessPartial = true;
                    }

                    $collMilestoness->getInternalIterator()->rewind();
                    return $collMilestoness;
                }

                if($partial && $this->collMilestoness) {
                    foreach($this->collMilestoness as $obj) {
                        if($obj->isNew()) {
                            $collMilestoness[] = $obj;
                        }
                    }
                }

                $this->collMilestoness = $collMilestoness;
                $this->collMilestonessPartial = false;
            }
        }

        return $this->collMilestoness;
    }

    /**
     * Sets a collection of Milestones objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $milestoness A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Projects The current object (for fluent API support)
     */
    public function setMilestoness(PropelCollection $milestoness, PropelPDO $con = null)
    {
        $milestonessToDelete = $this->getMilestoness(new Criteria(), $con)->diff($milestoness);

        $this->milestonessScheduledForDeletion = unserialize(serialize($milestonessToDelete));

        foreach ($milestonessToDelete as $milestonesRemoved) {
            $milestonesRemoved->setProject(null);
        }

        $this->collMilestoness = null;
        foreach ($milestoness as $milestones) {
            $this->addMilestones($milestones);
        }

        $this->collMilestoness = $milestoness;
        $this->collMilestonessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Milestones objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Milestones objects.
     * @throws PropelException
     */
    public function countMilestoness(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMilestonessPartial && !$this->isNew();
        if (null === $this->collMilestoness || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMilestoness) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getMilestoness());
            }
            $query = MilestonesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collMilestoness);
    }

    /**
     * Method called to associate a Milestones object to this object
     * through the Milestones foreign key attribute.
     *
     * @param    Milestones $l Milestones
     * @return Projects The current object (for fluent API support)
     */
    public function addMilestones(Milestones $l)
    {
        if ($this->collMilestoness === null) {
            $this->initMilestoness();
            $this->collMilestonessPartial = true;
        }
        if (!in_array($l, $this->collMilestoness->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMilestones($l);
        }

        return $this;
    }

    /**
     * @param	Milestones $milestones The milestones object to add.
     */
    protected function doAddMilestones($milestones)
    {
        $this->collMilestoness[]= $milestones;
        $milestones->setProject($this);
    }

    /**
     * @param	Milestones $milestones The milestones object to remove.
     * @return Projects The current object (for fluent API support)
     */
    public function removeMilestones($milestones)
    {
        if ($this->getMilestoness()->contains($milestones)) {
            $this->collMilestoness->remove($this->collMilestoness->search($milestones));
            if (null === $this->milestonessScheduledForDeletion) {
                $this->milestonessScheduledForDeletion = clone $this->collMilestoness;
                $this->milestonessScheduledForDeletion->clear();
            }
            $this->milestonessScheduledForDeletion[]= clone $milestones;
            $milestones->setProject(null);
        }

        return $this;
    }

    /**
     * Clears out the collTaskss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Projects The current object (for fluent API support)
     * @see        addTaskss()
     */
    public function clearTaskss()
    {
        $this->collTaskss = null; // important to set this to null since that means it is uninitialized
        $this->collTaskssPartial = null;

        return $this;
    }

    /**
     * reset is the collTaskss collection loaded partially
     *
     * @return void
     */
    public function resetPartialTaskss($v = true)
    {
        $this->collTaskssPartial = $v;
    }

    /**
     * Initializes the collTaskss collection.
     *
     * By default this just sets the collTaskss collection to an empty array (like clearcollTaskss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTaskss($overrideExisting = true)
    {
        if (null !== $this->collTaskss && !$overrideExisting) {
            return;
        }
        $this->collTaskss = new PropelObjectCollection();
        $this->collTaskss->setModel('Tasks');
    }

    /**
     * Gets an array of Tasks objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Projects is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Tasks[] List of Tasks objects
     * @throws PropelException
     */
    public function getTaskss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTaskssPartial && !$this->isNew();
        if (null === $this->collTaskss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTaskss) {
                // return empty collection
                $this->initTaskss();
            } else {
                $collTaskss = TasksQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTaskssPartial && count($collTaskss)) {
                      $this->initTaskss(false);

                      foreach($collTaskss as $obj) {
                        if (false == $this->collTaskss->contains($obj)) {
                          $this->collTaskss->append($obj);
                        }
                      }

                      $this->collTaskssPartial = true;
                    }

                    $collTaskss->getInternalIterator()->rewind();
                    return $collTaskss;
                }

                if($partial && $this->collTaskss) {
                    foreach($this->collTaskss as $obj) {
                        if($obj->isNew()) {
                            $collTaskss[] = $obj;
                        }
                    }
                }

                $this->collTaskss = $collTaskss;
                $this->collTaskssPartial = false;
            }
        }

        return $this->collTaskss;
    }

    /**
     * Sets a collection of Tasks objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $taskss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Projects The current object (for fluent API support)
     */
    public function setTaskss(PropelCollection $taskss, PropelPDO $con = null)
    {
        $taskssToDelete = $this->getTaskss(new Criteria(), $con)->diff($taskss);

        $this->taskssScheduledForDeletion = unserialize(serialize($taskssToDelete));

        foreach ($taskssToDelete as $tasksRemoved) {
            $tasksRemoved->setProject(null);
        }

        $this->collTaskss = null;
        foreach ($taskss as $tasks) {
            $this->addTasks($tasks);
        }

        $this->collTaskss = $taskss;
        $this->collTaskssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Tasks objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Tasks objects.
     * @throws PropelException
     */
    public function countTaskss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTaskssPartial && !$this->isNew();
        if (null === $this->collTaskss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTaskss) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getTaskss());
            }
            $query = TasksQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collTaskss);
    }

    /**
     * Method called to associate a Tasks object to this object
     * through the Tasks foreign key attribute.
     *
     * @param    Tasks $l Tasks
     * @return Projects The current object (for fluent API support)
     */
    public function addTasks(Tasks $l)
    {
        if ($this->collTaskss === null) {
            $this->initTaskss();
            $this->collTaskssPartial = true;
        }
        if (!in_array($l, $this->collTaskss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTasks($l);
        }

        return $this;
    }

    /**
     * @param	Tasks $tasks The tasks object to add.
     */
    protected function doAddTasks($tasks)
    {
        $this->collTaskss[]= $tasks;
        $tasks->setProject($this);
    }

    /**
     * @param	Tasks $tasks The tasks object to remove.
     * @return Projects The current object (for fluent API support)
     */
    public function removeTasks($tasks)
    {
        if ($this->getTaskss()->contains($tasks)) {
            $this->collTaskss->remove($this->collTaskss->search($tasks));
            if (null === $this->taskssScheduledForDeletion) {
                $this->taskssScheduledForDeletion = clone $this->collTaskss;
                $this->taskssScheduledForDeletion->clear();
            }
            $this->taskssScheduledForDeletion[]= clone $tasks;
            $tasks->setProject(null);
        }

        return $this;
    }

    /**
     * Clears out the collNotess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Projects The current object (for fluent API support)
     * @see        addNotess()
     */
    public function clearNotess()
    {
        $this->collNotess = null; // important to set this to null since that means it is uninitialized
        $this->collNotessPartial = null;

        return $this;
    }

    /**
     * reset is the collNotess collection loaded partially
     *
     * @return void
     */
    public function resetPartialNotess($v = true)
    {
        $this->collNotessPartial = $v;
    }

    /**
     * Initializes the collNotess collection.
     *
     * By default this just sets the collNotess collection to an empty array (like clearcollNotess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNotess($overrideExisting = true)
    {
        if (null !== $this->collNotess && !$overrideExisting) {
            return;
        }
        $this->collNotess = new PropelObjectCollection();
        $this->collNotess->setModel('Notes');
    }

    /**
     * Gets an array of Notes objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Projects is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Notes[] List of Notes objects
     * @throws PropelException
     */
    public function getNotess($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collNotessPartial && !$this->isNew();
        if (null === $this->collNotess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collNotess) {
                // return empty collection
                $this->initNotess();
            } else {
                $collNotess = NotesQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collNotessPartial && count($collNotess)) {
                      $this->initNotess(false);

                      foreach($collNotess as $obj) {
                        if (false == $this->collNotess->contains($obj)) {
                          $this->collNotess->append($obj);
                        }
                      }

                      $this->collNotessPartial = true;
                    }

                    $collNotess->getInternalIterator()->rewind();
                    return $collNotess;
                }

                if($partial && $this->collNotess) {
                    foreach($this->collNotess as $obj) {
                        if($obj->isNew()) {
                            $collNotess[] = $obj;
                        }
                    }
                }

                $this->collNotess = $collNotess;
                $this->collNotessPartial = false;
            }
        }

        return $this->collNotess;
    }

    /**
     * Sets a collection of Notes objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $notess A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Projects The current object (for fluent API support)
     */
    public function setNotess(PropelCollection $notess, PropelPDO $con = null)
    {
        $notessToDelete = $this->getNotess(new Criteria(), $con)->diff($notess);

        $this->notessScheduledForDeletion = unserialize(serialize($notessToDelete));

        foreach ($notessToDelete as $notesRemoved) {
            $notesRemoved->setProject(null);
        }

        $this->collNotess = null;
        foreach ($notess as $notes) {
            $this->addNotes($notes);
        }

        $this->collNotess = $notess;
        $this->collNotessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Notes objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Notes objects.
     * @throws PropelException
     */
    public function countNotess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collNotessPartial && !$this->isNew();
        if (null === $this->collNotess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collNotess) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getNotess());
            }
            $query = NotesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collNotess);
    }

    /**
     * Method called to associate a Notes object to this object
     * through the Notes foreign key attribute.
     *
     * @param    Notes $l Notes
     * @return Projects The current object (for fluent API support)
     */
    public function addNotes(Notes $l)
    {
        if ($this->collNotess === null) {
            $this->initNotess();
            $this->collNotessPartial = true;
        }
        if (!in_array($l, $this->collNotess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddNotes($l);
        }

        return $this;
    }

    /**
     * @param	Notes $notes The notes object to add.
     */
    protected function doAddNotes($notes)
    {
        $this->collNotess[]= $notes;
        $notes->setProject($this);
    }

    /**
     * @param	Notes $notes The notes object to remove.
     * @return Projects The current object (for fluent API support)
     */
    public function removeNotes($notes)
    {
        if ($this->getNotess()->contains($notes)) {
            $this->collNotess->remove($this->collNotess->search($notes));
            if (null === $this->notessScheduledForDeletion) {
                $this->notessScheduledForDeletion = clone $this->collNotess;
                $this->notessScheduledForDeletion->clear();
            }
            $this->notessScheduledForDeletion[]= clone $notes;
            $notes->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Projects is new, it will return
     * an empty collection; or if this Projects has previously
     * been saved, it will retrieve related Notess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Projects.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Notes[] List of Notes objects
     */
    public function getNotessJoinActor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = NotesQuery::create(null, $criteria);
        $query->joinWith('Actor', $join_behavior);

        return $this->getNotess($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->projectid = null;
        $this->projectcode = null;
        $this->projectname = null;
        $this->projectdescription = null;
        $this->projectstartdate = null;
        $this->projectduedate = null;
        $this->projectenddate = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collProjectActors) {
                foreach ($this->collProjectActors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFiless) {
                foreach ($this->collFiless as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMilestoness) {
                foreach ($this->collMilestoness as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTaskss) {
                foreach ($this->collTaskss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collNotess) {
                foreach ($this->collNotess as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collProjectActors instanceof PropelCollection) {
            $this->collProjectActors->clearIterator();
        }
        $this->collProjectActors = null;
        if ($this->collFiless instanceof PropelCollection) {
            $this->collFiless->clearIterator();
        }
        $this->collFiless = null;
        if ($this->collMilestoness instanceof PropelCollection) {
            $this->collMilestoness->clearIterator();
        }
        $this->collMilestoness = null;
        if ($this->collTaskss instanceof PropelCollection) {
            $this->collTaskss->clearIterator();
        }
        $this->collTaskss = null;
        if ($this->collNotess instanceof PropelCollection) {
            $this->collNotess->clearIterator();
        }
        $this->collNotess = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProjectsPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
