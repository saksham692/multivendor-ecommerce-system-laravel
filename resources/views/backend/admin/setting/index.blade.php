@extends('backend.admin.layouts.main')
@section('title', 'Site Settings')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Settings</div>
@endsection
@push('style')
@endpush
@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Settings</h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">

                    <div class="card-body">
                      <div class="row">
                        <div class="col-2">
                          <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab">General Setting</a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Email Configuration</a>
                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab">Logo and Favicon</a>

                            <a class="list-group-item list-group-item-action" id="list-pusher-list" data-toggle="list" href="#pusher-setting" role="tab">Pusher Setting</a>


                          </div>
                        </div>
                        <div class="col-10">
                          <div class="tab-content" id="nav-tabContent">

                            @include('backend.admin.setting.general-setting')

                            @include('backend.admin.setting.email-configuration')

                            @include('backend.admin.setting.logo-setting')

                            @include('backend.admin.setting.pusher-setting')
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>

          </div>
        </section>

@endsection
