# testapi
http://api.suh199121.beget.tech/

<h3>Ссылка Show users создаст запрос на получения списка пользователей.</h3>

GET Запрос к серверу:<br>
<code>/?command=showusers</code>

Запрос к базе:<br>
<code>$json = file_get_contents('https://jsonplaceholder.typicode.com/users');</code>

Ответ:<code></code>

    All users:
    Leanne Graham
    Ervin Howell
    Clementine Bauch
    Patricia Lebsack
    Chelsey Dietrich
    Mrs. Dennis Schulist
    Kurtis Weissnat
    Nicholas Runolfsdottir V
    Glenna Reichert
    Clementina DuBuque
    
<h3>После клика на любого пользователя запрашивается и отображается список постов и заданий этого пользователя.</h3>

GET Запрос к серверу:<br> 
<code>/?command=showposts&userid=8</code>

Запрос к базе:<br>
<code>$json = file_get_contents('https://jsonplaceholder.typicode.com/posts?userId=8');</code>

Ответ:
<code></code>

    User posts:
    et iusto veniam et illum aut fuga
    sint hic doloribus consequatur eos non id
    consequuntur deleniti eos quia temporibus ab aliquid at
    enim unde ratione doloribus quas enim ut sit sapiente
    dignissimos eum dolor ut enim et delectus in
    doloremque officiis ad et non perferendis
    necessitatibus quasi exercitationem odio
    quam voluptatibus rerum veritatis
    pariatur consequatur quia magnam autem omnis non amet
    labore in ex et explicabo corporis aut quas
    User todos:
    explicabo consectetur debitis voluptates quas quae culpa rerum non
    maiores accusantium architecto necessitatibus reiciendis ea aut
    eum non recusandae cupiditate animi
    ut eum exercitationem sint
    beatae qui ullam incidunt voluptatem non nisi aliquam
    molestiae suscipit ratione nihil odio libero impedit vero totam
    eum itaque quod reprehenderit et facilis dolor autem ut
    esse quas et quo quasi exercitationem
    animi voluptas quod perferendis est
    eos amet tempore laudantium fugit a
    accusamus adipisci dicta qui quo ea explicabo sed vero
    odit eligendi recusandae doloremque cumque non
    ea aperiam consequatur qui repellat eos
    rerum non ex sapiente
    voluptatem nobis consequatur et assumenda magnam
    nam quia quia nulla repellat assumenda quibusdam sit nobis
    dolorem veniam quisquam deserunt repellendus
    debitis vitae delectus et harum accusamus aut deleniti a
    debitis adipisci quibusdam aliquam sed dolore ea praesentium nobis
    et praesentium aliquam est

<h3>После клика на любой из постов запрашиваются посты пользователя и отображается название и текст требуемого поста в редактируемых окнах.</h3>

GET Запрос к серверу: <br>
<code>/?command=showpost&userid=8&postid=77</code>

Запрос к базе:<br>
<code>$json = file_get_contents('https://jsonplaceholder.typicode.com/posts?userId=8');</code>

Ответ:<br>
<code></code>

    necessitatibus quasi exercitationem odio 
    
    modi ut in nulla repudiandae dolorum nostrum eos
    aut consequatur omnis
    ut incidunt est omnis iste et quam
    voluptates sapiente aliquam asperiores nobis amet corrupti repudiandae provident

<h3>Кнопка Save as new post сохранит редактируемый пост как новый у того же пользователя</h3>

Запрос к базе:
<code></code>

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
        $result = file_get_contents( TestAPI::$url.'posts', false, $context );
Ответ: 
<code>New post added: { "title": "tew title", "body": "new text", "userId": "8", "id": 101 }</code>

<h3>Кнопка Save post сохранит редактируемый пост</h3>

Запрос к базе:
<code></code>

        $json=json_encode(array(
            'id' => '77',
            'title' => 'new title',
            'body' => 'new text',
            'userId' => '8',
        ));

        $options = array(
            'http' => array(
                'method'  => 'PUT',
                'content' => $json,
                'header'=>  "Content-Type: application/json"
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents('https://jsonplaceholder.typicode.com/posts/8', false, $context );
        
Ответ:
<code>Post saved: { "id": 77, "title": "tew title", "body": "new text", "userId": "8" }</code>

<h3>Кнопка Delete post удалит редактируемый пост.</h3>

Запрос к базе:
<code></code>

        $options = array(
            'http' => array(
                'method'  => 'DELETE',
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents( 'https://jsonplaceholder.typicode.com/posts/8', false, $context );

Ответ:
<code>Post deleted: {}</code>
