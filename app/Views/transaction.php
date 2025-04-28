
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="w-10/12 flex flex-col items-center gap-4">

        <div class="w-full flex flex-col gap-2">
            <?= view('components/profile_widget'); ?>
            <p class="text-2xl mt-10 font-medium">Semua Transaksi</p>
            <div id="transaction-holder" class="w-full flex flex-col items-start gap-4 mt-4">

            </div>
            <h5 id="show-more" class="w5/12 text-center mt-5 cursor-pointer text-red-500 font-semibold">Show more</h5>
        </div>
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
                    let transaction_div = $('<div class="flex flex-row justify-between items-center w-full rounded-md border border-gray-300 py-4 px-6"></div>');
                    let transaction_info = $('<div class="flex flex-col"></div>');
                    let format_total = new Intl.NumberFormat('id-ID').format(transaction.total_amount)
                    let nominal = $(`<p class="text-2xl font-medium">${prefix} Rp.${format_total}</p>`);
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
                    transaction_info.append(`<p class="text-sm text-gray-500 pt-1">${final_date}</p>`);
                    transaction_div.append(transaction_info);
                    transaction_div.append('<div class="self-start">' + transaction.description + '</div>');
                    transaction_holder.append(transaction_div);
                }
                offset_tracker += data_length;
                if ($init) newest = transactions[0].invoice_number;
            },
            error: function(xhr, status, error) {
                let err = JSON.parse(xhr.responseText);
                //console.log(err);
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
                //console.log(`newest ${newest} == ${new_entry}`)
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
                //console.log(err);
            }
        })
    })
    $(document).ready(function() {
        add_data(true);
    });
</script>
<?= $this->endSection() ?>