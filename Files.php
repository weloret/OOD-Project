<?php

class Files {

    private $FileID;
    private $FileName;
    private $FileType;
    private $Flocation;
    private $ArticleID;
    
        function __construct() {
        
    }
    
    
    public function getFileID() {
        return $this->FileID;
    }

    public function getFileName() {
        return $this->FileName;
    }

    public function getFileType() {
        return $this->FileType;
    }

    public function getFlocation() {
        return $this->Flocation;
    }

    public function getArticleID() {
        return $this->ArticleID;
    }

    public function setFileID($FileID) {
        $this->FileID = $FileID;
    }

    public function setFileName($FileName) {
        $this->FileName = $FileName;
    }

    public function setFileType($FileType) {
        $this->FileType = $FileType;
    }

    public function setFlocation($Flocation) {
        $this->Flocation = $Flocation;
    }

    public function setArticleID($AtricleID) {
        $this->ArticleID = $AtricleID;
    }
    

    function deleteFile() {
        try {
            $db = Database::getInstance();
            $data = $db->querySql('Delete from files where fid=' . $this->FileID);
            unlink($this->Flocation);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    function initWithFid($fid) {

        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM files WHERE fid = ' . $fid);
        $this->initWith($data->FileID, $data->FileName, $data->Flocation, $data->FileType, $data->ArticleID);
    }

    function addFile() {
        $query = "INSERT into files(`fid`,`ArticleID`,`fname`,`flocation`,`ftype`) VALUES(null,$this->ArticleID,'$this->FileName','$this->Flocation','$this->FileType') ";
        try {
            $db = Database::getInstance();
        $dbc = $db->connect();
        $result = $db->querySQL($query); 
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

//    private function initWith($fid, $fname, $flocation, $ftype, $uid) {
//        $this->fid = $fid;
//        $this->fname = $fname;
//        $this->flocation = $flocation;
//        $this->ftype = $ftype;
//        $this->uid = $uid;
//    }

    function updateDB() {

        $db = Database::getInstance();
        $data = 'UPDATE files set
			fname = \'' . $this->FileName . '\' ,
			ftype = \'' . $this->FileType . '\' ,
			flocation = \'' . $this->Flocation . '\' ,
                        ArticleID = ' . $this->ArticleID . '
				WHERE fid = ' . $this->FileID;
        $db->querySql($data);
    }

    function getAllFiles() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from files');
        return $data;
    }

    function insertfileGetID($articleID, $fname, $flocation, $ftype){
        
    }
    
    function getArticleImage() {
        $db = Database::getInstance();
        $dbc = $db->connect();
        $data = $db->querySQL("Select * from files where ArticleID = $this->ArticleID AND (ftype = 'jpg' OR "
                . "ftype = 'jpeg' OR ftype = 'png' OR ftype = 'gif')");
        if (mysqli_num_rows($data) > 0) {
            foreach($data as $row){
            $file = new Files();
        
            $file->setFileID($row['fid']);
            $file->setFlocation($row['flocation']);
            $file->setFileType($row['ftype']);
            $file->setArticleID($row['ArticleID']);
            $file->setFileName($row['fname']);
        
            return $file;
            }
        } else {
            return '';
        }
        
        
    }
    
    function getArticleVideo() {
        $db = Database::getInstance();
        $dbc = $db->connect();
        $data = $db->querySQL("Select * from files where ArticleID = $this->ArticleID AND ftype = 'mp4' OR "
                . "ftype = 'mp3' OR ftype = 'mov' OR ftype = 'avi' OR ftype = 'wmv'");
        
        if (mysqli_num_rows($data) > 0) {
            foreach($data as $row){
            $file = new Files();
        
            $file->setFileID($row['fid']);
            $file->setFlocation($row['flocation']);
            $file->setFileType($row['ftype']);
            $file->setArticleID($row['ArticleID']);
            $file->setFileName($row['fname']);
        
            return $file;
            }
        } else {
            return null;
        }
        
        
        
    }
    
    public function getNewArticleID() {
        
        $query = "SELECT articleID FROM `Article` ORDER by ArticleID DESC LIMIT 1";
        
        $db = Database::getInstance();
        $dbc = $db->connect();
        $result = $db->querySQL($query);
        $this->ArticleID = $result;
    }
    
    
}