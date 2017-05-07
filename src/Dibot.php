<?php

namespace dibot;

class Dibot
{
    private $mapper;

    public function __construct($mapper)
    {
        $this->mapper = $mapper;
    }


    public function getMapper()
    {
        return $this->mapper;
    }
}
