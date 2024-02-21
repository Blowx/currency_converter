<?php

namespace application\models;

interface ParserInterface
{
    /**
     * Parse information
     *
     * @return mixed
     */
    public function parse();

    /**
     * Returns url for further parse from
     *
     * @return mixed
     */
    public function getUrlKey();
}
