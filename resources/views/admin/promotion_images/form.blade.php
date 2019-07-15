<div class="row">
    <div class="col-md-6">
        {!! HTML::vtext('title', null, ['data-validation' => 'required']) !!}
    </div>
    <div class="col-md-6">
        @if( isset($model) && $model->image )
            {!!  HTML::vimage('image', ['value' => $model->image, 'accept' => 'image/jpeg , image/jpg, image/png']) !!}
        @else
            {!! HTML::vimage('image', ['accept' => 'image/jpeg , image/jpg, image/png']) !!}
        @endif
    </div>
</div>



            

    