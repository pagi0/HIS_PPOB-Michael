<?php helper('global') ?>

<div id="profile-picture-group" class="grow relative w-40 p-0">
    <div id="profile-picture" class="w-full aspect-square rounded-full overflow-hidden border border-gray-300">
        <img id="profile-img" class="h-full w-auto aspect-square object-cover rounded-full" src="<?= base_url() ?>assets/img/Profile Photo.png">
    </div>
    <input type="file" class="hidden" id="profile-picture-input" accept=".png, .jpg, image/jpeg, image/png" hidden>
    <div class="absolute bottom-0 right-0 w-9 aspect-square border rounded-full border-gray-300 flex items-center justify-center bg-white">
        <img 
            src="<?= base_url()."assets/icon/edit.svg" ?>" 
            class="material-symbols-outlined"
            width="15"
            height="15">
    </div>
</div>

<script>
    $('#profile-picture-input').click(function(event) {
        event.stopPropagation(); 
    });
    $('#profile-picture-input').change(function(event) {
        const file = this.files[0];
        if (file) {
            let form_data = new FormData();
            form_data.append('file', file);
            $.ajax({
                url: '<?= get_api_base() ?>/profile/image',
                type: 'PUT',
                data: form_data,
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
                },
                success: function(data) {
                    $("#profile-img").attr("src", data.data.profile_image);
                },
                error: function(xhr, status, error) {
                    const response = JSON.parse(xhr.responseText);

                    console.error(response);
                }
            });

        }
    });
    $('#profile-picture-group').click(function(event) {
        //console.log('click');
        $('#profile-picture-input').trigger('click');
    });


</script>