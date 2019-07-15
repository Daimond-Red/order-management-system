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

            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Add New</a>
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
                        Add New
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <!-- <div class="kt-portlet__head-wrapper">
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
                    </div> -->
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    
                    <div class="kt-section__content">

                        <div class="row">
                            <div style="border-right:1px solid lightgrey;" class="col-4 px-4">
                                {{ Form::open( [ 'class' => '', 'route' => 'admin.appNotifications.store', 'method' => 'POST', 'files' => true ]) }}
                                    @include('admin.appNotifications.form')
                                    {!! Form::hidden('users', null, ['class' => 'users']) !!}
                                    <div class=" m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            <div class="col-8 px-4">
                                {{ Form::hidden('allUserIds', implode(',', $allUserIds)) }}
                                <table class="data-table table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" data-group=".user_list" class="select-all-users" name="select-all" value="" />
                                        </th>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> User Type </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!count($collection))

                                        @else 
                                            @foreach( $collection as $model )
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="user_list" name="user_list[]" value="{{$model->id}}">
                                                </td>
                                            
                                                <td> {{ $model->name }} </td>
                                                <td> {{ $model->email }} </td>
                                                <td>
                                                    @if( $model->type == \App\User::INDIVIDUAL_CUSTOMER )
                                                        <p>Customer</p>
                                                    @elseif( $model->type == \App\User::VENDOR )
                                                        <p>Vendor</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{-- {{ $collection->appends(array_merge(request()->all(), ['isAjax' => 1]))->links() }} --}}
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	

@stop

@section('style')
    <style>
        table tr td{
			padding:0.3rem 0.75rem !important;
			vertical-align:middle !important;
			font-size:13px;
		}
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            
            $('.notification-menu').addClass('kt-menu__item--open');

            Cookies.set('user_list', []);

            $('body').on('change', '.user_list', function (e) {

                var arr = Cookies.get('user_list');
                arr = JSON.parse(arr);
                if(  typeof arr == 'undefined') arr = [];

                if( $(this).is(':checked') ) {
                    arr.push($(this).val());
                } else {
                    var itemtoRemove = $(this).val();
                    arr.splice($.inArray(itemtoRemove, arr),1);
                }
                console.log(arr);
                Cookies.set('user_list', arr);
                $('.users').val(arr.join(','));
            });

            function clearUsers() {
                Cookies.set('user_list', []);
                $('.users').val('');
            }

            function setUsers() {
                var arr = $('input[name="allUserIds').val();
                arr = arr.split(',');
                Cookies.set('user_list', arr);
                $('.users').val(arr.join(','));
            }

            // select all checkbox
            $('body').on('click', '.select-all-users', function (e) {

                var group = $(this).attr('data-group');
                // console.log(group)
                if ( $(this).is(':checked') ) {
                    $(group).prop('checked', true);
                    setUsers();
                } else {
                    $(group).prop('checked', false);
                    clearUsers();
                }



                //$(group).change();
            });

        });
    </script>
@stop