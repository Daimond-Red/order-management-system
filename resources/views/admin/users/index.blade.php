@extends('layouts.master')

@section('pageBar')
    Customers 
@stop

@section('content')
    
    <div id="mainPanel">
        
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div id="panel-1" class="panel panel-white">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <h3 class="panel-title text-capitalize">Customer List</h3> </div>
                        <div class="col-xs-12 col-sm-12 col-md-10">
                            <div class="pull-right">
                                <ul class="list-inline mrgn-all-none">
                                                                        
                                    @if( isSuperAdmin() )
                                    {{-- <li>
                                        <button
                                                class="btn btn-primary btn-rounded dataModel"
                                                type="button"
                                                data-id="#mainPanel"
                                                data-href="{{ route('admin.vehicleTypes.create') }}"
                                        >Add New
                                        </button>
                                    </li> --}}
                                    @endif
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="collapse in">
                    <div class="panel-body">
                        <div class="table-responsive ajax-collection">
                            
                            <table class="data-table table table-hover th-fw-light" style="width:100%;">
                                <thead>
                                <tr class="bg-primary">
                                    <th>#</th>
                                    <th>Customer Info</th>
                                    <th>Mobile No</th>
                                    <th>Account Status</th>
                                    <th>Signup Type</th>
                                    <th>Created On</th>
                                    <th width="15%"> Action </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(! count($collection) )
                                    <tr>
                                        <td colspan="15" style="text-align: center">No matching records found</td>
                                    </tr>
                                @else
                                    @foreach( $collection as $model )
                                        <tr>
                                            <td>{{ $model->id }}</td>
                                            <td>
                                                <a href="{{ getImageUrl('') }}" class="light-image">
                                                    <img style="width: 40px; height:40px" src="{{ getImageUrl('') }}">
                                                </a>
                                                <span><strong>{{ $model->name }}</strong><br>{{ $model->email }}</span>
                                                
                                            </td>

                                            <td>{{ $model->mobile_no }}</td>
                                            <td>
                                                @if($model->is_verified)
                                                    <span class="btn btn-success btn-rounded btn-xs">Verified</span>
                                                @else
                                                    <span class="btn btn-danger btn-rounded btn-xs">Unverified</span>
                                                @endif    
                                            </td>
                                            <td>
                                                @if($model->type == \App\User::INDIVIDUAL_CUSTOMER)
                                                    <span class="btn m-b-xs w-xs btn-default btn-rounded disabled btn-xs">Normal</span>
                                                @elseif($model->type == \App\User::COMMERCIAL_CUSTOMER)
                                                    <span class="btn m-b-xs w-xs btn-default btn-rounded disabled btn-xs">Commercial</span>
                                                @endif
                                            </td>
                                            <td>{{ getDateValue($model->created_at) }}</td>
                                            <td>
                                                <button
                                                    data-id="#mainPanel"
                                                    data-href="{{ route('admin.users.edit', $model->id) }}"
                                                    class="btn btn-outline-inverse btn-primary btn-xs dataModel"
                                                    type="button"
                                                > <span><i class="fa fa-pencil" aria-hidden="true"></i></span> </button>
                                                <a href="{{route('admin.users.delete', $model->id)}}" class="deleteItem btn btn-outline-danger btn-danger  btn-xs" type="button"> <span><i class="fa fa-times" aria-hidden="true"></i></span> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            {{-- {{ $collection->appends(array_merge(request()->all(), ['isAjax'=>1]))->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.master-menu').addClass('active opened');
            $('.master-menu ul').removeClass('collapse');
            $('.vehicle-type-menu').addClass('active');
        });
    </script>
@stop
