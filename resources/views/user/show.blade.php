@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">User / </span>  Details
@endsection

@section('content')
  <style>
    .detail-info .row {
      margin-bottom: 20px;
      font-size: 15px;
    }
    .label {
      font-weight: 600;
      color: rgba(1, 41, 112, 0.6);
    }
  </style>
  
  <div class="card">
    <div class="card-header pt-3 pb-4">
      <h5>Detail Users</h5>
      <hr>
    </div>
    <div class="card-body">
      <div class="row detail-info">
        <div class="col-12">
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">NIP</div>
            <div class="col-lg-9 col-md-8">{{ $user->nip }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Nama</div>
            <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Email</div>
            <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Gender</div>
            <div class="col-lg-9 col-md-8">{{ $user->gender }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Alamat</div>
            <div class="col-lg-9 col-md-8">{{ $user->address }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Tanggal Pendaftaran</div>
            <div class="col-lg-9 col-md-8">{{ $user->created_at }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Status</div>
            <div class="col-lg-9 col-md-8">
              @if($user->is_active)
                <span class="badge bg-label-info me-1">Active</span>
              @else
                <span class="badge bg-label-danger me-1">Inactive</span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection