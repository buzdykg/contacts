<?php
namespace Tools;

class Validator {

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $dictionaries = [];

    public function __construct() {}

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function setDictionary($name, \Dictionary\Dictionary $dictionary)
    {
        $this->dictionaries[$name] = $dictionary;
    }

    public function validate($dataset)
    {
        foreach ($dataset as $i => $row) {
            $hard_failures = [];
            foreach ($row as $j => $column) {
                if ($this->process($column, $this->rules[$j]) === false) {
                    $hard_failures[] = $j;
                }
            }

            if (count($hard_failures)) {
                $dataset[$i][count($this->rules)] = $hard_failures;
            }
        }

        return $dataset;
    }

    protected function process($value, $rules)
    {
        $rules = explode('|', $rules);
        $result = true;

        foreach ($rules as $rule) {
            $rule = explode(':', $rule);
            $vars = [$value];

            if (isset($rule[1]) && $rule[1]) {
                $vars[] = $rule[1];
            }
            if (!$rule[0]) {
                continue;
            }

            $result &= call_user_func_array([$this, $rule[0]], $vars);
        }

        return (bool) $result;
    }

    protected function required($val)
    {
        return (bool) $val;
    }

    protected function capitilized($val)
    {
        return preg_match('/^[A-Z]{1}[a-z]{1,100}$/', $val);
    }

    protected function email($val)
    {
        return filter_var($val, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function number_string($val)
    {
        return preg_match('/^[0-9]{1}.*$/', $val);
    }

    protected function dictionary($val, $dictionary_name)
    {
        if (!isset($this->dictionaries[$dictionary_name])) {
            throw new \Exception("You must set up '$dictionary_name' in order to use ->dictionary() validation");
        }

        $dic = $this->dictionaries[$dictionary_name];

        return isset($dic[$val]);
    }

    protected function float($val)
    {
        return preg_match('/^[0-9]*\.[0-9]{1,5}$/', $val);
    }

    protected function integer($val)
    {
        return preg_match('/^[0-9]*$/', $val);
    }

    protected function future($val)
    {
        $now = time();
        $then= strtotime($val);

        return ($then !== false || $then != -1) && $then > $now;
    }

    protected function exact_length($val, $length)
    {
        return strlen($val) === (int) $length;
    }
}