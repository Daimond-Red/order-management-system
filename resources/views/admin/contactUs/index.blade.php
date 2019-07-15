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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Queries </a>
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
                        Queries List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <!-- <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            <button href="#" class="btn btn-brand btn-elevate btn-icon-sm dataModel"
                                data-href="{{ route('admin.pages.create') }}"
                                data-title="Add new"
                            >
                                <i class="la la-plus"></i>
                                Add New
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead class="thead-default">
                                <tr>
                                    <th>#</th>
                                    <th width="10%">Title</th>
                                    <th width="30%">Message</th>

                                    <th>Phone Number</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $collection as $model )
                                <tr>
                                    <th scope="row">{{ $model->id }}</th>
                                    <td>{{ $model->title }}</td>
                                    <td>
                                        <a href="javascript:void(0);" data-toggle="tooltip" title="{{ $model->message }}">{{ substr($model->message, 0, 40)  }} {{ strlen($model->message) > 40 ? ' ...' :'' }}</a>
                                    </td>
                                    <td>{{ $model->alternate_no }}</td>
                                    <td>
                                        @if($model->status == \App\ContactUs::PENDING_RESOLUTION)
                                            <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Pending Resolution</span>
                                        @elseif($model->status == \App\ContactUs::CUSTOMER_ACTION_PENDING)
                                            <span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Customer Action Pending</span>
                                        @elseif($model->status == \App\ContactUs::PENDING_ADMIN_REPLY)
                                            <span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Pending Admin Reply</span>
                                        @elseif($model->status == \App\ContactUs::ISSUE_RESOLVED)
                                            <span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Resolved</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                    <td>
                                        <span>
                                            {{-- <button
                                               class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                               title="Edit details"
                                               data-href="{{ route('admin.pages.edit', $model->id) }}"
                                               data-title="Edit"
                                            >
                                                <i class="la la-edit"></i>
                                            </button> --}}
                                            <a
                                                href="{{ route('admin.customerChats.index', $model->id) }}"
                                                class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                title="Reply"
                                            >
                                                <i class="fa flaticon-reply"></i>
                                            </a>
                                            <a
                                                href="{{ route('admin.contactUs.delete', $model->id) }}"
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
    <style>
       
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.query-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop