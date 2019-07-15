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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Confirmed Bookings </a>
        </div>
    </div>
    {{-- <div class="kt-subheader__toolbar">
        <div class="kt-subheader__wrapper">
            <button href="#" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10 dataModel"
                data-href="{{ route('admin.tests.create') }}"
                data-title="Add new"
            >
                Add New
            </button>
        </div>
    </div> --}}
    
@stop
@section('style')

@stop
@section('content')
<div class="row">
    <div class="col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Confirmed Bookings
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
                        <table class="data-table table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ord. ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Distance (KMS)</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!count($collection))

                                @else 
                                    @foreach( $collection as $model )
                                    <tr>
                                        <th scope="row">{{$model->id}}</th>
                                        <td>{{$model->order_no}}</td>
                                        <td>{{ optional($model->cityRel)->title }}</td>
                                        <td>{{ optional($model->dropLocationCityRel)->title }}</td>
                                        <td>{{$model->distance}}</td>
                                        <td>
                                            <span class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">{{ getBookingStatus($model->status) }}</span>
                                            </td>
                                        <td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                        <td>
                                           
                                            <a href="{{ route('admin.bookingDetail', $model->id) }}"
                                                class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">View Details</a>
                                        </td>
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
            $('.booking-menu').addClass('kt-menu__item--open');
            $('.booking-confirm-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop