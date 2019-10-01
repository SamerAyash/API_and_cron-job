<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostResource::collection(Post::all());

    }

    public function myPost()
    {

        $myPost =collect(Post::where('user_id',Auth::id())->get());
        return PostResource::collection($myPost);

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all() ,[
            'title'=>'required',
            'details'=>'required',
        ])->validate();
        if (Auth::user()->numbersOfPosts == 0){

        $post =Post::create([
            'title'=>$request->title,
            'details'=>$request->details,
            'user_id'=>Auth::id(),
        ]);
            Auth::user()->numbersOfPosts = Auth::user()->numbersOfPosts +1 ;
            Auth::user()->update();
        return new PostResource($post);

            }

        return ['message'=>'Opportunities to publish your posts are over today'];


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $post =Post::findOrFail($id);
            return new PostResource($post);
        }
        catch (\Exception $e){
            return ['message'=>'Not found the post'];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make(
            $request->all(),
            [
                'title'=>'required',
                'details'=>'required',
                ]
        )->validate();

        try{

            $post =Post::findOrFail($id);
            if (Auth::id() == $post->user_id){

            $post->title =$request->title;
            $post->details=$request->details;
            $post->update();
            return new PostResource($post);
            }
            return ['message'=>'This is not your post'];
        }
        catch (\Exception $exception){
            return [
                'massage'=>'No post found'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $post =Post::findOrFail($id);
            if (Auth::id() == $post->user_id){
            $post->delete();
            return new PostResource($post);
            }
            return ['message'=>'This is not your post'];
        }
        catch (\Exception $e){
            return ['message'=>'Not found the post'];
        }
    }
}
