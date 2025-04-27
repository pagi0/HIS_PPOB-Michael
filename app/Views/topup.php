<?= $this->extend('layouts/main') ?>

<?php
    $suggestion = array(
        10000, 20000, 50000, 100000, 250000, 500000
    )
?>

<?= $this->section('content') ?>
<div class="container-fluid row d-flex flex-column align-items-center" style="padding-top: 2.5rem; margin-bottom: 5rem;">

    <div class="col-md-10 d-flex flex-column align-items-start gap-4">

        <?= view('components/profile_widget'); ?>
        <h4>Silahkan masukkan</h4>
        <h2>Nominal Top Up</h2>
        <div class="row w-100">
            <div class="col-md-7 d-flex flex-column">
                <div class="d-flex registrasi borderform" id="topup-group">
                        <img 
                            src="<?= base_url()."assets/icon/credit_card.svg" ?>" 
                            class="material-symbols-outlined align-self-center registrasi icon"
                            width="30"
                            height="30">
                        <form id="topup-form" class="flex-grow-1 w-100">
                            <input type="text" 
                                class="registrasi form " 
                                id="topup-value" 
                                name="topup_value"
                                placeholder="nominal top up"
                                value="">
                        </form>
                </div>
                <span id="topup-err" class="m-0 align-self-end text-danger invisible">error</span>
                <button id="topup-btn" class="registrasi btn w-100" style="margin-top: 2px">Top Up</button>
            </div>
            <div class="col-md-5 gap-5 col">
                <?php 
                // render suggestion nominal top up
                    $tracker = 0;
                    for ($idx1 = 0; $idx1 < ceil(sizeof($suggestion)/3); $idx1++) {
                        echo '<div class="row gap-2" style="'
                            .(($idx1 == ceil(sizeof($suggestion)/3)-1)?'margin-top: 1.5rem' : '')
                            .'">';
                            for ($idx2 = 0; $idx2 < 3; $idx2++) {
                                echo '<div id="suggestion-'.$suggestion[$tracker].'" class="col topup-suggestion d-flex justify-content-center align-items-center clickable" data-val="'.$suggestion[$tracker].'"></div>';
                                $tracker++;
                            }
                        echo '</div>';
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
        'ok' => array("id" => "topup-konfirmasi-ok", "text" => "Ya, lanjutkan Bayar"),
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
            $('#<?= $topup_data['container']?>').removeClass('d-none');
            $('#<?= $topup_data['label']['id']?>').text(`Topup senilai`);
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
                        $('#<?= $topup_data['container']?>').addClass('d-none');
                        feedback_success();
                    },
                    error: function (xhr, status, error) {
                        $('#<?= $topup_data['container']?>').addClass('d-none');
                        feedback_failed();
                    }
                });
                feedback.removeClass('invisible');
                feedback.addClass('visible')
            });
            $('#<?= $topup_data['no']['id']?>').on('click', function () {
                $('#<?= $topup_data['container'] ?>').addClass('d-none')
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
        $('#<?= $beli_feedback[0]['container'] ?>').removeClass('d-none')
        $('#<?= $beli_feedback[0]['close']['id']?>').click(() => {
            $('#<?= $beli_feedback[0]['container'] ?>').removeClass('d-none')
            $(location).attr('href', "<?= base_url() ?>dashboard");
        })
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($('#topup-value').val())}`;
        $('#<?= $beli_feedback[0]['nominal']['id']?>').text(format_total);
        $('#<?= $beli_feedback[0]['label']['id']?>').text(`Topup dengan nominal`)
    }


    function feedback_failed() {
        $('#<?= $beli_feedback[1]['container'] ?>').removeClass('d-none')
        $('#<?= $beli_feedback[1]['close']['id']?>').click(() => {
            $('#<?= $beli_feedback[1]['container'] ?>').removeClass('d-none')
            $(location).attr('href', "<?= base_url() ?>dashboard");
        })
        let format_total = `Rp.${new Intl.NumberFormat('id-ID').format($('#topup-value').val())}`;
        $('#<?= $beli_feedback[1]['nominal']['id']?>').text(format_total);
        $('#<?= $beli_feedback[1]['label']['id']?>').text(`Topup dengan nominal`)
    }
</script>
<?= $this->endSection() ?>