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

<div class="w-full h-min-screen flex flex-col items-center justify-center">
    <div class="w-full 3xl:max-w-[2000px] 3xl:max-h-[1080] h-min-screen grid grid-cols-1 md:grid-cols-2">
        <div class="w-full w-full grid grid-rows-1 grid-rows-1">
            <div class="flex flex-row justify-center items-center col-start-1 row-start-1 row-span-1 z-10 py-24">
                <div class="w-8/12 flex flex-col justify-center items-center gap-12">
                    <div class="w-full flex flex-row justify-center items-center gap-2 ">
                        <img 
                            src="<?= base_url() ?>assets/img/Logo.png" 
                            class="w-8" 
                            alt="Responsive image">
                        <p class="text-3xl font-semibold">SIMS PPOB</p>
                    </div>
                    <h2 class="text-center text-3xl font-semibold">Lengkapi data untuk </br>membuat akun</h2>

                    <form id="registrasi-form" class="w-full" method="POST">
                    <div class="flex flex-col gap-4">
                        <?php 
                            echo view('components/form_input', $email);
                            echo view('components/form_input', $first_name);
                            echo view('components/form_input', $last_name);
                            echo view('components/form_password', $password1);
                            echo view('components/form_password', $password2);
                        ?>
                    </div>
                    <button type="submit" class="w-full bg-red-500 text-white h-form cursor-pointer mt-8">Register</button>

                    </form>
                    <span class="">sudah punya akun? login <a href="<?= base_url('/login/') ?>" class="!text-red-500 no-underline font-semibold">di sini</a></span>
                    </div>
            </div>
            <div class="flex flex-col justify-end items-center row-start-1 row-end-1 col-start-1 col-end-1">
                <div class="w-10/12 mb-6 flex flex-row p-2 invisible bg-bg-err text-err" id="registrasi-feedback">
                    <span id="registrasi-feedback-msg">MESAAGE</span>
                    <span class="align-self-end"></span>
                </div>
            </div>
        </div>
        <div class="hidden md:block bg-yellow-100 hero-img">
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