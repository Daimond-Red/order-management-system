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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Chats </a>
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
                        Chat List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            
                        </div>
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
                                <th>Booking</th>
                                <th>Customer</th>
                                <th>Vendor</th>
                                <th> Created On </th>
                                <th width="12%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $collection as $model )
                                <tr>
                                    <th scope="row">{{ $model->id }}</th>
                                    <td>{{ optional($model->bookingRel)->order_no }}</td>
                                    <td>{{ optional($model->customerRel)->name }}</td>
                                    <td>{{ optional($model->vendorRel)->name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                    <td>
                                        {{-- <span>
                                            

                                            <a
                                                href="{{ route('admin.chats.delete', $model->id) }}"
                                                class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                title="Delete"
                                            >
                                                <i class="la la-trash"></i>
                                            </a>
                                        </span> --}}
                                        <a href="{{ route('admin.chats.show', $model->id) }}" class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">View Chat</a>
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
            // $('.master-menu').addClass('kt-menu__item--open');
            $('.chat-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop