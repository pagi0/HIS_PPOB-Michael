<?= $this->extend('layouts/main') ?>

<?php
    $email = array(
            'api_name' => 'email',
            'icon' => 'alternate_email',
            'placeholder' => '',
            'label' => "Email",
            'readonly' => true,
    );
    $first_name = array(
            'api_name' => 'first_name',
            'icon' => 'person',
            'placeholder' => '',
            'label' => "Nama Depan",
            'readonly' => false,
    );
    $last_name = array(
            'api_name' => 'last_name',
            'icon' => 'person',
            'placeholder' => '',
            'label' => "Nama Belakang",
            'extra' => "elo",
            'readonly' => false,
    );
?>

<?= $this->section('content') ?>
<div class="w-full 3xl:max-w-[2000px] 3xl:max-h-[1080] h-min-screen mx-auto flex flex-col justify-center items-center pt-10 mb-20 gap-16 ">
    <div class="w-10/12 flex flex-col items-center gap-6">
        <?= view('components/profile_photo') ?>
        <p class="text-4xl font-semibold"><span id="fist_name_display">Kristanto</span> <span id="last_name_display">Wibowo</span></p>

        <div class="flex flex-col w-8/12 gap-2" id="registrasi-form">
                <div>
                    <?= view('components/form_input', $email) ?>
                    <?= view('components/form_input', $first_name) ?>
                    <?= view('components/form_input', $last_name) ?>
                </div>
                <button id="simpan" type="submit" class="rounded-md w-full bg-red-500 text-white h-form cursor-pointer mt-2">Simpan</button>

        </form>
    </div>
</div>

<script>
    $.ajax({
        url: '<?= get_api_base() ?>/profile',
        type: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
        },
        success: function(data) {
            console.log(data);
            $('#<?= $email['api_name'] ?>').val(data.data.email);
            $('#<?= $first_name['api_name'] ?>').val(data.data.first_name);
            $('#<?= $last_name['api_name'] ?>').val(data.data.last_name);
            $("#profile-img").attr("src", data.data.profile_image);
            $("#fist_name_display").text(data.data.last_name);
            $("#last_name_display").text(data.data.first_name);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $('#simpan').on('click', function() {
        $.ajax({
            url: '<?= get_api_base() ?>/profile/update',
            type: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
            },
            data: JSON.stringify({
                first_name: $('#<?= $first_name['api_name'] ?>').val(),
                last_name: $('#<?= $last_name['api_name'] ?>').val(),
            }),
            success: function(data) {
                console.log(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    })
</script>

<?= $this->endSection() ?>