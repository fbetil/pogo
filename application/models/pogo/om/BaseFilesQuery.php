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
use PoGo\Actors;
use PoGo\Files;
use PoGo\FilesPeer;
use PoGo\FilesQuery;
use PoGo\Projects;

/**
 * Base class that represents a query for the 'files' table.
 *
 *
 *
 * @method FilesQuery orderById($order = Criteria::ASC) Order by the fileid column
 * @method FilesQuery orderByName($order = Criteria::ASC) Order by the filename column
 * @method FilesQuery orderByFolder($order = Criteria::ASC) Order by the filefolder column
 * @method FilesQuery orderByContent($order = Criteria::ASC) Order by the filecontent column
 * @method FilesQuery orderByMimeType($order = Criteria::ASC) Order by the filemimetype column
 * @method FilesQuery orderBySize($order = Criteria::ASC) Order by the filesize column
 * @method FilesQuery orderByVersion($order = Criteria::ASC) Order by the fileversion column
 * @method FilesQuery orderByActorId($order = Criteria::ASC) Order by the actorid column
 * @method FilesQuery orderByProjectId($order = Criteria::ASC) Order by the projectid column
 *
 * @method FilesQuery groupById() Group by the fileid column
 * @method FilesQuery groupByName() Group by the filename column
 * @method FilesQuery groupByFolder() Group by the filefolder column
 * @method FilesQuery groupByContent() Group by the filecontent column
 * @method FilesQuery groupByMimeType() Group by the filemimetype column
 * @method FilesQuery groupBySize() Group by the filesize column
 * @method FilesQuery groupByVersion() Group by the fileversion column
 * @method FilesQuery groupByActorId() Group by the actorid column
 * @method FilesQuery groupByProjectId() Group by the projectid column
 *
 * @method FilesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FilesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FilesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FilesQuery leftJoinActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Actor relation
 * @method FilesQuery rightJoinActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Actor relation
 * @method FilesQuery innerJoinActor($relationAlias = null) Adds a INNER JOIN clause to the query using the Actor relation
 *
 * @method FilesQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method FilesQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method FilesQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method Files findOne(PropelPDO $con = null) Return the first Files matching the query
 * @method Files findOneOrCreate(PropelPDO $con = null) Return the first Files matching the query, or a new Files object populated from the query conditions when no match is found
 *
 * @method Files findOneByName(string $filename) Return the first Files filtered by the filename column
 * @method Files findOneByFolder(string $filefolder) Return the first Files filtered by the filefolder column
 * @method Files findOneByContent(resource $filecontent) Return the first Files filtered by the filecontent column
 * @method Files findOneByMimeType(string $filemimetype) Return the first Files filtered by the filemimetype column
 * @method Files findOneBySize(int $filesize) Return the first Files filtered by the filesize column
 * @method Files findOneByVersion(int $fileversion) Return the first Files filtered by the fileversion column
 * @method Files findOneByActorId(int $actorid) Return the first Files filtered by the actorid column
 * @method Files findOneByProjectId(int $projectid) Return the first Files filtered by the projectid column
 *
 * @method array findById(int $fileid) Return Files objects filtered by the fileid column
 * @method array findByName(string $filename) Return Files objects filtered by the filename column
 * @method array findByFolder(string $filefolder) Return Files objects filtered by the filefolder column
 * @method array findByContent(resource $filecontent) Return Files objects filtered by the filecontent column
 * @method array findByMimeType(string $filemimetype) Return Files objects filtered by the filemimetype column
 * @method array findBySize(int $filesize) Return Files objects filtered by the filesize column
 * @method array findByVersion(int $fileversion) Return Files objects filtered by the fileversion column
 * @method array findByActorId(int $actorid) Return Files objects filtered by the actorid column
 * @method array findByProjectId(int $projectid) Return Files objects filtered by the projectid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseFilesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFilesQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Files', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FilesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FilesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FilesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FilesQuery) {
            return $criteria;
        }
        $query = new FilesQuery();
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
     * @return   Files|Files[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FilesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FilesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Files A model object, or null if the key is not found
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
     * @return                 Files A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `fileid`, `filename`, `filefolder`, `filecontent`, `filemimetype`, `filesize`, `fileversion`, `actorid`, `projectid` FROM `files` WHERE `fileid` = :p0';
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
            $obj = new Files();
            $obj->hydrate($row);
            FilesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Files|Files[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Files[]|mixed the list of results, formatted by the current formatter
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
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FilesPeer::FILEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FilesPeer::FILEID, $keys, Criteria::IN);
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
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FilesPeer::FILEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FilesPeer::FILEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesPeer::FILEID, $id, $comparison);
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
     * @return FilesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FilesPeer::FILENAME, $name, $comparison);
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
     * @return FilesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FilesPeer::FILEFOLDER, $folder, $comparison);
    }

    /**
     * Filter the query on the filecontent column
     *
     * @param     mixed $content The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {

        return $this->addUsingAlias(FilesPeer::FILECONTENT, $content, $comparison);
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
     * @return FilesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FilesPeer::FILEMIMETYPE, $mimeType, $comparison);
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
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterBySize($size = null, $comparison = null)
    {
        if (is_array($size)) {
            $useMinMax = false;
            if (isset($size['min'])) {
                $this->addUsingAlias(FilesPeer::FILESIZE, $size['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($size['max'])) {
                $this->addUsingAlias(FilesPeer::FILESIZE, $size['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesPeer::FILESIZE, $size, $comparison);
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
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(FilesPeer::FILEVERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(FilesPeer::FILEVERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesPeer::FILEVERSION, $version, $comparison);
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
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterByActorId($actorId = null, $comparison = null)
    {
        if (is_array($actorId)) {
            $useMinMax = false;
            if (isset($actorId['min'])) {
                $this->addUsingAlias(FilesPeer::ACTORID, $actorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($actorId['max'])) {
                $this->addUsingAlias(FilesPeer::ACTORID, $actorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesPeer::ACTORID, $actorId, $comparison);
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
     * @return FilesQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(FilesPeer::PROJECTID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(FilesPeer::PROJECTID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesPeer::PROJECTID, $projectId, $comparison);
    }

    /**
     * Filter the query by a related Actors object
     *
     * @param   Actors|PropelObjectCollection $actors The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FilesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActor($actors, $comparison = null)
    {
        if ($actors instanceof Actors) {
            return $this
                ->addUsingAlias(FilesPeer::ACTORID, $actors->getId(), $comparison);
        } elseif ($actors instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FilesPeer::ACTORID, $actors->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByActor() only accepts arguments of type Actors or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Actor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FilesQuery The current query, for fluid interface
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
     * Use the Actor relation Actors object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ActorsQuery A secondary query class using the current class as primary query
     */
    public function useActorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinActor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Actor', '\PoGo\ActorsQuery');
    }

    /**
     * Filter the query by a related Projects object
     *
     * @param   Projects|PropelObjectCollection $projects The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FilesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($projects, $comparison = null)
    {
        if ($projects instanceof Projects) {
            return $this
                ->addUsingAlias(FilesPeer::PROJECTID, $projects->getId(), $comparison);
        } elseif ($projects instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FilesPeer::PROJECTID, $projects->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProject() only accepts arguments of type Projects or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Project relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FilesQuery The current query, for fluid interface
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
     * Use the Project relation Projects object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ProjectsQuery A secondary query class using the current class as primary query
     */
    public function useProjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Project', '\PoGo\ProjectsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Files $files Object to remove from the list of results
     *
     * @return FilesQuery The current query, for fluid interface
     */
    public function prune($files = null)
    {
        if ($files) {
            $this->addUsingAlias(FilesPeer::FILEID, $files->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
