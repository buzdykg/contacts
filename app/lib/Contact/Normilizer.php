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
            /*zip code*/  7  => Normilizer::NUMBERS_ONLY,
            /*job
                service*/ 8  => 0,
            /*price*/     9  => Normilizer::FLOAT_NUMBER,
            /*cycle in*/  10  => Normilizer::NUMBERS_ONLY,
            /*next job
                   date*/ 11 => 0,
        ]);
    }

}