<div class="row">
    <div class="col-md-12">
        {!!  HTML::vtext('title', null, ['label' => 'Page Title', 'data-validation' => 'required']) !!}
    </div>
    <div class="col-md-6">
    	{{-- @if(isset($model))
    		{!!  HTML::vtext('slug', null, ['label' => 'Slug', 'disabled']) !!}
    	@else
    		{!!  HTML::vtext('slug', null, ['label' => 'Slug']) !!}
    	@endif --}}
        
    </div>
</div>

{!!  HTML::vtextarea('body', null, ['label' => 'Page Content', 'class' => 'editor']) !!}