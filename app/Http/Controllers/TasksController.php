<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    
     // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $data = [];
        if (\Auth::check()){
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
                ];
            }
       
       return view('welcome', $data);
        
    }

     // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;
        
            return view('tasks.create', [
                'task' => $task,
            ]);
    }

    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required',
            ]);
            
            
        //dd($request->content);
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
            ]);
            
            return redirect('/');
    }

     // getでtasks/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }

    // getでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }

    // putまたはpatchでtasks/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required',
            ]);
            
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        }
        
        return redirect('/');
    }

    // deleteでtasks/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = \App\Task::findOrFail($id);        
        
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
    }
}
