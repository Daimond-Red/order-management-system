@extends('layouts.master')

@section('pageBar')
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title"> Dashboard </h3>
        <span class="kt-subheader__separator kt-hidden"></span>
        <div class="kt-subheader__breadcrumbs">
            <a href="{{ route('dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('dashboard') }}" class="kt-subheader__breadcrumbs-link"> Dashboard </a>

            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Test </a>
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
    <div class="col-xl-6">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Test List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            <button href="#" class="btn btn-brand btn-elevate btn-icon-sm dataModel"
                                data-href="{{ route('admin.tests.create') }}"
                                data-title="Add new"
                            >
                                <i class="la la-plus"></i>
                                New Record
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!count($collection))

                                @else 
                                    @foreach( $collection as $model )
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Jhon</td>
                                        <td>Stone</td>
                                        <td>@jhon</td>
                                        <td>
                                            <span class="row">
                                                <button
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                                   title="Edit details"
                                                   data-href="{{ route('admin.tests.edit', $model->id) }}"
                                                   data-title="Edit"
                                                >
                                                    <i class="la la-edit"></i>
                                                </button>

                                                <a
                                                    href="{{ route('admin.tests.delete', $model->id) }}"
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

@section('script')
    <script>
        $(document).ready(function(){
            $('.vendor-menu').addClass('m-menu__item--active');
        });
    </script>
@stop