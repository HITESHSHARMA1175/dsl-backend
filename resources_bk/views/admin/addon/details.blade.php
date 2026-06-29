@extends('admin.layout.app')
@section('content')
    <style>
        main .timeline p {
            line-height: 1.8;
        }

        time {
            line-height: 1.6;
        }

        body {
            min-width: 375px;

            font-family: "Poppins", sans-serif;

            background-color: #f1f1f1;
            color: #1a1a1a;
        }

        main {
            /* min-height: 100vh; */

            display: grid;
            /* place-content: center; */

            /* padding: 1rem; */
        }

        /* ===================== */
        /* ===================== */

        /* Timeline */
        /* Code Here ↓ */

        .timeline {
            padding: 1.5rem 2rem;
            max-width: auto;
            border-radius: 12px;
            background-color: white;
        }

        .tl-content .tl-header,
        .tl-content .tl-body {
            padding-left: 25.6px;

            border-left: 2px dotted #eeeeee;
        }

        .tl-body {
            padding-bottom: 1rem;
        }

        .tl-content:last-child .tl-body {
            border-left: 3px solid transparent;
        }

        .tl-header {
            position: relative;
            display: grid;

            /* padding-top: 1rem;
                                                                                                                                                                                                                                                                                                                            padding-bottom: 1rem; */
        }

        .tl-title {
            font-weight: 700;
            font-size: 1.2em;

            border-bottom: 0;
        }

        .tl-time {
            font-size: 0.9em;
        }

        .tl-marker {
            display: block;
            position: absolute;

            width: 16px;
            height: 16px;
            border-radius: 50% / 50%;

            background: gainsboro;

            left: -1.1rem;
            top: 50%;

            transform: translate(50%, -50%);
        }

        .tl-content-active .tl-marker {
            padding: 1.6px;

            left: -1.25rem;

            width: 18px;
            height: 18px;
border: 2px solid #141614;
    background-color: #141614;
            background-clip: content-box;

            box-shadow: 0 0 15px -2px #ddd;
        }

        .tl-content .tl-title {
            font-weight: 700;
            color: green;font-size:14px;
        }

        .tl-body p span {
            display: block;
        }

        /* Code Here ↑ */
        /* Timeline */

        /* ==================== */
    </style>
    <!-- Main Content-->
    <div class="main-content side-content pt-0 mt-5">
        <div class="main-container container-fluid">
            <div class="inner-body">
                <!-- Page Header -->
                    <div class="row">
                    <div class="col-lg-7">
                        <div class="card custom-card border mt-4 mb-4">
                            <div class="card-header pb-3">
            					<h6 class="mb-0">Property Info</h6>
            				</div>
                            <div class="card-body">
                               
                                <main>
                                    <div class="timeline">
                                        
                                            <div class="tl-content tl-content-active }} ">
                                                <div class="tl-header">
                                                    <span class="tl-marker"></span>
                                                    <p class="mb-0">
                                                        <i class="fe fe-arrow-right me-2"></i><b style=" color: #4b4b95;font-weight:normal"> Property Sale Type</b> : 
                                                        {{ @$property_info->getPropertySaleType->MasterValue }}
                                                    </p>
                                                </div>
                                                <div class="tl-body">
                                                    <p class="mb-4" >
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Property Name</b> :
                                                            {{ @$property_info->property_name  }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Owner Name</b> :
                                                            {{ @$property_info->getPropertyOwner->first_name . ' ' . @$property_info->getPropertyOwner->last_name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Builder Name</b> :
                                                            {{ @$property_info->getPropertyBuilder->builder_name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Project Name</b> :
                                                            {{ @$property_info->getPropertySociety->society_name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Property Category</b> :
                                                            {{ @$property_info->getPropertyCategory->category_name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Property Sub Category</b> :
                                                            {{ @$property_info->getPropertySubCategory->category_name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Property Size</b> :
                                                            {{ @$property_info->property_size }} Sqft
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Address</b> :
                                                            {{ $property_info->address }}
                                                            {{ !empty($property_info->getPropertyCity->name) ? @$property_info->getPropertyCity->name . ',' : '' }}
                                                            {{ !empty($property_info->getPropertyState->name) ? @$property_info->getPropertyState->name . ',' : '' }}
                                                            {{ @$property_info->getPropertyCountry->name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Floor Name</b> :
                                                            {{ @$property_info->floor_name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Unit no</b> :
                                                            {{ @$property_info->unit_no }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Tower no</b> :
                                                            {{ @$property_info->tower_no }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Saleable Area</b> :
                                                            {{ @$property_info->salable_area }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Base Rate ( After Discount)</b> :
                                                            {{ @$property_info->base_rate }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Unit Value</b> :
                                                            {{ @$property_info->unit_value }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Total Cost</b> :
                                                            {{ @$property_info->total_cost }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Outstanding principle</b> :
                                                            {{ @$property_info->outstanding_principle }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Broker Name</b> :
                                                            {{ @$property_info->broker_name }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Possession Type</b> :
                                                            {{ @$property_info->possession_status }}
                                                        </span>
                                                        @if(@$property_info->possession_status=='Ready To Move-In')
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Registration no</b> :
                                                            {{ @$property_info->registration_no }}
                                                        </span>
                                                        @endif
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Loan on Property</b> :
                                                            {{ @$property_info->loan_on_property }}
                                                        </span>
                                                        @if(@$property_info->loan_on_property=='Yes')
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Bank Name</b> :
                                                            {{ @$property_info->loan_bank_name }}
                                                        </span>
                                                        @endif
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Video link</b> :
                                                            {{ @$property_info->video_link }}
                                                        </span>
                                                        
                                                        
                                                    </p>
                                                </div>
                                            </div>
                                            
                                           
                                    </div>
                                </main>
                            </div>
                        </div>
                        
                        <div class="card custom-card border mt-4 mb-4">
                            <div class="card-header pb-3">
            					<h6 class="mb-0">Property Price History</h6>
            				</div>
                            <div class="card-body">
                               
                                <main>
                                    <div class="timeline">
                                            @if(@$propertyjourneys)
                                            @foreach($propertyjourneys as $history)
                                            <div class="tl-content tl-content-active }} ">
                                                <div class="tl-header">
                                                    <span class="tl-marker"></span>
                                                    <p class="mb-0">
                                                        <i class="fe fe-arrow-right me-2"></i><b style=" color: #4b4b95;font-weight:normal"> Old Base Rate ( After Discount)</b> : 
                                                        {{ @$history->old_base_rate }}
                                                    </p>
                                                </div>
                                                <div class="tl-body">
                                                    <p class="mb-4" >
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Old Unit Value</b> :
                                                            {{ @$history->old_unit_value }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">Old Total Cost</b> :
                                                            {{ @$history->old_total_cost }}
                                                        </span>
                                                        
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">New Base Rate ( After Discount)</b> :
                                                            {{ @$history->base_rate }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">New Unit Value</b> :
                                                            {{ @$history->unit_value }}
                                                        </span>
                                                        <span><i class="fe fe-arrow-right me-2"></i>
                                                            <b style=" color: #4b4b95;font-weight:normal">New Total Cost</b> :
                                                            {{ @$history->total_cost }}
                                                        </span>
                                                        
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                           
                                    </div>
                                </main>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-5">
                         <div class="card custom-card border mb-4 mt-4">
    					<div class="card-header pb-3">
    					<h6 class="mb-0">Images</h6> 
    					</div>
    						<div class="card-body">
    						 <div class="row">
    						     
    							<div class="col-sm-12">
                                	<div class="main-profile-contact-list mb-3">
                                	    
                                	    @php @$allImage=@$property_info->getPropertyImages @endphp
                                        @if (count($allImage) > 0)
                                        @foreach ($allImage as $key => $imageItem)
                                	    <div class="media">
                                			<!--<div class="media-icon bg-primary-transparent text-primary"> <i class="icon ion-md-globe"></i> </div>-->
                                			<div class="media-body">
                                				<div>
                                				    @if($imageItem->image!='')
                                				    <a title="View" target="_blank" href="{{ asset('uploads/property/' . $imageItem->image) }}">
                                				        <img class="img" src="{{ asset('uploads/property/' . $imageItem->image) }}" style="height: 170px;">
                                				    </a>
                                				    @else
                                				    NA
                                				    @endif
                                				</div>
                                			</div>
                                		</div>
                                		@endforeach
                                        @endif
                                	</div>
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
