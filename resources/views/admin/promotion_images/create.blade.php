{{ Form::open( [ 'class' => '', 'route' => ['admin.promotionImages.store'], 'method' => 'POST', 'files' => true ]) }}
    @include('admin.promotion_images.form')
{{ Form::close() }}