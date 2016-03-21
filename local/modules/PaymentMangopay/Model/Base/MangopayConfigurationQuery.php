<?php

namespace PaymentMangopay\Model\Base;

use \Exception;
use \PDO;
use PaymentMangopay\Model\MangopayConfiguration as ChildMangopayConfiguration;
use PaymentMangopay\Model\MangopayConfigurationQuery as ChildMangopayConfigurationQuery;
use PaymentMangopay\Model\Map\MangopayConfigurationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'mangopay_configuration' table.
 *
 * 
 *
 * @method     ChildMangopayConfigurationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMangopayConfigurationQuery orderByFees($order = Criteria::ASC) Order by the fees column
 * @method     ChildMangopayConfigurationQuery orderByClientid($order = Criteria::ASC) Order by the clientid column
 * @method     ChildMangopayConfigurationQuery orderByClientpassword($order = Criteria::ASC) Order by the clientpassword column
 * @method     ChildMangopayConfigurationQuery orderByTemporaryfolder($order = Criteria::ASC) Order by the temporaryfolder column
 * @method     ChildMangopayConfigurationQuery orderByDeferredPayment($order = Criteria::ASC) Order by the deferred_payment column
 * @method     ChildMangopayConfigurationQuery orderByDays($order = Criteria::ASC) Order by the days column
 * @method     ChildMangopayConfigurationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildMangopayConfigurationQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildMangopayConfigurationQuery groupById() Group by the id column
 * @method     ChildMangopayConfigurationQuery groupByFees() Group by the fees column
 * @method     ChildMangopayConfigurationQuery groupByClientid() Group by the clientid column
 * @method     ChildMangopayConfigurationQuery groupByClientpassword() Group by the clientpassword column
 * @method     ChildMangopayConfigurationQuery groupByTemporaryfolder() Group by the temporaryfolder column
 * @method     ChildMangopayConfigurationQuery groupByDeferredPayment() Group by the deferred_payment column
 * @method     ChildMangopayConfigurationQuery groupByDays() Group by the days column
 * @method     ChildMangopayConfigurationQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildMangopayConfigurationQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildMangopayConfigurationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMangopayConfigurationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMangopayConfigurationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMangopayConfiguration findOne(ConnectionInterface $con = null) Return the first ChildMangopayConfiguration matching the query
 * @method     ChildMangopayConfiguration findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMangopayConfiguration matching the query, or a new ChildMangopayConfiguration object populated from the query conditions when no match is found
 *
 * @method     ChildMangopayConfiguration findOneById(int $id) Return the first ChildMangopayConfiguration filtered by the id column
 * @method     ChildMangopayConfiguration findOneByFees(double $fees) Return the first ChildMangopayConfiguration filtered by the fees column
 * @method     ChildMangopayConfiguration findOneByClientid(string $clientid) Return the first ChildMangopayConfiguration filtered by the clientid column
 * @method     ChildMangopayConfiguration findOneByClientpassword(string $clientpassword) Return the first ChildMangopayConfiguration filtered by the clientpassword column
 * @method     ChildMangopayConfiguration findOneByTemporaryfolder(string $temporaryfolder) Return the first ChildMangopayConfiguration filtered by the temporaryfolder column
 * @method     ChildMangopayConfiguration findOneByDeferredPayment(int $deferred_payment) Return the first ChildMangopayConfiguration filtered by the deferred_payment column
 * @method     ChildMangopayConfiguration findOneByDays(int $days) Return the first ChildMangopayConfiguration filtered by the days column
 * @method     ChildMangopayConfiguration findOneByCreatedAt(string $created_at) Return the first ChildMangopayConfiguration filtered by the created_at column
 * @method     ChildMangopayConfiguration findOneByUpdatedAt(string $updated_at) Return the first ChildMangopayConfiguration filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildMangopayConfiguration objects filtered by the id column
 * @method     array findByFees(double $fees) Return ChildMangopayConfiguration objects filtered by the fees column
 * @method     array findByClientid(string $clientid) Return ChildMangopayConfiguration objects filtered by the clientid column
 * @method     array findByClientpassword(string $clientpassword) Return ChildMangopayConfiguration objects filtered by the clientpassword column
 * @method     array findByTemporaryfolder(string $temporaryfolder) Return ChildMangopayConfiguration objects filtered by the temporaryfolder column
 * @method     array findByDeferredPayment(int $deferred_payment) Return ChildMangopayConfiguration objects filtered by the deferred_payment column
 * @method     array findByDays(int $days) Return ChildMangopayConfiguration objects filtered by the days column
 * @method     array findByCreatedAt(string $created_at) Return ChildMangopayConfiguration objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildMangopayConfiguration objects filtered by the updated_at column
 *
 */
