@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center g-3">
        <div class="col-md-12 clearfix">
            <div class="float-end">
                <a href="{{ url('/admin/add-category') }}" class="btn btn-primary">Add category</a>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Subcategory</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category['name'] }}</td>
                                    <td>
                                        <img src="{{ asset('images/category/'.$category['image']) }}" alt="Img" style="width: 80px; height: auto;">
                                    </td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach ($category['subcategories'] as $key => $subcategory)
                                            <li class="list-unstyled-item">{{ $subcategory['name'] }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/edit-category/'. $category['id']) }}">Edit</a>
                                        <a href="javascript:void(0);" class="remove-btn" data-id="{{ $category['id'] }}" data-url="/admin/delete-category">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 clearfix">
                            <div class="pagination pagination-secondary float-end pagination-sm" id="privateCategoryPagination">
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
