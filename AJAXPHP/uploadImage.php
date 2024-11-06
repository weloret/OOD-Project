<?php //

include '../Database.php';
include '../Files.php';
include '../ArticleClass.php';
    
    $articleImage = $_FILES['articleImage'];
    $articleVideo = $_FILES['articleVideo'];
    $targetDir = "uploads/";
    
    $id = $_GET['id'];
    $img = $_POST["img"];
    
    echo 'test';
//        $file = new Files();
//        $file->setArticleID($id);
//        //$file->getNewArticleID();// && $articleImage['error'] === UPLOAD_ERR_OK
//        // && $articleImage['error'] === UPLOAD_ERR_OK
//        // Image file validation
//        echo $_FILES['articleImage'];
//        echo $_FILES['articleImage']['name'];
//        if (!empty($_FILES)) {
//            $imageFileType = strtolower(pathinfo($articleImage['name'], PATHINFO_EXTENSION));
//            $allowedImageTypes = array('jpg', 'jpeg', 'png', 'gif');
//
//            if (in_array($imageFileType, $allowedImageTypes)) {
//            
//                $article->setImage($articleImage);
//
//                $fileName = basename($_FILES["articleImage"]["name"]);
//                $file->setFileName($fileName);
//                $targetFilePath = $targetDir . $fileName;
//                $file->setFlocation($targetFilePath);
//                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
//                $file->setFileType($fileType);
//                
//                if(move_uploaded_file($_FILES["articleImage"]["tmp_name"], $targetFilePath)){
//                    
//                    if($file->addFile()){
//                        //echo 'im uploaded';
//                    }else{
//                        //echo 'im failed';
//                    }
//             }
//            
//        } else {
//            // Invalid image file type
//            // Handle the error or display a message to the user
//            //echo 'invalid image file type';
//        }
//    }else{
//        //echo'dwdfwdok';
//    }
    
    // Video file validation
//    if (isset($articleVideo) && $articleVideo['error'] === UPLOAD_ERR_OK) {
//        $videoFileType = strtolower(pathinfo($articleVideo['name'], PATHINFO_EXTENSION));
//        $allowedVideoTypes = array('mp4', 'avi', 'mov', 'wmv');
//        
//        if (in_array($videoFileType, $allowedVideoTypes)) {
//            $article->setVideo($articleVideo);
//            
//            
//            $fileName = basename($_FILES["articleVideo"]["name"]);
//            $file->setFileName($fileName);
//            $targetFilePath = $targetDir . $fileName;
//            $file->setFlocation($targetFilePath);
//            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
//            $file->setFileType($fileType);
//            
//             if(move_uploaded_file($_FILES["articleVideo"]["tmp_name"], $targetFilePath)){
//            // Insert image file name into database
////                 echo 'im moved <br>';
////                 echo $file->getAtricleID().'<br>';
////                 echo $file->getFileName().'<br>';
////                 echo $file->getFileType().'<br>';
////                 echo $file->getFlocation().'<br>';
//                 
//                if($file->addFile()){
//                    //echo 'im uploaded';
//                }else{
//                    //echo 'im failed';
//                }
//             }
//        } else {
//            // Invalid video file type
//            // Handle the error or display a message to the user
//            //echo 'invalid video file type';
//        }
//    }
//       // header("Location: dashboard.php");
//    } else {
//        //echo 'something went wrong';
//    }
    
    //echo 'if statement ran';
  