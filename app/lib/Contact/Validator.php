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
            /*zip code*/  7  => 'required|integer|exact_length:5',
            /*job
                service*/ 8  => 'required',
            /*price*/     9  => 'float',
            /*cycle in*/  10  => 'integer',
            /*next job
                   date*/ 11 => 'future',
        ]);
    }
}