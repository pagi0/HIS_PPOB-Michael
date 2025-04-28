<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="w-10/12 flex flex-col items-center gap-4">
        <div class="w-full flex flex-col gap-14">
            <?= view('components/profile_widget') ?>
            <div id="service-holder" class="flex flex-row justify-between flex-wrap gap-1">
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="w-11/12 ml-auto flex flex-row align-self-start ">
        <div class="w-full flex flex-col gap-8">
            <p class="text-xl">Temukan Promo menarik</p>
            <div id="promo-slider" class="flex flex-row promo-slider gap-8" >
            </div>
    </div>

<script>

    $.ajax({
        url: "<?= get_api_base() ?>/banner",
        type: "GET",
        headers:{
            'Content-Type': 'applicaiton/json',

        },
        success: function (response) {
            let promo = response.data;
            for (let i = 0; i < promo.length; i++) {
                let promoItem = promo[i];
                $("#promo-slider").append(`
                    <a href="#" class="text-black underline-none">
                        <img src="${promoItem.banner_image}" alt="${promoItem.description}">
                    </a>
                `);
            }    
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
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
            services.forEach((service) =>{
                service_holder.append(`
                    <a class="shrink underline-none text-black" href="<?= base_url() ?>service/${service.service_code}" > 
                        <div class="flex flex-col items-center gap-2 cursor-pointer w-26 text-base">
                            <img class="w-full object-cover" src="${service.service_icon}">
                            <p class="text-center text-wrap">${service.service_name}</p>
                        </div>
                    </a>
                `);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
</script>

<?= $this->endSection() ?>

