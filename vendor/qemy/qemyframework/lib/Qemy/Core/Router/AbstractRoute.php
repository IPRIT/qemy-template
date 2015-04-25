<?php

namespace Qemy\Core\Router;

use Qemy\Core\Application;

abstract class AbstractRoute {

    const DEFAULT_CONTROLLER = 'Index';
    const NOT_FOUND_CONTROLLER = 'Err404';
    const DEFAULT_ACTION = 'index';
    const COMPANY_ALIAS = ':company';

    private $post_data;
    private $get_data;

    protected $request_uri;
    protected $clear_request_uri;
    protected $module_name;

    protected $params = array();

    function __construct() {
        $this->request_uri = $_SERVER['REQUEST_URI'];
        $this->clear_request_uri = preg_replace("/((\?|[#]).*$)/i", '', $this->request_uri);
        $this->post_data = $this->createPostData();
        $this->get_data = $this->createGetData();
    }

    private function createPostData() {
        return $_POST;
    }

    private function createGetData() {
        $get_data = array();
        foreach ($_GET as $key => $value) {
            if ($key == 'r') continue; //route key in .htaccess
            $get_data[$key] = $value;
        }
        return $get_data;
    }

    protected function getPostData() {
        return $this->post_data;
    }

    protected function getGetData() {
        return $this->get_data;
    }

    protected function findController($controller_key, $companyPromise) {
        $modules = Application::$config['modules'];
        if (array_key_exists($controller_key, $modules)) {
            return $modules[$controller_key];
        }
        if ($companyPromise) {
            $this->params['company_domain'] = $controller_key;
        }
        return $companyPromise
            ? $modules[self::COMPANY_ALIAS] : self::NOT_FOUND_CONTROLLER;
    }

    protected function findAction($action_key) {
        if ($this->module_name != 'Err404') {
            $modules_path = Q_PATH.Application::$config['module_options']['module_path'];
            $module_config = require $modules_path.'/'.$this->module_name.'/config/module.config.php';
            $actions = $module_config['actions'];
            if (is_array($actions) && array_key_exists($action_key, $actions)) {
                return $actions[$action_key];
            }
        }
        return !1;
    }
}