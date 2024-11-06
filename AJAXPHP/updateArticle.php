<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include "../Database.php";
include "../ArticleClass.php";
include '../Files.php';
session_start();

$id = urldecode($_GET['id']);

$thisArticle = new Article();

if ($id > 0) {

    $article = $thisArticle->read_single($id);
    $article->setHeadLine($_GET['headline']);
    $article->setArticleText($_GET['text']);
    $article->setPublished($_GET['published']);
    $article->setCategoryID($_GET['catid']);
    $article->setArticleID($id);
    
    
    
    $article->edit();

    echo '<h1>Article '.$_GET['headline'].'" has been successfully updated!</h1>';
} 
else 
{
    $article = new Article();
    $article->setHeadLine($_GET['headline']);
    $article->setArticleText($_GET['text']);
    $article->setPublished($_GET['published']);
    $article->setCategoryID($_GET['catid']);
    $article->setUserID($_SESSION['UserID']);
    
    if ($article->getPublished() == 0) {
        echo '<h1>Article '.$_GET['headline'].'" has been published!</h1>';
    } else {
        echo '<h1>Article '.$_GET['headline'].'" has been saved as draft!</h1>';
    }
}
