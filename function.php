<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
function rctjp_register_jost_post(){
	$args = array();
	
	$labels = array(
    'name'               => _x( 'Job Post', 'post type general name' ),
    'singular_name'      => _x( 'Job Post', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Job Post' ),
    'add_new_item'       => __( 'Add New Job Post' ),
    'edit_item'          => __( 'Edit Job Post' ),
    'new_item'           => __( 'New Job Post' ),
    'all_items'          => __( 'All Job Post' ),
    'view_item'          => __( 'View Job Post' ),
    'search_items'       => __( 'Search Job Post' ),
    'not_found'          => __( 'No Job Post found' ),
    'not_found_in_trash' => __( 'No Job Post found in the Trash' ), 
    'parent_item_colon'  => __( 'Job Post:', 'job_post-textdomain' ),
    'menu_name'          => 'Job Post'
  );
  $args = array(
    'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	//'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
	'rewrite' => true,
	'capability_type' => 'post',
	'has_archive' => 'job',
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title','editor','excerpt')
  );
  register_post_type( 'job_post', $args ); 
}

function rctjp_register_taxonomies_job_post(){
	$texonomies_args = array();
	$labels = array(
    'name'              => _x( 'Job Post Category', 'taxonomy general name' ),
    'singular_name'     => _x( 'Job Post Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Job Post Category' ),
    'all_items'         => __( 'All Job Post Categories' ),
    'parent_item'       => __( 'Parent Job Post Category' ),
    'parent_item_colon' => __( 'Parent Job Post Category:' ),
    'edit_item'         => __( 'Edit Job Post Category' ), 
    'update_item'       => __( 'Update Job Post Category' ),
    'add_new_item'      => __( 'Add New Job Post Category' ),
    'new_item_name'     => __( 'New Job Post Category' ),
    'menu_name'         => __( 'Job Post Categories' ),
  );
  $texonomies_args = array(
    'labels' => $labels,
    'hierarchical' => true,
	'slug' => 'job_post_category',
	'query_var' => true,
	'rewrite' =>true
  );
  register_taxonomy( 'job_post_category', 'job_post', $texonomies_args );
}
function rctjp_exp_meta_boxes(){
	//experiance
	add_meta_box( 
        'job_post_exp_box',
        'Experience',
        'rctjp_exp_box_content',
        'job_post',
        'normal',
        'high'
    );
}
function rctjp_qua_meta_boxes(){
	
	// qualification
	add_meta_box( 
        'job_post_qua_box',
        'Qualifiaction',
        'rctjp_qua_box_content',
        'job_post',
        'normal',
        'high'
    );
}

function rctjp_exp_box_content( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'job_post_exp_box_content_nonce' );
	$experiance = get_post_meta( get_the_ID(), 'job_post_exp', true );
	echo '<label for="job_post_exp"></label>';
	echo '<input type="text" id="job_post_exp" name="job_post_exp" placeholder="enter experience"  value="'.$experiance.'" />';
}

function rctjp_qua_box_content( $post ) {
	$qualification = get_post_meta( get_the_ID(), 'job_post_qua', true );
	wp_nonce_field( plugin_basename( __FILE__ ), 'job_post_qua_box_content_nonce' );
	echo '<label for="job_post_qua"></label>';
	echo '<input type="text" id="job_post_qua" name="job_post_qua" placeholder="enter qualification for job post" value="'.$qualification.'"  />';
}

