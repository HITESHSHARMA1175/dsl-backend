@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <form action="{{ route('team.update', $team_info->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="main-container container-fluid">
                <div class="inner-body">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5">Edit Team</h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Team </a></li>
                            </ol>
                        </div>
                        <div class="d-flex">
                            <div class="justify-content-center">
                                {{-- 
                                <button type="button" class="btn btn-primary my-2 btn-icon-text">
                                    <i class="fe fe-download-cloud me-2"></i> Print
                                </button> --}}
                            </div>
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <!-- Row -->
                    <div class="row row-sm">
                        <div class="col-lg-3 col-md-3">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Team Image</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="profile"
                                                    data-default-file="{{ !empty($team_info->profile) ? asset('uploads/team/' . $team_info->profile) : asset('assets/img/media/1.jpg') }}"
                                                    data-height="200" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label  mb-3">Team Info</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="team_name"
                                                    value="{{ $team_info->team_name }}" type="text">
                                            </div>
                                            @error('team_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Email: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="email"
                                                    value="{{ $team_info->email }}" type="email">
                                            </div>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Mobile: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="mobile"
                                                    value="{{ $team_info->mobile }}" type="text">
                                            </div>
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <label class="form-label">Gender: <span class="tx-danger">*</span></label>
                                            <select class="form-control select2" name="gender">
                                                <option value="">Select</option>
                                                <option value="Male"
                                                    {{ $team_info->gender == 'Male' ? 'Selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ $team_info->gender == 'Female' ? 'Selected' : '' }}>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10 d-none">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Designation: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="designation"
                                                    value="{{ $team_info->designation }}" type="text">
                                            </div>
                                            @error('designation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mg-t-10">
                                            <div class="form-group mb-0">
                                                <label class="form-label">Profession: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="profession"
                                                    value="{{ $team_info->profession }}" type="text">
                                            </div>
                                            @error('profession')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="row row-sm">
                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label  mb-3">Work Category</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-sm-12">

                                            <div class="form-group">
                                                <div>
                                                    <td>
                                                        <?php 
                                                        $work_categoryarr=explode(",",$team_info->work_category);
                										foreach ($categories as $key => $value) {?>
                                                        <input type="checkbox" name="work_category[]"
                                                            value="<?php echo $value->id; ?>"
                                                            <?php echo $chktext = in_array($value->id, $work_categoryarr) ? 'checked' : ''; ?>>&nbsp;<?php echo $value->category_name; ?>
                                                        &nbsp;&nbsp;
                                                        <?php }
                										?>
                                                    </td>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row row-sm">
                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label  mb-3">Work Condition</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-sm-12">

                                            <div class="form-group">
                                                <div>
                                                    <td>
                                                        <?php 
                                                        $work_conditionarr=explode(",",$team_info->work_condition);
                										foreach ($conditions as $key => $value) {?>
                                                        <input type="checkbox" name="work_condition[]"
                                                            value="<?php echo $value->id; ?>"
                                                            <?php echo $chktext = in_array($value->id, $work_conditionarr) ? 'checked' : ''; ?>>&nbsp;<?php echo $value->category_name; ?>
                                                        &nbsp;&nbsp;
                                                        <?php }
                										?>
                                                    </td>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row row-sm">
                        <div class="col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body">

                                    <div>
                                        <h6 class="main-content-label mb-1">Working Days</h6>
                                    </div>
                                    <div class="row row-sm">


                                        <div class="card-body">



                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">

                                                        <div class="row mb-3">
                                                            <div class="col-md-2">
                                                                <label for="0">Monday</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-4 ">
                                                                <input type="time" required="" id="0"
                                                                    class="form-control start_time" name="start_time[]"
                                                                    value="{{ $team_info->monday_start }}">

                                                            </div>
                                                            <div class="col-md-1 col-sm-2 mt-2 col-4 text-center">
                                                                To </div>
                                                            <div class="col-md-3 col-sm-3 col-4 endTime">
                                                                <input type="time" id="0" required=""
                                                                    class="form-control end_time" name="end_time[]"
                                                                    value="{{ $team_info->monday_end }}">
                                                            </div>
                                                            <div class="col-md-2 col-sm-3 m-sm-1 mt-3">
                                                                <div class="form-check mt-1">
                                                                    <div class="button b2 working-days_checkbox"
                                                                        id="button-11">

                                                                        <input type="checkbox" class="checkbox check_box"
                                                                            name="monday"
                                                                            {{ $team_info->monday == '1' ? 'checked' : '' }}
                                                                            id="flexCheckDefault"> Check if
                                                                        working day
                                                                        <div class="knobs">
                                                                            <span></span>
                                                                        </div>
                                                                        <div class="layer"></div>
                                                                    </div>

                                                                </div>


                                                            </div>



                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="1"> Tuesday</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-4">
                                                            <input type="time" id="1"
                                                                class="form-control start_time" name="start_time[]"
                                                                value="{{ $team_info->tuesday_start }}">
                                                        </div>
                                                        <div class="col-md-1 col-sm-2 mt-2 col-4 text-center">
                                                            To </div>
                                                        <div class="col-md-3 col-sm-3 col-4 endTime">
                                                            <input type="time" id="01"
                                                                class="form-control end_time" name="end_time[]"
                                                                value="{{ $team_info->tuesday_end }}">
                                                        </div>
                                                        <div class="col-md-2 col-sm-3 m-sm-1 mt-3">
                                                            <div class="form-check mt-1">
                                                                <div class="button b2 working-days_checkbox"
                                                                    id="button-11">

                                                                    <input type="checkbox" class="checkbox check_box"
                                                                        name="tuesday"
                                                                        {{ $team_info->tuesday == '1' ? 'checked' : '' }}
                                                                        id="flexCheckDefault"> Check if
                                                                    working day
                                                                    <div class="knobs">
                                                                        <span></span>
                                                                    </div>
                                                                    <div class="layer"></div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="2"> Wednesday</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-4">
                                                            <input type="time" id="2"
                                                                class="form-control start_time" name="start_time[]"
                                                                value="{{ $team_info->wednesday_start }}">
                                                        </div>
                                                        <div class="col-md-1 col-sm-2 mt-2 col-4 text-center">
                                                            To </div>
                                                        <div class="col-md-3 col-sm-3 col-4 endTime">
                                                            <input type="time" id="02"
                                                                class="form-control end_time" name="end_time[]"
                                                                value="{{ $team_info->wednesday_end }}">
                                                        </div>
                                                        <div class="col-md-2 col-sm-3 m-sm-1 mt-3">
                                                            <div class="form-check mt-1">
                                                                <div class="button b2 working-days_checkbox"
                                                                    id="button-11">

                                                                    <input type="checkbox" class="checkbox check_box"
                                                                        name="wednesday"
                                                                        {{ $team_info->wednesday == '1' ? 'checked' : '' }}
                                                                        id="flexCheckDefault"> Check if
                                                                    working day
                                                                    <div class="knobs">
                                                                        <span></span>
                                                                    </div>
                                                                    <div class="layer"></div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="3"> Thursday</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-4">
                                                            <input type="time" id="3"
                                                                class="form-control start_time" name="start_time[]"
                                                                value="{{ $team_info->thursday_start }}">
                                                        </div>
                                                        <div class="col-md-1 col-sm-2 mt-2 col-4 text-center">
                                                            To </div>
                                                        <div class="col-md-3 col-sm-3 col-4 endTime">
                                                            <input type="time" class="form-control end_time"
                                                                name="end_time[]"
                                                                value="{{ $team_info->thursday_end }}">
                                                        </div>
                                                        <div class="col-md-2 col-sm-3 m-sm-1 mt-4">
                                                            <div class="form-check mt-1">
                                                                <div class="button b2 working-days_checkbox"
                                                                    id="button-11">

                                                                    <input type="checkbox" class="checkbox check_box"
                                                                        name="thursday"
                                                                        {{ $team_info->thursday == '1' ? 'checked' : '' }}
                                                                        id="flexCheckDefault"> Check if
                                                                    working day
                                                                    <div class="knobs">
                                                                        <span></span>
                                                                    </div>
                                                                    <div class="layer"></div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="4"> Friday</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-4">
                                                            <input type="time" id="4"
                                                                class="form-control start_time" name="start_time[]"
                                                                value="{{ $team_info->friday_start }}">
                                                        </div>
                                                        <div class="col-md-1 col-sm-2 mt-2 col-4 text-center">
                                                            To </div>
                                                        <div class="col-md-3 col-sm-3 col-4 endTime">
                                                            <input type="time" class="form-control end_time"
                                                                name="end_time[]"
                                                                value="{{ $team_info->friday_end }}">
                                                        </div>
                                                        <div class="col-md-2 col-sm-3 m-sm-1 mt-3">
                                                            <div class="form-check mt-1">
                                                                <div class="button b2 working-days_checkbox"
                                                                    id="button-11">

                                                                    <input type="checkbox" class="checkbox check_box"
                                                                        name="friday"
                                                                        {{ $team_info->friday == '1' ? 'checked' : '' }}
                                                                        id="flexCheckDefault"> Check if
                                                                    working day
                                                                    <div class="knobs">
                                                                        <span></span>
                                                                    </div>
                                                                    <div class="layer"></div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="5"> Saturday</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-4">
                                                            <input type="time" id="5"
                                                                class="form-control start_time" name="start_time[]"
                                                                value="{{ $team_info->saturday_start }}">
                                                        </div>
                                                        <div class="col-md-1 col-sm-2 mt-2 col-4 text-center">
                                                            To </div>
                                                        <div class="col-md-3 col-sm-3 col-4 endTime">
                                                            <input type="time" class="form-control end_time"
                                                                name="end_time[]"
                                                                value="{{ $team_info->saturday_end }}">
                                                        </div>
                                                        <div class="col-md-2 col-sm-3 m-sm-1 mt-3">
                                                            <div class="form-check mt-1">
                                                                <div class="button b2 working-days_checkbox"
                                                                    id="button-11">

                                                                    <input type="checkbox" class="checkbox check_box"
                                                                        name="saturday"
                                                                        {{ $team_info->saturday == '1' ? 'checked' : '' }}
                                                                        id="flexCheckDefault"> Check if
                                                                    working day
                                                                    <div class="knobs">
                                                                        <span></span>
                                                                    </div>
                                                                    <div class="layer"></div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="6"> Sunday</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-4">
                                                            <input type="time" id="6"
                                                                class="form-control start_time" name="start_time[]"
                                                                value="{{ $team_info->sunday_start }}">
                                                        </div>
                                                        <div class="col-md-1 col-sm-2 mt-2 col-4 text-center">
                                                            To </div>
                                                        <div class="col-md-3 col-sm-3 col-4 endTime">
                                                            <input type="time" class="form-control end_time"
                                                                name="end_time[]"
                                                                value="{{ $team_info->sunday_end }}">
                                                        </div>
                                                        <div class="col-md-2 col-sm-3 m-sm-1 mt-3">
                                                            <div class="form-check mt-1">
                                                                <div class="button b2 working-days_checkbox"
                                                                    id="button-11">

                                                                    <input type="checkbox" class="checkbox check_box"
                                                                        name="sunday"
                                                                        {{ $team_info->sunday == '1' ? 'checked' : '' }}
                                                                        id="flexCheckDefault"> Check if
                                                                    working day
                                                                    <div class="knobs">
                                                                        <span></span>
                                                                    </div>
                                                                    <div class="layer"></div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row row-sm">
                        <div class="col-lg-3 col-md-3">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Banner Image (English)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="banner"
                                                    data-default-file="{{ !empty($team_info->banner) ? asset('uploads/team/' . $team_info->banner) : asset('assets/img/media/1.jpg') }}"
                                                    data-height="188" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label  mb-3">Long Description (English)</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                            <textarea class="form-control textarea"  name="long_description" id="editor1" placeholder="" rows="8">{{ $team_info->long_description }}</textarea>
														
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 ">
                                    <div class="form-group mb-10">
                                        <label class="form-label">Description (English) <span
                                                class="tx-danger"></span></label>
                                        <input class="form-control" name="description" value="{{ $team_info->description }}"  type="text">
                                    </div>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        
                    </div>
                    
                    <div class="row row-sm">
                        <div class="col-lg-3 col-md-3">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Banner Image (Urdu)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="banner_cn"
                                                    data-default-file="{{ !empty($team_info->banner_cn) ? asset('uploads/team/' . $team_info->banner_cn) : asset('assets/img/media/1.jpg') }}"
                                                    data-height="188" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label  mb-3">Long Description (Urdu)</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                            <textarea class="form-control textarea"  name="long_description_cn" id="editor_cn" placeholder="" rows="8">{{ $team_info->long_description_cn }}</textarea>
														
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 ">
                                    <div class="form-group mb-10">
                                        <label class="form-label">Description (Urdu) <span
                                                class="tx-danger"></span></label>
                                        <input class="form-control" name="description_cn" value="{{ $team_info->description_cn }}"  type="text">
                                    </div>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        
                    </div>
                    
                    <div class="row row-sm">
                        <div class="col-lg-3 col-md-3">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-4">Banner Image (Arabic)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row row-sm">
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" class="dropify" name="banner_ar"
                                                    data-default-file="{{ !empty($team_info->banner_ar) ? asset('uploads/team/' . $team_info->banner_ar) : asset('assets/img/media/1.jpg') }}"
                                                    data-height="188" accept="image/*" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label  mb-3">Long Description (Arabic)</h6>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                            <textarea class="form-control textarea"  name="long_description_ar" id="editor_ar" placeholder="" rows="8">{{ $team_info->long_description_ar }}</textarea>
														
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 ">
                                    <div class="form-group mb-10">
                                        <label class="form-label">Description (Arabic)<span
                                                class="tx-danger"></span></label>
                                        <input class="form-control" name="description_ar" value="{{ $team_info->description_ar }}"  type="text">
                                    </div>
                                    @error('description_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        
                    </div>
                    
                    
                    
                    <!-- End Row -->




                </div>
                <!-- End Row -->


                <div class="row row-sm">
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Main Content-->

<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

//[editor Javascript]

//Project:	Rhythm Admin - Responsive Admin Template
//Primary use:   Used only for the wysihtml5 Editor 


//Add text editor
    $(function () {
    "use strict";

    // Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace('editor1')
	CKEDITOR.replace('editor_cn')
	CKEDITOR.replace('editor_ar')
	
	$('.textarea').wysihtml5();		
	
  });


</script> 


@endsection
