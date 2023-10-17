<div class="">
    <ul class="nav nav-pills nav-pill-info nav-justified" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bolder active" id="maklumatPSB-tab" data-bs-toggle="tab" href="#maklumatPSB" aria-controls="maklumatPSB" role="tab" aria-selected="true">
                Maklumat PSB/PSL
                {{-- <br><div class="badge badge-light-danger fw-bolder" id="tm_psl" hidden>Tiada Maklumat</div> --}}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bolder" id="peperiksaanPSL-tab" data-bs-toggle="tab" href="#peperiksaanPSL" aria-controls="peperiksaanPSL" role="tab" aria-selected="true">
                Peperiksaan PSL
                <br><div class="badge badge-light-danger fw-bolder" id="tm_peperiksaan_psl" hidden>Tiada Maklumat</div>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="maklumatPSB" role="tabpanel" aria-labelledby="maklumatPSB-tab">
            <hr>
            @include('maklumat_pemohon.pemohon.maklumat_perkhidmatan.psb')
        </div>
        <div class="tab-pane fade" id="peperiksaanPSL" role="tabpanel" aria-labelledby="peperiksaanPSL-tab">
            <hr>
            @include('maklumat_pemohon.pemohon.maklumat_perkhidmatan.peperiksaan')
        </div>
    </div>
</div>
