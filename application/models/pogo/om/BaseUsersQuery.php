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
use PoGo\UserProfile;
use PoGo\Users;
use PoGo\UsersPeer;
use PoGo\UsersQuery;

/**
 * Base class that represents a query for the 'users' table.
 *
 *
 *
 * @method UsersQuery orderById($order = Criteria::ASC) Order by the userid column
 * @method UsersQuery orderByLogin($order = Criteria::ASC) Order by the userlogin column
 * @method UsersQuery orderByFirstName($order = Criteria::ASC) Order by the userfirstname column
 * @method UsersQuery orderByName($order = Criteria::ASC) Order by the username column
 * @method UsersQuery orderByPassword($order = Criteria::ASC) Order by the userpassword column
 * @method UsersQuery orderByEmail($order = Criteria::ASC) Order by the useremail column
 * @method UsersQuery orderByActorId($order = Criteria::ASC) Order by the actorid column
 * @method UsersQuery orderByProperties($order = Criteria::ASC) Order by the userproperties column
 *
 * @method UsersQuery groupById() Group by the userid column
 * @method UsersQuery groupByLogin() Group by the userlogin column
 * @method UsersQuery groupByFirstName() Group by the userfirstname column
 * @method UsersQuery groupByName() Group by the username column
 * @method UsersQuery groupByPassword() Group by the userpassword column
 * @method UsersQuery groupByEmail() Group by the useremail column
 * @method UsersQuery groupByActorId() Group by the actorid column
 * @method UsersQuery groupByProperties() Group by the userproperties column
 *
 * @method UsersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UsersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UsersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UsersQuery leftJoinActor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Actor relation
 * @method UsersQuery rightJoinActor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Actor relation
 * @method UsersQuery innerJoinActor($relationAlias = null) Adds a INNER JOIN clause to the query using the Actor relation
 *
 * @method UsersQuery leftJoinUserProfile($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserProfile relation
 * @method UsersQuery rightJoinUserProfile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserProfile relation
 * @method UsersQuery innerJoinUserProfile($relationAlias = null) Adds a INNER JOIN clause to the query using the UserProfile relation
 *
 * @method Users findOne(PropelPDO $con = null) Return the first Users matching the query
 * @method Users findOneOrCreate(PropelPDO $con = null) Return the first Users matching the query, or a new Users object populated from the query conditions when no match is found
 *
 * @method Users findOneByLogin(string $userlogin) Return the first Users filtered by the userlogin column
 * @method Users findOneByFirstName(string $userfirstname) Return the first Users filtered by the userfirstname column
 * @method Users findOneByName(string $username) Return the first Users filtered by the username column
 * @method Users findOneByPassword(string $userpassword) Return the first Users filtered by the userpassword column
 * @method Users findOneByEmail(string $useremail) Return the first Users filtered by the useremail column
 * @method Users findOneByActorId(int $actorid) Return the first Users filtered by the actorid column
 * @method Users findOneByProperties(string $userproperties) Return the first Users filtered by the userproperties column
 *
 * @method array findById(int $userid) Return Users objects filtered by the userid column
 * @method array findByLogin(string $userlogin) Return Users objects filtered by the userlogin column
 * @method array findByFirstName(string $userfirstname) Return Users objects filtered by the userfirstname column
 * @method array findByName(string $username) Return Users objects filtered by the username column
 * @method array findByPassword(string $userpassword) Return Users objects filtered by the userpassword column
 * @method array findByEmail(string $useremail) Return Users objects filtered by the useremail column
 * @method array findByActorId(int $actorid) Return Users objects filtered by the actorid column
 * @method array findByProperties(string $userproperties) Return Users objects filtered by the userproperties column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseUsersQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUsersQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Users', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UsersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UsersQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UsersQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UsersQuery) {
            return $criteria;
        }
        $query = new UsersQuery();
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
     * @return   Users|Users[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UsersPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UsersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Users A model object, or null if the key is not found
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
     * @return                 Users A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `userid`, `userlogin`, `userfirstname`, `username`, `userpassword`, `useremail`, `actorid`, `userproperties` FROM `users` WHERE `userid` = :p0';
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
            $obj = new Users();
            $obj->hydrate($row);
            UsersPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Users|Users[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Users[]|mixed the list of results, formatted by the current formatter
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
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UsersPeer::USERID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UsersPeer::USERID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the userid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE userid = 1234
     * $query->filterById(array(12, 34)); // WHERE userid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE userid >= 12
     * $query->filterById(array('max' => 12)); // WHERE userid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UsersPeer::USERID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UsersPeer::USERID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersPeer::USERID, $id, $comparison);
    }

    /**
     * Filter the query on the userlogin column
     *
     * Example usage:
     * <code>
     * $query->filterByLogin('fooValue');   // WHERE userlogin = 'fooValue'
     * $query->filterByLogin('%fooValue%'); // WHERE userlogin LIKE '%fooValue%'
     * </code>
     *
     * @param     string $login The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterByLogin($login = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($login)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $login)) {
                $login = str_replace('*', '%', $login);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsersPeer::USERLOGIN, $login, $comparison);
    }

    /**
     * Filter the query on the userfirstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE userfirstname = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE userfirstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UsersPeer::USERFIRSTNAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UsersPeer::USERNAME, $name, $comparison);
    }

    /**
     * Filter the query on the userpassword column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE userpassword = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE userpassword LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsersPeer::USERPASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the useremail column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE useremail = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE useremail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsersPeer::USEREMAIL, $email, $comparison);
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
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterByActorId($actorId = null, $comparison = null)
    {
        if (is_array($actorId)) {
            $useMinMax = false;
            if (isset($actorId['min'])) {
                $this->addUsingAlias(UsersPeer::ACTORID, $actorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($actorId['max'])) {
                $this->addUsingAlias(UsersPeer::ACTORID, $actorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersPeer::ACTORID, $actorId, $comparison);
    }

    /**
     * Filter the query on the userproperties column
     *
     * Example usage:
     * <code>
     * $query->filterByProperties('fooValue');   // WHERE userproperties = 'fooValue'
     * $query->filterByProperties('%fooValue%'); // WHERE userproperties LIKE '%fooValue%'
     * </code>
     *
     * @param     string $properties The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function filterByProperties($properties = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($properties)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $properties)) {
                $properties = str_replace('*', '%', $properties);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsersPeer::USERPROPERTIES, $properties, $comparison);
    }

    /**
     * Filter the query by a related Actors object
     *
     * @param   Actors|PropelObjectCollection $actors The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UsersQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActor($actors, $comparison = null)
    {
        if ($actors instanceof Actors) {
            return $this
                ->addUsingAlias(UsersPeer::ACTORID, $actors->getId(), $comparison);
        } elseif ($actors instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UsersPeer::ACTORID, $actors->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByActor() only accepts arguments of type Actors or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Actor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UsersQuery The current query, for fluid interface
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
     * Use the Actor relation Actors object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\ActorsQuery A secondary query class using the current class as primary query
     */
    public function useActorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinActor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Actor', '\PoGo\ActorsQuery');
    }

    /**
     * Filter the query by a related UserProfile object
     *
     * @param   UserProfile|PropelObjectCollection $userProfile  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UsersQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserProfile($userProfile, $comparison = null)
    {
        if ($userProfile instanceof UserProfile) {
            return $this
                ->addUsingAlias(UsersPeer::USERID, $userProfile->getUserId(), $comparison);
        } elseif ($userProfile instanceof PropelObjectCollection) {
            return $this
                ->useUserProfileQuery()
                ->filterByPrimaryKeys($userProfile->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserProfile() only accepts arguments of type UserProfile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserProfile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function joinUserProfile($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserProfile');

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
            $this->addJoinObject($join, 'UserProfile');
        }

        return $this;
    }

    /**
     * Use the UserProfile relation UserProfile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PoGo\UserProfileQuery A secondary query class using the current class as primary query
     */
    public function useUserProfileQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserProfile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserProfile', '\PoGo\UserProfileQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Users $users Object to remove from the list of results
     *
     * @return UsersQuery The current query, for fluid interface
     */
    public function prune($users = null)
    {
        if ($users) {
            $this->addUsingAlias(UsersPeer::USERID, $users->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
