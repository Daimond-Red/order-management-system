<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">Vehicle Info</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">Owner</a>
    </li>
    {{-- <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab">Configuration</a>
    </li> --}}
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
        
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('vehicle_name', null, ['label' => 'Vehicle Name', 'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vselect('vehicle_type_id', $vehicletypes, null, ['label' => 'Type of vehicle required']) !!}
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('vehicle_num', null, ['label' => 'Vehicle Number',  'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('expire_date', null, ['label' => 'Expire Date', 'class' => 'form-control datepicker', 'data-validation' => 'required']) !!}
            </div>
            
            
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('fitness_validity', null, ['label' => 'Fitness Validity', 'class' => 'form-control datepicker', 'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('insurance_validity', null, ['label' => 'Insurance Validity', 'class' => 'form-control datepicker', 'data-validation' => 'required']) !!}
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vselect('is_verified', ['' => 'Unverified', '1' =>  'Verified', '2' => 'Self-Verified'], null, ['label' => 'Verification']) !!}

            </div>
            <div class="col-md-6">
                {!! HTML::vtext('capacity', null, ['label' => 'Load Capacity', 'data-validation' => 'required']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('length', null, ['label' => 'Length (in feet)', 'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('breadth', null, ['label' => 'Breadth (in feet)', 'data-validation' => 'required']) !!}
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('hieght', null, ['label' => 'Hieght (in feet)', 'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('no_of_tyres', null, ['label' => 'Number Of Tyres', 'data-validation' => 'required']) !!}
            </div>
            
        </div>
        <div class="row">
            
            <div class="col-md-6">
                @if(isset($model))

                    @foreach($permits as $key => $value)

                        @if(in_array($key, $permitTypes))
                            {!! Form::checkbox('permits[]', $key, true, []) !!} {{ $value }}
                        @else
                            {!! Form::checkbox('permits[]', $key, null, []) !!} {{ $value }}
                        @endif
                    @endforeach
                @else
                    @foreach($permits as $key => $value)
                        {!! Form::checkbox('permits[]', $key, null,[]) !!} {{ $value }}
                    @endforeach
                @endif
            </div>
            <div class="col-md-6">
                @if(isset($cities))
                    {!! HTML::vselect('cities[]', $servicesAreas, array_keys($cities), [
                        'label' => 'servicesAreas', 
                        'class' => 'form-control select2-ajaxselect', 
                        'data-url' => route('admin.cities.search'),
                        'id' => 'servicesAreas',
                        'multiple' => 'multiple'
                    ]) !!}
                @else
                    {!! HTML::vselect('cities[]', [], null, [
                        'label' => 'servicesAreas', 
                        'class' => 'form-control select2-ajaxselect', 
                        'data-url' => route('admin.cities.search'),
                        'id' => 'servicesAreas',
                        'multiple' => 'multiple'
                    ]) !!}
                @endif
                
            </div>
        </div> 
    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('name', null, ['label' => 'Owner Name']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('address', null, ['label' => 'Owner Address']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vselect('state_id', $states, null, ['label' => 'State', 'id' => 'state', 'data-validation' => 'required']) !!}
            </div> 
            <div class="col-md-6">
                @if( isset($model) )
                    {!! HTML::vselect('city_id', [ optional($model->cityRel)->id => optional($model->cityRel)->title ], null, ['label' => 'City', 'id' => 'city', 'data-validation' => 'required', 'class' => 'form-control select2-ajaxselect', 'data-url' => route('admin.cities.search', ['state_id' => \App\State::$india_id]),]) !!}
                @else   
                    {!! HTML::vselect('city_id', [], null, ['label' => 'City', 'id' => 'city', 'data-validation' => 'required']) !!}
                @endif
            </div> 

        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('mobile_no', null, ['label' => 'Owner Mobile No', 'class' => 'form-control phone-10-digit']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('pan', null, ['label' => 'Pan Number']) !!}
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('aadhar', null, ['label' => 'Aadhar Number']) !!}
            </div>
        </div>
    </div>
    {{-- <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
        
               
    </div> --}}
</div>