//save experiance
add_action( 'save_post', 'rctjp_exp_box_save' );
function rctjp_exp_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	if ( !wp_verify_nonce( $_POST['job_post_exp_box_content_nonce'], plugin_basename( __FILE__ ) ) )
		return;
	if ( !wp_verify_nonce( $_POST['job_post_qua_box_content_nonce'], plugin_basename( __FILE__ ) ) )
		return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	$job_post_exp = $_POST['job_post_exp'];
	$job_post_qua = $_POST['job_post_qua'];
	update_post_meta( $post_id, 'job_post_exp', $job_post_exp );
	update_post_meta( $post_id, 'job_post_qua', $job_post_qua );
 	
	$taxonomies = get_object_taxonomies( 'job_post' );
	
	foreach ( (array) $taxonomies as $taxonomy ) {
		$category = get_term_by('name', 'Current Openings', 'job_post_category');
		$count =  $category->count + 1;
		 $terms = wp_get_post_terms( $post_id, 'job_post_category');
		if ( empty( $terms )){
			$data_qty = array('object_id' => $post_id, 'term_taxonomy_id' => $category->term_id, 'term_order'=>0);
			global $wpdb;
			$second_qty = $wpdb->insert(
			'wp_term_relationships',
			$data_qty
			);
			$second_qty = $wpdb->get_row("UPDATE wp_term_taxonomy SET count=".$count." WHERE term_id = ".$category->term_id);
		}
	}
}
function rctjp_user_list_menu() {
	add_submenu_page( 'edit.php?post_type=job_post', __( 'Job Post', 'jobpost' ), __( 'Applications', 'jobpost' ), 'read_private_pages', 'rctjp_admin_user_list_page', 'rctjp_admin_user_list_page' );
}
function rctjp_admin_user_list_page(){
	include_once(JOBPOST_DIR_PATH.'jop-post-list-user.php');
}
function rctjp_smtp_config() {
	add_submenu_page( 'edit.php?post_type=job_post', __( 'Job Post', 'jobpost' ), __( 'SMTP Config', 'jobpost' ), 'read_private_pages', 'rctjp_smtp_config_page', 'rctjp_smtp_config_page' );
}
function rctjp_smtp_config_page(){
	include_once(JOBPOST_DIR_PATH.'rctjp_smtp_config_page.php');
}
// add default category
function rctjp_set_default_category() {
	wp_insert_term(
		'Current Openings',
		'job_post_category',
		array(
		  'description'	=> 'This is an default category of job post.',
		  'slug' 		=> 'current-openings'
		)
	);
}
function RCT_Job_Post_uninstall() {
	
	global $wpdb;
	
	$table_name1 = $wpdb->prefix . "applay_position";
	$table_name2 = $wpdb->prefix . "application_detail";
	$table_name3 = $wpdb->prefix . "cv_detail";
	$wpdb->query("DROP TABLE IF EXISTS $table_name1");
	$wpdb->query("DROP TABLE IF EXISTS $table_name2");
	$wpdb->query("DROP TABLE IF EXISTS $table_name3");
	
}
function rctjp_alert_message_smtp_config( $post_type ) { ?>
    <div class="after-title-help postbox">
        <div class="inside" style="">
			<h3> SMTP Configuration :</h3>
            <p> Please configure SMTP configuration <a href="edit.php?post_type=job_post&page=rctjp_smtp_config_page"> HERE </a> otherwise candidate will not able to send/receive email notification </p>
        </div><!-- .inside -->
    </div><!-- .postbox -->
<?php }

// CALL ACTIONS
add_action( 'init', 'rctjp_register_jost_post' );
add_action( 'init', 'rctjp_register_taxonomies_job_post', 0 );
add_action( 'add_meta_boxes', 'rctjp_qua_meta_boxes' );
add_action( 'add_meta_boxes', 'rctjp_exp_meta_boxes' );
add_action( 'admin_menu', 'rctjp_user_list_menu' );
add_action( 'init', 'rctjp_set_default_category' );
add_action( 'admin_menu', 'rctjp_smtp_config' );
if ( function_exists('register_uninstall_hook') )
{
	register_uninstall_hook( __FILE__, 'RCT_Job_Post_uninstall' );
}
if(!get_option('rctjp_smtp_host') || !get_option('rctjp_smtp_port') || !get_option('rctjp_smtp_username') || !get_option('rctjp_smtp_password')){
	add_action( 'admin_notices', 'rctjp_alert_message_smtp_config' );
}
?>