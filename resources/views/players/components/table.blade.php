
<section class="space-y-6">

<div class="container mt-3">
    <div class="col-md-12">    
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th></th>
        <th>Name</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $key=>$item)
      <tr>
        <td>{{$key + 1}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->email}}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  </div>
</div>

</section>