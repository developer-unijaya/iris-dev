<style>
    #table-list-users thead th {
        vertical-align: middle;
        text-align: center;
    }

    #table-list-users tbody {
        vertical-align: middle;
        /* text-align: center; */
    }

    #table-list-users {
        width: 100% !important;
        /* word-wrap: break-word; */
    }

</style>

<div class="modal fade text-start" id="viewUsersModal" tabindex="-1" aria-labelledby="title-role" aria-hidden="true" data-bs-backdrop="false" style="background:rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-role">Lihat Kumpulan Pengguna</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <center>
                    <table width="100%">
                        <tr>
                            <td width="20%" class="fw-bolder">Nama Peranan</td>
                            <td id="td_name"></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Nama Paparan</td>
                            <td id="td_display_name"></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Penerangan</td>
                            <td id="td_description"></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Jenis Peranan</td>
                            <td id="td_is_internal"></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Jumlah Bilangan Pengguna</td>
                            <td id="td_count"></td>
                        </tr>
                    </table>
                    </center>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table header_uppercase table-bordered" id="table-list-users">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>No Kad Pengenalan</th>
                                <th>Emel</th>
                                <th>No Telefon</th>
                                <th>Kementerian</th>
                                <th>Jawatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
