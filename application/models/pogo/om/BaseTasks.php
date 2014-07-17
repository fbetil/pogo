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
use PoGo\Projects;
use PoGo\ProjectsQuery;
use PoGo\TaskActor;
use PoGo\TaskActorQuery;
use PoGo\Tasks;
use PoGo\TasksPeer;
use PoGo\TasksQuery;

/**
 * Base class that represents a row from the 'tasks' table.
 *
 *
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseTasks extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'PoGo\\TasksPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        TasksPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the taskid field.
     * @var        int
     */
    protected $taskid;

    /**
     * The value for the taskname field.
     * @var        string
     */
    protected $taskname;

    /**
     * The value for the taskdescription field.
     * @var        string
     */
    protected $taskdescription;

    /**
     * The value for the taskstartdate field.
     * @var        string
     */
    protected $taskstartdate;

    /**
     * The value for the taskduedate field.
     * @var        string
     */
    protected $taskduedate;

    /**
     * The value for the taskprogress field.
     * @var        int
     */
    protected $taskprogress;

    /**
     * The value for the projectid field.
     * @var        int
     */
    protected $projectid;

    /**
     * @var        Projects
     */
    protected $aProject;

    /**
     * @var        PropelObjectCollection|TaskActor[] Collection to store aggregation of TaskActor objects.
     */
    protected $collTaskActors;
    protected $collTaskActorsPartial;

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
    protected $taskActorsScheduledForDeletion = null;

    /**
     * Get the [taskid] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->taskid;
    }

    /**
     * Get the [taskname] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->taskname;
    }

    /**
     * Get the [taskdescription] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->taskdescription;
    }

    /**
     * Get the [optionally formatted] temporal [taskstartdate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = '%x')
    {
        if ($this->taskstartdate === null) {
            return null;
        }

        if ($this->taskstartdate === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->taskstartdate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->taskstartdate, true), $x);
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
     * Get the [optionally formatted] temporal [taskduedate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDueDate($format = '%x')
    {
        if ($this->taskduedate === null) {
            return null;
        }

        if ($this->taskduedate === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->taskduedate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->taskduedate, true), $x);
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
     * Get the [taskprogress] column value.
     *
     * @return int
     */
    public function getProgress()
    {
        return $this->taskprogress;
    }

    /**
     * Get the [projectid] column value.
     *
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectid;
    }

    /**
     * Set the value of [taskid] column.
     *
     * @param int $v new value
     * @return Tasks The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->taskid !== $v) {
            $this->taskid = $v;
            $this->modifiedColumns[] = TasksPeer::TASKID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [taskname] column.
     *
     * @param string $v new value
     * @return Tasks The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->taskname !== $v) {
            $this->taskname = $v;
            $this->modifiedColumns[] = TasksPeer::TASKNAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [taskdescription] column.
     *
     * @param string $v new value
     * @return Tasks The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->taskdescription !== $v) {
            $this->taskdescription = $v;
            $this->modifiedColumns[] = TasksPeer::TASKDESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Sets the value of [taskstartdate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Tasks The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->taskstartdate !== null || $dt !== null) {
            $currentDateAsString = ($this->taskstartdate !== null && $tmpDt = new DateTime($this->taskstartdate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->taskstartdate = $newDateAsString;
                $this->modifiedColumns[] = TasksPeer::TASKSTARTDATE;
            }
        } // if either are not null


        return $this;
    } // setStartDate()

    /**
     * Sets the value of [taskduedate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Tasks The current object (for fluent API support)
     */
    public function setDueDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->taskduedate !== null || $dt !== null) {
            $currentDateAsString = ($this->taskduedate !== null && $tmpDt = new DateTime($this->taskduedate)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->taskduedate = $newDateAsString;
                $this->modifiedColumns[] = TasksPeer::TASKDUEDATE;
            }
        } // if either are not null


        return $this;
    } // setDueDate()

    /**
     * Set the value of [taskprogress] column.
     *
     * @param int $v new value
     * @return Tasks The current object (for fluent API support)
     */
    public function setProgress($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->taskprogress !== $v) {
            $this->taskprogress = $v;
            $this->modifiedColumns[] = TasksPeer::TASKPROGRESS;
        }


        return $this;
    } // setProgress()

    /**
     * Set the value of [projectid] column.
     *
     * @param int $v new value
     * @return Tasks The current object (for fluent API support)
     */
    public function setProjectId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->projectid !== $v) {
            $this->projectid = $v;
            $this->modifiedColumns[] = TasksPeer::PROJECTID;
        }

        if ($this->aProject !== null && $this->aProject->getId() !== $v) {
            $this->aProject = null;
        }


        return $this;
    } // setProjectId()

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

            $this->taskid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->taskname = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->taskdescription = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->taskstartdate = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->taskduedate = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->taskprogress = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->projectid = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = TasksPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Tasks object", $e);
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

        if ($this->aProject !== null && $this->projectid !== $this->aProject->getId()) {
            $this->aProject = null;
        }
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
            $con = Propel::getConnection(TasksPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = TasksPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProject = null;
            $this->collTaskActors = null;

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
            $con = Propel::getConnection(TasksPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = TasksQuery::create()
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
            $con = Propel::getConnection(TasksPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                TasksPeer::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProject !== null) {
                if ($this->aProject->isModified() || $this->aProject->isNew()) {
                    $affectedRows += $this->aProject->save($con);
                }
                $this->setProject($this->aProject);
            }

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

            if ($this->taskActorsScheduledForDeletion !== null) {
                if (!$this->taskActorsScheduledForDeletion->isEmpty()) {
                    TaskActorQuery::create()
                        ->filterByPrimaryKeys($this->taskActorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->taskActorsScheduledForDeletion = null;
                }
            }

            if ($this->collTaskActors !== null) {
                foreach ($this->collTaskActors as $referrerFK) {
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

        $this->modifiedColumns[] = TasksPeer::TASKID;
        if (null !== $this->taskid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TasksPeer::TASKID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TasksPeer::TASKID)) {
            $modifiedColumns[':p' . $index++]  = '`taskid`';
        }
        if ($this->isColumnModified(TasksPeer::TASKNAME)) {
            $modifiedColumns[':p' . $index++]  = '`taskname`';
        }
        if ($this->isColumnModified(TasksPeer::TASKDESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`taskdescription`';
        }
        if ($this->isColumnModified(TasksPeer::TASKSTARTDATE)) {
            $modifiedColumns[':p' . $index++]  = '`taskstartdate`';
        }
        if ($this->isColumnModified(TasksPeer::TASKDUEDATE)) {
            $modifiedColumns[':p' . $index++]  = '`taskduedate`';
        }
        if ($this->isColumnModified(TasksPeer::TASKPROGRESS)) {
            $modifiedColumns[':p' . $index++]  = '`taskprogress`';
        }
        if ($this->isColumnModified(TasksPeer::PROJECTID)) {
            $modifiedColumns[':p' . $index++]  = '`projectid`';
        }

        $sql = sprintf(
            'INSERT INTO `tasks` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`taskid`':
                        $stmt->bindValue($identifier, $this->taskid, PDO::PARAM_INT);
                        break;
                    case '`taskname`':
                        $stmt->bindValue($identifier, $this->taskname, PDO::PARAM_STR);
                        break;
                    case '`taskdescription`':
                        $stmt->bindValue($identifier, $this->taskdescription, PDO::PARAM_STR);
                        break;
                    case '`taskstartdate`':
                        $stmt->bindValue($identifier, $this->taskstartdate, PDO::PARAM_STR);
                        break;
                    case '`taskduedate`':
                        $stmt->bindValue($identifier, $this->taskduedate, PDO::PARAM_STR);
                        break;
                    case '`taskprogress`':
                        $stmt->bindValue($identifier, $this->taskprogress, PDO::PARAM_INT);
                        break;
                    case '`projectid`':
                        $stmt->bindValue($identifier, $this->projectid, PDO::PARAM_INT);
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


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProject !== null) {
                if (!$this->aProject->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProject->getValidationFailures());
                }
            }


            if (($retval = TasksPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collTaskActors !== null) {
                    foreach ($this->collTaskActors as $referrerFK) {
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
        $pos = TasksPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getStartDate();
                break;
            case 4:
                return $this->getDueDate();
                break;
            case 5:
                return $this->getProgress();
                break;
            case 6:
                return $this->getProjectId();
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
        if (isset($alreadyDumpedObjects['Tasks'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Tasks'][$this->getPrimaryKey()] = true;
        $keys = TasksPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getStartDate(),
            $keys[4] => $this->getDueDate(),
            $keys[5] => $this->getProgress(),
            $keys[6] => $this->getProjectId(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aProject) {
                $result['Project'] = $this->aProject->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTaskActors) {
                $result['TaskActors'] = $this->collTaskActors->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = TasksPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setName($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setStartDate($value);
                break;
            case 4:
                $this->setDueDate($value);
                break;
            case 5:
                $this->setProgress($value);
                break;
            case 6:
                $this->setProjectId($value);
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
        $keys = TasksPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setStartDate($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDueDate($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setProgress($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setProjectId($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TasksPeer::DATABASE_NAME);

        if ($this->isColumnModified(TasksPeer::TASKID)) $criteria->add(TasksPeer::TASKID, $this->taskid);
        if ($this->isColumnModified(TasksPeer::TASKNAME)) $criteria->add(TasksPeer::TASKNAME, $this->taskname);
        if ($this->isColumnModified(TasksPeer::TASKDESCRIPTION)) $criteria->add(TasksPeer::TASKDESCRIPTION, $this->taskdescription);
        if ($this->isColumnModified(TasksPeer::TASKSTARTDATE)) $criteria->add(TasksPeer::TASKSTARTDATE, $this->taskstartdate);
        if ($this->isColumnModified(TasksPeer::TASKDUEDATE)) $criteria->add(TasksPeer::TASKDUEDATE, $this->taskduedate);
        if ($this->isColumnModified(TasksPeer::TASKPROGRESS)) $criteria->add(TasksPeer::TASKPROGRESS, $this->taskprogress);
        if ($this->isColumnModified(TasksPeer::PROJECTID)) $criteria->add(TasksPeer::PROJECTID, $this->projectid);

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
        $criteria = new Criteria(TasksPeer::DATABASE_NAME);
        $criteria->add(TasksPeer::TASKID, $this->taskid);

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
     * Generic method to set the primary key (taskid column).
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
     * @param object $copyObj An object of Tasks (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setDueDate($this->getDueDate());
        $copyObj->setProgress($this->getProgress());
        $copyObj->setProjectId($this->getProjectId());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getTaskActors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTaskActor($relObj->copy($deepCopy));
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
     * @return Tasks Clone of current object.
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
     * @return TasksPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new TasksPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Projects object.
     *
     * @param             Projects $v
     * @return Tasks The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProject(Projects $v = null)
    {
        if ($v === null) {
            $this->setProjectId(NULL);
        } else {
            $this->setProjectId($v->getId());
        }

        $this->aProject = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Projects object, it will not be re-added.
        if ($v !== null) {
            $v->addTasks($this);
        }


        return $this;
    }


    /**
     * Get the associated Projects object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Projects The associated Projects object.
     * @throws PropelException
     */
    public function getProject(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProject === null && ($this->projectid !== null) && $doQuery) {
            $this->aProject = ProjectsQuery::create()->findPk($this->projectid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProject->addTaskss($this);
             */
        }

        return $this->aProject;
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
        if ('TaskActor' == $relationName) {
            $this->initTaskActors();
        }
    }

    /**
     * Clears out the collTaskActors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Tasks The current object (for fluent API support)
     * @see        addTaskActors()
     */
    public function clearTaskActors()
    {
        $this->collTaskActors = null; // important to set this to null since that means it is uninitialized
        $this->collTaskActorsPartial = null;

        return $this;
    }

    /**
     * reset is the collTaskActors collection loaded partially
     *
     * @return void
     */
    public function resetPartialTaskActors($v = true)
    {
        $this->collTaskActorsPartial = $v;
    }

    /**
     * Initializes the collTaskActors collection.
     *
     * By default this just sets the collTaskActors collection to an empty array (like clearcollTaskActors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTaskActors($overrideExisting = true)
    {
        if (null !== $this->collTaskActors && !$overrideExisting) {
            return;
        }
        $this->collTaskActors = new PropelObjectCollection();
        $this->collTaskActors->setModel('TaskActor');
    }

    /**
     * Gets an array of TaskActor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Tasks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|TaskActor[] List of TaskActor objects
     * @throws PropelException
     */
    public function getTaskActors($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTaskActorsPartial && !$this->isNew();
        if (null === $this->collTaskActors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTaskActors) {
                // return empty collection
                $this->initTaskActors();
            } else {
                $collTaskActors = TaskActorQuery::create(null, $criteria)
                    ->filterByTask($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTaskActorsPartial && count($collTaskActors)) {
                      $this->initTaskActors(false);

                      foreach($collTaskActors as $obj) {
                        if (false == $this->collTaskActors->contains($obj)) {
                          $this->collTaskActors->append($obj);
                        }
                      }

                      $this->collTaskActorsPartial = true;
                    }

                    $collTaskActors->getInternalIterator()->rewind();
                    return $collTaskActors;
                }

                if($partial && $this->collTaskActors) {
                    foreach($this->collTaskActors as $obj) {
                        if($obj->isNew()) {
                            $collTaskActors[] = $obj;
                        }
                    }
                }

                $this->collTaskActors = $collTaskActors;
                $this->collTaskActorsPartial = false;
            }
        }

        return $this->collTaskActors;
    }

    /**
     * Sets a collection of TaskActor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $taskActors A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Tasks The current object (for fluent API support)
     */
    public function setTaskActors(PropelCollection $taskActors, PropelPDO $con = null)
    {
        $taskActorsToDelete = $this->getTaskActors(new Criteria(), $con)->diff($taskActors);

        $this->taskActorsScheduledForDeletion = unserialize(serialize($taskActorsToDelete));

        foreach ($taskActorsToDelete as $taskActorRemoved) {
            $taskActorRemoved->setTask(null);
        }

        $this->collTaskActors = null;
        foreach ($taskActors as $taskActor) {
            $this->addTaskActor($taskActor);
        }

        $this->collTaskActors = $taskActors;
        $this->collTaskActorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TaskActor objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related TaskActor objects.
     * @throws PropelException
     */
    public function countTaskActors(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTaskActorsPartial && !$this->isNew();
        if (null === $this->collTaskActors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTaskActors) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getTaskActors());
            }
            $query = TaskActorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTask($this)
                ->count($con);
        }

        return count($this->collTaskActors);
    }

    /**
     * Method called to associate a TaskActor object to this object
     * through the TaskActor foreign key attribute.
     *
     * @param    TaskActor $l TaskActor
     * @return Tasks The current object (for fluent API support)
     */
    public function addTaskActor(TaskActor $l)
    {
        if ($this->collTaskActors === null) {
            $this->initTaskActors();
            $this->collTaskActorsPartial = true;
        }
        if (!in_array($l, $this->collTaskActors->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTaskActor($l);
        }

        return $this;
    }

    /**
     * @param	TaskActor $taskActor The taskActor object to add.
     */
    protected function doAddTaskActor($taskActor)
    {
        $this->collTaskActors[]= $taskActor;
        $taskActor->setTask($this);
    }

    /**
     * @param	TaskActor $taskActor The taskActor object to remove.
     * @return Tasks The current object (for fluent API support)
     */
    public function removeTaskActor($taskActor)
    {
        if ($this->getTaskActors()->contains($taskActor)) {
            $this->collTaskActors->remove($this->collTaskActors->search($taskActor));
            if (null === $this->taskActorsScheduledForDeletion) {
                $this->taskActorsScheduledForDeletion = clone $this->collTaskActors;
                $this->taskActorsScheduledForDeletion->clear();
            }
            $this->taskActorsScheduledForDeletion[]= clone $taskActor;
            $taskActor->setTask(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tasks is new, it will return
     * an empty collection; or if this Tasks has previously
     * been saved, it will retrieve related TaskActors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tasks.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TaskActor[] List of TaskActor objects
     */
    public function getTaskActorsJoinActor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TaskActorQuery::create(null, $criteria);
        $query->joinWith('Actor', $join_behavior);

        return $this->getTaskActors($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->taskid = null;
        $this->taskname = null;
        $this->taskdescription = null;
        $this->taskstartdate = null;
        $this->taskduedate = null;
        $this->taskprogress = null;
        $this->projectid = null;
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
            if ($this->collTaskActors) {
                foreach ($this->collTaskActors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aProject instanceof Persistent) {
              $this->aProject->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collTaskActors instanceof PropelCollection) {
            $this->collTaskActors->clearIterator();
        }
        $this->collTaskActors = null;
        $this->aProject = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TasksPeer::DEFAULT_STRING_FORMAT);
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
