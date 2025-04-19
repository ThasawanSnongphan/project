<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    
    
    function index(){
        $news=DB::table('news')->get();
        return view('News.index',compact('news'));
    }
    public function detail($id){
        $data['newsDetail'] = News::find($id);
        return view('News.detail',compact('data'));
    }


    public function insert(Request $request){
        // $request->validate(
        //     [
        //         'title'=>'required',
        //         'content'=>'required',
        //         'image' => 'nullable|image|mimes:jpeg,png,jpg'
        //     ],
        //     [
        //         'title.required'=>'กรุณากรอกหัวข้อข่าว',
        //         'content.required'=>'กรุณากรอกรายละเอียดข่าว',
        //         'img.nullable'=>'กรุณาใส่รูปภาพ'
        //     ]
        // );

        $news = new News();
        $news->title = $request->input('title');
        $news->content = $request->input('content');

        if ($request->hasFile('img')) {
            // เก็บไฟล์ในโฟลเดอร์ 'images' ภายใต้โฟลเดอร์ 'public'
            $img = $request->file('img')->move(public_path('images/News'), $request->file('img')->getClientOriginalName());
            
            // ถ้าคุณต้องการเก็บแค่ชื่อไฟล์ในฐานข้อมูล
            $filename = $request->file('img')->getClientOriginalName();
        
            // เก็บ path หรือชื่อไฟล์ในฐานข้อมูล เช่น:
            // $model->image_path = 'images/' . $filename;
            // $model->save();
        }
        $imageName = basename($img);
        $news->img = $imageName;
        $news->save();
        return redirect('/news');
    }

    function delete($id){
        DB::table('news')->where('id',$id)->delete();
        return redirect('/news');
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

        $news = DB::table('news')->where('id', $id)->first();

         if ($request->hasFile('img')) {
        // ลบรูปเก่า ถ้ามี
        if ($news->img && file_exists(public_path('images/News/' . $news->img))) {
            unlink(public_path('images/News/' . $news->img));
        }

        // เก็บรูปใหม่
        $filename = $request->file('img')->getClientOriginalName();
        $request->file('img')->move(public_path('images/News'), $filename);
        } else {
            // ใช้รูปเดิม
            $filename = $news->img;
        }

        $news=[
            'title'=>$request->title,
            'content'=>$request->content,
            'img'=>$filename
        ];
        DB::table('news')->where('id',$id)->update($news);
        return redirect('/news'); 
    }
}
