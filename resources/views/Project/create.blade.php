@extends('layout')
@section('title', 'Project')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>สร้างโครงการ</h2>
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
                    <form method="POST" action="/projectInsert"novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="yearID" class="form-control" required>
                                    @foreach ($year as $item)
                                        <option value="{{ $item->yearID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    data-validate-length-range="8,20" />
                                @error('name')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เจ้าของโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="user" id="user" required='required'
                                    value="{{ Auth::user()->username }}" data-validate-length-range="8,20" disabled />
                                @error('user')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary"
                                    onclick="addNewUserDropdown()">เพิ่มผู้รับผิดชอบ</button>
                            </div>
                        </div>

                        <div id="userDropdownContainer"></div>
                        {{-- <div class="row field item form-group align-items-center">
                            <div class="col-md-3 col-sm-3 "></div>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" id="userDropdown" style="display: none;">
                                    <option value="">เลือกผู้รับผิดชอบ</option>
                                </select>

                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type="button" style="display: none;" id="userDelete" class="btn btn-danger mt-2"
                                    onclick="removeSelectedUser()">ลบ</button>
                            </div>
                        </div> --}}


                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">สังกัด<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="affiliation" id="affiliation"
                                    required='required' data-validate-length-range="8,20" disabled />
                                @error('affiliation')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="format" class="col-form-label col-md-3 col-sm-3 label-align">format<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="format" name="format" class="form-control" required>
                                    <option value="team">team</option>
                                    <option value="department">department</option>
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="plan" class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="straID" name="straID" class="form-control" required>
                                    <!-- แผนจะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่มความสอดคล้อง</button>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="SFAID" name="SFAID" class="form-control" required>
                                    <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="goalID" name="goalID" class="form-control" required>
                                    <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="tacID" name="tacID" class="form-control" required>
                                    <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>



                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ประเภทโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">
                                <select id="type" name="proTypeID" class="form-control" required>
                                    @foreach ($projectType as $item)
                                        <option value="{{ $item->proTypeID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ลักษณะโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">
                                <select id="charecter" name="proChaID" class="form-control" required>
                                    @foreach ($projectCharec as $item)
                                        <option value="{{ $item->proChaID }}">
                                            {{ $item->pro_cha_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="integrat" class="col-form-label col-md-3 col-sm-3 label-align">การบูรณาการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="integrat" name="proInID" class="form-control" required
                                    onchange="toggleTextarea()">
                                    @foreach ($projectIntegrat as $item)
                                        <option value="{{ $item->proInID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center" id="otherTextContainer"
                            style="display: none;">
                            <label for="otherText" class="col-form-label col-md-3 col-sm-3 label-align"></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea id="otherText" name="otherText" class="form-control" placeholder="เรื่อง"></textarea>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">หลักการและเหตุผล<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 d-flex">
                                <textarea class="form-control" name="principle" id="principle" required='required'
                                    data-validate-length-range="8,20"></textarea>
                                @error('principle')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">วัตถุประสงค์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="objective" id="obj"
                                    required='required' data-validate-length-range="8,20" />

                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary">เพิ่ม</button>
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดความสำเร็จโครงการ</label>
                            <div class="row col-md-9 col-sm-9 border m-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title"
                                            class="col-form-label label-align">ตัวชี้วัดความสำเร็จ</label>
                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">หน่วยนับ</label>

                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ค่าเป้าหมาย</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="row col-md-4 col-sm-4 m-1">
                                        <input class="form-control" type="text" name="KPIProject" id="">
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="countProject" id="">

                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="targetProject" id="">
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่ม</button>

                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">กลุ่มเป้าหมาย<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="target" name="tarID" class="form-control" required>
                                    @foreach ($target as $item)
                                        <option value="{{ $item->tarID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 col-sm-1 m-1">
                                <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่ม</button>

                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ขั้นตอนการดำเนินการ</label>
                            <div class="row col-md-9 col-sm-9 border m-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">รายการกิจกรรม</label>
                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">เริ่มต้น</label>

                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">สิ้นสุด</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="row col-md-4 col-sm-4 m-1">
                                        <input class="form-control" type="text" name="stepName" id="">
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepStart" id="">

                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepEnd" id="">
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่ม</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3 label-align">แหล่งเงินประเภทงบประมาณที่ใช้<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="badget" name="badID" class="form-control" required>
                                    @foreach ($badgetType as $item)
                                        <option value="{{ $item->badID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">แผนงาน<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="planID" name="planID" class="form-control" required>
                                    @foreach ($uniplan as $item)
                                        <option value="{{ $item->planID }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-md-2 col-sm-2">ประเภทค่าใช้จ่าย</label>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <div class=" col-md-12 col-sm-12 border p-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-3 col-sm-3 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align"></label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">ไตรมาศ 1 (ต.ค-ธ.ค)</label>

                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ไตรมาศ 2
                                            (ม.ค-มี.ค)</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ไตรมาศ 3
                                            (เม.ย-มิ.ย)</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ไตรมาศ 4
                                            (ก.ค-ก.ย)</label>
                                    </div>
                                </div>


                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-3 col-sm-3 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ประเภทรายจ่าย</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">แผนการใใช้จ่าย</label>

                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">แผนการใใช้จ่าย</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">แผนการใใช้จ่าย</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">แผนการใใช้จ่าย</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">

                                    <div class="row col-md-3 col-sm-3 mr-1">
                                        <select id="expID" name="expID" class="form-control" required>
                                            <option value="" disabled selected>งบรายจ่าย</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 col-sm-1">
                                        <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่ม</button>

                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="row col-md-3 col-sm-3 mr-1">
                                        <select id="costType" name="costID" class="form-control" required>

                                        </select>
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control" type="text" name="costQu1" id="">
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control" type="text" name="costQu2" id="">
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control" type="text" name="costQu3" id="">
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control" type="text" name="costQu4" id="">
                                    </div>
                                    <div class="col-md-1 col-sm-1 ">
                                        <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่ม</button>

                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประมาณการงบประมาณที่ใช้<span
                                    class="required">*</span></label>
                            <div class="col-md-3 col-sm-3">
                                <input class="form-control" type="text" name="affiliation" id="affiliation"
                                    required='required' data-validate-length-range="8,20" disabled />

                            </div>
                            <div class="col-md-5 col-sm-5">
                                <input class="form-control" type="text" name="affiliation" id="affiliation"
                                    required='required' data-validate-length-range="8,20" disabled />

                            </div>

                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประโยชน์ที่คาดว่าจะได้รับ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="benefit" id="benefit"
                                    required='required' data-validate-length-range="8,20" />
                                @error('object')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-1 col-sm-1 ">
                                <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่ม</button>

                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ไฟล์เอกสารประกอบโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="file" name="object" id="object"
                                    required='required' data-validate-length-range="8,20" />
                                @error('object')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-1 col-sm-1 ">
                                <button type='submit' class="btn btn-primary" value="บันทึก">เพิ่ม</button>

                            </div>
                        </div>

                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-primary" value="บันทึก">บันทึก</button>
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
        const strategic = @json($strategic); // ข้อมูลแผนยุทธศาสตร์
        const issues = @json($SFA); // ข้อมูลประเด็นยุทธศาสตร์
        const goals = @json($goal); // ข้อมูลเป้าประสงค์
        const tactics = @json($tactics); // ข้อมูลกลยุทธ์

        const funds = @json($fund);
        const expenses = @json($expanses);
        const costTypes = @json($costTypes);

        const proIn = @json($projectIntegrat);

        const users = @json($user);
        const currentUserId = {{ Auth::user()->id }};

        function addNewUserDropdown() {
            const dropdownCount = document.querySelectorAll('.userDropdown').length + 1;

            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMd3 = document.createElement('div');
            colMd3.classList.add('col-md-3', 'col-sm-3');
             // ใส่ข้อความหรือเนื้อหา

            const dropdownCol = document.createElement('div');
            dropdownCol.classList.add('col-md-6', 'col-sm-6');

            const userDropdown = document.createElement('select');
            userDropdown.classList.add('form-control', 'userDropdown'); // เพิ่มคลาสเพื่อทำให้สามารถระบุได้ง่ายขึ้น
            userDropdown.id = `userDropdown${dropdownCount}`;
            userDropdown.innerHTML = '';

            users.forEach(user => {
                if (user.id != currentUserId ) {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.firstname_th;
                userDropdown.appendChild(option);
                }
            });

            dropdownCol.appendChild(userDropdown);
            mainContainer.appendChild(colMd3);
            mainContainer.appendChild(dropdownCol);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('userDropdownContainer').appendChild(mainContainer);
        }
        // function showDropdown() {
        //     const userDropdown = document.getElementById('userDropdown');
        //     const userDelete = document.getElementById('userDelete');
        //     console.log('showDropdown called'); // ตรวจสอบว่าเรียกฟังก์ชันจริง
        //     console.log('Current users:', users);
        //     userDropdown.style.display = 'block';
        //     userDelete.style.display = 'block';
        //     userDropdown.innerHTML = '';
        //     users.forEach(user => {
        //         if (user.id != currentUserId) {
        //             const option = document.createElement('option');
        //             option.value = user.id;
        //             option.textContent = user.firstname_th;
        //             userDropdown.appendChild(option);
        //         }
        //     });
        // }
        //     function removeSelectedUser() {
        //         // ดึง dropdown element
        //         const userDropdown = document.getElementById('userDropdown');
        // const userDelete = document.getElementById('userDelete');

        //         // ตรวจสอบว่ามีตัวเลือกที่ถูกเลือกหรือไม่
        //         if (userDropdown.selectedIndex !== -1) {
        //             // ลบตัวเลือกที่เลือกอยู่
        //             userDropdown.remove(userDropdown.selectedIndex);

        //             // ตรวจสอบว่ามีตัวเลือกเหลือหรือไม่ ถ้าไม่มีให้ซ่อนปุ่มลบ

        //                 userDropdown.style.display = 'none';
        //                 userDelete.style.display = 'none';

        //         }
        //     }


        function toggleTextarea() {
            var select = document.getElementById("integrat");
            var otherTextContainer = document.getElementById("otherTextContainer");

            if (select.value === '6') {
                otherTextContainer.style.display = "flex";
            } else {
                otherTextContainer.style.display = "none";
            }
        }



        // ฟังก์ชันอัปเดต dropdown ของแผน
        function updatePlanDropdown(selectedYearID) {
            const planSelect = document.getElementById('straID');
            planSelect.innerHTML = '';

            const filteredPlans = strategic.filter(plan => plan.yearID == selectedYearID);

            if (filteredPlans.length === 0) {
                const noPlanOption = document.createElement('option');
                noPlanOption.value = '';
                noPlanOption.textContent = 'ไม่มีแผนยุทธศาสตร์';
                planSelect.appendChild(noPlanOption);
                planSelect.disabled = true;
                updateIssueDropdown(null);
            } else {
                planSelect.disabled = false;
                filteredPlans.forEach(plan => {
                    const option = document.createElement('option');
                    option.value = plan.straID;
                    option.textContent = plan.name;
                    planSelect.appendChild(option);
                });
                updateIssueDropdown(filteredPlans[0].straID);
            }
        }

        // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
        function updateIssueDropdown(selectedPlanID) {
            const issueSelect = document.getElementById('SFAID');
            issueSelect.innerHTML = '';

            if (!selectedPlanID) {
                const noIssueOption = document.createElement('option');
                noIssueOption.value = '';
                noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสาตร์';
                issueSelect.appendChild(noIssueOption);
                issueSelect.disabled = true;
                updateGoalDropdown(null);
                return;
            }

            const filteredIssues = issues.filter(issue => issue.straID == selectedPlanID);

            if (filteredIssues.length === 0) {
                const noIssueOption = document.createElement('option');
                noIssueOption.value = '';
                noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                issueSelect.appendChild(noIssueOption);
                issueSelect.disabled = true;
                updateGoalDropdown(null);
            } else {
                issueSelect.disabled = false;
                filteredIssues.forEach(issue => {
                    const option = document.createElement('option');
                    option.value = issue.SFAID;
                    option.textContent = issue.name;
                    issueSelect.appendChild(option);
                });
                updateGoalDropdown(filteredIssues[0].SFAID);

            }
        }

        // ฟังก์ชันอัปเดต dropdown ของกลยุทธ์ผ่านการเชื่อมต่อจากประเด็นยุทธศาสตร์และเป้าประสงค์
        function updateGoalDropdown(selectedSFAID) {
            const goalSelect = document.getElementById('goalID');
            goalSelect.innerHTML = '';

            if (!selectedSFAID) {
                const noGoalOption = document.createElement('option');
                noGoalOption.value = '';
                noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                goalSelect.appendChild(noGoalOption);
                goalSelect.disabled = true;
                updateTacticsDropdown(null);
                return;
            }

            // กรองประเด็นยุทธศาสตร์ที่เชื่อมกับแผนที่เลือก
            const filteredGoals = goals.filter(goal => goal.SFAID == selectedSFAID);

            if (filteredGoals.length === 0) {
                const noGoalOption = document.createElement('option');
                noGoalOption.value = '';
                noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                goalSelect.appendChild(noGoalOption);
                goalSelect.disabled = true;
                updateTacticsDropdown(null);
            } else {
                goalSelect.disabled = false;
                filteredGoals.forEach(goal => {
                    const option = document.createElement('option');
                    option.value = goal.goalID;
                    option.textContent = goal.name;
                    goalSelect.appendChild(option);
                });
                updateTacticsDropdown(filteredGoals[0].goalID);

            }
        }

        // ฟังก์ชันอัปเดต dropdown ของกลยุทธ์ผ่านการเชื่อมต่อจากประเด็นยุทธศาสตร์และเป้าประสงค์
        function updateTacticsDropdown(selectedGoalID) {
            const tacticsSelect = document.getElementById('tacID');
            tacticsSelect.innerHTML = '';

            if (!selectedGoalID) {
                const noTacticsOption = document.createElement('option');
                noTacticsOption.value = '';
                noTacticsOption.textContent = 'ไม่มีกลยุทธ์';
                tacticsSelect.appendChild(noTacticsOption);
                tacticsSelect.disabled = true;
                return;
            }

            // กรองประเด็นยุทธศาสตร์ที่เชื่อมกับแผนที่เลือก
            const filteredTactics = tactics.filter(tactic => tactic.goalID == selectedGoalID);

            if (filteredTactics.length === 0) {
                const noTacticsOption = document.createElement('option');
                noTacticsOption.value = '';
                noTacticsOption.textContent = 'ไม่มีกลยุทธ์';
                tacticsSelect.appendChild(noTacticsOption);
                tacticsSelect.disabled = true;
            } else {
                tacticsSelect.disabled = false;
                filteredTactics.forEach(tactic => {
                    const option = document.createElement('option');
                    option.value = tactic.tacID;
                    option.textContent = tactic.name;
                    tacticsSelect.appendChild(option);
                });
            }
            // แสดงกลยุทธ์ใน dropdown

        }

        function updateExpenseDropdown(selectedPlanID) {
            const expenseSelect = document.getElementById('expID');
            expenseSelect.innerHTML = '';

            // กรองกองทุนที่เชื่อมกับแผน
            const relatedFunds = funds.filter(fund => fund.planID == selectedPlanID);

            // กรองงบรายจ่ายตามกองทุนที่เชื่อมกับแผน
            const filteredExpenses = expenses.filter(expense =>
                relatedFunds.some(fund => fund.fundID == expense.fundID)
            );

            if (filteredExpenses.length === 0) {
                const noExpenseOption = document.createElement('option');
                noExpenseOption.value = '';
                noExpenseOption.textContent = 'ไม่มีงบรายจ่าย';
                expenseSelect.appendChild(noExpenseOption);
                updateCostTypeDropdown(null);
                expenseSelect.disabled = true; // Disable expense dropdown
            } else {
                expenseSelect.disabled = false; // Enable expense dropdown
                filteredExpenses.forEach(expense => {
                    const option = document.createElement('option');
                    option.value = expense.expID;
                    option.textContent = expense.exname;
                    expenseSelect.appendChild(option);
                });
                updateCostTypeDropdown(filteredExpenses[0].expID);
            }
        }

        function updateCostTypeDropdown(selectedEXPID) {
            const costTypeSelect = document.getElementById('costType');
            costTypeSelect.innerHTML = '';

            // กรองกองทุนที่เชื่อมกับแผน
            const filteredCostType = costTypes.filter(costType => costType.expID == selectedEXPID);

            if (filteredCostType.length === 0) {
                const noCostTypeOption = document.createElement('option');
                noCostTypeOption.value = '';
                noCostTypeOption.textContent = 'ไม่มีหมวดรายจ่าย';
                costTypeSelect.appendChild(noCostTypeOption);
                costTypeSelect.disabled = true; // Disable expense dropdown
            } else {
                costTypeSelect.disabled = false; // Enable expense dropdown
                filteredCostType.forEach(costType => {
                    const option = document.createElement('option');
                    option.value = costType.costID;
                    option.textContent = costType.costname;
                    costTypeSelect.appendChild(option);
                });
            }
        }

        // Event listeners สำหรับ dropdown ต่าง ๆ
        window.onload = function() {
            const yearSelect = document.getElementById('year');
            const StrategicSelect = document.getElementById('straID');
            const SFASelect = document.getElementById('SFAID');
            const goalSelect = document.getElementById('goalID');

            const planSelect = document.getElementById('planID');
            const EXPSelect = document.getElementById('expID');


            // เมื่อเปลี่ยนปีงบประมาณ
            yearSelect.addEventListener('change', function() {
                const selectedYearID = this.value;
                updatePlanDropdown(selectedYearID);
            });

            // เมื่อเปลี่ยนแผนยุทธศาสตร์
            StrategicSelect.addEventListener('change', function() {
                const selectedStraID = this.value;
                updateIssueDropdown(selectedStraID);

            });

            SFASelect.addEventListener('change', function() {
                const selectedSFAID = this.value;
                updateGoalDropdown(selectedSFAID);
            });

            goalSelect.addEventListener('change', function() {
                const selectedGoalID = this.value;
                updateTacticsDropdown(selectedGoalID);
            });

            planSelect.addEventListener('change', function() {
                const selectedPlanID = this.value;
                updateExpenseDropdown(selectedPlanID);
            });
            EXPSelect.addEventListener('change', function() {
                const selectedEXPID = this.value;
                updateCostTypeDropdown(selectedEXPID);
            });

            // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
            const defaultYearID = yearSelect.value;
            if (defaultYearID) {
                updatePlanDropdown(defaultYearID);
            }

            const defaultPlanID = planSelect.value;
            if (defaultPlanID) {
                updateExpenseDropdown(defaultPlanID);
            }
        };
    </script>
@endsection
