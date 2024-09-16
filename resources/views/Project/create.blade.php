<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>สร้างโครงการ</h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
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
                    <form class="" action="" method="post" novalidate>
                        <div class="col-lg-3 col-md-2 col-sm-2">
                            <div class="row">
                                <label class="col-form-label col-md-3 col-sm-3 " for="heard">ปีงบประมาณ*</label>
                                <div class="ml-2 col-md-8 col-sm-8">
                                    <select id="heard" class="form-control" required>
                                        <option value="">...</option>
                                        <option value="press">Press</option>
                                        <option value="net">Internet</option>
                                        <option value="mouth">Word of mouth</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-9 col-md-10 col-sm-10">
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">ชื่อโครงการ<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" data-validate-length-range="6" data-validate-words="2"
                                        name="name" required="required" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label
                                    class="col-form-label col-md-3 col-sm-3  label-align">ชื่อผู้รับผิดชอบโครงการ<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex flex-column" id="input-container">
                                    <input class="form-control mt-2" name="occupation[]"
                                        data-validate-length-range="5,15" type="text" />
                                </div>
                                <div class="col-form-label col-md-3 col-sm-3">
                                    <button type="button" class="btn btn-primary"
                                        id="add-input-btn">เพิ่มผู้รับผิดชอบ</button>
                                </div>
                            </div>
                            <script>
                                // Get the button and container for inputs
                                const addInputBtn = document.getElementById('add-input-btn');
                                const inputContainer = document.getElementById('input-container');

                                // Add event listener to the button
                                addInputBtn.addEventListener('click', function() {
                                    // Create a new div to hold input and delete button
                                    const newDiv = document.createElement('div');
                                    newDiv.setAttribute('class', 'd-flex align-items-center mt-2');

                                    // Create a new input element
                                    const newInput = document.createElement('input');
                                    newInput.setAttribute('type', 'text');
                                    newInput.setAttribute('name', 'occupation[]');
                                    newInput.setAttribute('class', 'form-control mr-2');
                                    newInput.setAttribute('data-validate-length-range', '5,15');

                                    // Create a delete button
                                    const deleteBtn = document.createElement('button');
                                    deleteBtn.setAttribute('type', 'button');
                                    deleteBtn.setAttribute('class', 'btn btn-danger btn-sm');
                                    deleteBtn.textContent = 'ลบ';

                                    // Add event listener to remove the input when delete button is clicked
                                    deleteBtn.addEventListener('click', function() {
                                        newDiv.remove();
                                    });

                                    // Append the input and delete button to the div
                                    newDiv.appendChild(newInput);
                                    newDiv.appendChild(deleteBtn);

                                    // Append the new div to the container
                                    inputContainer.appendChild(newDiv);
                                });
                            </script>

                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">สังกัด<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" name="email" class='email' required="required"
                                        type="email" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label
                                    class="col-form-label col-md-3 col-sm-3 label-align">ความเชื่อมโยง/ความสอดคล้อง<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 mt-2 ">
                                    <select id="heard" class="form-control" required>
                                        <option value="">...</option>
                                        <option value="press">Press</option>
                                        <option value="net">Internet</option>
                                        <option value="mouth">Word of mouth</option>
                                    </select>
                                </div>
                                <div class="col-form-label col-md-3 col-sm-3" >
                                    <button type="button" class="btn btn-primary"
                                       >เพิ่มแผนยุทธ์ศาสตร์</button>
                                </div>
                            </div>

                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">หลักการและเหตุผล<span
                                        class="required">*</span></label>
                                <div class="col-md-9 col-sm-9">
                                    <textarea required="required" name='message'></textarea>
                                </div>
                            </div>

                        </div>
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
</div>
