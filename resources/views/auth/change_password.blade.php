@extends('layouts.index')

@section('content')
<style>
  .card-outer {
    min-height: 550px
  }
  .authentication-inner {
    max-width: 400px;
    position: relative;
  }
</style>

  <div class="card card-outer" style="background-color: #eee">
    <div class="card-body">
    <div class="justify-content-center d-md-flex">
      <div class="authentication-inner">
        <div class="card p-5">
          <div class="card-body">
            <div class="app-brand justify-content-center mb-5">
              <span class="app-brand-text text-body fw-bolder fs-3">
                Ganti Password
              </span>
            </div>
            @php
              //var_dump(session());
            @endphp
            @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('error')}}
              </div>
            @endif
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
              </div>
            @endif
            <form id="formAuthentication" class="mb-3" action="{{url('auth/change-password')}}" method="POST">
              @csrf
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password Lama</label>
                <div class="input-group">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="currentPassword"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="text-danger">{{ $errors->first('currentPassword') }}</span>
                </div>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password Baru</label>
                <div class="input-group">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="newPassword"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="text-danger">{{ $errors->first('newPassword') }}</span>
                </div>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Konfirmasi Password</label>
                <div class="input-group">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="newPassword_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="text-danger">{{ $errors->first('newPassword_confirmation') }}</span>
                </div>
              </div>

              <button class="btn btn-primary d-grid w-100">Simpan</button>
            </form>

          </div>
        </div>
      </div>
    </div>

    </div>
  </div>
@endsection