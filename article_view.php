<?php
//   TODO: MAKE THIS A LIST OF TOP VIEWED ARTICLES
//     Create variable to store query
//     loop through query while changing details based on it

//include 'Database.php';
include './ArticleClass.php';

$categoryID = urldecode($_GET['id']);

$db = Database::getInstance();
$dbc = $db->connect();

//determining if user is in dashboard or has clicked a category
if(isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['search'])){
    $categoryID = urldecode($_GET['id']);
    $searchQuery = urldecode($_GET['search']);

    $result = $db->querySQL("SELECT * FROM Article JOIN User ON Article.UserID = User.UserID "
            . "WHERE Article.Published = 1 AND Article.CategoryID = $categoryID "
            . "AND (Article.HeadLine LIKE '%$searchQuery%' OR User.UserName LIKE '%$searchQuery%' OR Article.ArticleText LIKE '%$searchQuery%')");
}
elseif (isset($_GET['startDate']) && isset($_GET['endDate']))
{
    $startDate = urldecode($_GET['startDate']);
    $endDate = urldecode($_GET['endDate']);
    $result = $db->querySQL("SELECT * FROM Article WHERE Published = 1 AND PublishDate BETWEEN '$startDate' and '$endDate' ORDER BY NoReaders DESC");
}
elseif (isset($_GET['recentNewsBtn'])) {
    // retrieve the most recent articles
    $result = $db->querySQL("SELECT * FROM Article WHERE Published = 1 ORDER BY PublishDate DESC");
}
elseif (isset($_GET['search'])) { 
    // search query is present in URL, retrieve articles matching search query

    $searchQuery = urldecode($_GET['search']);
    $result = $db->querySQL("SELECT * FROM Article LEFT JOIN User ON Article.UserID = User.UserID "
            . "WHERE Article.Published = 1 AND Article.HeadLine LIKE '%$searchQuery%' "
            . "OR User.UserName LIKE '%$searchQuery%' OR Article.ArticleText LIKE '%$searchQuery%'");
} else {
    // no search query in URL, determine if user is in dashboard or has clicked a category
    $categoryID = urldecode($_GET['id']);
    if(empty($categoryID)) {
        //should be sorted by views OR likes
        $result = $db->querySQL("SELECT * FROM Article WHERE Published = 1 ORDER BY NoReaders DESC");

    } else {
        $result = $db->querySQL("SELECT * FROM Article WHERE Published = 1 AND CategoryID = $categoryID ORDER BY NoReaders DESC");

    }
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
    
    $articles[] = $article;
        
    //Uncomment to find out what the query is returning
    //var_dump($row);
}  

?>

<section>
    <div class="d-flex p-1 justify-content-center">
        <h1 class="oldLondon fst-italic text-decoration-underline">Latest Article Releases</h1>
    </div>
    <div>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
              $(function() {
                $("#startDate").datepicker({
                  dateFormat: 'yy-mm-dd',
                  rangeSelect: true // enable date range selection
                });
                $("#endDate").datepicker({
                  dateFormat: 'yy-mm-dd',
                  rangeSelect: true // enable date range selection
                });
              });
            </script>
            <form class="d-flex col-12 justify-content-center align-items-center gap-2" dateRangeForm" method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="startDate">Start Date:</label>
                <input type="text" id="startDate" name="startDate" placeholder="Select Start Date: ">
                <label for="endDate">End Date:</label>
                <input type="text" id="endDate" name="endDate" placeholder="Select End Date: ">
                <input type="hidden" name="id" value="<?php echo $categoryID ?>">
                <button type="submit" id="dateRangeBtn">Search</button>
            </form>

            <script>
                // add event listener to button
                document.getElementById("dateRangeBtn").addEventListener("click", function() {
                  // retrieve start date
                  var startDate = document.getElementById("startDate").value;

                  if (startDate !== "") {
                    // add start date to URL
                    var url = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $categoryID ?>&startDate=" + startDate;

                    // set form action to new URL
                    document.getElementById("dateRangeForm").action = url;

                    // submit form withGET method
                    document.getElementById("dateRangeForm").submit();
                  }
                });
            </script>
  </div>
