@extends('template')
@section('content')
<div class="row">
  <div class="col">
    <div class="card">
        <div class="card-body">
            <div class="text-bold">
            Detail Karya Ilmiah :
            </div>
        </div>
        <div class="border-top">
            <p class="text-lg px-4 text-center text-primary mt-3 text-bold">
            {{ $detail_data['judul'] }}
            </p>
            <p class="text-md px-4">
            Abstraksi : <br><br>
            {{ $detail_data['abstraksi'] }}
            </p>
        </div>
    </div>
  </div>
</div>
@endsection

  