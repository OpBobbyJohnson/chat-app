<?php
    $verb = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['PATH_INFO'];
    $authorReq = $_POST['author'];
    $contentReq = $_POST['content'];



    $routes = explode("/",$uri;

    
    $dbhandle = new PDO("sqlite:database.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);

    if($verb = "GET"){
        $query = "SELECT * FROM chat";
        
    }
    else if($verb="POST"){
        $author = "anonymous";
        $content = "empty";
        if(isset($contentReq)){
            $content = $contentReq;
        }
        if(isset($authorReq)){
            $author = $authorReq;
        }
        $query = 'INSERT into chat ("author","content") VALUES ("'.$author.'","'.$content.'")';
        echo $query;
        
        echo json_encode($author,$content);
    }
    else{
        
    }
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    //this part is perhaps overkill but I wanted to set the HTTP headers and status code
    //making to this line means everything was great with this request
    header('HTTP/1.1 200 OK');
    //this lets the browser know to expect json
    header('Content-Type: application/json');
    //this creates json and gives it back to the browser
    echo json_encode($results);
?>