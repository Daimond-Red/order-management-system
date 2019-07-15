{{ Form::model($model, ['route' => [ 'admin.vehicleTypes.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.masters.vehicleTypes.form')
{{ Form::close() }}