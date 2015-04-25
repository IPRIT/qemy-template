<?php

namespace Qemy\Core\Model;

use Qemy\Core\Application;
use Qemy\Db\QemyDatabase;

abstract class AbstractModel implements ModelInterface {

    private $qemy_db;
    private $data;
    private $request_params;

    function __construct() {
        $this->qemy_db = new QemyDatabase(Application::$config['db_options']);
        $this->specific_params = Application::$router->getSpecificParams();
        $this->request_params = Application::$request_variables;
    }

    protected function getQemyDb() {
        return $this->qemy_db;
    }

    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
    }

    function getRequestParams() {
        return $this->request_params;
    }
}