{{ Form::open( [ 'class' => '', 'route' => 'admin.cargoTypes.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.masters.cargoTypes.form')
{{ Form::close() }}