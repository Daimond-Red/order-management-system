{!! Form::model($model, ['route' => [ 'admin.documents.update',  $model->id ], 'method' => 'put', 'files' => true ] ) !!}
@include('admin.documents.form')
{!!  Form::close() !!}