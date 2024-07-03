<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>

   <div class="bg-dark py-3">
        <h3 class="text-white text-center">crud</h3>
   </div>
   <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{route('products.create')}}" class="btn btn-dark">Create</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
                <div class="col-md-10 mt-4">
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    
                </div>
            @endif
            <div class="col-md-10">
                <div class="card borde-0 shadow-lg my-4">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Products</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>
                                            @if ($product->image!= "")
                                                <img width="50" src="{{asset('uploads/products/'.$product->image)}}" alt="">
                                            @endif
                                        </td>
                                        <td>{{$product->name}}</td>
                                        
                                        <td>
                                            <a href="{{route('products.edit',$product->id)}}" class="btn btn-dark">Edit</a>
                                            <a href="#" onclick="deleteProduct({{$product->id}});" class="btn btn-danger">Del</a>
                                            <form id="delete-product-from-{{$product->id}}" action="{{route('products.destory',$product->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
   </div>


  </body>
</html>
<script>
    function deleteProduct(id) {
        if(confirm('Are you sure want to delete this product?')) {
            document.getElementById("delete-product-from-"+id).submit();
        }
    }
</script>