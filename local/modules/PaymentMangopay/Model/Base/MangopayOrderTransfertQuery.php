<?php

namespace PaymentMangopay\Model\Base;

use \Exception;
use \PDO;
use PaymentMangopay\Model\MangopayOrderTransfert as ChildMangopayOrderTransfert;
use PaymentMangopay\Model\MangopayOrderTransfertQuery as ChildMangopayOrderTransfertQuery;
use PaymentMangopay\Model\Map\MangopayOrderTransfertTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'mangopay_order_transfert' table.
 *
 * 
 *
 * @method     ChildMangopayOrderTransfertQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMangopayOrderTransfertQuery orderByTransactionRef($order = Criteria::ASC) Order by the transaction_ref column
 * @method     ChildMangopayOrderTransfertQuery orderByTransactionStatus($order = Criteria::ASC) Order by the transaction_status column
 * @method     ChildMangopayOrderTransfertQuery orderByEscrowWallet($order = Criteria::ASC) Order by the escrow_wallet column
 * @method     ChildMangopayOrderTransfertQuery orderByUserWallet($order = Criteria::ASC) Order by the user_wallet column
 * @method     ChildMangopayOrderTransfertQuery orderByTransfertRef($order = Criteria::ASC) Order by the transfert_ref column
 * @method     ChildMangopayOrderTransfertQuery orderByTransfertStatus($order = Criteria::ASC) Order by the transfert_status column
 * @method     ChildMangopayOrderTransfertQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildMangopayOrderTransfertQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildMangopayOrderTransfertQuery groupById() Group by the id column
 * @method     ChildMangopayOrderTransfertQuery groupByTransactionRef() Group by the transaction_ref column
 * @method     ChildMangopayOrderTransfertQuery groupByTransactionStatus() Group by the transaction_status column
 * @method     ChildMangopayOrderTransfertQuery groupByEscrowWallet() Group by the escrow_wallet column
 * @method     ChildMangopayOrderTransfertQuery groupByUserWallet() Group by the user_wallet column
 * @method     ChildMangopayOrderTransfertQuery groupByTransfertRef() Group by the transfert_ref column
 * @method     ChildMangopayOrderTransfertQuery groupByTransfertStatus() Group by the transfert_status column
 * @method     ChildMangopayOrderTransfertQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildMangopayOrderTransfertQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildMangopayOrderTransfertQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMangopayOrderTransfertQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMangopayOrderTransfertQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMangopayOrderTransfert findOne(ConnectionInterface $con = null) Return the first ChildMangopayOrderTransfert matching the query
 * @method     ChildMangopayOrderTransfert findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMangopayOrderTransfert matching the query, or a new ChildMangopayOrderTransfert object populated from the query conditions when no match is found
 *
 * @method     ChildMangopayOrderTransfert findOneById(int $id) Return the first ChildMangopayOrderTransfert filtered by the id column
 * @method     ChildMangopayOrderTransfert findOneByTransactionRef(string $transaction_ref) Return the first ChildMangopayOrderTransfert filtered by the transaction_ref column
 * @method     ChildMangopayOrderTransfert findOneByTransactionStatus(string $transaction_status) Return the first ChildMangopayOrderTransfert filtered by the transaction_status column
 * @method     ChildMangopayOrderTransfert findOneByEscrowWallet(int $escrow_wallet) Return the first ChildMangopayOrderTransfert filtered by the escrow_wallet column
 * @method     ChildMangopayOrderTransfert findOneByUserWallet(int $user_wallet) Return the first ChildMangopayOrderTransfert filtered by the user_wallet column
 * @method     ChildMangopayOrderTransfert findOneByTransfertRef(int $transfert_ref) Return the first ChildMangopayOrderTransfert filtered by the transfert_ref column
 * @method     ChildMangopayOrderTransfert findOneByTransfertStatus(string $transfert_status) Return the first ChildMangopayOrderTransfert filtered by the transfert_status column
 * @method     ChildMangopayOrderTransfert findOneByCreatedAt(string $created_at) Return the first ChildMangopayOrderTransfert filtered by the created_at column
 * @method     ChildMangopayOrderTransfert findOneByUpdatedAt(string $updated_at) Return the first ChildMangopayOrderTransfert filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildMangopayOrderTransfert objects filtered by the id column
 * @method     array findByTransactionRef(string $transaction_ref) Return ChildMangopayOrderTransfert objects filtered by the transaction_ref column
 * @method     array findByTransactionStatus(string $transaction_status) Return ChildMangopayOrderTransfert objects filtered by the transaction_status column
 * @method     array findByEscrowWallet(int $escrow_wallet) Return ChildMangopayOrderTransfert objects filtered by the escrow_wallet column
 * @method     array findByUserWallet(int $user_wallet) Return ChildMangopayOrderTransfert objects filtered by the user_wallet column
 * @method     array findByTransfertRef(int $transfert_ref) Return ChildMangopayOrderTransfert objects filtered by the transfert_ref column
 * @method     array findByTransfertStatus(string $transfert_status) Return ChildMangopayOrderTransfert objects filtered by the transfert_status column
 * @method     array findByCreatedAt(string $created_at) Return ChildMangopayOrderTransfert objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildMangopayOrderTransfert objects filtered by the updated_at column
 *
 */