abstract class MangopayConfigurationQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \PaymentMangopay\Model\Base\MangopayConfigurationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PaymentMangopay\\Model\\MangopayConfiguration', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMangopayConfigurationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMangopayConfigurationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PaymentMangopay\Model\MangopayConfigurationQuery) {
            return $criteria;
        }
        $query = new \PaymentMangopay\Model\MangopayConfigurationQuery();
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
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMangopayConfiguration|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MangopayConfigurationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MangopayConfigurationTableMap::DATABASE_NAME);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildMangopayConfiguration A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, FEES, CLIENTID, CLIENTPASSWORD, TEMPORARYFOLDER, DEFERRED_PAYMENT, DAYS, CREATED_AT, UPDATED_AT FROM mangopay_configuration WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildMangopayConfiguration();
            $obj->hydrate($row);
            MangopayConfigurationTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildMangopayConfiguration|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MangopayConfigurationTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MangopayConfigurationTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the fees column
     *
     * Example usage:
     * <code>
     * $query->filterByFees(1234); // WHERE fees = 1234
     * $query->filterByFees(array(12, 34)); // WHERE fees IN (12, 34)
     * $query->filterByFees(array('min' => 12)); // WHERE fees > 12
     * </code>
     *
     * @param     mixed $fees The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByFees($fees = null, $comparison = null)
    {
        if (is_array($fees)) {
            $useMinMax = false;
            if (isset($fees['min'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::FEES, $fees['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fees['max'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::FEES, $fees['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::FEES, $fees, $comparison);
    }

    /**
     * Filter the query on the clientid column
     *
     * Example usage:
     * <code>
     * $query->filterByClientid('fooValue');   // WHERE clientid = 'fooValue'
     * $query->filterByClientid('%fooValue%'); // WHERE clientid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientid The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByClientid($clientid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientid)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientid)) {
                $clientid = str_replace('*', '%', $clientid);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::CLIENTID, $clientid, $comparison);
    }

    /**
     * Filter the query on the clientpassword column
     *
     * Example usage:
     * <code>
     * $query->filterByClientpassword('fooValue');   // WHERE clientpassword = 'fooValue'
     * $query->filterByClientpassword('%fooValue%'); // WHERE clientpassword LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientpassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByClientpassword($clientpassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientpassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientpassword)) {
                $clientpassword = str_replace('*', '%', $clientpassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::CLIENTPASSWORD, $clientpassword, $comparison);
    }

    /**
     * Filter the query on the temporaryfolder column
     *
     * Example usage:
     * <code>
     * $query->filterByTemporaryfolder('fooValue');   // WHERE temporaryfolder = 'fooValue'
     * $query->filterByTemporaryfolder('%fooValue%'); // WHERE temporaryfolder LIKE '%fooValue%'
     * </code>
     *
     * @param     string $temporaryfolder The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByTemporaryfolder($temporaryfolder = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($temporaryfolder)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $temporaryfolder)) {
                $temporaryfolder = str_replace('*', '%', $temporaryfolder);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::TEMPORARYFOLDER, $temporaryfolder, $comparison);
    }

    /**
     * Filter the query on the deferred_payment column
     *
     * Example usage:
     * <code>
     * $query->filterByDeferredPayment(1234); // WHERE deferred_payment = 1234
     * $query->filterByDeferredPayment(array(12, 34)); // WHERE deferred_payment IN (12, 34)
     * $query->filterByDeferredPayment(array('min' => 12)); // WHERE deferred_payment > 12
     * </code>
     *
     * @param     mixed $deferredPayment The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByDeferredPayment($deferredPayment = null, $comparison = null)
    {
        if (is_array($deferredPayment)) {
            $useMinMax = false;
            if (isset($deferredPayment['min'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::DEFERRED_PAYMENT, $deferredPayment['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deferredPayment['max'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::DEFERRED_PAYMENT, $deferredPayment['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::DEFERRED_PAYMENT, $deferredPayment, $comparison);
    }

    /**
     * Filter the query on the days column
     *
     * Example usage:
     * <code>
     * $query->filterByDays(1234); // WHERE days = 1234
     * $query->filterByDays(array(12, 34)); // WHERE days IN (12, 34)
     * $query->filterByDays(array('min' => 12)); // WHERE days > 12
     * </code>
     *
     * @param     mixed $days The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByDays($days = null, $comparison = null)
    {
        if (is_array($days)) {
            $useMinMax = false;
            if (isset($days['min'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::DAYS, $days['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($days['max'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::DAYS, $days['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::DAYS, $days, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MangopayConfigurationTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayConfigurationTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMangopayConfiguration $mangopayConfiguration Object to remove from the list of results
     *
     * @return ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function prune($mangopayConfiguration = null)
    {
        if ($mangopayConfiguration) {
            $this->addUsingAlias(MangopayConfigurationTableMap::ID, $mangopayConfiguration->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mangopay_configuration table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MangopayConfigurationTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MangopayConfigurationTableMap::clearInstancePool();
            MangopayConfigurationTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMangopayConfiguration or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMangopayConfiguration object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MangopayConfigurationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MangopayConfigurationTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        MangopayConfigurationTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MangopayConfigurationTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior
    
    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(MangopayConfigurationTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(MangopayConfigurationTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(MangopayConfigurationTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(MangopayConfigurationTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(MangopayConfigurationTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildMangopayConfigurationQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(MangopayConfigurationTableMap::CREATED_AT);
    }

} // MangopayConfigurationQuery
