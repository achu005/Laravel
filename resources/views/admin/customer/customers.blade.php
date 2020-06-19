@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customers</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customers</h3>
                <a href="{{url('/admin/add-customer') }}" class="btn btn-block btn-success" style="width:150px;float:right;display:inline-block;">
                    Add Customer
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr style="background:rosybrown;">
                      <th style="width: 10px">#</th>
                      <th>Customer Name</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Place</th>
                      <th>Actions</th>
                      {{-- <th style="width: 40px">Label</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                   <?php $num = 1; ?>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{$num++}}</td>
                        <td>{{$customer->customer_name}}</td>
                        <td>{{$customer->customer_mobile}}</td>
                        <td>{{$customer->customer_email}}</td>
                        <td>{{$customer->customer_place}}</td>
                        <td>
                            {{-- <a href="{{url('/admin/delete-customer/'.$customer->id)}}" type="button" class="btn btn-danger">Delete</a> --}}
                            {{-- record is customer from above url bcz /admin/delete- is in js --}}
                            <a href="javascript:void(0)" class="confirmDelete btn btn-danger" record="customer" recordid= "{{ $customer->id }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection