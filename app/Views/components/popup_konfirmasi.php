<div id="<?= $container ?>" class="w-screen h-screen absolute top-0 left-0 bg-blue-200 popup hidden">
    <div class="min-h-4/12 aspect-square z-30 rounded-md bg-white absolute top-1/2 left-1/2 flex flex-col justify-center items-center p-5 -translate-1/2">
        <img src="<?= base_url()?>assets/img/Logo.png" class="mb-3" alt="" width="50" height="50"></img>
        <p id="<?= $label['id'] ?>" class="text-xl text-center mt-2"><?= $label['text'] ?><p>
        <p id="<?= $nominal['id'] ?>" class="text-3xl font-medium"><?= $nominal['text'] ?></p>
        <p id="<?= $ok['id'] ?>" class="text-xl font-semibold text-red-500 cursor-pointer mt-8"><?= $ok['text'] ?></p>
        <p id="<?= $no['id'] ?>" class="text-gray-600 font-semibold cursor-pointer mt-4"><?= $no['text'] ?></p>

    </div>
</div>