
<div class="row">
    <div class="col-md-6">
        
        {!! HTML::vselect('name', \App\Document::IMAGE_NAME,  null, ['label' => 'File Name', 'data-validation' => '
        required' ]) !!}
    </div>
    <div class="col-md-6">
    	@if( isset($model) && $model->image )
    		{!! HTML::vimage('image', ['label' => 'Image', 'accept' => 'image/*' ,'value' => $model->image]) !!}
            
        @else
            {!! HTML::vimage('image', ['label' => 'Image', 'accept' => 'image/*']) !!}
        @endif      
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        
        {!! HTML::vselect('site', ['back' => 'Back Side', 'front' => 'Front Side'],  null, ['label' => 'Image Side', 'data-validation' => '
        required' ]) !!}
    </div>
</div>
@if(\request('userId'))
    {!! Form::hidden('userId', \request('userId')) !!}
@endif        

    