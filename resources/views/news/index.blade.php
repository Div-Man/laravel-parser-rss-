<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Новости</title>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            .box {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .wrap {
                width: 1000px;
               
            }
            
            .wrap .post{
                display: flex; 
            }
            
            .left-side {
                width: 60%;
                padding: 10px;
               
            }
            
            .wrap .post{
                 border: 1px solid;
                 padding: 10px;
                 margin-bottom: 30px;
            }
            
            .wrap .top .header{
                display: flex;
                align-items: center;
                margin-bottom: 30px;
            }
            
            .wrap .top h3 {
                width: 400px;  
            }
            
            .wrap .top .date{
                
            }
            
            .left-side .desciption{
                 margin-bottom: 30px;
            }
            
            .right-side{
                
                 margin-left: 40px;
            }
  
        </style>
    </head>
    <body>

        <div class="box">
            <div class="wrap">
                        
                 @foreach($posts as $post)
                <div class="post">
                    <div class="left-side">
                        <div class="top">
                            <div class="header">
                                <h3>{{$post->title}}</h3>
                                <div class="date">{{$post->date_rss}}</div>
                            </div>
                            
                            <div class="desciption">
                               {{$post->description}}
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="tags">
                               
                                Теги:  @foreach($post->tags as $tag)
                                         <a href="#">{{$tag->name}}</a>
                                       @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="image">
                          <img width="300px" src="{{ asset('storage/' . $post->img)}}">
                        </div>
                        <div class="likes">
                            <a onclick="like(event)" data-id-post="{{$post->id}}" href="#">Нравится({{$post->like_count}})</a> / 
                            <a onclick="dislike(event)" data-id-post="{{$post->id}}" href="#">Не нравится({{$post->dislike_count}})</a>
                        </div>
                        <div class="rating">
                            Общий рейтинг: {{$post->rating}}
                        </div>
                        
                    </div>
                </div>
                 @endforeach
                
                 
                  <div class="pagination">
                  {{$posts->links()}}
              </div>
                 
            </div>
        </div>
        
        <script>
            
            function like(event){
                 event.preventDefault();
                 let id = event.target.dataset.idPost;
                 
                 axios.post('/like', {
                   idPost: id
                 })
                 .then(function (response) {
                   console.log(response);
                 })
                 .catch(function (error) {
                   console.log(error);
                 });
            }
            
              function dislike(event){
                 event.preventDefault();
                 let id = event.target.dataset.idPost;
                 
                 axios.post('/dislike', {
                   idPost: id
                 })
                 .then(function (response) {
                   console.log(response);
                 })
                 .catch(function (error) {
                   console.log(error);
                 });
            }
            
        </script>

    </body>
</html>
