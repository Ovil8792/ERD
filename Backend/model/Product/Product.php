<?php

namespace erd\Backend\model;
use  erd\core\model\connector;
use erd\core\model\db;
class Product extends connector{
    protected static $conn;
    protected $db = new db("user");
    public function __construct(){
       $this->conn = parent::conn();
    }
    public function get(){
        $this->db->get();
    }
}