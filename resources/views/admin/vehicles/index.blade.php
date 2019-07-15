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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Vehicle </a>
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
                        Vehicle List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            <button href="#" class="btn btn-brand btn-elevate btn-icon-sm dataModel"
                                data-href="{{ route('admin.vehicles.create', $vendor->id) }}"
                                data-title="Add new"
                            >
                                <i class="la la-plus"></i>
                                Add New 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content">
                        <table class="data-table table table-bordered table-sm table-responsive">
                            <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Vehicle Name</th>
                                <th>vehicles Type</th>
                                <th>Owner Name</th>
                                <th>Owner Mobile No.</th>
                                <th>Expire Date</th>
                                <th>Insurance Validity</th>
                                <th>Is Verified</th>
                                <th>Created On</th>
                                <th width="18%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $collection as $model )
                                <tr>
                                    <th scope="row"> {{ $model->id }} </th>
                                    <th> {{ $model->vehicle_name }} </th>
                                    <td>
                                        <a href="javascript:void(0);" data-toggle="tooltip" title="{{ optional($model->vehicleTypeRel)->title }}">{{ substr(optional($model->vehicleTypeRel)->title, 0, 20)  }} {{ strlen(optional($model->vehicleTypeRel)->title) > 20 ? ' ...' :'' }}</a> 
                                    </td>
                                    <td> {{ $model->name }} </td>
                                    <td> {{ $model->mobile_no }} </td>
                                    <td> {{ getDateValue($model->expire_date) }} </td>
                                    
                                    <td> {{ getDateValue($model->insurance_validity) }} </td>
                                    <td>
                                        @if ( !$model->is_verified)
                                            <span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Unverified</span>
                                        @elseif($model->is_verified == 1)
                                            <span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Verified</span>
                                        @elseif($model->is_verified == 2)
                                            <span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Self Verified</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                    <td>
                                        <span class="row">
                                            <button
                                               class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                               title="Edit details"
                                               data-href="{{ route('admin.vehicles.edit', [ 'vendor_id' => $vendor->id, 'vehicle_id' => $model->id ]) }}"
                                               data-title="Edit"
                                            >
                                                <i class="la la-edit"></i>
                                            </button>
                                            <a
                                                href="{{ route('admin.vehicles.show', [ 'vendor_id' => $vendor->id, 'vehicle_id' => $model->id ]) }}"
                                                class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                title="View Details"
                                            >
                                                <i class="la la-user-plus"></i>
                                            </a>
                                            <a
                                                href="{{ route('admin.vehicles.delete', [ 'vendor_id' => $vendor->id, 'vehicle_id' => $model->id ]) }}"
                                                class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                title="Delete"
                                            >
                                                <i class="la la-trash"></i>
                                            </a>
                                        </span>
                                    </td>
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
            $('.vendor-menu').addClass('kt-menu__item--active');

            $('body').on('change', '#state', function(){

                var val = $(this).val();
                setCities(val);
                
            });

        });
    </script>
@stop