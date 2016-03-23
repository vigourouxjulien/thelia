<?php

namespace PaymentMangopay\Model\Base;

use \Exception;
use \PDO;
use PaymentMangopay\Model\MangopayWallet as ChildMangopayWallet;
use PaymentMangopay\Model\MangopayWalletQuery as ChildMangopayWalletQuery;
use PaymentMangopay\Model\Map\MangopayWalletTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'mangopay_wallet' table.
 *
 * 
 *
 * @method     ChildMangopayWalletQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMangopayWalletQuery orderByUser($order = Criteria::ASC) Order by the user column
 * @method     ChildMangopayWalletQuery orderByWallet($order = Criteria::ASC) Order by the wallet column
 * @method     ChildMangopayWalletQuery orderByIsDefault($order = Criteria::ASC) Order by the is_default column
 * @method     ChildMangopayWalletQuery orderByTheliaSeller($order = Criteria::ASC) Order by the thelia_seller column
 *
 * @method     ChildMangopayWalletQuery groupById() Group by the id column
 * @method     ChildMangopayWalletQuery groupByUser() Group by the user column
 * @method     ChildMangopayWalletQuery groupByWallet() Group by the wallet column
 * @method     ChildMangopayWalletQuery groupByIsDefault() Group by the is_default column
 * @method     ChildMangopayWalletQuery groupByTheliaSeller() Group by the thelia_seller column
 *
 * @method     ChildMangopayWalletQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMangopayWalletQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMangopayWalletQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMangopayWallet findOne(ConnectionInterface $con = null) Return the first ChildMangopayWallet matching the query
 * @method     ChildMangopayWallet findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMangopayWallet matching the query, or a new ChildMangopayWallet object populated from the query conditions when no match is found
 *
 * @method     ChildMangopayWallet findOneById(int $id) Return the first ChildMangopayWallet filtered by the id column
 * @method     ChildMangopayWallet findOneByUser(int $user) Return the first ChildMangopayWallet filtered by the user column
 * @method     ChildMangopayWallet findOneByWallet(int $wallet) Return the first ChildMangopayWallet filtered by the wallet column
 * @method     ChildMangopayWallet findOneByIsDefault(int $is_default) Return the first ChildMangopayWallet filtered by the is_default column
 * @method     ChildMangopayWallet findOneByTheliaSeller(int $thelia_seller) Return the first ChildMangopayWallet filtered by the thelia_seller column
 *
 * @method     array findById(int $id) Return ChildMangopayWallet objects filtered by the id column
 * @method     array findByUser(int $user) Return ChildMangopayWallet objects filtered by the user column
 * @method     array findByWallet(int $wallet) Return ChildMangopayWallet objects filtered by the wallet column
 * @method     array findByIsDefault(int $is_default) Return ChildMangopayWallet objects filtered by the is_default column
 * @method     array findByTheliaSeller(int $thelia_seller) Return ChildMangopayWallet objects filtered by the thelia_seller column
 *
 */
