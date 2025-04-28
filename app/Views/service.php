<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="w-10/12 flex flex-col items-center gap-4">

        <div class="w-full flex flex-col gap-2">
            <?= view('components/profile_widget'); ?>
            <p class="text-xl text-gray-600 mt-14">PemBayaran</p>
            <div class="flex flex-row justify-start items-center gap-2">
                <img id="service-icon" src="" alt="" width="30" height="30">
                <p class="text-2xl font-semibold" id="service-name">_</p>
            </div>
            <div class="w-full flex flex-row border border-gray-300 rounded-md h-form mt-10" id="topup-group">
                    <img 
                        src="<?= base_url()."assets/icon/credit_card.svg" ?>" 
                        class="material-symbols-outlined w-8 pl-4 brightness-200 invert">
                    <input type="text" 
                        class="w-full h-full border-0 px-4 focus:outline-none" 
                        id="nominal" 
                        name="nomial-value"
                        placeholder="nominal top up" 
                        value=0
                        readonly>
            </div>
            <button id="bayar" class="rounded-md w-full bg-red-500 text-white h-form cursor-pointer mt-4" >Bayar</button>
        </div>
    </div>

<?php 
    $beli_data = array(
        'container' => "beli-konfirmasi-container",
        'label' => array("id" => "beli-konfirmasi-label", "text" => ""),
        'nominal' => array("id" => "beli-konfirmasi-nominal", "text" => ""),
        'ok' => array("id" => "beli-konfirmasi-ok", "text" => "Ya, lanjutkan Bayar"),
        'no' => array("id" => "beli-konfirmasi-no", "text" => "Batalkan"),
    );

    $beli_feedback = array(
        array(
            'container' => "beli-feedback-ok-container",
            'label' => array("id" => "beli-feedback-ok-label", "text" => ""),
            'nominal' => array("id" => "beli-feedback-ok-nominal", "text" => ""),
            'close' => array("id" => "beli-feedback-ok-close", "text" => "Kembali ke Beranda"),
        ), 
        array(
            'container' => "beli-feedback-bo-container",
            'label' => array("id" => "beli-feedback-bo-label", "text" => ""),
            'nominal' => array("id" => "beli-feedback-bo-nominal", "text" => ""),
            'close' => array("id" => "beli-feedback-bo-close", "text" => "Kembali ke Beranda"),
        )
    );
    $status = 0;
?>
<?= view('components/popup_konfirmasi', $beli_data); ?>
<?= view('components/popup_berhasil', $beli_feedback[0]); ?>
<?= view('components/popup_gagal', $beli_feedback[1]); ?>
<script>
    $.ajax({
        url: '<?= get_api_base() ?>/services',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
        },
        success: function(data) {
            let services = data.data;
            let service_holder = $("#service-holder");
            let service_data = services.find((service) => service.service_code == "<?= $service ?>" );
            $('#service-name').text(service_data.service_name);
            $("#nominal").val(service_data.service_tariff);
            $("#service-icon").attr("src", service_data.service_icon);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
    $('#bayar').on('click', function(e) {
        e.preventDefault()
        $('#<?= $beli_data['container']?>').removeClass('hidden');
        $('#<?= $beli_data['label']['id']?>').text(`Pembelian ${$('#service-name').text().toLowerCase()} senilai`);
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($('#nominal').val())}`;
        $('#<?= $beli_data['nominal']['id']?>').text(format_total);
        $('#<?= $beli_data['ok']['id']?>').click(() => {
            $.ajax({
                url: '<?= get_api_base() ?>/transaction',
                type: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
                },
                data: JSON.stringify({
                    service_code: "<?= $service ?>",
                }),
                success: function(data) {
                    $('#<?= $beli_data['container']?>').addClass('hidden');
                    feedback_success();
                },
                error: function(xhr, status, error) {
                    $('#<?= $beli_data['container']?>').addClass('hidden');
                    feedback_failed();
                }
            })
        })
        $('#<?= $beli_data['no']['id']?>').click(() => {
            $('#<?= $beli_data['container'] ?>').addClass('hidden')
        })
    });
    function feedback_success($success) {
        $('#<?= $beli_feedback[0]['container'] ?>').removeClass('hidden')
        $('#<?= $beli_feedback[0]['close']['id']?>').click(() => {
            $('#<?= $beli_feedback[0]['container'] ?>').removeClass('hidden')
            $(location).attr('href', "<?= base_url() ?>dashboard");
        })
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($('#nominal').val())}`;
        $('#<?= $beli_feedback[0]['nominal']['id']?>').text(format_total);
        $('#<?= $beli_feedback[0]['label']['id']?>').text(`Pembelian ${$('#service-name').text().toLowerCase()} senilai`);
    }

    function feedback_failed() {
        $('#<?= $beli_feedback[1]['container'] ?>').removeClass('hidden')
        $('#<?= $beli_feedback[1]['close']['id']?>').click(() => {
            $('#<?= $beli_feedback[1]['container'] ?>').removeClass('hidden')
            $(location).attr('href', "<?= base_url() ?>dashboard");
        })
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($('#nominal').val())}`;
        $('#<?= $beli_feedback[1]['nominal']['id']?>').text(format_total);
        $('#<?= $beli_feedback[1]['label']['id']?>').text(`Pembelian ${$('#service-name').text().toLowerCase()} senilai`);
    }
</script>

<?= $this->endSection() ?>

