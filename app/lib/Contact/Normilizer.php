<?php
namespace Contact;

use Tools\Normilizer as BaseNormilizer;

class Normilizer extends BaseNormilizer {

    public function __construct()
    {
        parent::__construct();

        $this->setRules([
            /*firstname*/ 0  => Normilizer::UC_FIRST | Normilizer::NO_SPACES | Normilizer::AZSPACE_ONLY,
            /*lastname*/  1  => Normilizer::UC_FIRST | Normilizer::NO_SPACES | Normilizer::AZSPACE_ONLY,
            /*email*/     2  => 0,
            /*phone*/     3  => Normilizer::NUMBERS_ONLY,
            /*street*/    4  => 0,
            /*city*/      5  => 0,
            /*state*/     6  => Normilizer::STATE,
            /*job
                service*/ 7  => 0,
            /*price*/     8  => Normilizer::FLOAT_NUMBER,
            /*cycle in*/  9  => Normilizer::NUMBERS_ONLY,
            /*next job
                   date*/ 10 => 0,
        ]);
    }

}