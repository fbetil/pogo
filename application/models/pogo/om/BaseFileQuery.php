<?php

namespace PoGo\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use PoGo\Actor;
use PoGo\File;
use PoGo\FilePeer;
use PoGo\FileQuery;
use PoGo\Project;

/**
 * Base class that represents a query for the 'file' table.
 *
 *
 *
 * @method FileQuery orderById($order = Criteria::ASC) Order by the fileid column
 * @method FileQuery orderByName($order = Criteria::ASC) Order by the filename column
 * @method FileQuery orderByFolder($order = Criteria::ASC) Order by the filefolder column
 * @method FileQuery orderByContent($order = Criteria::ASC) Order by the filecontent column
 * @method FileQuery orderByMimeType($order = Criteria::ASC) Order by the filemimetype column
 * @method FileQuery orderBySize($order = Criteria::ASC) Order by the filesize column
 * @method FileQuery orderByVersion($order = Criteria::ASC) Order by the fileversion column
 * @method FileQuery orderByActorId($order = Criteria::ASC) Order by the actorid column
 * @method FileQuery orderByProjectId($order = Criteria::ASC) Order by the projectid column
 *
 * @method FileQuery groupById() Group by the fileid column
 * @method FileQuery groupByName() Group by the filename column
 * @method FileQuery groupByFolder() Group by the filefolder column
 * @method FileQuery groupByContent() Group by the filecontent column
 * @method FileQuery groupByMimeType() Group by the filemimetype column
 * @method FileQuery groupBySize() Group by the filesize column
 * @method FileQuery groupByVersion() Group by the fileversion column
 * @method FileQuery groupByActorId() Group by the actorid column
 * @method FileQuery groupByProjectId() Group by the projectid column
 *
 * @method FileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FileQuery leftJoinActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Actor relation
 * @method FileQuery rightJoinActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Actor relation
 * @method FileQuery innerJoinActor($relationAlias = null) Adds a INNER JOIN clause to the query using the Actor relation
 *
 * @method FileQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method FileQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method FileQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method File findOne(PropelPDO $con = null) Return the first File matching the query
 * @method File findOneOrCreate(PropelPDO $con = null) Return the first File matching the query, or a new File object populated from the query conditions when no match is found
 *
 * @method File findOneByName(string $filename) Return the first File filtered by the filename column
 * @method File findOneByFolder(string $filefolder) Return the first File filtered by the filefolder column
 * @method File findOneByContent(resource $filecontent) Return the first File filtered by the filecontent column
 * @method File findOneByMimeType(string $filemimetype) Return the first File filtered by the filemimetype column
 * @method File findOneBySize(int $filesize) Return the first File filtered by the filesize column
 * @method File findOneByVersion(int $fileversion) Return the first File filtered by the fileversion column
 * @method File findOneByActorId(int $actorid) Return the first File filtered by the actorid column
 * @method File findOneByProjectId(int $projectid) Return the first File filtered by the projectid column
 *
 * @method array findById(int $fileid) Return File objects filtered by the fileid column
 * @method array findByName(string $filename) Return File objects filtered by the filename column
 * @method array findByFolder(string $filefolder) Return File objects filtered by the filefolder column
 * @method array findByContent(resource $filecontent) Return File objects filtered by the filecontent column
 * @method array findByMimeType(string $filemimetype) Return File objects filtered by the filemimetype column
 * @method array findBySize(int $filesize) Return File objects filtered by the filesize column
 * @method array findByVersion(int $fileversion) Return File objects filtered by the fileversion column
 * @method array findByActorId(int $actorid) Return File objects filtered by the actorid column
 * @method array findByProjectId(int $projectid) Return File objects filtered by the projectid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseFileQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFileQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\File', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FileQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FileQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FileQuery) {
            return $criteria;
        }
        $query = new FileQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   File|File[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FilePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 File A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 File A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `fileid`, `filename`, `filefolder`, `filecontent`, `filemimetype`, `filesize`, `fileversion`, `actorid`, `projectid` FROM `file` WHERE `fileid` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new File();
            $obj->hydrate($row);
            FilePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return File|File[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|File[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FilePeer::FILEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FilePeer::FILEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the fileid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE fileid = 1234
     * $query->filterById(array(12, 34)); // WHERE fileid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE fileid >= 12
     * $query->filterById(array('max' => 12)); // WHERE fileid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FilePeer::FILEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FilePeer::FILEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::FILEID, $id, $comparison);
    }

    /**
     * Filter the query on the filename column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE filename = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE filename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilePeer::FILENAME, $name, $comparison);
    }

    /**
     * Filter the query on the filefolder column
     *
     * Example usage:
     * <code>
     * $query->filterByFolder('fooValue');   // WHERE filefolder = 'fooValue'
     * $query->filterByFolder('%fooValue%'); // WHERE filefolder LIKE '%fooValue%'
     * </code>
     *
     * @param     string $folder The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByFolder($folder = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($folder)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $folder)) {
                $folder = str_replace('*', '%', $folder);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilePeer::FILEFOLDER, $folder, $comparison);
    }

    /**
     * Filter the query on the filecontent column
     *
     * @param     mixed $content The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {

        return $this->addUsingAlias(FilePeer::FILECONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the filemimetype column
     *
     * Example usage:
     * <code>
     * $query->filterByMimeType('fooValue');   // WHERE filemimetype = 'fooValue'
     * $query->filterByMimeType('%fooValue%'); // WHERE filemimetype LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mimeType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByMimeType($mimeType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mimeType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mimeType)) {
                $mimeType = str_replace('*', '%', $mimeType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilePeer::FILEMIMETYPE, $mimeType, $comparison);
    }

    /**
     * Filter the query on the filesize column
     *
     * Example usage:
     * <code>
     * $query->filterBySize(1234); // WHERE filesize = 1234
     * $query->filterBySize(array(12, 34)); // WHERE filesize IN (12, 34)
     * $query->filterBySize(array('min' => 12)); // WHERE filesize >= 12
     * $query->filterBySize(array('max' => 12)); // WHERE filesize <= 12
     * </code>
     *
     * @param     mixed $size The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterBySize($size = null, $comparison = null)
    {
        if (is_array($size)) {
            $useMinMax = false;
            if (isset($size['min'])) {
                $this->addUsingAlias(FilePeer::FILESIZE, $size['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($size['max'])) {
                $this->addUsingAlias(FilePeer::FILESIZE, $size['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::FILESIZE, $size, $comparison);
    }

    /**
     * Filter the query on the fileversion column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE fileversion = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE fileversion IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE fileversion >= 12
     * $query->filterByVersion(array('max' => 12)); // WHERE fileversion <= 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(FilePeer::FILEVERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(FilePeer::FILEVERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::FILEVERSION, $version, $comparison);
    }

    /**
     * Filter the query on the actorid column
     *
     * Example usage:
     * <code>
     * $query->filterByActorId(1234); // WHERE actorid = 1234
     * $query->filterByActorId(array(12, 34)); // WHERE actorid IN (12, 34)
     * $query->filterByActorId(array('min' => 12)); // WHERE actorid >= 12
     * $query->filterByActorId(array('max' => 12)); // WHERE actorid <= 12
     * </code>
     *
     * @see       filterByActor()
     *
     * @param     mixed $actorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByActorId($actorId = null, $comparison = null)
    {
        if (is_array($actorId)) {
            $useMinMax = false;
            if (isset($actorId['min'])) {
                $this->addUsingAlias(FilePeer::ACTORID, $actorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($actorId['max'])) {
                $this->addUsingAlias(FilePeer::ACTORID, $actorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::ACTORID, $actorId, $comparison);
    }

    /**
     * Filter the query on the projectid column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectId(1234); // WHERE projectid = 1234
     * $query->filterByProjectId(array(12, 34)); // WHERE projectid IN (12, 34)
     * $query->filterByProjectId(array('min' => 12)); // WHERE projectid >= 12
     * $query->filterByProjectId(array('max' => 12)); // WHERE projectid <= 12
     * </code>
     *
     * @see       filterByProject()
     *
     * @param     mixed $projectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(FilePeer::PROJECTID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(FilePeer::PROJECTID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::PROJECTID, $projectId, $comparison);
    }

    /**
     * Filter the query by a related Actor object
     *
     * @param   Actor|PropelObjectCollection $actor The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActor($actor, $comparison = null)
    {
        if ($actor instanceof Actor) {
            return $this
                ->addUsingAlias(FilePeer::ACTORID, $actor->getId(), $comparison);
        } elseif ($actor instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FilePeer::ACTORID, $actor->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByActor() only accepts arguments of type Actor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Actor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function joinActor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Actor');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Actor');
        }

        return $this;
    }

    /**
     * Use the Actor relation Actor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ActorQuery A secondary query class using the current class as primary query
     */
    public function useActorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinActor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Actor', '\PoGo\ActorQuery');
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(FilePeer::PROJECTID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FilePeer::PROJECTID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProject() only accepts arguments of type Project or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Project relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function joinProject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Project');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Project');
        }

        return $this;
    }

    /**
     * Use the Project relation Project object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ProjectQuery A secondary query class using the current class as primary query
     */
    public function useProjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Project', '\PoGo\ProjectQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   File $file Object to remove from the list of results
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function prune($file = null)
    {
        if ($file) {
            $this->addUsingAlias(FilePeer::FILEID, $file->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
