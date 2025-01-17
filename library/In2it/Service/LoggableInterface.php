<?php

interface In2it_Service_LoggableInterface
{
    /**
     * Sets the logger for a service
     *
     * @param Zend_Log $log
     * @return mixed
     */
    public function setLogger(Zend_Log $log);

    /**
     * Retrieves the logger
     *
     * @return Zend_Log
     */
    public function getLogger();
}