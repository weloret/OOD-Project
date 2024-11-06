<?php
    session_start();
    include 'header.php';
    //include './Database.php';
    include './user.php';
    include 'ArticleClass.php';
    include 'comment.php';
    $article = new Article();
    $id = urldecode($_GET['id']);
    
    $thisArticle = $article->read_single($id); 
    $text = $thisArticle->getArticleText();
    $title = $thisArticle->getHeadLine();
    
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $comment = new Comment();
        $comment->setArticleID($id);
        $comment->setCommentDate(date("Y-m-d"));
        $comment->setCommentText($_POST['review']);
        $comment->setUserID($_SESSION['UserID']);
        $comment->insertComment();
        
    }
    if($_SESSION['UserID'] == null)
    {
        $hide = 'style="display:none;"';
        
    }
    
    $_SESSION['pageCounter'] = $thisArticle->getNoReaders();
    $_SESSION['pageCounter']++;
    $thisArticle->increasePageCount();
?>
<html>
    
<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  
<!--  <script>
    function likeDislikeCounter(button) {
  let likes = parseInt(button.nextElementSibling.innerHTML);
  likes++;
  button.nextElementSibling.innerHTML = likes;
  button.disabled = true; // disable the button after it has been clicked
  // send AJAX request to update the database
  // ...
  document.getElementById("articleLike").innerHTML = likes;
}
  </script>-->
  <script>
      
   $(document).ready(function(){
        $("article:odd").addClass("bg-light");     
    });
      
  function likeDislikeCounter(button) {
    let isLike = button.classList.contains("like-button") ? 1 : 0;
    let likes = parseInt(button.nextElementSibling.innerHTML) + 1;
    button.nextElementSibling.innerHTML = likes;
    button.disabled = true;

    $.ajax({
      type: "POST",
      url: "updateLikes.php",
      data: {
        article_id: <?php echo $id;?>, // replace with the actual ID of the article
        is_like: isLike,
        count: likes
      },
      success: function(response) {
        console.log("Likes updated successfully. 2.0");
      },
      error: function(xhr, status, error) {
        console.error("Failed to update likes: " + error);
      }
    });
  }
  
  function deleteComment(id) {
  
        if (confirm("Are you sure you want to delete this comment?")) 
        {
            xmlhttp = new XMLHttpRequest();

            xmlhttp.open("GET", "AJAXPHP/deleteComment.php?id=" + id, true);
            xmlhttp.send();
            
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("comment-" + id).innerHTML = xmlhttp.responseText;
                }
            }
        }
    }
  
</script>
      
</head>

<body>
  <main>
    <div class="row">
        <header class="col-12 article-header text-center pt-5">
            <h2 class="display-4"><?php echo $title; ?></h2>
          <p class="meta"><?php echo $thisArticle->PublishDate;?> by <?php echo $thisArticle->getArticleCreator();?></p>
          <p class="meta">View count: <?php echo $thisArticle->getNoReaders();?></p>
        </header>
        <article>   
            <div class="row center">
                <div class="col-1 padding"></div>
                <div class="content col-10 center">
                    <p class="article-text">
                        <img class="img m-4 rounded float-end " src="https://via.placeholder.com/500x300" alt="Article Image">
                        <?php echo $text; ?>
                    </p>
                    <br>
        <!--          <video src="https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_640_3MG.mp4"
                         controls></video><! if there is a video run this line, otherwise keep hidden -->
                </div>
                <div class="col-1 padding"></div>
            </div>
        </article>
        
      <!-- LIKE/DISLIKE FOR ARTICLE -->
      <div class="row">
        <div class="d-flex justify-content-end">
            
            <div class="col-2 d-flex justify-content-around pt-5" <?php echo $hide;?>>
                <div>
                    <button class="like-button" onclick="likeDislikeCounter(this)">Like</button>
                    <span id="article-likes"><?php echo $thisArticle->NoLikes; ?></span>
                </div>
                <div>
                    <button class="dislike-button" onclick="likeDislikeCounter(this)">Dislike</button>
                    <span id="article-dislikes"><?php echo $thisArticle->NoDislike; ?></span>
                </div>
            </div>
            <div class="col-1 padding"></div>
        </div>
          
          <hr class="mt-4">
          
        <!-- COMMENT SECTION AND LEAVING REVIEWS -->
        <div class="row col-12">
            
            <h3 class="text-center p-2">Comment section</h3>
            <div class="col-2 padding"></div>
            <ul class="comment-list col-8" style="list-style-type: none;">
              <?php 
                
                $hidden = '';
                
                if($_SESSION['RoleID'] != 3){
                    $hidden = 'style="display: none;"';
                } else {
                    $hidden = '';
                }
              
                $comment = new Comment();
                $comments = $comment->getAllComments($id);
                foreach ($comments as $comm)
                {
                    $commentCreator = $comm->getCommentCreator();
                    $date = $comm->getCommentDate();
                    $text = $comm->getCommentText();
                    $commID = $comm->getCommentID();

                    echo "<li>
                            <article class=\"comment rounded border-bottom mb-4\">
                                <header>
                                    <div class=\"d-flex pt-2 pb-2 col-4 justify-content-around align-items-center\">
                                        <h5 class=\"text-center mr-auto col-2 fw-bold\">$commentCreator</h4>
                                        <time class=\"\" datetime=\"$date\">$date</time>
                                    </div>
                                </header>
                                <div class=\"d-flex py-2 justify-content-between align-items-center\">
                                    <p id=\"comment-$commID\" class=\"p-3\">$text</p>
                                    <button class=\"col-1 btn btn-danger m-3\" $hidden onclick=\"deleteComment($commID)\">Delete</button>
                                </div>
                            </article>
                          </li>";
                }
              ?>
            </ul>
            <div class="col-2 padding"></div>

            <!-- HIDE WITH PHP UNTIL USER LOGS IN -->
            <div <?php echo $hide;?>>
                <form class="d-flex justify-content-center gap-5 align-items-center bg-light py-4" method="POST">
                    <h3>Leave a Review</h3>
                    <textarea class="form-control w-50 col-1" id="review" name="review" rows="4" cols="50" required></textarea>
                    <input class="btn btn-light btn-lg" type="submit" value="Submit">
                </form>
            </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>