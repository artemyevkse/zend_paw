<?php

interface In2it_Model_ValidatorInterface
{
    /**
     * Sets the filtering and validation object
     *
     * @param Zend_Filter_Input $input
     * @return In2it_Model_ValidatorInterface
     */
    public function setInputFilter(Zend_Filter_Input $input);

    /**
     * Retrieves teh filtering and validation object
     *
     * @return In2it_Model_ValidatorInterface
     */
    public function getInputFilter();
}