<div class="row col-md-12 widget">
    <div class="col-md-5 d-flex flex-column widget-profile p-0">
        <div id="profile-picture-group" class="profile-picture-group p-0" style="width: 5rem">
            <div id="profile-picture" class="profile-picture mb-4">
                <img id="profile-img" class="profile-img" src="<?= base_url() ?>assets/img/Profile Photo.png">
            </div>
        </div>
        <h5 class="mb-0" style="color: grey">Selamat datang,</h5>
        <h1 class="mt-0"><span id="fist_name_display">Kristanto</span> <span id="last_name_display">Wibowo</span></h1>
    </div>
    <div class="col-md-7 d-flex flex-column widget-saldo py-5 px-4">
        <h5 style="font-size: 1.2rem;">Saldo anda</h5>
        <h1><span>Rp </span><input type="password" class="user-select-none text-like-input" id="saldo" disabled></input></h3>
        <span id="lihat-saldo" class="clickable d-none">Lihat saldo <img class="white-svg" src="<?= base_url() ?>assets/icon/visibility.svg" width="15"></span>
        <span id="sembunyikan-saldo" class="clickable d-none">Sembunyikan saldo <img class="white-svg" src="<?= base_url() ?>assets/icon/visibility_off.svg" width="15"></span>

    </div>
</div>

<?php helper('global'); ?>

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
            $("#fist_name_display").text(data.data.last_name);
            $("#last_name_display").text(data.data.first_name);
            $("#profile-img").attr("src", data.data.profile_image);
        },
        error: function(xhr, status, error) {
            let response = JSON.parse(xhr.responseText);
            console.error(response);
        }
    })
    $.ajax({
        url: '<?= get_api_base() ?>/balance',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
        },
        success: function(data) {
            console.log(data);
            let format_total = new Intl.NumberFormat('id-ID').format(data.data.balance)
            $("#saldo").val(format_total);
        },
        error: function(xhr, status, error) {
            let response = JSON.parse(xhr.responseText);
            console.error(response);
        }
    })
    $('#lihat-saldo').click(function () {
        let new_type = "text";
        sessionStorage.setItem('tampilSaldo', new_type)
        $('#saldo').attr('type', new_type);
        $('#lihat-saldo').addClass('d-none');
        $('#sembunyikan-saldo').removeClass('d-none');
    })
    $('#sembunyikan-saldo').click(function () {
        let new_type = "password";
        sessionStorage.setItem('tampilSaldo', new_type)
        $('#saldo').attr('type', new_type);
        $('#lihat-saldo').removeClass('d-none');
        $('#sembunyikan-saldo').addClass('d-none');
    })
    $(document).ready(function() {
        let type = sessionStorage.getItem('tampilSaldo');
        if (type === null) {
            type = "password";
        }
        $('#saldo').attr('type', type);
        console.log(type);
        if (type == "text") {
            $('#lihat-saldo').addClass('d-none');
            $('#sembunyikan-saldo').removeClass('d-none');
        } else {
            $('#lihat-saldo').removeClass('d-none');
            $('#sembunyikan-saldo').addClass('d-none');
        }
    })
</script>