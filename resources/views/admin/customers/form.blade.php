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
                {!! HTML::vtext('name', null, ['label' => 'Name']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('mobile_no', null, ['label' => 'Mobile No', 'class' => 'form-control phone-10-digit']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('email', null, ['label' => 'Email', 'disabled' => 'disabled']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vpassword('password', ['label' => 'Password']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('pan', null, ['label' => 'Pancard No']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('aadhar', null, ['label' => 'Aadhaar Number']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vselect('status', ['' => 'Document Pending', '2' => 'Unverified', '1' => 'Verified'], null, ['label' => 'Account Status']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vselect('type', ['2' => 'Individual', '3' => 'Commercial'], null, ['label' => 'Customer Type']) !!}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
        @if( isset($model) && $model->image )
            {!!  HTML::vimage('image', [ 'label' => 'Profile Image', 'value' => $model->image, 'accept' => 'image/*']) !!}
        @else
            {!! HTML::vimage('image', ['label' => 'Profile Image', 'accept' => 'image/*']) !!}
        @endif
        {{-- <div class="row">
            <div class="col-md-6">
            
                {!! HTML::vimage('pan_image', ['label' => 'Pan Image', 'accept' => 'image/*']) !!}
            </div>
            <div class="col-md-6">    
                {!! HTML::vimage('aadhar_image', ['label' => 'Aadhar Image', 'accept' => 'image/*']) !!}
            </div>
        </div> --}}
        
        {{-- @if($model->type == \App\User::COMMERCIAL_CUSTOMER)
            <div class="row">
                <div class="col-md-6">
                
                    {!! HTML::vimage('gstin_image', ['label' => 'Gstin Image', 'accept' => 'image/*']) !!}
                </div>
                <div class="col-md-6">    
                    {!! HTML::vimage('cin_image', ['label' => 'Cin Image', 'accept' => 'image/*']) !!}
                </div>
            </div>
        @endif --}}
    </div>
</div>

    
    {{-- <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
        {!! HTML::vtext('device_id', null, ['label' => 'Device ID']) !!}
        {!! HTML::vtext('device_type', null, ['label' => 'Device Type', 'disabled']) !!}
        {!! HTML::vtextarea('device_token', null, ['label' => 'Device Token']) !!}
    </div> --}}
