<?php helper('global') ?>

<div id="profile-picture-group" class="profile-picture-group">
    <div id="profile-picture" class="profile-picture">
        <img id="profile-img" class="profile-img" src="">
    </div>
    <input type="file" class="profile-picture-input" id="profile-picture-input" accept=".png, .jpg, image/jpeg, image/png" hidden>
    <div class="profile-picture-icon d-flex align-items-center justify-content-center" style="background: #ffffff">
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
        console.log('click');
        $('#profile-picture-input').trigger('click');
    });


</script>