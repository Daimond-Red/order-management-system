{{ Form::open( [ 'class' => '', 'route' => 'admin.vehicleTypes.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.masters.vehicleTypes.form')
{{ Form::close() }}