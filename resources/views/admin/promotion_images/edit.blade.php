{!! Form::model($model, ['route' => [ 'admin.promotionImages.update',  $model->id ], 'method' => 'put', 'files' => true ] ) !!}
@include('admin.promotion_images.form')
{!!  Form::close() !!}