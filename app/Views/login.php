
<?= $this->extend('layouts/pre_main') ?>

<?php
    helper('global');
    $email = array(
            'api_name' => 'email',
            'icon' => 'alternate_email',
            'placeholder' => 'masukkan email anda',
            'readonly' => false,
    );
    $password = array(
            'api_name' => 'password',
            'icon' => 'lock',
            'placeholder' => 'masukkan password anda',
            'readonly' => false,
    );
?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row h-100">
        <div class="col-md-6 vh-100 d-flex flex-column align-items-center p-0">
            <div class="w-100 d-flex flex-column align-items-center" style="padding: 7rem 7rem 3rem 7rem">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <img 
                        src="<?= base_url() ?>assets/img/Logo.png" 
                        class="img-fluid" 
                        style="width: 2rem; height: 2rem"
                        alt="Responsive image">
                    <h3 class="m-0">SIMS PPOB</h3>
                </div>
                <h2 class="mb-4 text-center mb-5">Masuk atau buat akun</br>untuk memulai</h2>

                <form id="login-form" class="w-100" method="POST">
                <div>
                    <?php 
                        echo view('components/form_input', $email);
                        echo view('components/form_password', $password);
                    ?>
                </div>
                <button type="submit" class="registrasi btn w-100" style="margin-top: 2rem">Masuk</button>

                </form>
                <span class="mt-3">belum punya akun? registrasi <a href="<?= base_url('/registrasi/') ?>" style="color: red; text-decoration: none; font-weight: bold">di sini</a></span>
            </div>
            <div class="mt-auto w-80 d-flex flex-row invisible" id="login-feedback">
                <span id="login-feedback-msg"></span>
                <span class="align-self-end"></span>
            </div>
        </div>
        <div class="col-md-6 vh-100 p-0 overflow-hidden hero-img">
        </div>
    </div>
    
</div>

<script>
    $('#login-form').validate({
        rules: {
            <?= $email["api_name"]?>: {
                required: true,
                email: true,
            },
            <?= $password["api_name"]?>: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            <?= $email["api_name"] ?>: {
                required: "<?= $email["api_name"] ?> tidak boleh kosong",
                email: "tolong masukkan email yang valid",
            },
            <?= $password["api_name"] ?>: {
                required: "<?= $password["api_name"] ?> tidak boleh kosong",
                minlength: "<?= $password["api_name"] ?> minimal 8 karakter",
            },
        },
        errorPlacement: function (error, element) {
            $('#'+error.attr('id')).text(error.text());
            $('#'+error.attr('id')).removeClass('invisible');
        },
        success: function (label, element) {
            $('#'+label.attr('id')).text("_");
            $('#'+label.attr('id')).addClass('invisible');
        },
        submitHandler: function (form) {
            // form.submit(); // Uncomment this line to submit the form
            let data = {
                <?= $email["api_name"]?>: $('#<?= $email["api_name"]?>').val(),
                <?= $password["api_name"]?>: $('#<?= $password["api_name"]?>').val(),
            };
            const feedback = $('#login-feedback');
            $.ajax({
                url: "<?= get_api_base()?>/login",
                type: 'POST',
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                },
                success: function(data) {
                    console.log('Success:', data);
                    feedback.removeClass('invisible');
                    feedback.addClass('login-success');
                    feedback.removeClass('login-error')
                    feedback.get(0).scrollIntoView();
                    $('#login-feedback-msg').text(data.message);
                    localStorage.setItem('jwt_token', data.data.token);
                    setTimeout(() => {
                        $(location).attr('href', "<?= base_url() ?>dashboard");
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    const response = JSON.parse(xhr.responseText);
                    feedback.removeClass('invisible');
                    feedback.addClass('login-error');
                    feedback.removeClass('login-sucess');
                    feedback.get(0).scrollIntoView();
                    $('#login-feedback-msg').text(response.message);

                    console.log('Errorr:', response);
                    console.error('Error:', status, error);
                }
            });
        } 
    });

</script>
<?= $this->endSection() ?>