<?php
// this file is to automatically update and create database
// echo "hello";
//we are connecting with database using DSN and PDO

// DSN String 
include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/src/Framework/Database.php";

use App\Config\Paths;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

use Framework\Database;

$db = new Database($_ENV['DB_DRIVER'], [
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'dbname' => $_ENV['DB_NAME']
], $_ENV['DB_USER'], $_ENV['DB_PASS']);


$sqlFile = file_get_contents("./database.sql");

$db->query($sqlFile); //created the tables


















// try {
//     $db->connection->beginTransaction();
//     $db->connection->query("INSERT INTO products VALUES(16,'HandCuffs')");

//     $search = "Hat";
//     $query = "SELECT * from products where productName=:name";
//     // $stmt = $db->connection->query($query, PDO::FETCH_BOTH); //it is the default mode it will return both numeric and column name
//     // $stmt = $db->connection->query($query, PDO::FETCH_NUM); //it is the numeric mode it will return  numeric  key
//     // $stmt = $db->connection->query($query, PDO::FETCH_ASSOC); //it is the named mode it will return  column name key  
//     // $stmt = $db->connection->query($query, PDO::FETCH_ASSOC); //it is the named mode it will return  column name key  

//     // using prepared statements
//     $stmt = $db->connection->prepare($query);
//     $stmt->bindValue('name', 'HandCuffs', PDO::PARAM_STR);
//     $stmt->execute(); //it validates to prevent sql injection
//     $db->connection->commit();
//     var_dump($stmt->fetchAll(PDO::FETCH_OBJ));
// } catch (Exception $e) {
//     if ($db->connection->inTransaction()) {
//         $db->connection->rollBack(); //trascation changes are revert backed before commit
//     }
//     echo "transaction failed";
// }
