<?= $this->extend('layouts/pre_main') ?>

<?php
    helper('global');
    $email = array(
            'api_name' => 'email',
            'icon' => 'alternate_email',
            'placeholder' => 'masukan email anda',
            'readonly' => false,
    );
    $first_name = array(
            'api_name' => 'first_name',
            'icon' => 'person',
            'placeholder' => 'nama depan',
            'readonly' => false,
    );
    $last_name = array(
            'api_name' => 'last_name',
            'icon' => 'person',
            'placeholder' => 'nama belakang',
            'readonly' => false,
    );
    $password1 = array(
            'api_name' => 'password',
            'icon' => 'lock',
            'placeholder' => 'buat password',
            'readonly' => false,
    );
    $password2 = array(
            'api_name' => 'konfirmasi',
            'icon' => 'lock',
            'placeholder' => 'konfirmasi password',
            'type' => 'password',
            'readonly' => false,
    );
?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row h-100">
        <div class="col-md-6 d-flex flex-column align-items-center" style="padding: 7rem">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <img 
                        src="<?= base_url() ?>assets/img/Logo.png" 
                        class="img-fluid" 
                        style="width: 2rem; height: 2rem"
                        alt="Responsive image">
                    <h3 class="m-0">SIMS PPOB</h3>
                </div>
                <h2 class="mb-4 text-center mb-5">Lengkapi data untuk </br>membuat akun</h2>

                <form action="register_process.php" id="registrasi-form" class="w-100" method="POST">
                <div>
                    <?php 
                        echo view('components/form_input', $email);
                        echo view('components/form_input', $first_name);
                        echo view('components/form_input', $last_name);
                        echo view('components/form_password', $password1);
                        echo view('components/form_password', $password2);
                    ?>
                </div>
                <button type="submit" class="registrasi btn w-100" style="margin-top: 2rem">Register</button>

                </form>
                <span class="mt-3">sudah punya akun? login <a href="<?= base_url('/login/') ?>" style="color: red; text-decoration: none; font-weight: bold">di sini</a></span>

                <div class="mt-auto w-80 d-flex flex-row invisible" id="registrasi-feedback">
                    <span id="registrasi-feedback-msg"></span>
                </div>
        </div>
        <div class="col-md-6 p-0">
            <img src="<?= base_url() ?>assets/img/Illustrasi Login.png" class="img-fluid w-100" alt="Responsive image">
        </div>
    </div>
    
</div>

<script>
    $('#registrasi-form').validate({
        rules: {
            <?= $email["api_name"]?>: {
                required: true,
                email: true,
            },
            <?= $first_name["api_name"]?>: {
                required: true,
            },
            <?= $last_name["api_name"]?>: {
                required: true,
            },
            <?= $password1["api_name"]?>: {
                required: true,
                minlength: 8
            },
            <?= $password2["api_name"]?>: {
                required: true,
                minlength: 8,
                equalTo: "#<?= $password1["api_name"]?>"
            }
        },
        messages: {
            <?= $email["api_name"] ?>: {
                required: "<?= $email["api_name"] ?> tidak boleh kosong",
                email: "tolong masukkan email yang valid",
            },
            <?= $first_name["api_name"] ?>: {
                required: "nama depan tidak boleh kosong",
            },
            <?= $last_name["api_name"] ?>: {
                required: "nama belakang tidak boleh kosong",
            },
            <?= $password1["api_name"] ?>: {
                required: "<?= $password1["api_name"] ?> tidak boleh kosong",
                minlength: "<?= $password1["api_name"] ?> minimal 8 karakter",
            },
            <?= $password2["api_name"] ?>: {
                required: "<?= $password1["api_name"] ?> tidak boleh kosong",
                minlength: "<?= $password1["api_name"] ?> minimal 8 karakter",
                equalTo: "<?= $password1["api_name"] ?> tidak sama",
            }
        },
        errorPlacement: function (error, element) {
            $('#'+error.attr('id')).text(error.text());
            $('#'+error.attr('id')).removeClass('invisible');
            $('#'+error.attr('id').replace("error", "group")).addClass('form-salah');
        },
        success: function (label, element) {
            $('#'+label.attr('id')).text("_");
            $('#'+label.attr('id')).addClass('invisible');
            $('#'+label.attr('id').replace("-error", "")+"-group").removeClass('form-salah');
        },
        submitHandler: function (form) {

            let data = {
                <?= $email["api_name"]?>: $('#<?= $email["api_name"]?>').val(),
                <?= $first_name["api_name"]?>: $('#<?= $first_name["api_name"]?>').val(),   
                <?= $last_name["api_name"]?>: $('#<?= $last_name["api_name"]?>').val(),
                <?= $password1["api_name"]?>: $('#<?= $password1["api_name"]?>').val(),
            };
            console.log(data);
            const feedback = $('#registrasi-feedback');
            $.ajax({
                url: "<?= get_api_base()?>/registration",
                type: 'POST',
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    console.log('Success:', data);
                    feedback.removeClass('invisible');
                    feedback.addClass('login-success');
                    feedback.removeClass('login-error')
                    feedback.get(0).scrollIntoView();
                    $('#registrasi-feedback-msg').text(data.message);
                    form.reset();
                },
                error: function(xhr, status, error) {
                    const response = JSON.parse(xhr.responseText);
                    feedback.removeClass('invisible');
                    feedback.addClass('login-error');
                    feedback.removeClass('login-sucess');
                    feedback.get(0).scrollIntoView();
                    $('#registrasi-feedback-msg').text(response.message);

                    console.log('Errorr:', response);
                }
            });
        } 
    });


</script>
<?= $this->endSection() ?>