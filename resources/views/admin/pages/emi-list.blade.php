@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">
            <div class="main-container container-fluid">
                <div class="inner-body">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Staff List (2347)</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">HRMS </a></li>
                                <li class="breadcrumb-item active" aria-current="page">Staff List </li>
                            </ol>
                        </div>
                        <div class="d-flex">
                            <div class="justify-content-center"> </div>
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card custom-card">
                                <div class="card-body py-3">
                                    <form action="https://admin.dsl.co.in/admin/employee/All%20User" method="get">
                                        <!--<input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">-->
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Search..." name="search_text" value=""> </div>
                                            <div class="col-sm-3 form-group">
                                                <select class="form-control select select2" name="designation">
                                                    <option value="">Select Area</option>
                                                    <option value="4"> Basti </option>
                                                    <option value="5"> GORAKHPUR </option>
                                                    <option value="6"> kushinagar </option>
                                                    <option value="7"> maharajganj </option>
                                                    <option value="2"> Noida </option>
                                                    <option value="3"> SIDDHARATH NAGAR </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2 ">
                                                <button type="submit" class="btn btn-primary  btn-icon-text"> <i class="fe fe-search me-2"></i> Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row -->
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered  mb-0">
                                            <thead>
                                                <tr>
                                                    <th><b>ID</b></th>
                                                    <th><b>Photo</b></th>
                                                    <th><b>Staff Detail</b></th>
                                                    <th width="25%"><b>Address</b></th>
                                                    <th width="25%"><b>Last Location</b></th>
                                                    <th><b>Actions</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> USR-3156
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Bhagwan PRasad
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 8328944081
                                                            <br> <b>Password:</b> dsl@123 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3156" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3156"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3156/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3156" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3156').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3156" action="https://admin.dsl.co.in/admin/employee/3156" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3155
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Mainuddin Ansari
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 7081008749
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3155" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3155"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3155/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3155" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3155').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3155" action="https://admin.dsl.co.in/admin/employee/3155" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3154
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Dilip kUMAR
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 9935070176
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3154" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3154"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3154/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3154" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3154').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3154" action="https://admin.dsl.co.in/admin/employee/3154" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3153
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Guddu
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 8084726549
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3153" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3153"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3153/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3153" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3153').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3153" action="https://admin.dsl.co.in/admin/employee/3153" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3152
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Deepak Yadav
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 7296093218
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3152" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3152"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3152/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3152" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3152').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3152" action="https://admin.dsl.co.in/admin/employee/3152" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3151
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Hiralal Yadav
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 7070171813
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3151" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3151"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3151/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3151" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3151').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3151" action="https://admin.dsl.co.in/admin/employee/3151" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3150
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Ashok Kushwaha
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 7309614779
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3150" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3150"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3150/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3150" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3150').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3150" action="https://admin.dsl.co.in/admin/employee/3150" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3149
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Tiwari
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 9956679883
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3149" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3149"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3149/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3149" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3149').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3149" action="https://admin.dsl.co.in/admin/employee/3149" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3148
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Santosh Kushwaha
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 9628747222
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3148" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3148"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3148/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3148" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3148').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3148" action="https://admin.dsl.co.in/admin/employee/3148" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> USR-3147
                                                        <br> </td>
                                                    <td><img alt="avatar" class="rounded-circle me-3" src="https://admin.dsl.co.in/assets/img/media/user-img4.jpg" style="width:60px"></td>
                                                    <td>
                                                        <p class="mb-0"> <b>Name:</b> Narsingh Yadav
                                                            <br> <b>Email:</b>
                                                            <br> <b>DOB:</b>
                                                            <br> <b>Gender:</b>
                                                            <br> <b>Area:</b> kushinagar
                                                            <br>
                                                            <br> <b>Mobile:</b> 8756533879
                                                            <br> <b>Password:</b> 1234 </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>City:</b>
                                                            <br> <b>State:</b>
                                                            <br> <b>Country:</b>
                                                            <br> <b>Pincode:</b> </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0"> <b>Address:</b>
                                                            <br> <b>Date:</b>
                                                            <br> <b>Time:</b>
                                                            <br> </p>
                                                    </td>
                                                    <td> <a href="https://admin.dsl.co.in/admin/employee_desable/3147" class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Block</a>
                                                        <br>
                                                        <!--<a href="https://admin.dsl.co.in/admin/employee_desable/3147"
                                                            class="btn ripple  btn-xs w-100 mb-1 btn-success">
                                                            Unblock</a>
                                                        <br>--><a href="https://admin.dsl.co.in/admin/employee/3147/edit" class="btn ripple btn-info btn-xs w-100 mb-1">Edit
                                                            Profile</a>
                                                        <br> <a href="https://admin.dsl.co.in/admin/getUserMap/3147" class="btn ripple btn-info btn-xs w-100 mb-1">Live Location</a>
                                                        <br> <a href="javasctipt:void(0)" class="btn ripple btn-danger btn-xs w-100" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete?')) { document.getElementById('delete-item-form3147').submit(); }">
                                                            Delete
                                                        </a>
                                                        <form id="delete-item-form3147" action="https://admin.dsl.co.in/admin/employee/3147" method="post" style="display: none;">
                                                            <input type="hidden" name="_token" value="mBCiUT5quy5O1SmkDO9RU7OHrVX5KAIEBQozFZY1" autocomplete="off">
                                                            <input type="hidden" name="_method" value="DELETE"> </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <nav>
                                            <ul class="pagination">
                                                <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; Previous"> <span class="page-link" aria-hidden="true">&lsaquo;</span> </li>
                                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=2">2</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=3">3</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=4">4</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=5">5</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=6">6</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=7">7</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=8">8</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=9">9</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=10">10</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=11">11</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=12">12</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=13">13</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=14">14</a></li>
                                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=234">234</a></li>
                                                <li class="page-item"><a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=235">235</a></li>
                                                <li class="page-item"> <a class="page-link" href="https://admin.dsl.co.in/admin/employee/All%20User?page=2" rel="next" aria-label="Next &raquo;">&rsaquo;</a> </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
        </div>
    <!-- End Main Content-->


   
@endsection
