<div id="<?= $container ?>" class="popup hidden">
    <div class="popup-content d-flex flex-column justify-content-center align-items-center p-5">
        <img src="<?= base_url()?>assets/img/Logo.png" class="mb-3" alt="" width="50" height="50"></img>
        <h5 id="<?= $label['id'] ?>" class="fw-normal m-0 text-center"><?= $label['text'] ?><h5>
        <h3 id="<?= $nominal['id'] ?>" class="m-0"><?= $nominal['text'] ?></h3>
        <h5 id="<?= $ok['id'] ?>" class="clickable mt-4" style="color: red"><?= $ok['text'] ?></h5>
        <h5 id="<?= $no['id'] ?>" class="clickable mt-4" style="color: grey"><?= $no['text'] ?></h5>

    </div>
</div>