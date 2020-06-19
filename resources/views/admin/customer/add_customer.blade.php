@extends('layouts.admin_layout.admin_layout')
@section('content')

 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Customers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Customer</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Customer Form</h3>
              </div>
              <form id="customerform" name="customerform" action="{{url('/admin/add-customer') }}" method="post">@csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Customer Name</label>
                        <input type="text" class="form-control" id="customername" name="customername" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Customer Mobile</label>
                        <input type="text" class="form-control" id="customermobile" name="customermobile" placeholder="Enter Mobile number">
                      </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Email</label>
                    <input type="email" class="form-control" id="customeremail" name="customeremail" placeholder="Enter Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Customer Place</label>
                    <input type="text" class="form-control" id="customerplace" name="customerplace" placeholder="Enter Location">
                  </div>                  
                  {{-- <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div> --}}
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


@endsection