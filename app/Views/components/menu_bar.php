<?php  $path = explode('/', current_url(true)->getPath())[2]; ?>
<div class="w-full  xborder-b-1 border-gray-300 ">
    <div class="w-full 3xl:max-w-[2000px] mx-auto ">
        <div class="w-10/12 py-4 mx-auto flex flex-row justify-between items-center">
            <div class="flex flex-row justify-left items-center gap-2">
                <img 
                    src="<?= base_url() ?>assets/img/Logo.png" 
                    class="w-8" 
                    alt="Responsive image">
                <a href="<?= base_url() ?>dashboard" class="text-xl font-semibold underline-none" ><h5 class="">SIMS PPOB</h5></a>
            </div>
            <div class="flex flex-row">
                    <?php 

                        $menus = array(
                            array('name' => 'Top Up', 'link' => 'topup'),
                            array('name' => 'Transaction', 'link' => 'transaction'),
                            array('name' => 'Akun', 'link' => 'profile'),
                        );
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
</div>