<?php
namespace libs;

class DB
{
    private static $_obj = null;
    private function clone(){}
    private $_pdo;
    private function __construct()
    {
        $this->_pdo = new \PDO("mysql:host=127.0.0.1;dbname=shop",'root','');
        $this->_pdo->exec('SET NAMES utf8');
    }   
    public static function make()
    {
        if(self::$_obj===null)
        self::$_obj = new self;
        return self::$_obj;
    }

    // 预处理
    public function prepare($sql)
    {
        return $this->_pdo->prepare($sql);
    }

    // 非预处理
    public function exec($sql)
    {
        return $this->_pdo->exec($sql);
    }
}