<div id="form-group-<?= $api_name ?>" class="d-flex flex-column gap-0 mb-2">
    <div class="d-flex flex-row registrasi borderform mb-1" id="<?= $api_name ?>-group">
        <img 
            src="<?= base_url()."assets/icon/".$icon.".svg" ?>" 
            class="material-symbols-outlined align-self-center registrasi icon"
            width="30"
            height="30">
        <input type="password" 
            class="registrasi form" 
            id="<?= $api_name ?>" 
            name="<?= $api_name ?>"
            placeholder="<?= $placeholder ?>">
        <img 
            src="<?= base_url()."assets/icon/visibility.svg" ?>" 
            class="material-symbols-outlined align-self-center registrasi icon"
            style="color: grey;"
            width="30"
            height="30"
            id="eye_<?= $api_name ?>">
    </div>
    <span class="align-self-end text-danger invisible" id="<?= $api_name ?>-error" >_</label>
</div>

<script>
    $('#eye_<?= $api_name ?>').on('click', function () {
        const $input = $('#<?= $api_name ?>');
        const type = $input.attr('type') === 'password' ? 'text' : 'password';
        console.log(type);
        $input.attr('type', type);
    });
</script>