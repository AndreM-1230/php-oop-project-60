<?php

namespace Hexlet\Validator;

class Validator
{
    private $required, $minLength, $contains, $type, $isPositive, $range;

    function __construct()
    {
        $this->type = false;
        $this->required  = false;
        $this->minLength = false;
        $this->contains = false;
        $this->isPositive = false;
        $this->range = array();
    }
    function string()
    {
        $this->type = 'string';
        return new Validator();
    }

    function number()
    {
        $this->type = 'number';
        return new Validator();
    }

    function isValid($request)
    {
        $isValid = false;
        if ($this->required || (!$this->required && ($request === null || is_string($request)))) {
            $isValid = true;
        } else {
            $isValid = false;
        }
        if ($isValid && $this->minLength && ($request === null || is_string($request) || strlen($request) < $this->minLength)) {
            $isValid = false;
        }
        if ($isValid && $this->contains && ($request === null || is_string($request) || strpos($request, $this->contains) === false)) {
            $isValid = false;
        }
        $this->minLength = false;
        $this->contains = false;
        $this->isPositive = false;
        $this->range = array();
        return $isValid;
    }

    function required()
    {
        $this->required = true;
    }

    function contains(string $request)
    {
        $this->contains = $request;
    }

    function minLength(int $request)
    {
        $this->minLength = $request;
    }

    function positive()
    {
        $this->isPositive = true;
    }

    function range(int $a, int $b)
    {
        $this->range = [$a, $b];
    }
}