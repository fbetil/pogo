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
use PoGo\ActorPeer;
use PoGo\ActorQuery;
use PoGo\File;
use PoGo\Note;
use PoGo\ProjectActor;
use PoGo\TaskActor;
use PoGo\User;

/**
 * Base class that represents a query for the 'actor' table.
 *
 *
 *
 * @method ActorQuery orderById($order = Criteria::ASC) Order by the actorid column
 * @method ActorQuery orderByFirstName($order = Criteria::ASC) Order by the actorfirstname column
 * @method ActorQuery orderByName($order = Criteria::ASC) Order by the actorname column
 * @method ActorQuery orderByOrganization($order = Criteria::ASC) Order by the actororganization column
 *
 * @method ActorQuery groupById() Group by the actorid column
 * @method ActorQuery groupByFirstName() Group by the actorfirstname column
 * @method ActorQuery groupByName() Group by the actorname column
 * @method ActorQuery groupByOrganization() Group by the actororganization column
 *
 * @method ActorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ActorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ActorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ActorQuery leftJoinProjectActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectActor relation
 * @method ActorQuery rightJoinProjectActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectActor relation
 * @method ActorQuery innerJoinProjectActor($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectActor relation
 *
 * @method ActorQuery leftJoinFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the File relation
 * @method ActorQuery rightJoinFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the File relation
 * @method ActorQuery innerJoinFile($relationAlias = null) Adds a INNER JOIN clause to the query using the File relation
 *
 * @method ActorQuery leftJoinTaskActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the TaskActor relation
 * @method ActorQuery rightJoinTaskActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TaskActor relation
 * @method ActorQuery innerJoinTaskActor($relationAlias = null) Adds a INNER JOIN clause to the query using the TaskActor relation
 *
 * @method ActorQuery leftJoinNote($relationAlias = null) Adds a LEFT JOIN clause to the query using the Note relation
 * @method ActorQuery rightJoinNote($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Note relation
 * @method ActorQuery innerJoinNote($relationAlias = null) Adds a INNER JOIN clause to the query using the Note relation
 *
 * @method ActorQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method ActorQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method ActorQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method Actor findOne(PropelPDO $con = null) Return the first Actor matching the query
 * @method Actor findOneOrCreate(PropelPDO $con = null) Return the first Actor matching the query, or a new Actor object populated from the query conditions when no match is found
 *
 * @method Actor findOneByFirstName(string $actorfirstname) Return the first Actor filtered by the actorfirstname column
 * @method Actor findOneByName(string $actorname) Return the first Actor filtered by the actorname column
 * @method Actor findOneByOrganization(string $actororganization) Return the first Actor filtered by the actororganization column
 *
 * @method array findById(int $actorid) Return Actor objects filtered by the actorid column
 * @method array findByFirstName(string $actorfirstname) Return Actor objects filtered by the actorfirstname column
 * @method array findByName(string $actorname) Return Actor objects filtered by the actorname column
 * @method array findByOrganization(string $actororganization) Return Actor objects filtered by the actororganization column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseActorQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseActorQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Actor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ActorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ActorQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ActorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ActorQuery) {
            return $criteria;
        }
        $query = new ActorQuery();
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
     * @return   Actor|Actor[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ActorPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ActorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Actor A model object, or null if the key is not found
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
     * @return                 Actor A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `actorid`, `actorfirstname`, `actorname`, `actororganization` FROM `actor` WHERE `actorid` = :p0';
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
            $obj = new Actor();
            $obj->hydrate($row);
            ActorPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Actor|Actor[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Actor[]|mixed the list of results, formatted by the current formatter
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
     * @return ActorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ActorPeer::ACTORID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ActorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ActorPeer::ACTORID, $keys, Criteria::IN);
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
     * @return ActorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ActorPeer::ACTORID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ActorPeer::ACTORID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActorPeer::ACTORID, $id, $comparison);
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
     * @return ActorQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ActorPeer::ACTORFIRSTNAME, $firstName, $comparison);
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
     * @return ActorQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ActorPeer::ACTORNAME, $name, $comparison);
    }

    /**
     * Filter the query on the actororganization column
     *
     * Example usage:
     * <code>
     * $query->filterByOrganization('fooValue');   // WHERE actororganization = 'fooValue'
     * $query->filterByOrganization('%fooValue%'); // WHERE actororganization LIKE '%fooValue%'
     * </code>
     *
     * @param     string $organization The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ActorQuery The current query, for fluid interface
     */
    public function filterByOrganization($organization = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($organization)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $organization)) {
                $organization = str_replace('*', '%', $organization);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActorPeer::ACTORORGANIZATION, $organization, $comparison);
    }

    /**
     * Filter the query by a related ProjectActor object
     *
     * @param   ProjectActor|PropelObjectCollection $projectActor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectActor($projectActor, $comparison = null)
    {
        if ($projectActor instanceof ProjectActor) {
            return $this
                ->addUsingAlias(ActorPeer::ACTORID, $projectActor->getActorId(), $comparison);
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
     * @return ActorQuery The current query, for fluid interface
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
     * Filter the query by a related File object
     *
     * @param   File|PropelObjectCollection $file  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFile($file, $comparison = null)
    {
        if ($file instanceof File) {
            return $this
                ->addUsingAlias(ActorPeer::ACTORID, $file->getActorId(), $comparison);
        } elseif ($file instanceof PropelObjectCollection) {
            return $this
                ->useFileQuery()
                ->filterByPrimaryKeys($file->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFile() only accepts arguments of type File or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the File relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ActorQuery The current query, for fluid interface
     */
    public function joinFile($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('File');

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
            $this->addJoinObject($join, 'File');
        }

        return $this;
    }

    /**
     * Use the File relation File object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\FileQuery A secondary query class using the current class as primary query
     */
    public function useFileQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'File', '\PoGo\FileQuery');
    }

    /**
     * Filter the query by a related TaskActor object
     *
     * @param   TaskActor|PropelObjectCollection $taskActor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTaskActor($taskActor, $comparison = null)
    {
        if ($taskActor instanceof TaskActor) {
            return $this
                ->addUsingAlias(ActorPeer::ACTORID, $taskActor->getActorId(), $comparison);
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
     * @return ActorQuery The current query, for fluid interface
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
     * Filter the query by a related Note object
     *
     * @param   Note|PropelObjectCollection $note  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByNote($note, $comparison = null)
    {
        if ($note instanceof Note) {
            return $this
                ->addUsingAlias(ActorPeer::ACTORID, $note->getActorId(), $comparison);
        } elseif ($note instanceof PropelObjectCollection) {
            return $this
                ->useNoteQuery()
                ->filterByPrimaryKeys($note->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNote() only accepts arguments of type Note or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Note relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ActorQuery The current query, for fluid interface
     */
    public function joinNote($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Note');

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
            $this->addJoinObject($join, 'Note');
        }

        return $this;
    }

    /**
     * Use the Note relation Note object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\NoteQuery A secondary query class using the current class as primary query
     */
    public function useNoteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNote($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Note', '\PoGo\NoteQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ActorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ActorPeer::ACTORID, $user->getActorId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            return $this
                ->useUserQuery()
                ->filterByPrimaryKeys($user->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ActorQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\PoGo\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Actor $actor Object to remove from the list of results
     *
     * @return ActorQuery The current query, for fluid interface
     */
    public function prune($actor = null)
    {
        if ($actor) {
            $this->addUsingAlias(ActorPeer::ACTORID, $actor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
