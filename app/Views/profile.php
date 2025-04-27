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
<div class="container-fluid row d-flex flex-column align-items-center" style="padding-top: 2.5rem; margin-bottom: 5rem;">
    <div class="col-md-8 d-flex flex-column align-items-center gap-4">
        <?= view('components/profile_photo') ?>
        <h2><span id="fist_name_display">Kristanto</span> <span id="last_name_display">Wibowo</span></h2>

        <div class="d-flex flex-column w-100 gap-2" id="registrasi-form">
                <div>
                    <?= view('components/form_input', $email) ?>
                    <?= view('components/form_input', $first_name) ?>
                    <?= view('components/form_input', $last_name) ?>
                </div>
                <a href="<?= base_url() ?>profile_edit"><button type="submit" class="registrasi btn w-100">Edit Profil</button></a>
                <button id="logout" type="submit" class="registrasi btn-inverse w-100">Logout</button>

        </div>
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