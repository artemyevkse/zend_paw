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
 * In2it_Model_Interface
 * 
 * This interface provides a blue-print of model classes that implement this
 * functionality and allows a certain behaviour to be expected
 * 
 * @category In2it
 * @package In2it_Model
 * @copyright Copyright (c) 2012 in2it vof
 */
interface In2it_Model_Interface
{
    public function populate($row);
    /**
     * Converts this Model into an array
     * 
     * @return array
     */
    public function toArray();
}