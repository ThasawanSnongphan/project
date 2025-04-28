<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Users</h2>
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
                <form action="/uInsert" method="post" novalidate>
                    @csrf
                    <div class="field item form-group">
                        <label for="username" class="col-form-label col-md-3 col-sm-3  label-align">UserName<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" data-validate-length-range="6"
                                data-validate-words="2" name="username" id="username" required="required" />
                            @error('username')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="field item form-group">
                        <label for="email" class="col-form-label col-md-3 col-sm-3  label-align">email<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" id="email" class='email' required="required"
                                type="email" />
                            @error('email')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="password1" class="col-form-label col-md-3 col-sm-3  label-align">Password<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="password" id="password1" name="password"
                                title="Minimum 8 Characters Including An Upper And Lower Case Letter, A Number And A Unique Character"
                                required />
                            @error('password')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
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
                                @error('password2')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>




                    {{-- <div class="field item form-group">
                        <label for="firstname_en"
                            class="col-form-label col-md-3 col-sm-3  label-align">firstname_en<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="firstname_en" id="firstname_en"
                                required='required' data-validate-length-range="8,20" />
                                @error('firstname_en')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="lastname_en"
                            class="col-form-label col-md-3 col-sm-3  label-align">lastname_en<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="lastname_en" id="lastname_en"
                                required='required' data-validate-length-range="8,20" />
                                @error('lastname_en')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="personnel_type_id"
                            class="col-form-label col-md-3 col-sm-3  label-align">personnel_type_id<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="personnel_type_id"
                                id="personnel_type_id" required='required' data-validate-length-range="8,20" />
                                @error('personnel_type_id')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="personnel_type_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">personnel_type_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="personnel_type_name"
                                id="personnel_type_name" required='required' data-validate-length-range="8,20" />
                                @error('personnel_type_name')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="position_id"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_id<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_id" id="position_id"
                                required='required' data-validate-length-range="8,20" />
                                @error('position_id')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="field item form-group">
                        <label for="displayname"
                            class="col-form-label col-md-3 col-sm-3  label-align">displayname<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="displayname" id="displayname"
                                required='required' data-validate-length-range="8,20" />
                                @error('displayname')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="person_key"
                            class="col-form-label col-md-3 col-sm-3  label-align">person_key<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="person_key" id="person_key"
                                required='required' data-validate-length-range="8,20" />
                                @error('person_key')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="position_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_name" id="position_name"
                                required='required' data-validate-length-range="8,20" />
                                @error('position_name')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="field item form-group">
                        <label for="position_type_id"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_type_id<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_type_id" id="position_type_id"
                                required='required' data-validate-length-range="8,20" />
                                @error('position_type_id')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="position_type_th"
                            class="col-form-label col-md-3 col-sm-3  label-align">position_type_th<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="position_type_th" id="position_type_th"
                                required='required' data-validate-length-range="8,20" />
                                @error('position_type_th')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    {{-- <div class="field item form-group">
                        <label for="faculty_code"
                            class="col-form-label col-md-3 col-sm-3  label-align">faculty_code<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="faculty_code" id="faculty_code"
                                required='required' data-validate-length-range="8,20" />
                                @error('faculty_code')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="field item form-group">
                        <label for="faculty_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">faculty_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="faculty_name" id="faculty_name"
                                required='required' data-validate-length-range="8,20" />
                                @error('faculty_name')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="field item form-group">
                        <label for="department_code"
                            class="col-form-label col-md-3 col-sm-3  label-align">department_code<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="department_code" id="department_code"
                                required='required' data-validate-length-range="8,20" />
                                @error('department_code')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="field item form-group">
                        <label for="department_name"
                            class="col-form-label col-md-3 col-sm-3  label-align">department_name<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="department_name" id="department_name"
                                required='required' data-validate-length-range="8,20" />
                                @error('department_name')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Executive
                            (ผู้บริหาร)</label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Executive" name="Executive"
                                        {{ old('Executive') ? 'checked' : '' }} />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Planning_Analyst
                            (เจ้าหน้าที่แผน)</label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Planning_Analyst"
                                        name="Planning_Analyst" {{ old('Planning_Analyst') ? 'checked' : '' }} />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label
                            class="col-form-label col-md-3 col-sm-3 label-align">Department_head(หัวหน้าฝ่าย)</label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Department_head"
                                        name="Department_head" {{ old('Department_head') ? 'checked' : '' }} />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Supply_Analyst
                            (นักวิชาการพัสดุ)</label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Supply_Analyst"
                                        name="Supply_Analyst" {{ old('Supply_Analyst') ? 'checked' : '' }} />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Responsible
                            (ผู้รับผิดชอบโครงการ)<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Responsible" name="Responsible"
                                        checked {{ old('Responsible') ? 'checked' : '' }} />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Admin
                            (แอดมิน)</label>
                        <div class="col-md-9 col-sm-9 ">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" id="Admin" name="Admin"
                                        {{ old('Admin') ? 'checked' : '' }} />
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
                                    <input type="checkbox" class="js-switch" id="flag" name="flag" checked
                                        {{ old('flag') ? 'checked' : '' }} />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3 text-center">
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
