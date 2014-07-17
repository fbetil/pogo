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
use PoGo\ProjectMilestone;
use PoGo\ProjectMilestonePeer;
use PoGo\ProjectMilestoneQuery;
use PoGo\Projects;

/**
 * Base class that represents a query for the 'project_milestone' table.
 *
 *
 *
 * @method ProjectMilestoneQuery orderById($order = Criteria::ASC) Order by the projectmilestoneid column
 * @method ProjectMilestoneQuery orderByProjectId($order = Criteria::ASC) Order by the projectid column
 * @method ProjectMilestoneQuery orderByMilestoneId($order = Criteria::ASC) Order by the milestoneid column
 *
 * @method ProjectMilestoneQuery groupById() Group by the projectmilestoneid column
 * @method ProjectMilestoneQuery groupByProjectId() Group by the projectid column
 * @method ProjectMilestoneQuery groupByMilestoneId() Group by the milestoneid column
 *
 * @method ProjectMilestoneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectMilestoneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectMilestoneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectMilestoneQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method ProjectMilestoneQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method ProjectMilestoneQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method ProjectMilestoneQuery leftJoinMilestone($relationAlias = null) Adds a LEFT JOIN clause to the query using the Milestone relation
 * @method ProjectMilestoneQuery rightJoinMilestone($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Milestone relation
 * @method ProjectMilestoneQuery innerJoinMilestone($relationAlias = null) Adds a INNER JOIN clause to the query using the Milestone relation
 *
 * @method ProjectMilestone findOne(PropelPDO $con = null) Return the first ProjectMilestone matching the query
 * @method ProjectMilestone findOneOrCreate(PropelPDO $con = null) Return the first ProjectMilestone matching the query, or a new ProjectMilestone object populated from the query conditions when no match is found
 *
 * @method ProjectMilestone findOneByProjectId(int $projectid) Return the first ProjectMilestone filtered by the projectid column
 * @method ProjectMilestone findOneByMilestoneId(int $milestoneid) Return the first ProjectMilestone filtered by the milestoneid column
 *
 * @method array findById(int $projectmilestoneid) Return ProjectMilestone objects filtered by the projectmilestoneid column
 * @method array findByProjectId(int $projectid) Return ProjectMilestone objects filtered by the projectid column
 * @method array findByMilestoneId(int $milestoneid) Return ProjectMilestone objects filtered by the milestoneid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseProjectMilestoneQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectMilestoneQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\ProjectMilestone', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectMilestoneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectMilestoneQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectMilestoneQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectMilestoneQuery) {
            return $criteria;
        }
        $query = new ProjectMilestoneQuery();
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
     * @return   ProjectMilestone|ProjectMilestone[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectMilestonePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectMilestonePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ProjectMilestone A model object, or null if the key is not found
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
     * @return                 ProjectMilestone A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `projectmilestoneid`, `projectid`, `milestoneid` FROM `project_milestone` WHERE `projectmilestoneid` = :p0';
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
            $obj = new ProjectMilestone();
            $obj->hydrate($row);
            ProjectMilestonePeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProjectMilestone|ProjectMilestone[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProjectMilestone[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectMilestoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectMilestonePeer::PROJECTMILESTONEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectMilestoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectMilestonePeer::PROJECTMILESTONEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the projectmilestoneid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE projectmilestoneid = 1234
     * $query->filterById(array(12, 34)); // WHERE projectmilestoneid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE projectmilestoneid >= 12
     * $query->filterById(array('max' => 12)); // WHERE projectmilestoneid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectMilestoneQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectMilestonePeer::PROJECTMILESTONEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectMilestonePeer::PROJECTMILESTONEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectMilestonePeer::PROJECTMILESTONEID, $id, $comparison);
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
     * @return ProjectMilestoneQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(ProjectMilestonePeer::PROJECTID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(ProjectMilestonePeer::PROJECTID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectMilestonePeer::PROJECTID, $projectId, $comparison);
    }

    /**
     * Filter the query on the milestoneid column
     *
     * Example usage:
     * <code>
     * $query->filterByMilestoneId(1234); // WHERE milestoneid = 1234
     * $query->filterByMilestoneId(array(12, 34)); // WHERE milestoneid IN (12, 34)
     * $query->filterByMilestoneId(array('min' => 12)); // WHERE milestoneid >= 12
     * $query->filterByMilestoneId(array('max' => 12)); // WHERE milestoneid <= 12
     * </code>
     *
     * @see       filterByMilestone()
     *
     * @param     mixed $milestoneId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectMilestoneQuery The current query, for fluid interface
     */
    public function filterByMilestoneId($milestoneId = null, $comparison = null)
    {
        if (is_array($milestoneId)) {
            $useMinMax = false;
            if (isset($milestoneId['min'])) {
                $this->addUsingAlias(ProjectMilestonePeer::MILESTONEID, $milestoneId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($milestoneId['max'])) {
                $this->addUsingAlias(ProjectMilestonePeer::MILESTONEID, $milestoneId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectMilestonePeer::MILESTONEID, $milestoneId, $comparison);
    }

    /**
     * Filter the query by a related Projects object
     *
     * @param   Projects|PropelObjectCollection $projects The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectMilestoneQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($projects, $comparison = null)
    {
        if ($projects instanceof Projects) {
            return $this
                ->addUsingAlias(ProjectMilestonePeer::PROJECTID, $projects->getId(), $comparison);
        } elseif ($projects instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectMilestonePeer::PROJECTID, $projects->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ProjectMilestoneQuery The current query, for fluid interface
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
     * Filter the query by a related Milestones object
     *
     * @param   Milestones|PropelObjectCollection $milestones The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectMilestoneQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMilestone($milestones, $comparison = null)
    {
        if ($milestones instanceof Milestones) {
            return $this
                ->addUsingAlias(ProjectMilestonePeer::MILESTONEID, $milestones->getId(), $comparison);
        } elseif ($milestones instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectMilestonePeer::MILESTONEID, $milestones->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMilestone() only accepts arguments of type Milestones or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Milestone relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectMilestoneQuery The current query, for fluid interface
     */
    public function joinMilestone($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Milestone');

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
            $this->addJoinObject($join, 'Milestone');
        }

        return $this;
    }

    /**
     * Use the Milestone relation Milestones object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\MilestonesQuery A secondary query class using the current class as primary query
     */
    public function useMilestoneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMilestone($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Milestone', '\PoGo\MilestonesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ProjectMilestone $projectMilestone Object to remove from the list of results
     *
     * @return ProjectMilestoneQuery The current query, for fluid interface
     */
    public function prune($projectMilestone = null)
    {
        if ($projectMilestone) {
            $this->addUsingAlias(ProjectMilestonePeer::PROJECTMILESTONEID, $projectMilestone->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
