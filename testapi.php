<?php

class TestAPI
{
    static $url = "https://jsonplaceholder.typicode.com/";

    public function showUsers() {        
        $json = file_get_contents(TestAPI::$url."users");
        $json_data = json_decode($json, true);
        echo "All users:<br>";
        foreach ($json_data as $user) {
            echo "<a href='?command=showposts&userid=".$user["id"]."'>".$user["name"]."</a><br>";
        }
    }

    public function showPosts() { 
        if (isset($_GET['userid'])) {
            $json = file_get_contents(TestAPI::$url."posts?userId=".$_GET['userid']);
            $json_data = json_decode($json, true);

            echo "User posts:<br>";
            foreach ($json_data as $post) {
                echo "<a href='?command=showpost&userid=".$_GET['userid']."&postid=".$post["id"]."'>".$post["title"]."</a><br>";
            }
            TestAPI::showTodos();
        }
    }

    public function showTodos() { 
        if (isset($_GET['userid'])) {
            $json = file_get_contents(TestAPI::$url."todos?userId=".$_GET['userid']);
            $json_data = json_decode($json, true);

            echo "User todos:<br>";
            foreach ($json_data as $todo) {
                if ($todo["completed"]==0) echo "<div style='color: red'>".$todo["title"]."</div>";
                else echo "<div style='color: green'>".$todo["title"]."</div>";
            }
        }
    }

    public function showPost() { 
        if (isset($_GET['userid']) and isset($_GET['postid'])) {
            $json = file_get_contents(TestAPI::$url."posts?userId=".$_GET['userid']);
            $json_data = json_decode($json, true);

            foreach ($json_data as $post) {
                if ($post['id']==$_GET['postid']) {
                    echo "<form id='form' action='' method='post'>";
                    echo "<textarea name='title' rows='2' cols='50'>".$post["title"]."</textarea><br>";
                    echo "<textarea name='text' rows='8' cols='50'>".$post["body"]."</textarea><br>";
                    echo "<input id='dbcommand' name='dbcommand' type='hidden' value=''/>";
                    echo "<input name='userId' type='hidden' value='".$_GET['userid']."'/>";
                    echo "<input name='postId' type='hidden' value='".$_GET['postid']."'/>";
                    echo "</form><button onclick='postNew()'>Save as new post</button><button onclick='postSave()'>Save post</button><button onclick='postDel()'>Delete post</button>";
                }
            }            
        }
    }

    public function postNew() { 
        $json=json_encode(array(
            'title' => $_POST['title'],
            'body' => $_POST['text'],
            'userId' => $_POST['userId'],
        ));

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => $json,
                'header'=>  "Content-Type: application/json"
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents( 'https://jsonplaceholder.typicode.com/posts', false, $context );
        echo "New post added: ".$result;        
    }   

    public function postSave() { 
        $json=json_encode(array(
            'id' => $_POST['postId'],
            'title' => $_POST['title'],
            'body' => $_POST['text'],
            'userId' => $_POST['userId'],
        ));

        $options = array(
            'http' => array(
                'method'  => 'PUT',
                'content' => $json,
                'header'=>  "Content-Type: application/json"
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents( TestAPI::$url.'posts/'.$_POST['postId'], false, $context );
        echo "Post saved: ".$result;        
    }  

    public function postDel() { 
        $options = array(
            'http' => array(
                'method'  => 'DELETE',
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents( TestAPI::$url.'posts/'.$_POST['postId'], false, $context );
        echo "Post deleted: ".$result;        
    } 
}



$command='';
$dbcommand='';
if (isset($_POST['dbcommand'])) $dbcommand=$_POST['dbcommand'];


$testAPI = new TestAPI();

switch ($dbcommand) {    
    case "postNew": 
        TestAPI::postNew();
        break;
    case "postSave": 
        TestAPI::postSave();
        break;
    case "postDel": 
        TestAPI::postDel();
        break;
    case "":    
        if (isset($_GET['command'])) $command= $_GET['command'];
}

switch ($command) {    
    case "": 
        echo "<br><a href='?command=showusers'>Show users</a><br>";
        break;
    case "showusers": 
        TestAPI::showUsers();
        break;
    case "showposts": 
        TestAPI::showPosts();
        break;
    case "showpost": 
        TestAPI::showPost();
        break;
}


?>


<script type="text/javascript">

function postNew() {
    dbcommand.value='postNew';
    form.submit();
}

function postSave() {
    dbcommand.value='postSave';
    form.submit();
}
    
function postDel() {
    dbcommand.value='postDel';
    form.submit();
}
</script>