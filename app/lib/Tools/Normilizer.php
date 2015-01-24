<?php
namespace Tools;

use Dictionary\Dictionary;

class Normilizer {

    const NO_TRIM      = 1;
    const AZSPACE_ONLY = 2;
    const NO_SPACES    = 4;
    const NUMBERS_ONLY = 8;
    const STATE        = 16;
    const FLOAT_NUMBER = 32;
    const UC_FIRST     = 64;

    protected $rules = [];

    /*
     * atm may contain states for STATE normalization
     * @var array
    */
    protected $dictionaries = [];

    public function __construct() {}

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setDictionary($name, Dictionary $dictionary)
    {
        $this->dictionaries[$name] = $dictionary;
    }

    public function normilize(array $dataset)
    {
        foreach ($dataset as $i => $row) {
            foreach ($row as $j => $col) {
                $dataset[$i][$j] = $this->process($col, $this->rules[$j]);
            }
        }

        return $dataset;
    }

    protected function process($value, $flag)
    {
        if (!($flag & self::NO_TRIM)) {
            $value = trim($value);
        }

        if ($flag & self::NUMBERS_ONLY) {
            $value = $this->getNumbersOnly($value);
        }

        if ($flag & self::AZSPACE_ONLY) {
            $value = $this->getAZSpaceOnly($value);
        }

        if ($flag & self::FLOAT_NUMBER) {
            $value = $this->getFloatNumber($value);
        }

        if ($flag & self::UC_FIRST) {
            $value = $this->getUCFirst($value);
        }

        if ($flag & self::STATE) {
            $value = $this->getAZSpaceOnly(strtoupper($value));

            $value = $this->getState($value);
        }

        return $value;
    }

    protected function getNoSpace($value)
    {
        return str_replace(' ', '', $value);
    }

    protected function getNumbersOnly($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    protected function getAZSpaceOnly($value)
    {
        return preg_replace('/[^A-Za-z ]/', '', $value);
    }

    protected function getFloatNumber($value)
    {
        return preg_replace('/[^0-9\.]/', '', $value);
    }

    protected function getUCFirst($value)
    {
        return ucfirst($value);
    }

    protected function getState($value)
    {
        /** @var \Dictionary\Dictionary $states */
        $states = $this->dictionaries['states'];

        if (!$states->hasKey($value)) {
            $value = $states->getKeyByValueAndlevenshtein($value, 2);
        }

        return strtoupper($value);

    }
}