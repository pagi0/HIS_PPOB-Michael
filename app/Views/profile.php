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
            'readonly' => true,
    );
    $last_name = array(
            'api_name' => 'last_name',
            'icon' => 'person',
            'placeholder' => '',
            'label' => "Nama Belakang",
            'readonly' => true,
    );
?>

<?= $this->section('content') ?>

    <div class="w-10/12 flex flex-col items-center gap-6">
        <?= view('components/profile_photo') ?>
        <p class="text-4xl font-semibold"><span id="fist_name_display">Kristanto</span> <span id="last_name_display">Wibowo</span></p>

        <div class="flex flex-col w-8/12 gap-2" id="registrasi-form">
                <div>
                    <?= view('components/form_input', $email) ?>
                    <?= view('components/form_input', $first_name) ?>
                    <?= view('components/form_input', $last_name) ?>
                </div>
                <a href="<?= base_url() ?>profile_edit"><button type="submit" class="rounded-md w-full bg-red-500 text-white h-form cursor-pointer mt-2">Edit Profil</button></a>
                <button id="logout" type="submit" class="rounded-md w-full text-red-500 border border-red-500 bg-white h-form cursor-pointer mt-6">Logout</button>

        </div>
    </div>

<script>
    $.ajax({
        url: '<?= get_api_base() ?>/profile',
        type: 'GET',
        dataType: 'json',
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
            $(location).attr('href', "<?= base_url() ?>login");
            console.error(error);
        }
    });
    $('#logout').on('click', function() {
        localStorage.removeItem('jwt_token');
        $(location).attr('href', "<?= base_url() ?>login");
    })
</script>

<?= $this->endSection() ?>