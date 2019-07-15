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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Notifications</a>
        </div>
    </div>
@stop



@section('content')

<div class="row">
    <div class="col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Notifications
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            <a class="btn btn-brand btn-elevate btn-icon-sm"
                            href="{{ route('admin.appNotifications.create') }}"
                                data-title="Add new"
                            >
                                <i class="flaticon-plus"></i>
                               Add New
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content">
                        <table class="data-table table table-bordered">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Created On</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!count($collection))

                                @else 
                                    @foreach( $collection as $model )
                                    <tr>
                                        <th scope="row">{{ $model->id }}</th>
                                        <td>{{ $model->title }}</td>
                                        <td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                        <td>
                                            <span class="row">
                                                <button
                                                class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                                title="Edit details"
                                                data-href="{{ route('admin.appNotifications.edit', $model->id) }}"
                                                data-title="Edit"
                                                >
                                                    <i class="la la-edit"></i>
                                                </button>

                                                <a
                                                    href="{{ route('admin.appNotifications.delete', $model->id) }}"
                                                    class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                    title="Delete"
                                                >
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
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

@section('style')
    <style>
        /*.m-portlet.m-portlet--head-sm .m-portlet__head {*/
            /*height: 6.1rem;*/

        /*}*/
        .m-portlet:hover{
            box-shadow: 0px 3px 20px 0px #bdc3d4;
        }
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.notification-menu').addClass('kt-menu__item--open');
        });
    </script>
@stop