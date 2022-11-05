@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">Dashboard</span>
@endsection('breadcrumb')

@section('content')
  <div class="row mb-3">
    <div class="col-lg-12 col-md-12 order-1">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="flex-shrink-0 text-primary">
                  <i class='fs-4 bx bxs-user'></i>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Jumlah User</span>
              <h3 class="card-title mb-2">{{$count_user}}</h3>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="flex-shrink-0 text-primary">
                  <i class='fs-3 bx bxs-user-check' ></i>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Jumlah User Active</span>
              <h3 class="card-title mb-2">{{$count_user_active}}</h3>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="flex-shrink-0 text-primary">
                  <i class='fs-4 bx bxs-wallet-alt' ></i>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Jumlah pinjaman</span>
              <h3 class="card-title mb-2">{{$count_loans}}</h3>
            </div>
          </div>
        </div>
        <!-- <div class="col-lg-3 col-md-6 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="flex-shrink-0 text-primary">
                  <i class='fs-4 bx bxs-credit-card' ></i>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Jumlah Jatuh Tempo</span>
              <h3 class="card-title mb-2">40</h3>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </div>
  <!-- <div class="row">
    <div class="col-md-12 col-lg-12 order-1 mb-4">
      <div class="card h-100">
        <div class="card-header">
          <p>Statistic</p>
        </div>
        <div class="card-body px-0">
          <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
              <div id="incomeChart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
@endsection('content')