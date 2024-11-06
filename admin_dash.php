<head>
    <script>
        
        window.onload = function() {
            showArticles('', 0);
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
    
    function showUsers(str)
    {
        //create the AJAX request object
        xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "AJAXPHP/getUsers.php?q=" + str, true);
        xmlhttp.send();
   
        //declare a function that is called when something happens to the request
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("users-table").innerHTML = xmlhttp.responseText;
            }
        }
    }
    
    function showUserControls(id)
    {
        //create the AJAX request object
        xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "AJAXPHP/getUserControls.php?id=" + id, true);
        xmlhttp.send();
   
        //declare a function that is called when something happens to the request
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("controls").innerHTML = xmlhttp.responseText;
            }
        }
    }
    
    function updateUser(id, username, password, email)
    {
        var r = 0;
        
        if(document.getElementById('viewer').checked == true) {   
            r = 1;
        } 
        else if(document.getElementById('author').checked == true) {   
            r = 2;
        } 
        else if(document.getElementById('admin').checked == true) {   
            r = 3;
        }

        //create the AJAX request object
        xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "AJAXPHP/updateUser.php?id=" + id + "&name=" + username + "&pass=" + password +"&email=" + email + "&roleid=" + r, true);
        xmlhttp.send();
   
        //declare a function that is called when something happens to the request
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("controls").innerHTML = xmlhttp.responseText;
                showUsers('');
            }
        }
        
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
    
    
    function showArticles(str, pub)
    {
        //create the AJAX request object
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "AJAXPHP/getArticles.php?q=" + str + "&pub=" + pub);
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
    

    function updateArticle(id, headline, text, published, catid) {
        
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "AJAXPHP/updateArticle.php?id=" + id + "&headline=" + headline + "&text=" + text + "&published=" + published + "&catid=" + catid, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function()
            
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {   
                    document.getElementById("test").innerHTML = xmlhttp.responseText; 
//                    showArticles('', published);
//                    window.alert(xmlhttp.responseText);
                }
            }
            
        }

    </script>
</head>

<div class="container-fluid h-100 overflow-auto" style="height: vh90;">
<!-- data tabs -->
<div id="test">test</div>
<div class="row d-flex justify-content-start">
    <div class ="col-12 col-xl-4 p-1 border border-top-0 rounded-bottom">
        <ul class="mt-2 nav nav-tabs nav-justified" id="navtabs">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="#">Articles</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item active" id="unpublished-articles-tab" onclick="showArticles('', 0)" data-bs-toggle="tab" href="#unpublished-article-tab-pane">unpublished articles</a></li>
                    <li><a class="dropdown-item" id="published-article-tab" data-bs-toggle="tab" onclick="showArticles('', 1)" href="#published-article-tab-pane">published articles</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="users-tab" data-bs-toggle="tab" onclick="showUsers('')" href="#users-tab-pane">Users</a>
            </li>
        </ul>
        
        <div class="tab-content d-flex">
            <div class="tab-pane fade show col-12 active" id="unpublished-article-tab-pane">
                <h2 class="text-center border-bottom py-4">All Unpublished Articles</h2>
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

                <button class="btn btn-primary col-12 p-2 mt-4" onclick="window.print()" >EXPORT DATA</button>

            </div>
        
            <div class="tab-pane fade show col-12" id="published-article-tab-pane">
                <h2 class="text-center border-bottom py-4">All Published Articles</h2>
                <input type="text" class="w-100" name="test" placeholder="Title or Author" onkeyup="showArticles(this.value, 1)"/> <!--TODO: Add functionality - search for published articles-->
                <div id="published-article-table"></div>
                <button class="btn btn-primary col-12 p-2 mt-4" onclick="window.print()" >EXPORT DATA</button>
            </div>


            <div class="tab-pane fade show col-12" id="users-tab-pane">
                <h2 class="w-100 text-center">Users</h2>
                
                <input type="text" class="w-100" name="Search" placeholder="ID or Username" onkeyup="showUsers(this.value)"/>
                
                <div id="users-table"></div>
                <button class="btn btn-primary col-12 p-2 mt-4" onclick="window.print()" >EXPORT DATA</button>
            </div>
            
            
            
        </div>
        
        <div class="d-flex justify-content-center">
        
    </div> 
    </div> 
    <!-- controls -->
    <div class ="col-11 col-md-8" id="controls"></div>
    
</div>
</div>