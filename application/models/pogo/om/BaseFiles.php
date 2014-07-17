<?php

namespace PoGo\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelException;
use \PropelPDO;
use PoGo\Actors;
use PoGo\ActorsQuery;
use PoGo\Files;
use PoGo\FilesPeer;
use PoGo\FilesQuery;
use PoGo\Projects;
use PoGo\ProjectsQuery;

/**
 * Base class that represents a row from the 'files' table.
 *
 *
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseFiles extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'PoGo\\FilesPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FilesPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the fileid field.
     * @var        int
     */
    protected $fileid;

    /**
     * The value for the filename field.
     * @var        string
     */
    protected $filename;

    /**
     * The value for the filefolder field.
     * @var        string
     */
    protected $filefolder;

    /**
     * The value for the filecontent field.
     * @var        resource
     */
    protected $filecontent;

    /**
     * The value for the filemimetype field.
     * @var        string
     */
    protected $filemimetype;

    /**
     * The value for the filesize field.
     * @var        int
     */
    protected $filesize;

    /**
     * The value for the fileversion field.
     * @var        int
     */
    protected $fileversion;

    /**
     * The value for the actorid field.
     * @var        int
     */
    protected $actorid;

    /**
     * The value for the projectid field.
     * @var        int
     */
    protected $projectid;

    /**
     * @var        Actors
     */
    protected $aActor;

    /**
     * @var        Projects
     */
    protected $aProject;

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
     * Get the [fileid] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->fileid;
    }

    /**
     * Get the [filename] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->filename;
    }

    /**
     * Get the [filefolder] column value.
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->filefolder;
    }

    /**
     * Get the [filecontent] column value.
     *
     * @return resource
     */
    public function getContent()
    {
        return $this->filecontent;
    }

    /**
     * Get the [filemimetype] column value.
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->filemimetype;
    }

    /**
     * Get the [filesize] column value.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->filesize;
    }

    /**
     * Get the [fileversion] column value.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->fileversion;
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
     * Get the [projectid] column value.
     *
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectid;
    }

    /**
     * Set the value of [fileid] column.
     *
     * @param int $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->fileid !== $v) {
            $this->fileid = $v;
            $this->modifiedColumns[] = FilesPeer::FILEID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [filename] column.
     *
     * @param string $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->filename !== $v) {
            $this->filename = $v;
            $this->modifiedColumns[] = FilesPeer::FILENAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [filefolder] column.
     *
     * @param string $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setFolder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->filefolder !== $v) {
            $this->filefolder = $v;
            $this->modifiedColumns[] = FilesPeer::FILEFOLDER;
        }


        return $this;
    } // setFolder()

    /**
     * Set the value of [filecontent] column.
     *
     * @param resource $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setContent($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->filecontent = fopen('php://memory', 'r+');
            fwrite($this->filecontent, $v);
            rewind($this->filecontent);
        } else { // it's already a stream
            $this->filecontent = $v;
        }
        $this->modifiedColumns[] = FilesPeer::FILECONTENT;


        return $this;
    } // setContent()

    /**
     * Set the value of [filemimetype] column.
     *
     * @param string $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setMimeType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->filemimetype !== $v) {
            $this->filemimetype = $v;
            $this->modifiedColumns[] = FilesPeer::FILEMIMETYPE;
        }


        return $this;
    } // setMimeType()

    /**
     * Set the value of [filesize] column.
     *
     * @param int $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setSize($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->filesize !== $v) {
            $this->filesize = $v;
            $this->modifiedColumns[] = FilesPeer::FILESIZE;
        }


        return $this;
    } // setSize()

    /**
     * Set the value of [fileversion] column.
     *
     * @param int $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->fileversion !== $v) {
            $this->fileversion = $v;
            $this->modifiedColumns[] = FilesPeer::FILEVERSION;
        }


        return $this;
    } // setVersion()

    /**
     * Set the value of [actorid] column.
     *
     * @param int $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setActorId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->actorid !== $v) {
            $this->actorid = $v;
            $this->modifiedColumns[] = FilesPeer::ACTORID;
        }

        if ($this->aActor !== null && $this->aActor->getId() !== $v) {
            $this->aActor = null;
        }


        return $this;
    } // setActorId()

    /**
     * Set the value of [projectid] column.
     *
     * @param int $v new value
     * @return Files The current object (for fluent API support)
     */
    public function setProjectId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->projectid !== $v) {
            $this->projectid = $v;
            $this->modifiedColumns[] = FilesPeer::PROJECTID;
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

            $this->fileid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->filename = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->filefolder = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            if ($row[$startcol + 3] !== null) {
                $this->filecontent = fopen('php://memory', 'r+');
                fwrite($this->filecontent, $row[$startcol + 3]);
                rewind($this->filecontent);
            } else {
                $this->filecontent = null;
            }
            $this->filemimetype = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->filesize = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->fileversion = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->actorid = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->projectid = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 9; // 9 = FilesPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Files object", $e);
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
            $con = Propel::getConnection(FilesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FilesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aActor = null;
            $this->aProject = null;
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
            $con = Propel::getConnection(FilesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FilesQuery::create()
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
            $con = Propel::getConnection(FilesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FilesPeer::addInstanceToPool($this);
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
                // Rewind the filecontent LOB column, since PDO does not rewind after inserting value.
                if ($this->filecontent !== null && is_resource($this->filecontent)) {
                    rewind($this->filecontent);
                }

                $this->resetModified();
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

        $this->modifiedColumns[] = FilesPeer::FILEID;
        if (null !== $this->fileid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FilesPeer::FILEID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FilesPeer::FILEID)) {
            $modifiedColumns[':p' . $index++]  = '`fileid`';
        }
        if ($this->isColumnModified(FilesPeer::FILENAME)) {
            $modifiedColumns[':p' . $index++]  = '`filename`';
        }
        if ($this->isColumnModified(FilesPeer::FILEFOLDER)) {
            $modifiedColumns[':p' . $index++]  = '`filefolder`';
        }
        if ($this->isColumnModified(FilesPeer::FILECONTENT)) {
            $modifiedColumns[':p' . $index++]  = '`filecontent`';
        }
        if ($this->isColumnModified(FilesPeer::FILEMIMETYPE)) {
            $modifiedColumns[':p' . $index++]  = '`filemimetype`';
        }
        if ($this->isColumnModified(FilesPeer::FILESIZE)) {
            $modifiedColumns[':p' . $index++]  = '`filesize`';
        }
        if ($this->isColumnModified(FilesPeer::FILEVERSION)) {
            $modifiedColumns[':p' . $index++]  = '`fileversion`';
        }
        if ($this->isColumnModified(FilesPeer::ACTORID)) {
            $modifiedColumns[':p' . $index++]  = '`actorid`';
        }
        if ($this->isColumnModified(FilesPeer::PROJECTID)) {
            $modifiedColumns[':p' . $index++]  = '`projectid`';
        }

        $sql = sprintf(
            'INSERT INTO `files` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`fileid`':
                        $stmt->bindValue($identifier, $this->fileid, PDO::PARAM_INT);
                        break;
                    case '`filename`':
                        $stmt->bindValue($identifier, $this->filename, PDO::PARAM_STR);
                        break;
                    case '`filefolder`':
                        $stmt->bindValue($identifier, $this->filefolder, PDO::PARAM_STR);
                        break;
                    case '`filecontent`':
                        if (is_resource($this->filecontent)) {
                            rewind($this->filecontent);
                        }
                        $stmt->bindValue($identifier, $this->filecontent, PDO::PARAM_LOB);
                        break;
                    case '`filemimetype`':
                        $stmt->bindValue($identifier, $this->filemimetype, PDO::PARAM_STR);
                        break;
                    case '`filesize`':
                        $stmt->bindValue($identifier, $this->filesize, PDO::PARAM_INT);
                        break;
                    case '`fileversion`':
                        $stmt->bindValue($identifier, $this->fileversion, PDO::PARAM_INT);
                        break;
                    case '`actorid`':
                        $stmt->bindValue($identifier, $this->actorid, PDO::PARAM_INT);
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

            if ($this->aActor !== null) {
                if (!$this->aActor->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aActor->getValidationFailures());
                }
            }

            if ($this->aProject !== null) {
                if (!$this->aProject->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProject->getValidationFailures());
                }
            }


            if (($retval = FilesPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = FilesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFolder();
                break;
            case 3:
                return $this->getContent();
                break;
            case 4:
                return $this->getMimeType();
                break;
            case 5:
                return $this->getSize();
                break;
            case 6:
                return $this->getVersion();
                break;
            case 7:
                return $this->getActorId();
                break;
            case 8:
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
        if (isset($alreadyDumpedObjects['Files'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Files'][$this->getPrimaryKey()] = true;
        $keys = FilesPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getFolder(),
            $keys[3] => $this->getContent(),
            $keys[4] => $this->getMimeType(),
            $keys[5] => $this->getSize(),
            $keys[6] => $this->getVersion(),
            $keys[7] => $this->getActorId(),
            $keys[8] => $this->getProjectId(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aActor) {
                $result['Actor'] = $this->aActor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProject) {
                $result['Project'] = $this->aProject->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = FilesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFolder($value);
                break;
            case 3:
                $this->setContent($value);
                break;
            case 4:
                $this->setMimeType($value);
                break;
            case 5:
                $this->setSize($value);
                break;
            case 6:
                $this->setVersion($value);
                break;
            case 7:
                $this->setActorId($value);
                break;
            case 8:
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
        $keys = FilesPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFolder($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setContent($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setMimeType($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSize($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setVersion($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setActorId($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setProjectId($arr[$keys[8]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FilesPeer::DATABASE_NAME);

        if ($this->isColumnModified(FilesPeer::FILEID)) $criteria->add(FilesPeer::FILEID, $this->fileid);
        if ($this->isColumnModified(FilesPeer::FILENAME)) $criteria->add(FilesPeer::FILENAME, $this->filename);
        if ($this->isColumnModified(FilesPeer::FILEFOLDER)) $criteria->add(FilesPeer::FILEFOLDER, $this->filefolder);
        if ($this->isColumnModified(FilesPeer::FILECONTENT)) $criteria->add(FilesPeer::FILECONTENT, $this->filecontent);
        if ($this->isColumnModified(FilesPeer::FILEMIMETYPE)) $criteria->add(FilesPeer::FILEMIMETYPE, $this->filemimetype);
        if ($this->isColumnModified(FilesPeer::FILESIZE)) $criteria->add(FilesPeer::FILESIZE, $this->filesize);
        if ($this->isColumnModified(FilesPeer::FILEVERSION)) $criteria->add(FilesPeer::FILEVERSION, $this->fileversion);
        if ($this->isColumnModified(FilesPeer::ACTORID)) $criteria->add(FilesPeer::ACTORID, $this->actorid);
        if ($this->isColumnModified(FilesPeer::PROJECTID)) $criteria->add(FilesPeer::PROJECTID, $this->projectid);

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
        $criteria = new Criteria(FilesPeer::DATABASE_NAME);
        $criteria->add(FilesPeer::FILEID, $this->fileid);

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
     * Generic method to set the primary key (fileid column).
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
     * @param object $copyObj An object of Files (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setFolder($this->getFolder());
        $copyObj->setContent($this->getContent());
        $copyObj->setMimeType($this->getMimeType());
        $copyObj->setSize($this->getSize());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setActorId($this->getActorId());
        $copyObj->setProjectId($this->getProjectId());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
     * @return Files Clone of current object.
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
     * @return FilesPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FilesPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Actors object.
     *
     * @param             Actors $v
     * @return Files The current object (for fluent API support)
     * @throws PropelException
     */
    public function setActor(Actors $v = null)
    {
        if ($v === null) {
            $this->setActorId(NULL);
        } else {
            $this->setActorId($v->getId());
        }

        $this->aActor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Actors object, it will not be re-added.
        if ($v !== null) {
            $v->addFiles($this);
        }


        return $this;
    }


    /**
     * Get the associated Actors object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Actors The associated Actors object.
     * @throws PropelException
     */
    public function getActor(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aActor === null && ($this->actorid !== null) && $doQuery) {
            $this->aActor = ActorsQuery::create()->findPk($this->actorid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aActor->addFiless($this);
             */
        }

        return $this->aActor;
    }

    /**
     * Declares an association between this object and a Projects object.
     *
     * @param             Projects $v
     * @return Files The current object (for fluent API support)
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
            $v->addFiles($this);
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
                $this->aProject->addFiless($this);
             */
        }

        return $this->aProject;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->fileid = null;
        $this->filename = null;
        $this->filefolder = null;
        $this->filecontent = null;
        $this->filemimetype = null;
        $this->filesize = null;
        $this->fileversion = null;
        $this->actorid = null;
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
            if ($this->aActor instanceof Persistent) {
              $this->aActor->clearAllReferences($deep);
            }
            if ($this->aProject instanceof Persistent) {
              $this->aProject->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aActor = null;
        $this->aProject = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FilesPeer::DEFAULT_STRING_FORMAT);
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