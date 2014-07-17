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
use PoGo\Note;
use PoGo\NotePeer;
use PoGo\NoteQuery;
use PoGo\Project;

/**
 * Base class that represents a query for the 'note' table.
 *
 *
 *
 * @method NoteQuery orderById($order = Criteria::ASC) Order by the noteid column
 * @method NoteQuery orderByName($order = Criteria::ASC) Order by the notename column
 * @method NoteQuery orderByContent($order = Criteria::ASC) Order by the notecontent column
 * @method NoteQuery orderByActorId($order = Criteria::ASC) Order by the actorid column
 * @method NoteQuery orderByPublishedAt($order = Criteria::ASC) Order by the notepublishedat column
 * @method NoteQuery orderByProjectId($order = Criteria::ASC) Order by the projectid column
 *
 * @method NoteQuery groupById() Group by the noteid column
 * @method NoteQuery groupByName() Group by the notename column
 * @method NoteQuery groupByContent() Group by the notecontent column
 * @method NoteQuery groupByActorId() Group by the actorid column
 * @method NoteQuery groupByPublishedAt() Group by the notepublishedat column
 * @method NoteQuery groupByProjectId() Group by the projectid column
 *
 * @method NoteQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method NoteQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method NoteQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method NoteQuery leftJoinActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Actor relation
 * @method NoteQuery rightJoinActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Actor relation
 * @method NoteQuery innerJoinActor($relationAlias = null) Adds a INNER JOIN clause to the query using the Actor relation
 *
 * @method NoteQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method NoteQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method NoteQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method Note findOne(PropelPDO $con = null) Return the first Note matching the query
 * @method Note findOneOrCreate(PropelPDO $con = null) Return the first Note matching the query, or a new Note object populated from the query conditions when no match is found
 *
 * @method Note findOneByName(string $notename) Return the first Note filtered by the notename column
 * @method Note findOneByContent(string $notecontent) Return the first Note filtered by the notecontent column
 * @method Note findOneByActorId(int $actorid) Return the first Note filtered by the actorid column
 * @method Note findOneByPublishedAt(string $notepublishedat) Return the first Note filtered by the notepublishedat column
 * @method Note findOneByProjectId(int $projectid) Return the first Note filtered by the projectid column
 *
 * @method array findById(int $noteid) Return Note objects filtered by the noteid column
 * @method array findByName(string $notename) Return Note objects filtered by the notename column
 * @method array findByContent(string $notecontent) Return Note objects filtered by the notecontent column
 * @method array findByActorId(int $actorid) Return Note objects filtered by the actorid column
 * @method array findByPublishedAt(string $notepublishedat) Return Note objects filtered by the notepublishedat column
 * @method array findByProjectId(int $projectid) Return Note objects filtered by the projectid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseNoteQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseNoteQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Note', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new NoteQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   NoteQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return NoteQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof NoteQuery) {
            return $criteria;
        }
        $query = new NoteQuery();
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
     * @return   Note|Note[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = NotePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(NotePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Note A model object, or null if the key is not found
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
     * @return                 Note A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `noteid`, `notename`, `notecontent`, `actorid`, `notepublishedat`, `projectid` FROM `note` WHERE `noteid` = :p0';
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
            $obj = new Note();
            $obj->hydrate($row);
            NotePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Note|Note[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Note[]|mixed the list of results, formatted by the current formatter
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
     * @return NoteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NotePeer::NOTEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return NoteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NotePeer::NOTEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the noteid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE noteid = 1234
     * $query->filterById(array(12, 34)); // WHERE noteid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE noteid >= 12
     * $query->filterById(array('max' => 12)); // WHERE noteid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return NoteQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(NotePeer::NOTEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(NotePeer::NOTEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotePeer::NOTEID, $id, $comparison);
    }

    /**
     * Filter the query on the notename column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE notename = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE notename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return NoteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(NotePeer::NOTENAME, $name, $comparison);
    }

    /**
     * Filter the query on the notecontent column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE notecontent = 'fooValue'
     * $query->filterByContent('%fooValue%'); // WHERE notecontent LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return NoteQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $content)) {
                $content = str_replace('*', '%', $content);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(NotePeer::NOTECONTENT, $content, $comparison);
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
     * @return NoteQuery The current query, for fluid interface
     */
    public function filterByActorId($actorId = null, $comparison = null)
    {
        if (is_array($actorId)) {
            $useMinMax = false;
            if (isset($actorId['min'])) {
                $this->addUsingAlias(NotePeer::ACTORID, $actorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($actorId['max'])) {
                $this->addUsingAlias(NotePeer::ACTORID, $actorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotePeer::ACTORID, $actorId, $comparison);
    }

    /**
     * Filter the query on the notepublishedat column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishedAt('2011-03-14'); // WHERE notepublishedat = '2011-03-14'
     * $query->filterByPublishedAt('now'); // WHERE notepublishedat = '2011-03-14'
     * $query->filterByPublishedAt(array('max' => 'yesterday')); // WHERE notepublishedat > '2011-03-13'
     * </code>
     *
     * @param     mixed $publishedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return NoteQuery The current query, for fluid interface
     */
    public function filterByPublishedAt($publishedAt = null, $comparison = null)
    {
        if (is_array($publishedAt)) {
            $useMinMax = false;
            if (isset($publishedAt['min'])) {
                $this->addUsingAlias(NotePeer::NOTEPUBLISHEDAT, $publishedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishedAt['max'])) {
                $this->addUsingAlias(NotePeer::NOTEPUBLISHEDAT, $publishedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotePeer::NOTEPUBLISHEDAT, $publishedAt, $comparison);
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
     * @return NoteQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(NotePeer::PROJECTID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(NotePeer::PROJECTID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotePeer::PROJECTID, $projectId, $comparison);
    }

    /**
     * Filter the query by a related Actor object
     *
     * @param   Actor|PropelObjectCollection $actor The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 NoteQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActor($actor, $comparison = null)
    {
        if ($actor instanceof Actor) {
            return $this
                ->addUsingAlias(NotePeer::ACTORID, $actor->getId(), $comparison);
        } elseif ($actor instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NotePeer::ACTORID, $actor->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return NoteQuery The current query, for fluid interface
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
     * @return                 NoteQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(NotePeer::PROJECTID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NotePeer::PROJECTID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return NoteQuery The current query, for fluid interface
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
     * @param   Note $note Object to remove from the list of results
     *
     * @return NoteQuery The current query, for fluid interface
     */
    public function prune($note = null)
    {
        if ($note) {
            $this->addUsingAlias(NotePeer::NOTEID, $note->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
