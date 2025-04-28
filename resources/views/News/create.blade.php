<div class="row">
    <div class="col-md-3 col-sm-1" ></div>
    <div class="col-md-6 col-sm-10">
        <div class="x_panel">
            <div class="x_title">

                <h2>เพิ่มข่าวประชาสัมพันธ์ </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    {{-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                        </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li> --}}
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="/insert" enctype="multipart/form-data">
                    @csrf
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">หัวข้อข่าว<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="textt" name="title" id="title" required>

                        </div>
                    </div>

                    <div class="field item form-group">
                        <label for="content" class="col-form-label col-md-3 col-sm-3  label-align">รายละเอียดข่าว<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <textarea  name="content" id="content" rows="5" class="form-control" required></textarea>

                        </div>
                    </div>

                    <div class="field item form-group">
                        <label for="img" class="col-form-label col-md-3 col-sm-3  label-align">รูป<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="file" name="img" id="img" class="form-control" required>
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group ">
                            <div class="col-md-6 offset-md-3 text-center">
                                <button type='submit' class="btn btn-primary" value="บันทึก">Submit</button>
                                <button type='reset' class="btn btn-success">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-1"></div>
</div>
