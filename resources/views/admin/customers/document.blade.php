@extends('layouts.master')

@section('pageBar')
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title"> Dashboard </h3>
        <span class="kt-subheader__separator kt-hidden"></span>
        <div class="kt-subheader__breadcrumbs">
            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('admin.customers.index') }}" class="kt-subheader__breadcrumbs-link"> Customers </a>

            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link"> Documents </a>
        </div>
    </div>
    
@stop
@section('style')

@stop
@section('content')
<div class="row">
    <div class="col-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ $userModel->name }}'s Document List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            
                            &nbsp;
                            <button href="#" class="btn btn-brand btn-elevate btn-icon-sm dataModel"
                                data-href="{{ route('admin.documents.create', \request('userId')) }}"
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
                    
                    <div class="kt-section__content table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th >Image</th>
                                    <th>Image Name</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!count($collection))

                                @else 
                                    @foreach( $collection as $model )
                                    <tr>
                                        <th scope="row">{{ $model->id }}</th>
                                        <td>
                                            <a href="{{ getImageUrl($model->image) }}" class="light-image">
                                                <img src="{{ getImageUrl($model->image) }}" alt="{{ $model->name }}" width="40">
                                            </a>
                                        </td>
                                        <td>{{ $model->name }}</td>
                                        
                                        <td>
                                            <span class="row">
                                                <button
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                                   title="Edit details"
                                                   data-href="{{ route('admin.documents.edit', $model->id) }}"
                                                   data-title="Edit"
                                                >
                                                    <i class="la la-edit"></i>
                                                </button>

                                                <a
                                                    href="{{ route('admin.documents.delete', $model->id) }}"
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
            $('.customer-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop