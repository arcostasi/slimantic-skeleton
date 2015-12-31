<?php

namespace App\Model;

/**
 * Base Model.
 *
 * @package App\Model
 */
class BaseModel
{
    protected $db;

    /**
     * Database Connect.
     *
     * @param $db
     */
    function __construct($db)
    {
        $this->db = $db;
    }
}