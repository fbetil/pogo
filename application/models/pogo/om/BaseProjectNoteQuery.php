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
use PoGo\Notes;
use PoGo\ProjectNote;
use PoGo\ProjectNotePeer;
use PoGo\ProjectNoteQuery;
use PoGo\Projects;

/**
 * Base class that represents a query for the 'project_note' table.
 *
 *
 *
 * @method ProjectNoteQuery orderById($order = Criteria::ASC) Order by the projectnoteid column
 * @method ProjectNoteQuery orderByProjectId($order = Criteria::ASC) Order by the projectid column
 * @method ProjectNoteQuery orderByNoteId($order = Criteria::ASC) Order by the noteid column
 *
 * @method ProjectNoteQuery groupById() Group by the projectnoteid column
 * @method ProjectNoteQuery groupByProjectId() Group by the projectid column
 * @method ProjectNoteQuery groupByNoteId() Group by the noteid column
 *
 * @method ProjectNoteQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectNoteQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectNoteQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectNoteQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method ProjectNoteQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method ProjectNoteQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method ProjectNoteQuery leftJoinNote($relationAlias = null) Adds a LEFT JOIN clause to the query using the Note relation
 * @method ProjectNoteQuery rightJoinNote($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Note relation
 * @method ProjectNoteQuery innerJoinNote($relationAlias = null) Adds a INNER JOIN clause to the query using the Note relation
 *
 * @method ProjectNote findOne(PropelPDO $con = null) Return the first ProjectNote matching the query
 * @method ProjectNote findOneOrCreate(PropelPDO $con = null) Return the first ProjectNote matching the query, or a new ProjectNote object populated from the query conditions when no match is found
 *
 * @method ProjectNote findOneByProjectId(int $projectid) Return the first ProjectNote filtered by the projectid column
 * @method ProjectNote findOneByNoteId(int $noteid) Return the first ProjectNote filtered by the noteid column
 *
 * @method array findById(int $projectnoteid) Return ProjectNote objects filtered by the projectnoteid column
 * @method array findByProjectId(int $projectid) Return ProjectNote objects filtered by the projectid column
 * @method array findByNoteId(int $noteid) Return ProjectNote objects filtered by the noteid column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseProjectNoteQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectNoteQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\ProjectNote', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectNoteQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectNoteQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectNoteQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectNoteQuery) {
            return $criteria;
        }
        $query = new ProjectNoteQuery();
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
     * @return   ProjectNote|ProjectNote[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectNotePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectNotePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ProjectNote A model object, or null if the key is not found
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
     * @return                 ProjectNote A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `projectnoteid`, `projectid`, `noteid` FROM `project_note` WHERE `projectnoteid` = :p0';
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
            $obj = new ProjectNote();
            $obj->hydrate($row);
            ProjectNotePeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProjectNote|ProjectNote[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProjectNote[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectNoteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectNotePeer::PROJECTNOTEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectNoteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectNotePeer::PROJECTNOTEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the projectnoteid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE projectnoteid = 1234
     * $query->filterById(array(12, 34)); // WHERE projectnoteid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE projectnoteid >= 12
     * $query->filterById(array('max' => 12)); // WHERE projectnoteid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectNoteQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectNotePeer::PROJECTNOTEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectNotePeer::PROJECTNOTEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectNotePeer::PROJECTNOTEID, $id, $comparison);
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
     * @return ProjectNoteQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(ProjectNotePeer::PROJECTID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(ProjectNotePeer::PROJECTID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectNotePeer::PROJECTID, $projectId, $comparison);
    }

    /**
     * Filter the query on the noteid column
     *
     * Example usage:
     * <code>
     * $query->filterByNoteId(1234); // WHERE noteid = 1234
     * $query->filterByNoteId(array(12, 34)); // WHERE noteid IN (12, 34)
     * $query->filterByNoteId(array('min' => 12)); // WHERE noteid >= 12
     * $query->filterByNoteId(array('max' => 12)); // WHERE noteid <= 12
     * </code>
     *
     * @see       filterByNote()
     *
     * @param     mixed $noteId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectNoteQuery The current query, for fluid interface
     */
    public function filterByNoteId($noteId = null, $comparison = null)
    {
        if (is_array($noteId)) {
            $useMinMax = false;
            if (isset($noteId['min'])) {
                $this->addUsingAlias(ProjectNotePeer::NOTEID, $noteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($noteId['max'])) {
                $this->addUsingAlias(ProjectNotePeer::NOTEID, $noteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectNotePeer::NOTEID, $noteId, $comparison);
    }

    /**
     * Filter the query by a related Projects object
     *
     * @param   Projects|PropelObjectCollection $projects The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectNoteQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($projects, $comparison = null)
    {
        if ($projects instanceof Projects) {
            return $this
                ->addUsingAlias(ProjectNotePeer::PROJECTID, $projects->getId(), $comparison);
        } elseif ($projects instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectNotePeer::PROJECTID, $projects->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ProjectNoteQuery The current query, for fluid interface
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
     * Filter the query by a related Notes object
     *
     * @param   Notes|PropelObjectCollection $notes The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectNoteQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByNote($notes, $comparison = null)
    {
        if ($notes instanceof Notes) {
            return $this
                ->addUsingAlias(ProjectNotePeer::NOTEID, $notes->getId(), $comparison);
        } elseif ($notes instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectNotePeer::NOTEID, $notes->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByNote() only accepts arguments of type Notes or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Note relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectNoteQuery The current query, for fluid interface
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
     * Use the Note relation Notes object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\NotesQuery A secondary query class using the current class as primary query
     */
    public function useNoteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNote($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Note', '\PoGo\NotesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ProjectNote $projectNote Object to remove from the list of results
     *
     * @return ProjectNoteQuery The current query, for fluid interface
     */
    public function prune($projectNote = null)
    {
        if ($projectNote) {
            $this->addUsingAlias(ProjectNotePeer::PROJECTNOTEID, $projectNote->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
