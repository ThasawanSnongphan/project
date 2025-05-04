@extends('layout')
@section('title', 'แก้ไขข่าว')
@section('content')

    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">

                    <h2>แก้ไขข่าวประชาสัมพันธ์ </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="POST" action="{{ route('news.update', $news->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="field item form-group"  id="previewImage">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align"></label>
                            <div class="col-md-6 col-sm-6">
                                <img  style="width: 100%; display: block; " src="{{ asset('images/News/' . $news->img) }}" />
                                <p class="mt-1 text-center">{{$news->img}}</p>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label for="img" class="col-form-label col-md-3 col-sm-3  label-align">รูป<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="file" name="img" id="img" class="form-control" onchange="hideOldImage()">

                            </div>
                        </div>
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">หัวข้อข่าว<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="textt" name="title" id="title"
                                    value="{{ $news->title }}" required>
                            </div>
                        </div>

                        <div class="field item form-group">
                            <label for="content" class="col-form-label col-md-3 col-sm-3  label-align">รายละเอียดข่าว<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea name="content" id="content" rows="5" class="form-control" required>{{ $news->content }}</textarea>

                            </div>
                        </div>


                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3 text-center">
                                    <button type='submit' class="btn btn-warning" value="บันทึก">Edit</button>
                                    <a href="/news"><button type='button' class="btn btn-danger">Back</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>

    <script>
        function hideOldImage() {
            const fileInput = document.getElementById('img');
            const previewImage = document.getElementById('previewImage');
            const imgName = document.getElementById('imgName');

            if (fileInput.files.length > 0) {
                previewImage.style.display = 'none';
                imgName.style.display = 'none';
            }
        }
    </script>

@endsection
