
@extends('layouts.app')

@section('app')

<div class="row">
               


<div class="card ">
  <div class="card-header">
      <div class="d-flex justify-content-between"> 
      <h4> Order Lists </h4>
        
     {{--   <a href="javascript:void(0)" data-toggle="modal" data-target="#createplayer" class="btn m-t-20 btn-info btn-sm "><i class="fas fa-user-plus"></i>
        </a> --}}
                                   
     
      </div>
    
  </div>
  <div class="card-body">

          <div class="card-box table-responsive">

  <table id="datatable-buttons" class="table table-striped table-bordered" style="width:120%">
    <thead>
      <tr>
        <th>Id</th></th>
        <th>Order id</th></th>
        <th>Company name</th></th>
        <th>Coupon</th>
        <th>Amount</th>
        <!--<th>Password</th>-->
        <th> Discount </th>
        <!--<th>Role</th>-->
        <th> Date </th>
        <!--<th>Action</th>-->
        
      </tr>
    </thead>
    
    



  </table>

</div>







@endsection
