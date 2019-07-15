<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">Personal Info</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">Image</a>
    </li>
    {{-- <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab">Address</a>
    </li> --}}
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
        {!! Form::hidden('vendor_id', \request('vendor_id')) !!}
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('name',  null, ['label' => 'Name', 'data-validation' => 'required' ]) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('mobile_no', null, ['label' => 'Mobile No', 'data-validation' => 'required', 'class' => 'form-control phone-10-digit']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('email', null, ['label' => 'Email']) !!}
            </div>
            <div class="col-md-6">
                @if( isset($model) )
                    {!! HTML::vtext('password', '') !!}
                @else
                    {!! HTML::vtext('password') !!}
                @endif

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('license_no', null, ['label' => 'Licence No', 'data-validation' => 'required']) !!}        
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('expire_date', null, ['label' => 'Licence Validity', 'class' => 'form-control datepicker', 'data-validation' => 'required']) !!}
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('aadhar', null, ['label' => 'Aadhar Number']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('address', null, ['label' => 'Address', 'data-validation' => 'required']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vselect('status', ['' => 'Document Pending', '2' => 'Unverified', '1' => 'Verified'], null, ['label' => 'Account Status']) !!}
            </div> 
            <div class="col-md-6">
                {!! HTML::vselect('state_id', $states, null, ['label' => 'State', 'id' => 'state', 'data-validation' => 'required']) !!}
            </div> 
        </div>
        <div class="row">
            <div class="col-md-6">
                @if( isset($model) )

                    {!! HTML::vselect('city_id', [ optional($model->cityRel)->id => optional($model->cityRel)->title ], null, ['label' => 'City', 'id' => 'city', 'data-validation' => 'required', 'class' => 'form-control select2-ajaxselect', 'data-url' => route('admin.cities.search', ['state_id' => \App\State::$india_id]),]) !!}
                @else   
                    {!! HTML::vselect('city_id', [], null, ['label' => 'City', 'id' => 'city', 'data-validation' => 'required']) !!}
                @endif
                
            </div> 
        </div>

    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
        @if( isset($model) && $model->image )
            {!!  HTML::vimage('image', ['value' => $model->image]) !!}
        @else
            {!! HTML::vimage('image') !!}
        @endif
        {{-- @if( isset($model) && $model->licence_pic )
            {!!  HTML::vimage('licence_pic', ['value' => $model->licence_pic, 'label' => 'Licence Pic']) !!}
        @else
            {!! HTML::vimage('licence_pic', ['label' => 'Licence Pic']) !!}
        @endif --}}
    </div>
    {{-- <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
        {!! HTML::vtext('address1', null, ['label' => 'Address1']) !!}
        {!! HTML::vtext('address2', null, ['label' => 'Address2']) !!}
        {!! HTML::vtext('city', null, ['label' => 'City']) !!}
        {!! HTML::vtext('state', null, ['label' => 'State']) !!}
        {!! HTML::vtext('pincode', null, ['label' => 'Pincode']) !!}
    </div> --}}
</div>