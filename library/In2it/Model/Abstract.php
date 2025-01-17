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
 * In2it_Model_Abstract
 * 
 * This abstract class provides a blue-print of model classes that extends
 * this functionality and allows a certain behaviour to be expected
 * 
 * @category In2it
 * @package In2it_Model
 * @copyright Copyright (c) 2012 in2it vof
 */
abstract class In2it_Model_Abstract implements In2it_Model_Interface, In2it_Model_ValidatorInterface
{
    /**
     * @var Zend_Filter_Input The filtering and validation procedure
     */
    protected $_inputFilter;

    /**
     * Initializer for this model class
     */
    public function init()
    {
        /* Initialization of this model class */
    }

    /**
     * Constructor for this class populating the model with optional row data.
     * 
     * @param null|array|Zend_Db_Row $params 
     */
    public function __construct($params = null)
    {
        $this->init();
        if (null !== $params) {
            $this->populate($params);
        }
    }

    /**
     * Safely setting values in a chained procedure
     *
     * @param $resultRow The entity result containing key/value pairs
     * @param $key The key of the entity containing the value
     * @param $method The method of the model class to set the property
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function _setSafeValues($resultRow, $key, $method)
    {
        if (!method_exists($this, $method)) {
            throw new InvalidArgumentException('Method ' . $method . ' does not exists.');
        }
        if (isset ($resultRow->$key)) {
            $this->$method($resultRow->$key);
        }
        return $this;
    }

    /**
     * Sets the input filter for validation and filtering of input
     *
     * @param Zend_Filter_Input $inputFilter
     * @return $this
     */
    public function setInputFilter(Zend_Filter_Input $inputFilter)
    {
        $this->_inputFilter = $inputFilter;
        return $this;
    }

    /**
     * Returns the Zend_Filter_Input object
     *
     * @return Zend_Filter_Input
     */
    public function getInputFilter()
    {
        return $this->_inputFilter;
    }
    
}