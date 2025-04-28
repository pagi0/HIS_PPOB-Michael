<div class="w-full flex flex-col md:flex-row justify-between">
    <div class="grid grid-cols-4 gap-x-6 md:gap-x-0 md:flex md:flex-col py-4 ">
        <div id="profile-picture-group" class="col-span-1 grow relative md:w-26 md:pb-3">
            <div id="profile-picture" class="w-full aspect-square rounded-full overflow-hidden border border-gray-300 mb:mb-4">
                <img id="profile-img" class="h-full w-auto aspect-square object-cover rounded-full" src="<?= base_url() ?>assets/img/Profile Photo.png">
            </div>
        </div>
        <div class="col-span-3 md:block flex flex-col justify-end">
            <p class="text-2xl text-gray-600 mb-1">Selamat datang,</p>
            <div class="text-4xl font-semibold max-w-[300px] md:max-w[100px] lg:max-w-[400px] truncate">
                <span class="overflow-ellipsis" id="fist_name_display">Kristanto</span> 
                <span class="w-full overflow-ellipsis" id="last_name_display">Wibowo</span>
            </div>
        </div>
    </div>
    <div class="grow max-w-full md:max-w-7/12 mt-4 md:mt-0 grid grid-cols-1 grid-rows-1 align-center">
        <div class="flex flex-col justify-center items-start w-full h-full text-sm row-start-1 col-start-1 col-span-1 z-10 pl-8 text-white gap-1 md:gap-4">
            <p class="text-lg md:text-xl font-semibold">Saldo anda</p>
            <p class="text-xl md:text-5xl"><span>Rp </span>
                <input type="text" class="user-select-none text-like-input hidden" id="saldo" disabled></input>
                <input type="password" class="user-select-none text-like-input hidden" id="saldo-blur" value="******" disabled></input>
            </p>
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
    let balance = "";
    function toggle(type) {
        if (type=="text") {
            $('#saldo').removeClass('hidden');
            $('#saldo-blur').addClass('hidden');
            $('#lihat-saldo').addClass('hidden');
            $('#sembunyikan-saldo').removeClass('hidden');
        } else {
            $('#saldo').addClass('hidden');
            $('#saldo-blur').removeClass('hidden');
            $('#lihat-saldo').removeClass('hidden');
            $('#sembunyikan-saldo').addClass('hidden');
        }
    }
    $.ajax({
        url: '<?= get_api_base() ?>/profile',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
        },
        success: function(data) {
            //console.log(data);
            $("#fist_name_display").text(data.data.last_name);
            $("#last_name_display").text(data.data.first_name);
            if (data.data.profile_image != "https://minio.nutech-integrasi.com/take-home-test/null") {
                    $("#profile-img").attr("src", data.data.profile_image);
            }
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
            //console.log(data);
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
        toggle("text");
    })
    $('#sembunyikan-saldo').click(function () {
        let new_type = "password";
        sessionStorage.setItem('tampilSaldo', new_type)
        toggle("password");
    })
    $(document).ready(function() {
        let type = sessionStorage.getItem('tampilSaldo');
        if (type === null) {
            type = "password";
        }
        //console.log(type);
        toggle(type)

    })
</script>