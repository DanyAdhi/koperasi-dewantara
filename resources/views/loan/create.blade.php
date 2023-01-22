@extends('layouts.index')

@section('breadcrumb')
  <span class="text-muted fw-light">Loans / </span>  Create
@endsection('breadcrumb')

@php
//  dd($users);
@endphp

@section('content')
<div class="row">
  <div class="col-xl">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Create User</h5>
      </div>
      <div class="card-body">
        <form action="{{url('loans')}}" method="POST">
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
            <label class="form-label" >Total Pinjaman</label>
            <div class="input-group input-group-merge">
              <input type="text" class="form-control" placeholder="2.000.000" name='loan_amount' value="{{ old('loan_amount') }}" id="rupiahPinjaman" />
            </div>
            @error('loan_amount')
              <span class="text-danger">{{ $errors->first('loan_amount') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" >Kali Angsuran <small class="text-lowercase">(bulan)<small></label>
            <div class="input-group input-group-merge">
              <input type="number" class="form-control" placeholder="10-60" name='installment_times' value="{{ old('installment_times') }}"/>
            </div>
            @error('installment_times')
              <span class="text-danger">{{ $errors->first('installment_times') }}</span>                  
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" >Bunga (%)</label>
            <div class="input-group input-group-merge">
              <input type="number" class="form-control" placeholder="0-100" name='loan_interest' value="{{ old('loan_interest') }}"/>
            </div>
            @error('loan_interest')
              <span class="text-danger">{{ $errors->first('loan_interest') }}</span>                  
            @enderror
          </div>
          <a href="{{url('loans')}}" class="btn btn-secondary mt-5" style="text-transform: none !important">Back</a>
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