
<?php
echo 'testger';
//include './Database.php'; 
// connect to the database
$servername = "localhost";
$username = "u202003176";
$password = "u202003176";
$dbname = "db202003176";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//$db= Database::getInstance();
//$conn=$db->connect();

// get the POST data
$article_id = $_POST['article_id'];
$is_like = $_POST['is_like'];
$count = $_POST['count'];


// update the likes or dislikes count in the database
if ($is_like) {
  $sql = "UPDATE Article SET NoLikes = $count WHERE ArticleID = $article_id";
  echo 'WIORKIUNG';
} else {
  $sql = "UPDATE Article SET NoDislike = $count WHERE ArticleID = $article_id";
  echo 'wolkrferjiung';
}
if (mysqli_query($conn, $sql)) {
  echo "Likes updated successfully.";
} else {
  echo "Error updating likes: " . mysqli_error($conn);
}

// close the database connection
mysqli_close($conn);
?>