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
use PoGo\ActorsPeer;
use PoGo\ActorsQuery;
use PoGo\Files;
use PoGo\Notes;
use PoGo\ProjectActor;
use PoGo\TaskActor;
use PoGo\Users;

/**
 * Base class that represents a query for the 'actors' table.
 *
 *
 *
 * @method ActorsQuery orderById($order = Criteria::ASC) Order by the actorid column
 * @method ActorsQuery orderByFirstName($order = Criteria::ASC) Order by the actorfirstname column
 * @method ActorsQuery orderByName($order = Criteria::ASC) Order by the actorname column
 * @method ActorsQuery orderByEntity($order = Criteria::ASC) Order by the actorentity column
 *
 * @method ActorsQuery groupById() Group by the actorid column
 * @method ActorsQuery groupByFirstName() Group by the actorfirstname column
 * @method ActorsQuery groupByName() Group by the actorname column
 * @method ActorsQuery groupByEntity() Group by the actorentity column
 *
 * @method ActorsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ActorsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ActorsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ActorsQuery leftJoinProjectActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectActor relation
 * @method ActorsQuery rightJoinProjectActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectActor relation
 * @method ActorsQuery innerJoinProjectActor($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectActor relation
 *
 * @method ActorsQuery leftJoinFiles($relationAlias = null) Adds a LEFT JOIN clause to the query using the Files relation
 * @method ActorsQuery rightJoinFiles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Files relation
 * @method ActorsQuery innerJoinFiles($relationAlias = null) Adds a INNER JOIN clause to the query using the Files relation
 *
 * @method ActorsQuery leftJoinTaskActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the TaskActor relation
 * @method ActorsQuery rightJoinTaskActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TaskActor relation
 * @method ActorsQuery innerJoinTaskActor($relationAlias = null) Adds a INNER JOIN clause to the query using the TaskActor relation
 *
 * @method ActorsQuery leftJoinNotes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notes relation
 * @method ActorsQuery rightJoinNotes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notes relation
 * @method ActorsQuery innerJoinNotes($relationAlias = null) Adds a INNER JOIN clause to the query using the Notes relation
 *
 * @method ActorsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method ActorsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method ActorsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method Actors findOne(PropelPDO $con = null) Return the first Actors matching the query
 * @method Actors findOneOrCreate(PropelPDO $con = null) Return the first Actors matching the query, or a new Actors object populated from the query conditions when no match is found
 *
 * @method Actors findOneByFirstName(string $actorfirstname) Return the first Actors filtered by the actorfirstname column
 * @method Actors findOneByName(string $actorname) Return the first Actors filtered by the actorname column
 * @method Actors findOneByEntity(string $actorentity) Return the first Actors filtered by the actorentity column
 *
 * @method array findById(int $actorid) Return Actors objects filtered by the actorid column
 * @method array findByFirstName(string $actorfirstname) Return Actors objects filtered by the actorfirstname column
 * @method array findByName(string $actorname) Return Actors objects filtered by the actorname column
 * @method array findByEntity(string $actorentity) Return Actors objects filtered by the actorentity column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseActorsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseActorsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Actors', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ActorsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ActorsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ActorsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ActorsQuery) {
            return $criteria;
        }
        $query = new ActorsQuery();
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
     * @return   Actors|Actors[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ActorsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ActorsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Actors A model object, or null if the key is not found
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
     * @return                 Actors A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `actorid`, `actorfirstname`, `actorname`, `actorentity` FROM `actors` WHERE `actorid` = :p0';
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
            $obj = new Actors();
            $obj->hydrate($row);
            ActorsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Actors|Actors[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Actors[]|mixed the list of results, formatted by the current formatter
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
     * @return ActorsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ActorsPeer::ACTORID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ActorsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ActorsPeer::ACTORID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the actorid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE actorid = 1234
     * $query->filterById(array(12, 34)); // WHERE actorid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE actorid >= 12
     * $query->filterById(array('max' => 12)); // WHERE actorid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ActorsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ActorsPeer::ACTORID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ActorsPeer::ACTORID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActorsPeer::ACTORID, $id, $comparison);
    }

    /**
     * Filter the query on the actorfirstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE actorfirstname = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE actorfirstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ActorsQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstName)) {
                $firstName = str_replace('*', '%', $firstName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActorsPeer::ACTORFIRSTNAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the actorname column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE actorname = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE actorname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ActorsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ActorsPeer::ACTORNAME, $name, $comparison);
    }

    /**
     * Filter the query on the actorentity column
     *
     * Example usage:
     * <code>
     * $query->filterByEntity('fooValue');   // WHERE actorentity = 'fooValue'
     * $query->filterByEntity('%fooValue%'); // WHERE actorentity LIKE '%fooValue%'
     * </code>
     *
     * @param     string $entity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ActorsQuery The current query, for fluid interface
     */
    public function filterByEntity($entity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($entity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $entity)) {
                $entity = str_replace('*', '%', $entity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActorsPeer::ACTORENTITY, $entity, $comparison);
    }

    /**
     * Filter the query by a related ProjectActor object
     *
     * @param   ProjectActor|PropelObjectCollection $projectActor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectActor($projectActor, $comparison = null)
    {
        if ($projectActor instanceof ProjectActor) {
            return $this
                ->addUsingAlias(ActorsPeer::ACTORID, $projectActor->getActorId(), $comparison);
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
     * @return ActorsQuery The current query, for fluid interface
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
     * @return                 ActorsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFiles($files, $comparison = null)
    {
        if ($files instanceof Files) {
            return $this
                ->addUsingAlias(ActorsPeer::ACTORID, $files->getActorId(), $comparison);
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
     * @return ActorsQuery The current query, for fluid interface
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
     * Filter the query by a related TaskActor object
     *
     * @param   TaskActor|PropelObjectCollection $taskActor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTaskActor($taskActor, $comparison = null)
    {
        if ($taskActor instanceof TaskActor) {
            return $this
                ->addUsingAlias(ActorsPeer::ACTORID, $taskActor->getActorId(), $comparison);
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
     * @return ActorsQuery The current query, for fluid interface
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
     * Filter the query by a related Notes object
     *
     * @param   Notes|PropelObjectCollection $notes  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByNotes($notes, $comparison = null)
    {
        if ($notes instanceof Notes) {
            return $this
                ->addUsingAlias(ActorsPeer::ACTORID, $notes->getActorId(), $comparison);
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
     * @return ActorsQuery The current query, for fluid interface
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
     * Filter the query by a related Users object
     *
     * @param   Users|PropelObjectCollection $users  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof Users) {
            return $this
                ->addUsingAlias(ActorsPeer::ACTORID, $users->getActorId(), $comparison);
        } elseif ($users instanceof PropelObjectCollection) {
            return $this
                ->useUsersQuery()
                ->filterByPrimaryKeys($users->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type Users or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ActorsQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\PoGo\UsersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Actors $actors Object to remove from the list of results
     *
     * @return ActorsQuery The current query, for fluid interface
     */
    public function prune($actors = null)
    {
        if ($actors) {
            $this->addUsingAlias(ActorsPeer::ACTORID, $actors->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
