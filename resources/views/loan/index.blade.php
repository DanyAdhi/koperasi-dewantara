@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">Pinjaman / </span>  Overview
@endsection

@section('content')
  <div class="card">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
      <h5>Data Pinjaman</h5>
      <a href="{{url('/loans/create')}}" class="btn btn-primary text text-decoration-none">
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
      <table class="table table-hover" id="datatables">
        <thead>
          <tr>
            <th style="width: 10px">No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Jumlah Pinjaman</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse($loans as $item)
            <tr>
              <td>{{ $loop->index + 1 }}</td>
              <td class="fw-bold"> {{ $item->nip }}</td>
              <td>{{ $item->name }}</td>
              <td>@currency($item->loan_amount)</td>
              <td>
                @if($item->is_paid_off)
                  <span class="badge bg-label-info">Sudah Lunas</span>
                @else
                  <span class="badge bg-label-danger">Belum Lunas</span>
                @endif
              </td>
              <td>
                <a href="{{url('loans', [$item->id])}}" class="btn btn-icon btn-info" title="detail">
                  <i class='bx bx-show'></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan='6' class='p-4'>
                <p class='text-center'>Empty Data</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready( function () {
      $('#datatables').DataTable({
        "info": false,
      });
    });
  </script>
@endsection