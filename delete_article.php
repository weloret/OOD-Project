<?php
include 'header.php';
include 'ArticleClass.php';

$uid = urldecode($_GET['id']);
$article = new Article();
$thisArticle = $article->read_single($uid);
$thisArticle->delete();
echo'testing2';
header("Location: dashboard.php");

?>