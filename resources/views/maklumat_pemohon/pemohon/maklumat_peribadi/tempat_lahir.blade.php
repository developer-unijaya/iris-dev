<form 
id="tempatLahirForm"
action="{{ route('tempat-lahir.update') }}"
method="POST"
data-refreshFunctionName="reloadTimeline"
data-refreshFunctionNameIfSuccess="reloadTempatLahir" 
data-reloadPage="false">
@csrf
<div class="row">
    <input type="hidden" name="tempat_lahir_no_pengenalan" id="tempat_lahir_no_pengenalan" value="">
    <div class="col-sm-4 col-md-4 col-lg-4 mb-1">
        <label class="form-label">Tempat Lahir</label>
        <select class="select2 form-control" name="place_of_birth" id="place_of_birth" disabled>
            <option value=""></option>
            @foreach($states as $state)
            <option value="{{ $state->code }}">{{ $state->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-sm-4 col-md-4 col-lg-4 mb-1">
        <label class="form-label">Tempat Lahir Ayah</label>
        <select class="select2 form-control" name="father_place_of_birth" id="father_place_of_birth" disabled>
            <option value=""></option>
            @foreach($states as $state)
            <option value="{{ $state->code }}">{{ $state->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-sm-4 col-md-4 col-lg-4 mb-1">
        <label class="form-label">Tempat Lahir Ibu</label>
        <select class="select2 form-control" name="mother_place_of_birth" id="mother_place_of_birth" disabled>
            <option value=""></option>
            @foreach($states as $state)
            <option value="{{ $state->code }}">{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div id="button_action_tempat_lahir" style="display:none">
    <button type="button" id="btnEditTempatLahir" hidden onclick="generalFormSubmit(this);"></button>
    <div class="d-flex justify-content-end align-items-center my-1">
        <button type="button" class="btn btn-success float-right" onclick="$('#btnEditTempatLahir').trigger('click');">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</div>
</form>

<div class="card-footer">
    <div class="d-flex justify-content-end align-items-center my-1 ">
        <a class="me-3 text-danger" type="button" id="update_tempat_lahir" hidden onclick="editTempatLahir()">
            <i class="fa-regular fa-pen-to-square"></i>
            Kemaskini
        </a>
    </div>
</div>

<script>
    function editTempatLahir() {
        $('#tempatLahirForm select[name="place_of_birth"]').attr('disabled', false);
        $('#tempatLahirForm select[name="father_place_of_birth"]').attr('disabled', false);
        $('#tempatLahirForm select[name="mother_place_of_birth"]').attr('disabled', false);

        $("#button_action_tempat_lahir").attr("style", "display:block");
        //document.getElementById('button_action_tempat_lahir').style.display = 'block';
    }

    function reloadTempatLahir() {
        var no_pengenalan = $('#candidate_no_pengenalan').val();

        var reloadTempatLahirUrl = "{{ route('tempat-lahir.details', ':replaceThis') }}"
        reloadTempatLahirUrl = reloadTempatLahirUrl.replace(':replaceThis', no_pengenalan);
        $.ajax({
            url: reloadTempatLahirUrl,
            method: 'GET',
            async: true,
            success: function(data) {
                $('#tempatLahirForm select[name="place_of_birth"]').val(data.detail.place_of_birth).trigger('change');
                $('#tempatLahirForm select[name="father_place_of_birth"]').val(data.detail.father_place_of_birth).trigger('change');
                $('#tempatLahirForm select[name="mother_place_of_birth"]').val(data.detail.mother_place_of_birth).trigger('change');
            },
            error: function(data) {
                //
            }
        });
    }
</script>