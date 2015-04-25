<?php

namespace Index\Model;

use Qemy\Core\Model\AbstractModel;
use YourProject\Utils\Validation\Validation;

class IndexModel extends AbstractModel {

    public function main() {
        $test = new Validation();
        $this->setData(array(
            'example' => array(
                'isPhone' => $test->isValidPhone('8 (915) 255-55-55')
            )
        ));
        return $this;
    }
}