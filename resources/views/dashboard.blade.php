@extends('layouts.master')

@section('pageBar')
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title"> Dashboard </h3>
        <span class="kt-subheader__separator kt-hidden"></span>
        <div class="kt-subheader__breadcrumbs">
            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link"> Dashboard </a>

        </div>
    </div>
@stop

@section('content')
    <div class="row custom-dashboard">
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.customers.index') }}">
                <div class="card p-3 bg-primary text-white">
                    <h1 class="text-light">{{ $customerCount }}</h1>
                    <h5>Customers</h5>
                    <i class="flaticon-users-1 text-right h1"></i>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.vendors.index') }}">
                <div class="card p-3 bg-success text-white">
                    <h1 class="text-dark">{{ $vendorCount }}</h1>
                    <h5>Vendors</h5>
                    <i class="flaticon-users-1 text-right h1"></i>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.drivers.driverList') }}">
                <div class="card p-3 bg-info text-white">
                    <h1 class="text-light">{{ $driverCount }}</h1>
                    <h5>Drivers</h5>
                    <i class="flaticon-users-1 text-right h1"></i>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.bookings.pendingBooking') }}">
                <div class="card p-3 bg-dark text-white">
                    <h1 class="text-warning">{{ $bookingCount }}</h1>
                    <h5>Pending Bookings</h5>
                    <i class="flaticon-layers text-right h1"></i>
                </div>
            </a>
        </div>
    </div>


<div class="row mt-5">
    <div class="col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Recent Pending Bookings
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <!-- <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            <button href="#" class="btn btn-brand btn-elevate btn-icon-sm dataModel"
                                data-href="{{ route('admin.tests.create') }}"
                                data-title="Add new"
                            >
                                <i class="flaticon-search"></i>
                               Find Loads
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ord. ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Distance ( Km )</th>
                                    <th>Logistic Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    {{-- <td>Action</td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(!count($bookingCollection))
                                    <tr>
                                        <td colspan="15" align="center">No Record found.</td>
                                    </tr>
                                @else 
                                    @foreach( $bookingCollection as $model )
                                    <tr>
                                        <th scope="row">{{ $model->id }}</th>
                                        <td>{{ $model->order_no }}</td>
                                        <td>{{ optional($model->cityRel)->title }}</td>
                                        <td>{{ optional($model->dropLocationCityRel)->title }}</td>
                                        <td>{{ $model->distance }}</td>
                                        <td>
                                            @if($model->logistic_type == \App\Booking::INTER_CITY)
                                                <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Inter City</span>
                                            @else
                                                <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Intra City</span>
                                            @endif
                                        </td>
                                        <td><span class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">Pending</span></td>
                                        <td>{{ getDateValue($model->start_date_time) }}</td>
                                        
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
<!-- Recent ongoing bookings -->
<div class="row">
    <div class="col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Recent Live Bookings
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ord. ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Distance ( Km )</th>
                                    <th>Logistic Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    {{-- <td>Action</td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(!count($ongoingBookings))
                                    <tr>
                                        <td colspan="15" align="center">No Record found.</td>
                                    </tr>
                                @else 
                                    @foreach( $ongoingBookings as $model )
                                    <tr>
                                        <th scope="row">{{ $model->id }}</th>
                                        <td>{{ $model->order_no }}</td>
                                        <td>{{ optional($model->cityRel)->title }}</td>
                                        <td>{{ optional($model->cityRel)->title }}</td>
                                        <td>{{ $model->distance }}</td>
                                        <td>
                                            @if($model->logistic_type == \App\Booking::INTER_CITY)
                                                <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Inter City</span>
                                            @else
                                                <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Intra City</span>
                                            @endif
                                        </td>
                                        <td><span class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">Pending</span></td>
                                        <td>{{ getDateValue($model->start_date_time) }}</td>
                                        
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
    <!-- customer table -->
<div class="row">
    <div class="col-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Recent Customer List
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
                <div class="kt-section">
                    
                    <div class="kt-section__content table-responsive">
    
                        <table class="table table-bordered">
                            <thead class="thead-default">
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Account Status</th>
                                <th>Customer Type</th>
                                <th>Created On</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(!count($customerCollection))
                                <tr>
                                    <td colspan="15" align="center">No Record found.</td>
                                </tr>
                            @else 
                                @foreach( $customerCollection as $model )
                                    <tr>
                                        {{-- <th scope="row">{{ $model->id }}</th> --}}
                                        <td class="customer-info">{{ $model->name }}</td>
                                        <td>{{ $model->email }}</td>
                                        <td>{{ $model->mobile_no }}</td>
                                        <td>
                                            @if( !$model->status )
                                                <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Document Pending</span>
                                            @elseif ( $model->status == 2 )
                                                <span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Unverified</span>
                                            @else
                                                <span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Verified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($model->type == \App\User::INDIVIDUAL_CUSTOMER )
                                                <span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Individual</span>
                                            @else
                                                <span class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">Commercial</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                        
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


<!-- vendors table -->
<div class="row">
    <div class="col-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Recent Vendor List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            <!-- <button href="#" class="btn btn-brand btn-elevate btn-icon-sm dataModel"
                                data-href="{{ route('admin.vendors.create') }}"
                                data-title="Add new"
                            >
                                <i class="la la-plus"></i>
                                Add New 
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-default">
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Account Status</th>
                                <th>Customer Type</th>
                                <th>Created On</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(!count($vendorCollection))
                            <tr>
                                <td colspan="15" align="center">No Record found.</td>
                            </tr>
                            @else 
                                @foreach( $vendorCollection as $model )
                                    <tr>
                                        {{-- <th scope="row">{{ $model->id }}</th> --}}
                                        <td class="customer-info">{{ $model->name }}</td>
                                        <td>{{ $model->email }}</td>
                                        <td>{{ $model->mobile_no }}</td>
                                        <td>
                                            @if( !$model->status )
                                                <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Document Pending</span>
                                            @elseif ( $model->status == 2 )
                                                <span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Unverified</span>
                                            @else
                                                <span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Verified</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Vendor</span>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                        
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

<!-- confirmed bookings table -->



@stop

@section('style')
<style>
    .custom-dashboard .card{
        overflow:hidden;
        margin-top:10px;
        transition:all 0.5s;
    }
    .custom-dashboard .card:hover{
        transform:scale(1.05,1.05);
    }
    .custom-dashboard i{
        position: absolute;
        right: 0;
        bottom:-18px;
        opacity: 0.1;
        font-size: 73px;
    }
</style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.dashboard-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop