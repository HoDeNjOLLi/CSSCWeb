<?php
/**
 * Created by PhpStorm.
 * User: hojoe
 * Date: 18.12.2017
 * Time: 18:44
 */

namespace App;

class Model {
    protected $dbConnection;


    function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }



    function returnData($var)
    {
        $data = [];
        foreach ($var as $row) {
            $data[] = $row;
        }
        return $data;
    }



}

