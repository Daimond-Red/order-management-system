{{ Form::open( [ 'class' => '', 'route' => ['admin.documents.store'], 'method' => 'POST', 'files' => true ]) }}
    @include('admin.documents.form')
{{ Form::close() }}