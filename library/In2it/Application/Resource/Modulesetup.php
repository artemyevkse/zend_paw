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
 * Class In2it_Application_Resource_Modulesetup
 *
 * This class provides a Zend Framework resource for loading
 * configurations from installed modules at bootstrap.
 *
 * @link http://blog.vandenbos.org/2009/07/07/zend-framework-module-config/
 * @see Zend_Application_Resource_ResourceAbstract
 */
class In2it_Application_Resource_Modulesetup extends Zend_Application_Resource_ResourceAbstract
{
    public function init()
    {
        $this->_getModuleSetup();
    }

    /**
     * Load the module's ini files
     *
     * @return void
     * @throws Zend_Application_Exception
     */
    protected function _getModuleSetup()
    {
        $bootstrap = $this->getBootstrap();

        if (!($bootstrap instanceof Zend_Application_Bootstrap_Bootstrap)) {
            throw new Zend_Application_Exception('Invalid bootstrap class');
        }

        $bootstrap->bootstrap('frontcontroller');
        $front = $bootstrap->getResource('frontcontroller');
        $modules = $front->getControllerDirectory();

        foreach (array_keys($modules) as $module) {
            $configPath  = $front->getModuleDirectory($module)
                . DIRECTORY_SEPARATOR . 'configs';
            if (file_exists($configPath)) {
                $cfgdir = new DirectoryIterator($configPath);
                $appOptions = $this->getBootstrap()->getOptions();

                foreach ($cfgdir as $file) {
                    if ($file->isFile()) {
                        $filename = $file->getFilename();
                        $options = $this->_loadOptions(
                            $configPath . DIRECTORY_SEPARATOR . $filename
                        );

                        if (($len = strpos($filename, '.')) !== false) {
                            $cfgtype = substr($filename, 0, $len);
                        } else {
                            $cfgtype = $filename;
                        }

                        if (strtolower($cfgtype) == 'module') {
                            $appOptions = array_merge_recursive($appOptions, $options);

                            $options = array_change_key_case($options, CASE_LOWER);

                            if (!empty($options['phpsettings'])) {
                                $this->getBootstrap()->getApplication()
                                    ->setPhpSettings($options['phpsettings']);
                            }

                            if (!empty($options['includepaths'])) {
                                $this->getBootstrap()->getApplication()
                                    ->setIncludePaths($options['includepaths']);
                            }

                            if (!empty($options['autoloadernamespaces'])) {
                                $this->getBootstrap()->getApplication()
                                    ->setAutoloaderNamespaces($options['autoloadernamespaces']);
                            }
                        } else {
                            $appOptions[$module]['resources'][$cfgtype] = $options;
                        }
                    }
                }
                $this->getBootstrap()->setOptions($appOptions);
            } else {
                continue;
            }
        }
    }

    /**
     * Load the config file
     *
     * @param string $fullpath
     * @return array
     * @throws Zend_Config_Exception
     * @throws Zend_Application_Resource_Exception
     */
    protected function _loadOptions($fullpath)
    {
        if (file_exists($fullpath)) {
            switch(substr(trim(strtolower($fullpath)), -3))
            {
                case 'ini':
                    $cfg = new Zend_Config_Ini($fullpath, $this->getBootstrap()
                        ->getEnvironment());
                    break;
                case 'xml':
                    $cfg = new Zend_Config_Xml($fullpath, $this->getBootstrap()
                        ->getEnvironment());
                    break;
                default:
                    throw new Zend_Config_Exception('Invalid format for config file');
                    break;
            }
        } else {
            throw new Zend_Application_Resource_Exception('File does not exist');
        }
        return $cfg->toArray();
    }
}