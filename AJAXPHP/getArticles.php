<?php

include '../Database.php';
include '../ArticleClass.php';

$q = urldecode($_GET['q']);
$pub = urldecode($_GET['pub']);

$db = Database::getInstance();
$dbc = $db->connect();

//determining if user is in dashboard or has clicked a category
if($q == '') {
    $result = $db->querySQL("SELECT * FROM Article WHERE Published = $pub");
} else {//Make this work with author, will need to do complex query
    $result = $db->querySQL("SELECT * FROM Article WHERE (HeadLine LIKE '%$q%' OR ArticleText LIKE '%$q%') AND Published = $pub"); 
}
if ($result) {
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {        
        // Process the results
    } else {
        echo "No results found.";
    }
} else {
    echo "Error executing query: " . mysqli_error($dbc);
}

$table = '';
$table .= '<ul class="table col-4 table-hover list-unstyled">';

foreach ($result as $row) {
    
    $article = new Article();
    $article->setArticleID($row['ArticleID']);
    $article->setHeadLine($row['HeadLine']);
    $article->setArticleText($row['ArticleText']);
    $article->setPublishDate($row['PublishDate']);
    $article->setPublished($row['Published']);
    $article->setNoReaders($row['NoReaders']);
    $article->setNoLikes($row['NoLikes']);
    $article->setNoDislike($row['NoDislike']);
    $article->setCategoryID($row['CategoryID']);
    $article->setUserID($row['UserID']);
    
    $table .= '<li onclick="showArticleControls('.$article->getArticleID().');">' .
                '<div class="d-flex flex-column mb-4">'.
                '<h4 class="text-center">' . $article->getHeadLine() . '</h4>' .
                '<p class="dashboard-article-text">' . $article->getArticleText() . '</p>' .
                '</div>'.
            '</li>';
}

$table .= '</ul>';

echo $table;

                