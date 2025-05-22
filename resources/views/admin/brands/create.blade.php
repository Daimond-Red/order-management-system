{{ Form::open( [ 'class' => '', 'route' => 'admin.brands.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.brands.form')
{{ Form::close() }}