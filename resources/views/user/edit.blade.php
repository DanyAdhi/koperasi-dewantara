@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">Users / </span>  Edit
@endsection('breadcrumb')

@section('content')
<div class="row">
  <div class="col-xl">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit User</h5>
      </div>
      <div class="card-body">
        <form action="{{url('users', [$user->id])}}" method="POST">
          @csrf
          @method('put')
          <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" class="form-control" placeholder="192837392777" name= 'nip' value="{{ old('nip', $user->nip) }}"/>
            @error('nip')
              <span class="text-danger">{{ $errors->first('nip') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" placeholder="Dany Adhi" name='name' value="{{ old('name', $user->name) }}"/>
            @error('name')
              <span class="text-danger">{{ $errors->first('name') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" >Jenis Kelamin</label>
            <div class="form-check mt-3">
              <input
                name="gender"
                class="form-check-input"
                type="radio"
                value="Pria"
                {{(old('gender', $user->gender) === 'Pria') ? 'checked' : ''}}
                />
              <label class="form-check-label"> Pria </label>
            </div>
            <div class="form-check mt-3">
              <input
                name="gender"
                class="form-check-input"
                type="radio"
                value="Wanita"
                {{ old('gender', $user->gender) === 'Wanita' ? 'checked' : '' }}
                />
              <label class="form-check-label"> Wanita </label>
            </div>
            @error('gender')
              <span class="text-danger">{{ $errors->first('gender') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" >Email</label>
            <div class="input-group input-group-merge">
              <input 
                type="text" 
                class="form-control" 
                placeholder="danyadhi@gmail.com" 
                name='email' 
                value="{{ old('email', $user->email) }}"
              />
            </div>
            @error('email')
              <span class="text-danger">{{ $errors->first('email') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" placeholder="Jl. kampung bali" name='address' >{{ $user->address }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <div class="form-check form-switch mb-2">
              <input 
                class="form-check-input"
                type="checkbox" 
                name='status' 
                {{ (old('status') == 'on') ? 'checked' : ''}}
                {{ $user->is_active == 1 ? 'checked' : '' }}
                />
            </div>
            @error('status')
              <span class="text-danger">{{ $errors->first('status') }}</span>                  
            @enderror
          </div>
          <a href="{{url('users')}}" class="btn btn-secondary mt-5" style="text-transform: none !important">Back</a>
          <button type="submit" class="btn btn-primary mt-5">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection('content')