<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
// create table to register user data store
register_activation_hook( __FILE__, 'rctjp_table_install' );
function rctjp_table_install() {
	global $wpdb;
	//$wpdb->prefix
	$charset_collate = $wpdb->get_charset_collate();

	$sql_1 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."applay_position` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `position_id` int(11) DEFAULT NULL,
			  `position_name` text,
			  `upload_cv` enum('Y','N') DEFAULT NULL,
			  `fill_form` enum('Y','N') DEFAULT NULL,
			  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

		
	$sql_2 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."application_detail` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `applay_position_id` int(11) DEFAULT NULL,
		  `name` varchar(250) DEFAULT NULL,
		  `age` FLOAT(11) DEFAULT NULL,
		  `gender` varchar(200) DEFAULT NULL,
		  `city` longtext,
		  `phone_number` int(11) DEFAULT NULL,
		  `email_address` varchar(250) DEFAULT NULL,
		  `qualification` varchar(250) DEFAULT NULL,
		  `ssc_school` varchar(250) DEFAULT NULL,
		  `ssc_year` int(11) DEFAULT NULL,
		  `ssc_mark` FLOAT(11) DEFAULT NULL,
		  `ssc_location` varchar(250) DEFAULT NULL,
		  `hsc_school` varchar(250) DEFAULT NULL,
		  `hsc_year` int(11) DEFAULT NULL,
		  `hsc_mark` FLOAT(11) DEFAULT NULL,
		  `hsc_location` varchar(250) DEFAULT NULL,
		  `gdu_school` varchar(250) DEFAULT NULL,
		  `gdu_year` int(11) DEFAULT NULL,
		  `gdu_mark` FLOAT(11) DEFAULT NULL,
		  `gdu_location` varchar(250) DEFAULT NULL,
		  `pg_school` varchar(250) DEFAULT NULL,
		  `pg_year` int(11) DEFAULT NULL,
		  `pg_mark` FLOAT(11) DEFAULT NULL,
		  `pg_location` varchar(250) DEFAULT NULL,
		  `otr_school` varchar(250) DEFAULT NULL,
		  `otr_year` int(11) DEFAULT NULL,
		  `otr_mark` FLOAT(11) DEFAULT NULL,
		  `otr_location` varchar(250) DEFAULT NULL,
		  `year_experiance` varchar(250) DEFAULT NULL,
		  `salary`   FLOAT(11) DEFAULT NULL,
		  `emp_seeking` longtext,
		  `skill_strength` longtext,
		  `attributes` longtext,
		  `project_work` longtext,
		  `roles` longtext,
		  `dislike_company` longtext,
		  `coworker` longtext,
		  `change_reason` longtext,
		  `night_shift` longtext,
		  `family_bg` longtext,
		  `accomplishments` longtext,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

	$sql_3 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."cv_detail` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `applay_position_id` int(11) DEFAULT NULL,
		  `name` varchar(250) DEFAULT NULL,
		  `cv_file_name` varchar(250) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql_1 );
	dbDelta( $sql_2 );
	dbDelta( $sql_3 );
}

?>