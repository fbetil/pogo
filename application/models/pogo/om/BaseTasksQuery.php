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
use PoGo\Projects;
use PoGo\TaskActor;
use PoGo\Tasks;
use PoGo\TasksPeer;
use PoGo\TasksQuery;

/**
 * Base class that represents a query for the 'tasks' table.
 *
 *
 *
 * @method TasksQuery orderById($order = Criteria::ASC) Order by the taskid column
 * @method TasksQuery orderByName($order = Criteria::ASC) Order by the taskname column
 * @method TasksQuery orderByDescription($order = Criteria::ASC) Order by the taskdescription column
 * @method TasksQuery orderByStartDate($order = Criteria::ASC) Order by the taskstartdate column
 * @method TasksQuery orderByDueDate($order = Criteria::ASC) Order by the taskduedate column
 * @method TasksQuery orderByProgress($order = Criteria::ASC) Order by the taskprogress column
 * @method TasksQuery orderByProjectId($order = Criteria::ASC) Order by the projectid column
 *
 * @method TasksQuery groupById() Group by the taskid column
 * @method TasksQuery groupByName() Group by the taskname column
 * @method TasksQuery groupByDescription() Group by the taskdescription column
 * @method TasksQuery groupByStartDate() Group by the taskstartdate column
 * @method TasksQuery groupByDueDate() Group by the taskduedate column
 * @method TasksQuery groupByProgress() Group by the taskprogress column
 * @method TasksQuery groupByProjectId() Group by the projectid column
 *
 * @method TasksQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TasksQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TasksQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TasksQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method TasksQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method TasksQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method TasksQuery leftJoinTaskActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the TaskActor relation
 * @method TasksQuery rightJoinTaskActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TaskActor relation
 * @method TasksQuery innerJoinTaskActor($relationAlias = null) Adds a INNER JOIN clause to the query using the TaskActor relation
 *
 * @method Tasks findOne(PropelPDO $con = null) Return the first Tasks matching the query
 * @method Tasks findOneOrCreate(PropelPDO $con = null) Return the first Tasks matching the query, or a new Tasks object populated from the query conditions when no match is found
 *
 * @method Tasks findOneByName(string $taskname) Return the first Tasks filtered by the taskname column
 * @method Tasks findOneByDescription(string $taskdescription) Return the first Tasks filtered by the taskdescription column
 * @method Tasks findOneByStartDate(string $taskstartdate) Return the first Tasks filtered by the taskstartdate column
 * @method Tasks findOneByDueDate(string $taskduedate) Return the first Tasks filtered by the taskduedate column
 * @method Tasks findOneByProgress(int $taskprogress) Return the first Tasks filtered by the taskprogress column
 * @method Tasks findOneByProjectId(int $projectid) Return the first Tasks filtered by the projectid column
 *
 * @method array findById(int $taskid) Return Tasks objects filtered by the taskid column
 * @method array findByName(string $taskname) Return Tasks objects filtered by the taskname column
 * @method array findByDescription(string $taskdescription) Return Tasks objects filtered by the taskdescription column
 * @method array findByStartDate(string $taskstartdate) Return Tasks objects filtered by the taskstartdate column
 * @method array findByDueDate(string $taskduedate) Return Tasks objects filtered by the taskduedate column
 * @method array findByProgress(int $taskprogress) Return Tasks objects filtered by the taskprogress column
 * @method array findByProjectId(int $projectid) Return Tasks objects filtered by the projectid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseTasksQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTasksQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Tasks', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TasksQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TasksQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TasksQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TasksQuery) {
            return $criteria;
        }
        $query = new TasksQuery();
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
     * @return   Tasks|Tasks[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TasksPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TasksPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Tasks A model object, or null if the key is not found
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
     * @return                 Tasks A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `taskid`, `taskname`, `taskdescription`, `taskstartdate`, `taskduedate`, `taskprogress`, `projectid` FROM `tasks` WHERE `taskid` = :p0';
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
            $obj = new Tasks();
            $obj->hydrate($row);
            TasksPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Tasks|Tasks[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Tasks[]|mixed the list of results, formatted by the current formatter
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
     * @return TasksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TasksPeer::TASKID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TasksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TasksPeer::TASKID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the taskid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE taskid = 1234
     * $query->filterById(array(12, 34)); // WHERE taskid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE taskid >= 12
     * $query->filterById(array('max' => 12)); // WHERE taskid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TasksQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TasksPeer::TASKID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TasksPeer::TASKID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TasksPeer::TASKID, $id, $comparison);
    }

    /**
     * Filter the query on the taskname column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE taskname = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE taskname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TasksQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TasksPeer::TASKNAME, $name, $comparison);
    }

    /**
     * Filter the query on the taskdescription column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE taskdescription = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE taskdescription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TasksQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TasksPeer::TASKDESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the taskstartdate column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE taskstartdate = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE taskstartdate = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE taskstartdate > '2011-03-13'
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
     * @return TasksQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(TasksPeer::TASKSTARTDATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(TasksPeer::TASKSTARTDATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TasksPeer::TASKSTARTDATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the taskduedate column
     *
     * Example usage:
     * <code>
     * $query->filterByDueDate('2011-03-14'); // WHERE taskduedate = '2011-03-14'
     * $query->filterByDueDate('now'); // WHERE taskduedate = '2011-03-14'
     * $query->filterByDueDate(array('max' => 'yesterday')); // WHERE taskduedate > '2011-03-13'
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
     * @return TasksQuery The current query, for fluid interface
     */
    public function filterByDueDate($dueDate = null, $comparison = null)
    {
        if (is_array($dueDate)) {
            $useMinMax = false;
            if (isset($dueDate['min'])) {
                $this->addUsingAlias(TasksPeer::TASKDUEDATE, $dueDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dueDate['max'])) {
                $this->addUsingAlias(TasksPeer::TASKDUEDATE, $dueDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TasksPeer::TASKDUEDATE, $dueDate, $comparison);
    }

    /**
     * Filter the query on the taskprogress column
     *
     * Example usage:
     * <code>
     * $query->filterByProgress(1234); // WHERE taskprogress = 1234
     * $query->filterByProgress(array(12, 34)); // WHERE taskprogress IN (12, 34)
     * $query->filterByProgress(array('min' => 12)); // WHERE taskprogress >= 12
     * $query->filterByProgress(array('max' => 12)); // WHERE taskprogress <= 12
     * </code>
     *
     * @param     mixed $progress The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TasksQuery The current query, for fluid interface
     */
    public function filterByProgress($progress = null, $comparison = null)
    {
        if (is_array($progress)) {
            $useMinMax = false;
            if (isset($progress['min'])) {
                $this->addUsingAlias(TasksPeer::TASKPROGRESS, $progress['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($progress['max'])) {
                $this->addUsingAlias(TasksPeer::TASKPROGRESS, $progress['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TasksPeer::TASKPROGRESS, $progress, $comparison);
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
     * @return TasksQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(TasksPeer::PROJECTID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(TasksPeer::PROJECTID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TasksPeer::PROJECTID, $projectId, $comparison);
    }

    /**
     * Filter the query by a related Projects object
     *
     * @param   Projects|PropelObjectCollection $projects The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TasksQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($projects, $comparison = null)
    {
        if ($projects instanceof Projects) {
            return $this
                ->addUsingAlias(TasksPeer::PROJECTID, $projects->getId(), $comparison);
        } elseif ($projects instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TasksPeer::PROJECTID, $projects->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return TasksQuery The current query, for fluid interface
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
     * Filter the query by a related TaskActor object
     *
     * @param   TaskActor|PropelObjectCollection $taskActor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TasksQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTaskActor($taskActor, $comparison = null)
    {
        if ($taskActor instanceof TaskActor) {
            return $this
                ->addUsingAlias(TasksPeer::TASKID, $taskActor->getTaskId(), $comparison);
        } elseif ($taskActor instanceof PropelObjectCollection) {
            return $this
                ->useTaskActorQuery()
                ->filterByPrimaryKeys($taskActor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTaskActor() only accepts arguments of type TaskActor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TaskActor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TasksQuery The current query, for fluid interface
     */
    public function joinTaskActor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TaskActor');

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
            $this->addJoinObject($join, 'TaskActor');
        }

        return $this;
    }

    /**
     * Use the TaskActor relation TaskActor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\TaskActorQuery A secondary query class using the current class as primary query
     */
    public function useTaskActorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTaskActor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TaskActor', '\PoGo\TaskActorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Tasks $tasks Object to remove from the list of results
     *
     * @return TasksQuery The current query, for fluid interface
     */
    public function prune($tasks = null)
    {
        if ($tasks) {
            $this->addUsingAlias(TasksPeer::TASKID, $tasks->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
