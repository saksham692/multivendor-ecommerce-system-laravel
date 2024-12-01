@extends('backend.admin.layouts.main')
@section('title', 'Edit Footer Item')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Footer</div>
    <div class="breadcrumb-item">Edit Footer Item</div>
@endsection

@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Footer Item</h4>

                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.footer-grid-three.update', $footer->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$footer->name}}">
                        </div>

                        <div class="form-group">
                            <label>url</label>
                            <input type="text" class="form-control" name="url" value="{{$footer->url}}">
                        </div>

                        <div class="form-group">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="status">
                              <option {{$footer->status === 1 ? 'selected' : ''}} value="1">Active</option>
                              <option {{$footer->status === 0 ? 'selected' : ''}} value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submmit" class="btn btn-primary">Update</button>
                    </form>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </section>

@endsection
