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
use PoGo\Files;
use PoGo\Milestones;
use PoGo\Notes;
use PoGo\ProjectActor;
use PoGo\Projects;
use PoGo\ProjectsPeer;
use PoGo\ProjectsQuery;
use PoGo\Tasks;

/**
 * Base class that represents a query for the 'projects' table.
 *
 *
 *
 * @method ProjectsQuery orderById($order = Criteria::ASC) Order by the projectid column
 * @method ProjectsQuery orderByCode($order = Criteria::ASC) Order by the projectcode column
 * @method ProjectsQuery orderByName($order = Criteria::ASC) Order by the projectname column
 * @method ProjectsQuery orderByDescription($order = Criteria::ASC) Order by the projectdescription column
 * @method ProjectsQuery orderByStartDate($order = Criteria::ASC) Order by the projectstartdate column
 * @method ProjectsQuery orderByDueDate($order = Criteria::ASC) Order by the projectduedate column
 * @method ProjectsQuery orderByEndDate($order = Criteria::ASC) Order by the projectenddate column
 *
 * @method ProjectsQuery groupById() Group by the projectid column
 * @method ProjectsQuery groupByCode() Group by the projectcode column
 * @method ProjectsQuery groupByName() Group by the projectname column
 * @method ProjectsQuery groupByDescription() Group by the projectdescription column
 * @method ProjectsQuery groupByStartDate() Group by the projectstartdate column
 * @method ProjectsQuery groupByDueDate() Group by the projectduedate column
 * @method ProjectsQuery groupByEndDate() Group by the projectenddate column
 *
 * @method ProjectsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectsQuery leftJoinProjectActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectActor relation
 * @method ProjectsQuery rightJoinProjectActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectActor relation
 * @method ProjectsQuery innerJoinProjectActor($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectActor relation
 *
 * @method ProjectsQuery leftJoinFiles($relationAlias = null) Adds a LEFT JOIN clause to the query using the Files relation
 * @method ProjectsQuery rightJoinFiles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Files relation
 * @method ProjectsQuery innerJoinFiles($relationAlias = null) Adds a INNER JOIN clause to the query using the Files relation
 *
 * @method ProjectsQuery leftJoinMilestones($relationAlias = null) Adds a LEFT JOIN clause to the query using the Milestones relation
 * @method ProjectsQuery rightJoinMilestones($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Milestones relation
 * @method ProjectsQuery innerJoinMilestones($relationAlias = null) Adds a INNER JOIN clause to the query using the Milestones relation
 *
 * @method ProjectsQuery leftJoinTasks($relationAlias = null) Adds a LEFT JOIN clause to the query using the Tasks relation
 * @method ProjectsQuery rightJoinTasks($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Tasks relation
 * @method ProjectsQuery innerJoinTasks($relationAlias = null) Adds a INNER JOIN clause to the query using the Tasks relation
 *
 * @method ProjectsQuery leftJoinNotes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notes relation
 * @method ProjectsQuery rightJoinNotes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notes relation
 * @method ProjectsQuery innerJoinNotes($relationAlias = null) Adds a INNER JOIN clause to the query using the Notes relation
 *
 * @method Projects findOne(PropelPDO $con = null) Return the first Projects matching the query
 * @method Projects findOneOrCreate(PropelPDO $con = null) Return the first Projects matching the query, or a new Projects object populated from the query conditions when no match is found
 *
 * @method Projects findOneByCode(string $projectcode) Return the first Projects filtered by the projectcode column
 * @method Projects findOneByName(string $projectname) Return the first Projects filtered by the projectname column
 * @method Projects findOneByDescription(string $projectdescription) Return the first Projects filtered by the projectdescription column
 * @method Projects findOneByStartDate(string $projectstartdate) Return the first Projects filtered by the projectstartdate column
 * @method Projects findOneByDueDate(string $projectduedate) Return the first Projects filtered by the projectduedate column
 * @method Projects findOneByEndDate(string $projectenddate) Return the first Projects filtered by the projectenddate column
 *
 * @method array findById(int $projectid) Return Projects objects filtered by the projectid column
 * @method array findByCode(string $projectcode) Return Projects objects filtered by the projectcode column
 * @method array findByName(string $projectname) Return Projects objects filtered by the projectname column
 * @method array findByDescription(string $projectdescription) Return Projects objects filtered by the projectdescription column
 * @method array findByStartDate(string $projectstartdate) Return Projects objects filtered by the projectstartdate column
 * @method array findByDueDate(string $projectduedate) Return Projects objects filtered by the projectduedate column
 * @method array findByEndDate(string $projectenddate) Return Projects objects filtered by the projectenddate column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseProjectsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Projects', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectsQuery) {
            return $criteria;
        }
        $query = new ProjectsQuery();
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
     * @return   Projects|Projects[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Projects A model object, or null if the key is not found
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
     * @return                 Projects A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `projectid`, `projectcode`, `projectname`, `projectdescription`, `projectstartdate`, `projectduedate`, `projectenddate` FROM `projects` WHERE `projectid` = :p0';
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
            $obj = new Projects();
            $obj->hydrate($row);
            ProjectsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Projects|Projects[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Projects[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectsPeer::PROJECTID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectsPeer::PROJECTID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the projectid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE projectid = 1234
     * $query->filterById(array(12, 34)); // WHERE projectid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE projectid >= 12
     * $query->filterById(array('max' => 12)); // WHERE projectid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::PROJECTID, $id, $comparison);
    }

    /**
     * Filter the query on the projectcode column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE projectcode = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE projectcode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::PROJECTCODE, $code, $comparison);
    }

    /**
     * Filter the query on the projectname column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE projectname = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE projectname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectsPeer::PROJECTNAME, $name, $comparison);
    }

    /**
     * Filter the query on the projectdescription column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE projectdescription = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE projectdescription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::PROJECTDESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the projectstartdate column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE projectstartdate = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE projectstartdate = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE projectstartdate > '2011-03-13'
     * </code>
     *
     * @param     mixed $startDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTSTARTDATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTSTARTDATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::PROJECTSTARTDATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the projectduedate column
     *
     * Example usage:
     * <code>
     * $query->filterByDueDate('2011-03-14'); // WHERE projectduedate = '2011-03-14'
     * $query->filterByDueDate('now'); // WHERE projectduedate = '2011-03-14'
     * $query->filterByDueDate(array('max' => 'yesterday')); // WHERE projectduedate > '2011-03-13'
     * </code>
     *
     * @param     mixed $dueDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByDueDate($dueDate = null, $comparison = null)
    {
        if (is_array($dueDate)) {
            $useMinMax = false;
            if (isset($dueDate['min'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTDUEDATE, $dueDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dueDate['max'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTDUEDATE, $dueDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::PROJECTDUEDATE, $dueDate, $comparison);
    }

    /**
     * Filter the query on the projectenddate column
     *
     * Example usage:
     * <code>
     * $query->filterByEndDate('2011-03-14'); // WHERE projectenddate = '2011-03-14'
     * $query->filterByEndDate('now'); // WHERE projectenddate = '2011-03-14'
     * $query->filterByEndDate(array('max' => 'yesterday')); // WHERE projectenddate > '2011-03-13'
     * </code>
     *
     * @param     mixed $endDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTENDDATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(ProjectsPeer::PROJECTENDDATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::PROJECTENDDATE, $endDate, $comparison);
    }

    /**
     * Filter the query by a related ProjectActor object
     *
     * @param   ProjectActor|PropelObjectCollection $projectActor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectActor($projectActor, $comparison = null)
    {
        if ($projectActor instanceof ProjectActor) {
            return $this
                ->addUsingAlias(ProjectsPeer::PROJECTID, $projectActor->getProjectId(), $comparison);
        } elseif ($projectActor instanceof PropelObjectCollection) {
            return $this
                ->useProjectActorQuery()
                ->filterByPrimaryKeys($projectActor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectActor() only accepts arguments of type ProjectActor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectActor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function joinProjectActor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectActor');

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
            $this->addJoinObject($join, 'ProjectActor');
        }

        return $this;
    }

    /**
     * Use the ProjectActor relation ProjectActor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ProjectActorQuery A secondary query class using the current class as primary query
     */
    public function useProjectActorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectActor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectActor', '\PoGo\ProjectActorQuery');
    }

    /**
     * Filter the query by a related Files object
     *
     * @param   Files|PropelObjectCollection $files  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFiles($files, $comparison = null)
    {
        if ($files instanceof Files) {
            return $this
                ->addUsingAlias(ProjectsPeer::PROJECTID, $files->getProjectId(), $comparison);
        } elseif ($files instanceof PropelObjectCollection) {
            return $this
                ->useFilesQuery()
                ->filterByPrimaryKeys($files->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFiles() only accepts arguments of type Files or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Files relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function joinFiles($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Files');

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
            $this->addJoinObject($join, 'Files');
        }

        return $this;
    }

    /**
     * Use the Files relation Files object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\FilesQuery A secondary query class using the current class as primary query
     */
    public function useFilesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFiles($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Files', '\PoGo\FilesQuery');
    }

    /**
     * Filter the query by a related Milestones object
     *
     * @param   Milestones|PropelObjectCollection $milestones  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMilestones($milestones, $comparison = null)
    {
        if ($milestones instanceof Milestones) {
            return $this
                ->addUsingAlias(ProjectsPeer::PROJECTID, $milestones->getProjectId(), $comparison);
        } elseif ($milestones instanceof PropelObjectCollection) {
            return $this
                ->useMilestonesQuery()
                ->filterByPrimaryKeys($milestones->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMilestones() only accepts arguments of type Milestones or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Milestones relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function joinMilestones($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Milestones');

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
            $this->addJoinObject($join, 'Milestones');
        }

        return $this;
    }

    /**
     * Use the Milestones relation Milestones object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\MilestonesQuery A secondary query class using the current class as primary query
     */
    public function useMilestonesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMilestones($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Milestones', '\PoGo\MilestonesQuery');
    }

    /**
     * Filter the query by a related Tasks object
     *
     * @param   Tasks|PropelObjectCollection $tasks  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTasks($tasks, $comparison = null)
    {
        if ($tasks instanceof Tasks) {
            return $this
                ->addUsingAlias(ProjectsPeer::PROJECTID, $tasks->getProjectId(), $comparison);
        } elseif ($tasks instanceof PropelObjectCollection) {
            return $this
                ->useTasksQuery()
                ->filterByPrimaryKeys($tasks->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTasks() only accepts arguments of type Tasks or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Tasks relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function joinTasks($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Tasks');

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
            $this->addJoinObject($join, 'Tasks');
        }

        return $this;
    }

    /**
     * Use the Tasks relation Tasks object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\TasksQuery A secondary query class using the current class as primary query
     */
    public function useTasksQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTasks($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Tasks', '\PoGo\TasksQuery');
    }

    /**
     * Filter the query by a related Notes object
     *
     * @param   Notes|PropelObjectCollection $notes  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByNotes($notes, $comparison = null)
    {
        if ($notes instanceof Notes) {
            return $this
                ->addUsingAlias(ProjectsPeer::PROJECTID, $notes->getProjectId(), $comparison);
        } elseif ($notes instanceof PropelObjectCollection) {
            return $this
                ->useNotesQuery()
                ->filterByPrimaryKeys($notes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNotes() only accepts arguments of type Notes or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Notes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function joinNotes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Notes');

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
            $this->addJoinObject($join, 'Notes');
        }

        return $this;
    }

    /**
     * Use the Notes relation Notes object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\NotesQuery A secondary query class using the current class as primary query
     */
    public function useNotesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNotes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notes', '\PoGo\NotesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Projects $projects Object to remove from the list of results
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function prune($projects = null)
    {
        if ($projects) {
            $this->addUsingAlias(ProjectsPeer::PROJECTID, $projects->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
