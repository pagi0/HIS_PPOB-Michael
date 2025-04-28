<!-- filepath: g:\web\HIS_PPOB-Michael\app\Views\registrasi.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS PPOB-Michael Nagaku</title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/otailwind.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css"> <!-- Add your CSS file here -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=alternate_email,person" /> <!-- google icon -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
</head>
<body>
    <?php helper('global'); ?>
    <div class="w-full flex flex-col justify-center items-center">
        <?= view('components/menu_bar') ?>

        <div class="w-full 3xl:max-w-[2000px] h-min-screen mx-auto flex flex-col justify-center items-center pt-2 md:pt-10 mb-20 gap-16 ">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <?= view('components/auth_load') ?>
    <script>
    $(document).ready(function() {
        $('body').addClass('block-scrolling')
        $.ajax({
            url: '<?= get_api_base() ?>/balance',
            type: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
            },
            success: function(data) {
                $("#loading").addClass('fade-out');
                setTimeout(() => {
                    $("#loading").remove();
                }, 500)
                $('body').removeClass('block-scrolling')
            },
            error: function(xhr, status, error) {
                $(location).attr('href', "<?= base_url() ?>login");
            }
        })
    })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>