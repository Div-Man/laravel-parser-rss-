<?php

namespace App\Http\Controllers;

use Vedmant\FeedReader\Facades\FeedReader;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\LikDis;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller {

    public function index() {

        $news = News::with('tags')
                ->withCount([
                    'likes AS like_count' => function ($query) {
                        $query->where('like_column', 1);
                    },
                    'likes AS dislike_count' => function ($query) {
                        $query->where('like_column', 0);
                    }
                ])
                ->withCount([
                    'likes AS rating' => function ($query) {
                        $query->select(DB::raw('COALESCE(SUM(like_column) - SUM(dislike), 0)'));
                    }
                ])
                ->orderByDesc('rating')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('news/index', ['posts' => $news]);
    }

    public function create() {


        $this->addAllTag();

        $news = FeedReader::read('https://lenta.ru/rss/news');

        $count_add = 0;

        foreach ($news->get_items() as $article) {

            $articleTag = $article->get_category()->term;
            $tag = Tag::where('name', $articleTag)->get();
            $tag_id = $tag->first()->id;

            $post = News::where('title', $article->get_title())->get();

            if ($post->first() === null) {

                $imageData = file_get_contents($article->get_enclosure()->link);

                $image_name = 'storage/' . Str::random(30) . '.jpg';
                Storage::disk('public')->put($image_name, file_get_contents($article->get_enclosure()->link));

                $data = [
                    'title' => $article->get_title(),
                    'link' => $article->get_link(),
                    'img' => $image_name,
                    'description' => $article->get_description(),
                    'author' => $article->get_author()->email,
                    'date_rss' => $article->get_date(),
                ];

                $news = News::create($data);
                $count_add = $count_add + 1;
                $news->tags()->attach([$tag_id]);
            }
        }

        return 'Количество добавленых новостей: ' . $count_add;
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

    public function like(Request $request) {

        $post_like = LikDis::create([
                    'news_id' => $request->idPost,
                    'like_column' => 1,
                    'dislike' => 0
        ]);

        return true;
    }

    public function dislike(Request $request) {

        $post_like = LikDis::create([
                    'news_id' => $request->idPost,
                    'like_column' => 0,
                    'dislike' => 1
        ]);

        return true;
    }

}
