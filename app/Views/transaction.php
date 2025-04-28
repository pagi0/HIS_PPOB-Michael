
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid row d-flex flex-column align-items-center justify-content-center" style="padding-top: 2.5rem; margin-bottom: 5rem;">

    <div class="col-md-10 d-flex flex-column align-items-start gap-4">
        <?= view('components/profile_widget'); ?>
        <h3>Semua Transaksi</h3>
        <div id="transaction-holder" class="w-100 d-flex flex-column align-items-start gap-4">
<!-- 
        <div class="d-flex flex-row justify-content-between align-items-center w-100 rounded border p-3 ">
            <div class="d-flex flex-column">
                <h4><span>+</span> Rp.10.000</h4>
                <p style="font-size: 10px">17 Agustus 2023 13:10 WIB</p>   
            </div>
            <div id="transaction-description" class="align-self-start">Top Up Saldo</div>
        </div> -->
        </div>
    </div>
    <h5 id="show-more" class="col-md-2 text-center mt-5 clickable text-danger">Show more</h5>
</div>

<script>
    let offset_tracker = 0;
    let limit = 5;
    let newest = "";
    // maslaah yang dapat muncul untuk implementasi offset + limit disini:
    // kalau user melakukan transaksi/topup baru sebelum menekan tombol "show more" dapat terjadi misssing entry
    // solusi:
    // me"refresh" page dengan menampilkan 5 entry terbaru saja
    function add_data($init) {
        $.ajax({
            url: `<?= get_api_base() ?>/transaction/history?offset=${offset_tracker}&limit=${limit}`,
            type: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
            },
            success: function(data) {
                let data_length = data.data.records.length;
                if (data_length < 1) {
                    $('#show-more').addClass('hidden');
                    return;
                }
                let transactions = data.data.records;
                let transaction_holder = $("#transaction-holder");
                for (let i = 0; i < transactions.length; i++) {
                    let transaction = transactions[i];
                    let prefix = transaction.transaction_type == "TOPUP" ? "+" : "-";
                    let prefix_class = transaction.transaction_type == "TOPUP" ? "transaction-plus" : "transaction-minus";
                    let transaction_div = $('<div class="d-flex flex-row justify-content-between align-items-center w-100 rounded border p-3 "></div>');
                    let transaction_info = $('<div class="d-flex flex-column"></div>');
                    let format_total = new Intl.NumberFormat('id-ID').format(transaction.total_amount)
                    let nominal = $(`<h4>${prefix} Rp.${format_total}</h4>`);
                    nominal.addClass(prefix_class);
                    transaction_info.append(nominal);

                    const date = new Date(transaction.created_on);
                    const options = { 
                        timeZone: 'Asia/Jakarta',
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false 
                    };

                    const formatter = new Intl.DateTimeFormat('id-ID', options);
                    const formatted = formatter.format(date).replace('pukul ', '').replace('.', ':');
                    const final_date = `${formatted} WIB`;
                    transaction_info.append(`<p style="font-size: 10px">${final_date}</p>`);
                    transaction_div.append(transaction_info);
                    transaction_div.append('<div class="align-self-start">' + transaction.description + '</div>');
                    transaction_holder.append(transaction_div);
                }
                offset_tracker += data_length;
                if ($init) newest = transactions[0].invoice_number;
            },
            error: function(xhr, status, error) {
                let err = JSON.parse(xhr.responseText);
                console.log(err);
            }
        })
    }
    $('#show-more').on('click', function() {
        $.ajax({
            url: '<?= get_api_base() ?>/transaction/history?offset=0&limit=1',
            type: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
            },
            success: function(data) {
                // check apakah ada entry terbaru
                let new_entry = data.data.records[0].invoice_number;
                console.log(`newest ${newest} == ${new_entry}`)
                if (newest == new_entry) {
                    add_data(false);
                } else {
                    // jika iya, repopulate dengan 5 entry terbaru saja
                    offset_tracker = 0;
                    $("#transaction-holder").empty();
                    add_data(true);
                }
            },
            error: function(xhr, status, error) {
                let err = JSON.parse(xhr.responseText);
                console.log(err);
            }
        })
    })
    $(document).ready(function() {
        add_data(true);
    });
</script>
<?= $this->endSection() ?>