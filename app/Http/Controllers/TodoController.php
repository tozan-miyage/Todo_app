<?php

namespace App\Http\Controllers;

use App\Todo;
// リレーションを使用するために追加
use App\Goal;
use App\Tag;
use Illuminate\Http\Request;
// ログインしているユーザーのTodoのみをレスポンスとして返す
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // show/create/editは削除
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Goal $goal)
    {
        // $goalに紐づいたtodo()を昇順で、doneがtrueでポジションがあるもの？？
        // $todos = $goal->todos()->orderBy('done','asc')->orderBy('position','asc')->get();
        
        $todos = $goal->todos()->with('tags')->orderBy('done','asc')->orderBy('position','asc')->get();
        
        return response()->json($todos);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Goal $goal)
    {
        // 新規作成
        $todo = new Todo();
        // contentをpostされた内容に
        $todo->content = request('content');
        // ユーザーIDはログインユーザー
        $todo->user_id = Auth::id();
        // ゴールIDはpostされたID
        $todo->goal_id = $goal->id;
        // positionはpostされたもの
        $todo->position = request('position');
        //????
        $todo->done= false;
        // 保存
        $todo->save();
        
        // goalに紐づいた、tososとtagsを引っ張ってきてくれ
        $todos = $goal->todos()->with('tags')->orderBy('done','asc')->orderBy('position','asc')->get();
        return response()->json($todos);
    }

    
    public function update(Request $request,Goal $goal, Todo $todo)
    {
        // contentをpostされた内容に
        $todo->content = request('content');
        // ユーザーIDはログインユーザー
        $todo->user_id = Auth::id();
        // ゴールIDはpostされたID
        $todo->goal_id = $goal->id;
        // positionはpostされたもの
        $todo->position = request('position');
        // ??????
        $todo->done= (bool) request('done');
        // 保存
        $todo->save();
        
        $todos = $goal->todos()->with('tags')->orderBy('done','asc')->orderBy('position','asc')->get();
        return response()->json($todos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Goal $goal,Todo $todo)
    {
        $todo->delete();
        
        $todos = $goal->todos()->with('tags')->orderBy('done','asc')->orderBy('position','asc')->get();
        return response()->json($todos);
        
    }
    
    public function sort(Request $request,Goal $goal,Todo $todo)
    {
        $exchangeTodo = Todo::where('position',request('sortId'))->first();
        
        $lastTodo = Todo::where('position',request('sortId'))->latest('position')->first();
        
        if(request('sortId') == 0){
            $todo->moveBefore($exchangeTodo);
        }else if (request('sortId') - 1 == $lastTodo->position){
            $todo->moveAfter($exchangeTodo);
        }else {
            $todo->moveAfter($exchangetodo);
        }
        
        $todos = $goal->todos()->with('tags')->orderBy('done','asc')->orderBy('position','asc')->get();
        
        return response()->json($todos);
    }
    public function addTag(Request $request,Goal $goal, Todo $todo, Tag $tag)
    {
        // $todoと$tagを中間テーブルで紐づける。
        $todo->tags()->attach($tag->id);
        
        $todos = $goal()->todos()->with('tags')->orderBy('done','asc')->orderBy('position','asc')->get();
        
        return response()->json($todos);
    }
    public function removeTag(Request $request,Goal $goal, Todo $todo, Tag $tag)
    {
        $todo->tags()->detach($tag->id);
        
        $todos = $goal->todos()->with('tags')->orderBy('done','asc')->orderBy('position','asc')->get();
        
        return response()->json($todos);
    }
}