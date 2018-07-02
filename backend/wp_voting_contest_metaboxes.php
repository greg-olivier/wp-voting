<?phpdefined( 'ABSPATH' ) or die();/** * Adds a box to the main column on the Contest edit screens. */function wp_voting_metaboxes() {	add_meta_box(		'wp_voting_',		__( 'Add Contest Items', 'wp_voting' ),		'wp_voting_metabox_forms',		'wp_voting_contest'	);}add_action( 'add_meta_boxes', 'wp_voting_metaboxes' );/** * Prints the box content. *  * @param WP_Post $post The object for the current post/page. */function wp_voting_metabox_forms( $post ) {	// Add an nonce field so we can check for it later.	wp_nonce_field( 'wp_voting_metabox_id', 'wp_voting_metabox_id_nonce' );	/*	 * Use get_post_meta() to retrieve an existing value	 * from the database and use the value for the form.	 */	$wp_voting_contest_item = get_post_meta( $post->ID, 'wp_voting_contest_item', true );	$wp_voting_contest_item_subtitle = get_post_meta( $post->ID, 'wp_voting_contest_item_subtitle', true );	$wp_voting_contest_item_desc = get_post_meta( $post->ID, 'wp_voting_contest_item_desc', true );	$wp_voting_contest_item_video = get_post_meta( $post->ID, 'wp_voting_contest_item_video', true );	$wp_voting_contest_item_profil_option = get_post_meta( $post->ID, 'wp_voting_contest_item_profil_option', true );	$wp_voting_contest_start_date =  get_post_meta($post->ID, 'wp_voting_contest_start_date', true);	$wp_voting_contest_end_date = get_post_meta($post->ID, 'wp_voting_contest_end_date', true);	$wp_voting_contest_item_img = get_post_meta( $post->ID, 'wp_voting_contest_item_img', true );	$wp_voting_contest_item_id = get_post_meta( $post->ID, 'wp_voting_contest_item_id', true );	$wp_voting_contest_vote_total_count = (int)get_post_meta($post->ID, 'wp_voting_vote_total_count',true);	?>	<?php if(($post->post_type == 'wp_voting_contest') && $_REQUEST['action'] == 'edit'){?>	<div class="wp_voting_short_code">		<?php _e('Shortcode for this contest is : [WP_VOTING "'.$post->ID.'"][/WP_VOTING] (Insert it anywhere in your post/page and show your contest)','wp_voting');?>	</div>	<?php }?>	<table class="form-table">		<tr>			<td><?php _e('Contest Start Date','wp_voting');?></td>			<td>				<input type="date" class="widefat" id="wp_voting_contest_start_date" name="wp_voting_contest_start_date" value="<?php echo esc_attr($wp_voting_contest_start_date,'wp_voting');?>" required/>			</td>			<td><?php _e('Contest End Date','wp_voting');?></td>			<td>				<input type="date" class="widefat" id="wp_voting_contest_end_date" name="wp_voting_contest_end_date" value="<?php echo esc_attr($wp_voting_contest_end_date,'wp_voting');?>" required/>			</td>		</tr>	</table>		<table class="form-table" id="wp_voting_append_item_filed">		<?php if(!empty($wp_voting_contest_item)):		$i=0;		$n=1;		foreach($wp_voting_contest_item as $wp_voting_contest_opt):						$wp_voting_contest_vote_count = (int)get_post_meta($post->ID, 'wp_voting_vote_count_' . $wp_voting_contest_item_id[$i], true);			if ($wp_voting_contest_vote_count == 0) {				$wp_voting_contest_vote_percentage = 0;			} else {				$wp_voting_contest_vote_percentage = round(($wp_voting_contest_vote_count * 100) / $wp_voting_contest_vote_total_count);			}			$wp_voting_contest_vote_percentage = (int)$wp_voting_contest_vote_percentage;?>			<tr class="wp_voting_append_item_filed_tr"><td><table class="form-table">				<tr>					<h1 style="text-align: center">Item <?php echo $n; ?></h1>				</tr>				<tr>					<div class="wp_voting_survey-stats">						<div class="wp_voting_pull-right">							<span class="wp_voting_survey-progress">								<span class="wp_voting_survey-progress-bg">									<span class="wp_voting_survey-progress-fg" style="width:									<?php echo($wp_voting_contest_vote_percentage . '%'); ?>"></span>								</span>								<span class="wp_voting_survey-progress-labels">									<span class="wp_voting_survey-progress-label">										<?php echo($wp_voting_contest_vote_percentage) . '%'; ?>									</span>									<span class="wp_voting_survey-completes">										<?php echo($wp_voting_contest_vote_count . '/' . $wp_voting_contest_vote_total_count); ?>									</span>								</span>							</span>						</div>					</div>				</tr>				<tr>					<td>						<?php _e('Item Title','wp_voting');?>					</td>					<td>						<input type="text" class="widefat" id="wp_voting_contest_item" name="wp_voting_contest_item[]" value="<?php echo esc_attr($wp_voting_contest_opt,'wp_voting');?>" required/>					</td>				</tr>				<tr>					<td>						<?php _e('Item Subtitle','wp_voting');?>					</td>					<td>						<input type="text" class="widefat" id="wp_voting_contest_item_subtitle" name="wp_voting_contest_item_subtitle[]" value="<?php if(!empty($wp_voting_contest_item_subtitle)){ echo esc_attr($wp_voting_contest_item_subtitle[$i],'wp_voting');}?>"/>					</td>				</tr>				<tr>					<td>						<?php _e('Item Description','wp_voting');?>					</td>					<td>						<textarea type="text" rows="4" cols="50" class="widefat" id="wp_voting_contest_item_desc" name="wp_voting_contest_item_desc[]"><?php if(!empty($wp_voting_contest_item_desc)){ echo esc_attr($wp_voting_contest_item_desc[$i],'wp_voting');}?></textarea>					</td>				</tr>				<tr>					<td>						<?php _e('Item Image','wp_voting');?>					</td>					<td>						<input type="url" class="widefat" id="wp_voting_contest_item_img" name="wp_voting_contest_item_img[]" value="<?php if(!empty($wp_voting_contest_item_img)){ echo esc_attr($wp_voting_contest_item_img[$i],'wp_voting');}?>"/>						<input type="hidden" name="wp_voting_contest_item_id[]" id="wp_voting_contest_item_id" value="<?php echo esc_attr($wp_voting_contest_item_id[$i],'wp_voting');?>"/>					</td>					<td>						<input type="button" class="button" id="wp_voting_contest_item_btn" name="wp_voting_contest_item_btn" value="<?php _e('Upload','wp_voting');?>">					</td>				</tr>				<tr>					<td>						<?php _e('Item Profil Option','wp_voting');?>					</td>					<td>						<select class="widefat wp_voting_profil-option-select" id="wp_voting_contest_item_profil_option" name="wp_voting_contest_item_profil_option[]" required>							<option disabled value> -- select an option --</option>							<option <?php if($wp_voting_contest_item_profil_option[$i] == 'img'){echo 'selected';}; ?> value="img">Image</option>							<option <?php if($wp_voting_contest_item_profil_option[$i] == 'yt'){echo 'selected';}; ?> value="yt">Youtube</option>						</select>					</td>				</tr>				<tr class="wp_voting_profil-option" <?php if($wp_voting_contest_item_profil_option[$i] == 'yt') {echo 'style="display:table-row;"';};?>>					<td>						<?php _e('Item Profil Video','wp_voting');?>					</td>					<td>						<input type="text" class="widefat" id="wp_voting_contest_item_video" name="wp_voting_contest_item_video[]" value="<?php if(!empty($wp_voting_contest_item_video)){ echo esc_attr($wp_voting_contest_item_video['wp_voting_video-'.$post->ID.$n],'wp_voting');}?>">					</td>				</tr>				<tr>					<td colspan="2">						<input type="button" class="button" id="wp_voting_contest_item_rm_btn" name="wp_voting_contest_item_rm_btn" value="Remove This Item">					</td>				</tr>			</table>		</td>	</tr>	<?php 	$i++;	$n++;endforeach;endif; ?></table><table class="form-table">	<tr>		<td><button type="button" name="" class="button wp_voting_add_item_btn" id=""><i class="dashicons-before dashicons-plus-alt"></i> <?php _e('Add Item','wp_voting');?></button></td>	</tr></table><table class="form-table wp_voting_short_code">	<tr>		<td><?php _e('Developed & Designed By <a href=" https://github.com/greg-olivier">Greg OLIVIER</a>','wp_voting');?></td>	</tr></table><?php}/** * When the post is saved, saves our custom data. * * @param int $post_id The ID of the post being saved. */function wp_voting_save_items( $post_id ) {	/*	 * We need to verify this came from our screen and with proper authorization,	 * because the save_post action can be triggered at other times.	 */	// Check if our nonce is set.	if ( ! isset( $_POST['wp_voting_metabox_id_nonce'] ) ) {		return;	}	// Verify that the nonce is valid.	if ( ! wp_verify_nonce( $_POST['wp_voting_metabox_id_nonce'], 'wp_voting_metabox_id' ) ) {		return;	}	// If this is an autosave, our form has not been submitted, so we don't want to do anything.	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {		return;	}	// Check the user's permissions.	if ( isset( $_POST['post_type'] ) && 'wp_voting_contest' == $_POST['post_type'] ) {		if ( ! current_user_can( 'edit_page', $post_id ) ) {			return;		}	} else {		if ( ! current_user_can( 'edit_post', $post_id ) ) {			return;		}	}		// Sanitize user input & Update the meta field in the database.	if(isset($_POST['wp_voting_contest_start_date'])){		$wp_voting_contest_start_date =  sanitize_text_field($_POST['wp_voting_contest_start_date']);		update_post_meta( $post_id, 'wp_voting_contest_start_date', $wp_voting_contest_start_date );	}	if(isset($_POST['wp_voting_contest_end_date'])){		$wp_voting_contest_end_date =  sanitize_text_field($_POST['wp_voting_contest_end_date']);		update_post_meta( $post_id, 'wp_voting_contest_end_date', $wp_voting_contest_end_date );	}		if(isset($_POST['wp_voting_contest_item'])){		$wp_voting_contest_items = $_POST['wp_voting_contest_item'];		$wp_voting_contest_item = array();		foreach($wp_voting_contest_items as $wp_voting_contest_opt_key){			if($wp_voting_contest_opt_key){				array_push($wp_voting_contest_item,sanitize_text_field($wp_voting_contest_opt_key));			}		}		update_post_meta( $post_id, 'wp_voting_contest_item', $wp_voting_contest_item );	}	if(isset($_POST['wp_voting_contest_item_subtitle'])){		$wp_voting_contest_item_subtitles = $_POST['wp_voting_contest_item_subtitle'];		$wp_voting_contest_item_subtitle = array();		foreach($wp_voting_contest_item_subtitles as $wp_voting_contest_item_subtitle_key){			if($wp_voting_contest_item_subtitle_key){				array_push($wp_voting_contest_item_subtitle,sanitize_text_field($wp_voting_contest_item_subtitle_key));			}		}		update_post_meta( $post_id, 'wp_voting_contest_item_subtitle', $wp_voting_contest_item_subtitle );	}	if(isset($_POST['wp_voting_contest_item_profil_option'])){		$wp_voting_contest_item_profil_options = $_POST['wp_voting_contest_item_profil_option'];		$wp_voting_contest_item_profil_option = array();		foreach($wp_voting_contest_item_profil_options as $wp_voting_contest_item_profil_option_key){			if($wp_voting_contest_item_profil_option_key){				array_push($wp_voting_contest_item_profil_option,sanitize_text_field($wp_voting_contest_item_profil_option_key));			}		}		update_post_meta( $post_id, 'wp_voting_contest_item_profil_option', $wp_voting_contest_item_profil_option );	}	if(isset($_POST['wp_voting_contest_item_video'])){		$wp_voting_contest_item_videos = $_POST['wp_voting_contest_item_video'];		$wp_voting_contest_item_options = (isset($_POST['wp_voting_contest_item_profil_option'])) ? $_POST['wp_voting_contest_item_profil_option'] : false;		$wp_voting_contest_item_video = array();		if($wp_voting_contest_item_options){			$n = 1;			$i = 0;			foreach($wp_voting_contest_item_videos as $wp_voting_contest_item_video_key){				if ($wp_voting_contest_item_options[$i] && $wp_voting_contest_item_options[$i] == 'yt')					$wp_voting_contest_item_video['wp_voting_video-'.$post_id.$n] = sanitize_text_field($wp_voting_contest_item_video_key);				else					$wp_voting_contest_item_video['wp_voting_video-'.$post_id.$n] = '';				$i++;				$n++;			}			update_post_meta( $post_id, 'wp_voting_contest_item_video', $wp_voting_contest_item_video);		}	}	if(isset($_POST['wp_voting_contest_item_desc'])){		$wp_voting_contest_item_descs = $_POST['wp_voting_contest_item_desc'];		$wp_voting_contest_item_desc = array();		foreach($wp_voting_contest_item_descs as $wp_voting_contest_item_desc_key){			if($wp_voting_contest_item_desc_key){				array_push($wp_voting_contest_item_desc,sanitize_text_field($wp_voting_contest_item_desc_key));			}		}		update_post_meta( $post_id, 'wp_voting_contest_item_desc', $wp_voting_contest_item_desc );	}	if(isset($_POST['wp_voting_contest_item_img'])){		$wp_voting_contest_item_imgs = $_POST['wp_voting_contest_item_img'];		$wp_voting_contest_item_img = array();		foreach($wp_voting_contest_item_imgs as $wp_voting_contest_item_img_key){			if($wp_voting_contest_item_img_key){				array_push($wp_voting_contest_item_img,sanitize_text_field($wp_voting_contest_item_img_key));			}		}		update_post_meta( $post_id, 'wp_voting_contest_item_img', $wp_voting_contest_item_img );	}	if(isset($_POST['wp_voting_contest_item_id'])){		$wp_voting_contest_item_ids = $_POST['wp_voting_contest_item_id'];		$wp_voting_contest_item_id = array();		foreach($wp_voting_contest_item_ids as $wp_voting_contest_item_id_key){			if($wp_voting_contest_item_id_key){				array_push($wp_voting_contest_item_id,sanitize_text_field($wp_voting_contest_item_id_key));			}		}		update_post_meta( $post_id, 'wp_voting_contest_item_id', $wp_voting_contest_item_id );	}}add_action( 'save_post', 'wp_voting_save_items' );