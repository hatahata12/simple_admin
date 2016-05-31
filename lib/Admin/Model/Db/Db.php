<?php
namespace Admin\Model\Db;

class Db
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    public function connect()
    {
        $db = $this->config['db.name'];
        $hostname = $this->config['db.host'];
        $user = $this->config['db.user'];
        $pass = $this->config['db.pass'];

        $pdo = new \PDO('mysql:host='.$hostname.';dbname='.$db.';charset=utf8',$user,$pass,
            array(\PDO::ATTR_EMULATE_PREPARES => false, \PDO::ATTR_PERSISTENT, true));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        return $pdo;
    }
}