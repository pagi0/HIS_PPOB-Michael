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
    <div class="w-10/12 flex flex-col items-center gap-6">
        <?= view('components/profile_photo') ?>

        <div class="text-4xl font-semibold max-w-[300px] md:max-w[100px] lg:max-w-[400px] truncate">
            <span class="overflow-ellipsis" id="fist_name_display">Kristanto</span> 
            <span class="w-full overflow-ellipsis" id="last_name_display">Wibowo</span>
        </div>

        <div class="flex flex-col w-8/12 gap-2" id="registrasi-form">
                <form id="edit-form">
                    <?= view('components/form_input', $email) ?>
                    <?= view('components/form_input', $first_name) ?>
                    <?= view('components/form_input', $last_name) ?>
                </form>
                <button id="simpan" type="submit" class="rounded-md w-full bg-red-500 text-white h-form cursor-pointer mt-2">Simpan</button>

        </form>
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
            if (data.data.profile_image != "https://minio.nutech-integrasi.com/take-home-test/null") {
                    $("#profile-img").attr("src", data.data.profile_image);
            }
            $("#fist_name_display").text(data.data.last_name);
            $("#last_name_display").text(data.data.first_name);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $('#edit-form').validate({
        rules: {
            <?= $first_name["api_name"]?>: {
                required: true,
            },
            <?= $last_name["api_name"]?>: {
                required: true,
            },
        },
        messages: {
            <?= $first_name["api_name"] ?>: {
                required: "nama depan tidak boleh kosong",
            },
            <?= $last_name["api_name"] ?>: {
                required: "nama belakang tidak boleh kosong",
            },
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
        }
    });

    $('#simpan').on('click', function() {
        if (!$('#edit-form').valid()) {
            return
        }
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