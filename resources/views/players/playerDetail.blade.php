
@extends('layouts.app')

@section('app')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg">
                
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex justify-content-between"> 
                            <h4> Bet Lists </h4>
                            <a href="{{ route('player.index') }}" class="btn btn-primary btn-sm" > Back </a>
                        </div>
    
                    </div>
  
    <div class="card-body">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered" style="width:120%">
                <thead>
                    <tr>
                        <th>Id</th></th>
                        <th>User id</th></th>
                        <th>Gamesno</th></th>
                        <th>Game id</th>
                        <th>Amount</th>
                        <th>Win Number</th>
                        <th>Win Amount</th>
                        <th>status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($lucky12Bet as $key=>$item)
      <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->user_id}}</td>
        <td>{{$item->period_no}}</td>
        <td>{{$item->game_id}}</td>
        <td>{{$item->amount}}</td>
        <td>{{$item->win_number}}</td>
        <td>{{$item->win_amount}}</td>
        <td>{{$item->status}}</td>
    
      </tr>
    @endforeach
     
                </tbody>
            </table>
             <div class="mt-5">
                {{ $lucky12Bet->links() }}
            </div>
        </div>
    </div>
</div>

                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between"> 
                            <h4> Payin Lists </h4>
                            <a href="{{ route('player.index') }}" class="btn btn-primary btn-sm" > Back </a>
                        </div>
    
                    </div>
  
    <div class="card-body">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered" style="width:120%">
                <thead>
                    <tr>
                        <th>Id</th></th>
                        <th>User id</th></th>
                        <th>Transaction </th>
                        <th>Paymode</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    
                      @foreach($payin as $item)
                        <tr> 
                            <td>{{$item->id}}</td>
                            <td>{{$item->user_id}}</td>
                            <td>{{$item->transaction_id}}</td>
                             @if($item->paymode_id == 4)
                            <td> <div class="btn btn-info btn-sm text-white"> Via Admin </div>  </td>
                            @else 
                            @endif
                            <td>{{$item->amount}}</td>
                            @if($item->payment_status==2)
                            <td> <div class="btn btn-success btn-sm"> Success </div> </td>
                            @else
                            <td></td>
                            @endif
                        </tr>
                      @endforeach
     
                </tbody>
            </table>
        </div>
    </div>
</div>

                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between"> 
                            <h4> withdraw Lists </h4>
                            <a href="{{ route('player.index') }}" class="btn btn-primary btn-sm" > Back </a>
                        </div>
    
                    </div>
  
    <div class="card-body">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered" style="width:120%">
                <thead>
                      <tr>
                        <th>Id</th></th>
                        <th>User id</th></th>
                        <th>Transaction </th>
                        <th>Paymode</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    
                     @foreach($withdraw as $item)
                        <tr> 
                            <td>{{$item->id}}</td>
                            <td>{{$item->user_id}}</td>
                            <td>{{$item->transaction_id}}</td>
                            
                            @if($item->paymode_id == 4)
                            <td> <div class="btn btn-info btn-sm text-white"> Via Admin </div>  </td>
                            @else 
                            @endif
                            <td>{{$item->amount}}</td>
                            @if($item->payment_status==2)
                            <td> <div class="btn btn-success btn-sm text-white"> Success </div> </td>
                            @else
                            <td></td>
                            @endif
                        </tr>
                      @endforeach
     
                </tbody>
            </table>
        </div>
    </div>
</div>
                
                
            </div>
        </div>
    </div>



@endsection
