<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Template Name: RCT Job Post List
 *
 * The second template used to demonstrate how to include the template
 * using this plugin.
 *
 * @package PTE
 * @since 	1.0.0
 * @version	1.0.0
 */
?>

<?php
wp_enqueue_style('custom_style', plugins_url('/job-post/css/custom_style.css'), false);
wp_enqueue_style('admin_css_bootstrap', plugins_url('/job-post/css/bootstrap.css'), false, '2.3.2', 'all');

get_header(); 

//temaplte page ids
$args = [
    'post_type' => 'page',
    'fields' => 'ids',
    'nopaging' => true,
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template-rct_job_post_applay_form.php'
];
$pages = get_posts( $args );
foreach ( $pages as $page ) {
     $pid = $page ;
}
///---- for pagination----------/////
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$total_cat = count(get_terms('job_post_category'));
$per_page    = 2;
$total_pages = ceil($total_cat/$per_page);
$offset      = $per_page * ( $paged - 1) ;
$args = array(
        'order'        => 'ASC',
        'orderby'      => 'menu_order',
		'offset'       => $offset,
		'number'	   => $per_page
);
$mystring = get_permalink($pid);
$findme = '?';
$pos = strstr($mystring, $findme);
//...............................List of job post......................................................//
$categories = get_terms('job_post_category', $args);

if ( ! empty( $categories ) ) {
    
	foreach($categories as $cate){
		echo '<div class="title_post"><h3  class="post_name">' . esc_html( $cate->name ); 
		echo '</h3></div>';
		if($cate->description){
			echo '<h3 class="text-center post_desc">'. $cate->description . '</h3>'; 
		}
		$catPost = get_posts(array('post_type' => 'job_post','orderby'=> 'date','order'=> 'DESC','posts_per_page' => -1));		
		foreach ($catPost as $post) : setup_postdata($post); ?>
		<?php $cat = get_the_term_list( get_the_ID(), 'job_post_category','', ',','' );
		$pieces = explode(",", strip_tags($cat));
		if(in_array($cate->name,$pieces) && get_post_meta( get_the_ID(), 'job_post_exp', true ) && get_post_meta( get_the_ID(), 'job_post_qua', true )){
			?>
			<h3 class="p_title"><?php the_title(); ?></h3>
			<div class="entry-content">
			<?php 
				the_content( sprintf(
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
					get_the_title()
				) );
				echo "<div> <b>Experiance : </b><span>" . get_post_meta( get_the_ID(), 'job_post_exp', true ) .'</span></div>';
				echo "<div> <b>Qualification : </b><span>". get_post_meta( get_the_ID(), 'job_post_qua', true ). '</span></div>';
			?>
			</div> 
			<?php if($pos){ ?>
			<a href="<?php echo get_permalink($pid); ?>&app=<?php the_ID(); ?>" class="btn btn-info"> Applay now </a>
			<hr >
		<?php  	
			}
			else{
				?>
				<a href="<?php echo get_permalink($pid); ?>?app=<?php the_ID(); ?>" class="btn btn-info"> Applay now </a>
				<hr >
				<?php
			}
		}
		endforeach;
		rewind_posts();
		wp_reset_query();
	}
	?>
	<div class="pg_main">
		<diV class="pull-left"><?php previous_posts_link('« Previous Entries ') ?> </div>
		<div class="pull-right"><?php next_posts_link('Next Entries »',$total_pages  ) ?> </div>
	</div>
	<?php
}
else{
	echo '<center><h1>Sorry!!! No Job Post Found</h1><center>';
}
get_footer();ob_flush(); ?>