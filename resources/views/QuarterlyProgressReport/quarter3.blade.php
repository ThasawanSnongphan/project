@extends('layout')
@section('title', 'QuarterReport')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>เขียนรายงานความก้าวหน้า ไตรมาส3</h2>
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
                    <form action="">
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                {{ $data['project']->name }}
                                {{-- <input class="form-control" type="text" name="project_name" id="peoject_name"
                                    data-validate-length-range="8,20" value="{{ $project->name }}" disabled /> --}}
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">งบประมาณที่จัดสรร :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                {{-- {{$project->badgetTotal}} --}}
                                {{-- <input class="form-control" type="text" name="project_name" id="peoject_name"
                                    data-validate-length-range="8,20" value="{{ $project->name }}" disabled /> --}}
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ผลการใช้จ่าย :
                            </label>
                            <div class="col-md-6 col-sm-6">

                                <input class="form-control" type="text" name="" id=""
                                    data-validate-length-range="8,20" />
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ผลตามตัวชี้วัด :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <table class="table table-bordered" >
                                    <tr style="text-align: center">
                                        <th>ตัวชี้วัด</th>
                                        <th>เป้า</th>
                                        <th>ผล</th>
                                        <th>บรรลุตามตัวชี้วัด</th>
                                    </tr>

                                    @foreach ($data['KPI'] as $item)
                                        <tr>
                                            <td> {{ $item->name }}</td>
                                            <td style="text-align: center">{{ $item->target }}</td>
                                            <td style="text-align: center">
                                                <input type="text">
                                            </td>
                                            <td style="text-align: center">
                                                <input type="checkbox">
                                            </td>
                                        </tr>
                                    @endforeach


                                </table>
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ขั้นตอนการดำเนินการ
                                : </label>
                            <div class="col-md-6 col-sm-6">
                                <table class="table table-bordered">
                                    <tr style="text-align: center">
                                        <th>รายการกิจกรรม</th>
                                        <th>เริ่มต้น</th>
                                        <th>สิ้นสุด</th>
                                    </tr>
                                    @foreach ($data['steps'] as $item)
                                        <tr>
                                            <td> {{ $item->name }} </td>
                                            <td style="text-align: center"> {{ $item->start }}</td>
                                            <td style="text-align: center"> {{ $item->end }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">รายละเอียดความก้าวหน้า : </label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="" id=""
                                    data-validate-length-range="8,20" />
                            </div>

                            <div class=" col-md-1 col-sm-1 m-1">
                                <button type='button' class="btn btn-primary" onclick="insertDetail()">เพิ่ม
                                </button>

                            </div>
                        </div>
                        <div id="insertDetail"></div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ปัญหา/อุปสรรค :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="problem[]" id=""
                                    data-validate-length-range="8,20" />
                            </div>
                            <div class="col-md-1 col-sm-1 m-1">
                                <button type='button' class="btn btn-primary" onclick="insertProblem()">เพิ่ม
                                </button>

                            </div>
                        </div>
                        <div id="insertProblem"></div>
                        <div class="col-md-6 offset-md-3 ">
                            <button type="submit" class="btn btn-primary"
                                onclick="submitButton('send1')">ส่งรายงานความก้าวหน้า</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>

    <script>
        function insertDetail() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-sm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const InputDetail = document.createElement('input');
            InputDetail.classList.add('form-control');
            InputDetail.type = 'text';
            InputDetail.name = 'detail[]';

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-3');
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove();
            }

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            mainContainer.appendChild(deleteButton);
            colMD6.appendChild(InputDetail);

            document.getElementById('insertDetail').appendChild(mainContainer);
        }

        function insertProblem() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-sm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const InputProblem = document.createElement('input');
            InputProblem.classList.add('form-control');
            InputProblem.type = 'text';
            InputProblem.name = 'detail[]';

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-3');
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove();
            }

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            mainContainer.appendChild(deleteButton);
            colMD6.appendChild(InputProblem);

            document.getElementById('insertProblem').appendChild(mainContainer);
        }
    </script>
@endsection
