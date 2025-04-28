<?= $this->extend('layouts/main') ?>

<?php
    $suggestion = array(
        10000, 20000, 50000, 100000, 250000, 500000
    )
?>

<?= $this->section('content') ?>

    <div class="w-10/12 flex flex-col items-center gap-4">

        <div class="w-full flex flex-col gap-2">
            <?= view('components/profile_widget'); ?>
            <p class="text-2xl mt-10">Silahkan masukkan</p>
            <p class="text-4xl font-semibold">Nominal Top Up</p>
            <div class="w-full grid grid-cols-8 gap-4 mt-10">
                <div class="col-start-1 col-span-full md:col-span-5">
                    <div class="w-full flex flex-row border border-gray-300 rounded-md h-form" id="topup-group">
                            <img 
                                src="<?= base_url()."assets/icon/credit_card.svg" ?>" 
                                class="material-symbols-outlined w-8 pl-4 brightness-200 invert">
                            <form id="topup-form" class="flex-grow-1 w-full">
                                <input type="text" 
                                    class="w-full h-full border-0 px-4 focus:outline-none" 
                                    id="topup-value" 
                                    name="topup_value"
                                    placeholder="nominal top up"
                                    value=0>
                            </form>
                    </div>
                    <span id="topup-err" class="self-end text-red-500 invisible">error</span>
                    <button id="topup-btn" class="rounded-md w-full bg-red-500 text-white h-form cursor-pointer mt-4" style="margin-top: 2px">Top Up</button>
                </div>
                <div class="hidden col-start-6 col-span-3 md:grid grid-cols-3 gap-y-6 gap-x-3">
                        <?php 
                            for ($idx = 0; $idx < sizeof($suggestion); $idx++) {
                                echo '
                                    <div id="suggestion-'.$suggestion[$idx].'" class=" w-full h-full topup-suggestion border border-gray-300 text-black rounded-md flex justify-center items-center cursor-pointer" data-val="'.$suggestion[$idx].'"></div>
                                ';
                            }
                        ?>
                </div>
            </div>
        </div>
    </div>

<?php 

    $topup_data = array(
        'container' => "topup-konfirmasi-container",
        'label' => array("id" => "topup-konfirmasi-label", "text" => ""),
        'nominal' => array("id" => "topup-konfirmasi-nominal", "text" => ""),
        'ok' => array("id" => "topup-konfirmasi-ok", "text" => "Ya, lanjutkan Top Up"),
        'no' => array("id" => "topup-konfirmasi-no", "text" => "Batalkan"),
    );

    $beli_feedback = array(
        array(
            'container' => "topup-feedback-ok-container",
            'label' => array("id" => "topup-feedback-ok-label", "text" => ""),
            'nominal' => array("id" => "topup-feedback-ok-nominal", "text" => ""),
            'close' => array("id" => "topup-feedback-ok-close", "text" => "Kembali ke Beranda"),
        ), 
        array(
            'container' => "topup-feedback-bo-container",
            'label' => array("id" => "topup-feedback-bo-label", "text" => ""),
            'nominal' => array("id" => "topup-feedback-bo-nominal", "text" => ""),
            'close' => array("id" => "topup-feedback-bo-close", "text" => "Kembali ke Beranda"),
        )
    );
?>
<?= view('components/popup_konfirmasi', $topup_data); ?>
<?= view('components/popup_berhasil', $beli_feedback[0]); ?>
<?= view('components/popup_gagal', $beli_feedback[1]); ?>

<script>
    $('body').ready(function (){
        $('.topup-suggestion').each( function() {
            // rupiah currency
            $(this).html(`Rp.${new Intl.NumberFormat('id-ID').format($(this).data('val'))}`) 
        })
    })
    $('.topup-suggestion').on('click', function() {
        $('#topup-value').val($(this).data('val'));
        $('#topup-value').blur(); // paksa jquery untuk mengvalidasi meski data diubah secara program

        // rupiah currency
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($(this).data('val'))}`;
        $('#<?= $topup_data['nominal']['id']?>').text(format_total);
    });


    $('#topup-btn').on('click', function() {
        if (!$('#topup-form').valid()) {
            return;
        }
            $('#<?= $topup_data['container']?>').removeClass('hidden');
            $('#<?= $topup_data['label']['id']?>').text(`Anda yakin untuk Top Up sebesar`);
            $('#<?= $topup_data['ok']['id']?>').on('click', function () {
                $.ajax({
                    url: "<?= get_api_base() ?>/topup",
                    type: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
                    },
                    data: JSON.stringify({
                        top_up_amount: $('#topup-value').val(),
                    }),
                    success: function (response) {
                        $('#<?= $topup_data['container']?>').addClass('hidden');
                        feedback_success();
                    },
                    error: function (xhr, status, error) {
                        $('#<?= $topup_data['container']?>').addClass('hidden');
                        feedback_failed();
                    }
                });
                feedback.removeClass('invisible');
                feedback.addClass('visible')
            });
            $('#<?= $topup_data['no']['id']?>').on('click', function () {
                $('#<?= $topup_data['container'] ?>').addClass('hidden')
            })
    });
    $('#topup-form').validate({
        rules: {
            topup_value: {
                required: true,
                range: [10000, 1000000]
            },
        },
        messages: {
            required: "Harap isi nominal top up",
            topup_value: "Hanya menerima nominal top up antara Rp 10.000 - Rp 1.000.000",
        },
        errorPlacement: function(error, element) {
            $('#topup-err').text(error.text());
            $('#topup-err').removeClass('invisible');
        },
        success: function(label, element) {
            $('#topup-err').text("_");
            $('#topup-err').addClass('invisible');
        },
    });
    function feedback_success($success) {
        $('#<?= $beli_feedback[0]['container'] ?>').removeClass('hidden')
        $('#<?= $beli_feedback[0]['close']['id']?>').click(() => {
            $('#<?= $beli_feedback[0]['container'] ?>').removeClass('hidden')
            $(location).attr('href', "<?= base_url() ?>dashboard");
        })
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($('#topup-value').val())}`;
        $('#<?= $beli_feedback[0]['nominal']['id']?>').text(format_total);
        $('#<?= $beli_feedback[0]['label']['id']?>').text(`Topup dengan nominal`)
    }


    function feedback_failed() {
        $('#<?= $beli_feedback[1]['container'] ?>').removeClass('hidden')
        $('#<?= $beli_feedback[1]['close']['id']?>').click(() => {
            $('#<?= $beli_feedback[1]['container'] ?>').removeClass('hidden')
            $(location).attr('href', "<?= base_url() ?>dashboard");
        })
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($('#topup-value').val())}`;
        $('#<?= $beli_feedback[1]['nominal']['id']?>').text(format_total);
        $('#<?= $beli_feedback[1]['label']['id']?>').text(`Topup dengan nominal`)
    }
</script>
<?= $this->endSection() ?>