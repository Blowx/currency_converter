<?php

namespace application\models;

interface ParserInterface
{
    public function parse();

    public function getUrlKey();
}
