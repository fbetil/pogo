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
use PoGo\Milestones;
use PoGo\MilestonesPeer;
use PoGo\MilestonesQuery;
use PoGo\Projects;

/**
 * Base class that represents a query for the 'milestones' table.
 *
 *
 *
 * @method MilestonesQuery orderById($order = Criteria::ASC) Order by the milestoneid column
 * @method MilestonesQuery orderByName($order = Criteria::ASC) Order by the milestonename column
 * @method MilestonesQuery orderByDescription($order = Criteria::ASC) Order by the milestonedescription column
 * @method MilestonesQuery orderByDueDate($order = Criteria::ASC) Order by the milestoneduedate column
 * @method MilestonesQuery orderByProjectId($order = Criteria::ASC) Order by the projectid column
 *
 * @method MilestonesQuery groupById() Group by the milestoneid column
 * @method MilestonesQuery groupByName() Group by the milestonename column
 * @method MilestonesQuery groupByDescription() Group by the milestonedescription column
 * @method MilestonesQuery groupByDueDate() Group by the milestoneduedate column
 * @method MilestonesQuery groupByProjectId() Group by the projectid column
 *
 * @method MilestonesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MilestonesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MilestonesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MilestonesQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method MilestonesQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method MilestonesQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method Milestones findOne(PropelPDO $con = null) Return the first Milestones matching the query
 * @method Milestones findOneOrCreate(PropelPDO $con = null) Return the first Milestones matching the query, or a new Milestones object populated from the query conditions when no match is found
 *
 * @method Milestones findOneByName(string $milestonename) Return the first Milestones filtered by the milestonename column
 * @method Milestones findOneByDescription(string $milestonedescription) Return the first Milestones filtered by the milestonedescription column
 * @method Milestones findOneByDueDate(string $milestoneduedate) Return the first Milestones filtered by the milestoneduedate column
 * @method Milestones findOneByProjectId(int $projectid) Return the first Milestones filtered by the projectid column
 *
 * @method array findById(int $milestoneid) Return Milestones objects filtered by the milestoneid column
 * @method array findByName(string $milestonename) Return Milestones objects filtered by the milestonename column
 * @method array findByDescription(string $milestonedescription) Return Milestones objects filtered by the milestonedescription column
 * @method array findByDueDate(string $milestoneduedate) Return Milestones objects filtered by the milestoneduedate column
 * @method array findByProjectId(int $projectid) Return Milestones objects filtered by the projectid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseMilestonesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMilestonesQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Milestones', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MilestonesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MilestonesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MilestonesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MilestonesQuery) {
            return $criteria;
        }
        $query = new MilestonesQuery();
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
     * @return   Milestones|Milestones[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MilestonesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MilestonesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Milestones A model object, or null if the key is not found
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
     * @return                 Milestones A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `milestoneid`, `milestonename`, `milestonedescription`, `milestoneduedate`, `projectid` FROM `milestones` WHERE `milestoneid` = :p0';
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
            $obj = new Milestones();
            $obj->hydrate($row);
            MilestonesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Milestones|Milestones[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Milestones[]|mixed the list of results, formatted by the current formatter
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
     * @return MilestonesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MilestonesPeer::MILESTONEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MilestonesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MilestonesPeer::MILESTONEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the milestoneid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE milestoneid = 1234
     * $query->filterById(array(12, 34)); // WHERE milestoneid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE milestoneid >= 12
     * $query->filterById(array('max' => 12)); // WHERE milestoneid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MilestonesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MilestonesPeer::MILESTONEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MilestonesPeer::MILESTONEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MilestonesPeer::MILESTONEID, $id, $comparison);
    }

    /**
     * Filter the query on the milestonename column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE milestonename = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE milestonename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MilestonesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MilestonesPeer::MILESTONENAME, $name, $comparison);
    }

    /**
     * Filter the query on the milestonedescription column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE milestonedescription = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE milestonedescription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MilestonesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MilestonesPeer::MILESTONEDESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the milestoneduedate column
     *
     * Example usage:
     * <code>
     * $query->filterByDueDate('2011-03-14'); // WHERE milestoneduedate = '2011-03-14'
     * $query->filterByDueDate('now'); // WHERE milestoneduedate = '2011-03-14'
     * $query->filterByDueDate(array('max' => 'yesterday')); // WHERE milestoneduedate > '2011-03-13'
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
     * @return MilestonesQuery The current query, for fluid interface
     */
    public function filterByDueDate($dueDate = null, $comparison = null)
    {
        if (is_array($dueDate)) {
            $useMinMax = false;
            if (isset($dueDate['min'])) {
                $this->addUsingAlias(MilestonesPeer::MILESTONEDUEDATE, $dueDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dueDate['max'])) {
                $this->addUsingAlias(MilestonesPeer::MILESTONEDUEDATE, $dueDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MilestonesPeer::MILESTONEDUEDATE, $dueDate, $comparison);
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
     * @return MilestonesQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(MilestonesPeer::PROJECTID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(MilestonesPeer::PROJECTID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MilestonesPeer::PROJECTID, $projectId, $comparison);
    }

    /**
     * Filter the query by a related Projects object
     *
     * @param   Projects|PropelObjectCollection $projects The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MilestonesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($projects, $comparison = null)
    {
        if ($projects instanceof Projects) {
            return $this
                ->addUsingAlias(MilestonesPeer::PROJECTID, $projects->getId(), $comparison);
        } elseif ($projects instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MilestonesPeer::PROJECTID, $projects->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return MilestonesQuery The current query, for fluid interface
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
     * @param   Milestones $milestones Object to remove from the list of results
     *
     * @return MilestonesQuery The current query, for fluid interface
     */
    public function prune($milestones = null)
    {
        if ($milestones) {
            $this->addUsingAlias(MilestonesPeer::MILESTONEID, $milestones->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
