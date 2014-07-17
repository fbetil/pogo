<?php

namespace PoGo\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use PoGo\Status;
use PoGo\StatusPeer;
use PoGo\StatusQuery;

/**
 * Base class that represents a query for the 'status' table.
 *
 *
 *
 * @method StatusQuery orderById($order = Criteria::ASC) Order by the statusid column
 * @method StatusQuery orderByCode($order = Criteria::ASC) Order by the statuscode column
 * @method StatusQuery orderByLabel($order = Criteria::ASC) Order by the statuslabel column
 *
 * @method StatusQuery groupById() Group by the statusid column
 * @method StatusQuery groupByCode() Group by the statuscode column
 * @method StatusQuery groupByLabel() Group by the statuslabel column
 *
 * @method StatusQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StatusQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StatusQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Status findOne(PropelPDO $con = null) Return the first Status matching the query
 * @method Status findOneOrCreate(PropelPDO $con = null) Return the first Status matching the query, or a new Status object populated from the query conditions when no match is found
 *
 * @method Status findOneByCode(string $statuscode) Return the first Status filtered by the statuscode column
 * @method Status findOneByLabel(string $statuslabel) Return the first Status filtered by the statuslabel column
 *
 * @method array findById(int $statusid) Return Status objects filtered by the statusid column
 * @method array findByCode(string $statuscode) Return Status objects filtered by the statuscode column
 * @method array findByLabel(string $statuslabel) Return Status objects filtered by the statuslabel column
 *
 * @package    propel.generator.pogo.om
 */
abstract class BaseStatusQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStatusQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pogo', $modelName = 'PoGo\\Status', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StatusQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StatusQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StatusQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StatusQuery) {
            return $criteria;
        }
        $query = new StatusQuery();
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
     * @return   Status|Status[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StatusPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StatusPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Status A model object, or null if the key is not found
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
     * @return                 Status A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `statusid`, `statuscode`, `statuslabel` FROM `status` WHERE `statusid` = :p0';
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
            $obj = new Status();
            $obj->hydrate($row);
            StatusPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Status|Status[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Status[]|mixed the list of results, formatted by the current formatter
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
     * @return StatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StatusPeer::STATUSID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StatusPeer::STATUSID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the statusid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE statusid = 1234
     * $query->filterById(array(12, 34)); // WHERE statusid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE statusid >= 12
     * $query->filterById(array('max' => 12)); // WHERE statusid <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StatusQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StatusPeer::STATUSID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StatusPeer::STATUSID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StatusPeer::STATUSID, $id, $comparison);
    }

    /**
     * Filter the query on the statuscode column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE statuscode = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE statuscode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StatusQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StatusPeer::STATUSCODE, $code, $comparison);
    }

    /**
     * Filter the query on the statuslabel column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE statuslabel = 'fooValue'
     * $query->filterByLabel('%fooValue%'); // WHERE statuslabel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StatusQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StatusPeer::STATUSLABEL, $label, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Status $status Object to remove from the list of results
     *
     * @return StatusQuery The current query, for fluid interface
     */
    public function prune($status = null)
    {
        if ($status) {
            $this->addUsingAlias(StatusPeer::STATUSID, $status->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
