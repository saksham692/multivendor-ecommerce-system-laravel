@extends('backend.admin.layouts.main')
@section('title', 'Create Footer Item')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Footer</div>
    <div class="breadcrumb-item">Create Footer Item</div>
@endsection


@section('content')
    <!-- Main Content -->
    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Footer Item</h4>

                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.footer-grid-three.store')}}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="">
                            </div>

                            <div class="form-group">
                                <label>url</label>
                                <input type="text" class="form-control" name="url" value="">
                            </div>

                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select id="inputState" class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submmit" class="btn btn-primary">Create</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
