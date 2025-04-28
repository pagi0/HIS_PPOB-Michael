<div class="w-full flex flex-row justify-between">
    <div class="flex flex-col py-4 ">
        <div id="profile-picture-group" class="grow relative w-40 p-0">
            <div id="profile-picture" class="w-full aspect-square rounded-full overflow-hidden border border-gray-300 mb-4">
                <img id="profile-img" class="h-full w-auto aspect-square object-cover rounded-full" src="<?= base_url() ?>assets/img/Profile Photo.png">
            </div>
        </div>
        <p class="text-xl text-gray-600">Selamat datang,</p>
        <p class="text-4xl"><span id="fist_name_display">Kristanto</span> <span id="last_name_display">Wibowo</span></p>
    </div>
    <div class="grow max-w-7/12 grid grid-cols-1 grid-rows-1 align-center">
        <div class="flex flex-col justify-center items-start w-full h-full row-start-1 col-start-1 z-10 pl-8 text-white gap-4">
            <p class="text-xl font-semibold">Saldo anda</p>
            <p class="text-5xl"><span>Rp </span><input type="password" class="user-select-none text-like-input" id="saldo" disabled></input></p>
            <p id="lihat-saldo" class="cursor-pointer hidden">Lihat saldo <img class="inline white-svg" src="<?= base_url() ?>assets/icon/visibility.svg" width="15"></p>
            <span id="sembunyikan-saldo" class="clickable hidden">Sembunyikan saldo <img class="inline white-svg" src="<?= base_url() ?>assets/icon/visibility_off.svg" width="15"></span>
        </div>  
        <div class="flex flex-col w-full h-full row-start-1 col-start-1 row-span-1 justify-center">
                <img src="<?= base_url() ?>/assets/img/Background Saldo.png" class="object-cover z-0">
        </div>  
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
        $('#lihat-saldo').addClass('hidden');
        $('#sembunyikan-saldo').removeClass('hidden');
    })
    $('#sembunyikan-saldo').click(function () {
        let new_type = "password";
        sessionStorage.setItem('tampilSaldo', new_type)
        $('#saldo').attr('type', new_type);
        $('#lihat-saldo').removeClass('hidden');
        $('#sembunyikan-saldo').addClass('hidden');
    })
    $(document).ready(function() {
        let type = sessionStorage.getItem('tampilSaldo');
        if (type === null) {
            type = "password";
        }
        $('#saldo').attr('type', type);
        console.log(type);
        if (type == "text") {
            $('#lihat-saldo').addClass('hidden');
            $('#sembunyikan-saldo').removeClass('hidden');
        } else {
            $('#lihat-saldo').removeClass('hidden');
            $('#sembunyikan-saldo').addClass('hidden');
        }
    })
</script>