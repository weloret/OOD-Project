<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$id = $_GET['id'];

include "../Database.php";
include "../ArticleClass.php";
include '../user.php';
include '../Files.php';

$db = Database::getInstance();
$dbc = $db->connect();

$user = new User();
$user->initWithUid($_SESSION['UserID']);

$thisArticle = new Article();
if($id > 0) {
    $article = $thisArticle->read_single($id);
} else {
    $article = new Article;
    $article->setPublished(0);
}


$boolPublished = '';
//disable publish button if article published already
if($article->getPublished() == 1) {
    $boolPublished = 'disabled';
} else {
    $boolPublished = '';
}

//to get the list of categories from the database
$result = $db->querySQL('SELECT * FROM Category');
$list = "";

if ($result) {
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) 
    {
        foreach ($result as $row) 
        {
            //echo $row;
            if ($article->getCategoryID() == $row['CategoryID']) 
            {
                $list .= '<option selected value="'.$row['CategoryID'].'">'.$row['CategoryName'].'</option>"></li>';
            } 
            else 
            {
                $list .= '<option value="'.$row['CategoryID'].'">'.$row['CategoryName'].'</option>"></li>';
            }
        }
    } 
    else 
    {
        echo "No results found.";
    }     
} 
else 
{
    echo "Error executing query: " . mysqli_error($dbc);
}
if($id > 0){
    
    $img = '';
    $video = '';
    $imgFile = null;
    $vidFile = null;
    
    $article->read_single($id);
    $file = new Files();
    $file->setArticleID($article->getArticleID());
    $imgFile = $file->getArticleImage();
    $vidFile = $file->getArticleVideo();

    if ($imgFile != null) {
        $img = $imgFile->getFlocation().$imgFile->getFileName();
    }
    
    if ($vidFile != null) {
        $video = $vidFile->getFlocation().$vidFile->getFileName();
    }
    
    
    $id = $article->getArticleID();
    $title = $article->getHeadLine();
    $text = $article->getArticleText();
    $published = $article->getPublished();
    $articleCreator = $article->getArticleCreator();
    $publishDate = $article->getPublishDate();
    
    echo '   
        <div class="d-flex flex-column gap-3 my-5 mx-2">
            <div class="d-flex justify-content-around">  <span class="fw-bold">'.$articleCreator.'</span> '.$publishDate.' </div>
            <div class="form-group">
              <input type="text" class="form-control" id="articleTitle" placeholder="Article Title" value="'.$title.'">
            </div>
            <div class="form-group">
              <textarea class="form-control" id="articleText" placeholder="Article Text" rows="15">'.$text.'</textarea>
            </div>
            <div class="form-group">
              <select class="form-control" id="articleCategory">
                '.$list.'
              </select>
            </div>
            <div class="d-flex col-12">
                <div class="col-6" id="imgUpload">
                    <label for="articleImage" class="btn">Select Image</label>
                    <form method="post">
                        <input type="file" style="visibility:hidden;" class="form-control" id="articleImage" value="">
                        <button id="imgSaveButton" class="col btn btn-secondary btn-block mb-4" type="submit" onclick="uploadImage('.$id.', articleImage.value)">Upload Image</button>
                    </form>
                    <div class="form-group">
                      <img src="'.$img.'">
                    </div>
                </div>
                <div class="form-group col-6">
                    <label for="articleVideo" class="btn">Select Video</label>
                    <input type="file" style="visibility:hidden;" class="form-control" id="articleVideo" placeholder="Video" value="">
                    <button id="vidSaveButton" class="col btn btn-secondary btn-block mb-4" type="submit" onclick="uploadImage('.$id.')">Upload Video</button>
                    <video width="100%" controls>
                        <source src="" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="d-flex row gap-5 mx-0">    
                <button id="saveButton" class="col btn btn-secondary btn-block mb-4" type="submit"
                onclick="updateArticle('.$id.', articleTitle.value, articleText.value, 0, articleCategory.value)">Save draft</button>
                <button class="col btn btn-primary btn-block mb-4" type="submit" '.$boolPublished.'
                onclick="updateArticle('.$id.', articleTitle.value, articleText.value, 1, articleCategory.value)">Publish</button>
            </div>
            <div class="d-flex justify-content-end" id="changes"></div>
        </div>
     ';
    
} else {
    
    echo '   
        <form class="d-flex flex-column gap-3 my-5 mx-2" id="edit_form">
            <div class="d-flex justify-content-around">  <span class="fw-bold">'.$user->getUsername().'</span> '.date("Y-m-d").'</div>
            <div class="form-group">
              <input type="text" class="form-control" id="articleTitle" placeholder="Article Title" value="" />
            </div>
            <div class="form-group">
              <textarea class="form-control" id="articleText" placeholder="Article Text" rows="15" ></textarea>
            </div>
            <div class="form-group">
              <select class="form-control" id="articleCategory">
                '.$list.'
              </select>
            </div>
            <div class="d-flex row gap-5 mx-0">
                <button id="saveButton" class="col btn btn-secondary btn-block mb-4" type="submit"
                onclick="updateArticle(0, articleTitle.value, articleText.value, 0, articleCategory.value)">Save as draft</button>
                <button class="col btn btn-primary btn-block mb-4" type="submit" '.$boolPublished.'
                onclick="updateArticle(0, articleTitle.value, articleText.value, 1, articleCategory.value)">Publish</button>
            </div>
            <div class="form-group">
              <input type="file" class="form-control" id="articleImage" placeholder="Image" value="">
            </div>
            <div class="form-group">
              <input type="file" class="form-control" id="articleVideo" placeholder="Video" value="">
            </div>
            <div class="d-flex justify-content-end" id="changes"></div>
        </form>
     ';
}