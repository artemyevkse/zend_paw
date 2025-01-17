<?php

abstract class In2it_Service_AbstractService implements In2it_Service_LoggableInterface
{
    /**
     * @var Zend_Log
     */
    protected $_logger;

    /**
     * @var Zend_Cache_Core
     */
    protected $_cache;
    /**
     * @return Zend_Log
     */
    public function getLogger()
    {
        if (null === $this->_logger) {
            $logger = new Zend_Log();
            $logger->addWriter(new Zend_Log_Writer_Null());
            $this->setLogger($logger);
        }
        return $this->_logger;
    }

    /**
     * @param Zend_Log $logger
     * @return In2it_Service_AbstractService
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
     * @return In2it_Service_AbstractService
     */
    public function setCache(Zend_Cache_Core $cache)
    {
        $this->_cache = $cache;
        return $this;
    }


}