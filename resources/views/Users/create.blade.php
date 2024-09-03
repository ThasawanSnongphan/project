<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Users</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                        </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="/uInsert" method="post" novalidate>
                    @csrf
                    <div class="field item form-group">
                        <label for="username" class="col-form-label col-md-3 col-sm-3  label-align">UserName<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" data-validate-length-range="6"
                                data-validate-words="2" name="username" id="username" required="required" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="email" class="col-form-label col-md-3 col-sm-3  label-align">email<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" id="email" class='email' required="required"
                                type="email" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="password1" class="col-form-label col-md-3 col-sm-3  label-align">Password<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="password" id="password1" name="password"
                                title="Minimum 8 Characters Including An Upper And Lower Case Letter, A Number And A Unique Character"
                                required />
                            {{-- pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" --}}
                            <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()">
                                <i id="slash" class="fa fa-eye-slash"></i>
                                {{-- <i id="eye" class="fa fa-eye"></i> --}}
                            </span>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="password2" class="col-form-label col-md-3 col-sm-3  label-align">Repeat
                            password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="password" name="password2" id="password2"
                                data-validate-linked='password' required='required' />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="account_type"
                            class="col-form-label col-md-3 col-sm-3  label-align">account_type<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="account_type" id="account_type"
                                data-validate-length-range="5,15" type="text" />
                        </div>
                    </div>

                    <div class="field item form-group">
                        <label for="full_prefix_name_th"
                            class="col-form-label col-md-3 col-sm-3  label-align">full_prefix_name_th<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="full_prefix_name_th"
                                id="full_prefix_name_th" data-validate-linked='email' required='required' />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="firstname_th"
                            class="col-form-label col-md-3 col-sm-3  label-align">firstname_th<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="firstname_th" id="firstname_th"
                                data-validate-minmax="10,100" required='required'>
                        </div>
                    </div>

                    <div class="field item form-group">
                        <label for="lastname_th"
                            class="col-form-label col-md-3 col-sm-3  label-align">lastname_th<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text"name="lastname_th" id="lastname_th"
                                data-validate-minmax="10,100" required='required'>
                        </div>
                    </div>



                    <div class="field item form-group">
                        <label for="firstname_en"
                            class="col-form-label col-md-3 col-sm-3  label-align">firstname_en<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="firstname_en" id="firstname_en"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="lastname_en"
                            class="col-form-label col-md-3 col-sm-3  label-align">lastname_en<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="lastname_en" id="lastname_en"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="personnel_type_id"
                            class="col-form-label col-md-3 col-sm-3  label-align">personnel_type_id<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="personnel_type_id"
                                id="personnel_type_id" required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="personnel_type_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">personnel_type_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="personnel_type_name"
                                id="personnel_type_name" required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="position_id"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_id<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_id" id="position_id"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="position_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_name" id="position_name"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="position_type_id"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_type_id<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_type_id" id="position_type_id"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="position_type_th"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_type_th<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_type_th" id="position_type_th"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="faculty_code"
                            class="col-form-label col-md-3 col-sm-3  label-align">faculty_code<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="faculty_code" id="faculty_code"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="faculty_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">faculty_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="faculty_name" id="faculty_name"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="department_code"
                            class="col-form-label col-md-3 col-sm-3  label-align">department_code<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="department_code" id="department_code"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="department_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">department_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="department_name" id="department_name"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Executive
                            (ผู้บริหาร) <span
                                class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Executive" name="Executive" {{ old('Executive') ? 'checked' : '' }}/> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Planning_Analyst
                            (เจ้าหน้าที่แผน)<span
                                class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Planning_Analyst" name="Planning_Analyst" {{ old('Planning_Analyst') ? 'checked' : '' }}  /> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Department_head(หัวหน้าฝ่าย)<span
                                class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Department_head" name="Department_head" {{ old('Department_head') ? 'checked' : '' }}  /> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Supply_Analyst (นักวิชาการพัสดุ)<span
                                class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Supply_Analyst" name="Supply_Analyst" {{ old('Supply_Analyst') ? 'checked' : '' }}  /> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Responsible
                            (ผู้รับผิดชอบโครงการ)<span
                                class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Responsible" name="Responsible"  checked {{ old('Responsible') ? 'checked' : '' }}   /> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Admin
                            (แอดมิน)<span
                                class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Admin" name="Admin" {{ old('Admin') ? 'checked' : '' }}  /> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">สถานะ<span
                                class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="flag" name="flag" checked {{ old('flag') ? 'checked' : '' }}  /> 
                                </label>
                            </div>
                        </div>
                    </div>



                    {{-- <div class="field item form-group">
                        <label for="Executive" class="col-form-label col-md-3 col-sm-3  label-align">Executive
                            (ผู้บริหาร) <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="Executive" id="Executive"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="Planning_Analyst"
                            class="col-form-label col-md-3 col-sm-3  label-align">Planning_Analyst
                            (เจ้าหน้าที่แผน)<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="Planning_Analyst" id="Planning_Analyst"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="Department_head"
                            class="col-form-label col-md-3 col-sm-3  label-align">Department_head(หัวหน้าฝ่าย)<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="Department_head" id="Department_head"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="Supply_Analyst"
                            class="col-form-label col-md-3 col-sm-3  label-align">Supply_Analyst (นักวิชาการพัสดุ)<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="Supply_Analyst" id="Supply_Analyst"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="Responsible" class="col-form-label col-md-3 col-sm-3  label-align">Responsible
                            (ผู้รับผิดชอบโครงการ)<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="Responsible" id="Responsible"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="Admin" class="col-form-label col-md-3 col-sm-3  label-align">Admin
                            (แอดมิน)<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="Admin" id="Admin"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="flag" class="col-form-label col-md-3 col-sm-3  label-align">สถานะ<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="flag" id="flag"
                                required='required' data-validate-length-range="8,20" />
                        </div>
                    </div> --}}



                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary">Submit</button>
                                <button type='reset' class="btn btn-success">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Javascript functions	-->
<script>
    function hideshow() {
        var password = document.getElementById("password1");
        var slash = document.getElementById("slash");
        var eye = document.getElementById("eye");

        if (password.type === 'password') {
            password.type = "text";
            slash.style.display = "block";
            eye.style.display = "none";
        } else {
            password.type = "password";
            slash.style.display = "none";
            eye.style.display = "block";
        }

    }
</script>
