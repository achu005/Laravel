@extends('layouts.admin_layout.admin_layout');
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
              
             
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>
                <a href="{{url('/admin/add-edit-category') }}" class="btn btn-block btn-success" style="width:150px;float:right;display:inline-block;">
                    Add Category
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="categories" class="table table-bordered table-striped">
                  <thead>
                  <tr style="background:rosybrown; color:#fff">
                    <th>#</th>
                    <th>Section</th>
                    <th>Parent Category</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $num = 1; ?>
                      @foreach ($categories as $category)
                      @if(!isset($category->parentcategory->category_name))
                        <?php $parent_category = "Root"; ?>
                      @else
                        <?php $parent_category = $category->parentcategory->category_name; ?>
                      @endif
                      
                      <tr>
                        <td>{{$num++}}</td>
                        <td>{{$category->section->name}}</td>
                        <td>{{$parent_category}}</td>
                        <td>{{$category->category_name}}</td>
                        <td><img style="width:75px;margin-top:10px;" src="{{ asset('images/category_images/'.$category['category_image']) }}"/></td>
                        <td> 
                            @if($category->status==1)
                                <a class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)">Active</a>
                            @else
                            <a class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)">Inactive</a>
                            @endif
                            </td>
                          <td><a href="{{url('/admin/add-edit-category/'.$category->id)}}" type="button" class="btn btn-primary">Edit</a>
                          &nbsp;&nbsp;&nbsp;
                          {{-- normal method --}}
                          {{-- <a class="confirmDelete" name="Category" href="{{url('/admin/delete-category/'.$category->id)}}" type="button" class="btn btn-danger">Delete</a></td> --}}
                            {{-- using sweetalert --}}
                            <a href="javascript:void(0)" class="confirmDelete btn btn-danger" record="category" recordid= "{{ $category->id }}">Delete</a></td>
                        </tr>    
                      @endforeach              
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection