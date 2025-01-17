<?php
/**
 * In2it
 * 
 * This is an extension of Zend Framework containing custom extensions for
 * the Zend Framework build by in2it vof team members.
 *
 * @category   In2it 
 * @package    In2it_Model
 * @copyright  Copyright (c) 2012 in2it vof (http://in2it.be)
 */
/**
 * In2it_Model_Mapper
 * 
 * This abstract class provides a base functionality for any data gateway mapper
 * model that extends from this class.
 * 
 * @category In2it
 * @package In2it_Model
 * @copyright Copyright (c) 2012 in2it vof
 * @abstract
 */
abstract class In2it_Model_Mapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     * @var Zend_Log
     */
    protected $_logger;

    /**
     * @var Zend_Cache
     */
    protected $_cache;
    /**
     * Sets the data gateway for this Mapper class
     * 
     * @param Zend_Db_Table $dbTable
     * @throws In2it_Model_Exception
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            if (!class_exists($dbTable)) {
                throw new In2it_Model_Exception(
                    'Non-existing data gateway provided'
                );
            }
            $dbTable = new $dbTable;
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new In2it_Model_Exception('Invalid data gateway provided');
        }
        $this->_dbTable = $dbTable;
    }
    /**
     * Retrieves the data gateway class from this Mapper class
     * 
     * @return Zend_Db_Table
     * @throws In2it_Model_Exception 
     */
    public function getDbTable()
    {
        if (!isset ($this->_dbTable)) {
            throw new In2it_Model_Exception('Data gateway not set');
        }
        return $this->_dbTable;
    }
    /**
     * Finds a single instance of a given model
     * 
     * @param In2it_Model_Abstract $model
     * @param mixed $id 
     */
    public function find(In2it_Model_Abstract $model, $id)
    {
        $resultSet = $this->getDbTable()->find($id);
        $model->populate($resultSet->current());
    }
    /**
     * Fetches a single instance of a given model with optionally provided
     * conditions and ordering
     * 
     * @param In2it_Model_Abstract $model
     * @param null|string|array $where
     * @param null|string|array $order 
     */
    public function fetchRow(
        In2it_Model_Abstract $model, $where = null, $order = null)
    {
        $resultRow = $this->getDbTable()->fetchRow($where, $order);
        if (null !== $resultRow) {
            $model->populate($resultRow);
        }
    }
    /**
     * Saves a single instance of a given model into the data storage
     * 
     * @param In2it_Model_Abstract $model 
     */
    public function save(In2it_Model_Abstract $model)
    {
        if (0 < $model->getId()) {
            $this->getDbTable()->update(
                $model->toArray(), array ('id = ?' => $model->getId())
            );
        } else {
            $data = $model->toArray();
            unset($data['id']);
            $id = $this->getDbTable()->insert($data);
            $model->setId($id);
        }
    }
    /**
     * Removes a single instance of a given model from the data storage
     * 
     * @param In2it_Model_Abstract $model 
     */
    public function delete(In2it_Model_Abstract $model)
    {
        $this->getDbTable()->delete(array ('id = ?' => $model->getId()));
    }
    /**
     * Fetches a collection from the data storage with given conditions
     * 
     * @param In2it_Model_Collection $collection
     * @param string $modelName
     * @param string|array $where
     * @param string|array $order
     * @param int $count
     * @param int $offset
     * @return In2it_Model_Mapper 
     * @throws In2it_Model_Exception
     */
    public function fetchAll(
        In2it_Model_Collection $collection, $modelName, $where = null, 
        $order = null, $count = null, $offset = null)
    {
        if (!class_exists($modelName)) {
            throw new In2it_Model_Exception('Non-existing model provided');
        }
        $resultSet = $this->getDbTable()->fetchAll(
            $where, $order, $count, $offset
        );
        foreach ($resultSet as $resultRow) {
            $collection->addElement(new $modelName($resultRow));
        }
        return $this;
    }

    /**
     * @return Zend_Log
     */
    public function getLogger()
    {
        if (null === $this->_logger) {
            $logger = new Zend_Log();
            $logger->addWriter(new Zend_Log_Writer_Mock);
            $this->setLogger($logger);
        }
        return $this->_logger;
    }

    /**
     * @param Zend_Log $logger
     * @return In2it_Model_Mapper
     */
    public function setLogger(Zend_Log $logger)
    {
        $this->_logger = $logger;
        return $this;
    }

    /**
     * @return Zend_Cache_Core
     */
    public function getCache()
    {
        if (null === $this->_cache) {
            // A dummy cache entry for functionality purposes
            $cache = Zend_Cache::factory('Core', 'File', array ('caching' => false), array ('cache_dir' => '/tmp'));
            $this->setCache($cache);
        }
        return $this->_cache;
    }

    /**
     * @param Zend_Cache_Core $cache
     * @return In2it_Model_Mapper
     */
    public function setCache(Zend_Cache_Core $cache)
    {
        $this->_cache = $cache;
        return $this;
    }

    /**
     * Cleans up a key to be used for caching purposes
     *
     * @param string|array $item
     * @return string
     */
    protected function _createCleanKey($item)
    {
        if (is_string($item)) {
            $item = array($item);
        }
        $string = implode('_', $item);
        $string = str_replace(array('`', ' '),array('', '_'), $string);
        $string = filter_var($string, FILTER_SANITIZE_STRING, array (
            FILTER_FLAG_STRIP_LOW,
            FILTER_FLAG_STRIP_BACKTICK,
            FILTER_FLAG_STRIP_HIGH,
        ));
        return $string;
    }

}