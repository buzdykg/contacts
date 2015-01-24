<?php
namespace Contact;

use Tools\Validator as BaseValidator;

class Validator extends BaseValidator {

    public function __construct()
    {
        parent::__construct();
        $this->setRules([
            /*firstname*/ 0  => 'capitilized|required',
            /*lastname*/  1  => 'capitilized|required',
            /*email*/     2  => 'email',
            /*phone*/     3  => 'integer|required',
            /*street*/    4  => 'number_string',
            /*city*/      5  => '',
            /*state*/     6  => 'dictionary:states',
            /*job
                service*/ 7  => 'required',
            /*price*/     8  => 'float',
            /*cycle in*/  9  => 'integer',
            /*next job
                   date*/ 10 => 'future',
        ]);
    }
}