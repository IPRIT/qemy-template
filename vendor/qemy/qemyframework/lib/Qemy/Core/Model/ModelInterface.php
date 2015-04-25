<?php

namespace Qemy\Core\Model;

interface ModelInterface {

    public function setData($data);
    public function getData();
    public function getRequestParams();
}