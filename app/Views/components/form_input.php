<div class="w-full flex flex-col gap-0">
    <label for="<?= $api_name ?>" class="mb-3" style="display: <?= isset($label) ? 'block' : 'none' ?>;"><?= isset($label) ? $label : "" ?></label>
    <div class="w-full flex flex-row border border-gray-300 rounded-md h-form" id="<?= $api_name ?>-group">
        <img 
            src="<?= base_url()."assets/icon/".$icon.".svg" ?>" 
            class="w-8 pl-4 brightness-200 invert">
        <input type="text" 
            class="w-full border-0 p-4 focus:outline-none" 
            id="<?= $api_name ?>" 
            name="<?= $api_name ?>"
            placeholder="<?= $placeholder ?>"
            <?= isset($readonly) && $readonly == true ? 'readonly' : '' ?>>
    </div>
    <span class="self-end text-err invisible" id="<?= $api_name ?>-error" >error</label>
</div>