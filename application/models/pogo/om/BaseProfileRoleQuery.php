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
use PoGo\Profile;
use PoGo\ProfileRole;
use PoGo\ProfileRolePeer;
use PoGo\ProfileRoleQuery;
use PoGo\Role;

/**
 * Base class that represents a query for the 'profile_role' table.
 *
 *
 *
 * @method ProfileRoleQuery orderById($order = Criteria::ASC) Order by the profileroleid column
 * @method ProfileRoleQuery orderByProfileId($order = Criteria::ASC) Order by the profileid column
 * @method ProfileRoleQuery orderByRoleId($order = Criteria::ASC) Order by the roleid column
 * @method ProfileRoleQuery orderByRestrictions($order = Criteria::ASC) Order by the profilerolerestrictions column
 *
 * @method ProfileRoleQuery groupById() Group by the profileroleid column
 * @method ProfileRoleQuery groupByProfileId() Group by the profileid column
 * @method ProfileRoleQuery groupByRoleId() Group by the roleid column
 * @method ProfileRoleQuery groupByRestrictions() Group by the profilerolerestrictions column
 *
 * @method ProfileRoleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProfileRoleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProfileRoleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProfileRoleQuery leftJoinProfile($relationAlias = null) Adds a LEFT JOIN clause to the query using the Profile relation
 * @method ProfileRoleQuery rightJoinProfile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Profile relation
 * @method ProfileRoleQuery innerJoinProfile($relationAlias = null) Adds a INNER JOIN clause to the query using the Profile relation
 *
 * @method ProfileRoleQuery leftJoinRole($relationAlias = null) Adds a LEFT JOIN clause to the query using the Role relation
 * @method ProfileRoleQuery rightJoinRole($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Role relation
 * @method ProfileRoleQuery innerJoinRole($relationAlias = null) Adds a INNER JOIN clause to the query using the Role relation
 *
 * @method ProfileRole findOne(PropelPDO $con = null) Return the first ProfileRole matching the query
 * @method ProfileRole findOneOrCreate(PropelPDO $con = null) Return the first ProfileRole matching the query, or a new ProfileRole object populated from the query conditions when no match is found
 *
 * @method ProfileRole findOneByProfileId(int $profileid) Return the first ProfileRole filtered by the profileid column
 * @method ProfileRole findOneByRoleId(int $roleid) Return the first ProfileRole filtered by the roleid column
 * @method ProfileRole findOneByRestrictions(string $profilerolerestrictions) Return the first ProfileRole filtered by the profilerolerestrictions column
 *
 * @method array findById(int $profileroleid) Return ProfileRole objects filtered by the profileroleid column
 * @method array findByProfileId(int $profileid) Return ProfileRole objects filtered by the profileid column
 * @method array findByRoleId(int $roleid) Return ProfileRole objects filtered by the roleid column
 * @method array findByRestrictions(string $profilerolerestrictions) Return ProfileRole objects filtered by the profilerolerestrictions column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseProfileRoleQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProfileRoleQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\ProfileRole', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProfileRoleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProfileRoleQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProfileRoleQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProfileRoleQuery) {
            return $criteria;
        }
        $query = new ProfileRoleQuery();
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
     * @return   ProfileRole|ProfileRole[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProfileRolePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProfileRolePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ProfileRole A model object, or null if the key is not found
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
     * @return                 ProfileRole A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `profileroleid`, `profileid`, `roleid`, `profilerolerestrictions` FROM `profile_role` WHERE `profileroleid` = :p0';
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
            $obj = new ProfileRole();
            $obj->hydrate($row);
            ProfileRolePeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProfileRole|ProfileRole[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProfileRole[]|mixed the list of results, formatted by the current formatter
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
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProfileRolePeer::PROFILEROLEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProfileRolePeer::PROFILEROLEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the profileroleid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE profileroleid = 1234
     * $query->filterById(array(12, 34)); // WHERE profileroleid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE profileroleid >= 12
     * $query->filterById(array('max' => 12)); // WHERE profileroleid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProfileRolePeer::PROFILEROLEID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProfileRolePeer::PROFILEROLEID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfileRolePeer::PROFILEROLEID, $id, $comparison);
    }

    /**
     * Filter the query on the profileid column
     *
     * Example usage:
     * <code>
     * $query->filterByProfileId(1234); // WHERE profileid = 1234
     * $query->filterByProfileId(array(12, 34)); // WHERE profileid IN (12, 34)
     * $query->filterByProfileId(array('min' => 12)); // WHERE profileid >= 12
     * $query->filterByProfileId(array('max' => 12)); // WHERE profileid <= 12
     * </code>
     *
     * @see       filterByProfile()
     *
     * @param     mixed $profileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function filterByProfileId($profileId = null, $comparison = null)
    {
        if (is_array($profileId)) {
            $useMinMax = false;
            if (isset($profileId['min'])) {
                $this->addUsingAlias(ProfileRolePeer::PROFILEID, $profileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profileId['max'])) {
                $this->addUsingAlias(ProfileRolePeer::PROFILEID, $profileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfileRolePeer::PROFILEID, $profileId, $comparison);
    }

    /**
     * Filter the query on the roleid column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleId(1234); // WHERE roleid = 1234
     * $query->filterByRoleId(array(12, 34)); // WHERE roleid IN (12, 34)
     * $query->filterByRoleId(array('min' => 12)); // WHERE roleid >= 12
     * $query->filterByRoleId(array('max' => 12)); // WHERE roleid <= 12
     * </code>
     *
     * @see       filterByRole()
     *
     * @param     mixed $roleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function filterByRoleId($roleId = null, $comparison = null)
    {
        if (is_array($roleId)) {
            $useMinMax = false;
            if (isset($roleId['min'])) {
                $this->addUsingAlias(ProfileRolePeer::ROLEID, $roleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleId['max'])) {
                $this->addUsingAlias(ProfileRolePeer::ROLEID, $roleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfileRolePeer::ROLEID, $roleId, $comparison);
    }

    /**
     * Filter the query on the profilerolerestrictions column
     *
     * Example usage:
     * <code>
     * $query->filterByRestrictions('fooValue');   // WHERE profilerolerestrictions = 'fooValue'
     * $query->filterByRestrictions('%fooValue%'); // WHERE profilerolerestrictions LIKE '%fooValue%'
     * </code>
     *
     * @param     string $restrictions The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function filterByRestrictions($restrictions = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($restrictions)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $restrictions)) {
                $restrictions = str_replace('*', '%', $restrictions);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProfileRolePeer::PROFILEROLERESTRICTIONS, $restrictions, $comparison);
    }

    /**
     * Filter the query by a related Profile object
     *
     * @param   Profile|PropelObjectCollection $profile The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProfileRoleQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProfile($profile, $comparison = null)
    {
        if ($profile instanceof Profile) {
            return $this
                ->addUsingAlias(ProfileRolePeer::PROFILEID, $profile->getId(), $comparison);
        } elseif ($profile instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProfileRolePeer::PROFILEID, $profile->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProfile() only accepts arguments of type Profile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Profile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function joinProfile($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Profile');

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
            $this->addJoinObject($join, 'Profile');
        }

        return $this;
    }

    /**
     * Use the Profile relation Profile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ProfileQuery A secondary query class using the current class as primary query
     */
    public function useProfileQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProfile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Profile', '\PoGo\ProfileQuery');
    }

    /**
     * Filter the query by a related Role object
     *
     * @param   Role|PropelObjectCollection $role The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProfileRoleQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRole($role, $comparison = null)
    {
        if ($role instanceof Role) {
            return $this
                ->addUsingAlias(ProfileRolePeer::ROLEID, $role->getId(), $comparison);
        } elseif ($role instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProfileRolePeer::ROLEID, $role->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRole() only accepts arguments of type Role or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Role relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function joinRole($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Role');

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
            $this->addJoinObject($join, 'Role');
        }

        return $this;
    }

    /**
     * Use the Role relation Role object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\RoleQuery A secondary query class using the current class as primary query
     */
    public function useRoleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRole($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Role', '\PoGo\RoleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ProfileRole $profileRole Object to remove from the list of results
     *
     * @return ProfileRoleQuery The current query, for fluid interface
     */
    public function prune($profileRole = null)
    {
        if ($profileRole) {
            $this->addUsingAlias(ProfileRolePeer::PROFILEROLEID, $profileRole->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
