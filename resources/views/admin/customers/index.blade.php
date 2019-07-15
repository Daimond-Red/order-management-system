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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Customers </a>
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
                        Customer List
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
                                Add New
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content table-responsive">
    
                        <table class="data-table table table-bordered table-sm">
                            <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Account Status</th>
                                <th>Customer Type</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $collection as $model )
                                <tr>
                                    <th scope="row">{{ $model->id }}</th>
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
                                    <td>
                                        <span class="action">
                                            <button
                                               class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                               title="Edit details"
                                               data-href="{{ route('admin.customers.edit', $model->id) }}"
                                               data-title="Edit"
                                            >
                                                <i class="la la-edit"></i>
                                            </button>
                                            <a
                                               class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill "
                                               title="View Uploaded Documents" href="{{ route('admin.documents.index', $model->id) }}"
                                               
                                            >
                                                <i class="flaticon-upload"></i>
                                            </a>

                                            <a
                                                href="{{ route('admin.customers.show', $model->id) }}"
                                                class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                title="View Details"
                                            >
                                                <i class="la la-user-plus"></i>
                                            </a>


                                            <a
                                                href="{{ route('admin.customers.delete', $model->id) }}"
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

                        {{-- {{ $collection->appends(request()->all())->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        
@stop

@section('style')
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <style>
        .m-portlet.m-portlet--head-sm .m-portlet__head {
            height: 6.1rem;

        }
        .m-portlet:hover{
            box-shadow: 0px 3px 20px 0px #bdc3d4;
        }
        .action .btn, .action a{
            padding:5px;
        }
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.customer-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop