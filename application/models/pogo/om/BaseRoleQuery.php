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
use PoGo\ProfileRole;
use PoGo\Role;
use PoGo\RolePeer;
use PoGo\RoleQuery;

/**
 * Base class that represents a query for the 'role' table.
 *
 *
 *
 * @method RoleQuery orderById($order = Criteria::ASC) Order by the roleid column
 * @method RoleQuery orderByName($order = Criteria::ASC) Order by the rolename column
 * @method RoleQuery orderByComment($order = Criteria::ASC) Order by the rolecomment column
 *
 * @method RoleQuery groupById() Group by the roleid column
 * @method RoleQuery groupByName() Group by the rolename column
 * @method RoleQuery groupByComment() Group by the rolecomment column
 *
 * @method RoleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method RoleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method RoleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method RoleQuery leftJoinProfileRole($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProfileRole relation
 * @method RoleQuery rightJoinProfileRole($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProfileRole relation
 * @method RoleQuery innerJoinProfileRole($relationAlias = null) Adds a INNER JOIN clause to the query using the ProfileRole relation
 *
 * @method Role findOne(PropelPDO $con = null) Return the first Role matching the query
 * @method Role findOneOrCreate(PropelPDO $con = null) Return the first Role matching the query, or a new Role object populated from the query conditions when no match is found
 *
 * @method Role findOneByName(string $rolename) Return the first Role filtered by the rolename column
 * @method Role findOneByComment(string $rolecomment) Return the first Role filtered by the rolecomment column
 *
 * @method array findById(int $roleid) Return Role objects filtered by the roleid column
 * @method array findByName(string $rolename) Return Role objects filtered by the rolename column
 * @method array findByComment(string $rolecomment) Return Role objects filtered by the rolecomment column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseRoleQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseRoleQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Role', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new RoleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   RoleQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return RoleQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof RoleQuery) {
            return $criteria;
        }
        $query = new RoleQuery();
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
     * @return   Role|Role[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RolePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(RolePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Role A model object, or null if the key is not found
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
     * @return                 Role A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `roleid`, `rolename`, `rolecomment` FROM `role` WHERE `roleid` = :p0';
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
            $obj = new Role();
            $obj->hydrate($row);
            RolePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Role|Role[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Role[]|mixed the list of results, formatted by the current formatter
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
     * @return RoleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RolePeer::ROLEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return RoleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RolePeer::ROLEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the roleid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE roleid = 1234
     * $query->filterById(array(12, 34)); // WHERE roleid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE roleid >= 12
     * $query->filterById(array('max' => 12)); // WHERE roleid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RoleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RolePeer::ROLEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RolePeer::ROLEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RolePeer::ROLEID, $id, $comparison);
    }

    /**
     * Filter the query on the rolename column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE rolename = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE rolename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RoleQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RolePeer::ROLENAME, $name, $comparison);
    }

    /**
     * Filter the query on the rolecomment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE rolecomment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE rolecomment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RoleQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $comment)) {
                $comment = str_replace('*', '%', $comment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RolePeer::ROLECOMMENT, $comment, $comparison);
    }

    /**
     * Filter the query by a related ProfileRole object
     *
     * @param   ProfileRole|PropelObjectCollection $profileRole  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RoleQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProfileRole($profileRole, $comparison = null)
    {
        if ($profileRole instanceof ProfileRole) {
            return $this
                ->addUsingAlias(RolePeer::ROLEID, $profileRole->getRoleId(), $comparison);
        } elseif ($profileRole instanceof PropelObjectCollection) {
            return $this
                ->useProfileRoleQuery()
                ->filterByPrimaryKeys($profileRole->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProfileRole() only accepts arguments of type ProfileRole or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProfileRole relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return RoleQuery The current query, for fluid interface
     */
    public function joinProfileRole($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProfileRole');

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
            $this->addJoinObject($join, 'ProfileRole');
        }

        return $this;
    }

    /**
     * Use the ProfileRole relation ProfileRole object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ProfileRoleQuery A secondary query class using the current class as primary query
     */
    public function useProfileRoleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProfileRole($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProfileRole', '\PoGo\ProfileRoleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Role $role Object to remove from the list of results
     *
     * @return RoleQuery The current query, for fluid interface
     */
    public function prune($role = null)
    {
        if ($role) {
            $this->addUsingAlias(RolePeer::ROLEID, $role->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
