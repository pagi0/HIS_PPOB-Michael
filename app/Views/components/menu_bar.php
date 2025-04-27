<?php  $path = explode('/', current_url(true)->getPath())[2]; ?>
<div class="container-fluid d-flex flex-row justify-content-center align-items-center menu-bar-container">
<div class="container-xxl row w-100">
    <div class="col-md-12 d-flex flex-column align-items-center">
        <div class="col-md-1"></div>
        <div class="col-md-10 d-flex flex-row justify-content-between menu-bar-content">
            <div class="d-flex flex-row align-items-center gap-2">
                <img 
                    src="<?= base_url() ?>assets/img/Logo.png" 
                    class="img-fluid" 
                    style="width: 1.5rem; height: 1.5rem"
                    alt="Responsive image">
                <a href="<?= base_url() ?>dashboard" class="m-0" style="text-decoration: none; color: black"><h5 class="m-0">SIMS PPOB</h5></a>
            </div>
            <div class="d-flex flex-row align-items-center">
                <?php 

                    $menus = array(
                        array('name' => 'Top Up', 'link' => 'topup'),
                        array('name' => 'Transaction', 'link' => 'transaction'),
                        array('name' => 'Akun', 'link' => 'profile'),
                    );
                    foreach ($menus as $menu) {
                        echo '
                            <a class="menu-bar-a menu-bar-item '
                            .'" href="'.base_url($menu['link']).'">'
                            .'<h5 class="'.(($path == $menu['link']) ? 'menu-active' : '').'">'
                            .$menu['name'].'</h5>'
                            .'</a>';
                    }
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
</div>
