<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
// ログインしているユーザーのみレスポンスを返す
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ログインユーザーを格納
        $user = Auth::user();
        // ユーザーに紐づいたtagsを取得
        $tags = $user->tags;
        // json形式で返す
        return response()->json($tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
        //使わない
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //新しいクラス(カラム)を作成
        $tag = new Tag();
        // タイトルはリクエストで送られてきたものを保存
        $tag->title = request('title');
        // ユーザーはログインしているユーザー
        $tag->user_id = Auth::id();
        // 保存
        $tag->save();
        // 保存した全てのタグを格納
        $tags = $user->tags;
        // json形式で返す
        return response()->json($tags);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    // public function show(Tag $tag)
    // {
        //使わない
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    // public function edit(Tag $tag)
    // {
        //使わない
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // タイトルはリクエストで送られてきたものを保存
        $tag->title = request('title');
        // ユーザーはログインしているユーザー
        $tag->user_id = Auth::id();
        // 保存
        $tag->save();
        // 保存した全てのタグを格納
        $tags = $user->tags;
        // json形式で返す
        return response()->json($tags);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        
        $user = Auth::user();
        
        $tags = $user->tags;
        
        return response()->json($tags);
    }
}
