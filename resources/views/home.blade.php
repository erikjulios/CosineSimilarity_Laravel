@extends('template')
@section('content')
<!-- Default box -->
<form action="{{url('textMining')}}" method="post">
  @csrf
<div class="row">
  <div class="col-4">
    <div class="card">
      <div class="card-header text-center bg-secondary">
        <h5>Masukan Judul</h5>
      </div>
      <div class="card-body">
        {{-- @isset($data_warna)
              {!! $data_warna !!}
        @else --}}
        <textarea class="form-control" name="judul" id="judul" minlength="20" rows="10" style="resize: none"></textarea>
        {{-- @endisset --}}
      </div>
    </div>
  </div>
  <div class="col-8">
    <div class="card">
      <div class="card-header text-center bg-secondary">
        <h5>Masukan Deskripsi</h5>
      </div>
      <div class="card-body">
        <textarea class="form-control" name="abstraksi" id="abstraksi" minlength="20" rows="10" style="resize: none"></textarea>
      </div>
    </div>
  </div>
</div>
<div class="row d-flex justify-content-center">
  <div class="col text-center">
    <button id="submitBtn" class="h5 btn bg-primary">Check Plagiasi</button>
  </div>
</div>

</form>


<div class="row d-flex justify-content-center mt-2">
  <div class="col-4">
    <div class="card">
      <div class="card-body">
        <div class="text-center h5">Kemiripan judul</div>
        <div id="output_judul" class="text-center h1">
          @if (isset($bigger_judul))
              {{ $bigger_judul }}%          
          @else
              {{ 0 }}
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="card">
      <div class="card-body">
        <div class="text-center h5">Kemiripan deskripsi</div>
        <div id="output_abstraksi" class="text-center h1"></div>
        <div id="output_data" class="text-center h1">
          @if (isset($bigger_abstraksi))
              {{ $bigger_abstraksi }}%         
          @else
              {{ 0 }}
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="text-bold">
          10 kemiripan tertinggi dengan karya ilmiah lainnya :
        </div>
      </div>
      @if (isset($output))
      @foreach ($output as $data)
        <div class="border-top">
          <p class="text-md text-primary mt-2 px-4 font-weight-bold">
            <a href="{{ url('detail', ['id' => $data['id']]) }}">
                {{ $data['judul'] }}
            </a>
          </p>
          <p class="text-sm px-4">
            Judul : {{ $data['persentase_judul'] }}%, 
            Deskripsi : {{ $data['persentase_abstraksi']}}%
          </p>
        </div>
      @endforeach
      @endif
    </div>
  </div>
</div>
{{-- <button id="test">test</button> --}}
{{-- <button onclick="saveText()">Simpan sementara</button>
<button onclick="clear()">Reset</button>
<a href="{{ url('tester')}}">Contoh</a> --}}

<script>

  // function validateString(inputString) {
  //   // menghilangkan spasi pada awal dan akhir string
  //   inputString = inputString.trim();
  //   // regex untuk memeriksa hanya karakter huruf, angka, dan spasi
  //   const regex = /[^a-zA-Z0-9 ]/g;
  //   const result = inputString.replace(regex, "");
  //     return result;
  // }

  // AJAX Request
  // document.getElementById("test").addEventListener("click", function() {
  //   // mengubah karakter agar bisa diterima url
  //     let judul = encodeURIComponent(document.getElementById("judul").value);
  //     let abstraksi = encodeURIComponent(document.getElementById("abstraksi").value);
  //     console.log(validateString(judul));
  //     console.log(validateString(abstraksi));
  //     if (judul.trim() === "") {
  //       alert("Judul harus diisi");
  //       return;
  //     }
  //     if (abstraksi.trim() === "") {
  //       alert("Abstraksi harus diisi");
  //       return;
  //     }
  //     if (judul.indexOf('/') !== -1 || abstraksi.indexOf("/") !== -1) {
  //   alert("Judul dan Abstraksi tidak boleh mengandung karakter slash (/)");
  //   return;
  // }
  //     let xhr = new XMLHttpRequest();
      
  //     xhr.open("GET", "/textMining/" + judul + "/" + abstraksi, true);
  //     xhr.onload = function() { 
  //         if (this.status == 200) {
  //             // document.getElementById("output_judul").textContent = this.responseText;
  //             var response = JSON.parse(this.responseText);
  //             // document.getElementById("output_judul").textContent = response.judul;
  //             // document.getElementById("output_abstraksi").textContent = response.abstraksi;
  //             // console.log(response[0].judul);
  //             // console.log(response[0].abstraksi);
  //             var response1 = response[0];
  //             var response2 = response[1];
  //             // var response2 = JSON.parse(xhr.responseText[1]);
  //             // document.getElementById("output_data").textContent = response2.message;
  //             document.getElementById("output_judul").textContent = response1.original.judul;
  //             document.getElementById("output_abstraksi").textContent = response1.original.abstraksi;
  //             console.log(response1.original.judul);
  //             console.log("pemanggilan API variable response2");
              
  //         }
  //     }
  //     xhr.onerror = function() {
  //       console.error('Terjadi kesalahan pada permintaan AJAX');
  //     };
  //     xhr.send();
  // });
</script>
{{-- <script>
  
var judul1 = document.getElementById('abstraksi');

// Memeriksa apakah ada nilai yang tersimpan dalam Local Storage
var savedText = localStorage.getItem('savedText');
if (savedText) {
  judul1.value = savedText; // Mengatur nilai input
}

// Fungsi untuk menyimpan teks dalam Local Storage
function saveText() {
  var text = judul1.value;
  localStorage.setItem('savedText', text); // Menyimpan nilai input dalam Local Storage
  alert('Teks berhasil disimpan!');
}
function clear() {
  localStorage.removeItem('savedText');  
}
</script> --}}


@endsection

  