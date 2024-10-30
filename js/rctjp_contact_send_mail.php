<?php
function rctjp_contact_send_mail(){
 global $wpdb;
$email = ( get_option('rctjp_smtp_form_email') ? get_option('rctjp_smtp_form_email') : get_option('admin_email'));
$data = $_POST;

foreach($data['data'] as $postdata){
	$postvalue[$postdata['name']] = $postdata['value'];
}
print_r($postvalue);

$applay_position_id = $postvalue['position_applay2'];
$query = $wpdb->insert(
		$wpdb->prefix.'applay_position',
		array(
			'position_id' => $applay_position_id,
			'position_name' => get_the_title( $applay_position_id ),
			'upload_cv' => 'N',
			'fill_form' => 'Y'
			)
		);
echo $lastid = $wpdb->insert_id;	
//personal details
$p_name 			= sanitize_text_field($postvalue['p_name']);
$age 				= intval($postvalue['age']);
$gender 			= sanitize_text_field($postvalue['gender']);
$city 				= sanitize_text_field($postvalue['city']);
$phone_number 		= intval($postvalue['phone_number']);
$email_address 		= sanitize_email($postvalue['email_address']);
$qualification 		= esc_html($postvalue['qualification']);
//education details
$ssc_school 		= esc_html($postvalue['ssc_school']);
$ssc_year 			= intval($postvalue['ssc_year']);
$ssc_mark 			= floatval($postvalue['ssc_mark']);
$ssc_location 		= esc_html($postvalue['ssc_location']);
$hsc_school 		= esc_html($postvalue['hsc_school']);
$hsc_year 			= intval($postvalue['hsc_year']);
$hsc_mark 			= floatval($postvalue['hsc_mark']);
$hsc_location 		= esc_html($postvalue['hsc_location']);
$gdu_school 		= esc_html($postvalue['gdu_school']);
$gdu_year 			= intval($postvalue['gdu_year']);
$gdu_mark 			= floatval($postvalue['gdu_mark']);	
$gdu_location 		= esc_html($postvalue['gdu_location']);
$pg_school 			= esc_html($postvalue['pg_school']);
$pg_year 			= intval($postvalue['pg_year']);
$pg_mark 			= floatval($postvalue['pg_mark']);
$pg_location 		= esc_html($postvalue['pg_location']);
$otr_school 		= esc_html($postvalue['otr_school']);
$otr_year 			= intval($postvalue['otr_year']);
$otr_mark 			= floatval($postvalue['otr_mark']);
$otr_location 		= esc_html($postvalue['otr_location']);
//	employment detail
$year_experiance 	= esc_html($postvalue['year_experiance']);
$salary 			= floatval($postvalue['salary']);
$emp_seeking 		= esc_html($postvalue['emp_seeking']);
//other details
$skill_strength 	= esc_html($postvalue['skill_strength']);
$attributes 		= esc_html($postvalue['attributes']);
$project_work 		= esc_html($postvalue['project_work']);
$roles 				= esc_html($postvalue['roles']);
$dislike_company 	= esc_html($postvalue['dislike_company']);
$coworker 			= esc_html($postvalue['coworker']);
$change_reason 		= esc_html($postvalue['change_reason']);
$night_shift 		= esc_html($postvalue['night_shift']);
$family_bg 			= esc_html($postvalue['family_bg']);
$accomplishments 	= esc_html($postvalue['accomplishments']);

$data_qty=	array(
		'applay_position_id' => $lastid,
		'name' => $p_name,
		'age' => $age,
		'gender' => $gender,
		'city' => $city,
		'phone_number' => $phone_number,
		'email_address' => $email_address,
		'qualification' => $qualification,
		'ssc_school' => $ssc_school,
		'ssc_year' => $ssc_year,
		'ssc_mark' => $ssc_mark,
		'ssc_location' => $ssc_location,
		'hsc_school' => $hsc_school,
		'hsc_year' => $hsc_year,
		'hsc_mark' => $hsc_mark,
		'hsc_location' => $hsc_location,
		'gdu_school' => $gdu_school,
		'gdu_year' => $gdu_year,
		'gdu_mark' => $gdu_mark,
		'gdu_location' => $gdu_location,
		'pg_school' => $pg_school,
		'pg_year' => $pg_year,
		'pg_mark' => $pg_mark,
		'pg_location' => $pg_location,
		'otr_school' => $otr_school,
		'otr_year' => $otr_year,
		'otr_mark' => $otr_mark,
		'otr_location' => $otr_location,
		'year_experiance' => $year_experiance,
		'salary' => $salary,
		'emp_seeking' => $emp_seeking,
		'skill_strength' => $skill_strength,
		'attributes' => $attributes,
		'project_work' => $project_work,
		'roles' => $roles,
		'dislike_company' => $dislike_company,
		'coworker' => $coworker,
		'change_reason' => $change_reason,
		'night_shift' => $night_shift,
		'family_bg' => $family_bg,
		'accomplishments' => $accomplishments,
	);
	
print_r($data_qty);

echo $second_qty = $wpdb->insert(
	$wpdb->prefix.'application_detail',
	$data_qty
);

//email template

$body = 'Hello sir / madam';

$body .= '<h1> Applicant Information </h1> <br/> Applicant Name : '.$p_name.' <br> Gender : '.($gender == "M" ? "Male" : "Femail" ).'<br> Email Address : '.$email_address.' <br>Phone Number : '.$phone_number.' <br>City : '.$city.' <br>Age : '.$age.'<br>Qualification : '.$qualification.'<br>';
			
$body .= '<h1>Education Details </h1> <br> 
		 <table  border="1">
			<head>
				<tr>
					<td><b>Qualification </b></td>
					<td><b>School/College Name </b> </td>
					<td><b>Year</b> </td>
					<td><b>Marks</b>[%]</td>
					<td><b>Location</b></td>
				</tr>
			</head>
			<body>
				<tr>
					<td>S.S.C. / Eq : </td>
					<td>'.$ssc_school.'</td>
					<td>'.$ssc_year.'</td>
					<td>'.$ssc_mark.'</td>
					<td>'.$ssc_location.'</td>
				</tr>
				<tr>
					<td>H.S.C. / Eq : </td>
					<td>'.$hsc_school.'</td>
					<td>'.$hsc_year.'</td>
					<td>'.$hsc_mark.'</td>
					<td>'.$hsc_location.'</td>
				</tr> 
				<tr>
					<td>Graduation :</td>
					<td>'.$gdu_school.'</td>
					<td>'.$gdu_year.'</td>
					<td>'.$gdu_mark.'</td>
					<td>'.$gdu_location.'</td>
				</tr>
				
				
				<tr>
					<td>PG / Diploma :</td>
					<td>'.$pg_school.'</td>
					<td>'.$pg_year.'</td>
					<td>'.$pg_mark.'</td>
					<td>'.$pg_location.'</td>
				</tr>
				
				
				<tr>
					<td>Any other Education or Qualification :</td>
					<td>'.$otr_school.'</td>
					<td>'.$otr_year.'</td>
					<td>'.$otr_mark.'</td>
					<td>'.$otr_location.'</td>
				</tr>
			
			</body>
		</table> <br/>';
		
$body .= '<h1> Employment Details </h1> <br>
			Years Of Experience : '.$year_experiance.'<br>
			Present Salary : '.$salary.' <br>
			Type Of Employment seeking : '.$emp_seeking.' <br>
	    	';
$body .= '<h1> Skills </h1> <br>
			Technical Skills/Strengths: '.$skill_strength.' <br> 
			Personal Attributes: '.$attributes.' <br>
			Professional History, Details about projects/work done. : '.$project_work.' <br>
		 ';
$body .= '<h1> More About Applicant </h1> <br>
			Work Areas, Roles and Responsibilities involved in current job : '.$roles.' <br>
			like or dislike about the current company : '.$dislike_company.' <br>
			co-worker describe : '.$coworker.' <br>
			Reason for job change : '.$change_reason.' <br>
			Ready work in night shift : '.$night_shift.' <br>
			Family background details : '.$family_bg.' <br>
			The three most important accomplishments : '.$accomplishments.' <br>
		 ';
$body .= '<br> Thank You';

	include(dirname(dirname ( __FILE__ )).'\SMTP\SMTP_config.php');
	
	$mail->addAddress($email);
	$mail->Subject = "Apply job for ". get_the_title( $applay_position_id );
	
	$mail->Body = $body;
	
	//$mail->AltBody = "This is the plain text version of the email content";

	if($mail->Send()) {
	  echo "Message sent!";
	} else {
	 // echo "Mailer Error: " . $mail->ErrorInfo;
	}

}

?>