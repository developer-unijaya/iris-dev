<div class="card">
    <div class="card-header">
        <h4 class="card-title">Change Password</h4>
    </div>
    <hr>
    <form method="POST" action="{{ route('updatePassword') }}" refreshFunctionDivId="divChangePassword" data-refreshFunctionNameIfSuccess="resetInput" data-refreshFunctionName="resetOnlyCaptcha" data-swal="Password updated successfully.">
        @csrf
        <div class="card-body" id="divChangePassword">
            <p class="text-danger text-center">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                Minimum 8 characters long, mixed with uppercase, lowercase, symbol and number.
            </p>
            <table class="table" width="100%">
                <tr>
                    <td class="fw-bolder">Current Password: </td>
                    <td>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control" name="reset_password_old" id="reset_password_old" placeholder="············">
                            <span class="input-group-text cursor-pointer">
                                <i data-feather="eye"></i>
                            </span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bolder">New Password: </td>
                    <td>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control" name="reset_password_new" id="reset_password_new" placeholder="············">
                            <span class="input-group-text cursor-pointer">
                                <i data-feather="eye"></i>
                            </span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bolder">Retype New Password: </td>
                    <td>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control" name="reset_password_confirm" id="reset_password_confirm" placeholder="············">
                            <span class="input-group-text cursor-pointer">
                                <i data-feather="eye"></i>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bolder">
                        <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Masukkan Captcha">
                            <span class="input-group-text cursor-pointer" data-toggle="tooltip" title="Set Semula Captcha" id="reload_captcha">
                                <i data-feather="refresh-cw"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
            <button type="button" class="btn btn-success" onclick="generalFormSubmit(this);" id="change_password_button" hidden></button>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary" onclick="$('#change_password_button').trigger('click');">
                    <span class="align-middle d-sm-inline-block d-none">
                        Update Password
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">2-Step Verification</h4>
    </div>
    <hr>

    <div class="card-body">
        <table class="table" width="100%">
            <tr>
                <td class="fw-bolder">Through SMS (Phone Number): </td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control" required/>
                        <button class="btn btn-primary" type="button">
                            Verify
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="text-center fw-bolder">
                <td colspan="2">
                    <h4>or</h4>
                </td>
            </tr>

            <tr>
                <td class="fw-bolder">Using Email: </td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control" required/>
                        <button class="btn btn-primary" type="button">
                            Verify
                        </button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

@section('script')
<script>

    $('#reload_captcha').click(function() {
        $.ajax({
            method : "GET",
            url : "{{ route('reload.captcha') }}",
            success:function(data){
                $(".captcha span").html(data.captcha)
            }
        });
    });

    function resetInput(){
        var reset_password_old = document.getElementById('reset_password_old');
        var reset_password_new = document.getElementById('reset_password_new')
        var reset_password_confirm = document.getElementById('reset_password_confirm');
        var captcha = document.getElementById('captcha');

        reset_password_old.value = '';
        reset_password_new.value = '';
        reset_password_confirm.value = '';
        captcha.value = '';
    
        $.ajax({
            method : "GET",
            url : "{{ route('reload.captcha') }}",
            success:function(data){
                $(".captcha span").html(data.captcha)
            }
        });
    }

    function resetOnlyCaptcha(){
        var captcha = document.getElementById('captcha');
        captcha.value = '';
    
        $.ajax({
            method : "GET",
            url : "{{ route('reload.captcha') }}",
            success:function(data){
                $(".captcha span").html(data.captcha)
            }
        });
    }
</script>
@endsection