abstract class MangopayOrderTransfertQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \PaymentMangopay\Model\Base\MangopayOrderTransfertQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PaymentMangopay\\Model\\MangopayOrderTransfert', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMangopayOrderTransfertQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMangopayOrderTransfertQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PaymentMangopay\Model\MangopayOrderTransfertQuery) {
            return $criteria;
        }
        $query = new \PaymentMangopay\Model\MangopayOrderTransfertQuery();
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
     * @return ChildMangopayOrderTransfert|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MangopayOrderTransfertTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MangopayOrderTransfertTableMap::DATABASE_NAME);
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
     * @return   ChildMangopayOrderTransfert A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TRANSACTION_REF, TRANSACTION_STATUS, ESCROW_WALLET, USER_WALLET, TRANSFERT_REF, TRANSFERT_STATUS, CREATED_AT, UPDATED_AT FROM mangopay_order_transfert WHERE ID = :p0';
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
            $obj = new ChildMangopayOrderTransfert();
            $obj->hydrate($row);
            MangopayOrderTransfertTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMangopayOrderTransfert|array|mixed the result, formatted by the current formatter
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
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the transaction_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByTransactionRef('fooValue');   // WHERE transaction_ref = 'fooValue'
     * $query->filterByTransactionRef('%fooValue%'); // WHERE transaction_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $transactionRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByTransactionRef($transactionRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($transactionRef)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $transactionRef)) {
                $transactionRef = str_replace('*', '%', $transactionRef);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::TRANSACTION_REF, $transactionRef, $comparison);
    }

    /**
     * Filter the query on the transaction_status column
     *
     * Example usage:
     * <code>
     * $query->filterByTransactionStatus('fooValue');   // WHERE transaction_status = 'fooValue'
     * $query->filterByTransactionStatus('%fooValue%'); // WHERE transaction_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $transactionStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByTransactionStatus($transactionStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($transactionStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $transactionStatus)) {
                $transactionStatus = str_replace('*', '%', $transactionStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::TRANSACTION_STATUS, $transactionStatus, $comparison);
    }

    /**
     * Filter the query on the escrow_wallet column
     *
     * Example usage:
     * <code>
     * $query->filterByEscrowWallet(1234); // WHERE escrow_wallet = 1234
     * $query->filterByEscrowWallet(array(12, 34)); // WHERE escrow_wallet IN (12, 34)
     * $query->filterByEscrowWallet(array('min' => 12)); // WHERE escrow_wallet > 12
     * </code>
     *
     * @param     mixed $escrowWallet The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByEscrowWallet($escrowWallet = null, $comparison = null)
    {
        if (is_array($escrowWallet)) {
            $useMinMax = false;
            if (isset($escrowWallet['min'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::ESCROW_WALLET, $escrowWallet['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($escrowWallet['max'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::ESCROW_WALLET, $escrowWallet['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::ESCROW_WALLET, $escrowWallet, $comparison);
    }

    /**
     * Filter the query on the user_wallet column
     *
     * Example usage:
     * <code>
     * $query->filterByUserWallet(1234); // WHERE user_wallet = 1234
     * $query->filterByUserWallet(array(12, 34)); // WHERE user_wallet IN (12, 34)
     * $query->filterByUserWallet(array('min' => 12)); // WHERE user_wallet > 12
     * </code>
     *
     * @param     mixed $userWallet The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByUserWallet($userWallet = null, $comparison = null)
    {
        if (is_array($userWallet)) {
            $useMinMax = false;
            if (isset($userWallet['min'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::USER_WALLET, $userWallet['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userWallet['max'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::USER_WALLET, $userWallet['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::USER_WALLET, $userWallet, $comparison);
    }

    /**
     * Filter the query on the transfert_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByTransfertRef(1234); // WHERE transfert_ref = 1234
     * $query->filterByTransfertRef(array(12, 34)); // WHERE transfert_ref IN (12, 34)
     * $query->filterByTransfertRef(array('min' => 12)); // WHERE transfert_ref > 12
     * </code>
     *
     * @param     mixed $transfertRef The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByTransfertRef($transfertRef = null, $comparison = null)
    {
        if (is_array($transfertRef)) {
            $useMinMax = false;
            if (isset($transfertRef['min'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::TRANSFERT_REF, $transfertRef['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($transfertRef['max'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::TRANSFERT_REF, $transfertRef['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::TRANSFERT_REF, $transfertRef, $comparison);
    }

    /**
     * Filter the query on the transfert_status column
     *
     * Example usage:
     * <code>
     * $query->filterByTransfertStatus('fooValue');   // WHERE transfert_status = 'fooValue'
     * $query->filterByTransfertStatus('%fooValue%'); // WHERE transfert_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $transfertStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByTransfertStatus($transfertStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($transfertStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $transfertStatus)) {
                $transfertStatus = str_replace('*', '%', $transfertStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::TRANSFERT_STATUS, $transfertStatus, $comparison);
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
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MangopayOrderTransfertTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayOrderTransfertTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMangopayOrderTransfert $mangopayOrderTransfert Object to remove from the list of results
     *
     * @return ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function prune($mangopayOrderTransfert = null)
    {
        if ($mangopayOrderTransfert) {
            $this->addUsingAlias(MangopayOrderTransfertTableMap::ID, $mangopayOrderTransfert->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mangopay_order_transfert table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MangopayOrderTransfertTableMap::DATABASE_NAME);
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
            MangopayOrderTransfertTableMap::clearInstancePool();
            MangopayOrderTransfertTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMangopayOrderTransfert or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMangopayOrderTransfert object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MangopayOrderTransfertTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MangopayOrderTransfertTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        MangopayOrderTransfertTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MangopayOrderTransfertTableMap::clearRelatedInstancePool();
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
     * @return     ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(MangopayOrderTransfertTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(MangopayOrderTransfertTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(MangopayOrderTransfertTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(MangopayOrderTransfertTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(MangopayOrderTransfertTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildMangopayOrderTransfertQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(MangopayOrderTransfertTableMap::CREATED_AT);
    }

} // MangopayOrderTransfertQuery
