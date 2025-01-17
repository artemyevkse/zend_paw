<?php

class In2it_Rest_Route extends Zend_Controller_Router_Route_Abstract
{

    /**
     * Route configuration
     * 
     * @var array 
     */
    protected $_routes;

    /**
     * Instantiates route based on passed Zend_Config structure
     */
    public static function getInstance(Zend_Config $config)
    {
        return new self($config->toArray());
    }


    /**
     * Constructor
     */
    public function __construct(array $routes = array())
    {
        // TODO: remove the filter when all routes are migrated
        $this->_routes = array_filter(
            $routes,
            function($item)
            {
                return !isset($item['method']);
            }
        );
    }


    /**
     * Matches an incoming HTTP request to a module, controller and action.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return Zend_Controller_Request_Abstract
     */
    public function match($request)
    {

        //Zend_Registry::get('logger')->warn('Entering route match method');
        
        $requestMethod = strtoupper($request->getMethod());

        // Ensuring we ignore the query string
        list($requestUri) = explode('?', $request->getRequestUri());

        // Removing any preceeding and trailing slashes
        $requestUri = trim($requestUri, '/');

        if ($requestMethod==='POST') {
            if ($override = $request->getHeader('X-HTTP-Method-Override')) {
                $requestMethod = strtoupper($override);
            } elseif ($override = $request->getParam('_method')) {
                $requestMethod = strtoupper($override);
            }

        }

        $foundRoute = null;
        foreach($this->_routes as $route) {
            if (preg_match($route['route'], $requestUri, $matches)) {
                $foundRoute = $route;
                break;
            }
        }
        if (!$foundRoute) return false;
         
        $params = array(
            'module' => $foundRoute['module'],
            'controller' => $foundRoute['controller'],
            'action' => strtolower($requestMethod),
        );

        // Taking any named subpatterns and adding it to the parameters
        foreach($matches as $key => $value) {
            if (is_string($key)) {
                $params[$key] = $value;
            }
        }
        $request->setParams($params);

        return $request; 

    }

    /**
     * Assembles user submitted parameters forming a URL path defined by this
     * route
     *
     * @param array $data An array of key and value pairs used as parameters
     * @param bool $reset Weither to reset the current params
     * @param bool $encode Weither to return urlencoded string
     * @return string Route path with user submitted parameters
     * @throws Exception
     */
    public function assemble($data = array(), $reset = false, $encode = true)
    {
        throw new Exception('Currently not implemented');
    }

}
