<div class="row">
    <div class="col-md-12">

        {!!  HTML::vtext('name', null, ['label' => 'Name', 'data-validation' => 'required']) !!}
    </div>
    {{-- <div class="col-md-12">
        @if( isset($model) && $model->cover )
            {!!  HTML::vimage('cover', ['value' => $model->cover, 'accept' => 'image/*']) !!}
        @else
            {!! HTML::vimage('cover', ['accept' => 'image/*']) !!}
        @endif
    </div> --}}
</div>
