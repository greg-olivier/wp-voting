/*wp_voting_js*/
$.noConflict();
jQuery(document).ready(function ($) {
    jQuery('#wp_voting_append_item_filed .wp_voting_append_item_filed_tr').each(function () {
        var it_ele_container = jQuery(this);
        jQuery(this).find('#wp_voting_contest_item_rm_btn').click(function () {
            jQuery(it_ele_container).remove();
        });
    });
    jQuery('.wp_voting_add_item_btn').click(function () {
        var date = new Date();
        var components = [
        date.getYear(),
        date.getMonth(),
        date.getDate(),
        date.getHours(),
        date.getMinutes(),
        date.getSeconds(),
        date.getMilliseconds()
        ];

        var uniqid = components.join("");

        jQuery('#wp_voting_append_item_filed').append('<tr class="wp_voting_append_item_filed_tr"><td><table class="form-table"><tr><td>Item Name</td><td><input type="text" class="widefat" id="wp_voting_contest_item" name="wp_voting_contest_item[]" required/></td></tr><tr><td>Item Subtitle</td><td><input type="text" class="widefat" id="wp_voting_contest_item_subtitle" name="wp_voting_contest_item_subtitle[]"/></td></tr><tr><td>Item Description</td><td><textarea type="text" rows="4" cols="50" class="widefat" id="wp_voting_contest_item_desc" name="wp_voting_contest_item_desc[]"></textarea><tr><td>Item Image</td><td><input type="url" class="widefat" id="wp_voting_contest_item_img" name="wp_voting_contest_item_img[]"/><input type="hidden" name="wp_voting_contest_item_id[]" id="wp_voting_contest_item_id" value="' + uniqid + '"/></td><td><input type="button" class="button" id="wp_voting_contest_item_btn" name="wp_voting_contest_item_btn" value="Upload"></td></tr><tr><td>Item Profil Option</td><td><select class="widefat wp_voting_profil-option-select" id="wp_voting_contest_item_profil_option" name="wp_voting_contest_item_profil_option[]" required><option disabled selected value> -- select an option --</option><option value="img">Image</option><option value="yt">Youtube</option></select></td></tr><tr class="wp_voting_profil-option"><td>Item Profil Video</td><td><input type="text" class="widefat" id="wp_voting_contest_item_video" name="wp_voting_contest_item_video[]"></td></tr><tr><td colspan="2"><input type="button" class="button" id="wp_voting_contest_item_rm_btn" name="wp_voting_contest_item_rm_btn" value="Remove This Item"></td></tr></table></td></tr>');
        jQuery('#wp_voting_append_item_filed .wp_voting_append_item_filed_tr').each(function () {
            var it_ele_container = jQuery(this);
            jQuery(this).find('#wp_voting_contest_item_rm_btn').click(function () {
                jQuery(it_ele_container).remove();
            });
        });

        $('.wp_voting_profil-option-select').each(function(){
            $(this).change(function(){
                if ( $(this).val() == "yt" ) { 
                    $(this).parent().parent().parent().find('.wp_voting_profil-option').show();
                } else {
                    $(this).parent().parent().parent().find('.wp_voting_profil-option').hide(); 
                }
            });
        }); 
        
        jQuery('#wp_voting_append_item_filed .wp_voting_append_item_filed_tr').each(function () {
            jQuery(this).find('#wp_voting_contest_item_btn').click(function (e) {

                var img_val = jQuery(this).parent().parent().find('#wp_voting_contest_item_img');
                var image = wp.media({
                    title: 'Upload Image',
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open()
                .on('select', function (e) {
                        // This will return the selected image from the Media Uploader, the result is an object
                        var uploaded_image = image.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image

                        var image_url = uploaded_image.toJSON().url;
                        // Let's assign the url value to the input field
                        console.log(img_val);

                        img_val.val(image_url);
                    });
            });
        });
    });
    if (jQuery('#wp_voting_append_item_filed .wp_voting_append_item_filed_tr')) {
        jQuery('#wp_voting_append_item_filed .wp_voting_append_item_filed_tr').each(function () {
            jQuery(this).find('#wp_voting_contest_item_btn').click(function (e) {

                var img_val = jQuery(this).parent().parent().find('#wp_voting_contest_item_img');
                var image = wp.media({
                    title: 'Upload Image',
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open()
                .on('select', function (e) {
                        // This will return the selected image from the Media Uploader, the result is an object
                        var uploaded_image = image.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image

                        var image_url = uploaded_image.toJSON().url;
                        // Let's assign the url value to the input field
                        console.log(img_val);

                        img_val.val(image_url);
                    });
            });
        });
    }

    // Show Youtube Link field if option selected
    $('.wp_voting_profil-option-select').each(function(){
        $(this).change(function(){
            if ( $(this).val() == "yt" ) { 
                $(this).parent().parent().parent().find('.wp_voting_profil-option').show();
            } else {
                $(this).parent().parent().parent().find('.wp_voting_profil-option').hide(); 
            }
        });
    });

});



