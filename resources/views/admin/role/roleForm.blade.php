<div class="modal fade text-start" id="roleFormModal" tabindex="-1" aria-labelledby="title-role" aria-hidden="true" data-bs-backdrop="false" style="background:rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-role">Tambah Peranan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Horizontal Wizard -->
                <section class="horizontal-wizard">
                <form action="{{ route('role.store') }}" method="POST" id="roleForm" data-reloadPage="true">
                <div class="bs-stepper horizontal-wizard-example">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#role-details" role="tab" id="role-details-trigger">
                            <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">1</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Maklumat Peranan</span>
                                <span class="bs-stepper-subtitle">dan Akses Level Peranan</span>
                            </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#menu-one" role="tab" id="menu-one-trigger">
                            <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Menu [Level 1]</span>
                            </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#menu-two" role="tab" id="menu-two-trigger">
                            <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Menu [Level 2]</span>
                            </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#menu-three" role="tab" id="menu-three-trigger">
                            <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">4</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Menu [Level 3]</span>
                            </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div id="role-details" class="content" role="tabpanel" aria-labelledby="role-details-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Maklumat Peranan</h5>
                            </div>

                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="role_name">Nama <span class="text text-danger">*</span> </label>
                                        <div class="input-group">
                                            <input type="text" id="role_name" name="role_name" value="" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="role_description">Ringkasan Peranan <span class="text text-danger">*</span> </label>
                                        <div class="input-group">
                                            <textarea class="form-control" rows = 4 name="role_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="role_display">Nama Paparan <span class="text text-danger">*</span> </label>
                                        <div class="input-group">
                                            <input type="text" id="role_display" class="form-control" name="role_display" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="role_level">Jenis Peranan <span class="text text-danger">*</span> </label>
                                        <select id="role_level" class="form-select select2" name="role_level" required>
                                            <option value=""></option>
                                            <option value="1">Peranan Dalaman</option>
                                            <option value="0">Peranan Luaran</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="access_function">Fungsi Capaian Akses<span class="text text-danger">*</span> </label>
                                        <select id="access_function" class="select2 form-select" name="access_function[]" required multiple>
                                            @foreach($masterFunction as $function)
                                            <option value="{{ $function->id }}">{{ $function->code." - ".$function->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-secondary btn-prev" type="button" disabled>
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-primary btn-next" type="button">
                                <span class="align-middle d-sm-inline-block d-none">Seterusnya</span>
                                <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                            </div>
                        </div>
                        <div id="menu-one" class="content" role="tabpanel" aria-labelledby="menu-one-trigger">
                            <div class="content-header">
                            <h5 class="mb-0">Menu [Level 1]</h5>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="level_one">Menu</label>
                                    <select id="level_one" class="select2 form-select" name="level_one[]" multiple onchange="showListMenu('one')">
                                        @foreach($securityMenu as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="table-responsive" id="div-table-one">
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-prev" type="button">
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-primary btn-next" type="button" id="next_two" onclick="showNextMenu('two', 'one')">
                                <span class="align-middle d-sm-inline-block d-none">Seterusnya</span>
                                <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                            </div>
                        </div>
                        <div id="menu-two" class="content" role="tabpanel" aria-labelledby="menu-two-trigger">
                            <div class="content-header">
                            <h5 class="mb-0">Menu [Level 2]</h5>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="level_two">Menu</label>
                                    <select id="level_two" class="select2 form-select" name="level_two[]" multiple onchange="showListMenu('two')">

                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="table-responsive" id="div-table-two">
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-prev" type="button">
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-primary btn-next" type="button" id="next_three" onclick="showNextMenu('three', 'two')">
                                <span class="align-middle d-sm-inline-block d-none">Seterusnya</span>
                                <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                            </div>
                        </div>
                        <div id="menu-three" class="content" role="tabpanel" aria-labelledby="menu-three-trigger">
                            <div class="content-header">
                            <h5 class="mb-0">Menu [Level 3]</h5>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="level_three">Menu</label>
                                    <select id="level_three" class="select2 form-select" name="level_three[]" multiple onchange="showListMenu('three')">

                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="table-responsive" id="div-table-three">
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-prev" type="button">
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-success btn-submit" id="btn_fake" type="button" onclick="$('#btn_submit').trigger('click');">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="btn_submit" hidden onclick="generalFormSubmit(this);"></button>
                </section>
                </form>
                <!-- /Horizontal Wizard -->
            </div>
        </div>
    </div>
</div>
<script>
    function showListMenu(level, id = null) {
        var value = $('#level_'+level).val();

        $.ajax({
            url: "{{ route('role.getMenu') }}",
            method: "POST",
            data : {
                menu_id : value,
                level : level,
                role_id : id,
            },
            success: function(response) {
                $('#div-table-'+level).html('');
                $('#div-table-'+level).html(response);
            },
            error: function(response) {
                // toastr.error('failed');
            }
        });
    }

    function showNextMenu(nextLevel, currentLevel, id = null) {
        var selectedMenu =  $('#level_'+currentLevel).val();

        $.ajax({
            url: "{{ route('role.getNextMenu') }}",
            method: "POST",
            data : {
                menu_id : selectedMenu,
                level : nextLevel,
                role_id : id,
            },
            success: function(response) {
                $('#level_'+nextLevel).empty();
                $('#level_'+nextLevel).append(response);
            },
            error: function(response) {
                // toastr.error('failed');
            }
        });
    }
</script>
