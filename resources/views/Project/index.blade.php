@extends('layout')
@section('title', 'โครงการประจำปี')
@section('content')

    {{-- <body class="nav-md"> --}}
    {{-- <div class="container body"> --}}
    <div class="main_container">
        <div role="main">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
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
                                <div class="field item form-group ">
                                    <label class="col-form-label col-md-1 col-sm-1 " for="heard">ปีงบประมาณ*</label>
                                    <div class="col-md-2 col-sm-2 m-2 ">
                                        <select name="year" id="yearID" class="form-control">
                                            <option data-year="ทั้งหมด">ทั้งหมด</option>
                                            @foreach ($year as $year)
                                                <option value="{{ $year->yearID }}" data-year="{{ $year->yearID }}">
                                                    {{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อโครงการ</th>
                                            <th>สถานะ</th>
                                            <th>ไตรมาส 1</th>
                                            <th>ไตรมาส 2</th>
                                            <th>ไตรมาส 3</th>
                                            <th>ไตรมาส 4</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $currentDate = date('Y-m-d');
                                            $i = 1;
                                        @endphp
                                        @foreach ($project as $index => $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td data-project="{{ $item->proID }}">
                                                    @if ($item->statusID == 12 || $item->statusID == 13 || $item->statusID == 14)
                                                        {{ $item->name }}
                                                    @else
                                                        <a
                                                            href="{{ route('project.detail', $item->proID) }}">{{ $item->name }}</a>
                                                    @endif
                                                </td>
                                                <td>{{ $status->firstWhere('statusID', $item->statusID)->name ?? 'ไม่พบ' }}
                                                </td>

                                                <td>
                                                    @if ($item->statusID == 4)
                                                        @if (count($data['dateQuarter1']) > 0)
                                                            @foreach ($data['dateQuarter1'] as $date)
                                                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                                                    @php $found = false; @endphp
                                                                    @if (count($data['report']) > 0)
                                                                        @foreach ($data['report'] as $report)
                                                                            @if ($report->proID == $item->proID && $report->quarID == 1)
                                                                                <a
                                                                                    href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                                                                        class="fa fa-pencil btn btn-danger">
                                                                                        เสนอปิดโครงการ</i></a>
                                                                                @php $found = true; @endphp
                                                                                @break
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    @if (!$found)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                                                                class="fa fa-pencil btn btn-primary">
                                                                                เขียน</i></a>
                                                                    @endif
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>
                                                        @endif
                                                    @elseif($item->statusID == 13)
                                                        {{-- <a href="#" class="disabled"><i
                                                        class="fa fa-pencil btn btn-secondary disabled">
                                                        เขียน</i></a> --}}
                                                        @php
                                                            $report1 = false;
                                                            // $report2 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID) {
                                                                    if ($eva->quarID == 1) {
                                                                        $report1 = true;
                                                                    }
                                                                    // if ($eva->quarID == 2) {
                                                                    //     $report2 = true;
                                                                    // }
                                                                }
                                                            }
                                                        @endphp
                                                        {{-- @if ($report2)
                                                        <a href="{{ route('report.quarter', [$item->proID, 1]) }}">
                                                            <i class="fa fa-eye btn btn-primary">
                                                                ดูรายงาน</i>
                                                        </a> --}}
                                                        @if ($report1)
                                                            <a href="{{ route('report.quarter', [$item->proID, 1]) }}">
                                                                <i class="fa fa-eye btn btn-primary">
                                                                    ดูรายงาน</i>
                                                            </a>
                                                        @endif
                                                    @elseif($item->statusID >= 5 && $item->statusID <= 11)
                                                        @php
                                                            $eva1 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID && $eva->quarID == 1) {
                                                                    $eva1 = true;
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($eva1)
                                                            <a href="{{ route('report.quarter', [$item->proID, 1]) }}">
                                                                <i class="fa fa-eye btn btn-primary">
                                                                    ดูรายงาน</i>
                                                            </a>
                                                        @endif
                                                        {{-- @foreach ($data['evaluation'] as $eva)
                                                            @if ($eva->proID == $item->proID && $eva->quarID == 1)
                                                                <a href="{{ route('report.quarter', [$item->proID, 1]) }}">
                                                                    <i class="fa fa-eye btn btn-primary">
                                                                        ดูรายงาน</i>
                                                                </a>
                                                            @endif
                                                        @endforeach --}}
                                                    @else
                                                        @php
                                                            $q1 = false;
                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID && $eva->quarID == 1) {
                                                                    $q1 = true;
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($q1)
                                                            <a href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                                                    class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-eye btn btn-secondary disabled">
                                                                    ดูรายงาน</i></a>
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($item->statusID == 4)
                                                        @if (count($data['dateQuarter2']) > 0)
                                                            @foreach ($data['dateQuarter2'] as $date)
                                                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                                                    @php
                                                                        $found = false;
                                                                        $found2 = false;

                                                                        foreach ($data['report'] as $report) {
                                                                            if ($report->proID == $item->proID) {
                                                                                if ($report->quarID == 1) {
                                                                                    $found = true;
                                                                                }
                                                                                if ($report->quarID == 2) {
                                                                                    $found2 = true;
                                                                                }
                                                                            }
                                                                        }

                                                                    @endphp
                                                                    {{-- @if (count($data['report']) > 0) --}}
                                                                    @if ($found && !$found2)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                                                                class="fa fa-pencil btn btn-primary">
                                                                                เขียน</i></a>
                                                                    @elseif($found2)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                                class="fa fa-pencil btn btn-danger">
                                                                                เสนอปิดโครงการ</i></a>
                                                                    @elseif(!$found && !$found2)
                                                                        <a href="#" class="disabled"><i
                                                                                class="fa fa-pencil btn btn-secondary disabled">
                                                                                เขียน</i></a>
                                                                    @endif

                                                                    {{-- @endif --}}
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>
                                                        @endif
                                                    @elseif($item->statusID == 13)
                                                        @php
                                                            // $report1 = false;
                                                            $report2 = false;
                                                            // $report3 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID) {
                                                                    // if ($eva->quarID == 1) {
                                                                    //     $report1 = true;
                                                                    // }
                                                                    if ($eva->quarID == 2) {
                                                                        $report2 = true;
                                                                    }
                                                                    // if ($eva->quarID == 3) {
                                                                    //     $report3 = true;
                                                                    // }
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($report2)
                                                            <a href="{{ route('report.quarter', [$item->proID, 2]) }}">
                                                                <i class="fa fa-eye btn btn-primary"> ดูรายงาน</i>
                                                            </a>
                                                        @elseif(!$report2)
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>

                                                            {{-- @elseif($report1) --}}
                                                        @endif
                                                    @elseif($item->statusID >= 5 && $item->statusID <= 11)
                                                        @php
                                                            $hasQuarter1 = false;
                                                            $hasQuarter2 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID) {
                                                                    if ($eva->quarID == 1) {
                                                                        $hasQuarter1 = true;
                                                                    }
                                                                    if ($eva->quarID == 2) {
                                                                        $hasQuarter2 = true;
                                                                    }
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($hasQuarter2)
                                                            <a href="{{ route('report.quarter', [$item->proID, 2]) }}">
                                                                <i class="fa fa-eye btn btn-primary"> ดูรายงาน</i>
                                                            </a>
                                                        @elseif ($hasQuarter1)
                                                            <a href="#" class="disabled">
                                                                <i class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        @php
                                                            $q1 = false;
                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID && $eva->quarID == 2) {
                                                                    $q1 = true;
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($q1)
                                                            <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                    class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-eye btn btn-secondary disabled">
                                                                    ดูรายงาน</i></a>
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($item->statusID == 4)
                                                        @if (count($data['dateQuarter3']) > 0)
                                                            @foreach ($data['dateQuarter3'] as $date)
                                                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                                                    @php

                                                                        $found3_2 = false;
                                                                        $found3_3 = false;

                                                                        foreach ($data['report'] as $report) {
                                                                            if ($report->proID == $item->proID) {
                                                                                if ($report->quarID == 2) {
                                                                                    $found3_2 = true;
                                                                                }
                                                                                if ($report->quarID == 3) {
                                                                                    $found3_3 = true;
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    {{-- @if (count($data['report']) > 0) --}}
                                                                    @if (!$found3_2)
                                                                        <a href="#" class="disabled"><i
                                                                                class="fa fa-pencil btn btn-secondary disabled">
                                                                                เขียน</i></a>
                                                                    @elseif ($found3_2 && !$found3_3)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                                                                class="fa fa-pencil btn btn-primary">
                                                                                เขียน</i></a>
                                                                    @elseif($found3_3)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                                class="fa fa-pencil btn btn-danger">
                                                                                เสนอปิดโครงการ</i></a>
                                                                    @endif


                                                                    {{-- @endif --}}
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>
                                                        @endif
                                                    @elseif($item->statusID == 13)
                                                        {{-- <a href="#" class="disabled"><i
                                                        class="fa fa-pencil btn btn-secondary disabled">
                                                        เขียน</i></a> --}}
                                                        @php

                                                            // $eva3_2 = false;
                                                            $eva3_3 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID) {
                                                                    // if ($eva->quarID == 2) {
                                                                    //     $eva3_2 = true;
                                                                    // }
                                                                    if ($eva->quarID == 3) {
                                                                        $eva3_3 = true;
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($eva3_3)
                                                            <a href="{{ route('report.quarter', [$item->proID, 3]) }}">
                                                                <i class="fa fa-eye btn btn-primary"> ดูรายงาน</i>
                                                            </a>
                                                        @elseif(!$eva3_3)
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>
                                                        @endif
                                                    @elseif($item->statusID >= 5 && $item->statusID <= 11)
                                                        @php
                                                            $Quarter1 = false;
                                                            $Quarter2 = false;
                                                            $Quarter3 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID) {
                                                                    if ($eva->quarID == 1) {
                                                                        $Quarter1 = true;
                                                                    }
                                                                    if ($eva->quarID == 2) {
                                                                        $Quarter2 = true;
                                                                    }
                                                                    if ($eva->quarID == 3) {
                                                                        $Quarter3 = true;
                                                                    }
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($Quarter3)
                                                            <a href="{{ route('report.quarter', [$item->proID, 3]) }}">
                                                                <i class="fa fa-eye btn btn-primary"> ดูรายงาน</i>
                                                            </a>
                                                        @elseif ($Quarter2 || $Quarter1)
                                                            <a href="#" class="disabled">
                                                                <i class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        @php
                                                            $q1 = false;
                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID && $eva->quarID == 3) {
                                                                    $q1 = true;
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($q1)
                                                            <a href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                    class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-eye btn btn-secondary disabled">
                                                                    ดูรายงาน</i></a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->statusID == 4)
                                                        @if (count($data['dateQuarter4']) > 0)
                                                            @foreach ($data['dateQuarter4'] as $date)
                                                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                                                    @php
                                                                        $found4_3 = false;
                                                                        $found4_4 = false;

                                                                        foreach ($data['report'] as $report) {
                                                                            if ($report->proID == $item->proID) {
                                                                                if ($report->quarID == 3) {
                                                                                    $found4_3 = true;
                                                                                }
                                                                                if ($report->quarID == 4) {
                                                                                    $found4_4 = true;
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    {{-- @if (count($data['report']) > 0) --}}
                                                                    @if (!$found4_3)
                                                                        <a href="#" class="disabled"><i
                                                                                class="fa fa-pencil btn btn-secondary disabled">
                                                                                เขียน</i></a>
                                                                    @elseif($found4_3 && !$found4_4)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                                                                class="fa fa-pencil btn btn-primary">
                                                                                เขียน</i></a>
                                                                    @elseif($found4_4)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, 4]) }}"><i
                                                                                class="fa fa-pencil btn btn-danger">
                                                                                เสนอปิดโครงการ</i></a>
                                                                    @endif

                                                                    {{-- @endif --}}
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>
                                                        @endif
                                                    @elseif($item->statusID == 13)
                                                        @php
                                                            // $eva4_3 = false;
                                                            $eva4_4 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID) {
                                                                    // if ($eva->quarID == 3) {
                                                                    //     $eva4_3 = true;
                                                                    // }
                                                                    if ($eva->quarID == 4) {
                                                                        $eva4_4 = true;
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($eva4_4)
                                                            <a href="{{ route('report.quarter', [$item->proID, 3]) }}">
                                                                <i class="fa fa-eye btn btn-primary"> ดูรายงาน</i>
                                                            </a>
                                                        @elseif(!$eva4_4)
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>
                                                        @endif
                                                    @elseif($item->statusID >= 5 && $item->statusID <= 11)
                                                        @php
                                                            $Quarter4 = false;

                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID) {
                                                                    if ($eva->quarID == 4) {
                                                                        $Quarter4 = true;
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($Quarter4)
                                                            <a href="{{ route('report.quarter', [$item->proID, 4]) }}">
                                                                <i class="fa fa-eye btn btn-primary"> ดูรายงาน</i>
                                                            </a>
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-pencil btn btn-secondary disabled">
                                                                    เขียน</i></a>
                                                        @endif
                                                        {{-- @foreach ($data['evaluation'] as $eva)
                                                            @php $found2 = false; @endphp
                                                            @if ($eva->proID == $item->proID && $eva->quarID == 4)
                                                                <a
                                                                    href="{{ route('report.quarter', [$item->proID, 4]) }}">
                                                                    <i class="fa fa-eye btn btn-primary">
                                                                        ดูรายงาน</i>
                                                                </a>
                                                                @php $found2 = true; @endphp
                                                                @break
                                                            @endif
                                                            @if (!$found2)
                                                                <a href="#" class="disabled"><i
                                                                        class="fa fa-pencil btn btn-secondary disabled">
                                                                        เขียน</i></a>
                                                                @break
                                                            @endif
                                                        @endforeach --}}
                                                    @else
                                                        @php
                                                            $q1 = false;
                                                            foreach ($data['evaluation'] as $eva) {
                                                                if ($eva->proID == $item->proID && $eva->quarID == 4) {
                                                                    $q1 = true;
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($q1)
                                                            <a href="{{ route('report.quarter', [$item->proID, 4]) }}"><i
                                                                    class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                        @else
                                                            <a href="#" class="disabled"><i
                                                                    class="fa fa-eye btn btn-secondary disabled">
                                                                    ดูรายงาน</i></a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->statusID == 12 || $item->statusID == 14)
                                                        <a href="{{ route('project.edit1', $item->proID) }}"><i
                                                                class="fa fa-pencil btn btn-warning"></i></a>
                                                        <a href="{{ route('project.delete', $item->proID) }}"
                                                            onclick="return confirm('ต้องการลบโปรเจค {{ $item->name }}  หรือไม่')"><i
                                                                class="fa fa-times btn btn-danger"></i></a>
                                                    @elseif($item->statusID == 13)
                                                        <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                                                class="fa fa-pencil btn btn-warning"></i></a>
                                                        <a href="{{ route('project.delete', $item->proID) }}"
                                                            onclick="return confirm('ต้องการลบโปรเจค {{ $item->name }}  หรือไม่')"><i
                                                                class="fa fa-times btn btn-danger"></i></a>
                                                    @endif
                                                </td>

                                                {{-- <td>


                                                                @if ($currentMonth >= 10 && $currentMonth <= 12)

                                                                    @if ($item->statusID == 4)
                                                                        @if (!empty($evaluation) && ($evaluation[$index]->proID ?? '') === $item->proID)
                                                                            <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                                                                    class="fa fa-pencil btn btn-warning"> แก้ไขเอกสารเสนอปิดโครงการ</i></a>
                                                                        @elseif (!empty($report) && ($proID[$index] ?? '') === $item->proID)

                                                                            <a href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                                                                    class="fa fa-pencil btn btn-danger"> เสนอปิดโครงการ</i></a>
                                                                        @else
                                                                            <a href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                                                                    class="fa fa-pencil btn btn-primary"> เขียน</i></a>

                                                                        @endif
                                                                    @elseif($item->statusID == 8 || $item->statusID == 9 || $item->statusID == 10 || $item->statusID == 11)
                                                                        <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                                class="fa fa-eye btn btn-primary"> ดูรายงาน</i></a>
                                                                    @endif
                                                                @else
                                                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif

                                                            </td>
                                                            <td>

                                                                @if ($currentMonth >= 1 && $currentMonth <= 3)

                                                                    @if ($item->statusID == 4)


                                                                        @if ($proID[$index] ?? '' === $item->proID)
                                                                            <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                                    class="fa fa-pencil btn btn-danger"> เสนอปิดโครงการ</i></a>
                                                                        @else

                                                                            <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                                    class="fa fa-pencil btn btn-primary">
                                                                                    เขียน</i></a>

                                                                        @endif
                                                                    @elseif($item->statusID == 13)
                                                                        <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                                                                class="fa fa-pencil btn btn-warning"> แก้ไขเอกสารเสนอปิดโครงการ</i></a>
                                                                    @elseif ($item->statusID >= 5 && $item->statusID <= 11)
                                                                        <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                                class="fa fa-eye btn btn-primary"> ดูรายงาน</i></a>
                                                                    @else
                                                                        <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                                                                เขียน</i></a>
                                                                    @endif
                                                                @else
                                                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($currentMonth >= 4 && $currentMonth <= 6)

                                                                    @if ($item->statusID == 4)


                                                                        @if ($proID[$index] ?? '' === $item->proID)
                                                                            <a href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                                    class="fa fa-pencil btn btn-danger"> เสนอปิดโครงการ</i></a>
                                                                        @else

                                                                            <a href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                                    class="fa fa-pencil btn btn-primary">
                                                                                    เขียน</i></a>
                                                                        @endif
                                                                    @elseif($item->statusID == 13)
                                                                        <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                                                                class="fa fa-pencil btn btn-warning"> แก้ไขเอกสารเสนอปิดโครงการ</i></a>
                                                                    @elseif ($item->statusID >= 5 && $item->statusID <= 11)
                                                                        <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                                class="fa fa-eye btn btn-primary"> ดูรายงาน</i></a>
                                                                    @else
                                                                        <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                                                                เขียน</i></a>
                                                                    @endif
                                                                @else
                                                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($currentMonth >= 7 && $currentMonth <= 9 && $item->statusID == 4)
                                                                    <a href="{{ route('report.quarter', [$item->proID, 4]) }}"><i
                                                                            class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                                                                @else
                                                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            </td>

                                                                @endif --}}

                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    {{-- </body> --}}









    {{-- <script>
        import DataTable from 'datatables.net-dt';
        import 'datatables.net-responsive-dt';

        let table = new DataTable('#myTable', {
            responsive: true
        });
    </script> --}}
    {{-- <a type='submit' class="btn btn-primary" href="/projectcreate">สร้างโปรเจค</a> --}}
    <script>
        // เมื่อมีการเลือกแผนยุทธศาสตร์จาก dropdown
        document.getElementById('yearID').addEventListener('change', function() {
            // ดึงค่า "data-year" จาก option ที่ถูกเลือก
            var selectedOption = this.options[this.selectedIndex];
            var year = selectedOption.getAttribute('data-year');
            console.log(year);

            const projectYear = @json($projectYear);
            console.log(projectYear);
            const tableRows = document.querySelectorAll("table tbody tr");


            tableRows.forEach(row => {
                const cell = row.querySelector('td[data-project]');
                if (cell) {
                    const projectID = cell.getAttribute('data-project');
                    const project = projectYear.find(project => project.proID == projectID);
                    // console.log(projectID);
                    // console.log(project);

                    // Check if the row should be displayed
                    if (project && (year === "" || year === "ทั้งหมด" || project.yearID == year)) {
                        row.style.display = ""; // Show the row
                    } else {
                        row.style.display = "none"; // Hide the row
                    }
                }
            });
        });
    </script>

@endsection
