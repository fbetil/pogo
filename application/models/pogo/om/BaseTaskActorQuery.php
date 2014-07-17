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
use PoGo\Task;
use PoGo\TaskActor;
use PoGo\TaskActorPeer;
use PoGo\TaskActorQuery;

/**
 * Base class that represents a query for the 'task_actor' table.
 *
 *
 *
 * @method TaskActorQuery orderById($order = Criteria::ASC) Order by the taskactorid column
 * @method TaskActorQuery orderByTaskId($order = Criteria::ASC) Order by the taskid column
 * @method TaskActorQuery orderByActorId($order = Criteria::ASC) Order by the actorid column
 *
 * @method TaskActorQuery groupById() Group by the taskactorid column
 * @method TaskActorQuery groupByTaskId() Group by the taskid column
 * @method TaskActorQuery groupByActorId() Group by the actorid column
 *
 * @method TaskActorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TaskActorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TaskActorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TaskActorQuery leftJoinTask($relationAlias = null) Adds a LEFT JOIN clause to the query using the Task relation
 * @method TaskActorQuery rightJoinTask($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Task relation
 * @method TaskActorQuery innerJoinTask($relationAlias = null) Adds a INNER JOIN clause to the query using the Task relation
 *
 * @method TaskActorQuery leftJoinActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Actor relation
 * @method TaskActorQuery rightJoinActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Actor relation
 * @method TaskActorQuery innerJoinActor($relationAlias = null) Adds a INNER JOIN clause to the query using the Actor relation
 *
 * @method TaskActor findOne(PropelPDO $con = null) Return the first TaskActor matching the query
 * @method TaskActor findOneOrCreate(PropelPDO $con = null) Return the first TaskActor matching the query, or a new TaskActor object populated from the query conditions when no match is found
 *
 * @method TaskActor findOneByTaskId(int $taskid) Return the first TaskActor filtered by the taskid column
 * @method TaskActor findOneByActorId(int $actorid) Return the first TaskActor filtered by the actorid column
 *
 * @method array findById(int $taskactorid) Return TaskActor objects filtered by the taskactorid column
 * @method array findByTaskId(int $taskid) Return TaskActor objects filtered by the taskid column
 * @method array findByActorId(int $actorid) Return TaskActor objects filtered by the actorid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseTaskActorQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTaskActorQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\TaskActor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TaskActorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TaskActorQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TaskActorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TaskActorQuery) {
            return $criteria;
        }
        $query = new TaskActorQuery();
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
     * @return   TaskActor|TaskActor[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TaskActorPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TaskActorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 TaskActor A model object, or null if the key is not found
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
     * @return                 TaskActor A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `taskactorid`, `taskid`, `actorid` FROM `task_actor` WHERE `taskactorid` = :p0';
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
            $obj = new TaskActor();
            $obj->hydrate($row);
            TaskActorPeer::addInstanceToPool($obj, (string) $key);
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
     * @return TaskActor|TaskActor[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|TaskActor[]|mixed the list of results, formatted by the current formatter
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
     * @return TaskActorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TaskActorPeer::TASKACTORID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TaskActorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TaskActorPeer::TASKACTORID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the taskactorid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE taskactorid = 1234
     * $query->filterById(array(12, 34)); // WHERE taskactorid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE taskactorid >= 12
     * $query->filterById(array('max' => 12)); // WHERE taskactorid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TaskActorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TaskActorPeer::TASKACTORID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TaskActorPeer::TASKACTORID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskActorPeer::TASKACTORID, $id, $comparison);
    }

    /**
     * Filter the query on the taskid column
     *
     * Example usage:
     * <code>
     * $query->filterByTaskId(1234); // WHERE taskid = 1234
     * $query->filterByTaskId(array(12, 34)); // WHERE taskid IN (12, 34)
     * $query->filterByTaskId(array('min' => 12)); // WHERE taskid >= 12
     * $query->filterByTaskId(array('max' => 12)); // WHERE taskid <= 12
     * </code>
     *
     * @see       filterByTask()
     *
     * @param     mixed $taskId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TaskActorQuery The current query, for fluid interface
     */
    public function filterByTaskId($taskId = null, $comparison = null)
    {
        if (is_array($taskId)) {
            $useMinMax = false;
            if (isset($taskId['min'])) {
                $this->addUsingAlias(TaskActorPeer::TASKID, $taskId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($taskId['max'])) {
                $this->addUsingAlias(TaskActorPeer::TASKID, $taskId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskActorPeer::TASKID, $taskId, $comparison);
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
     * @return TaskActorQuery The current query, for fluid interface
     */
    public function filterByActorId($actorId = null, $comparison = null)
    {
        if (is_array($actorId)) {
            $useMinMax = false;
            if (isset($actorId['min'])) {
                $this->addUsingAlias(TaskActorPeer::ACTORID, $actorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($actorId['max'])) {
                $this->addUsingAlias(TaskActorPeer::ACTORID, $actorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskActorPeer::ACTORID, $actorId, $comparison);
    }

    /**
     * Filter the query by a related Task object
     *
     * @param   Task|PropelObjectCollection $task The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TaskActorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTask($task, $comparison = null)
    {
        if ($task instanceof Task) {
            return $this
                ->addUsingAlias(TaskActorPeer::TASKID, $task->getId(), $comparison);
        } elseif ($task instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TaskActorPeer::TASKID, $task->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTask() only accepts arguments of type Task or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Task relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TaskActorQuery The current query, for fluid interface
     */
    public function joinTask($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Task');

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
            $this->addJoinObject($join, 'Task');
        }

        return $this;
    }

    /**
     * Use the Task relation Task object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\TaskQuery A secondary query class using the current class as primary query
     */
    public function useTaskQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTask($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Task', '\PoGo\TaskQuery');
    }

    /**
     * Filter the query by a related Actor object
     *
     * @param   Actor|PropelObjectCollection $actor The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TaskActorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActor($actor, $comparison = null)
    {
        if ($actor instanceof Actor) {
            return $this
                ->addUsingAlias(TaskActorPeer::ACTORID, $actor->getId(), $comparison);
        } elseif ($actor instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TaskActorPeer::ACTORID, $actor->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return TaskActorQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   TaskActor $taskActor Object to remove from the list of results
     *
     * @return TaskActorQuery The current query, for fluid interface
     */
    public function prune($taskActor = null)
    {
        if ($taskActor) {
            $this->addUsingAlias(TaskActorPeer::TASKACTORID, $taskActor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
