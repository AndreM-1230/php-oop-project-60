<?php

namespace Hexlet\Validator;

class Validator
{
    private $required, $minLength, $contains, $type, $isPositive, $range, $sizeof;

    function __construct($type = false)
    {
        $this->type = $type;
        $this->required  = false;
        $this->minLength = false;
        $this->contains = false;
        $this->isPositive = false;
        $this->range = false;
        $this->sizeof = false;
    }

    function string()
    {
        return new Validator('string');
    }

    function number()
    {
        return new Validator('number');
    }

    function array()
    {
        return new Validator('array');
    }

    function isValid($request)
    {
        $isValid = false;
        switch ($this->type)
        {
            case 'string':
                $isValid = ($this->minLength === false || ($this->minLength && is_string($request) && strlen($request) >= $this->minLength))
                    && ($this->contains === false || ($this->contains && is_string($request) && strpos($request, $this->contains) !== false))
                    && ((($request === null || $request == '') && !$this->required) || $request) ? true : false;
                break;
            case 'number':
                $isValid = (($request === null && !$this->required) || $request !== null)
                    && (($this->isPositive && $request > 0) || !$this->isPositive)
                    && (($this->range && $request >= $this->range[0] && $request <= $this->range[1]) || $this->range === false) ? true : false;
                break;
            case 'array':
                $isValid = (($request === null && !$this->required) || is_array($request))
                    && ($this->sizeof === false || ($this->sizeof && is_array($request) && count($request) == $this->sizeof)) ? true : false;
                break;
        }
        return $isValid;
    }

    function required()
    {
        $this->required = true;
        if ($this->type == 'array') {
            return $this;
        }
    }

    function contains(string $request)
    {
        $this->contains = $request;
        return $this;
    }

    function minLength(int $request)
    {
        $this->minLength = $request;
        return $this;
    }

    function positive()
    {
        $this->isPositive = true;
        return $this;
    }

    function range(int $a, int $b)
    {
        $this->range = [$a, $b];
        return $this;
    }

    function sizeof(int $request)
    {
        $this->sizeof = $request;
        return true;
    }
}