@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">Users / </span>  Overview
@endsection

@section('content')
  <div class="card">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
      <h5>Data user</h5>
      <a href="{{url('/users/create')}}" class="btn btn-primary text text-decoration-none">
          Tambah
      </a>
    </div>
    <div class="table-responsive text-nowrap p-5">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
          {{session('success')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
          {{session('error')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <table class="table table-hover" id="datatables">
        <thead>
          <tr>
            <th style="width: 10px">No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($users as $user)
            <tr>
              <td>{{ $loop->index + 1 }}</td>
              <td class="fw-bold"> {{$user->nip}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>
                @if($user->is_active == 1)
                  <span class="badge bg-label-primary"> Active </span>
                @else
                  <span class="badge bg-label-danger"> Inactive </span>
                @endif
              </td>
              <td>
                <a href="{{url('users', [$user->id])}}" class="btn btn-icon btn-info">
                  <i class='bx bx-show'></i>
                </a>
                
                <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-icon btn-warning">
                  <i class="bx bx-edit-alt"></i>
                </a>
                <button 
                  type="button" 
                  class="btn btn-icon btn-danger"
                  data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  onclick="deleteConfirm('{{url('users', [$user->id]) }}')"
                >
                  <i class="bx bx-trash"></i>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


  @include('layouts.modal_delete')
@endsection('content')

@section('script')
  <script>
    $(document).ready( function () {
      $('#datatables').DataTable({
        "info": false,
      });
    });
  </script>
@endsection