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
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link">App Translation</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row app-translation">
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header"> New Entry </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'config.translationStore', 'method' => 'post', 'id' => 'addNew']) !!}
                        {!! HTML::vtext('title', null, ['label' => 'Title']) !!}
                        {!! HTML::vtextarea('value', null, ['data-validation' => 'required']) !!}
                        {{-- {!! HTML::vtextarea('comment') !!} --}}
                        {!! Form::submit('Save', ['class' => 'btn btn-primary btn-block']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="card-footer small text-muted"></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-3">
                <div class="card-header"> List </div>
                <div class="card-body">
                    @if( $collection->isEmpty() )
                        <p>No Records Found</p>
                    @endif
                    @foreach( $collection as $model )
                        {!! Form::model($model, ['route' => ['config.translationUpdate', $model->id], 'method' => 'post', 'class' => 'update-form']) !!}

                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::text('title', null, ['placeholder' => 'Title', 'disabled', 'class' => 'form-control-sm form-control']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::text('tag', null, ['placeholder' => 'Tag', 'disabled', 'class' => 'form-control-sm form-control']) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::textarea('value', null, ['class' => 'form-control form-control-sm', 'rows' => 3]) !!}
                                </div>
                                {{-- <div class="col-md-4">
                                    {!! Form::textarea('comment', null, ['class' => 'form-control form-control-sm', 'rows' => 3]) !!}
                                </div> --}}
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-sm btn-primary mb-1">
                                        <i class="fa fa-save"></i>
                                    </button>
                                    <a type="button" class="btn btn-danger btn-sm remove-item confirmModel" href="{{ route('config.translationRemove', $model->id) }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>


                        {!! Form::close() !!}
                        <hr>
                    @endforeach

                </div>
                <div class="card-footer small text-muted"></div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('.config-menu').addClass('kt-menu__item--open');
            $('.trans-menu').addClass('kt-menu__item--active');
            // $('.trans-menu').addClass('active');

            function refreshContent() {
                $.get('{{ route('config.translation') }}', function(data){
                    var $response=$(data);
                    //query the jq object for the values
                    var dataToday = $response.find('.app-translation').html();
                    $('.app-translation').html(dataToday);

                    removePageLoader();
                });
            }

            $('body').on('submit', '#addNew', function(e){

                showPageLoader();
                e.preventDefault();
                $.post($(this).attr('action'), $(this).serialize(), function(res){
                    refreshContent();
                });

            });

            $('body').on('submit', '.update-form', function(e){

                showPageLoader();
                e.preventDefault();
                $.post($(this).attr('action'), $(this).serialize(), function(res){
                    refreshContent();
                });

            });



            $('body').on('click', '.remove-item', function(e){

                var url = $(this).attr('data-url');

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },function(result) {
                    if(result) {
                        swal.close();
                        showPageLoader();
                        $.get(url, $(this).serialize(), function(res){
                            refreshContent();
                        });
                    }
                });
            });

        });
    </script>
@stop