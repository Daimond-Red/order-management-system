@extends('layouts.master')

@section('pageBar')
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title"> Dashboard </h3>
        <span class="kt-subheader__separator kt-hidden"></span>
        <div class="kt-subheader__breadcrumbs">
            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link"> Dashboard </a>

            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Booking Details </a>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Booking Details
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            {{-- <button href="#" class="btn btn-brand btn-elevate btn-icon-sm dataModel"
                                data-href="{{ route('admin.tests.create') }}"
                                data-title="Add new"
                            >
                                <i class="la la-plus"></i>
                                New Record
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
            
                <!--begin::Accordion-->
                <div class="accordion accordion-light  accordion-toggle-arrow" id="accordionExample5">
                    <div class="card">
                        <div class="card-header" id="headingOne5">
                            <div class="card-title" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
                                <i class="flaticon2-delivery-package"></i>ORDER DETAILS
                            </div>
                        </div>
                        <div id="collapseOne5" class="collapse show" aria-labelledby="headingOne5" data-parent="#accordionExample5" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 mt-3">
                                        <div class="kt-timeline-v2">
                                            <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                                                <div class="kt-timeline-v2__item">
                                                    <div class="kt-timeline-v2__item-cricle">
                                                        <i class="fa fa-genderless kt-font-danger"></i>
                                                    </div>
                                                    <div class="kt-timeline-v2__item-text  kt-padding-top-5">
                                                        <small>Pickup Location</small> 
                                                        <h5 class="kt-font-dark kt-font-bold">{{$model->state}}</h5>  
                                                        <p>{{$model->address}}, {{$model->state}}</p> 
                                                    </div>
                                                </div>
                                                <div class="kt-timeline-v2__item">
                                                    <div class="kt-timeline-v2__item-cricle">
                                                        <i class="fa fa-genderless kt-font-success"></i>
                                                    </div>
                                                    <div class="kt-timeline-v2__item-text  kt-padding-top-5">
                                                        <small>Drop Location</small> 
                                                        <h5 class="kt-font-dark kt-font-bold">{{$model->drop_location_state}}</h5>  
                                                        <p>{{$model->drop_location_address}}, {{$model->drop_location_state}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="border-left:1px solid lightgrey" class="col-12 col-md-6 px-5 mt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <div>
                                                    <p class="mb-0">Order ID</p>
                                                    <h5 class="mt-0">{{$model->order_no}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-0">Status</p>
                                                    <h5 class="mt-0 text-success">
                                                    {{ getStatus($model->status) }}
                                                    </h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-0">Total Distance</p>
                                                    <h5 class="mt-0 text-warning">{{$model->distance}} KMS</h5>
                                                </div>
                                                @if($model->status == \App\Booking::COMPLETED)
                                                    <div class="mt-4">
                                                        <p class="mb-0">Rating By Customer</p>
                                                        <span class="stars text-warning" data-rating="{{$model->vendor_rating}}" data-num-stars="5" ></span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <p class="mb-0">Amount Payable</p>
                                                    <h5 class="mt-0 text-primary">
                                                        @if($model->booking_amount)
                                                            <i class="fa fa-rupee-sign"></i> {{ $model->booking_amount }}
                                                        @else 
                                                            NA
                                                        @endif 
                                                    </h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-0">Total Weight In (Tons)</p>
                                                    <h5 class="mt-0">{{ $model->estimate_weight }}</h5>
                                                </div>
                                                @if($model->status == \App\Booking::COMPLETED)
                                                    <div class="mt-4">
                                                        <p class="mb-0">Rating By Vendor</p>
                                                        <span class="stars text-warning" data-rating="{{$model->customer_rating}}" data-num-stars="5" ></span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo5">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo5" aria-expanded="false" aria-controls="collapseTwo5">
                                <i class="flaticon-truck"></i>SHIPMENT DETAILS
                            </div>
                        </div>
                        <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo5" data-parent="#accordionExample5" style="">
                            <div class="card-body">
                                <a href="#" class="kt-notification__item">
                                    <div class="kt-notification__item-details">
                                        <div class="row">
                                            <span>
                                                <i class="flaticon2-calendar h2 ml-5 text-warning"></i>
                                            </span>
                                            <span class="ml-4">
                                                <div class="text-dark">
                                                    <small>BOOKING DATE AND TIME</small>
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    <span class="kt-font-dark kt-font-bold">{{ date('d F Y h:i A', strtotime($model->start_date_time)) }}</span>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="row mt-4">
                                            <span>
                                                <i class="flaticon-event-calendar-symbol h2 ml-5 text-success"></i>
                                            </span>
                                            <span class="ml-4">
                                                <div class="text-dark">
                                                    <small>PICKUP DATE AND TIME</small>
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    <span class="kt-font-dark kt-font-bold">{{ date('d F Y h:i A', strtotime($model->end_date_time)) }}</span>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="row mt-4">
                                            <span>
                                                <i class="flaticon-truck h2 ml-5 text-danger"></i>
                                            </span>
                                            <span class="ml-4">
                                                <div class="text-dark">
                                                    <small>VEHICLE TYPE</small>
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    <span class="kt-font-dark kt-font-bold">{{optional($model->vehicleRel)->title}}</span>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="row mt-4">
                                            <span>
                                                <i class="flaticon2-box h2 ml-5 text-info"></i>
                                            </span>
                                            <span class="ml-4">
                                                <div class="text-dark">
                                                    <small>TYPE OF CARGO</small>
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    <span class="kt-font-dark kt-font-bold">{{optional($model->cargoRel)->title}}</span>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingThree5">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree11" aria-expanded="false" aria-controls="collapseThree11">
                                <i class="flaticon-coins"></i>BID HISTORY
                            </div>
                        </div>
                        <div id="collapseThree11" class="collapse" aria-labelledby="headingThree5" data-parent="#accordionExample5" style="">
                            <div class="card-body">
                                <div class="ml-5">
                                    
                                    <div class="kt-widget6">
                                        <div class="kt-widget6__head">
                                            <div class="kt-widget6__item">
                                                <span>Sceduled For Order ({{$model->order_no}})</span>
                                                <span>Vendor</span>
                                                <span>Amount</span>
                                                <span>Status</span>
                                            </div>
                                        </div>
                                        <div class="kt-widget6__body">
                                            @if(count($model->bookingBidRel))
                                                @foreach($model->bookingBidRel as $m)
                                                    <div class="kt-widget6__item">
                                                        <span>{{ date('l', strtotime($m->created_at)) }}, {{ date('d F Y h:i A', strtotime($m->created_at)) }}</span>
                                                        <span>{{ optional($m->vendorRel)->name }}</span>
                                                        <span class="kt-font-success kt-font-bold"><i class="fa fa-rupee-sign"></i> {{ $m->amount }}
                                                        </span>
                                                        <span>
                                                            @if($m->status == 2)
                                                                <span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">ACCEPTED</span>

                                                            @endif
                                                        </span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="kt-font-dark kt-font-bold">No Information available</p>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header" id="headingThree5">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree5" aria-expanded="false" aria-controls="collapseThree5">
                                <i class="flaticon2-position"></i>TRACKING HISTORY
                            </div>
                        </div>
                        <div id="collapseThree5" class="collapse" aria-labelledby="headingThree5" data-parent="#accordionExample5" style="">
                            <div class="card-body">
                                <div class="ml-5">
                                    <div class="kt-widget6">
                                        <div class="kt-widget6__head">
                                            <div class="kt-widget6__item">
                                                <span>Sceduled For Order ({{$model->order_no}})</span>
                                                <span>Status</span>
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="kt-widget6__body">
                                            @if(count($model->bookingLogsRel))
                                                @foreach($model->bookingLogsRel as $m)
                                                    <div class="kt-widget6__item">
                                                        <span>{{ date('l', strtotime($m->created_at)) }}, {{ date('d F Y h:i A', strtotime($m->created_at)) }}</span>
                                                        <span class="kt-font-dark kt-font-bold">{{ getBookingStatus($m->status) }}</span>
                                                        <span></span>
                                                        
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Allocation  -->
                    <div class="card">
                        <div class="card-header" id="headingAllocation">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseAllocation" aria-expanded="false" aria-controls="collapseAllocation">
                                <i class="flaticon-app"></i>Booking Allocation
                            </div>
                        </div>
                        <div id="collapseAllocation" class="collapse" aria-labelledby="headingAllocation" data-parent="#accordionExample5" style="">
                            <div class="card-body">
                                <div class="ml-5">
                                    <div class="kt-widget6">
                                        <div class="kt-widget6__head">
                                            <div class="kt-widget6__item">
                                                <span>Allocation For Order ({{$model->order_no}})</span>
                                                <span>Vendor</span>
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="kt-widget6__body">
                                            @if(count($model->bookingAllocationRel))
                                                @foreach($model->bookingAllocationRel as $m)
                                                    <div class="kt-widget6__item">
                                                        <span>{{ date('l', strtotime($m->created_at)) }}, {{ date('d F Y h:i A', strtotime($m->created_at)) }}</span>
                                                        <span class="kt-font-dark kt-font-bold">{{ optional($m->vendorRel)->name }}</span>
                                                        <span></span>
                                                        
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>No Information available</p>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Booking Allocation  -->

                    <!-- customer detaills -->
                    <div class="card">
                        <div class="card-header" id="headingTwo6">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo6" aria-expanded="false" aria-controls="collapseTwo5">
                                <i class="flaticon-user"></i>CUSTOMER DETAILS
                            </div>
                        </div>
                        <div id="collapseTwo6" class="collapse" aria-labelledby="headingTwo6" data-parent="#accordionExample5" style="">
                            <div class="card-body">
                                <a href="{{ route('admin.customers.show', optional($model->customerRel)->id) }}" class="kt-notification__item">
                                    <div class="kt-notification__item-details">
                                        <div class="row">
                                            <div class="col-12 col-md-4 mt-3 text-center">
                                                <div>
                                                    <img class="rounded-circle" src="{{ getImageUrl($model->image) }}" alt="customer" width="70" height="70">
                                                </div>
                                                <p class="kt-font-primary kt-font-bold h4 pt-3 mb-0">{{optional($model->customerRel)->name}}</p>
                                                <p class="kt-font-dark kt-font-bold h6 ">{{optional($model->customerRel)->email}}</p>
                                            </div>
                                            <div class="col-12 col-md-4 mt-3">
                                                <div class="row">
                                                    <div class="col-2 pt-1">
                                                        <i class="flaticon2-phone h4 text-info"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="text-dark">
                                                            <small>Phone Number :</small>
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            <span class="kt-font-dark kt-font-bold">{{optional($model->customerRel)->mobile_no}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-2 pt-1">
                                                        <i class="flaticon2-website h4 text-primary"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="text-dark">
                                                            <small>GSTIN</small>
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            <span class="kt-font-dark kt-font-bold">
                                                                @if(optional($model->customerRel)->gstin)
                                                                    {{optional($model->customerRel)->gstin  }}
                                                                @else
                                                                    NA
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-2 pt-1">
                                                        <i class="flaticon2-website h4 text-warning"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="text-dark">
                                                            <small>Aadhar Number :</small>
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            <span class="kt-font-dark kt-font-bold">{{optional($model->customerRel)->aadhar}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-4">
                                                    <div class="col-2 pt-1">
                                                        <i class="flaticon2-website h4 text-success"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="text-dark">
                                                            <small>Pancard Number :</small>
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            <span class="kt-font-dark kt-font-bold">{{optional($model->customerRel)->pan}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mt-3">
                                                <div class="row">
                                                    <div class="col-2 pt-1">
                                                        <i class="flaticon2-pin h4 text-primary"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="text-dark">
                                                            <small>Address :</small>
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            <p class="kt-font-dark kt-font-bold">
                                                                {{optional($model->customerRel)->address}} {{optional(optional($model->customerRel)->stateRel)->title}} {{optional(optional($model->customerRel)->cityRel)->title}} {{optional($model->customerRel)->postcode}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- vendors detaills -->
                    <div class="card">
                        <div class="card-header" id="headingTwo7">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo7" aria-expanded="false" aria-controls="collapseTwo5">
                                <i class="flaticon-user"></i>VENDOR DETAILS
                            </div>
                        </div>
                        <div id="collapseTwo7" class="collapse" aria-labelledby="headingTwo7" data-parent="#accordionExample5" style="">
                            @if(!$model->vendorRel)
                                <p class="kt-font-dark kt-font-bold">No Information available</p>
                            @else
                                <div class="card-body">
                                    <a href="{{ route('admin.vendors.show', optional($model->vendorRel)->id) }}" class="kt-notification__item">
                                        <div class="kt-notification__item-details">
                                            <div class="row">
                                                <div class="col-12 col-md-4 mt-3 text-center">
                                                    <div>
                                                        <img class="rounded-circle" src="{{ getImageUrl(optional($model->vendorRel)->image) }}" alt="customer" width="70" height="70">
                                                    </div>
                                                    <p class="kt-font-primary kt-font-bold h4 pt-3 mb-0">{{optional($model->vendorRel)->name}}</p>
                                                    <p class="kt-font-dark kt-font-bold h6 ">{{optional($model->vendorRel)->email}}</p>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3">
                                                    <div class="row">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-phone h4 text-info"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Phone Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{optional($model->vendorRel)->mobile_no}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-primary"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>GSTIN</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{optional($model->vendorRel)->gstin}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-warning"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Aadhar Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{optional($model->vendorRel)->aadhar}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-success"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Pancard Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{optional($model->vendorRel)->pan}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3">
                                                    <div class="row">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-pin h4 text-primary"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Address :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <p class="kt-font-dark kt-font-bold">{{optional($model->vendorRel)->address}} {{optional(optional($model->vendorRel)->stateRel)->title}} {{optional(optional($model->vendorRel)->cityRel)->title}} {{optional($model->vendorRel)->postcode}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Driver detaills -->
                    @if($model->status >= \App\Booking::ASSIGN_DRIVER_VEHICLE )
                    <div class="card">
                        <div class="card-header" id="headingTwo7">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo8" aria-expanded="false" aria-controls="collapseTwo8">
                                <i class="flaticon-user"></i>Driver DETAILS
                            </div>
                        </div>
                        <div id="collapseTwo8" class="collapse" aria-labelledby="headingTwo7" data-parent="#accordionExample5" style="">
                            <?php $collection = $model->vehicleDriverRel; ?>
                            @if(count($collection))
                            @foreach($collection as $driverModel)
                                <?php $driverModel = $driverModel->driverRel ?>
                                <div class="card-body">
                                    <a href="{{ route('admin.drivers.show', [ 'vendor_id' => $driverModel->vendor_id, 'driver_id' => $driverModel->id ]) }}" class="kt-notification__item">
                                        <div class="kt-notification__item-details">
                                            <div class="row">
                                                <div class="col-12 col-md-4 mt-3 text-center">
                                                    <div>
                                                        <img class="rounded-circle" src="{{ getImageUrl($driverModel->image) }}" alt="customer" width="70" height="70">
                                                    </div>
                                                    <p class="kt-font-primary kt-font-bold h4 pt-3 mb-0">{{$driverModel->name}}</p>
                                                    <p class="kt-font-dark kt-font-bold h6 ">{{$driverModel->email}}</p>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3">
                                                    <div class="row">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-phone h4 text-info"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Phone Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{$driverModel->mobile_no}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-primary"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>GSTIN</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">
                                                                    {{$driverModel->gstin}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-warning"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Aadhar Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">
                                                                    {{$driverModel->aadhar}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-success"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Pancard Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{$driverModel->pan}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3">
                                                    <div class="row">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-pin h4 text-primary"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Address :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <p class="kt-font-dark kt-font-bold">{{ $driverModel->address}} {{ optional($driverModel->stateRel)->title}} {{ optional($driverModel->cityRel)->title}} {{ $driverModel->postcode}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            @else
                                <p class="kt-font-dark kt-font-bold">No Information available</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Vehicle detaills -->
                    @if($model->status >= \App\Booking::ASSIGN_DRIVER_VEHICLE )
                    <div class="card">
                        <div class="card-header" id="headingTwo7">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo12" aria-expanded="false" aria-controls="collapseTwo12">
                                <i class="flaticon-truck"></i>Vehicle Details
                            </div>
                        </div>
                        <div id="collapseTwo12" class="collapse" aria-labelledby="headingTwo7" data-parent="#accordionExample5" style="">
                            <?php //$collection = $model->vehicleDriverRel; ?>
                            @if(count($collection))
                            @foreach($collection as $vehicleModel)
                                <?php $vehicleModel = $vehicleModel->vehicleRel ?>
                                <div class="card-body">
                                    <a href="{{ route('admin.vehicles.show', [ 'vendor_id' => $vehicleModel->user_id, 'vehicle_id' => $vehicleModel->id ]) }}" class="kt-notification__item">
                                        <div class="kt-notification__item-details">
                                            <div class="row">
                                                <div class="col-12 col-md-4 mt-3 text-center">
                                                    <div>
                                                        <img class="rounded-circle" src="{{ getImageUrl($vehicleModel->image) }}" alt="customer" width="70" height="70">
                                                    </div>
                                                    <p class="kt-font-primary kt-font-bold h4 pt-3 mb-0">{{$vehicleModel->vehicle_name}}</p>
                                                    <p class="kt-font-dark kt-font-bold h6 ">{{$vehicleModel->email}}</p>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3">
                                                    <div class="row">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-phone h4 text-info"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Phone Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{$vehicleModel->mobile_no}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-primary"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>GSTIN</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">
                                                                    {{$vehicleModel->gstin}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-warning"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Vehicle Number :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">
                                                                    {{$vehicleModel->vehicle_num}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mt-4">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-website h4 text-success"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Vehicle Type :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <span class="kt-font-dark kt-font-bold">{{optional($vehicleModel->vehicleTypeRel)->title}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3">
                                                    <div class="row">
                                                        <div class="col-2 pt-1">
                                                            <i class="flaticon2-pin h4 text-primary"></i>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="text-dark">
                                                                <small>Address :</small>
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                <p class="kt-font-dark kt-font-bold">{{ $vehicleModel->address}} {{ optional($vehicleModel->stateRel)->title}} {{ optional($vehicleModel->cityRel)->title}} {{ $vehicleModel->postcode}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            @else
                                <p class="kt-font-dark kt-font-bold">No Information available</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header" id="headingTwo5">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo15" aria-expanded="false" aria-controls="collapseTwo15">
                                <i class="flaticon-truck"></i>CONSENT
                            </div>
                        </div>
                        <div id="collapseTwo15" class="collapse" aria-labelledby="headingTwo5" data-parent="#accordionExample5" style="">
                            <div class="card-body">
                                <a href="#" class="kt-notification__item">
                                    <div class="kt-notification__item-details">
                                        <div class="row">
                                            <span>
                                                <i class="flaticon2-calendar h2 ml-5 text-warning"></i>
                                            </span>
                                            <span class="ml-4">
                                                <div class="text-dark">
                                                    <small>I/We confirm having received the good booked against order number {{ $model->order_no }} in order and good condition.</small>
                                                </div>
                                                @if(!$model->signature)
                                                    <div class="kt-notification__item-time">
                                                        <span class="kt-font-dark kt-font-bold">
                                                            NA
                                                        </span>
                                                    </div>
                                                @else 
                                                    <div class="kt-notification__item-time">
                                                        <span class="kt-font-dark kt-font-bold">
                                                            <img src="data:image/png;base64, {{ $model->signature }}" alt="Signature" width="100"><br>
                                                            Verified through OTP
                                                        </span>
                                                    </div>
                                                @endif
                                            </span>
                                        </div>
                                        
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Accordion-->
            </div>
        </div>
    </div>
</div>

@stop

@section('style')
    <style>
        .m-portlet.m-portlet--head-sm .m-portlet__head {
            height: 6.1rem;

        }
        .m-portlet:hover{
            box-shadow: 0px 3px 20px 0px #bdc3d4;
        }
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.booking-menu').addClass('kt-menu__item--open');
            
        });

        $.fn.stars = function() {
            return $(this).each(function() {
                var rating = $(this).data("rating");
                var numStars = $(this).data("numStars");
                var fullStar = new Array(Math.floor(rating + 1)).join('<i class="fa fa-star"></i>');
                var halfStar = ((rating%1) !== 0) ? '<i class="fa fa-star-half-alt"></i>': '';
                var noStar = new Array(Math.floor(numStars + 1 - rating)).join('<i class="far fa-star"></i>');
                $(this).html(fullStar + halfStar + noStar);
            });
        }

        $('.stars').stars();
    </script>
@stop