@extends('layout')
@section('title', 'Project')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>เขียนโครงการ</h2>
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
                    <form method="POST" action="{{ route('project.update', $project->proID) }}"novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="yearID" class="form-control" required>
                                    @foreach ($year as $item)
                                        <option value="{{ $item->yearID }}" <?php if ($item->yearID == $project->yearID) {
                                            echo 'selected';
                                        } ?>>{{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    data-validate-length-range="8,20" value="{{ $project->name }}" />
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
                                <input type="hidden" name="userID[]" id="userID" value="{{ Auth::user()->userID }}">
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

                        @foreach ($userMap as $index => $item)
                            @if ($item->proID === $project->proID && $item->userID !== Auth::user()->userID)
                                <div class="row field item form-group align-items-center">
                                    <div class="col-md-3 col-sm-3"></div>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="userID[]" id="userID" class="form-control">
                                            @foreach ($user as $users)
                                                @if ($users->userID !== Auth::user()->userID)
                                                    <option value="{{ $users->userID }}"
                                                        @if ($users->userID === $item->userID) selected @endif>
                                                        {{ $users->firstname_en }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <button type="button" class="btn btn-danger "
                                            onclick="this.closest('.row').remove()">ลบ</button>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div id="userDropdownContainer"></div>


                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">สังกัด<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="affiliation" id="affiliation"
                                    required='required' data-validate-length-range="8,20" disabled
                                    value="{{ Auth::user()->faculty_name }}" />
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
                                    <option value="team" <?php if ($project->format == 'team') {
                                        echo 'selected';
                                    } ?>>team</option>
                                    <option value="department" <?php if ($project->format == 'department') {
                                        echo 'selected';
                                    } ?>>department</option>
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="plan" class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="straID" name="straID[]" class="form-control" required
                                    onchange="KPIMainNone()">

                                    <!-- แผนจะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary"
                                    onclick="insertStrategic()">เพิ่มความสอดคล้อง</button>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-9 border mb-2 p-2">
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="SFAID" name="SFAID[]" class="form-control" required>
                                        <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                    </select>
                                </div>
                            </div>

                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="goalID" name="goalID[]" class="form-control" required>
                                        <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                    </select>
                                </div>
                            </div>

                            <div class="row field item form-group align-items-center">
                                <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="tacID" name="tacID[]" class="form-control" required>
                                        <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row field item form-group align-items-center">
                            <label for="plan" class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="straID" name="straID[]" class="form-control" required
                                    onchange="KPIMainNone()">

                                    <!-- แผนจะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                           
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-9 border mb-2 p-2">
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="SFAID" name="SFAID[]" class="form-control" required>
                                        <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                    </select>
                                </div>
                            </div>

                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="goalID" name="goalID[]" class="form-control" required>
                                        <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                    </select>
                                </div>
                            </div>

                            <div class="row field item form-group align-items-center">
                                <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="tacID" name="tacID[]" class="form-control" required>
                                        <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        <div id="insertStrategic"></div>


                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ประเภทโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">
                                <select id="type" name="proTypeID" class="form-control" required>
                                    @foreach ($projectType as $item)
                                        <option value="{{ $item->proTypeID }}" <?php if ($item->proTypeID == $project->proTypeID) {
                                            echo 'selected';
                                        } ?>>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ลักษณะโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">
                                <select id="charecter" name="proChaID" class="form-control" required>
                                    @foreach ($projectCharec as $item)
                                        <option value="{{ $item->proChaID }}" <?php if ($item->proChaID == $project->proChaID) {
                                            echo 'selected';
                                        } ?>>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">การบูรณาการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="integrat" name="proInID" class="form-control" required
                                    onchange="toggleTextarea()">
                                    @foreach ($projectIntegrat as $item)
                                        <option value="{{ $item->proInID }}" <?php if ($item->proInID == $project->proInID) {
                                            echo 'selected';
                                        } ?>>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center" id="otherTextContainer"
                            style="display: none;">
                            <label for="proInDetail" class="col-form-label col-md-3 col-sm-3 label-align"></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea id="proInDetail" name="proInDetail" class="form-control" placeholder="เรื่อง">{{ $project->proInDetail }}</textarea>
                            </div>
                        </div>


                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">หลักการและเหตุผล<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea class="form-control" name="principle" id="principle" required='required'
                                    data-validate-length-range="8,20">{{ $project->princiDetail }}</textarea>
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

                                <input class="form-control" type="text" name="obj[]" id="obj"
                                    required='required' data-validate-length-range="8,20"
                                    value="{{ $objProject->detail ?? '' }}" />
                                <input type="hidden" name="objID[]" value="{{ $objProject->objID }}">
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary" onclick="insertObj()">เพิ่ม</button>
                            </div>
                        </div>

                        @foreach ($obj as $index => $item)
                            @if ($index > 0 && $item->proID == $project->proID && $item->objID != $objProject->objID)
                                <div class="row field item form-group align-items-center">
                                    <div class="col-md-3 col-sm-3"></div>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" name="obj[]"
                                            value="{{ $item->detail }}" required="required" />
                                        <input type="hidden" name="objID[]" value="{{ $item->objID }}">

                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <button type="button" class="btn btn-danger "
                                            onclick="this.closest('.row').remove()">ลบ</button>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div id="insertObj"></div>


                        <div class="row field item form-group align-items-center" id="KPIMainNone"
                            style="display: flex;">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของแผน</label>
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
                                    <div class="col-md-4 col-sm-4 m-1">
                                        <select id="KPIMain" name="KPIMainID[]" class="form-control" required>
                                            <!-- KPIจะถูกโหลดที่นี่ -->
                                        </select>
                                    </div>
                                    <div class=" col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="countMain[]" id="countMain"
                                            disabled>

                                    </div>
                                    <div class=" col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="targetMain[]" id="targetMain"
                                            disabled>
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertKPIMain()">เพิ่ม</button>

                                    </div>
                                </div>
                                <div id="insertKPIMain"></div>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ตัวชีวัดความสำเร็จโครงการ</label>
                            <div class="row col-md-9 col-sm-9 border m-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title"
                                            class="col-form-label label-align">ตัวชีวัดความสำเร็จ</label>
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
                                <div class="row col-md-12 col-sm-12">
                                    <div class="row col-md-4 col-sm-4 m-1">
                                        <input class="form-control" type="hidden" name="KPIProID[]" id=""
                                            @if (!empty($KPIProject->KPIProID)) value="{{ $KPIProject->KPIProID }}" @endif>
                                        <input class="form-control" type="text" name="KPIProject[]" id=""
                                            @if (!empty($KPIProject->KPIProID)) value="{{ $KPIProject->name }}" @endif>
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <select id="countKPIProject" name="countKPIProject[]" class="form-control"
                                            required>
                                            <option value="">--</option>
                                            @if (!empty($KPIProject->KPIProID))
                                                @foreach ($CountKPIProjects as $item)
                                                    <option value="{{ $item->countKPIProID }}" <?php if ($item->countKPIProID == $KPIProject->countKPIProID) {
                                                        echo 'selected';
                                                    } ?>>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">--</option>
                                                @foreach ($CountKPIProjects as $item)
                                                    <option value="{{ $item->countKPIProID }}">
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="targetProject[]" id=""
                                            @if (!empty($KPIProject->KPIProID)) value="{{ $KPIProject->target }}" @endif>
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertKPIProject()">เพิ่ม</button>

                                    </div>
                                </div>
                                @if (!empty($KPIProjects))
                                    @foreach ($KPIProjects as $index => $item)
                                        @if ($index > 0 && $item->proID == $project->proID && $item->KPIProID != $KPIProject->KPIProID)
                                            {{-- <div class="row field item form-group align-items-center"> --}}
                                            <div class="row col-md-12 col-sm-12">
                                                <div class="row col-md-4 col-sm-4 m-1">
                                                    <input class="form-control" type="hidden" name="KPIProID[]"
                                                        id="" value="{{ $item->KPIProID }}">
                                                    <input class="form-control" type="text" name="KPIProject[]"
                                                        id="" value="{{ $item->name }}">
                                                </div>
                                                <div class="row col-md-3 col-sm-3 m-1">
                                                    <select id="countKPIProject" name="countKPIProject[]"
                                                        class="form-control" required>
                                                        @foreach ($CountKPIProjects as $count)
                                                            <option value="{{ $count->countKPIProID }}">
                                                                {{ $count->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="row col-md-3 col-sm-3 m-1">
                                                    <input class="form-control" type="text" name="targetProject[]"
                                                        id="" value="{{ $item->target }}">
                                                </div>
                                                <div class="col-md-1 col-sm-1 m-1">
                                                    <button type="button" class="btn btn-danger "
                                                        onclick="this.closest('.row').remove()">ลบ</button>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                        @endif
                                    @endforeach
                                @endif
                                <div id="insertKPIProject"></div>
                            </div>
                        </div>



                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">กลุ่มเป้าหมาย<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="target" name="tarID" class="form-control" required>
                                    @foreach ($target as $item)
                                        <option value="{{ $item->tarID }}" <?php if ($item->tarID == $project->tarID) {
                                            echo 'selected';
                                        } ?>>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
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
                                <div class="row col-md-12 col-sm-12">
                                    <div class="row col-md-4 col-sm-4 m-1">
                                        <input class="form-control" type="hidden" name="stepID[]" id=""
                                            @if (!empty($step->stepID)) value="{{ $step->stepID }}" @endif>
                                        <input class="form-control" type="text" name="stepName[]" id=""
                                            @if (!empty($step->stepID)) value="{{ $step->name }}" @endif>
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepStart[]" id=""
                                            @if (!empty($step->stepID)) value="{{ $step->start }}" @endif>

                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepEnd[]" id=""
                                            @if (!empty($step->stepID)) value="{{ $step->end }}" @endif>
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertStep()">เพิ่ม</button>

                                    </div>
                                </div>
                                @if (!empty($step))
                                    @foreach ($steps as $index => $item)
                                        @if ($index > 0 && $item->proID == $project->proID && $item->stepID != $step->stepID)
                                            <div class="row col-md-12 col-sm-12">
                                                <div class="row col-md-4 col-sm-4 m-1">
                                                    <input class="form-control" type="hidden" name="stepID[]"
                                                        id="" value="{{ $item->stepID }}">
                                                    <input class="form-control" type="text" name="stepName[]"
                                                        id="" value="{{ $item->name }}">
                                                </div>
                                                <div class="row col-md-3 col-sm-3 m-1">
                                                    <input class="form-control" type="date" name="stepStart[]"
                                                        id="" value="{{ $item->start }}">

                                                </div>
                                                <div class="row col-md-3 col-sm-3 m-1">
                                                    <input class="form-control" type="date" name="stepEnd[]"
                                                        id="" value="{{ $item->end }}">
                                                </div>
                                                <div class="col-md-1 col-sm-1 m-1">
                                                    <button type="button" class="btn btn-danger "
                                                        onclick="this.closest('.row').remove()">ลบ</button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div id="insertStep"></div>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3 label-align">แหล่งเงินประเภทงบประมาณที่ใช้<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="badget" name="badID" class="form-control" required>
                                    @foreach ($badgetType as $item)
                                        <option value="{{ $item->badID }}" <?php if ($item->badID == $project->badID) {
                                            echo 'selected';
                                        } ?>>
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
                                        <option value="{{ $item->planID }}" <?php if ($item->planID == $project->planID) {
                                            echo 'selected';
                                        } ?>>{{ $item->name }}
                                        </option>
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

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 mt-2">
                                    <div class="row col-md-3 col-sm-3 mr-1">
                                        <select id="costType" name="costID" class="form-control" required>

                                        </select>
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control" type="hidden" name="costQuID[]" id="costQuID"
                                            @if (!empty($costQuarter->costQuID)) value="{{ $costQuarter->costQuID }}" @endif>
                                        <input class="form-control cost-input" type="text" name="costQu1[]" id=""
                                            @if (!empty($costQuarter->costQu1)) value="{{ $costQuarter->costQu1 }}" @endif>
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control cost-input" type="text" name="costQu2[]"
                                            id=""
                                            @if (!empty($costQuarter->costQu2)) value="{{ $costQuarter->costQu2 }}" @endif>
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control cost-input" type="text" name="costQu3[]"
                                            id=""
                                            @if (!empty($costQuarter->costQu3)) value="{{ $costQuarter->costQu3 }}" @endif>
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control cost-input" type="text" name="costQu4[]"
                                            id=""
                                            @if (!empty($costQuarter->costQu4)) value="{{ $costQuarter->costQu4 }}" @endif>
                                    </div>
                                    <div class="col-md-1 col-sm-1">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertCostType()">เพิ่ม</button>

                                    </div>
                                </div>
                                @if (!empty($costQuarters))
                                    @foreach ($costQuarters as $index => $item)
                                        @if ($index > 0 && $item->proID == $project->proID && $item->costQuID != $costQuarter->costQuID)
                                            <div class="row col-md-12 col-sm-12">

                                                <div class="row col-md-3 col-sm-3 mr-1">
                                                    <select id="expID" name="expID" class="form-control" required>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row col-md-12 col-sm-12 mt-2">
                                                <div class="row col-md-3 col-sm-3 mr-1">
                                                    <select id="costType" name="costID" class="form-control" required>

                                                    </select>
                                                </div>
                                                <div class="row col-md-2 col-sm-2 mr-1">
                                                    <input class="form-control" type="hidden" name="costQuID[]"
                                                        id="" value="{{ $item->costQuID }}">
                                                    <input class="form-control cost-input" type="text" name="costQu1[]"
                                                        id="" value="{{ $item->costQu1 }}">
                                                </div>
                                                <div class="row col-md-2 col-sm-2 mr-1">
                                                    <input class="form-control cost-input" type="text" name="costQu2[]"
                                                        id="" value="{{ $item->costQu2 }}">
                                                </div>
                                                <div class="row col-md-2 col-sm-2 mr-1">
                                                    <input class="form-control cost-input" type="text" name="costQu3[]"
                                                        id="" value="{{ $item->costQu3 }}">
                                                </div>
                                                <div class="row col-md-2 col-sm-2 mr-1">
                                                    <input class="form-control cost-input" type="text" name="costQu4[]"
                                                        id="" value="{{ $item->costQu4 }}">
                                                </div>
                                                <div class="col-md-1 col-sm-1 m-1">
                                                    <button type="button" class="btn btn-danger "
                                                        onclick="this.closest('.row').remove()">ลบ</button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div id="insertExpense"></div>
                                <div id="insertCostType"></div>
                            </div>
                        </div>




                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประมาณการงบประมาณที่ใช้<span
                                    class="required">*</span></label>
                            <div class="col-md-3 col-sm-3">
                                <input class="form-control" type="text" name="badgetTotal" id="badgetTotal"
                                    required='required' data-validate-length-range="8,20" disabled
                                    value="{{ $project->badgetTotal }}" />

                            </div>
                            <div class="col-md-5 col-sm-5">
                                <input class="form-control" type="text" name="badgetTotalText" id="badgetTotalText"
                                    required='required' data-validate-length-range="8,20" disabled />

                            </div>

                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประโยชน์ที่คาดว่าจะได้รับ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="hidden" name="bnfID[]" id="benefit"
                                    required='required' data-validate-length-range="8,20"
                                    @if (!empty($benefit->bnfID)) value="{{ $benefit->bnfID }}" @endif>
                                <input class="form-control" type="text" name="benefit[]" id="benefit"
                                    required='required' data-validate-length-range="8,20"
                                    @if (!empty($benefit->bnfID)) value="{{ $benefit->detail }}" @endif>
                                @error('benefit')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-1 col-sm-1 ">
                                <button type='button' class="btn btn-primary" onclick="insertBenefit()">เพิ่ม</button>

                            </div>
                        </div>
                        @if (!empty($benefits))
                            @foreach ($benefits as $index => $item)
                                @if ($index > 0 && $item->proID == $project->proID && $item->bnfID != $benefit->bnfID)
                                    <div class="row field item form-group align-items-center">
                                        <div class="col-md-3 col-sm-3"></div>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" type="hidden" name="bnfID[]" id="benefit"
                                                required='required' data-validate-length-range="8,20"
                                                value="{{ $item->bnfID }}" />
                                            <input class="form-control" type="text" name="benefit[]" id="benefit"
                                                required='required' data-validate-length-range="8,20"
                                                value="{{ $item->detail }}" />

                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <button type="button" class="btn btn-danger "
                                                onclick="this.closest('.row').remove()">ลบ</button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div id="insertBenefit"></div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ไฟล์เอกสารประกอบโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="file" name="file" id="object"
                                    required='required' data-validate-length-range="8,20" />
                                @error('file')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-1 col-sm-1 ">
                                <button type='button' class="btn btn-primary" onclick="insertFile()">เพิ่ม</button>

                            </div>
                        </div>
                        <div id="insertFile"></div>


                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-primary"
                                        onclick="submitButton('save')">บันทึก</button>
                                    <button type='button' class="btn btn-primary"
                                        onclick="submitButton('send')">ส่ง</button>
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
        const KPIMains = @json($KPIMain);
        const funds = @json($fund);
        const expenses = @json($expanses);
        const costTypes = @json($costTypes);
        const strategicMaps = @json($project->strategicMap);
        const proIn = @json($projectIntegrat);

        const users = @json($user);
        const currentUserId = {{ Auth::user()->userID }};

        function calculateTotal() {
            // ดึงค่าจากช่อง input ที่มี class "cost-input"
            const inputs = document.querySelectorAll('.cost-input');
            let total = 0;

            // รวมค่าของแต่ละช่อง
            inputs.forEach(input => {
                const value = parseFloat(input.value) || 0; // แปลงค่าเป็นตัวเลข ถ้าไม่มีให้ใช้ 0
                total += value;
            });

            // แสดงผลรวมในช่อง badgetTotal
            document.getElementById('badgetTotal').value = total.toFixed(2); // แสดงผลแบบทศนิยม 2 ตำแหน่ง
        }

        // เพิ่ม event listener ให้ช่อง input ที่มี class "cost-input"
        document.querySelectorAll('.cost-input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        // เรียกคำนวณครั้งแรก (กรณีมีค่าเริ่มต้นในช่อง input)
        calculateTotal();

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
            userDropdown.id = `userID${dropdownCount}`;
            userDropdown.innerHTML = '';
            userDropdown.name = 'userID[]';

            users.forEach(user => {
                if (user.userID != currentUserId) {
                    const option = document.createElement('option');
                    option.value = user.userID;
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

        function insertStrategic() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            // สร้าง label
            const straLabel = document.createElement('label');
            straLabel.setAttribute('for', 'strategicInput'); // ตั้งค่า for ให้ตรงกับ input หรือ select ที่จะใช้
            straLabel.classList.add('col-form-label', 'col-md-3', 'col-sm-3', 'label-align');
            straLabel.textContent = 'แผนยุทธศาสตร์'; // ตั้งข้อความใน label

            // เพิ่ม label ลงใน mainContainer
            mainContainer.appendChild(straLabel);

            const divstraID = document.createElement('div');
            divstraID.classList.add('col-md-6', 'col-sm-6');

            const straDropdown = document.createElement('select');
            straDropdown.classList.add('form-control');
            // straDropdown.id = 'straID1';
            const uniqueID = `straID_${Date.now()}`;
            straDropdown.id = uniqueID;
            straDropdown.name = 'straID[]';

            const selectedYearID = document.getElementById('year').value;
            // const planSelect = document.getElementById('straID1');
            // planSelect.innerHTML = '';

            const filteredPlans = strategic.filter(plan => plan.yearID == selectedYearID);

            if (filteredPlans.length === 0) {
                const noPlanOption = document.createElement('option');
                noPlanOption.value = '';
                noPlanOption.textContent = 'ไม่มีแผนยุทธศาสตร์';
                straDropdown.appendChild(noPlanOption);
                straDropdown.disabled = true;
                // updateSFADropdown();
            } else {
                straDropdown.disabled = false;
                filteredPlans.forEach(plan => {
                    const option = document.createElement('option');
                    option.value = plan.straID;
                    option.textContent = plan.name;
                    straDropdown.appendChild(option);
                });
                // updateSFADropdown();
            }

            mainContainer.appendChild(divstraID);
            divstraID.appendChild(straDropdown);

            const mainContainer1 = document.createElement('div');
            mainContainer1.classList.add('col-md-3');

            const mainContainer2 = document.createElement('div');
            mainContainer2.classList.add('col-md-9', 'border', 'mb-2', 'p-2');

            const mainContainerSFA = document.createElement('div');
            mainContainerSFA.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const SFALabel = document.createElement('label');
            SFALabel.setAttribute('for', 'SFAInput');
            SFALabel.classList.add('col-form-label', 'col-md-3', 'col-sm-3', 'label-align');
            SFALabel.textContent = 'ประเด็นยุทธศาสตร์';
            mainContainerSFA.appendChild(SFALabel);

            const divSFA = document.createElement('div');
            divSFA.classList.add('col-md-6', 'col-sm-6');

            const SFADropdown = document.createElement('select');
            SFADropdown.classList.add('form-control');
            SFADropdown.id = `SFA_${Date.now()}`;
            SFADropdown.name = 'SFAID[]';
            SFADropdown.innerHTML = '';

            // ฟังก์ชันสำหรับอัปเดต SFADropdown
            const updateSFADropdown = () => {
                const selectedPlanID = straDropdown.value;

                // ลบตัวเลือกเก่าใน SFADropdown
                SFADropdown.innerHTML = '';

                if (!selectedPlanID) {
                    const noIssueOption = document.createElement('option');
                    noIssueOption.value = '';
                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                    SFADropdown.appendChild(noIssueOption);
                    SFADropdown.disabled = true;
                    updateGoalDropdown();
                    return;
                }

                const filteredIssues = issues.filter(issue => issue.straID == selectedPlanID);

                if (filteredIssues.length === 0) {
                    const noIssueOption = document.createElement('option');
                    noIssueOption.value = '';
                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                    SFADropdown.appendChild(noIssueOption);
                    SFADropdown.disabled = true;
                    updateGoalDropdown();
                } else {
                    SFADropdown.disabled = false;
                    filteredIssues.forEach(issue => {
                        const option = document.createElement('option');
                        option.value = issue.SFAID;
                        option.textContent = issue.name;
                        SFADropdown.appendChild(option);
                    });
                    // updateGoalDropdown();
                }

            };
            // เพิ่ม event listener ให้ straDropdown
            straDropdown.addEventListener('change', updateSFADropdown);
            // เรียกครั้งแรกเพื่อเติมค่าเริ่มต้นใน SFADropdown
            updateSFADropdown();

            mainContainer2.appendChild(mainContainerSFA);
            mainContainerSFA.appendChild(divSFA);
            divSFA.appendChild(SFADropdown);

            const mainContainerGoal = document.createElement('div');
            mainContainerGoal.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const goalLabel = document.createElement('label');
            goalLabel.setAttribute('for', 'goalInput');
            goalLabel.classList.add('col-form-label', 'col-md-3', 'col-sm-3', 'label-align');
            goalLabel.textContent = 'เป้าประสงค์';
            mainContainerGoal.appendChild(goalLabel);

            const divGoal = document.createElement('div');
            divGoal.classList.add('col-md-6', 'col-sm-6');

            const goalDropdown = document.createElement('select');
            goalDropdown.classList.add('form-control');
            goalDropdown.id = `goal_${Date.now()}`;
            goalDropdown.name = 'goalID[]';
            goalDropdown.innerHTML = '';

            const updateGoalDropdown = () => {
                const selectedSFAID = SFADropdown.value;

                // ลบตัวเลือกเก่าใน SFADropdown
                goalDropdown.innerHTML = '';

                if (!selectedSFAID) {
                    const noGoalOption = document.createElement('option');
                    noGoalOption.value = '';
                    noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                    goalDropdown.appendChild(noGoalOption);
                    goalDropdown.disabled = true;
                    updateTacticsDropdown();
                    return;
                }

                const filteredGoals = goals.filter(goal => goal.SFAID == selectedSFAID);

                if (filteredGoals.length === 0) {
                    const noGoalOption = document.createElement('option');
                    noGoalOption.value = '';
                    noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                    goalDropdown.appendChild(noGoalOption);
                    goalDropdown.disabled = true;
                    updateTacticsDropdown();
                } else {
                    goalDropdown.disabled = false;
                    filteredGoals.forEach(goal => {
                        const option = document.createElement('option');
                        option.value = goal.goalID;
                        option.textContent = goal.name;
                        goalDropdown.appendChild(option);
                    });
                }
            };

            // เพิ่ม event listener ให้ straDropdown
            SFADropdown.addEventListener('change', updateGoalDropdown);
            // เรียกครั้งแรกเพื่อเติมค่าเริ่มต้นใน SFADropdown
            updateGoalDropdown();

            mainContainer2.appendChild(mainContainerGoal);
            mainContainerGoal.appendChild(divGoal);
            divGoal.appendChild(goalDropdown);

            const mainContainerTactics = document.createElement('div');
            mainContainerTactics.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const tacticsLabel = document.createElement('label');
            tacticsLabel.setAttribute('for', 'tacticsInput');
            tacticsLabel.classList.add('col-form-label', 'col-md-3', 'col-sm-3', 'label-align');
            tacticsLabel.textContent = 'กลยุทธ์';
            mainContainerTactics.appendChild(tacticsLabel);

            const divTactics = document.createElement('div');
            divTactics.classList.add('col-md-6', 'col-sm-6');

            const tacticsDropdown = document.createElement('select');
            tacticsDropdown.classList.add('form-control');
            tacticsDropdown.id = `tacID_${Date.now()}`;
            tacticsDropdown.name = 'tacID[]';
            tacticsDropdown.innerHTML = '';

            const updateTacticsDropdown = () => {
                const selectedGoalID = goalDropdown.value;
                tacticsDropdown.innerHTML = '';

                if (!selectedGoalID) {
                    const noTacticsOption = document.createElement('option');
                    noTacticsOption.value = '';
                    noTacticsOption.textContent = 'ไม่มีกลยุทธ์';
                    tacticsDropdown.appendChild(noTacticsOption);
                    tacticsDropdown.disabled = true;
                    return;
                }

                // กรองประเด็นยุทธศาสตร์ที่เชื่อมกับแผนที่เลือก
                const filteredTactics = tactics.filter(tactic => tactic.goalID == selectedGoalID);

                if (filteredTactics.length === 0) {
                    const noTacticsOption = document.createElement('option');
                    noTacticsOption.value = '';
                    noTacticsOption.textContent = 'ไม่มีกลยุทธ์';
                    tacticsDropdown.appendChild(noTacticsOption);
                    tacticsDropdown.disabled = true;

                } else {
                    tacticsDropdown.disabled = false;
                    filteredTactics.forEach(tactic => {
                        const option = document.createElement('option');
                        option.value = tactic.tacID;
                        option.textContent = tactic.name;
                        tacticsDropdown.appendChild(option);
                    });

                }
            };

            // เพิ่ม event listener ให้ straDropdown
            goalDropdown.addEventListener('change', updateTacticsDropdown);
            // เรียกครั้งแรกเพื่อเติมค่าเริ่มต้นใน SFADropdown
            updateTacticsDropdown();


            mainContainer2.appendChild(mainContainerTactics);
            mainContainerTactics.appendChild(divTactics);
            divTactics.appendChild(tacticsDropdown);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
                mainContainer1.remove();
                mainContainer2.remove();
            };
            mainContainer.appendChild(deleteButton);


            // ตอนนี้ mainContainer จะมีทั้ง label และ input
            const container = document.getElementById('insertStrategic');
            container.appendChild(mainContainer);
            container.appendChild(mainContainer1);
            container.appendChild(mainContainer2);
            // หรือเพิ่มไปที่ container อื่น
        }

        function toggleTextarea() {
            var select = document.getElementById("integrat");
            var otherTextContainer = document.getElementById("otherTextContainer");

            if (select.value === '6') {
                otherTextContainer.style.display = "flex";
            } else {
                otherTextContainer.style.display = "none";
            }
        }

        function insertObj() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-sm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const InputObjt = document.createElement('input');
            InputObjt.classList.add('form-control');
            InputObjt.type = 'text';
            InputObjt.name = 'obj[]';

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            colMD6.appendChild(InputObjt);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('insertObj').appendChild(mainContainer);

        }

        function insertKPIMain() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('col-md-12', 'col-sm-12');

            const colKPI = document.createElement('div');
            colKPI.classList.add('col-md-4', 'col-sm-4', 'm-1');

            const KPIDropdown = document.createElement('select');
            KPIDropdown.classList.add('form-control');
            KPIDropdown.id = 'KPIMainID';
            KPIDropdown.innerHTML = '';

            const colCount = document.createElement('div');
            colCount.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const countInput = document.createElement('input');
            countInput.classList.add('form-control');
            countInput.type = 'text';
            countInput.name = 'countProject[]';

            const colTarget = document.createElement('div');
            colTarget.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const targetInput = document.createElement('input');
            targetInput.classList.add('form-control');
            targetInput.type = 'text';
            targetInput.name = 'targetProject[]';

            const colDelete = document.createElement('div');
            colDelete.classList.add('col-md-1', 'col-sm-1', 'm-1');

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };
            mainContainer.appendChild(colKPI);
            mainContainer.appendChild(colCount);
            mainContainer.appendChild(colTarget);
            mainContainer.appendChild(colDelete);
            colKPI.appendChild(KPIDropdown);
            colCount.appendChild(countInput);
            colTarget.appendChild(targetInput);
            colDelete.appendChild(deleteButton);
            // เพิ่มปุ่มลบลงใน mainContainer
            document.getElementById('insertKPIMain').appendChild(mainContainer);
        }

        function insertKPIProject() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'col-md-12', 'col-sm-12');
            mainContainer.style.display = "flex";

            const colKPI = document.createElement('div');
            colKPI.classList.add('col-md-4', 'col-sm-4', 'm-1');

            const KPIInput = document.createElement('input');
            KPIInput.classList.add('form-control');
            KPIInput.type = 'text';
            KPIInput.name = 'KPIProject[]';

            const colCount = document.createElement('div');
            colCount.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const countInput = document.createElement('select');
            countInput.classList.add('form-control');
            countInput.id = 'countKPIProject';
            countInput.name = 'countKPIProject[]';

            const originalOptions = document.querySelector('#countKPIProject').innerHTML;
            countInput.innerHTML = originalOptions;

            const colTarget = document.createElement('div');
            colTarget.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const targetInput = document.createElement('input');
            targetInput.classList.add('form-control');
            targetInput.type = 'text';
            targetInput.name = 'targetProject[]';

            const colDelete = document.createElement('div');
            colDelete.classList.add('col-md-1', 'col-sm-1', 'm-1');

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };
            mainContainer.appendChild(colKPI);
            mainContainer.appendChild(colCount);
            mainContainer.appendChild(colTarget);
            mainContainer.appendChild(colDelete);
            colKPI.appendChild(KPIInput);
            colCount.appendChild(countInput);
            colTarget.appendChild(targetInput);
            colDelete.appendChild(deleteButton);
            // เพิ่มปุ่มลบลงใน mainContainer
            document.getElementById('insertKPIProject').appendChild(mainContainer);
        }

        function insertStep() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'col-md-12', 'col-sm-12');

            const colName = document.createElement('div');
            colName.classList.add('row', 'col-md-4', 'col-sm-4', 'm-1');

            const NameInput = document.createElement('input');
            NameInput.classList.add('form-control');
            NameInput.type = 'text';
            NameInput.name = 'stepName[]';

            const colStart = document.createElement('div');
            colStart.classList.add('row', 'col-md-3', 'col-sm-3', 'm-1');

            const startInput = document.createElement('input');
            startInput.classList.add('form-control');
            startInput.type = 'date';
            startInput.name = 'stepStart[]';

            const colEnd = document.createElement('div');
            colEnd.classList.add('row', 'col-md-3', 'col-sm-3', 'm-1');

            const EndInput = document.createElement('input');
            EndInput.classList.add('form-control');
            EndInput.type = 'date';
            EndInput.name = 'stepEnd[]';

            const colDelete = document.createElement('div');
            colDelete.classList.add('col-md-1', 'col-sm-1', 'm-1');

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };
            mainContainer.appendChild(colName);
            mainContainer.appendChild(colStart);
            mainContainer.appendChild(colEnd);
            mainContainer.appendChild(colDelete);
            colName.appendChild(NameInput);
            colStart.appendChild(startInput);
            colEnd.appendChild(EndInput);
            colDelete.appendChild(deleteButton);
            // เพิ่มปุ่มลบลงใน mainContainer
            document.getElementById('insertStep').appendChild(mainContainer);
        }

        function insertCostType() {
            const dropdownCount = document.querySelectorAll('.Expense').length + 1;

            const mainExpenseContainer = document.createElement('div');
            mainExpenseContainer.classList.add('col-md-12', 'col-sm-12');

            const colExpense = document.createElement('div');
            colExpense.classList.add('col-md-3', 'col-sm-3', 'mr-1');
            // ใส่ข้อความหรือเนื้อหา

            const ExpenseDropdown = document.createElement('select');
            ExpenseDropdown.classList.add('form-control'); // เพิ่มคลาสเพื่อทำให้สามารถระบุได้ง่ายขึ้น
            ExpenseDropdown.id = 'expID';
            ExpenseDropdown.innerHTML = '';

            colExpense.appendChild(ExpenseDropdown);
            mainExpenseContainer.appendChild(colExpense);

            const mainCostTypeContainer = document.createElement('div');
            mainCostTypeContainer.classList.add('col-md-12', 'col-sm-12', 'mt-2');

            const colCostType = document.createElement('div');
            colCostType.classList.add('row', 'col-md-3', 'col-sm-3', 'mr-1');

            const costTypeDropdown = document.createElement('select');
            costTypeDropdown.classList.add('form-control'); // เพิ่มคลาสเพื่อทำให้สามารถระบุได้ง่ายขึ้น
            costTypeDropdown.id = 'costType';
            costTypeDropdown.innerHTML = '';

            colCostType.appendChild(costTypeDropdown);
            mainCostTypeContainer.appendChild(colCostType);

            const colCostQu1 = document.createElement('div');
            colCostQu1.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu1Input = document.createElement('input');
            CostQu1Input.classList.add('form-control','cost-input');
            CostQu1Input.type = 'text';
            CostQu1Input.name = 'CostQu1[]';
            CostQu1Input.addEventListener('input', calculateTotal); // เพิ่ม Event Listener

            colCostQu1.appendChild(CostQu1Input);
            mainCostTypeContainer.appendChild(colCostQu1);

            const colCostQu2 = document.createElement('div');
            colCostQu2.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu2Input = document.createElement('input');
            CostQu2Input.classList.add('form-control','cost-input');
            CostQu2Input.type = 'text';
            CostQu2Input.name = 'CostQu2[]';
            CostQu2Input.addEventListener('input', calculateTotal); // เพิ่ม Event Listener

            colCostQu2.appendChild(CostQu2Input);
            mainCostTypeContainer.appendChild(colCostQu2);

            const colCostQu3 = document.createElement('div');
            colCostQu3.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu3Input = document.createElement('input');
            CostQu3Input.classList.add('form-control','cost-input');
            CostQu3Input.type = 'text';
            CostQu3Input.name = 'CostQu3[]';
            CostQu3Input.addEventListener('input', calculateTotal); // เพิ่ม Event Listener

            colCostQu3.appendChild(CostQu3Input);
            mainCostTypeContainer.appendChild(colCostQu3);


            const colCostQu4 = document.createElement('div');
            colCostQu4.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu4Input = document.createElement('input');
            CostQu4Input.classList.add('form-control','cost-input');
            CostQu4Input.type = 'text';
            CostQu4Input.name = 'CostQu4[]';
            CostQu4Input.addEventListener('input', calculateTotal); // เพิ่ม Event Listener

            colCostQu4.appendChild(CostQu4Input);
            mainCostTypeContainer.appendChild(colCostQu4);


            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainExpenseContainer.remove();
                mainCostTypeContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
                calculateTotal();
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainCostTypeContainer.appendChild(deleteButton);

            document.getElementById('insertExpense').appendChild(mainExpenseContainer);
            document.getElementById('insertExpense').appendChild(mainCostTypeContainer);
        }

        function insertBenefit() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-ssm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const InputBenefit = document.createElement('input');
            InputBenefit.classList.add('form-control');
            InputBenefit.type = 'text';
            InputBenefit.name = 'benefit[]';

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            colMD6.appendChild(InputBenefit);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('insertBenefit').appendChild(mainContainer);

        }

        function insertFile() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-sm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const inputFile = document.createElement('input');
            inputFile.classList.add('form-control');
            inputFile.type = 'file';
            inputFile.name = 'file[]';

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            colMD6.appendChild(inputFile);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('insertFile').appendChild(mainContainer);

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
                    strategicMaps.forEach(map => {
                        if (map.straID == plan.straID) {
                            option.selected = true;
                            updateIssueDropdown(plan.straID);
                        }
                    });
                    planSelect.appendChild(option);
                });
                if (!filteredPlans.some(plan => strategicMaps.some(map => map.straID == plan.straID))) {
                    updateIssueDropdown(filteredPlans[0].straID);
                }

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
            //         console.log("Selected Plan ID:", selectedPlanID);
            // console.log("Filtered Issues:", filteredIssues);
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
                    strategicMaps.forEach(map => {
                        if (map.SFAID == issue.SFAID) {
                            option.selected = true;
                            updateGoalDropdown(issue.SFAID);
                        }
                    });
                    issueSelect.appendChild(option);
                });
                if (!filteredIssues.some(issue => strategicMaps.some(map => map.SFAID == issue.SFAID))) {
                    updateGoalDropdown(filteredIssues[0].SFAID);
                }

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
                updateKPIMain(null);
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
                updateKPIMain(null);
                updateTacticsDropdown(null);

            } else {
                goalSelect.disabled = false;
                filteredGoals.forEach(goal => {
                    const option = document.createElement('option');
                    option.value = goal.goalID;
                    option.textContent = goal.name;
                    strategicMaps.forEach(map => {
                        if (map.goalID == goal.goalID) {
                            option.selected = true;
                            updateKPIMain(goal.goalID);
                            updateTacticsDropdown(goal.goalID);
                        }
                    });
                    goalSelect.appendChild(option);
                });
                if (!filteredGoals.some(goal => strategicMaps.some(map => map.goalID == goal.goalID))) {
                    updateKPIMain(filteredGoals[0].goalID);
                    updateTacticsDropdown(filteredGoals[0].goalID);
                }
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
                    strategicMaps.forEach(map => {
                        if (map.tacID == tactic.tacID) {
                            option.selected = true;
                            // updateTacticsDropdown ( tactic.tacID);
                        }
                    });
                    tacticsSelect.appendChild(option);
                });
            }
            // แสดงกลยุทธ์ใน dropdown

        }

        function updateKPIMain(selectedGoalID) {
            // console.log(selectedGoalID);

            const KPIMainSelect = document.getElementById('KPIMain');
            const countMainInput = document.getElementById('countMain');
            const targetInput = document.getElementById('targetMain');

            // ล้างค่าตัวเลือกใน KPIMain
            KPIMainSelect.innerHTML = '';
            countMainInput.innerHTML = '';
            targetInput.innerHTML = '';

            // ถ้าไม่มี selectedtacID ให้แสดงตัวเลือกที่ไม่มีตัวชี้วัด
            if (!selectedGoalID) {
                const noKPIMainOption = document.createElement('option');
                noKPIMainOption.value = '';
                noKPIMainOption.textContent = 'ไม่มีตัวชี้วัดของแผน';
                KPIMainSelect.appendChild(noKPIMainOption);
                KPIMainSelect.disabled = true;
                countMainInput.value = 'ไม่มีหน่วยนับ';
                targetInput.value = 'ไม่มีค่าเป้าหมาย';
                return;
            }

            // กรอง KPI ที่ตรงกับ selectedtacID และเพิ่มเข้าไปใน dropdown
            const filteredKPIMains = KPIMains.filter(KPIMain => KPIMain.goalID == selectedGoalID);
            // console.log(filteredKPIMains);

            if (filteredKPIMains.length === 0) {
                const noKPIMainOption = document.createElement('option');
                noKPIMainOption.value = '';
                noKPIMainOption.textContent = 'ไม่มีตัวชี้วัดของแผน';
                KPIMainSelect.appendChild(noKPIMainOption);
                KPIMainSelect.disabled = true;
                countMainInput.value = 'ไม่มีหน่วยนับ';
                targetInput.value = 'ไม่มีค่าเป้าหมาย';
            } else {
                // เปิดใช้งาน dropdown และเพิ่ม KPI ในตัวเลือก
                KPIMainSelect.disabled = false;
                let selectedOptionFound = false;
                filteredKPIMains.forEach(KPIMain => {
                    const option = document.createElement('option');
                    option.value = KPIMain.KPIMainID;
                    option.textContent = KPIMain.name;
                    const map = strategicMaps.find(map => map.KPIMainID == KPIMain.KPIMainID);
                    if (map) {
                        option.selected = true;
                        countMainInput.value = KPIMain.count;
                        targetInput.value = KPIMain.target;
                    }
                    KPIMainSelect.appendChild(option);
                });

                if (!countMainInput.value && filteredKPIMains.length > 0) {
                    const firstKPIMain = filteredKPIMains[0];
                    countMainInput.value = firstKPIMain.count || 'ไม่มีหน่วยนับ';
                    targetInput.value = firstKPIMain.target || 'ไม่มีค่าเป้าหมาย';
                }
            }
        }

        document.getElementById('KPIMain').addEventListener('change', function() {
            const selectedKPIMainID = this.value;

            // ค้นหาข้อมูล KPIMain ที่เลือก
            const selectedKPIMain = KPIMains.find(KPIMain => KPIMain.KPIMainID == selectedKPIMainID);

            // ถ้ามีตัวเลือกที่เลือก ก็อัพเดตค่า count และ target
            if (selectedKPIMain) {
                document.getElementById('countMain').value = selectedKPIMain.count || 'ไม่มีหน่วยนับ';
                document.getElementById('targetMain').value = selectedKPIMain.target || 'ไม่มีค่าเป้าหมาย';
            }
        });

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
                    option.textContent = expense.name;
                    const map =
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
                    option.value = costType.id;
                    option.textContent = costType.name;
                    costTypeSelect.appendChild(option);
                });
            }
        }

        function submitButton(action) {
            var form = document.getElementById('actionForm');
            if (action === 'save') {
                form.action = "/projectupdate";
            } else if (action === 'send') {
                form.action = "/projectSend";
            }
            form.submit();
        }


        // Event listeners สำหรับ dropdown ต่าง ๆ
        window.onload = function() {
            const yearSelect = document.getElementById('year');
            const StrategicSelect = document.getElementById('straID');
            const SFASelect = document.getElementById('SFAID');
            const goalSelect = document.getElementById('goalID');

            const planSelect = document.getElementById('planID');
            const EXPSelect = document.getElementById('expID');
            var select = document.getElementById("integrat");
            var otherTextContainer = document.getElementById("otherTextContainer");

            if (select.value === '6') {
                otherTextContainer.style.display = "flex";
            } else {
                otherTextContainer.style.display = "none";
            }


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
                updateKPIMain(selectedGoalID);
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
