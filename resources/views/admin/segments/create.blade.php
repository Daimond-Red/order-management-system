{{ Form::open( [ 'class' => '', 'route' => 'admin.segments.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.segments.form')
{{ Form::close() }}