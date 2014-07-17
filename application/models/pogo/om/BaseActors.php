<?php

namespace PoGo\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use PoGo\Actors;
use PoGo\ActorsPeer;
use PoGo\ActorsQuery;
use PoGo\Files;
use PoGo\FilesQuery;
use PoGo\Notes;
use PoGo\NotesQuery;
use PoGo\ProjectActor;
use PoGo\ProjectActorQuery;
use PoGo\TaskActor;
use PoGo\TaskActorQuery;
use PoGo\Users;
use PoGo\UsersQuery;

/**
 * Base class that represents a row from the 'actors' table.
 *
 *
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseActors extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'PoGo\\ActorsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ActorsPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the actorid field.
     * @var        int
     */
    protected $actorid;

    /**
     * The value for the actorfirstname field.
     * @var        string
     */
    protected $actorfirstname;

    /**
     * The value for the actorname field.
     * @var        string
     */
    protected $actorname;

    /**
     * The value for the actorentity field.
     * @var        string
     */
    protected $actorentity;

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
     * @var        PropelObjectCollection|TaskActor[] Collection to store aggregation of TaskActor objects.
     */
    protected $collTaskActors;
    protected $collTaskActorsPartial;

    /**
     * @var        PropelObjectCollection|Notes[] Collection to store aggregation of Notes objects.
     */
    protected $collNotess;
    protected $collNotessPartial;

    /**
     * @var        PropelObjectCollection|Users[] Collection to store aggregation of Users objects.
     */
    protected $collUserss;
    protected $collUserssPartial;

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
    protected $taskActorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $notessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $userssScheduledForDeletion = null;

    /**
     * Get the [actorid] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->actorid;
    }

    /**
     * Get the [actorfirstname] column value.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->actorfirstname;
    }

    /**
     * Get the [actorname] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->actorname;
    }

    /**
     * Get the [actorentity] column value.
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->actorentity;
    }

    /**
     * Set the value of [actorid] column.
     *
     * @param int $v new value
     * @return Actors The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->actorid !== $v) {
            $this->actorid = $v;
            $this->modifiedColumns[] = ActorsPeer::ACTORID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [actorfirstname] column.
     *
     * @param string $v new value
     * @return Actors The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->actorfirstname !== $v) {
            $this->actorfirstname = $v;
            $this->modifiedColumns[] = ActorsPeer::ACTORFIRSTNAME;
        }


        return $this;
    } // setFirstName()

    /**
     * Set the value of [actorname] column.
     *
     * @param string $v new value
     * @return Actors The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->actorname !== $v) {
            $this->actorname = $v;
            $this->modifiedColumns[] = ActorsPeer::ACTORNAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [actorentity] column.
     *
     * @param string $v new value
     * @return Actors The current object (for fluent API support)
     */
    public function setEntity($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->actorentity !== $v) {
            $this->actorentity = $v;
            $this->modifiedColumns[] = ActorsPeer::ACTORENTITY;
        }


        return $this;
    } // setEntity()

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

            $this->actorid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->actorfirstname = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->actorname = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->actorentity = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 4; // 4 = ActorsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Actors object", $e);
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
            $con = Propel::getConnection(ActorsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ActorsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collProjectActors = null;

            $this->collFiless = null;

            $this->collTaskActors = null;

            $this->collNotess = null;

            $this->collUserss = null;

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
            $con = Propel::getConnection(ActorsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ActorsQuery::create()
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
            $con = Propel::getConnection(ActorsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ActorsPeer::addInstanceToPool($this);
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

            if ($this->userssScheduledForDeletion !== null) {
                if (!$this->userssScheduledForDeletion->isEmpty()) {
                    UsersQuery::create()
                        ->filterByPrimaryKeys($this->userssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userssScheduledForDeletion = null;
                }
            }

            if ($this->collUserss !== null) {
                foreach ($this->collUserss as $referrerFK) {
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

        $this->modifiedColumns[] = ActorsPeer::ACTORID;
        if (null !== $this->actorid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ActorsPeer::ACTORID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ActorsPeer::ACTORID)) {
            $modifiedColumns[':p' . $index++]  = '`actorid`';
        }
        if ($this->isColumnModified(ActorsPeer::ACTORFIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`actorfirstname`';
        }
        if ($this->isColumnModified(ActorsPeer::ACTORNAME)) {
            $modifiedColumns[':p' . $index++]  = '`actorname`';
        }
        if ($this->isColumnModified(ActorsPeer::ACTORENTITY)) {
            $modifiedColumns[':p' . $index++]  = '`actorentity`';
        }

        $sql = sprintf(
            'INSERT INTO `actors` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`actorid`':
                        $stmt->bindValue($identifier, $this->actorid, PDO::PARAM_INT);
                        break;
                    case '`actorfirstname`':
                        $stmt->bindValue($identifier, $this->actorfirstname, PDO::PARAM_STR);
                        break;
                    case '`actorname`':
                        $stmt->bindValue($identifier, $this->actorname, PDO::PARAM_STR);
                        break;
                    case '`actorentity`':
                        $stmt->bindValue($identifier, $this->actorentity, PDO::PARAM_STR);
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


            if (($retval = ActorsPeer::doValidate($this, $columns)) !== true) {
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

                if ($this->collTaskActors !== null) {
                    foreach ($this->collTaskActors as $referrerFK) {
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

                if ($this->collUserss !== null) {
                    foreach ($this->collUserss as $referrerFK) {
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
        $pos = ActorsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFirstName();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getEntity();
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
        if (isset($alreadyDumpedObjects['Actors'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Actors'][$this->getPrimaryKey()] = true;
        $keys = ActorsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFirstName(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getEntity(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collProjectActors) {
                $result['ProjectActors'] = $this->collProjectActors->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFiless) {
                $result['Filess'] = $this->collFiless->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTaskActors) {
                $result['TaskActors'] = $this->collTaskActors->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collNotess) {
                $result['Notess'] = $this->collNotess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserss) {
                $result['Userss'] = $this->collUserss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ActorsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFirstName($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setEntity($value);
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
        $keys = ActorsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFirstName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setEntity($arr[$keys[3]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ActorsPeer::DATABASE_NAME);

        if ($this->isColumnModified(ActorsPeer::ACTORID)) $criteria->add(ActorsPeer::ACTORID, $this->actorid);
        if ($this->isColumnModified(ActorsPeer::ACTORFIRSTNAME)) $criteria->add(ActorsPeer::ACTORFIRSTNAME, $this->actorfirstname);
        if ($this->isColumnModified(ActorsPeer::ACTORNAME)) $criteria->add(ActorsPeer::ACTORNAME, $this->actorname);
        if ($this->isColumnModified(ActorsPeer::ACTORENTITY)) $criteria->add(ActorsPeer::ACTORENTITY, $this->actorentity);

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
        $criteria = new Criteria(ActorsPeer::DATABASE_NAME);
        $criteria->add(ActorsPeer::ACTORID, $this->actorid);

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
     * Generic method to set the primary key (actorid column).
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
     * @param object $copyObj An object of Actors (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setName($this->getName());
        $copyObj->setEntity($this->getEntity());

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

            foreach ($this->getTaskActors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTaskActor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getNotess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNotes($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUsers($relObj->copy($deepCopy));
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
     * @return Actors Clone of current object.
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
     * @return ActorsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ActorsPeer();
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
        if ('TaskActor' == $relationName) {
            $this->initTaskActors();
        }
        if ('Notes' == $relationName) {
            $this->initNotess();
        }
        if ('Users' == $relationName) {
            $this->initUserss();
        }
    }

    /**
     * Clears out the collProjectActors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Actors The current object (for fluent API support)
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
     * If this Actors is new, it will return
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
                    ->filterByActor($this)
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
     * @return Actors The current object (for fluent API support)
     */
    public function setProjectActors(PropelCollection $projectActors, PropelPDO $con = null)
    {
        $projectActorsToDelete = $this->getProjectActors(new Criteria(), $con)->diff($projectActors);

        $this->projectActorsScheduledForDeletion = unserialize(serialize($projectActorsToDelete));

        foreach ($projectActorsToDelete as $projectActorRemoved) {
            $projectActorRemoved->setActor(null);
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
                ->filterByActor($this)
                ->count($con);
        }

        return count($this->collProjectActors);
    }

    /**
     * Method called to associate a ProjectActor object to this object
     * through the ProjectActor foreign key attribute.
     *
     * @param    ProjectActor $l ProjectActor
     * @return Actors The current object (for fluent API support)
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
        $projectActor->setActor($this);
    }

    /**
     * @param	ProjectActor $projectActor The projectActor object to remove.
     * @return Actors The current object (for fluent API support)
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
            $projectActor->setActor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Actors is new, it will return
     * an empty collection; or if this Actors has previously
     * been saved, it will retrieve related ProjectActors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Actors.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectActor[] List of ProjectActor objects
     */
    public function getProjectActorsJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectActorQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getProjectActors($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Actors is new, it will return
     * an empty collection; or if this Actors has previously
     * been saved, it will retrieve related ProjectActors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Actors.
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
     * @return Actors The current object (for fluent API support)
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
     * If this Actors is new, it will return
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
                    ->filterByActor($this)
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
     * @return Actors The current object (for fluent API support)
     */
    public function setFiless(PropelCollection $filess, PropelPDO $con = null)
    {
        $filessToDelete = $this->getFiless(new Criteria(), $con)->diff($filess);

        $this->filessScheduledForDeletion = unserialize(serialize($filessToDelete));

        foreach ($filessToDelete as $filesRemoved) {
            $filesRemoved->setActor(null);
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
                ->filterByActor($this)
                ->count($con);
        }

        return count($this->collFiless);
    }

    /**
     * Method called to associate a Files object to this object
     * through the Files foreign key attribute.
     *
     * @param    Files $l Files
     * @return Actors The current object (for fluent API support)
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
        $files->setActor($this);
    }

    /**
     * @param	Files $files The files object to remove.
     * @return Actors The current object (for fluent API support)
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
            $files->setActor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Actors is new, it will return
     * an empty collection; or if this Actors has previously
     * been saved, it will retrieve related Filess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Actors.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Files[] List of Files objects
     */
    public function getFilessJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FilesQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getFiless($query, $con);
    }

    /**
     * Clears out the collTaskActors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Actors The current object (for fluent API support)
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
     * If this Actors is new, it will return
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
                    ->filterByActor($this)
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
     * @return Actors The current object (for fluent API support)
     */
    public function setTaskActors(PropelCollection $taskActors, PropelPDO $con = null)
    {
        $taskActorsToDelete = $this->getTaskActors(new Criteria(), $con)->diff($taskActors);

        $this->taskActorsScheduledForDeletion = unserialize(serialize($taskActorsToDelete));

        foreach ($taskActorsToDelete as $taskActorRemoved) {
            $taskActorRemoved->setActor(null);
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
                ->filterByActor($this)
                ->count($con);
        }

        return count($this->collTaskActors);
    }

    /**
     * Method called to associate a TaskActor object to this object
     * through the TaskActor foreign key attribute.
     *
     * @param    TaskActor $l TaskActor
     * @return Actors The current object (for fluent API support)
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
        $taskActor->setActor($this);
    }

    /**
     * @param	TaskActor $taskActor The taskActor object to remove.
     * @return Actors The current object (for fluent API support)
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
            $taskActor->setActor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Actors is new, it will return
     * an empty collection; or if this Actors has previously
     * been saved, it will retrieve related TaskActors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Actors.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TaskActor[] List of TaskActor objects
     */
    public function getTaskActorsJoinTask($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TaskActorQuery::create(null, $criteria);
        $query->joinWith('Task', $join_behavior);

        return $this->getTaskActors($query, $con);
    }

    /**
     * Clears out the collNotess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Actors The current object (for fluent API support)
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
     * If this Actors is new, it will return
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
                    ->filterByActor($this)
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
     * @return Actors The current object (for fluent API support)
     */
    public function setNotess(PropelCollection $notess, PropelPDO $con = null)
    {
        $notessToDelete = $this->getNotess(new Criteria(), $con)->diff($notess);

        $this->notessScheduledForDeletion = unserialize(serialize($notessToDelete));

        foreach ($notessToDelete as $notesRemoved) {
            $notesRemoved->setActor(null);
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
                ->filterByActor($this)
                ->count($con);
        }

        return count($this->collNotess);
    }

    /**
     * Method called to associate a Notes object to this object
     * through the Notes foreign key attribute.
     *
     * @param    Notes $l Notes
     * @return Actors The current object (for fluent API support)
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
        $notes->setActor($this);
    }

    /**
     * @param	Notes $notes The notes object to remove.
     * @return Actors The current object (for fluent API support)
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
            $notes->setActor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Actors is new, it will return
     * an empty collection; or if this Actors has previously
     * been saved, it will retrieve related Notess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Actors.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Notes[] List of Notes objects
     */
    public function getNotessJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = NotesQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getNotess($query, $con);
    }

    /**
     * Clears out the collUserss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Actors The current object (for fluent API support)
     * @see        addUserss()
     */
    public function clearUserss()
    {
        $this->collUserss = null; // important to set this to null since that means it is uninitialized
        $this->collUserssPartial = null;

        return $this;
    }

    /**
     * reset is the collUserss collection loaded partially
     *
     * @return void
     */
    public function resetPartialUserss($v = true)
    {
        $this->collUserssPartial = $v;
    }

    /**
     * Initializes the collUserss collection.
     *
     * By default this just sets the collUserss collection to an empty array (like clearcollUserss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserss($overrideExisting = true)
    {
        if (null !== $this->collUserss && !$overrideExisting) {
            return;
        }
        $this->collUserss = new PropelObjectCollection();
        $this->collUserss->setModel('Users');
    }

    /**
     * Gets an array of Users objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Actors is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Users[] List of Users objects
     * @throws PropelException
     */
    public function getUserss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collUserssPartial && !$this->isNew();
        if (null === $this->collUserss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserss) {
                // return empty collection
                $this->initUserss();
            } else {
                $collUserss = UsersQuery::create(null, $criteria)
                    ->filterByActor($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collUserssPartial && count($collUserss)) {
                      $this->initUserss(false);

                      foreach($collUserss as $obj) {
                        if (false == $this->collUserss->contains($obj)) {
                          $this->collUserss->append($obj);
                        }
                      }

                      $this->collUserssPartial = true;
                    }

                    $collUserss->getInternalIterator()->rewind();
                    return $collUserss;
                }

                if($partial && $this->collUserss) {
                    foreach($this->collUserss as $obj) {
                        if($obj->isNew()) {
                            $collUserss[] = $obj;
                        }
                    }
                }

                $this->collUserss = $collUserss;
                $this->collUserssPartial = false;
            }
        }

        return $this->collUserss;
    }

    /**
     * Sets a collection of Users objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $userss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Actors The current object (for fluent API support)
     */
    public function setUserss(PropelCollection $userss, PropelPDO $con = null)
    {
        $userssToDelete = $this->getUserss(new Criteria(), $con)->diff($userss);

        $this->userssScheduledForDeletion = unserialize(serialize($userssToDelete));

        foreach ($userssToDelete as $usersRemoved) {
            $usersRemoved->setActor(null);
        }

        $this->collUserss = null;
        foreach ($userss as $users) {
            $this->addUsers($users);
        }

        $this->collUserss = $userss;
        $this->collUserssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Users objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Users objects.
     * @throws PropelException
     */
    public function countUserss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collUserssPartial && !$this->isNew();
        if (null === $this->collUserss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserss) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getUserss());
            }
            $query = UsersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByActor($this)
                ->count($con);
        }

        return count($this->collUserss);
    }

    /**
     * Method called to associate a Users object to this object
     * through the Users foreign key attribute.
     *
     * @param    Users $l Users
     * @return Actors The current object (for fluent API support)
     */
    public function addUsers(Users $l)
    {
        if ($this->collUserss === null) {
            $this->initUserss();
            $this->collUserssPartial = true;
        }
        if (!in_array($l, $this->collUserss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddUsers($l);
        }

        return $this;
    }

    /**
     * @param	Users $users The users object to add.
     */
    protected function doAddUsers($users)
    {
        $this->collUserss[]= $users;
        $users->setActor($this);
    }

    /**
     * @param	Users $users The users object to remove.
     * @return Actors The current object (for fluent API support)
     */
    public function removeUsers($users)
    {
        if ($this->getUserss()->contains($users)) {
            $this->collUserss->remove($this->collUserss->search($users));
            if (null === $this->userssScheduledForDeletion) {
                $this->userssScheduledForDeletion = clone $this->collUserss;
                $this->userssScheduledForDeletion->clear();
            }
            $this->userssScheduledForDeletion[]= clone $users;
            $users->setActor(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->actorid = null;
        $this->actorfirstname = null;
        $this->actorname = null;
        $this->actorentity = null;
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
            if ($this->collTaskActors) {
                foreach ($this->collTaskActors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collNotess) {
                foreach ($this->collNotess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserss) {
                foreach ($this->collUserss as $o) {
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
        if ($this->collTaskActors instanceof PropelCollection) {
            $this->collTaskActors->clearIterator();
        }
        $this->collTaskActors = null;
        if ($this->collNotess instanceof PropelCollection) {
            $this->collNotess->clearIterator();
        }
        $this->collNotess = null;
        if ($this->collUserss instanceof PropelCollection) {
            $this->collUserss->clearIterator();
        }
        $this->collUserss = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ActorsPeer::DEFAULT_STRING_FORMAT);
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
