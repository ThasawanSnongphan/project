@extends('layout')
@section('title', 'User')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    
                    
                    @include('Users.create');

                    <div class="row" style="display: block;">
                        <div class="col-md-12 col-sm-12  ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>User</h2>
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

                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <th>
                                                        <input type="checkbox" id="check-all" class="flat">
                                                    </th>
                                                    <th class="column-title">username </th>
                                                    <th class="column-title">name</th>
                                                    <th class="column-title">email</th>
                                                    <th class="column-title">position_name</th>
                                                    <th class="column-title">faculty_name</th>
                                                    <th class="column-title">department_name</th>
                                                    
                                                    
                                                    <th class="column-title no-link last"><span class="nobr">Action</span>
                                                    </th>
                                                    <th class="bulk-actions" colspan="7">
                                                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk
                                                            Actions ( <span class="action-cnt"> </span> ) <i
                                                                class="fa fa-chevron-down"></i></a>
                                                    </th><th class="column-title"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                    $i=1;
                                                @endphp
                                                @foreach ($users as $user)
                                                    <tr class="even pointer">
                                                        <td class="a-center ">
                                                            <input type="checkbox" class="flat" name="table_records">
                                                        </td>
                                                        <td class=" ">{{ $user->username }}</td>
                                                        <td class=" ">{{ $user->displayname }}</td>
                                                        <td class=" ">{{ $user->email }}</td>

                                                        <td class=" ">{{ $user->position_name }}</td>
                                                        <td class=" ">{{ $user->faculty_name }}</td>
                                                        <td class=" ">{{ $user->department_name }}</td>
                                                            <td class=" last"><a href="#">View </a>
                                                            </td>
                                                            <td>
                                                                 <a
                                                                href="{{ route('users.edit', $user->userID) }}"><i
                                                                    class="fa fa-pencil btn btn-warning"></i></a>
                                                            <a href="{{ route('users.delete', $user->userID) }}"
                                                                onclick="return confirm('ต้องการลบ {{ $user->username }} หรือไม่')"><i
                                                                    class="fa fa-times btn btn-danger"></i></a></td>
                                                        
                                                    </tr>
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
            <!-- /page content -->
        </div>
    </div>
@endsection
