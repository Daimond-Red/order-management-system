<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">Personal Info</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">Profile Image</a>
    </li>
    {{-- <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab">Device Details</a>
    </li> --}}
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('name', null, ['label' => 'Name', 'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('mobile_no', null, ['label' => 'Mobile No', 'data-validation' => 'required', 'class' => 'form-control phone-10-digit']) !!}
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('email', null, ['label' => 'Email', 'data-validation' => 'email']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vpassword('password', ['label' => 'Password']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('company', null, ['label' => 'Company Name', 'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('pan', null, ['label' => 'Pancard No', 'data-validation' => 'required']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('gstin', null, ['label' => 'GSTIN', 'data-validation' => 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vselect('status', ['' => 'Document Pending', '2' => 'Unverified', '1' => 'Verified' ], null, ['label' => 'Account Status']) !!}
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('aadhar', null, ['label' => 'Aadhaar Number']) !!}
            </div>
            
        </div>

    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
        @if( isset($model) && $model->image )
            {!!  HTML::vimage('image', ['value' => $model->image, 'accept' => 'image/*']) !!}
        @else
            {!! HTML::vimage('image', ['accept' => 'image/*']) !!}
        @endif
    </div>
    {{-- <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
        {!! HTML::vtext('device_id', null, ['label' => 'Device ID']) !!}
        {!! HTML::vtext('device_type', null, ['label' => 'Device Type', 'disabled']) !!}
        {!! HTML::vtextarea('device_token', null, ['label' => 'Device Token']) !!}
    </div> --}}
</div>