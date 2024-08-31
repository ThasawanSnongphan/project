@extends('layout')
@section('title', 'User')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>User </h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @include('Users.create');

                    <div class="row" style="display: block;">
                        <div class="col-md-12 col-sm-12  ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>User</h2>
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

                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <th>
                                                        <input type="checkbox" id="check-all" class="flat">
                                                    </th>
                                                    <th class="column-title">username </th>
                                                    <th class="column-title">firstname</th>
                                                    <th class="column-title">lastname </th>
                                                    <th class="column-title">email</th>
                                                    
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
                                                        <td class=" ">{{ $user->firstname_en }}</td>
                                                        <td class=" ">{{ $user->lastname_en }}</td>
                                                        <td class=" ">{{ $user->email }}</td>
                                                            <td class=" last"><a href="#">View </a>
                                                            </td>
                                                            <td>
                                                                 <a
                                                                href="{{ route('users.edit', $user->id) }}"><i
                                                                    class="fa fa-pencil btn btn-warning"></i></a>
                                                            <a href="{{ route('users.delete', $user->id) }}"
                                                                onclick="return confirm('ต้องการลบข่าว {{ $user->username }} หรือไม่')"><i
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
