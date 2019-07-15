{{ Form::open( [ 'class' => '', 'route' => ['admin.tests.store'], 'method' => 'POST', 'files' => true ]) }}
    @include('admin.tests.form')
{{ Form::close() }}