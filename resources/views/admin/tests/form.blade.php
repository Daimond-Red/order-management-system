
<div class="row">
    <div class="col-md-6">
        {!! HTML::vtext('name',  null, ['label' => 'Name', 'data-validation' => '
        required' ]) !!}
    </div>
    <div class="col-md-6">
        {!! HTML::vtext('phone', null, ['label' => 'Mobile No', 'data-validation' => '
        required' ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {!! HTML::vtextarea('description', null, ['class' => 'form-control editor']) !!}
    </div>
    
</div>
<div class="row">
    <div class="col-md-4">
        {!! HTML::vimage('image', ['label' => 'Image']) !!}        
    </div>
    <div class="col-md-4">
        {!! HTML::vtext('date', null, ['label' => 'Date', 'class' => 'datepicker form-control']) !!}
    </div>
    <div class="col-md-4">
        {!! HTML::vselect('gender', ['' => 'Select', 'male' => 'Male', 'female' => 'Female'], null, ['label' => 'Gender', 'class' => 'form-control select2-select']) !!}
    </div>
</div>
            

    