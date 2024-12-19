
@extends('layouts.app')

@section('app')

<div class="row">
               


<div class="card ">
  <div class="card-header">
      <div class="d-flex justify-content-between"> 
      <h4> User Lists </h4>
        
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
        <th>Uuid</th></th>
        <th>First Name</th></th>
        <th>Last Name</th>
        <th>Email</th>
        <!--<th>Password</th>-->
        <th>Wallet</th>
        <!--<th>Role</th>-->
        <th>status</th>
        <!--<th>Action</th>-->
        
      </tr>
    </thead>


    <tbody>
       @foreach($users as $key=>$item)
      <tr>
        <td>{{$key + 1}}</td>
        <td>{{$item->uuid}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->email}}</td>
   {{--     @if($item->show_pwd)
       @php $item->decoded_pwd = base64_decode($item->show_pwd); @endphp
        <td><center>
            
            <!-- <button type="button" class="btn btn-info btn-sm text-white" -->
            <!--        data-bs-toggle="popover" -->
            <!--        data-bs-title="{{$item->username}}" -->
            <!--        data-bs-content="{{ $item->decoded_pwd }}">-->
            <!--    Show Password-->
            <!--</button>-->
            
            <button type="button" class="btn btn-info btn-sm" data-container="body" data-toggle="popover" data-placement="right" data-title="{{$item->username}}" data-content="{{ $item->decoded_pwd }}"><i class="ti-eye"></i></button>
            
            
        </center></td>
        
        @else
        <td></td>
        @endif --}}
        <td> 
        <div>
        <p>  ₹ {{$item->wallet}}</p>
        
        <!--<a href="" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#walletadd{{$item->id}}"> + </a>-->
        <div class="d-flex justify-content-between">
        <a href="javascript:void(0)" data-toggle="modal" data-target="#walletadd{{$item->id}}" class="btn m-t-20 btn-info btn-sm "><i class="ti-plus"></i>
        </a>
        
        <a href="javascript:void(0)" data-toggle="modal" data-target="#walletsub{{$item->id}}" class="btn m-t-20 btn-danger btn-sm "><i class="ti-minus"></i>
        </a>
     </div>
        </div>
        </td>
        
       
        
                <!-- Modal Add Category -->
                <div class="modal fade none-border" id="walletadd{{$item->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add</strong> a Wallet</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('playerWallet.add',$item->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="form-group col-md-12">
                                    <label for="wallet">Wallet Amount</label>
                                    <input type="number" class="form-control" id="wallet" name="wallet" value="" placeholder="Enter Amount">
                                    @error('wallet')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                          </form>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
                
                 <!-- Modal Add Category -->
                <div class="modal fade none-border" id="walletsub{{$item->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Sub</strong> a Wallet</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                   <form action="{{route('playerWallet.sub',$item->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="form-group col-md-12">
                                    <label for="wallet">Wallet Amount</label>
                                    <input type="number" class="form-control" id="wallet" name="wallet" value="" placeholder="Enter Amount">
                                    @error('wallet')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                          </form>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
        
        
        

        
        
        
        
       {{-- @if($item->role_id == 2 || in_array($item->role_id, [3, 4, 5, 6, 7]))
        <td><div class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-placement="right" title="Player"> <i class="fas fa-user"></i> </div></td>
        
  
        @elseif($item->role_id == 1)
        <td><div class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-placement="right" title="Admin"> <i class="fas fa-user-secret"></i> </div></td>
        @else
        <td></td>
        @endif --}}
        
        
    
         @if($item->status == 0)
            <td><center><a href="{{route('playerActive',$item->id)}}"><div class="btn btn-danger btn-sm"><i class="fas fa-ban" style="font-size: 14px;"></i> </div></a></center></td>
            @elseif($item->status == 1)
            <td><center><a href="{{route('playerInactive',$item->id)}}"><div class="btn btn-success btn-sm"><i class="fas fa-check-circle" style="font-size: 14px;"></i></div></a></center></td>
            @else
            <td> </td>
            @endif
            
             {{-- <td><center><a href="{{route('Player.details',$item->id)}}"><div class="btn btn-info btn-sm"><i class="fas fa-cogs" style="font-size: 14px;"></i></div></a></center></td> --}}
            
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $users->links() }}
</div>


  <!-- Modal Add Category -->
                <div class="modal fade none-border" id="createplayer">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Create</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="wallet">Email</label>
                                    <input type="email" class="form-control"  name="email" value="" placeholder="Enter email">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                  
                                   <div class="form-group col-md-6">
                                    <label for="wallet">Password</label>
                                    <input type="password" class="form-control"  name="password" value="" placeholder="Enter password">
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                  
                                </div>
                                
                                <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="wallet"> Revenue % </label>
                                    <input type="number" class="form-control" id="wallet" name="revenue" value="" placeholder="Enter revenue" step="0.01">
                                    @error('revenue')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                  
                                   <div class="form-group col-md-6">
                                    <label for="wallet">Perent</label>
                                    <!--<input type="number" class="form-control" id="wallet" name="perent" value="" placeholder="Enter Amount">-->
                                    <select name="perent" class="form-control">
                                        @php
                                            $roles = App\Models\Role::all();
                                        @endphp
                                        @foreach($roles as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('perent')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                  
                                </div>
                                
                              </div>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                          </form>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->





@endsection
