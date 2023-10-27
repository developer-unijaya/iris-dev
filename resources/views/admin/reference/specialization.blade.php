@extends('layouts.app')

@section('header')
    Pengkhususan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('msg.home')}}</a></li>
    <li class="breadcrumb-item"><a>Pengkhususan</a>
    </li>
@endsection

@section('content')
<style>
    #table-specialization thead th {
        vertical-align: middle;
        text-align: center;
    }

    #table-specialization tbody {
        vertical-align: middle;
        /* text-align: center; */
    }

    #table-specialization {
        width: 100% !important;
        /* word-wrap: break-word; */
    }

    input[readonly] {
            pointer-events: none;
            /* Disable pointer events */
            background-color: #f0f0f0;
            /* Change background color */
            color: #666;
            /* Change text color */
            border: 1px solid #ccc;
            /* Change border color */
        }

</style>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Senarai Pengkhususan</h4>
        @if($accessAdd)
        <button type="button" class="btn btn-primary btn-md float-right" onclick="specializationForm()">
            <i class="fa-solid fa-add"></i> Tambah Pengkhususan
        </button>
        @endif
    </div>
    <hr>
    <div class="card-body">
        <form id="form-search" role="form" autocomplete="off" method="post" action="" class="mb-4" novalidate>
            <div class="row align-items-center">
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <label class="form-label" for="code">Carian Bidang</label>
                    <select name="activity_type_id" id="activity_type_id" class="select2 form-control">
                        <option value="Lihat Semua" selected>Lihat Semua</option>
                        @foreach ($bidang as $bid)
                        <option value="{{ $bid->kod }}">{{ $bid->kod }} - {{ $bid->diskripsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <label class="form-label" for="code">Carian Jenis</label>
                    <select name="module_id" id="module_id" class="select2 form-control">
                        <option value="Lihat Semua" selected>Sila Pilih:-</option>
                    </select>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 mt-2">
                    <button type="submit" class="btn btn-success">
                      <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div class="table-responsive">
            <table class="table header_uppercase table-bordered" id="table-specialization">
                <thead>
                    <tr>
                        <th width="2%">No.</th>
                        <th width="10%">Kod</th>
                        <th>Nama Pengkhususan</th>
                        <th width="10%">Jenis</th>
                        <th width="10%">Bidang</th>
                        <th width="10%">Tindakan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('admin.reference.specializationForm')

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#activity_type_id').change(function() {
            var parentCategory = $(this).val();
            if(parentCategory && parentCategory!= "Lihat Semua") {
                $.ajax({
                    url: "{{ route('admin.reference.specialization.getChild') }}",
                    type: 'GET',
                    data: {parent_category: parentCategory},
                    dataType: 'json',
                    success: function(data) {
                        $('#module_id').empty();
                        $('#module_id').append('<option value="Lihat Semua" selected>Lihat Semua</option>');
                        $.each(data, function(key, value) {
                            $('#module_id').append('<option value="'+ value.codes +'">'+value.codes +' - '+ value.categories +'</option>');
                        });
                    }
                });
            }else{
                $('#module_id').empty();
            }
        });
    });
    $(document).ready(function() {
        $('#field').change(function() {
            var parentCategory = $(this).val();
            if(parentCategory && parentCategory!= "Lihat Semua") {
                $.ajax({
                    url: "{{ route('admin.reference.specialization.getChild') }}",
                    type: 'GET',
                    data: {parent_category: parentCategory},
                    dataType: 'json',
                    success: function(data) {
                        $('#type').empty();
                        $('#type').append('<option value="" selected>Sila Pilih:-</option>');
                        $.each(data, function(key, value) {
                            $('#type').append('<option value="'+ value.codes +'">'+ value.categories +'</option>');
                        });
                        $('#specializationForm select[name="type"]').val($('#specializationForm input[name="temp"]').val()).trigger('change');
                    }
                });
            }else{
                $('#type').empty();
                $('#type').append('<option value="" selected>Sila Pilih:-</option>');
            }
        });
    });
    var table = $('#table-specialization').DataTable({
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
                data: "code",
                name: "code",
                className : "text-center",
                render: function(data, type, row) {
                    return $("<div/>").html(data).text();
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
                data: "type",
                name: "type",
                render: function(data, type, row) {
                    return $("<div/>").html(data).text();
                }
            },
            {
                data: "field",
                name: "field",
                render: function(data, type, row) {
                    return $("<div/>").html(data).text();
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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

    $('body').on('submit','#form-search',function(e){

        e.preventDefault();

        var form = $("#form-search");

        if(!form.valid()){
            return false;
        }
        var table;

        table = $('#table-specialization').DataTable().destroy();

        var table = $('#table-specialization').DataTable({
            orderCellsTop: true,
            colReorder: false,
            pageLength: 25,
            processing: true,
            serverSide: true, //enable if data is large (more than 50,000)
            deferRender: true,
            ajax: form.attr('action')+"?"+form.serialize(),
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
                    data: "code",
                    name: "code",
                    className : "text-center",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
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
                    data: "type",
                    name: "type",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: "field",
                    name: "field",
                    render: function(data, type, row) {
                        return $("<div/>").html(data).text();
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
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
        });

    specializationForm = function(id = null){
        var specializationFormModal;
        specializationFormModal = new bootstrap.Modal(document.getElementById('specializationFormModal'), { keyboard: false});

        var accessAdd = '{{ $accessAdd }}';
        var accessUpdate = '{{ $accessUpdate }}';

        event.preventDefault();
        if(id === null){
            $('#specializationForm').attr('action', '{{ route("admin.reference.specialization.store") }}');
            $('#specializationForm input[name="code"]').val("");
            $('#specializationForm input[name="name"]').val("");
            $('#specializationForm select[name="type"]').val("").trigger('change');
            $('#specializationForm select[name="field"]').val("").trigger('change');
            $('#specializationForm input[name="code"]').prop('readonly', false);

            $('#title-role').html('Tambah Pengkhususan');

            if(accessAdd == ''){
                $('#btn_fake').attr('hidden', true);
            } else if (accessAdd != ''){
                $('#btn_fake').attr('hidden', false);
            }

            specializationFormModal.show();
        }else{
            url = "{{ route('admin.reference.specialization.edit', ':replaceThis') }}"
            url = url.replace(':replaceThis', id);
            $.ajax({
                url: url,
                method: 'GET',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    // console.log(data);
                    specialization_id = data.detail.id;
                    // console.log(id_used);
                    url2 = "{{ route('admin.reference.specialization.update',':replaceThis') }}"
                    url2 = url2.replace(':replaceThis', specialization_id);

                    $('#specializationForm').attr('action',url2 );
                    $('#specializationForm input[name="code"]').val(data.detail.kod);
                    $('#specializationForm input[name="name"]').val(data.detail.diskripsi);
                    $('#specializationForm input[name="temp"]').val(data.detail.jenis);
                    $('#specializationForm select[name="type"]').val(data.detail.jenis).trigger('change');
                    $('#specializationForm select[name="field"]').val(data.detail.bidang).trigger('change');
                    $('#specializationForm input[name="code"]').prop('readonly', true);


                    $('#title-role').html('Kemaskini Pengkhususan');

                    if(accessUpdate == ''){
                        $('#btn_fake').attr('hidden', true);
                    } else if (accessUpdate != ''){
                        $('#btn_fake').attr('hidden', false);
                    }

                    specializationFormModal.show();
                },
            });
        }
    };

    function toggleActive(specializationId) {
            var url = "{{ route('admin.reference.specialization.toggleActive', ':replaceThis') }}"
            url = url.replace(':replaceThis', specializationId);

            $.ajax({
                url: url,
                method: 'POST',
                success: function(data) {
                    if (data.success) {
                        // Toggle the button class and icon
                        var button = document.querySelector('[data-id="' + specializationId + '"]');
                        button.classList.toggle('activate');
                        button.classList.toggle('deactivate');

                        // Toggle the icon
                        var icon = button.querySelector('i');
                        if (icon.classList.contains('fa-toggle-on')) {
                            icon.classList.replace('fa-toggle-on', 'fa-toggle-off');
                            icon.classList.replace('text-success', 'text-danger');
                        } else {
                            icon.classList.replace('fa-toggle-off', 'fa-toggle-on');
                            icon.classList.replace('text-danger', 'text-success');
                        }
                    } else {
                        alert('Error toggling active state');
                    }
                },
                error: function(error) {
                    console.error('Error toggling active state:', error);
                }
            });
        }

        function deleteItem(specializationId){
        var url = "{{ route('admin.reference.specialization.delete', ':replaceThis') }}"
        url = url.replace(':replaceThis', specializationId);

        Swal.fire({
            title: 'Adakah anda ingin hapuskan maklumat ini?',
            showCancelButton: true,
            confirmButtonText: 'Sahkan',
            cancelButtonText: 'Batal',
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    async: true,
                    success: function(data){
                        table.draw();
                    }
                })
            }
        })

        }

</script>
@endsection
