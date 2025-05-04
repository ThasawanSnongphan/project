@extends('layout')
@section('title', 'ผลการดำเนินงานตัวชี้วัด')
@section('content')
    <div class="main_container">
        <div role="main">
            <div class="row">

                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>โครงการประจำปี</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form action="/KPIMainReport" id="actionForm">
                                <div class=" field item form-group ">
                                    <label class="col-form-label col-md-1 col-sm-1">ปีงบประมาณ*</label>
                                    <div class="col-md-2 col-sm-2 m-2 ">
                                        <select id="yearID" name="yearID" class="form-control" required>
                                            <option value="">--เลือกปีงบประมาณ--</option>
                                            @foreach ($data['yearAll'] as $item)
                                                <option value="{{ $item->yearID }}"
                                                    {{ request('yearID') == $item->yearID ? 'selected' : '' }}>
                                                    {{ $item->year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                            </form>


                            <script>
                                function submitForm() {
                                    document.getElementById('actionForm').submit();
                                }

                                function projectEvaCompleteInPlan() {
                                    document.getElementById('projectEvaCompleteInPlan').submit();
                                }

                                function submit() {

                                    document.getElementById('submit').submit();

                                }

                                function clearTable() {
                                    document.querySelector("#data tbody").innerHTML = "";
                                }


                                // window.onload = function() {
                                //     const year = document.getElementById('yearID');
                                //     const defaultYear = year.value;
                                //     var displayYear = document.getElementById('displayYear')
                                //     displayYear.textContent = defaultYear;
                                //     year.addEventListener('change', function() {
                                //         const selectYear = this.value;
                                //         displayYear.textContent = selectYear;
                                //     });
                                // }
                            </script>
                        @endsection
