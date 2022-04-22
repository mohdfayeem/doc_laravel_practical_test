@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Category</div>

                <div class="card-body">
                @if (Session::has('response_message'))
                    <div class="alert {{ Session::get('response_class') }}" role="alert">
                        <span>{{ Session::get('response_message') }}</span>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <div class="small">
                            <h6><i class='fa fa-exclamation-triangle'></i> Please correct these error</h6>
                            <ul class="list-unstyled mb-0">
                                @foreach ($errors->all() as $error)
                                <li class="small"><i class="fa fa-circle"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form action="{{ url('/admin/add-category') }}" method="post" id="add_category_form" enctype="multipart/form-data">@csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Category Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Category email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" id="image" name="image" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h5>Subcategories Details:</h5>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="subcategoryname" class="form-label">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="subcategoryname[]" placeholder="Enter Subcategory Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="subcategoryemail" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="subcategoryemail[]" placeholder="Enter Subcategory Email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3 mt-4 pt-1">
                                    <button type="button" class="btn btn-primary add-subcategory-fields-btn">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid p-0" id="append_subcategory_container">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
