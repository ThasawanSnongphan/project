<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    function login(){
        return view('login');
    }
    
    function index(){
        $news=DB::table('news')->get();
        return view('News.index',compact('news'));
    }

    function create(){
        return view('News.create');
    }

    public function insert(Request $request){
        $request->validate(
            [
                'title'=>'required',
                'content'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg'
            ],
            [
                'title.required'=>'กรุณากรอกหัวข้อข่าว',
                'content.required'=>'กรุณากรอกรายละเอียดข่าว',
                'img.nullable'=>'กรุณาใส่รูปภาพ'
            ]
        );

        $news = new News();
        $news->title = $request->input('title');
        $news->content = $request->input('content');

        if ($request->hasFile('img')) {
            // เก็บไฟล์ในโฟลเดอร์ 'images' ภายใต้ 'storage/app/public'
            $img = $request->file('img')->store('images', 'public');
             // เก็บ path ของรูปในฐานข้อมูล
        }
        $news->img = $img;
        // if ($request->hasFile('img')) {
        //     $img = $request->file('img')->insert('images', 'public');
        //     $news->image = $img;
        // }

        $news->save();
        return redirect('/');
    }

    function delete($id){
        DB::table('news')->where('id',$id)->delete();
        return redirect('/');
    }
    function edit($id){
        $news=DB::table('news')->where('id',$id)->first();
        return view('News.update',compact('news'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'title'=>'required',
                'content'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg'
            ],
            [
                'title.required'=>'กรุณากรอกหัวข้อข่าว',
                'content.required'=>'กรุณากรอกรายละเอียดข่าว',
                'img.nullable'=>'กรุณาใส่รูปภาพ'
            ]
        );
        $news=[
            'title'=>$request->title,
            'content'=>$request->content
        ];
        DB::table('news')->where('id',$id)->update($news);
        return redirect('/'); 
    }
}
