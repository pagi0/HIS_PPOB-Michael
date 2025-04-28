
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

<div class="w-full h-screen flex flex-col items-center justify-center">
    <div class="w-full 3xl:max-w-[2000px] 3xl:max-h-[1080] h-screen grid grid-cols-1 md:grid-cols-2">
        <div class="w-full w-full grid grid-rows-1 grid-cols-1">
            <div class="flex flex-row justify-center items-center col-start-1 row-start-1 row-span-1 z-10">
                <div class="w-8/12 flex flex-col justify-center items-center gap-12">
                    <div class="w-full flex flex-row justify-center items-center gap-2 ">
                        <img 
                            src="<?= base_url() ?>assets/img/Logo.png" 
                            class="w-8" 
                            alt="Responsive image">
                        <p class="text-3xl font-semibold">SIMS PPOB</p>
                    </div>
                    <h2 class="text-center text-3xl font-semibold">Masuk atau buat akun</br>untuk memulai</h2>

                    <form id="login-form" class="w-full" method="POST">
                    <div class="flex flex-col gap-4"  >
                        <?php 
                            echo view('components/form_input', $email);
                            echo view('components/form_password', $password);
                        ?>
                    </div>
                    <button type="submit" class="rounded-md w-full bg-red-500 text-white h-form cursor-pointer mt-8">Masuk</button>

                    </form>
                    <span class="">belum punya akun? registrasi <a href="<?= base_url('/registrasi/') ?>" class="!text-red-500 no-underline font-semibold">di sini</a></span>
                </div>
            </div>
            <div class="flex flex-col justify-end items-center row-start-1 row-end-1 col-start-1 col-end-1">
                <div class="w-10/12 mb-6 flex flex-row p-2 invisible bg-bg-err text-err" id="login-feedback">
                    <span id="login-feedback-msg">MESAAGE</span>
                    <span class="align-self-end"></span>
                </div>
            </div>
        </div>
        <div class="hidden md:block bg-yellow-100 hero-img">
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
            $('#'+error.attr('id').replace('error', 'group')).addClass('border-red-500');
        },
        success: function (label, element) {
            $('#'+label.attr('id')).text("_");
            $('#'+label.attr('id')).addClass('invisible');
            $('#'+label.attr('id').replace('error', 'group')).removeClass('border-red-500');
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
                    feedback.addClass('bg-bg-ok text-ok');
                    feedback.removeClass('bg-bg-err text-err')
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
                    
                    feedback.addClass("bg-bg-err text-err");
                    feedback.removeClass("bg-bg-ok text-ok")
                    feedback.get(0).scrollIntoView();
                    $('#login-feedback-msg').text(response.message);

                    console.log('Errorr:', response);
                }
            });
        } 
    });

</script>
<?= $this->endSection() ?>