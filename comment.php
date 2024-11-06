<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class Comment {
    private $CommentID;
    private $CommentText;
    private $CommentDate;
    private $ArticleID;
    private $UserID;
    private $conn;
    
    public function __construct() {
        $this->CommentID = null;
        $this->CommentText = null;
        $this->CommentDate = null;
        $this->ArticleID = null;
        $this->UserID = null;
    }
    
    public function getCommentID() {
        return $this->CommentID;
    }

    public function getCommentText() {
        return $this->CommentText;
    }

    public function getCommentDate() {
        return $this->CommentDate;
    }

    public function getArticleID() {
        return $this->ArticleID;
    }

    public function getUserID() {
        return $this->UserID;
    }

    public function setCommentID($CommentID) {
        $this->CommentID = $CommentID;
    }

    public function setCommentText($CommentText) {
        $this->CommentText = $CommentText;
    }

    public function setCommentDate($CommentDate) {
        $this->CommentDate = $CommentDate;
    }

    public function setArticleID($ArticleID) {
        $this->ArticleID = $ArticleID;
    }

    public function setUserID($UserID) {
        $this->UserID = $UserID;
    }
    
    function insertComment()
    {
        $db = Database::getInstance();
        $db->connect();
        $this->conn = $db->getDBCon();
//    debugging line    echo 'test line 177<br>';
        
        // Create query
        $query = "INSERT INTO Comment(CommentID, CommentText,".
            "CommentDate, ArticleID, UserID)".
            "VALUES (NULL, ?, NOW(), ?, ?)";

        // Prepare statement
        try {
        $stmt = $this->conn->prepare($query);
            // Rest of the code
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        // Bind data
        $stmt->bind_param("sii", $this->CommentText, $this->ArticleID, $this->UserID);
        
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete($id) {
        
        $this->setCommentText('Comment removed by admin.');
        
        $db = Database::getInstance();
        $db->connect();
        $this->conn = $db->getDBCon();
//    debugging line    echo 'test line 177<br>';
        // Create query
        $query = "UPDATE Comment SET CommentText = 'Comment removed by admin.',".
            " CommentDate = NOW() WHERE CommentID = ?";

        // Prepare statement
        try {
        $stmt = $this->conn->prepare($query);
            // Rest of the code
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
//        echo 'test line 189<br>';
//        echo 'test line 211<br>';
        // Bind data
        $stmt->bind_param("i", $id);
        
        
        // Execute query
        if($stmt->execute()) { 
            echo $this->CommentText;
            return true;
        } else {
            echo 'error: ' . $stmt->error_list . '<br>';
            return false;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
    
    function intWithCid($cid) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Comment WHERE CommentID = ' . $cid);
        $this->initWith($data->CommentID, $data->CommentText, $data->CommentDate, $data->ArticleID, $data->UserID);
    }
    
    function initWithArticleID() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Comment WHERE ArticleID = \'' . $this->ArticleID . '\'');
        if ($data != null) {
            return false;
        }
            return true;
    }
    
    function initWith($cid, $commenttext, $commentdate, $articleid, $userid){
        $this->CommentID = $cid;
        $this->CommentText = $commenttext;
        $this->CommentDate = $commentdate;
        $this->ArticleID = $articleid;
        $this->UserID = $userid;
    }

    public function getAllComments($articleId) {
        $db = Database::getInstance();
        $dbc = $db->connect();
        
        $result = $db->querySQL("SELECT * FROM Comment WHERE ArticleID = $articleId");
        foreach ($result as $row) {
            $comment = new Comment();
            $comment->setArticleID($row['ArticleID']);
            $comment->setCommentDate($row['CommentDate']);
            $comment->setCommentID($row['CommentID']);
            $comment->setCommentText($row['CommentText']);
            $comment->setUserID($row['UserID']);
//            $article->setArticleID($row['ArticleID']);

            $comments[] = $comment;

            //Uncomment to find out what the query is returning
            //var_dump($row);
        }
        
        return $comments;
    }
    
    public function getCommentCreator() 
    {
        $db = Database::getInstance();
        $db->connect();
        $this->conn = $db->getDBCon();
        
        if ($sql = $this->conn->prepare("SELECT User.UserName FROM Comment JOIN User ON Comment.UserID = User.UserID WHERE Comment.UserID = ?"))
        {
            $sql->bind_param("i", $this->UserID);
            $sql->execute();
            $sql->bind_result($userName);
            $sql->fetch();
            return $userName;
        } 
        else 
        {
            echo "Failed to prepare statement: " . $this->conn->error;
            return false;
        }   
    }
}