{{ Form::model($model, ['route' => [ 'admin.segments.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.segments.form')
{{ Form::close() }}