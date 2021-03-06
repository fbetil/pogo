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
use PoGo\ProjectActor;
use PoGo\TypeActorsRoles;
use PoGo\TypeActorsRolesPeer;
use PoGo\TypeActorsRolesQuery;

/**
 * Base class that represents a query for the 'typeactorsroles' table.
 *
 *
 *
 * @method TypeActorsRolesQuery orderById($order = Criteria::ASC) Order by the typeactorroleid column
 * @method TypeActorsRolesQuery orderByCode($order = Criteria::ASC) Order by the typeactorrolecode column
 * @method TypeActorsRolesQuery orderByLabel($order = Criteria::ASC) Order by the typeactorrolelabel column
 *
 * @method TypeActorsRolesQuery groupById() Group by the typeactorroleid column
 * @method TypeActorsRolesQuery groupByCode() Group by the typeactorrolecode column
 * @method TypeActorsRolesQuery groupByLabel() Group by the typeactorrolelabel column
 *
 * @method TypeActorsRolesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TypeActorsRolesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TypeActorsRolesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TypeActorsRolesQuery leftJoinProjectActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectActor relation
 * @method TypeActorsRolesQuery rightJoinProjectActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectActor relation
 * @method TypeActorsRolesQuery innerJoinProjectActor($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectActor relation
 *
 * @method TypeActorsRoles findOne(PropelPDO $con = null) Return the first TypeActorsRoles matching the query
 * @method TypeActorsRoles findOneOrCreate(PropelPDO $con = null) Return the first TypeActorsRoles matching the query, or a new TypeActorsRoles object populated from the query conditions when no match is found
 *
 * @method TypeActorsRoles findOneByCode(string $typeactorrolecode) Return the first TypeActorsRoles filtered by the typeactorrolecode column
 * @method TypeActorsRoles findOneByLabel(string $typeactorrolelabel) Return the first TypeActorsRoles filtered by the typeactorrolelabel column
 *
 * @method array findById(int $typeactorroleid) Return TypeActorsRoles objects filtered by the typeactorroleid column
 * @method array findByCode(string $typeactorrolecode) Return TypeActorsRoles objects filtered by the typeactorrolecode column
 * @method array findByLabel(string $typeactorrolelabel) Return TypeActorsRoles objects filtered by the typeactorrolelabel column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseTypeActorsRolesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTypeActorsRolesQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\TypeActorsRoles', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TypeActorsRolesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TypeActorsRolesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TypeActorsRolesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TypeActorsRolesQuery) {
            return $criteria;
        }
        $query = new TypeActorsRolesQuery();
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
     * @return   TypeActorsRoles|TypeActorsRoles[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TypeActorsRolesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TypeActorsRolesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 TypeActorsRoles A model object, or null if the key is not found
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
     * @return                 TypeActorsRoles A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `typeactorroleid`, `typeactorrolecode`, `typeactorrolelabel` FROM `typeactorsroles` WHERE `typeactorroleid` = :p0';
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
            $obj = new TypeActorsRoles();
            $obj->hydrate($row);
            TypeActorsRolesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return TypeActorsRoles|TypeActorsRoles[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|TypeActorsRoles[]|mixed the list of results, formatted by the current formatter
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
     * @return TypeActorsRolesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TypeActorsRolesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the typeactorroleid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE typeactorroleid = 1234
     * $query->filterById(array(12, 34)); // WHERE typeactorroleid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE typeactorroleid >= 12
     * $query->filterById(array('max' => 12)); // WHERE typeactorroleid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TypeActorsRolesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLEID, $id, $comparison);
    }

    /**
     * Filter the query on the typeactorrolecode column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE typeactorrolecode = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE typeactorrolecode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TypeActorsRolesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLECODE, $code, $comparison);
    }

    /**
     * Filter the query on the typeactorrolelabel column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE typeactorrolelabel = 'fooValue'
     * $query->filterByLabel('%fooValue%'); // WHERE typeactorrolelabel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TypeActorsRolesQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $label)) {
                $label = str_replace('*', '%', $label);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLELABEL, $label, $comparison);
    }

    /**
     * Filter the query by a related ProjectActor object
     *
     * @param   ProjectActor|PropelObjectCollection $projectActor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TypeActorsRolesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectActor($projectActor, $comparison = null)
    {
        if ($projectActor instanceof ProjectActor) {
            return $this
                ->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLEID, $projectActor->getTypeActorRoleId(), $comparison);
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
     * @return TypeActorsRolesQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   TypeActorsRoles $typeActorsRoles Object to remove from the list of results
     *
     * @return TypeActorsRolesQuery The current query, for fluid interface
     */
    public function prune($typeActorsRoles = null)
    {
        if ($typeActorsRoles) {
            $this->addUsingAlias(TypeActorsRolesPeer::TYPEACTORROLEID, $typeActorsRoles->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
