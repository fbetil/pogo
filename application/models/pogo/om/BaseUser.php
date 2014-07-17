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
use PoGo\Actor;
use PoGo\ActorQuery;
use PoGo\User;
use PoGo\UserPeer;
use PoGo\UserProfile;
use PoGo\UserProfileQuery;
use PoGo\UserQuery;

/**
 * Base class that represents a row from the 'user' table.
 *
 *
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseUser extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'PoGo\\UserPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        UserPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the userid field.
     * @var        int
     */
    protected $userid;

    /**
     * The value for the userlogin field.
     * @var        string
     */
    protected $userlogin;

    /**
     * The value for the userfirstname field.
     * @var        string
     */
    protected $userfirstname;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the userpassword field.
     * @var        string
     */
    protected $userpassword;

    /**
     * The value for the useremail field.
     * @var        string
     */
    protected $useremail;

    /**
     * The value for the actorid field.
     * @var        int
     */
    protected $actorid;

    /**
     * The value for the userproperties field.
     * @var        string
     */
    protected $userproperties;

    /**
     * @var        Actor
     */
    protected $aActor;

    /**
     * @var        PropelObjectCollection|UserProfile[] Collection to store aggregation of UserProfile objects.
     */
    protected $collUserProfiles;
    protected $collUserProfilesPartial;

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
    protected $userProfilesScheduledForDeletion = null;

    /**
     * Get the [userid] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->userid;
    }

    /**
     * Get the [userlogin] column value.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->userlogin;
    }

    /**
     * Get the [userfirstname] column value.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->userfirstname;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * Get the [userpassword] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->userpassword;
    }

    /**
     * Get the [useremail] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->useremail;
    }

    /**
     * Get the [actorid] column value.
     *
     * @return int
     */
    public function getActorId()
    {
        return $this->actorid;
    }

    /**
     * Get the [userproperties] column value.
     *
     * @return string
     */
    public function getProperties()
    {
        return $this->userproperties;
    }

    /**
     * Set the value of [userid] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[] = UserPeer::USERID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [userlogin] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setLogin($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->userlogin !== $v) {
            $this->userlogin = $v;
            $this->modifiedColumns[] = UserPeer::USERLOGIN;
        }


        return $this;
    } // setLogin()

    /**
     * Set the value of [userfirstname] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->userfirstname !== $v) {
            $this->userfirstname = $v;
            $this->modifiedColumns[] = UserPeer::USERFIRSTNAME;
        }


        return $this;
    } // setFirstName()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[] = UserPeer::USERNAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [userpassword] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->userpassword !== $v) {
            $this->userpassword = $v;
            $this->modifiedColumns[] = UserPeer::USERPASSWORD;
        }


        return $this;
    } // setPassword()

    /**
     * Set the value of [useremail] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->useremail !== $v) {
            $this->useremail = $v;
            $this->modifiedColumns[] = UserPeer::USEREMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [actorid] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setActorId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->actorid !== $v) {
            $this->actorid = $v;
            $this->modifiedColumns[] = UserPeer::ACTORID;
        }

        if ($this->aActor !== null && $this->aActor->getId() !== $v) {
            $this->aActor = null;
        }


        return $this;
    } // setActorId()

    /**
     * Set the value of [userproperties] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setProperties($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->userproperties !== $v) {
            $this->userproperties = $v;
            $this->modifiedColumns[] = UserPeer::USERPROPERTIES;
        }


        return $this;
    } // setProperties()

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

            $this->userid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->userlogin = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->userfirstname = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->username = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->userpassword = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->useremail = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->actorid = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->userproperties = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 8; // 8 = UserPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating User object", $e);
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

        if ($this->aActor !== null && $this->actorid !== $this->aActor->getId()) {
            $this->aActor = null;
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
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aActor = null;
            $this->collUserProfiles = null;

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
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = UserQuery::create()
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
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                UserPeer::addInstanceToPool($this);
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

            if ($this->aActor !== null) {
                if ($this->aActor->isModified() || $this->aActor->isNew()) {
                    $affectedRows += $this->aActor->save($con);
                }
                $this->setActor($this->aActor);
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

            if ($this->userProfilesScheduledForDeletion !== null) {
                if (!$this->userProfilesScheduledForDeletion->isEmpty()) {
                    UserProfileQuery::create()
                        ->filterByPrimaryKeys($this->userProfilesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userProfilesScheduledForDeletion = null;
                }
            }

            if ($this->collUserProfiles !== null) {
                foreach ($this->collUserProfiles as $referrerFK) {
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

        $this->modifiedColumns[] = UserPeer::USERID;
        if (null !== $this->userid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserPeer::USERID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserPeer::USERID)) {
            $modifiedColumns[':p' . $index++]  = '`userid`';
        }
        if ($this->isColumnModified(UserPeer::USERLOGIN)) {
            $modifiedColumns[':p' . $index++]  = '`userlogin`';
        }
        if ($this->isColumnModified(UserPeer::USERFIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`userfirstname`';
        }
        if ($this->isColumnModified(UserPeer::USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`username`';
        }
        if ($this->isColumnModified(UserPeer::USERPASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`userpassword`';
        }
        if ($this->isColumnModified(UserPeer::USEREMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`useremail`';
        }
        if ($this->isColumnModified(UserPeer::ACTORID)) {
            $modifiedColumns[':p' . $index++]  = '`actorid`';
        }
        if ($this->isColumnModified(UserPeer::USERPROPERTIES)) {
            $modifiedColumns[':p' . $index++]  = '`userproperties`';
        }

        $sql = sprintf(
            'INSERT INTO `user` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`userid`':
                        $stmt->bindValue($identifier, $this->userid, PDO::PARAM_INT);
                        break;
                    case '`userlogin`':
                        $stmt->bindValue($identifier, $this->userlogin, PDO::PARAM_STR);
                        break;
                    case '`userfirstname`':
                        $stmt->bindValue($identifier, $this->userfirstname, PDO::PARAM_STR);
                        break;
                    case '`username`':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case '`userpassword`':
                        $stmt->bindValue($identifier, $this->userpassword, PDO::PARAM_STR);
                        break;
                    case '`useremail`':
                        $stmt->bindValue($identifier, $this->useremail, PDO::PARAM_STR);
                        break;
                    case '`actorid`':
                        $stmt->bindValue($identifier, $this->actorid, PDO::PARAM_INT);
                        break;
                    case '`userproperties`':
                        $stmt->bindValue($identifier, $this->userproperties, PDO::PARAM_STR);
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

            if ($this->aActor !== null) {
                if (!$this->aActor->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aActor->getValidationFailures());
                }
            }


            if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collUserProfiles !== null) {
                    foreach ($this->collUserProfiles as $referrerFK) {
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
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getLogin();
                break;
            case 2:
                return $this->getFirstName();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getPassword();
                break;
            case 5:
                return $this->getEmail();
                break;
            case 6:
                return $this->getActorId();
                break;
            case 7:
                return $this->getProperties();
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
        if (isset($alreadyDumpedObjects['User'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->getPrimaryKey()] = true;
        $keys = UserPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLogin(),
            $keys[2] => $this->getFirstName(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getPassword(),
            $keys[5] => $this->getEmail(),
            $keys[6] => $this->getActorId(),
            $keys[7] => $this->getProperties(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aActor) {
                $result['Actor'] = $this->aActor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collUserProfiles) {
                $result['UserProfiles'] = $this->collUserProfiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setLogin($value);
                break;
            case 2:
                $this->setFirstName($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setPassword($value);
                break;
            case 5:
                $this->setEmail($value);
                break;
            case 6:
                $this->setActorId($value);
                break;
            case 7:
                $this->setProperties($value);
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
        $keys = UserPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setLogin($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFirstName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPassword($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setActorId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setProperties($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserPeer::DATABASE_NAME);

        if ($this->isColumnModified(UserPeer::USERID)) $criteria->add(UserPeer::USERID, $this->userid);
        if ($this->isColumnModified(UserPeer::USERLOGIN)) $criteria->add(UserPeer::USERLOGIN, $this->userlogin);
        if ($this->isColumnModified(UserPeer::USERFIRSTNAME)) $criteria->add(UserPeer::USERFIRSTNAME, $this->userfirstname);
        if ($this->isColumnModified(UserPeer::USERNAME)) $criteria->add(UserPeer::USERNAME, $this->username);
        if ($this->isColumnModified(UserPeer::USERPASSWORD)) $criteria->add(UserPeer::USERPASSWORD, $this->userpassword);
        if ($this->isColumnModified(UserPeer::USEREMAIL)) $criteria->add(UserPeer::USEREMAIL, $this->useremail);
        if ($this->isColumnModified(UserPeer::ACTORID)) $criteria->add(UserPeer::ACTORID, $this->actorid);
        if ($this->isColumnModified(UserPeer::USERPROPERTIES)) $criteria->add(UserPeer::USERPROPERTIES, $this->userproperties);

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
        $criteria = new Criteria(UserPeer::DATABASE_NAME);
        $criteria->add(UserPeer::USERID, $this->userid);

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
     * Generic method to set the primary key (userid column).
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
     * @param object $copyObj An object of User (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLogin($this->getLogin());
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setName($this->getName());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setActorId($this->getActorId());
        $copyObj->setProperties($this->getProperties());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getUserProfiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserProfile($relObj->copy($deepCopy));
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
     * @return User Clone of current object.
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
     * @return UserPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new UserPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Actor object.
     *
     * @param             Actor $v
     * @return User The current object (for fluent API support)
     * @throws PropelException
     */
    public function setActor(Actor $v = null)
    {
        if ($v === null) {
            $this->setActorId(NULL);
        } else {
            $this->setActorId($v->getId());
        }

        $this->aActor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Actor object, it will not be re-added.
        if ($v !== null) {
            $v->addUser($this);
        }


        return $this;
    }


    /**
     * Get the associated Actor object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Actor The associated Actor object.
     * @throws PropelException
     */
    public function getActor(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aActor === null && ($this->actorid !== null) && $doQuery) {
            $this->aActor = ActorQuery::create()->findPk($this->actorid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aActor->addUsers($this);
             */
        }

        return $this->aActor;
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
        if ('UserProfile' == $relationName) {
            $this->initUserProfiles();
        }
    }

    /**
     * Clears out the collUserProfiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return User The current object (for fluent API support)
     * @see        addUserProfiles()
     */
    public function clearUserProfiles()
    {
        $this->collUserProfiles = null; // important to set this to null since that means it is uninitialized
        $this->collUserProfilesPartial = null;

        return $this;
    }

    /**
     * reset is the collUserProfiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialUserProfiles($v = true)
    {
        $this->collUserProfilesPartial = $v;
    }

    /**
     * Initializes the collUserProfiles collection.
     *
     * By default this just sets the collUserProfiles collection to an empty array (like clearcollUserProfiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserProfiles($overrideExisting = true)
    {
        if (null !== $this->collUserProfiles && !$overrideExisting) {
            return;
        }
        $this->collUserProfiles = new PropelObjectCollection();
        $this->collUserProfiles->setModel('UserProfile');
    }

    /**
     * Gets an array of UserProfile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|UserProfile[] List of UserProfile objects
     * @throws PropelException
     */
    public function getUserProfiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collUserProfilesPartial && !$this->isNew();
        if (null === $this->collUserProfiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserProfiles) {
                // return empty collection
                $this->initUserProfiles();
            } else {
                $collUserProfiles = UserProfileQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collUserProfilesPartial && count($collUserProfiles)) {
                      $this->initUserProfiles(false);

                      foreach($collUserProfiles as $obj) {
                        if (false == $this->collUserProfiles->contains($obj)) {
                          $this->collUserProfiles->append($obj);
                        }
                      }

                      $this->collUserProfilesPartial = true;
                    }

                    $collUserProfiles->getInternalIterator()->rewind();
                    return $collUserProfiles;
                }

                if($partial && $this->collUserProfiles) {
                    foreach($this->collUserProfiles as $obj) {
                        if($obj->isNew()) {
                            $collUserProfiles[] = $obj;
                        }
                    }
                }

                $this->collUserProfiles = $collUserProfiles;
                $this->collUserProfilesPartial = false;
            }
        }

        return $this->collUserProfiles;
    }

    /**
     * Sets a collection of UserProfile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $userProfiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return User The current object (for fluent API support)
     */
    public function setUserProfiles(PropelCollection $userProfiles, PropelPDO $con = null)
    {
        $userProfilesToDelete = $this->getUserProfiles(new Criteria(), $con)->diff($userProfiles);

        $this->userProfilesScheduledForDeletion = unserialize(serialize($userProfilesToDelete));

        foreach ($userProfilesToDelete as $userProfileRemoved) {
            $userProfileRemoved->setUser(null);
        }

        $this->collUserProfiles = null;
        foreach ($userProfiles as $userProfile) {
            $this->addUserProfile($userProfile);
        }

        $this->collUserProfiles = $userProfiles;
        $this->collUserProfilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserProfile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related UserProfile objects.
     * @throws PropelException
     */
    public function countUserProfiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collUserProfilesPartial && !$this->isNew();
        if (null === $this->collUserProfiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserProfiles) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getUserProfiles());
            }
            $query = UserProfileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collUserProfiles);
    }

    /**
     * Method called to associate a UserProfile object to this object
     * through the UserProfile foreign key attribute.
     *
     * @param    UserProfile $l UserProfile
     * @return User The current object (for fluent API support)
     */
    public function addUserProfile(UserProfile $l)
    {
        if ($this->collUserProfiles === null) {
            $this->initUserProfiles();
            $this->collUserProfilesPartial = true;
        }
        if (!in_array($l, $this->collUserProfiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddUserProfile($l);
        }

        return $this;
    }

    /**
     * @param	UserProfile $userProfile The userProfile object to add.
     */
    protected function doAddUserProfile($userProfile)
    {
        $this->collUserProfiles[]= $userProfile;
        $userProfile->setUser($this);
    }

    /**
     * @param	UserProfile $userProfile The userProfile object to remove.
     * @return User The current object (for fluent API support)
     */
    public function removeUserProfile($userProfile)
    {
        if ($this->getUserProfiles()->contains($userProfile)) {
            $this->collUserProfiles->remove($this->collUserProfiles->search($userProfile));
            if (null === $this->userProfilesScheduledForDeletion) {
                $this->userProfilesScheduledForDeletion = clone $this->collUserProfiles;
                $this->userProfilesScheduledForDeletion->clear();
            }
            $this->userProfilesScheduledForDeletion[]= clone $userProfile;
            $userProfile->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related UserProfiles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|UserProfile[] List of UserProfile objects
     */
    public function getUserProfilesJoinProfile($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = UserProfileQuery::create(null, $criteria);
        $query->joinWith('Profile', $join_behavior);

        return $this->getUserProfiles($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->userid = null;
        $this->userlogin = null;
        $this->userfirstname = null;
        $this->username = null;
        $this->userpassword = null;
        $this->useremail = null;
        $this->actorid = null;
        $this->userproperties = null;
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
            if ($this->collUserProfiles) {
                foreach ($this->collUserProfiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aActor instanceof Persistent) {
              $this->aActor->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collUserProfiles instanceof PropelCollection) {
            $this->collUserProfiles->clearIterator();
        }
        $this->collUserProfiles = null;
        $this->aActor = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserPeer::DEFAULT_STRING_FORMAT);
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
