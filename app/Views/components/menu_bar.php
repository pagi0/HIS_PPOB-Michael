<?php  
    $path = explode('/', current_url(true)->getPath())[2]; 

    $menus = array(
        array('name' => 'Top Up', 'link' => 'topup'),
        array('name' => 'Transaction', 'link' => 'transaction'),
        array('name' => 'Akun', 'link' => 'profile'),
    );
?>
<div class="w-full  xborder-b-1 border-gray-300 ">
    <div class="w-full 3xl:max-w-[2000px] mx-auto ">
        <div class="w-10/12 py-4 mx-auto flex flex-row justify-between items-center">
            <div class="flex flex-row justify-left items-center gap-2">
                <img 
                    src="<?= base_url() ?>assets/img/Logo.png" 
                    class="w-8" 
                    alt="Responsive image">
                <a href="<?= base_url() ?>dashboard" class="hidden md:block text-xl font-semibold underline-none" ><h5 class="">SIMS PPOB</h5></a>
            </div>
            <div id="menu-small" class="md:hidden font-medium text-xl">MENU</div>
            <div class="hidden md:block flex flex-row">
                    <?php 

                        foreach ($menus as $menu) {
                            echo '
                                <a class="font-medium underline-none text-center text-black text-xl py-4 px-8" href="'
                                .base_url($menu['link']).'">'
                                .'<p class="ml-auto '.(($path == $menu['link']) ? 'text-red-500' : '').'">'
                                .$menu['name'].'</p>'
                                .'</a>';
                        }
                    ?>
            </div>
        </div>
    </div>

    <div id="menu-expand" class="w-full 3xl:max-w-[2000px] mx-auto hidden">
        <?php
        foreach ($menus as $menu) {
            echo '
                <a class="font-medium underline-none text-center text-black text-xl py-4 px-8" href="'
                .base_url($menu['link']).'">'
                .'<p class="ml-auto '.(($path == $menu['link']) ? 'text-red-500' : '').'">'
                .$menu['name'].'</p>'
                .'</a>';
        }
        ?>
    </div>
</div>

<script>
    $('#menu-small').click(function() {
        if ($('#menu-expand').hasClass('hidden')) {
            $('#menu-expand').removeClass('hidden');
        } else {
            $('#menu-expand').addClass('hidden');
        }
    })
</script>