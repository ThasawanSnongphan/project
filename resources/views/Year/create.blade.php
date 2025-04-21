<div class="row">
    <div class="col-md-3 col-sm-1"></div>
    <div class="col-md-6 col-sm-10">
        <div class="x_panel">
            <div class="x_title">
                <h2>เพิ่มปีงบประมาณ </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="/yInsert" enctype="multipart/form-data">
                    @csrf
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">year<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="year" id="year" required>
                        </div>
                    </div>
                    <div class="ln_solid ">
                        <div class="form-group text-center p-2">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-success" value="บันทึก">Submit</button>
                                {{-- <button type='reset' class="btn btn-success">Reset</button> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-1"></div>
</div>
