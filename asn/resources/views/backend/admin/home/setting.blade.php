@extends('backend.admin.layouts.layout')
@section('content')
    <!--begin::Container-->
    <div class="container-fluid" id="kt_content_container">
        <div class="card card-shadow">
            <div class="card-header">
                <div class="card-title">
                    Setting
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.setting.store') }}" method="POST">
                    @csrf

                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <label for="sys_name">System Name</label>
                            <input class="form-control" id="sys_name" name="sys_name" type="text"
                                value="{{ $setting->sys_name ?? '' }}" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
