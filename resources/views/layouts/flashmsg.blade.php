

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Successfully..!</strong>  {{ session('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if (session('error'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Failed..!</strong>  {{ session('error') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif