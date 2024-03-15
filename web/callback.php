<?php

//require_once __DIR__ . '/../vendor/autoload.php';
//
//use Lcobucci\JWT\Encoding\CannotDecodeContent;
//use Lcobucci\JWT\Encoding\JoseEncoder;
//use Lcobucci\JWT\Token;
//use Lcobucci\JWT\Token\InvalidTokenStructure;
//use Lcobucci\JWT\Token\Parser;
//use Lcobucci\JWT\Token\UnsupportedHeaderFound;

//$request = json_decode('{"token":"eyJraWQiOiJlbG0iLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiIxMTA3NTIxMTA0IiwidHJhbnNJZCI6IjAzMWJmM2E5LTFlYzUtNGZhZS1hMjE3LTYwNzE5NjJmYTkzMCIsImlzcyI6Imh0dHBzOlwvXC9uYWZhdGguYXBpLmVsbS5zYSIsImF1ZCI6Imh0dHBzOlwvXC9uYWZpdGhoLnNhXC9uYWZhdGhcL2NhbGxiYWNrIiwibmF0aW9uYWxpdHlDb2RlIjoiMTEzIiwibmJmIjoxNjk2NDk2MTYwLCJQZXJzb25JZCI6MTEwNzUyMTEwNCwiU2VydmljZU5hbWUiOiJSZWNpcGllbnRBcHByb3ZhbFdpdGhvdXRCaW8iLCJqd2tzX3VyaSI6Imh0dHBzOlwvXC9uYWZhdGguYXBpLmVsbS5zYVwvYXBpXC92MVwvbWZhXC9qd2siLCJleHAiOjE2OTY0OTYzMTAsImlhdCI6MTY5NjQ5NjE2MCwianRpIjoiNGQ3MzZkNTktZmUxMy00MTA1LTk0MDYtYjc5ZjhiNWViODU0Iiwic3RhdHVzIjoiQ09NUExFVEVEIn0.HGuJi7fwUJ_0f25qW_PvNCuooVhqccP1XmKMWpBnAAbMzW7nNjr6wXHnHt_QaZcAhiKKjrTx0cryCfIXRkfrpJL7B_HEF6tHPBNWRwuMNhx8MIKeoEPh26PUUUCFoKlCehNLHms5-so75xOwhdz5NQYRzy1bfRp2LYy2tplH9KNoPcmq6FEil2gGtTEeJFETL2hD8ZPYph-KH4ed_sXnYS8Fmhwn_OZgKUBBoHEMIDNUzNAdY7qoKSayDaIuErMW7M3HU2jcpsrJbkGDc3X6-PuVGZSseyOTA4XQeyWKSjo79TGvryox8qXSHBny5IJQZRj-l4lTVJW8odiHpO79Xg","transId":"0f191613-aa2e-48ac-b406-e603da65d705","requestId":"4d736d59-fe13-4105-9406-b79f8b5eb854"}', true);

$request = file_get_contents('php://input');
$request = json_decode($request, true);

//$parser = new Parser(new JoseEncoder());
//
//try {
//
//    $token = $parser->parse($request['token']);
//
//} catch (CannotDecodeContent|InvalidTokenStructure|UnsupportedHeaderFound $e) {
//    return false;
//}
//
//// Access claims from the token
//$data = $token->claims();

//echo "<pre>";
//var_dump($data->get('transId'));
//echo "</pre>";

var_dump($request['transId']);

try {
    $db = new \PDO("mysql:host=localhost;dbname=nafit", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $transId = $request['transId']; // Replace with the new value
    $idToUpdate = 1; // Replace with the ID of the row to update

    $stmt = $db->prepare("UPDATE user SET nafath_validated = 1 WHERE transId = :transId");
    $stmt->bindParam(":transId", $transId);
    $stmt->execute();

    echo "Update successful!";

} catch(\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}