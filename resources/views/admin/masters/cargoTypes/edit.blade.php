{{ Form::model($model, ['route' => [ 'admin.cargoTypes.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.masters.cargoTypes.form')
{{ Form::close() }}