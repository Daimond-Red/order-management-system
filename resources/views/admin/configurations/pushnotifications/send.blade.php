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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Push Notification</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-envelope"></i> Send Push </div>
                <div class="card-body">
                    {{ Form::open( [  'route' => 'config.send', 'method' => 'POST', 'files' => true ]) }}

                        <div class="form-group">
                            <label for="push_mode">User</label>
                            {{ Form::select('user_type', [ 'customer' => 'Customer', 'vendor' => 'Vendor' ], null, [ 'id' => 'user_type', 'class' => 'form-control' ]) }}
                        </div>

                        <div class="form-group">
                            <label for="device_type">Device Type</label>
                            {{ Form::select('device_type', [ 'ios' => 'Ios', 'android' => 'Android' ], null, ['id' => 'device_type', 'class' => 'form-control']) }}
                        </div>

                        <div class="form-group">
                            <label for="device_token">Device token</label>
                            {{ Form::textarea('device_token', null, ['id' => 'device_token', 'class' => 'form-control', 'rows' => '2']) }}
                        </div>

                        <div class="form-group">
                            <label for="device_token">Title</label>
                            {{ Form::text('title', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="device_token">Description</label>
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) }}
                        </div>

                        <input type="submit" class="btn btn-primary btn-block" value="Send" />

                    </form>
                </div>
                <div class="card-footer small text-muted"></div>
            </div>
        </div>
        {{--<div class="col-md-6">--}}
            {{--<div class="card mb-3">--}}
                {{--<div class="card-header">--}}
                    {{--<i class="fa fa-envelope"></i> Send Push - SECOND USER</div>--}}
                {{--<div class="card-body">--}}
                    {{--{{ Form::open( [  'route' => 'config.send', 'method' => 'POST', 'files' => true ]) }}--}}

                        {{--<div class="form-group">--}}
                            {{--<label for="push_mode">Push Mode</label>--}}
                            {{--{{ Form::select('push_mode', [ 'production' => 'Production', 'sandbox' => 'Sandbox' ], null, [ 'id' => 'push_mode', 'class' => 'form-control' ]) }}--}}
                        {{--</div>--}}
                        {{--<input type="hidden" name="user_type" value="user1" />--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="device_type">Device Type</label>--}}
                            {{--{{ Form::select('device_type', [ 'ios' => 'Ios', 'android' => 'Android' ], null, ['id' => 'device_type', 'class' => 'form-control']) }}--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label for="device_token">Device token</label>--}}
                            {{--{{ Form::textarea('device_token', null, ['id' => 'device_token', 'class' => 'form-control', 'rows' => '2']) }}--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label for="device_token">Title</label>--}}
                            {{--{{ Form::text('title', null, ['class' => 'form-control']) }}--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="device_token">Description</label>--}}
                            {{--{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) }}--}}
                        {{--</div>--}}

                        {{--<input type="submit" class="btn btn-primary btn-block" value="Send" />--}}

                    {{--</form>--}}
                {{--</div>--}}
                {{--<div class="card-footer small text-muted"></div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('.config-menu').addClass('kt-menu__item--open');
            $('.send-push-menu').addClass('kt-menu__item--active');
        });
    </script>
@stop