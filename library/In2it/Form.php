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
 * In2it_Form
 *
 * Because Zend Form didn't allow setting error messages directly on elements,
 * this class offers that functionality.
 *
 * @category In2it
 * @package In2it_Form
 * @copyright Copyright (c) 2012 in2it vof
 */
class In2it_Form extends Zend_Form
{
    public function setElementErrors($errors)
    {
        foreach ($errors as $element => $errorSet) {
            if (null !== $this->getElement($element)) {
                $this->getElement($element)->addErrors($errorSet);
            }
        }
    }
}