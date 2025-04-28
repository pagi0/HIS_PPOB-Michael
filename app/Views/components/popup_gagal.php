<div id="<?= $container ?>" class="w-screen h-screen absolute top-0 left-0 bg-blue-200 popup hidden">
    <div class="min-h-4/12 aspect-square z-30 rounded-md bg-white absolute top-1/2 left-1/2 flex flex-col justify-center items-center p-5 -translate-1/2">
        <img id="popup-img" src="<?= base_url() ?>assets/img/remove.png" class="mb-3" alt="" width="50" height="50"></img>
        <p id="<?= $label['id'] ?>" class="text-xl text-center mt-2"><?= $label['text'] ?><p>
        <p id="<?= $nominal['id'] ?>" class="text-3xl text-center font-medium"><?= $nominal['text'] ?></h3>
        <p class="text-xl">gagal</h5>
        <p id="<?= $close['id'] ?>" class="text-xl font-semibold text-red-500 cursor-pointer mt-4"><?= $close['text'] ?></h5>
    </div>
</div>