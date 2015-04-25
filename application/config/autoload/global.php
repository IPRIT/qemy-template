<?php

namespace Autoloader;

class Autoload {

    public static $loader;
    public $configuration;

    public static function init() {
        if (!self::$loader) {
            self::$loader = new self();
        }
        return self::$loader;
    }

    public function __construct() {
        $this->configuration = require Q_PATH . '/application/config/application.config.php';
        spl_autoload_register(array(
            $this, 'vendorAutoload'
        ));
        spl_autoload_register(array(
            $this, 'moduleAutoload'
        ));
    }

    public function vendorAutoload($class) {
        $class_path = '/'.str_replace('\\', '/', $class);
        $vendor_options = $this->configuration['vendor_options'];
        $projects = $vendor_options['projects'];
        foreach ($projects as $project_name => $project_object) {
            $path = $vendor_options['vendor_path'].$project_object['library_path'].$class_path;
            $file_name = Q_PATH.$path.'.php';
            if (file_exists($file_name)) {
                require_once $file_name;
            }
        }
    }

    public function moduleAutoload($class) {
        $class_path = '/'.str_replace('\\', '/', $class);
        $module_options = $this->configuration['module_options'];
        $controller_path = $module_options['module_path'].$class_path;
        $file_name = Q_PATH.$controller_path.'.php';
        if (file_exists($file_name)) {
            require_once $file_name;
        }
    }
}