<?php/*Plugin Name: WP Voting ContestDescription: The WP Voting Plug in is an advanced and responsive voting system made to integrate contest into your posts, pages and everywhere in website with a shortcode. Add contest to your post/page by placing shortcode and so offer to your visitors a possibility to interact with your website by voting.Author: Greg OlivierAuthor URI: https://github.com/greg-olivierVersion: 1.0Tags: WordPress Plugin, wp voting, wp contest system, contest plugin, survey plugin, wp contest, user contest, user voting, contest system, add contest, wp contest system, voting system, wp voting, vote, vote system, posts, pages, category, plugin.Text Domain: wp_voting*/defined( 'ABSPATH' ) or die();register_deactivation_hook(__FILE__, 'wp_voting_deactivate');register_activation_hook(__FILE__, 'wp_voting_activate');//E Contest Activationfunction wp_voting_activate(){}//E Contest Deactivationfunction wp_voting_deactivate(){	}//Security Tokenfunction setting_token_cookie() {	$token = bin2hex(random_bytes(16).hash('sha256', $_SERVER['REMOTE_ADDR'], true ));	setcookie( 'wpvo', $token, time() + 3600*4, '/', $_SERVER['HTTP_HOST']);}add_action( 'init', 'setting_token_cookie' );if ( ! function_exists('wp_voting_contest_create_contest') ) {	function wp_voting_contest_create_contest() {		$labels = array(			'name'                => _x( 'Contest', 'Post Type General Name', 'wp_voting' ),			'singular_name'       => _x( 'Contest', 'Post Type Singular Name', 'wp_voting' ),			'menu_name'           => __( 'WP Voting', 'wp_voting' ),			'name_admin_bar'      => __( 'WP Voting', 'wp_voting' ),			'parent_item_colon'   => __( 'Parent Contest:', 'wp_voting' ),			'all_items'           => __( 'All Contests', 'wp_voting' ),			'add_new_item'        => __( 'Add New Contest', 'wp_voting' ),			'add_new'             => __( 'Add New', 'wp_voting' ),			'new_item'            => __( 'New Contest', 'wp_voting' ),			'edit_item'           => __( 'Edit Contest', 'wp_voting' ),			'update_item'         => __( 'Update Contest', 'wp_voting' ),			'view_item'           => __( 'View Contest', 'wp_voting' ),			'search_items'        => __( 'Search Contest', 'wp_voting' ),			'not_found'           => __( 'Not found', 'wp_voting' ),			'not_found_in_trash'  => __( 'Not found in Trash', 'wp_voting' ),		);		$args = array(			'label'               => __( 'contest', 'wp_voting' ),			'description'         => __( 'Contest Description', 'wp_voting' ),			'labels'              => $labels,			'supports'            => array( 'title','thumbnail','revisions'),			'hierarchical'        => true,			'public'              => true,			'show_ui'             => true,			'show_in_menu'        => true,			'menu_position'       => 5,			'menu_icon'			  => 'dashicons-awards',			'show_in_admin_bar'   => true,			'show_in_nav_menus'   => true,			'can_export'          => true,			'has_archive'         => true,			'exclude_from_search' => false,			'publicly_queryable'  => true,			'rewrite' 			  => array('slug' => 'contest'),			'capability_type'     => 'page',		);		register_post_type( 'wp_voting_contest', $args );	}// Hook into the 'init' action	add_action( 'init', 'wp_voting_contest_create_contest', 0 );}//Add eContest Admin Scriptsfunction wp_voting_js_register() {	wp_enqueue_script('media-upload');	wp_enqueue_script('thickbox');	wp_register_script('wp_voting_js', plugins_url('/assets/js/wp_voting.min.js',__FILE__ ), array('jquery','media-upload','thickbox'), '', true);	wp_enqueue_script('wp_voting_js');}//Add eContest Admin Stylefunction wp_voting_css_register() {	wp_register_style('wp_voting_css', plugins_url('/assets/css/wp_voting.min.css',__FILE__ ));	wp_enqueue_style(array('thickbox','wp_voting_css'));}add_action( 'admin_enqueue_scripts', 'wp_voting_css_register' );add_action( 'admin_enqueue_scripts', 'wp_voting_js_register' );//Add Contest Frontend Stylefunction wp_voting_enqueue_style() {	wp_enqueue_style( 'wp_voting_style', plugins_url('/assets/css/wp_voting_frontend.min.css',__FILE__ ), false );}add_action( 'wp_enqueue_scripts', 'wp_voting_enqueue_style' );//Add Contest Frontend Scriptfunction wp_voting_enqueue_script() {	wp_enqueue_script( 'wp_voting_script', plugins_url('/assets/js/wp_voting_frontend.min.js',__FILE__ ), array('jquery'), '', true );}add_action( 'wp_enqueue_scripts', 'wp_voting_enqueue_script' );//Add Contest Youtube Scriptfunction wp_voting_enqueue_yt_script(){	wp_enqueue_script( 'wp_voting_yt_script', plugins_url('/assets/js/wp_voting_yt_api.min.js',__FILE__ ), array(), '', true );}add_action( 'wp_enqueue_scripts', 'wp_voting_enqueue_yt_script' );function get_url_wp_voting_items_video($post_id){	$wp_voting_item_videos = get_post_meta($post_id, 'wp_voting_contest_item_video', true);	$wp_voting_contest_item_video = array();	if(isset($wp_voting_item_videos)){		foreach($wp_voting_item_videos as $wp_voting_item_video){			$locate_id = strpos($wp_voting_item_video, '=') + 1;			$id_video = substr($wp_voting_item_video, $locate_id);			$wp_voting_contest_item_video[$post_id] .= $id_video;		}	}	return $wp_voting_contest_item_video;}function getAllYoutubeUrls(){	// Get all published Contests	$args = array(		'post_type' => array('wp_voting_contest'),		'post_status' => array('publish'),		'order' => 'ASC'	);	// The Query	$wp_voting_post_query = new WP_Query($args);	$posts = $wp_voting_post_query->get_posts();	wp_reset_postdata();	// Get Posts IDs of published Contest	$id_posts = [];	foreach ($posts as $post) {		array_push($id_posts, $post->ID);	};	// Get All Youtube Urls from published posts	$yt_urls=[];	foreach ($id_posts as $id_post) {		array_push($yt_urls,get_post_meta($id_post, 'wp_voting_contest_item_video', true));	}	// Put all datas in array	$wp_voting_yt = [];	$yt_size = ['width' => 854, 'height' => 480, 'width_mob' => 640, 'height_mob' => 360];	foreach ($yt_urls as $key => $values) {		foreach ($values as $key => $value) {			$locate_id = strpos($value, '=') + 1;			$id_video = substr($value, $locate_id);			$array_item_yt = [				'id' => $key,				'videoId' => $id_video,				'width' => $yt_size['width'],				'height' => $yt_size['height'],				'width_mobile' => $yt_size['width_mob'],				'height_mobile' => $yt_size['height_mob']			];			if($id_video != false)				array_push($wp_voting_yt, $array_item_yt);		}	}	// Pass datas to JS 	wp_localize_script( 'wp_voting_yt_script', 'wp_voting_item_yt' , $wp_voting_yt );}add_action('wp_enqueue_scripts', 'getAllYoutubeUrls');// Do an extract of item description fieldfunction wp_voting_item_synopsis($text_html, $length = 150, $ellipsis = '...'){	$text = sanitize_text_field($text_html);	if (strlen($text) > $length){		$text = substr($text, 0, $length);				$last_space = strrpos($text, ' ');		if ($last_space !== false){			$text = substr($text, 0, $last_space);		}		$text .= $ellipsis;	}	return $text;}include_once('backend/wp_voting_contest_metaboxes.php');include_once('frontend/wp_voting_contest.php');function get_wp_voting_contest_template($single_template) {	global $post;	if ($post->post_type == 'wp_voting_contest') {		$single_template = dirname( __FILE__ ) . '/frontend/wp_voting_contest-template.php';	}	return $single_template;}add_filter( 'single_template', 'get_wp_voting_contest_template' );wp_enqueue_script( 'wp_voting_ajax', plugins_url( '/assets/js/wp_voting_vote.min.js', __FILE__ ), array('jquery'), '', true );wp_localize_script( 'wp_voting_ajax', 'wp_voting_ajax_obj',	array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );add_action( 'wp_ajax_wp_voting_vote', 'ajax_wp_voting_vote' );add_action( 'wp_ajax_nopriv_wp_voting_vote', 'ajax_wp_voting_vote' );function ajax_wp_voting_vote() {	if(isset($_POST['action']) and $_POST['action'] == 'wp_voting_vote' and $_POST['token'] == $_COOKIE['wPvO'])	{		session_start();		if(isset($_POST['contest_id'])){			$contest_id = intval(sanitize_text_field($_POST['contest_id']));		}		if(isset($_POST['item_id'])){			$item_id = sanitize_text_field($_POST['item_id']);		}				//Validate Contest ID		if ( ! $contest_id ) {			$contest_id = '';			//setcookie ("wp_voting_id-".$contest_id, uniqid(), time() + 3600, '/');			die();		}		//Validate Item ID		if ( ! $item_id ) {			$item_id = '';			//setcookie ("wp_voting_id-".$contest_id, uniqid(), time() + 3600, '/');			die();		}		// Validate Item ID		// IDENTIFICATION BY IP			$oldest_ip_users = get_post_meta($contest_id, 'wp_voting_contest_ip_users',true);		$ip_user = $_SERVER['REMOTE_ADDR'];		foreach($oldest_ip_users as $oldest_ip_users_key){			if($oldest_ip_users_key == $ip_user){				$outputdata['fail']=true;				print_r(json_encode($outputdata));				die();			}		}		// IDENTIFICATION BY COOKIES			// if (isset($_COOKIE['wp_voting_id-'.$contest_id])) {		// 	$outputdata['fail']=true;		// 	print_r(json_encode($outputdata));		// 	die();		//}		$oldest_vote = (int)get_post_meta($contest_id, 'wp_voting_vote_count_'.$item_id,true);		$oldest_total_vote = (int)get_post_meta($contest_id, 'wp_voting_vote_total_count',true);		$new_total_vote = $oldest_total_vote + 1;		$new_vote = ($oldest_vote + 1);		update_post_meta($contest_id, 'wp_voting_vote_count_'.$item_id,$new_vote);		update_post_meta($contest_id, 'wp_voting_vote_total_count',$new_total_vote);		$outputdata = array();		$outputdata['success'] = true;		// IDENTIFICATION BY IP			$new_ip_users = array();		foreach($oldest_ip_users as $oldest_ip_users_key){			if($oldest_ip_users_key){				array_push($new_ip_users,$oldest_ip_users_key);			}		}		array_push($new_ip_users,$ip_user);		update_post_meta($contest_id, 'wp_voting_contest_ip_users',$new_ip_users);		// IDENTIFICATION BY COOKIES		//setcookie ("wp_voting_id-".$contest_id, $contest_id, time() + 3600*24*7*360, '/');		print_r(json_encode($outputdata));	} else {        $outputdata = array();		$outputdata['fail']=true;		print_r(json_encode($outputdata));	}		die();}function wp_voting_register_button( $buttons ) {	array_push( $buttons, "|", "wp_voting" );	return $buttons;}function wp_voting_add_plugin( $plugin_array ) {	$plugin_array['wp_voting'] = plugins_url( '/assets/js/wp_voting_tinymce_btn.min.js', __FILE__ );	return $plugin_array;}function wp_voting_tinymce_setup() {	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {		return;	}	if ( get_user_option('rich_editing') == 'true' ) {		add_filter( 'mce_external_plugins', 'wp_voting_add_plugin' );		add_filter( 'mce_buttons', 'wp_voting_register_button' );	}}add_action('init', 'wp_voting_tinymce_setup');