<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- ฟอนต์ Sarabun จาก Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <title>@yield('title')</title>

    <!-- เรียกใช้ฟอนต์ TH Sarabun -->
    <style>
        * {
            font-family: 'THSarabunPSK';
            src: url('/fonts/THSarabunPSK.ttf') format('truetype');
            /* font-size: 14px; */

        }
    </style>
</head>


<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>Strategic Plan</span></a>
                    </div>

                    <div class="clearfix"></div>


                    @if (Auth::check())
                        <div class="profile clearfix">
                            {{-- <div class="profile_pic">
                                <img src="{{ asset('production/images/img.jpg') }}" alt="..."
                                    class="img-circle profile_img">
                            </div> --}}
                            <div class="profile_info">
                                <span>Welcome,</span> <br>
                                {{ Auth::user()->displayname }}
                            </div>
                        </div>
                    @endif


                    <br />

                    <!-- sidebar menu -->
                    {{-- @php
                    dd(auth()->user());
                    @endphp --}}


                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                {{-- สิทธิ์ผู้เขียนโครงการ --}}
                                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="/">ข่าวประชาสัมพันธ์</a></li>
                                        {{-- ดูได้แค่ชื่อกับสถานะ --}}

                                        <li><a href="/projectAll">รายชื่อโครงการทั้งหมด</a></li>

                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                {{-- สิทธิ์ผู้เขียนโครงการ --}}
                                <li><a><i class="fa fa-file"></i> ผลการดำเนินงาน <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="/Performance">ผลการดำเนินงาน</a></li>
                                    </ul>
                                </li>
                            </ul>
                            @if (Auth::check())

                                @if (Auth::check() && auth()->user() && auth()->user()->Admin == 1)
                                    {{-- <h3>General</h3> --}}
                                    <ul class="nav side-menu">
                                        <li><a><i class="fa fa-user"></i> Admin <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="/news">ข่าวประชาสัมพันธ์</a></li>
                                                <li><a href="/users">Users</a></li>
                                                <li><a href="/year">ปีงบประมาณ</a></li>
                                                <hr>
                                                <p>รูปแบบของแผน 3 ระดับ</p>
                                                <li><a href="/strategic">แผนยุทธศาสตร์ </a></li>
                                                <li><a href="/SFA">ประเด็นยุทธศาสตร์</a></li>
                                                <li><a href="/goal">เป้าประสงค์</a></li>
                                                <li><a href="/KPIMain">ตัวชี้วัดของแผน</a></li>
                                                <li><a href="/tactics">กลยุทธ์</a></li>
                                                <hr>
                                                <p>รูปแบบของแผน 2 ระดับ</p>
                                                <li><a href="/strategic2LV">แผนยุทธศาสตร์ </a></li>
                                                <li><a href="/SFA2LV">ประเด็นยุทธศาสตร์</a></li>
                                                <li><a href="/KPIMain2LV">ตัวชี้วัดของแผน</a></li>
                                                <li><a href="/tactic2LV">กลยุทธ์</a></li>
                                                <hr>
                                                <p>รูปแบบของแผน 1 ระดับ</p>
                                                <li><a href="/strategic1LV">แผนยุทธศาสตร์ </a></li>
                                                <li><a href="/target1LV">เป้าหมาย</a></li>
                                                <hr>

                                                <li><a href="/plan">แผนงานมหาลัย</a></li>
                                                <li><a href="/fund">กองทุน</a></li>
                                                <li><a href="/Expense">งบรายจ่าย</a></li>
                                                <li><a href="/cost_type">หมวดรายจ่าย</a></li>
                                                <li><a href="/BadgetType">ประเภทงบประมาณ</a></li>
                                                <li><a href="/proChar">ลักษณะโครงการ</a></li>
                                                <li><a href="/projectIntegrat">การบูรณาการ</a></li>
                                                <li><a href="/status">สถานะ</a></li>
                                                <li><a href="/projectType">ประเภทโครงการ</a></li>
                                                <li><a href="/target">กลุ่มเป้าหมาย</a></li>
                                                <li><a href="/countKPI">หน่วยนับKPI</a></li>
                                                <li><a href="/dateInPlan">กำหนดการเสนอโครงการในแผน</a></li>
                                                <li><a href="/dateReportQuarter">กำหนดการกรอกรายงานรายไตรมาส</a></li>
                                                <li><a href="/project">โครงการ</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                                @if (Auth::check() && auth()->user() && auth()->user()->Responsible == 1)
                                    <ul class="nav side-menu">
                                        {{-- สิทธิ์ผู้เขียนโครงการ --}}
                                        <li><a><i class="fa fa-user"></i> ผู้รับผิดชอบโครงการ <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">

                                                <li><a href="/project">รายชื่อโครงการ</a></li>
                                                <li><a href="/projectOutPlan">รายชื่อโครงการนอกแผน</a></li>
                                                {{-- โครงการที่ไม่อนุมัติ --}}
                                                <li><a href="#">รายชื่อโครงการที่ไม่อนุมัติ/ยกเลิก</a></li>
                                                <li><a href="/projectcreate1">สร้างโครงการใหม่</a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                                @if (Auth::check() && auth()->user() && auth()->user()->Department_head == 1)
                                    <ul class="nav side-menu">
                                        <li><a><i class="fa fa-user"></i> หัวหน้าฝ่าย <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">

                                                <li><a href="/DepartmentHeadProject">รายชื่อโครงการ</a></li>

                                                <li><a href="/DepartmentHeadProjectOutPlan">รายชื่อโครงการนอกแผน</a>
                                                </li>
                                                <li><a href="#">รายชื่อโครงการที่ไม่อนุมัติ/ยกเลิก</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                                @if (Auth::check() && auth()->user() && auth()->user()->Planning_Analyst == 1)
                                    <ul class="nav side-menu">
                                        <li><a><i class="fa fa-user"></i> เจ้าหน้าที่แผน <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="/PlanningAnalystProjectAll">รายชื่อโครงการทั้งหมด</a></li>

                                                <li><a href="/PlanningAnalystProject">รายชื่อโครงการในแผนรอพิจารณา</a>
                                                </li>
                                                <li><a
                                                        href="/PlanningAnalystProjectOutPlan">รายชื่อโครงการนอกแผนรอพิจารณา</a>
                                                </li>
                                                {{-- โครงการที่ไม่อนุมัติ --}}
                                                <li><a
                                                        href="/PlanningAnalystProjectCancel">รายชื่อโครงการที่ไม่อนุมัติ/ยกเลิก</a>
                                                </li>


                                            </ul>
                                        </li>
                                    </ul>
                                @endif

                                @if (Auth::check() && auth()->user() && auth()->user()->Executive == 1)
                                    <ul class="nav side-menu">
                                        <li><a><i class="fa fa-user"></i> ผู้บริหาร <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">

                                                <li><a href="/ExecutiveProjectlist">รายชื่อโครงการ</a></li>
                                                <li><a href="/ExecutiveProjectOutPlan">รายชื่อโครงการนอกแผน</a></li>
                                                <li><a
                                                        href="/ExecutiveProjectDenied">รายชื่อโครงการที่ไม่อนุมัติ/ยกเลิก</a>
                                                </li>


                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                                @if (Auth::check() && auth()->user() && auth()->user()->Supply_Analyst == 1)
                                    <ul class="nav side-menu">
                                        <li><a><i class="fa fa-user"></i> เจ้าหน้าที่พัสดุ <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">

                                                <li><a href="/SupplyAnalystProject">รายชื่อโครงการ</a></li>
                                                <li><a href="/SupplyAnalystProjectOutPlan">รายชื่อโครงการนอกแผน</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif

                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-home"></i> รายงาน <span
                                                class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <p> เอกสาร PDF</p>

                                            <?php
                                                $conn = mysqli_connect('localhost', 'root', '', 'plan');
                                                if ($conn->connect_error) {
                                                    die('Connection failed: ' . $conn->connect_error);
                                                }

                                                $sql = "SELECT yearID,year FROM years ";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                    ?>
                                            <li><a href="{{ route('plan.PDF', $row['yearID']) }}"
                                                    target="_blank">รายงานแผนปฏิบัติการ <?php echo $row['year']; ?> </a></li>
                                            <?php
                                                    }
                                                } ?>

                                            <p> เอกสาร Excel</p>

                                            <?php
                                                $conn = mysqli_connect('localhost', 'root', '', 'plan');
                                                if ($conn->connect_error) {
                                                    die('Connection failed: ' . $conn->connect_error);
                                                }
                                                $sql = "SELECT yearID,year FROM years ";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                    ?>
                                            <li><a href="{{ route('plan.Excel', $row['yearID']) }}">รายงานแผนปฏิบัติการ
                                                    <?php echo $row['year']; ?> </a></li>
                                            <?php
                                                    }
                                                } ?>
                                        </ul>
                                    </li>
                                </ul>

                            @endif







                        </div>
                    </div>
                    {{-- <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>General</h3>
                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-home"></i> Home <span
                                                class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/">ข่าวประชาสัมพันธ์</a></li>
                                            <li><a href="/project">โครงการ</a></li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}

                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav ">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="navbar-left m-2">

                            </div>
                            <ul class=" navbar-right">
                                @auth
                                    <li class="nav-item dropdown open" style="padding-left: 15px;">
                                        <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                                            id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                            {{-- <img src="{{ asset('production/images/img.jpg') }}" alt=""> --}}
                                            {{ Auth::user()->displayname }}
                                        </a>
                                        <div class="dropdown-menu dropdown-usermenu pull-right"
                                            aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="javascript:;"> Profile</a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <span class="badge bg-red pull-right">50%</span>
                                                <span>Settings</span>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">Help</a>
                                            <a class="dropdown-item" href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                    class="fa fa-sign-out pull-right"></i>
                                                Log Out</a>
                                        </div>
                                    </li>
                                @endauth
                                @guest
                                    <li class="nav-item" style="padding-left: 15px;">
                                        <a class="nav-link" href="/login">Login</a>
                                    </li>
                                @endguest

                                {{-- <li role="presentation" class="nav-item dropdown open">
                                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="badge bg-green">6</span>
                                    </a>
                                    <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                        aria-labelledby="navbarDropdown1">
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                                <span class="image"><img src="images/img.jpg"
                                                        alt="Profile Image" /></span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They
                                                    were
                                                    where...
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                                <span class="image"><img src="images/img.jpg"
                                                        alt="Profile Image" /></span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They
                                                    were
                                                    where...
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                                <span class="image"><img src="images/img.jpg"
                                                        alt="Profile Image" /></span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They
                                                    were
                                                    where...
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item">
                                                <span class="image"><img src="images/img.jpg"
                                                        alt="Profile Image" /></span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They
                                                    were
                                                    where...
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <div class="text-center">
                                                <a class="dropdown-item">
                                                    <strong>See All Alerts</strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li> --}}
                            </ul>
                        </div>
                    </nav>
                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->

                <!-- /top tiles -->
                <div class="container py-5">
                    @yield('content')
                </div>
                <div class="clearfix"></div>

            </div>
            <!-- /page content -->

            <!-- footer content -->
            {{-- <footer> --}}
            {{-- <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div> --}}
            {{-- <div class="clearfix"></div>



            </footer> --}}
            <!-- /footer content -->

        </div>
    </div>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>
