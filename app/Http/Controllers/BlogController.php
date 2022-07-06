<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostDestroyRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
        public function index(){

        $posts = Post::select('id', 'user_id', 'title', 'description', 'text')
            ->get();

       return PostResource::collection($posts);
    }

    public function store(PostStoreRequest $request){
            $request->validated();
            $request->request->add([
                'user_id' => Str(Auth::user()->id),
                'slug'=> Str::random(10)
            ]);

        $created_post = Post::create([
            'user_id' => $request->user_id,
            'text' => $request->text,
            'description' => $request->description,
            'title' => $request->title,
            'slug' => $request->slug
        ]);

            return new PostResource($created_post);

    }

    public function destroy(PostDestroyRequest $request){

           $request->validated();

            $post = Post::select('id','user_id')
                ->where('slug', '=', Str($request->slug))
                ->get();

            if($post->value('user_id') == Auth::user()->id){

                Post::destroy($post->value('id'));
                return response()->json([
                    'message' => 'Запись была успешно удалена',
                ]);

            } else
                return response()->json([
                'message' => 'У Вас нет права на удаление данной записи',
            ]);

    }

}
