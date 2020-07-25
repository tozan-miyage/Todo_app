<?php

namespace App\Http\Controllers;

use App\Goal;
use Illuminate\Http\Request;
// ログインしているユーザーの投稿のみをレスポンスとして返す
use Illuminate\Support\Facades\Auth;


// show/create/editは削除
class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ユーザーに紐づいたgoalsを格納
        $goals = Auth::user()->goals;
        // json形式でレスポンスとして返す
        return response()->json($goals);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 新しいテーブルを作成
        $goal = new Goal();
        // タイトルをポストされているtitleに変更
        $goal->title = request('title');
        // ユーザーIDはログインしているID
        $goal->user_id = Auth::id();
        // 保存
        $goal->save();
        // 保存した内容を格納
        $goals = Auth::user()->goals;
        
        return response()->json($goals);
        
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    //  既存のGoalの更新作業
    public function update(Request $request, Goal $goal)
    {
        $goal->title = request('title');
        
        $goal->user_id = Auth::id();
        
        $goal->save();
        
        $goals = Auth::user()->goals;
        
        return response()->json($goals);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    //  Goalの削除
    public function destroy(Goal $goal)
    {
        // postされた$goalを削除
        $goal->delete();
        // 削除されたデータを格納
        $goals = Auth::user()->goals;
        // jsonで返す
        return response()->json($goals);
    }
}
