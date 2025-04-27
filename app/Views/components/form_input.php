<div class="d-flex flex-column gap-0 mb-2">
    <label for="<?= $api_name ?>" class="mb-3" style="display: <?= isset($label) ? 'block' : 'none' ?>;"><?= isset($label) ? $label : "" ?></label>
    <div class="d-flex flex-row registrasi borderform mb-1" id="<?= $api_name ?>-group">
        <img 
            src="<?= base_url()."assets/icon/".$icon.".svg" ?>" 
            class="material-symbols-outlined align-self-center registrasi icon"
            width="30"
            height="30">
        <input type="text" 
            class="registrasi form" 
            id="<?= $api_name ?>" 
            name="<?= $api_name ?>"
            placeholder="<?= $placeholder ?>"
            <?= isset($readonly) && $readonly == true ? 'readonly' : '' ?>>
    </div>
    <span class="align-self-end text-danger invisible" id="<?= $api_name ?>-error" >error</label>
</div>