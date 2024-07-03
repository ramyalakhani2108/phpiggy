<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException, PDOStatement;

class Database
{
    private PDO $connection;
    private PDOStatement $stmt;
    public function __construct(string $driver, array $config, string $username, string $password)
    {
        //our database is mariaDB but mysql is compatible and mariadb has no individual driver
        $configuration = http_build_query(data: $config, arg_separator: ";"); //this will create configuration string
        $dsn = "{$driver}:{$configuration}"; //this will create valid DSN string for connecting with databases
        try {
            $this->connection = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
            // echo "we have connected with the database";
        } catch (PDOException $e) {
            die("Unable to connect Database");
        }
    }
    public function query(string $query, array $params = []): Database
    {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);

        return $this; //returning isntance to apply method chaining
    } //it is just to reduse the burden to write $db->connection->query($query)
    // firstly, it prevents the conneciton from being overridden
    //if we need to run different method, we're going to be force to define a method in our class to provide access to that method
    public function count()
    {
        return $this->stmt->fetchColumn();
    } //fetching a single result from the array

    public function find()
    {
        return $this->stmt->fetch();
    }

    public function id()
    {
        return $this->connection->lastInsertId();
    } //it gives last id inserted
}