<?php
  
    echo '<div class= "col-12 row row-cols-1 row-cols-md-2 justify-content-around">';
    $counter=0;
    $darkbg=true;
    foreach ($articles as $article) {

        if($darkbg){

            echo '<div class="col-md-5 my-2 p-2 bg-grey border-0 rounded py-1 text-white ">'.
            '<article>' .
                '<h3 class="text-center playball mb-0 py-2">' . $article->getHeadLine() . '</h3><hr class="border-bottom border-1 mt-0 mb-2">' .
                '<div class="article-text text-overflow-clamp border-bottom px-1 pb-2 mb-2">' . $article->getArticleText() . '</div>' .
                '<div class="d-flex justify-content-center align-items-center px-2">'.
                    '<div class="d-flex col-8 gap-5 pt-2">'.
                        '<a class="link-light fst-italic" href="article.php?id='. $article->getArticleID(). '">Read more...</a>' .
                        $article->getPublishDate().
                        '<p> by <span class="fw-bold">'. $article->getArticleCreator() . '</span></p>' .
                    '</div>'.
                    '<div class="d-flex col-4 justify-content-around">'.
                        '<p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sunglasses" viewBox="0 0 16 16">
                        <path d="M3 5a2 2 0 0 0-2 2v.5H.5a.5.5 0 0 0 0 1H1V9a2 2 0 0 0 2 2h1a3 3 0 0 0 3-3 1 1 0 1 1 2 0 3 3 0 0 0 3 3h1a2 2 0 0 0 2-2v-.5h.5a.5.5 0 0 0 0-1H15V7a2 2 0 0 0-2-2h-2a2 2 0 0 0-1.888 1.338A1.99 1.99 0 0 0 8 6a1.99 1.99 0 0 0-1.112.338A2 2 0 0 0 5 5H3zm0 1h.941c.264 0 .348.356.112.474l-.457.228a2 2 0 0 0-.894.894l-.228.457C2.356 8.289 2 8.205 2 7.94V7a1 1 0 0 1 1-1z"/>
                        </svg>'.
                        $article->getNoReaders().
                        '</p><p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                        </svg>'.
                        $article->getNoLikes().
                        '</p><p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down-fill" viewBox="0 0 16 16">
                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                        </svg>'.
                        $article->getNoDislike().
                    '</p></div>'.
                '</div>'.
            '</article></div>'; 


        } else {
            echo '<div class="col-md-5 my-2 p-2 h-50 d-inline-block">'.
            '<article>' .

                '<h3 class="text-center playball mb-0 py-2">' . $article->getHeadLine() . '</h3><hr class="border-white border-1 mt-0 mb-2">' .
                '<div class="article-text text-overflow-clamp border-bottom px-1 pb-2 mb-2">' . $article->getArticleText() . '</div>' .
                '<div class="d-flex justify-content-center align-items-center">'.
                    '<div class="d-flex col-8 gap-5 pt-2">'.
                        '<a class="link-dark fst-italic" href="article.php?id='. $article->getArticleID(). '">Read more...</a>' .
                        $article->getPublishDate().
                        '<p> by <span class="fw-bold">'. $article->getArticleCreator() . '</span></p>' .
                    '</div>'.
                    '<div class="d-flex col-4 justify-content-around">'.
                        '<p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sunglasses" viewBox="0 0 16 16">
                        <path d="M3 5a2 2 0 0 0-2 2v.5H.5a.5.5 0 0 0 0 1H1V9a2 2 0 0 0 2 2h1a3 3 0 0 0 3-3 1 1 0 1 1 2 0 3 3 0 0 0 3 3h1a2 2 0 0 0 2-2v-.5h.5a.5.5 0 0 0 0-1H15V7a2 2 0 0 0-2-2h-2a2 2 0 0 0-1.888 1.338A1.99 1.99 0 0 0 8 6a1.99 1.99 0 0 0-1.112.338A2 2 0 0 0 5 5H3zm0 1h.941c.264 0 .348.356.112.474l-.457.228a2 2 0 0 0-.894.894l-.228.457C2.356 8.289 2 8.205 2 7.94V7a1 1 0 0 1 1-1z"/>
                        </svg>'.
                        $article->getNoReaders().
                        '</p><p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                        </svg>'.
                        $article->getNoLikes().
                        '</p><p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down-fill" viewBox="0 0 16 16">
                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                        </svg>'.
                        $article->getNoDislike().
                    '</p></div>'.
                '</div>'.
            '</article></div>'; 

        }
        $darkbg = !$darkbg;
        $counter = $counter+1;
        if($counter==2){
            $counter=0;
            $darkbg  = !$darkbg;
        }
    }
    
    echo '</div>';

      
?>
</section>