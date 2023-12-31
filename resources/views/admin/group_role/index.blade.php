@extends('layouts.app')

@section('header')
    Kumpulan Pengguna
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('msg.home')}}</a></li>
    <li class="breadcrumb-item"><a>Kumpulan Pengguna</a>
    </li>
@endsection

@section('content')
<style>
    #table-group-role thead th {
        vertical-align: middle;
        text-align: center;
    }

    #table-group-role tbody {
        vertical-align: middle;
        /* text-align: center; */
    }

    #table-group-role {
        width: 100% !important;
        /* word-wrap: break-word; */
    }

</style>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Senarai Kumpulan Pengguna</h4>
    </div>
    <hr>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table header_uppercase table-bordered" id="table-group-role">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Peranan</th>
                        <th>Nama Paparan</th>
                        <th>Penerangan</th>
                        <th>Jenis Peranan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('admin.group_role.getListUsers')

@endsection

@section('script')
<script>

    var table = $('#table-group-role').DataTable({
        orderCellsTop: true,
        colReorder: false,
        pageLength: 25,
        processing: true,
        serverSide: true, //enable if data is large (more than 50,000)
        ajax: {
            url: "{{ fullUrl() }}",
            cache: false,
        },
        columns: [
            {
                defaultContent: '',
                orderable: false,
                searchable: false,
                className : "text-center",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: "name",
                name: "name",
                render: function(data, type, row) {
                    return $("<div/>").html(data).text();
                }
            },
            {
                data: "display_name",
                name: "display_name",
                render: function(data, type, row) {
                    return $("<div/>").html(data).text();
                }
            },
            {
                data: "description",
                name: "description",
                render: function(data, type, row) {
                    return $("<div/>").html(data).text();
                }
            },
            {
                data: "is_internal",
                name: "is_internal",
                render: function(data, type, row) {
                    return $("<div/>").html(data).text();
                }
            },
        ],
        language : {
            emptyTable : "Tiada data tersedia",
            info : "Menunjukkan _START_ hingga _END_ daripada _TOTAL_ entri",
            infoEmpty : "Menunjukkan 0 hingga 0 daripada 0 entri",
            infoFiltered : "(Ditapis dari _MAX_ entri)",
            search : "Cari:",
            zeroRecords : "Tiada rekod yang ditemui",
            paginate : {
                first : "Pertama",
                last : "Terakhir",
                next : "Seterusnya",
                previous : "Sebelumnya"
            },
            lengthMenu : "Lihat _MENU_ entri",
        }
    });

    function viewUsersForm(id){
        url = "{{ route('admin.group-role.edit', ':replaceThis') }}";
        url = url.replace(':replaceThis', id);

        url2 = "{{ route('admin.group-role.getRole', ':replaceThis') }}";
        url2 = url2.replace(':replaceThis', id);

        $.ajax({
            url: url2,
            method: 'GET',
            async: true,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#addUsersRoleForm input[name="id_role"]').val(id);
                $('#td_name').html(':&nbsp;&nbsp;'+data.detail.name);
                $('#td_display_name').html(':&nbsp;&nbsp;'+data.detail.display_name);
                $('#td_description').html(':&nbsp;&nbsp;'+data.detail.description);
                $('#td_is_internal').html(':&nbsp;&nbsp;'+data.detail.internalType);
                $('#td_count').html(':&nbsp;&nbsp;'+data.detail.totalCount);

                data.detail.availableUsers.forEach(function(user) {
                    $('#select2-multiple').append($('<option>', {
                        value: user.id,
                        text: user.name
                    }));
                });

                $('#select2-multiple').select2();

            },
        });

        var tableListUsers;

        tableListUsers = $('#table-list-users').DataTable().destroy();

        tableListUsers = $('#table-list-users').DataTable({
            orderCellsTop: true,
            colReorder: false,
            pageLength: 10,
            processing: true,
            serverSide: true, //enable if data is large (more than 50,000)
            ajax: {
                url: url,
                cache: false,
            },
            columns: [
                {
                    defaultContent: '',
                    orderable: false,
                    searchable: false,
                    className : "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "name",
                    name: "name",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: "no_ic",
                    name: "no_ic",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: "email",
                    name: "email",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: "phone_number",
                    name: "phone_number",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: "department_ministry",
                    name: "department_ministry",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: "skim",
                    name: "skim",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: "status",
                    name: "status",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },

            ],
            language : {
                emptyTable : "Tiada data tersedia",
                info : "Menunjukkan _START_ hingga _END_ daripada _TOTAL_ entri",
                infoEmpty : "Menunjukkan 0 hingga 0 daripada 0 entri",
                infoFiltered : "(Ditapis dari _MAX_ entri)",
                search : "Cari:",
                zeroRecords : "Tiada rekod yang ditemui",
                paginate : {
                    first : "Pertama",
                    last : "Terakhir",
                    next : "Seterusnya",
                    previous : "Sebelumnya"
                },
                lengthMenu : "Lihat _MENU_ entri",
            }
        });

        var viewUsersModal = new bootstrap.Modal(document.getElementById('viewUsersModal'), { keyboard: false});
        viewUsersModal.show();
    }

    function closeModal() {

        $('#td_name').html(':&nbsp;&nbsp;');
        $('#td_display_name').html(':&nbsp;&nbsp;');
        $('#td_description').html(':&nbsp;&nbsp;');
        $('#td_is_internal').html(':&nbsp;&nbsp;');
        $('#td_count').html(':&nbsp;&nbsp;');

        $('#table-list-users').DataTable().destroy();

        $("#table-list-users > tbody").html("");
    }

</script>
@endsection