abstract class MangopayWalletQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \PaymentMangopay\Model\Base\MangopayWalletQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PaymentMangopay\\Model\\MangopayWallet', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMangopayWalletQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMangopayWalletQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PaymentMangopay\Model\MangopayWalletQuery) {
            return $criteria;
        }
        $query = new \PaymentMangopay\Model\MangopayWalletQuery();
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
     * @return ChildMangopayWallet|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MangopayWalletTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MangopayWalletTableMap::DATABASE_NAME);
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
     * @return   ChildMangopayWallet A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, USER, WALLET, IS_DEFAULT, THELIA_SELLER FROM mangopay_wallet WHERE ID = :p0';
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
            $obj = new ChildMangopayWallet();
            $obj->hydrate($row);
            MangopayWalletTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMangopayWallet|array|mixed the result, formatted by the current formatter
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
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MangopayWalletTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MangopayWalletTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MangopayWalletTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MangopayWalletTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayWalletTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the user column
     *
     * Example usage:
     * <code>
     * $query->filterByUser(1234); // WHERE user = 1234
     * $query->filterByUser(array(12, 34)); // WHERE user IN (12, 34)
     * $query->filterByUser(array('min' => 12)); // WHERE user > 12
     * </code>
     *
     * @param     mixed $user The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function filterByUser($user = null, $comparison = null)
    {
        if (is_array($user)) {
            $useMinMax = false;
            if (isset($user['min'])) {
                $this->addUsingAlias(MangopayWalletTableMap::USER, $user['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($user['max'])) {
                $this->addUsingAlias(MangopayWalletTableMap::USER, $user['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayWalletTableMap::USER, $user, $comparison);
    }

    /**
     * Filter the query on the wallet column
     *
     * Example usage:
     * <code>
     * $query->filterByWallet(1234); // WHERE wallet = 1234
     * $query->filterByWallet(array(12, 34)); // WHERE wallet IN (12, 34)
     * $query->filterByWallet(array('min' => 12)); // WHERE wallet > 12
     * </code>
     *
     * @param     mixed $wallet The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function filterByWallet($wallet = null, $comparison = null)
    {
        if (is_array($wallet)) {
            $useMinMax = false;
            if (isset($wallet['min'])) {
                $this->addUsingAlias(MangopayWalletTableMap::WALLET, $wallet['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wallet['max'])) {
                $this->addUsingAlias(MangopayWalletTableMap::WALLET, $wallet['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayWalletTableMap::WALLET, $wallet, $comparison);
    }

    /**
     * Filter the query on the is_default column
     *
     * Example usage:
     * <code>
     * $query->filterByIsDefault(1234); // WHERE is_default = 1234
     * $query->filterByIsDefault(array(12, 34)); // WHERE is_default IN (12, 34)
     * $query->filterByIsDefault(array('min' => 12)); // WHERE is_default > 12
     * </code>
     *
     * @param     mixed $isDefault The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function filterByIsDefault($isDefault = null, $comparison = null)
    {
        if (is_array($isDefault)) {
            $useMinMax = false;
            if (isset($isDefault['min'])) {
                $this->addUsingAlias(MangopayWalletTableMap::IS_DEFAULT, $isDefault['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isDefault['max'])) {
                $this->addUsingAlias(MangopayWalletTableMap::IS_DEFAULT, $isDefault['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayWalletTableMap::IS_DEFAULT, $isDefault, $comparison);
    }

    /**
     * Filter the query on the thelia_seller column
     *
     * Example usage:
     * <code>
     * $query->filterByTheliaSeller(1234); // WHERE thelia_seller = 1234
     * $query->filterByTheliaSeller(array(12, 34)); // WHERE thelia_seller IN (12, 34)
     * $query->filterByTheliaSeller(array('min' => 12)); // WHERE thelia_seller > 12
     * </code>
     *
     * @param     mixed $theliaSeller The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function filterByTheliaSeller($theliaSeller = null, $comparison = null)
    {
        if (is_array($theliaSeller)) {
            $useMinMax = false;
            if (isset($theliaSeller['min'])) {
                $this->addUsingAlias(MangopayWalletTableMap::THELIA_SELLER, $theliaSeller['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($theliaSeller['max'])) {
                $this->addUsingAlias(MangopayWalletTableMap::THELIA_SELLER, $theliaSeller['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MangopayWalletTableMap::THELIA_SELLER, $theliaSeller, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMangopayWallet $mangopayWallet Object to remove from the list of results
     *
     * @return ChildMangopayWalletQuery The current query, for fluid interface
     */
    public function prune($mangopayWallet = null)
    {
        if ($mangopayWallet) {
            $this->addUsingAlias(MangopayWalletTableMap::ID, $mangopayWallet->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mangopay_wallet table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MangopayWalletTableMap::DATABASE_NAME);
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
            MangopayWalletTableMap::clearInstancePool();
            MangopayWalletTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMangopayWallet or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMangopayWallet object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MangopayWalletTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MangopayWalletTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        MangopayWalletTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MangopayWalletTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MangopayWalletQuery
