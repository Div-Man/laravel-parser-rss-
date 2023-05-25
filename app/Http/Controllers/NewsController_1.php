<?php

namespace App\Http\Controllers;

use Vedmant\FeedReader\Facades\FeedReader;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Tag;

class NewsController extends Controller {
    
 
    public function create() {
        
        $this->addAllTag();
        
        $news = FeedReader::read('https://lenta.ru/rss/news');

        $count_add = 0;

        foreach ($news->get_items() as $article) {
            $data = [
                'title' => $article->get_title(),
                'link' => $article->get_link(),
                'img' => $article->get_enclosure()->link,
                'description' => $article->get_description(),
                'author' => $article->get_author()->email,
                'date_rss' => $article->get_date(),
            ];


            $articleTag = $article->get_category()->term;
            $tag = Tag::where('name', $articleTag)->get();
            $tag_id = $tag->first()->id;
            
            $post = News::where('title', $data['title'])->get();

            if ($post->first() === null) {
               
                $news = News::create($data);
                $count_add = $count_add + 1;
                $news->tags()->attach([$tag_id]);
            }


            //
            //$post = News::create($data);
            // guid
            //dump($data);
            //dump($article->get_author()->email);
            //dump($article->get_date());
            //dump($article->get_enclosure()->link);
            //dump($article);
        }

        echo 'Количество добавленых новостей: ' . $count_add;
    }

    public function addAllTag() {
        $news = FeedReader::read('https://lenta.ru/rss/news');

        foreach ($news->get_items() as $article) {
            $articleTag = $article->get_category()->term;

            $tag = Tag::where('name', $articleTag)->get();

            if ($tag->isEmpty()) {
                $new_tag = new Tag;
                $new_tag->name = $articleTag;
                $new_tag->save();
            }
        }
    }
    

}
