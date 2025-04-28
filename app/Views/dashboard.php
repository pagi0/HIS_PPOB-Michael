<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-amber-300 w-3xl h-3 font-extrabold text-amber-200">awkdwako</div>
<div class="container-xxl row d-flex flex-column justify-content-center align-items-center" style="padding-top: 2.5rem; margin-bottom: 5rem;">
    <div class="col-md-12 d-flex flex-column align-items-center gap-4 m-0">
        <div class="col-md-1"></div>
        <div class="col-md-10 row">
            <?= view('components/profile_widget') ?>
            <div id="service-holder" class="d-flex col-md-12 flex-row mt-4 p-0 flex-fill">
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="col-md-12 row align-self-start">
        <div class="col-md-1"></div>
        <div class="col-md-11">
            <h3>Temukan Promo menarik</h3>
            <div id="promo-slider" class="d-flex flex-row promo-slider gap-4">
            </div>
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
                    <a href="#" style="text-decoration: none; underline: none; color: black;">
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
                    <a class="flex-grow-1" href="<?= base_url() ?>service/${service.service_code}" style="text-decoration: none; color: black"> 
                    <div class="d-flex flex-column align-items-center gap-2 clickable service-item">
                        <img src="${service.service_icon}" alt="" class="widget-icon">
                        <p style="text-align: center; text-wrap: wrap" >${service.service_name}</p>
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

