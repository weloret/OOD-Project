<head>
    <script>
        
        window.onload = function() {
            showArticles('', 0, <?php echo $_SESSION['UserID']?>);
        }
        
    function confirmDelete(userID) 
    {
        if (confirm("Are you sure you want to delete this user?")) 
        {
            xmlhttp = new XMLHttpRequest();

            xmlhttp.open("GET", "AJAXPHP/deleteUser.php?id=" + userID, true);
            xmlhttp.send();
            
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("controls").innerHTML = xmlhttp.responseText;
                    showUsers('');
                }
            }
        }
    }
    function confirmDeleteArticle(articleId)
    {
        if(confirm("Are you sure you want to delete this article?"))
        {
            window.location.href = "delete_article.php?id=" + articleId;
        }
    }
    
    function viewArticle(articleId)
    {
        window.location.href = "article.php?id=" + articleId;
    }
    function createArticle()
    {
        window.location.href = "article_form.php";
    }
    
    function showArticleControls(id){
        
        xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "AJAXPHP/getArticleControls.php?id=" + id, true);
        xmlhttp.send();
        
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("controls").innerHTML = xmlhttp.responseText;
            } else {
//                window.alert(xmlhttp.responseText);
            }
        }
    }
    
    function updateArticle(id, headline, text, published, catid) {
        
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "AJAXPHP/updateArticle.php?id=" + id + "&headline=" + headline + "&text=" + text + "&published=" + published + "&catid=" + catid, true);
        xmlhttp.send();
        xmlhttp.onreadystatechange = function()

        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {   
                document.getElementById("test").innerHTML = xmlhttp.responseText; 
                
                //window.alert(xmlhttp.responseText);
            }
            showArticles("", published);
        }
            
    }
    
    function showArticles(str, pub, id)
    {
        //create the AJAX request object
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "AJAXPHP/getArticlesByID.php?q=" + str + "&pub=" + pub + "&id=" + id);
        xmlhttp.send();
        //declare a function that is called when something happens to the request
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                if (pub == 0) {
                    document.getElementById("unpublished-article-table").innerHTML = xmlhttp.responseText;
                } else {
                    document.getElementById("published-article-table").innerHTML = xmlhttp.responseText;
                }
            } else {
//                window.alert(xmlhttp.responseText);
            }
        }  
        
    }
    
    $(function () {
        $('#edit_form').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
              type: 'post',
              url: 'AJAXPHP/uploadImage.php',
              data: formData,
              processData: false,
              contentType: false,
              success: function () {
                alert('Form was submitted');
              }
            });
        });
    });
    
    </script>
</head>

<div class="container-fluid h-100 overflow-auto" style="height: vh90;">
<!-- data tabs -->
<div class="row d-flex justify-content-start">
    <div class ="col-12 col-xl-4 p-1 border border-top-0 rounded-bottom">
        <ul class="mt-2 nav nav-tabs nav-justified" id="navtabs">
            <li class="nav-item">
                <a class="nav-link active" id="unpublished-articles-tab" onclick="showArticles('', 0, <?php echo $_SESSION['UserID'];?>)" href="#unpublished-article-tab-pane" data-bs-toggle="tab">Unpublished Articles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="published-article-tab" data-bs-toggle="tab" onclick="showArticles('', 1, <?php echo $_SESSION['UserID'];?>)" href="#published-article-tab-pane">published articles</a>
            </li>
        </ul>
        
        <div class="tab-content d-flex">
            <div class="tab-pane fade show col-12 active" id="unpublished-article-tab-pane">
                <h2 class="text-center border-bottom py-4">Unpublished Articles</h2>
                <input type="text" class="w-100" name="Search" placeholder="Title or Author" onkeyup="showArticles(this.value, 0)"/>
                <div id="unpublished-article-table" class="overflow-auto" style="height: 60vh;"></div>
                <button class="btn btn-primary col-12 p-2 mt-4" onclick="showArticleControls(-1)" >Create New Article</button>
                <nav class="d-flex justify-content-center mt-3">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        
            <div class="tab-pane fade show col-12" id="published-article-tab-pane">
                <h2 class="text-center border-bottom py-4">Published Articles</h2>
                <input type="text" class="w-100" name="test" placeholder="Title or Author" onkeyup="showArticles(this.value, 1)"/> <!--TODO: Add functionality - search for published articles-->
                <div id="published-article-table"></div>
            </div>


            <div class="tab-pane fade show col-12" id="users-tab-pane">
                <h2 class="w-100 text-center">Users</h2>
                
                <input type="text" class="w-100" name="Search" placeholder="ID or Username" onkeyup="showUsers(this.value)"/>
                
                <div id="users-table"></div>
            </div>
            
            
            
        </div>
        <div class="d-flex justify-content-center">
        
    </div> 
    </div> 
    
    <!-- controls -->
    <div class ="col-11 col-md-8" id="controls"></div>
</div>
</div>