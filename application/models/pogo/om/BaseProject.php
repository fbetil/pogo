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
use PoGo\File;
use PoGo\FileQuery;
use PoGo\Milestone;
use PoGo\MilestoneQuery;
use PoGo\Note;
use PoGo\NoteQuery;
use PoGo\Project;
use PoGo\ProjectActor;
use PoGo\ProjectActorQuery;
use PoGo\ProjectPeer;
use PoGo\ProjectQuery;
use PoGo\Task;
use PoGo\TaskQuery;

/**
 * Base class that represents a row from the 'project' table.
 *
 *
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseProject extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'PoGo\\ProjectPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProjectPeer
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
     * @var        PropelObjectCollection|File[] Collection to store aggregation of File objects.
     */
    protected $collFiles;
    protected $collFilesPartial;

    /**
     * @var        PropelObjectCollection|Milestone[] Collection to store aggregation of Milestone objects.
     */
    protected $collMilestones;
    protected $collMilestonesPartial;

    /**
     * @var        PropelObjectCollection|Task[] Collection to store aggregation of Task objects.
     */
    protected $collTasks;
    protected $collTasksPartial;

    /**
     * @var        PropelObjectCollection|Note[] Collection to store aggregation of Note objects.
     */
    protected $collNotes;
    protected $collNotesPartial;

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
    protected $filesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $milestonesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $tasksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $notesScheduledForDeletion = null;

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
     * @return Project The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->projectid !== $v) {
            $this->projectid = $v;
            $this->modifiedColumns[] = ProjectPeer::PROJECTID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [projectcode] column.
     *
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->projectcode !== $v) {
            $this->projectcode = $v;
            $this->modifiedColumns[] = ProjectPeer::PROJECTCODE;
        }


        return $this;
    } // setCode()

    /**
     * Set the value of [projectname] column.
     *
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->projectname !== $v) {
            $this->projectname = $v;
            $this->modifiedColumns[] = ProjectPeer::PROJECTNAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [projectdescription] column.
     *
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->projectdescription !== $v) {
            $this->projectdescription = $v;
            $this->modifiedColumns[] = ProjectPeer::PROJECTDESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Sets the value of [projectstartdate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Project The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->projectstartdate !== null || $dt !== null) {
            $currentDateAsString = ($this->projectstartdate !== null && $tmpDt = new DateTime($this->projectstartdate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->projectstartdate = $newDateAsString;
                $this->modifiedColumns[] = ProjectPeer::PROJECTSTARTDATE;
            }
        } // if either are not null


        return $this;
    } // setStartDate()

    /**
     * Sets the value of [projectduedate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Project The current object (for fluent API support)
     */
    public function setDueDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->projectduedate !== null || $dt !== null) {
            $currentDateAsString = ($this->projectduedate !== null && $tmpDt = new DateTime($this->projectduedate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->projectduedate = $newDateAsString;
                $this->modifiedColumns[] = ProjectPeer::PROJECTDUEDATE;
            }
        } // if either are not null


        return $this;
    } // setDueDate()

    /**
     * Sets the value of [projectenddate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Project The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->projectenddate !== null || $dt !== null) {
            $currentDateAsString = ($this->projectenddate !== null && $tmpDt = new DateTime($this->projectenddate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->projectenddate = $newDateAsString;
                $this->modifiedColumns[] = ProjectPeer::PROJECTENDDATE;
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
            return $startcol + 7; // 7 = ProjectPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Project object", $e);
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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProjectPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collProjectActors = null;

            $this->collFiles = null;

            $this->collMilestones = null;

            $this->collTasks = null;

            $this->collNotes = null;

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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProjectQuery::create()
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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ProjectPeer::addInstanceToPool($this);
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

            if ($this->filesScheduledForDeletion !== null) {
                if (!$this->filesScheduledForDeletion->isEmpty()) {
                    FileQuery::create()
                        ->filterByPrimaryKeys($this->filesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->filesScheduledForDeletion = null;
                }
            }

            if ($this->collFiles !== null) {
                foreach ($this->collFiles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->milestonesScheduledForDeletion !== null) {
                if (!$this->milestonesScheduledForDeletion->isEmpty()) {
                    MilestoneQuery::create()
                        ->filterByPrimaryKeys($this->milestonesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->milestonesScheduledForDeletion = null;
                }
            }

            if ($this->collMilestones !== null) {
                foreach ($this->collMilestones as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tasksScheduledForDeletion !== null) {
                if (!$this->tasksScheduledForDeletion->isEmpty()) {
                    TaskQuery::create()
                        ->filterByPrimaryKeys($this->tasksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->tasksScheduledForDeletion = null;
                }
            }

            if ($this->collTasks !== null) {
                foreach ($this->collTasks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->notesScheduledForDeletion !== null) {
                if (!$this->notesScheduledForDeletion->isEmpty()) {
                    NoteQuery::create()
                        ->filterByPrimaryKeys($this->notesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->notesScheduledForDeletion = null;
                }
            }

            if ($this->collNotes !== null) {
                foreach ($this->collNotes as $referrerFK) {
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

        $this->modifiedColumns[] = ProjectPeer::PROJECTID;
        if (null !== $this->projectid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProjectPeer::PROJECTID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProjectPeer::PROJECTID)) {
            $modifiedColumns[':p' . $index++]  = '`projectid`';
        }
        if ($this->isColumnModified(ProjectPeer::PROJECTCODE)) {
            $modifiedColumns[':p' . $index++]  = '`projectcode`';
        }
        if ($this->isColumnModified(ProjectPeer::PROJECTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`projectname`';
        }
        if ($this->isColumnModified(ProjectPeer::PROJECTDESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`projectdescription`';
        }
        if ($this->isColumnModified(ProjectPeer::PROJECTSTARTDATE)) {
            $modifiedColumns[':p' . $index++]  = '`projectstartdate`';
        }
        if ($this->isColumnModified(ProjectPeer::PROJECTDUEDATE)) {
            $modifiedColumns[':p' . $index++]  = '`projectduedate`';
        }
        if ($this->isColumnModified(ProjectPeer::PROJECTENDDATE)) {
            $modifiedColumns[':p' . $index++]  = '`projectenddate`';
        }

        $sql = sprintf(
            'INSERT INTO `project` (%s) VALUES (%s)',
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


            if (($retval = ProjectPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collProjectActors !== null) {
                    foreach ($this->collProjectActors as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFiles !== null) {
                    foreach ($this->collFiles as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMilestones !== null) {
                    foreach ($this->collMilestones as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTasks !== null) {
                    foreach ($this->collTasks as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collNotes !== null) {
                    foreach ($this->collNotes as $referrerFK) {
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
        $pos = ProjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['Project'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Project'][$this->getPrimaryKey()] = true;
        $keys = ProjectPeer::getFieldNames($keyType);
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
            if (null !== $this->collFiles) {
                $result['Files'] = $this->collFiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMilestones) {
                $result['Milestones'] = $this->collMilestones->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTasks) {
                $result['Tasks'] = $this->collTasks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collNotes) {
                $result['Notes'] = $this->collNotes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
        $keys = ProjectPeer::getFieldNames($keyType);

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
        $criteria = new Criteria(ProjectPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProjectPeer::PROJECTID)) $criteria->add(ProjectPeer::PROJECTID, $this->projectid);
        if ($this->isColumnModified(ProjectPeer::PROJECTCODE)) $criteria->add(ProjectPeer::PROJECTCODE, $this->projectcode);
        if ($this->isColumnModified(ProjectPeer::PROJECTNAME)) $criteria->add(ProjectPeer::PROJECTNAME, $this->projectname);
        if ($this->isColumnModified(ProjectPeer::PROJECTDESCRIPTION)) $criteria->add(ProjectPeer::PROJECTDESCRIPTION, $this->projectdescription);
        if ($this->isColumnModified(ProjectPeer::PROJECTSTARTDATE)) $criteria->add(ProjectPeer::PROJECTSTARTDATE, $this->projectstartdate);
        if ($this->isColumnModified(ProjectPeer::PROJECTDUEDATE)) $criteria->add(ProjectPeer::PROJECTDUEDATE, $this->projectduedate);
        if ($this->isColumnModified(ProjectPeer::PROJECTENDDATE)) $criteria->add(ProjectPeer::PROJECTENDDATE, $this->projectenddate);

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
        $criteria = new Criteria(ProjectPeer::DATABASE_NAME);
        $criteria->add(ProjectPeer::PROJECTID, $this->projectid);

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
     * @param object $copyObj An object of Project (or compatible) type.
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

            foreach ($this->getFiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFile($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMilestones() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMilestone($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTasks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTask($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getNotes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNote($relObj->copy($deepCopy));
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
     * @return Project Clone of current object.
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
     * @return ProjectPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProjectPeer();
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
        if ('File' == $relationName) {
            $this->initFiles();
        }
        if ('Milestone' == $relationName) {
            $this->initMilestones();
        }
        if ('Task' == $relationName) {
            $this->initTasks();
        }
        if ('Note' == $relationName) {
            $this->initNotes();
        }
    }

    /**
     * Clears out the collProjectActors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
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
     * If this Project is new, it will return
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
     * @return Project The current object (for fluent API support)
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
     * @return Project The current object (for fluent API support)
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
     * @return Project The current object (for fluent API support)
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
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related ProjectActors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
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
     * Clears out the collFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addFiles()
     */
    public function clearFiles()
    {
        $this->collFiles = null; // important to set this to null since that means it is uninitialized
        $this->collFilesPartial = null;

        return $this;
    }

    /**
     * reset is the collFiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialFiles($v = true)
    {
        $this->collFilesPartial = $v;
    }

    /**
     * Initializes the collFiles collection.
     *
     * By default this just sets the collFiles collection to an empty array (like clearcollFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFiles($overrideExisting = true)
    {
        if (null !== $this->collFiles && !$overrideExisting) {
            return;
        }
        $this->collFiles = new PropelObjectCollection();
        $this->collFiles->setModel('File');
    }

    /**
     * Gets an array of File objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|File[] List of File objects
     * @throws PropelException
     */
    public function getFiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFilesPartial && !$this->isNew();
        if (null === $this->collFiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFiles) {
                // return empty collection
                $this->initFiles();
            } else {
                $collFiles = FileQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFilesPartial && count($collFiles)) {
                      $this->initFiles(false);

                      foreach($collFiles as $obj) {
                        if (false == $this->collFiles->contains($obj)) {
                          $this->collFiles->append($obj);
                        }
                      }

                      $this->collFilesPartial = true;
                    }

                    $collFiles->getInternalIterator()->rewind();
                    return $collFiles;
                }

                if($partial && $this->collFiles) {
                    foreach($this->collFiles as $obj) {
                        if($obj->isNew()) {
                            $collFiles[] = $obj;
                        }
                    }
                }

                $this->collFiles = $collFiles;
                $this->collFilesPartial = false;
            }
        }

        return $this->collFiles;
    }

    /**
     * Sets a collection of File objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $files A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setFiles(PropelCollection $files, PropelPDO $con = null)
    {
        $filesToDelete = $this->getFiles(new Criteria(), $con)->diff($files);

        $this->filesScheduledForDeletion = unserialize(serialize($filesToDelete));

        foreach ($filesToDelete as $fileRemoved) {
            $fileRemoved->setProject(null);
        }

        $this->collFiles = null;
        foreach ($files as $file) {
            $this->addFile($file);
        }

        $this->collFiles = $files;
        $this->collFilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related File objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related File objects.
     * @throws PropelException
     */
    public function countFiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFilesPartial && !$this->isNew();
        if (null === $this->collFiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFiles) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFiles());
            }
            $query = FileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collFiles);
    }

    /**
     * Method called to associate a File object to this object
     * through the File foreign key attribute.
     *
     * @param    File $l File
     * @return Project The current object (for fluent API support)
     */
    public function addFile(File $l)
    {
        if ($this->collFiles === null) {
            $this->initFiles();
            $this->collFilesPartial = true;
        }
        if (!in_array($l, $this->collFiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFile($l);
        }

        return $this;
    }

    /**
     * @param	File $file The file object to add.
     */
    protected function doAddFile($file)
    {
        $this->collFiles[]= $file;
        $file->setProject($this);
    }

    /**
     * @param	File $file The file object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeFile($file)
    {
        if ($this->getFiles()->contains($file)) {
            $this->collFiles->remove($this->collFiles->search($file));
            if (null === $this->filesScheduledForDeletion) {
                $this->filesScheduledForDeletion = clone $this->collFiles;
                $this->filesScheduledForDeletion->clear();
            }
            $this->filesScheduledForDeletion[]= clone $file;
            $file->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related Files from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|File[] List of File objects
     */
    public function getFilesJoinActor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FileQuery::create(null, $criteria);
        $query->joinWith('Actor', $join_behavior);

        return $this->getFiles($query, $con);
    }

    /**
     * Clears out the collMilestones collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addMilestones()
     */
    public function clearMilestones()
    {
        $this->collMilestones = null; // important to set this to null since that means it is uninitialized
        $this->collMilestonesPartial = null;

        return $this;
    }

    /**
     * reset is the collMilestones collection loaded partially
     *
     * @return void
     */
    public function resetPartialMilestones($v = true)
    {
        $this->collMilestonesPartial = $v;
    }

    /**
     * Initializes the collMilestones collection.
     *
     * By default this just sets the collMilestones collection to an empty array (like clearcollMilestones());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMilestones($overrideExisting = true)
    {
        if (null !== $this->collMilestones && !$overrideExisting) {
            return;
        }
        $this->collMilestones = new PropelObjectCollection();
        $this->collMilestones->setModel('Milestone');
    }

    /**
     * Gets an array of Milestone objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Milestone[] List of Milestone objects
     * @throws PropelException
     */
    public function getMilestones($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMilestonesPartial && !$this->isNew();
        if (null === $this->collMilestones || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMilestones) {
                // return empty collection
                $this->initMilestones();
            } else {
                $collMilestones = MilestoneQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMilestonesPartial && count($collMilestones)) {
                      $this->initMilestones(false);

                      foreach($collMilestones as $obj) {
                        if (false == $this->collMilestones->contains($obj)) {
                          $this->collMilestones->append($obj);
                        }
                      }

                      $this->collMilestonesPartial = true;
                    }

                    $collMilestones->getInternalIterator()->rewind();
                    return $collMilestones;
                }

                if($partial && $this->collMilestones) {
                    foreach($this->collMilestones as $obj) {
                        if($obj->isNew()) {
                            $collMilestones[] = $obj;
                        }
                    }
                }

                $this->collMilestones = $collMilestones;
                $this->collMilestonesPartial = false;
            }
        }

        return $this->collMilestones;
    }

    /**
     * Sets a collection of Milestone objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $milestones A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setMilestones(PropelCollection $milestones, PropelPDO $con = null)
    {
        $milestonesToDelete = $this->getMilestones(new Criteria(), $con)->diff($milestones);

        $this->milestonesScheduledForDeletion = unserialize(serialize($milestonesToDelete));

        foreach ($milestonesToDelete as $milestoneRemoved) {
            $milestoneRemoved->setProject(null);
        }

        $this->collMilestones = null;
        foreach ($milestones as $milestone) {
            $this->addMilestone($milestone);
        }

        $this->collMilestones = $milestones;
        $this->collMilestonesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Milestone objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Milestone objects.
     * @throws PropelException
     */
    public function countMilestones(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMilestonesPartial && !$this->isNew();
        if (null === $this->collMilestones || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMilestones) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getMilestones());
            }
            $query = MilestoneQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collMilestones);
    }

    /**
     * Method called to associate a Milestone object to this object
     * through the Milestone foreign key attribute.
     *
     * @param    Milestone $l Milestone
     * @return Project The current object (for fluent API support)
     */
    public function addMilestone(Milestone $l)
    {
        if ($this->collMilestones === null) {
            $this->initMilestones();
            $this->collMilestonesPartial = true;
        }
        if (!in_array($l, $this->collMilestones->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMilestone($l);
        }

        return $this;
    }

    /**
     * @param	Milestone $milestone The milestone object to add.
     */
    protected function doAddMilestone($milestone)
    {
        $this->collMilestones[]= $milestone;
        $milestone->setProject($this);
    }

    /**
     * @param	Milestone $milestone The milestone object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeMilestone($milestone)
    {
        if ($this->getMilestones()->contains($milestone)) {
            $this->collMilestones->remove($this->collMilestones->search($milestone));
            if (null === $this->milestonesScheduledForDeletion) {
                $this->milestonesScheduledForDeletion = clone $this->collMilestones;
                $this->milestonesScheduledForDeletion->clear();
            }
            $this->milestonesScheduledForDeletion[]= clone $milestone;
            $milestone->setProject(null);
        }

        return $this;
    }

    /**
     * Clears out the collTasks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addTasks()
     */
    public function clearTasks()
    {
        $this->collTasks = null; // important to set this to null since that means it is uninitialized
        $this->collTasksPartial = null;

        return $this;
    }

    /**
     * reset is the collTasks collection loaded partially
     *
     * @return void
     */
    public function resetPartialTasks($v = true)
    {
        $this->collTasksPartial = $v;
    }

    /**
     * Initializes the collTasks collection.
     *
     * By default this just sets the collTasks collection to an empty array (like clearcollTasks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTasks($overrideExisting = true)
    {
        if (null !== $this->collTasks && !$overrideExisting) {
            return;
        }
        $this->collTasks = new PropelObjectCollection();
        $this->collTasks->setModel('Task');
    }

    /**
     * Gets an array of Task objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Task[] List of Task objects
     * @throws PropelException
     */
    public function getTasks($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTasksPartial && !$this->isNew();
        if (null === $this->collTasks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTasks) {
                // return empty collection
                $this->initTasks();
            } else {
                $collTasks = TaskQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTasksPartial && count($collTasks)) {
                      $this->initTasks(false);

                      foreach($collTasks as $obj) {
                        if (false == $this->collTasks->contains($obj)) {
                          $this->collTasks->append($obj);
                        }
                      }

                      $this->collTasksPartial = true;
                    }

                    $collTasks->getInternalIterator()->rewind();
                    return $collTasks;
                }

                if($partial && $this->collTasks) {
                    foreach($this->collTasks as $obj) {
                        if($obj->isNew()) {
                            $collTasks[] = $obj;
                        }
                    }
                }

                $this->collTasks = $collTasks;
                $this->collTasksPartial = false;
            }
        }

        return $this->collTasks;
    }

    /**
     * Sets a collection of Task objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $tasks A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setTasks(PropelCollection $tasks, PropelPDO $con = null)
    {
        $tasksToDelete = $this->getTasks(new Criteria(), $con)->diff($tasks);

        $this->tasksScheduledForDeletion = unserialize(serialize($tasksToDelete));

        foreach ($tasksToDelete as $taskRemoved) {
            $taskRemoved->setProject(null);
        }

        $this->collTasks = null;
        foreach ($tasks as $task) {
            $this->addTask($task);
        }

        $this->collTasks = $tasks;
        $this->collTasksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Task objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Task objects.
     * @throws PropelException
     */
    public function countTasks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTasksPartial && !$this->isNew();
        if (null === $this->collTasks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTasks) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getTasks());
            }
            $query = TaskQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collTasks);
    }

    /**
     * Method called to associate a Task object to this object
     * through the Task foreign key attribute.
     *
     * @param    Task $l Task
     * @return Project The current object (for fluent API support)
     */
    public function addTask(Task $l)
    {
        if ($this->collTasks === null) {
            $this->initTasks();
            $this->collTasksPartial = true;
        }
        if (!in_array($l, $this->collTasks->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTask($l);
        }

        return $this;
    }

    /**
     * @param	Task $task The task object to add.
     */
    protected function doAddTask($task)
    {
        $this->collTasks[]= $task;
        $task->setProject($this);
    }

    /**
     * @param	Task $task The task object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeTask($task)
    {
        if ($this->getTasks()->contains($task)) {
            $this->collTasks->remove($this->collTasks->search($task));
            if (null === $this->tasksScheduledForDeletion) {
                $this->tasksScheduledForDeletion = clone $this->collTasks;
                $this->tasksScheduledForDeletion->clear();
            }
            $this->tasksScheduledForDeletion[]= clone $task;
            $task->setProject(null);
        }

        return $this;
    }

    /**
     * Clears out the collNotes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addNotes()
     */
    public function clearNotes()
    {
        $this->collNotes = null; // important to set this to null since that means it is uninitialized
        $this->collNotesPartial = null;

        return $this;
    }

    /**
     * reset is the collNotes collection loaded partially
     *
     * @return void
     */
    public function resetPartialNotes($v = true)
    {
        $this->collNotesPartial = $v;
    }

    /**
     * Initializes the collNotes collection.
     *
     * By default this just sets the collNotes collection to an empty array (like clearcollNotes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNotes($overrideExisting = true)
    {
        if (null !== $this->collNotes && !$overrideExisting) {
            return;
        }
        $this->collNotes = new PropelObjectCollection();
        $this->collNotes->setModel('Note');
    }

    /**
     * Gets an array of Note objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Note[] List of Note objects
     * @throws PropelException
     */
    public function getNotes($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collNotesPartial && !$this->isNew();
        if (null === $this->collNotes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collNotes) {
                // return empty collection
                $this->initNotes();
            } else {
                $collNotes = NoteQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collNotesPartial && count($collNotes)) {
                      $this->initNotes(false);

                      foreach($collNotes as $obj) {
                        if (false == $this->collNotes->contains($obj)) {
                          $this->collNotes->append($obj);
                        }
                      }

                      $this->collNotesPartial = true;
                    }

                    $collNotes->getInternalIterator()->rewind();
                    return $collNotes;
                }

                if($partial && $this->collNotes) {
                    foreach($this->collNotes as $obj) {
                        if($obj->isNew()) {
                            $collNotes[] = $obj;
                        }
                    }
                }

                $this->collNotes = $collNotes;
                $this->collNotesPartial = false;
            }
        }

        return $this->collNotes;
    }

    /**
     * Sets a collection of Note objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $notes A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setNotes(PropelCollection $notes, PropelPDO $con = null)
    {
        $notesToDelete = $this->getNotes(new Criteria(), $con)->diff($notes);

        $this->notesScheduledForDeletion = unserialize(serialize($notesToDelete));

        foreach ($notesToDelete as $noteRemoved) {
            $noteRemoved->setProject(null);
        }

        $this->collNotes = null;
        foreach ($notes as $note) {
            $this->addNote($note);
        }

        $this->collNotes = $notes;
        $this->collNotesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Note objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Note objects.
     * @throws PropelException
     */
    public function countNotes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collNotesPartial && !$this->isNew();
        if (null === $this->collNotes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collNotes) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getNotes());
            }
            $query = NoteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collNotes);
    }

    /**
     * Method called to associate a Note object to this object
     * through the Note foreign key attribute.
     *
     * @param    Note $l Note
     * @return Project The current object (for fluent API support)
     */
    public function addNote(Note $l)
    {
        if ($this->collNotes === null) {
            $this->initNotes();
            $this->collNotesPartial = true;
        }
        if (!in_array($l, $this->collNotes->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddNote($l);
        }

        return $this;
    }

    /**
     * @param	Note $note The note object to add.
     */
    protected function doAddNote($note)
    {
        $this->collNotes[]= $note;
        $note->setProject($this);
    }

    /**
     * @param	Note $note The note object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeNote($note)
    {
        if ($this->getNotes()->contains($note)) {
            $this->collNotes->remove($this->collNotes->search($note));
            if (null === $this->notesScheduledForDeletion) {
                $this->notesScheduledForDeletion = clone $this->collNotes;
                $this->notesScheduledForDeletion->clear();
            }
            $this->notesScheduledForDeletion[]= clone $note;
            $note->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related Notes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Note[] List of Note objects
     */
    public function getNotesJoinActor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = NoteQuery::create(null, $criteria);
        $query->joinWith('Actor', $join_behavior);

        return $this->getNotes($query, $con);
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
            if ($this->collFiles) {
                foreach ($this->collFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMilestones) {
                foreach ($this->collMilestones as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTasks) {
                foreach ($this->collTasks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collNotes) {
                foreach ($this->collNotes as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collProjectActors instanceof PropelCollection) {
            $this->collProjectActors->clearIterator();
        }
        $this->collProjectActors = null;
        if ($this->collFiles instanceof PropelCollection) {
            $this->collFiles->clearIterator();
        }
        $this->collFiles = null;
        if ($this->collMilestones instanceof PropelCollection) {
            $this->collMilestones->clearIterator();
        }
        $this->collMilestones = null;
        if ($this->collTasks instanceof PropelCollection) {
            $this->collTasks->clearIterator();
        }
        $this->collTasks = null;
        if ($this->collNotes instanceof PropelCollection) {
            $this->collNotes->clearIterator();
        }
        $this->collNotes = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProjectPeer::DEFAULT_STRING_FORMAT);
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
