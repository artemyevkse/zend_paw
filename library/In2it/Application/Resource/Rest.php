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
 * Class In2it_Application_Resource_Rest
 *
 * This class provides a Zend Framework resource for loading
 * configurations from installed modules at bootstrap.
 *
 * @link http://blog.vandenbos.org/2009/07/07/zend-framework-module-config/
 * @see Zend_Application_Resource_ResourceAbstract
 */
class In2it_Application_Resource_Rest
    extends Zend_Application_Resource_ResourceAbstract
{
    public function init()
    {
        $bootstrap = $this->getBootstrap();
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');
        $restOptions = $this->getOptions();

        $routes = isset($restOptions['routes']) ? $restOptions['routes'] : array();
        // Fixing issue for not loading "routes" directly as they're part of rest
        if (empty ($routes)) {
            $routes = isset($restOptions['rest']) ? $restOptions['rest'] : array();
        }

        $restRouteV1 = new In2it_Rest_Route($routes);
        $restRoute = new Zend_Rest_Route(
            Zend_Controller_Front::getInstance(),
            array(),
            isset($restOptions['modules']) ? $restOptions['modules'] : array()
        );
        $front->getRouter()->addRoute('rest_v1', $restRouteV1);
        $front->getRouter()->addRoute('rest', $restRoute);
    }
}
