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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Customer </a>
        </div>
    </div>
@stop

@section('content')

    <div class="card shadow px-sm-5 py-4">
        <div class="row px-3 text-center text-sm-left">
            <div class="col-sm-2 col-12">
                <img class="rounded-circle" src="{{ getImageUrl($model->image) }}" alt="" width="100" height="100">
            </div>
            <div class="col-sm-9 col-12">
                <h2 class="kt-font-dark">{{ $model->name }}</h2>
                <h6 class="kt-label-font-color-3 ">{{ $model->email }}</h6>
                <div class="mt-4">
                    @if($model->type == \App\User::INDIVIDUAL_CUSTOMER)
                        <a href="#" class="btn btn-sm btn-primary">Individual</a>
                    @else
                        <a href="#" class="btn btn-sm btn-primary">Commercial</a>
                    @endif
                    @if( !$model->status )
                        <span class="btn btn-sm btn-warning">Document Pending</span>
                    @elseif ( $model->status == 2 )
                        <span class="btn btn-sm btn-danger">Unverified</span>
                    @else
                        <span class="btn btn-sm btn-success">Verified</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="kt-portlet kt-portlet--tabs px-0 mt-4">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary nav-tabs-line-2x" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_portlet_base_demo_1_1_tab_content" role="tab" aria-selected="true">
                                <i class="la la-user"></i> Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_portlet_base_demo_1_2_tab_content" role="tab" aria-selected="false">
                                <i class="la la-dropbox"></i> Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_portlet_base_demo_1_3_tab_content" role="tab" aria-selected="false">
                                <i class="la la-file-text"></i>Documents
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_portlet_base_demo_1_1_tab_content" role="tabpanel">
                        <a href="#" class="kt-notification__item">
                            <div class="kt-notification__item-details">
                                <div class="row">
                                    <div class="col-12 col-sm-4 mt-4">
                                        <div class="row">
                                            <div class="col-2 pt-1">
                                                <i class="flaticon2-phone h4 text-info"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">
                                                    <small>Phone Number :</small>
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    <span class="kt-font-dark kt-font-bold">
                                                        {{ $model->mobile_no }}</span>
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
                                                    <span class="kt-font-dark kt-font-bold">{{ $model->gstin }}</span>
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
                                                    <span class="kt-font-dark kt-font-bold">{{ $model->aadhar}}</span>
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
                                                    <span class="kt-font-dark kt-font-bold">{{ $model->pan }}</span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mt-4">
                                            <div class="col-2 pt-1">
                                                <i class="flaticon2-website h4 text-danger"></i>
                                            </div>
                                            <div class="col-10  pl-4">
                                                <div class="text-dark">
                                                    <small>Referred By :</small>
                                                </div>
                                                <?php $userIdRef = 0;
                                                    $code = 'NA';
                                                    if($model->referralCodeRel->referred_by_id) {
                                                        $userIdRef = $model->referralCodeRel->referred_by_id;
                                                        $code = optional(optional(optional($model->referralCodeRel)->referredByRel)->referralCodeRel)->referral_code;
                                                    } 
                                                ?>
                                                @if($userIdRef)
                                                    <a href="{{ route('admin.customers.show', $userIdRef ) }}">
                                                @endif
                                                    <div class="kt-notification__item-time">
                                                        <span class="kt-font-dark kt-font-bold">{{ $code }}</span>
                                                    </div>
                                                @if($userIdRef)
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                       
                                    </div>
                                    <div class="col-12 col-sm-4 mt-4">
                                        <div class="row">
                                            <div class="col-2 pt-1">
                                                <i class="flaticon2-pin h4 text-primary"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">
                                                    <small>Address :</small>
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    <p class="kt-font-dark kt-font-bold">{{$model->address}} {{optional($model->stateRel)->title}}, {{optional($model->cityRel)->title}} {{ $model->postcode}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tab-pane table-responsive" id="kt_portlet_base_demo_1_2_tab_content" role="tabpanel">
                        <table class="table data-table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ord. ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Distance (KMS)</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!count($model->customerBookingRel))

                                @else 
                                    @foreach( $model->customerBookingRel as $bookingModel )
                                    <tr>
                                        <th scope="row">{{$bookingModel->id}}</th>
                                        <td>{{$bookingModel->order_no}}</td>
                                        <td>
                                            <p data-toggle="tooltip" title="{{$bookingModel->address}}" class="text-primary">
                                                {{ str_limit($bookingModel->address, 10)  }},{{$bookingModel->state}}
                                            </p>
                                        </td>
                                        <td>
                                            <p data-toggle="tooltip" title="{{$bookingModel->drop_location_address}}" class="text-primary">
                                                {{ str_limit($bookingModel->drop_location_address, 10)  }},{{$bookingModel->drop_location_state}}
                                            </p>
                                        </td>
                                        <td>{{$bookingModel->distance}}</td>
                                        <td>{{ date('d/m/Y', strtotime($bookingModel->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('admin.bookingDetail', $bookingModel->id) }}"
                                                class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">View Details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="kt_portlet_base_demo_1_3_tab_content" role="tabpanel">
                        <div class="kt-section__content">
                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th >Image</th>
                                        <th>Image Name</th>
                                        <th>Image Side</th>
                                        {{-- <th width="15%">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!count($model->documentsRel))

                                    @else 
                                        @foreach( $model->documentsRel as $docModel )
                                        <tr>
                                            <th scope="row">{{ $docModel->id }}</th>
                                            <td>
                                                <a href="{{ getImageUrl($docModel->image) }}" class="light-image">
                                                    <img src="{{ getImageUrl($docModel->image) }}" alt="{{ $docModel->name }}" width="40">
                                                </a>
                                            </td>
                                            <td>{{ $docModel->name }}</td>
                                            <td>{{ $docModel->site }}</td>
                                            
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </div>

        

@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.customer-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop