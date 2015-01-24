<?php

namespace Dictionary;

class Dictionary  implements \ArrayAccess {

    protected $dictionary;

    /**
     *  Case insensitive
     */
    public function hasKey($string)
    {
        foreach (array_keys($this->dictionary) as $key) {
            if (strtolower($key) == strtolower($string)) {
                return true;
            }
        }

        return false;
    }

    public function getKeyByValueAndlevenshtein($string, $maxDistance)
    {
        foreach ($this->dictionary as $key => $value) {
            if (levenshtein(strtolower($string), strtolower($value)) <= $maxDistance) {
                return $key;
            }
        }

        return false;
    }

    public function offsetExists($offset)
    {
        return isset($this->dictionary[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->dictionary[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->dictionary[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->dictionary[$offset]);
    }

}