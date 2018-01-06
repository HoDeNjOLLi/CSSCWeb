<?php

namespace App;

class Model
{
    protected $dbConnection;

    /* @var $dbConnection \PDO */

    function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    function initDB()
    {
        $this->dbConnection->exec(
            "CREATE TABLE IF NOT EXISTS blogItems (
            id INTEGER PRIMARY KEY,
            title TEXT,
            blogText TEXT,
            publishDate TEXT,
            imageID TEXT)");
    }

    function getBlogPosts()
    {
        $result = $this->dbConnection->query(
            'SELECT * FROM blogItems');
        $data = [];
        foreach ($result as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function addItem($item)
    {
        // Prepare INSERT statement to SQLite3 file db
        $insert = "INSERT INTO blogItems
                  (title, publishDate, blogText,imageID)
                    VALUES (:title, :publishDate, :blogText, :imageID)";
        $stmt = $this->dbConnection->prepare($insert);

        // Bind parameters to values
        $stmt->bindParam(':title', $item['title']);
        $stmt->bindParam(':publishDate', $item['publishDate']);
        $stmt->bindParam(':blogText', $item['blogText']);
        $stmt->bindParam(':imageID', $item['imageID']);


        // Execute statement
        $stmt->execute();
    }

    function addUser($user)
    {
        // Prepare INSERT statement to SQLite3 file db
        $insert = "INSERT INTO users
                  (username, password)
                    VALUES (:username, :password)";
        $stmt = $this->dbConnection->prepare($insert);

        // Bind parameters to values
        $stmt->bindParam(':username', $user['username']);
        $stmt->bindParam(':password', $user['password']);


        // Execute statement
        $stmt->execute();
    }

    //TODO wie Nutzer definieren? ID ?
    function addCredit($user,$credit)
    {
        // Prepare INSERT statement to SQLite3 file db
        $insert = "UPDATE users SET credit WHERE username = $user
                    VALUES (:credit)";
        $stmt = $this->dbConnection->prepare($insert);

        // Bind parameters to values
        $stmt->bindParam(':credit', $user['credit']);


        // Execute statement
        $stmt->execute();
    }

}