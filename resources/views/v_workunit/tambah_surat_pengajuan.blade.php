@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-4">Surat Pengajuan Penyimpanan</h1>
            <div>
              <form action="{{ url('unit-kerja/surat/tambah-pengajuan/penyimpanan') }}" method="POST">
                @csrf
                <input type="hidden" name="purpose" value="penyimpanan">
                <input type="hidden" name="id" value="{{ random_int(100000, 999999) }}">
                <div class="row g-4">
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" required>
                      <label for="name">Tanggal</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control text-uppercase" name="letter_num" placeholder="Nomor surat" required>
                      <label for="name">Nomor Surat</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="category" placeholder="Jenis Surat" required>
                      <label for="name">Jenis Surat (Biasa/Penting)</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="regarding" placeholder="Perihal" required>
                      <label for="name">Perihal</label>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-floating">
                      <textarea id="summernote" name="text" style="height: 20vh;" placeholder="Maksud / Tujuan" required></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                    <button type="submit" class="btn btn-primary py-2 px-3 me-3" href="{{ url('unit-kerja/surat/tambah-pengajuan/penyimpanan') }}"
                    onclick="return confirm('Apakah data sudah benar ?');">
                      Submit
                    </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

@section('js')
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote({
        placeholder: 'Maksud atau tujuan',
        height: 140,
        toolbar: [
            ['style', ['bold', 'italic']],
            ['para', ['ul', 'ol']],
        ]
      });
  });
</script>
@endsection

@endsection
