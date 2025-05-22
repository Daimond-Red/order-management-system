{{ Form::model($model, ['route' => [ 'admin.brands.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.brands.form')
{{ Form::close() }}