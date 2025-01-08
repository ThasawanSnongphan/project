@extends('layout')
@section('title', 'แก้ไขข่าว')
@section('content')
<h2 class="m-2">แก้ไขข่าว</h2>
<form method="POST" action="{{route('news.update',$news->id)}}">
    @csrf
    <div class="form-group m-2">
        <label for="title">หัวข้อข่าว</label>
        <input type="text" name="title" id="title" class="form-control" value="{{$news->title}}">
    </div>
    @error('title')
        <div class="m-2">
            <span class="text text-danger">{{$message}}</span>
        </div>
    @enderror
    <div class="form-group m-2">
        <label for="content">รายละเอียดข่าว</label>
        <textarea name="content" id="content" rows="5" class="form-control" >{{$news->content}}</textarea>
    </div>
    @error('content')
        <div class="m-2">
            <span class="text text-danger">{{$message}}</span>
        </div>
    @enderror
    <div class="form-group m-2">
        <label for="img">รูป</label>
        <input type="file" name="img" id="img" class="form-control">
    </div>
    <input type="submit" value="update" class="btn btn-primary m-2">
    <a href="/" class="btn btn-secondary">กลับ</a>
</form>
@endsection