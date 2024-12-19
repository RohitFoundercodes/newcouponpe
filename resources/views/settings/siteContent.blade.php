
@extends('layouts.app')

@section('app')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg">
            <div class="container-fluid mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                            <div class="full graph_head">
                                <div class="d-flex justify-content-between">
                                    <h2>Site Content</h2>
			                        <!--<div> <a href="" class="btn btn-info btn-sm"> Salary List</a> </div>-->
                                </div>
                            </div>
       
                            <div class="table_section padding_infor_info mt-5">
          
			                <form action="" method="post">
				            @csrf
	
     			    
     		</div>
     		
     		<div class="row mt-3">
				  
				   <div class="col-md-12">
    					<label for="exampleInputEmail1" class="form-label">Description</label>
    					
    				 <textarea class="form-control" id="body" placeholder="Enter the Description" name="body"></textarea>
    				
     			    </div>
				  
				 

				  </div>
				 
				 
				 <div class="mt-3">
					 <button type="submit" class="btn btn-success btn-sm"> Submit </button>
					 </div>
				
				 
				 </form>
			  
		
           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>


<script>
    ClassicEditor
    .create( document.querySelector( '#body' ) )
    .catch( error => {
    console.error( error );
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" ></script>


                

@endsection

