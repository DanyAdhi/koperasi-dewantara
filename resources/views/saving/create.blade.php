@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">Tabungan / </span>  Create
@endsection('breadcrumb')


@section('content')
<div class="row">
  <div class="col-xl">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Create User</h5>
      </div>
      <div class="card-body">
        <form action="{{url('savings')}}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">User</label>
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="user_id">
              <option selected>-- Pilih User --</option>
              @foreach($users as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
              @endforeach
            </select>
            @error('user_id')
              <span class="text-danger">{{ $errors->first('user_id') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" >Jumlah Setoran</label>
            <div class="input-group input-group-merge">
              <input type="text" class="form-control" placeholder="2.000.000" name='savings_amount' value="{{ old('savings_amount') }}" id="rupiahPinjaman" />
            </div>
            @error('savings_amount')
              <span class="text-danger">{{ $errors->first('savings_amount') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="category_id">
              <option selected>-- Pilih Kategori --</option>
              @foreach($types as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
              @endforeach
            </select>
            @error('category_id')
              <span class="text-danger">{{ $errors->first('category_id') }}</span>                  
            @enderror
          </div>
          <a href="{{url('savings')}}" class="btn btn-secondary mt-5" style="text-transform: none !important">Back</a>
          <button type="submit" class="btn btn-primary mt-5">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection('content')


@section('script')
  <script type="text/javascript" src="{{asset('js/autoNumeric/autoNumeric.js')}}"></script>
  <script>
      $(document).ready(function(){
        $('#rupiahPinjaman').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
      });
  </script>
@endsection