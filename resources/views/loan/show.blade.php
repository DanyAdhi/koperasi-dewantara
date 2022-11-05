@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">Pinjaman / </span>  Details
@endsection

@php
  $search_index = array_search(0, array_column($installment, 'is_paid'));
@endphp 

@section('content')
  <style>
    .detail-info {
      margin-bottom: 60px;
    }
    .detail-info .row {
      margin-bottom: 20px;
      font-size: 15px;
    }
    .label {
      font-weight: 600;
      color: rgba(1, 41, 112, 0.6);
    }
  </style>
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <div class="card-header pt-3 pb-4">
      <h5>Detail Pinjaman</h5>
      <hr>
    </div>
    <div class="card-body">
      <div class="row detail-info">
        <div class="col-6">
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">NIP</div>
            <div class="col-lg-9 col-md-8">{{ $loan->nip }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Nama</div>
            <div class="col-lg-9 col-md-8">{{ $loan->name }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Tanggal Pinjam</div>
            <div class="col-lg-9 col-md-8">{{ $loan->created_at }}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Status</div>
            <div class="col-lg-9 col-md-8">
              @if($loan->is_paid_off)
                <span class="badge bg-label-info me-1">Sudah Lunas</span>
              @else
                <span class="badge bg-label-danger me-1">Belum Lunas</span>
              @endif
            </div>
          </div>
        </div>
        <div class="col-6">
        <div class="row">
            <div class="col-lg-3 col-md-4 label ">Jumlah Pinjam</div>
            <div class="col-lg-9 col-md-8"> @currency($loan->loan_amount) </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Kali Angsuran</div>
            <div class="col-lg-9 col-md-8">{{$loan->installment_times}} Bulan</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Jumlah Angsuran</div>
            <div class="col-lg-9 col-md-8"> @currency($loan->installment_amount)</div>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <h5 class="card-header">Detail Angsuran</h5>
        <div class="table-responsive text-nowrap p-2">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
              {{session('success')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          <table class="table table-striped">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($installment as $item)
              <tr>
                <td><strong>{{ $loop->index + 1 }}</strong></td>
                <td>{{ $item->due_date }}</td>
                <td>
                  @if($item->is_paid)
                    <span class="badge bg-label-info me-1">Sudah Dibayar</span>
                  @else
                    <span class="badge bg-label-danger me-1">Belum Dibayar</span>
                  @endif
                </td>
                <td>
                  @if($item->is_paid)
                    <span class="badge bg-label-info me-1">Lunas</span>
                  @elseif($search_index === $loop->index)
                    <button 
                      type="button" 
                      class="btn btn-sm btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#confirmModal" 
                      onclick="bayarConfirm('{{url('installments/update-status', [$item->id]) }}')"
                    >
                      Bayar
                    </button>
                  @else
                    <span class="ms-2 fs-4 fw-bolder">-</span>
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->

  <!-- modal konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white mb-1">Bayar angsuran</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="row g-2">
          <div class="col mb-0 display-6">
            Bayar angsuran ini?
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">
          Batal
        </button>
        <form class="d-inline" method="POST" id="bayarConfirm">
          @csrf
          @method('put')
          <button type="submit" class="btn btn-md btn-primary">Bayar</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
  <script>
    function bayarConfirm(url) {
      $('#bayarConfirm').attr('action',url);
    }
  </script>
@endsection