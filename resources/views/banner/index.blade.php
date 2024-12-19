
@extends('layouts.app')

@section('app')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg">
                
                
                <div class="row col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between"> 
                                <h4> Banner Lists </h4>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#createplayer" class="btn m-t-20 btn-info btn-sm "><i class="fas fa-upload"></i></a>
                            </div>
                        </div>
        
                        <div class="card-body">

                        <div class="card-box table-responsive">

                            <table id="datatable-buttons" class="table table-striped table-bordered" >
                                <thead>
                                     <tr>
                                        <th>Id</th>
                                        <th>Banner</th>
                                        <th>Create Date</th>
                                        <th>Updated Date</th>
                                        <th>Status</th>
                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($banner as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>
                                            <img src="{{ asset('assets/banner/' . $item->image) }}" width="200" height="50" alt="Banner Image">
                                        </td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->updated_at}}</td>
                                         @if($item->status == 0)
            <td><center><a href="{{route('banner.active',$item->id)}}"><div class="btn btn-danger btn-sm"><i class="fas fa-ban" style="font-size: 14px;"></i> </div></a></center></td>
            @elseif($item->status == 1)`
            <td><center><a href="{{route('banner.inactive',$item->id)}}"><div class="btn btn-success btn-sm"><i class="fas fa-check-circle" style="font-size: 14px;"></i></div></a></center></td>
            @else
            <td> </td>
            @endif
                                        
                                        <!--<td><center><a href="{{route('Player.details',$item->id)}}"><div class="btn btn-danger btn-sm"><i class="fas fa-trash" style="font-size: 14px;"></i></div></a></center></td>-->
                                        
                                        <form action="{{ route('banner.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
    @csrf
    @method('DELETE')
    <!--<button type="submit">Delete</button>-->
   <td> <center><button type="submit"><div class="btn btn-danger btn-sm"><i class="fas fa-trash" style="font-size: 14px;"></i></div></button></center></td>
</form>
            
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                <!-- Modal Add Category -->
                    <div class="modal fade none-border" id="createplayer">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add Banner</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                
                            <form  action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="form-group col-md-12">
                                    <label for="wallet">Image</label>
                                    <input type="file" class="form-control"  name="image" accept="image/*">
                                    @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Upload Banner</button>

                            </div>
                          </form>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
                
    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    

                

@endsection

