<div id="form-group-<?= $api_name ?>" class="w-full flex flex-col">
    <div class="w-full flex flex-row border border-gray-300 rounded-md h-form" id="<?= $api_name ?>-group">
        <img 
            src="<?= base_url()."assets/icon/".$icon.".svg" ?>" 
            class="w-8 pl-4 brightness-200 invert"
            >
        <input type="password" 
            class="w-full border-0 p-4 focus:outline-none" 
            id="<?= $api_name ?>" 
            name="<?= $api_name ?>"
            placeholder="<?= $placeholder ?>">
        <img 
            src="<?= base_url()."assets/icon/visibility.svg" ?>" 
            class="w-8 pr-4 brightness-200 invert"
            id="eye_<?= $api_name ?>">
    </div>
    <span class="self-end text-err invisible" id="<?= $api_name ?>-error" >_</label>
</div>

<script>
    $('#eye_<?= $api_name ?>').on('click', function () {
        const $input = $('#<?= $api_name ?>');
        const type = $input.attr('type') === 'password' ? 'text' : 'password';
        //console.log(type);
        $input.attr('type', type);
    });
</script>