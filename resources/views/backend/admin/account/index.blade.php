@extends('backend.admin.layouts.layout')
@section('content')
    <!--begin::Container-->
    <div class="container-fluid" id="kt_content_container">
        <div class="card card-shadow">
            <div class="card-header">
                <div class="card-title">
                    Edit Profile
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input class="form-control" name="name" type="text" value="{{ Auth::user()->name }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input class="form-control" name="email" type="text" value="{{ Auth::user()->email }}"
                                    required>
                            </div>
                        </div>

                    </div>
            </div>
            <div class=" card-footer d-flex justify-content-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
            </form>
        </div>
        <div class="card card-shadow mt-4">
            <div class="card-header">
                <div class="card-title">
                    Edit Password
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    <div class="row">
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">

                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input
                                    class="form-control @error('new_password')
                                is-invalid
                            @enderror"
                                    name="new_password" type="password" value="" required>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">

                            <div class="form-group">
                                <label class="form-label">Re-type Password</label>
                                <input
                                    class="form-control @error('conform_password')
                                is-invalid
                            @enderror"
                                    name="conform_password" type="password" value="" required>
                            </div>
                        </div>

                    </div>
            </div>
            <div class=" card-footer d-flex justify-content-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
            </form>
        </div>
    </div>
@endsection
