<div id="<?= $container ?>" class="popup hidden">
    <div class="popup-content d-flex flex-column justify-content-center align-items-center">
        <img id="popup-img" src="<?= base_url() ?>assets/img/check.png" class="mb-3" alt="" width="50" height="50"></img>
        <h5 id="<?= $label['id'] ?>" class="fw-normal m-0 text-center"><?= $label['text'] ?><h5>
        <h3 id="<?= $nominal['id'] ?>" class="m-0"><?= $nominal['text'] ?></h3>
        <h5 class="m-0 fw-normal">berhasil</h5>
        <h5 id="<?= $close['id'] ?>" class="clickable mt-4" style="color: red"><?= $close['text'] ?></h5>

    </div>
</div>

<script>
</script>