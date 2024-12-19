
@extends('layouts.app')

@section('app')

<div class="row">
               


<div class="card ">
  <div class="card-header">
      <div class="d-flex justify-content-between"> 
      <h4> Payin Lists </h4>
        
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
        <th>Transaction id</th></th>
        <th>User name</th></th>
        <th>Amount</th>
        <th>Pay mode</th>
        <!--<th>Password</th>-->
        <th>Payment Status</th>
        <!--<th>Role</th>-->
        <th>payment Date</th>
        <!--<th>Action</th>-->
        
      </tr>
    </thead>
    
    
    <tbody>
        @foreach($payin as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->transaction_id }}</td>
            <td>{{$item->user->name}}</td>
            <td>{{$item->amount}}</td>
            @if($item->paymode_id)
            <td>Indian pay</td>
            @endif
            @if($item->status == 1)
                <td>Success</td>
            @elseif($item->status == 0)
                <td>Failed</td>
            @else
                <td></td>
            @endif
            <td>{{ $item->created_at }} </td>
        </tr>
        @endforeach
    </tbody>


  </table>
  {{$payin->links()}}
</div>







@endsection
