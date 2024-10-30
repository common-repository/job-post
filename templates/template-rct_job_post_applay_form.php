<?php
if ( ! defined( 'ABSPATH' ) ) exit; session_start();
/**
 * Template Name: RCT Job Post Application Form
 *
 * A template used to demonstrate how to include the template
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
wp_register_script( 'form_submit', plugins_url('/job-post/js/form_submit.js'), array('jquery'));
wp_enqueue_script('form_submit');
wp_register_script( 'form_validate', plugins_url('/job-post/js/jquery.validate.min.js'), array('jquery'),'1.9.0');
wp_enqueue_script('form_validate');

get_header();

//create a captch random number

$ranStr = md5(microtime());
$ranStr = substr($ranStr, 0, 6);
$_SESSION['cap_code'] = $ranStr;
$cap = $_SESSION['cap_code'];

$id_get = null;
$id_get =$_GET['app'];
$args = [
    'post_type' => 'page',
    'fields' => 'ids',
    'nopaging' => true,
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template-rct_job_post_list.php'
];
$pages = get_posts( $args );
$pid = $pages[0];

$args=array(
  'post_type' => 'job_post',
  'post_status' => 'publish',
);
$email = ( get_option('rctjp_smtp_form_email') ? get_option('rctjp_smtp_form_email') : get_option('admin_email'));
?>
<div> <a href="<?php echo get_permalink($pid); ?>"> back to list </a> </div>
<?php
if (isset($_POST['cv_submit'])) {
	
	$applay_position_id = intval($_POST['position_applay']);
	$user_name = esc_html($_POST['p_name']);
	
	if (!is_dir(JOBPOST_DIR_PATH.'uploads')) {
		mkdir(JOBPOST_DIR_PATH.'uploads');         
	}
	$upload_dir = JOBPOST_DIR_PATH.'uploads/'.$user_name;
	
	$allowedExts = array("pdf","txt", "doc", "docx", "dot");
	$extension = end(explode(".", $_FILES["cv"]["name"]));

	if ((($_FILES["cv"]["type"] == "application/pdf")
        || ($_FILES["cv"]["type"] == "application/plain")
		|| ($_FILES["cv"]["type"] == "text/plain")
        || ($_FILES["cv"]["type"] == "application/msword") || ($_FILES["cv"]["type"] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'))
        && in_array($extension, $allowedExts))
	{	
		if(move_uploaded_file($_FILES['cv']["tmp_name"], $upload_dir.'_'.$_FILES['cv']["name"])){
			$query = $wpdb->insert(
			$wpdb->prefix.'applay_position',
			array(
				'position_id' => $applay_position_id,
				'position_name' => get_the_title( $applay_position_id ),
				'upload_cv' => 'Y',
				'fill_form' => 'N'
				)
			);
			$lastid = $wpdb->insert_id;
			$wpdb->insert(
			$wpdb->prefix.'cv_detail',
			array(
				'applay_position_id' => $lastid,
				'name' => $_POST['p_name'],
				'cv_file_name' => $_FILES['cv']["name"],	
				)
			);
			echo "<h3 style='color:green'>Apply Sucessfully<h3>";
		}		
		require_once(JOBPOST_DIR_PATH.'/SMTP/SMTP_config.php');
		$mail->addAddress($email);
		$mail->Subject = "Apply job for ". get_the_title( $applay_position_id );
		$mail->AddAttachment($upload_dir.'_'.$_FILES['cv']["name"]);
		$mail->Body = "Hello sir / madam,  <br>
						<p> Please find attachment.</p> <br>
						<br>
						Thank you
						";
		if(!$mail->Send()) {
		 // echo "Mailer Error: " . $mail->ErrorInfo;
		}
	}else{
		echo '<br><h3 style="color:red">Invaliad Files</h3>';
	}
}
?>
<div id="simple-msg"></div>
<h2 class="text-center title_post">Apply for Job </h2>
<div>
	<h4> Schedule an interview </h4>
</div>
<form action="" id="application_form"  method="post" enctype="multipart/form-data">
	<div>
		 <span> Position Applied For : * <span>
		<select name="position_applay" id="position_applay" required>
			<option value="" selected disabled>-- select --</option>
			<?php 
				$my_query = new WP_Query($args);
				while ($my_query->have_posts()) : $my_query->the_post(); 
					  $val = get_the_id();
					?>
					<option value="<?php the_ID(); ?>"  <?php if($id_get == $val){ echo 'selected'; } ?>> <?php the_title(); ?> </option>
					<?php
				endwhile
			?>
		</select>
	</div>
	<div >
		<input type="radio" name="details" id="d1" value="upload_cv" checked onchange="hideActive(this.id);">
			<label for="d1" > Upload your CV </label>

		<input type="radio" name="details" id="d2" value="fill_form" onchange="hideActive(this.id);"> 
			<label for="d2" > Fill up form </label>	
	</div>
	<div id="div_cv" style="display=block;">
		<h4> Select a text file to upload a resume </h4>
		<div>
			<label> Name :* </label>
			<input type="text" id="p_name" name="p_name" value=""  aria-required="true" maxlength="60" /> 
		</div>
		<div>
			<input type="file" id="cv" name="cv" value="Choose File" aria-required="true">
		</div>
		<div>
			<label>Captcha : </label> 
			<img id="captcha_img" src="<?php echo JOBPOST_URL; ?>/templates/captcha.php" class="cap">
			<a href="#" class="refresh_captcha"><img src="<?php echo JOBPOST_URL; ?>/templates/image/reload1.png" > </a>
			<input type="text" name="rtcjp_captcha_cv" id="rtcjp_captcha_cv" value="" maxlength='6' ><br>
			<input type="hidden" name="rtcjp_captcha_session_cv" id="rtcjp_captcha_session_cv" value="<?php echo $_SESSION['cap_code'];?>"><br>
			<div id="captcha-error-cv"></div>
			<input type="hidden" name="urls" id="urls" value="<?php echo JOBPOST_URL; ?>">
		</div>
		<button type="submit" class="btn btn-info" name="cv_submit"> Applay Job </button>
		
	</div>
</form>	
	<form action="" id="application_form2"  method="post" enctype="multipart/form-data">
	<input type="hidden" id="position_applay2" name="position_applay2"  value="<?php echo $id_get?>" required>
	<div id="div_form" style="display:none;">
		<h4> Personal Information</h4>
		<div>
			<label> Name :* </label>
			<input type="text" id="p_name" name="p_name" value=""  aria-required="true" maxlength="60" /> 
		</div>
		<div>
			<label> Age (In year):* </label>
			<input type="text" name="age" value="" aria-required="true" maxlength="2"  />  <br/>
		</div>
		<div>
			<label> Gender :* </label>
			<input type="radio" name="gender" value="M" id="male" checked required /> <label for="male"> Male </label>
			<input type="radio" name="gender" value="F" id="female" required> <label for="female"> Female </label>  <br/>
		</div>
		<div>
			<label> Current location (city) :*</label>
			<input type="text" name="city" value="" aria-required="true" maxlength="60"  /> <br/>
		</div>
		<div>
			<label> Contact phone / mobile :* </label>
			<input type="text" name="phone_number" value="" aria-required="true" maxlength="10"  /> <br/>
		</div>
		<div>
			<label> Contact email :* </label>
			<input type="email" name="email_address" value="" aria-required="true" maxlength="60"  /> <br/>
		</div>
		<div>
			<label> Qualification :* </label>
			<input type="text" name="qualification" value="" aria-required="true" maxlength="100"  /> <br/>
		</div>
		<h4> Education </h4>
		<table>
			<head>
				<th>QUALIFICATION</th>
				<th>SCHOOL/COLLEGE NAME</th>
				<th>YEAR</th>
				<th>MARKS[%]</th>
				<th>LOCATION</th>
			</head>
			<body>
				<tr>
					<td>S.S.C. / Eq : *</td>
					<td><input type="text" name="ssc_school" value="" aria-required="true" maxlength="100" ></td>
					<td><input type="text" name="ssc_year" value="" aria-required="true" maxlength="4" ></td>
					<td><input type="text" name="ssc_mark" value="" aria-required="true" maxlength="5"  ></td>
					<td><input type="text" name="ssc_location" value="" aria-required="true" maxlength="100" ></td>
				</tr>
				<tr>
					<td>H.S.C. / Eq : *</td>
					<td><input type="text" name="hsc_school" value="" aria-required="true" maxlength="100" ></td>
					<td><input type="text" name="hsc_year" value="" aria-required="true" maxlength="4" ></td>
					<td><input type="text" name="hsc_mark" value="" aria-required="true" maxlength="5" ></td>
					<td><input type="text" name="hsc_location" value="" aria-required="true" maxlength="100" ></td>
				</tr>
				<tr>
					<td>Graduation :</td>
					<td><input type="text" name="gdu_school" value="" aria-required="true" maxlength="100" ></td>
					<td><input type="text" name="gdu_year" value="" aria-required="true" maxlength="4" ></td>
					<td><input type="text" name="gdu_mark" value="" aria-required="true" maxlength="5" ></td>
					<td><input type="text" name="gdu_location" value="" aria-required="true" maxlength="100" ></td>
				</tr>
				<tr>
					<td>PG / Diploma :</td>
					<td><input type="text" name="pg_school" value="" aria-required="true" maxlength="100" ></td>
					<td><input type="text" name="pg_year" value="" aria-required="true" maxlength="4" ></td>
					<td><input type="text" name="pg_mark" value="" aria-required="true" maxlength="5" ></td>
					<td><input type="text" name="pg_location" value="" aria-required="true" maxlength="100" ></td>
				</tr>
				<tr>
					<td>Any other education or qualification :</td>
					<td><input type="text" name="otr_school" value="" aria-required="true" maxlength="100" ></td>
					<td><input type="text" name="otr_year" value="" aria-required="true" maxlength="4" ></td>
					<td><input type="text" name="otr_mark" value="" aria-required="true" maxlength="5" ></td>
					<td><input type="text" name="otr_location" value="" aria-required="true" maxlength="100" ></td>
				</tr>
			</body>
		</table>
		
		<h4> Employment </h4>
		<div>
			<label>Years Of experience :*	 </label>
			<select  name="year_experiance" required /> 
				<option value="" selected disabled>-- select --</option>
				<option value="Fresher"> Fresher</option>
				<option value="6 month and above"> 6 Month and above</option>
				<option value="1 Year and above"> 1 Year and above </option><option value=""> </option>
				<option value="2 Year and above"> 2 Year and above </option>
				<option value="3 Year and above"> 3 Year and above</option>
				<option value="4 Year and above"> 4 Year and above</option>
				<option value="5 Year and above"> 5 Year and above</option>
				<option value="6 Year and above"> 6 Year and above</option>
				<option value="7 Year and above"> 7 Year and above</option>
				<option value="8 Year and above"> 8 Year and above</option>
				<option value="9 Year and above"> 9 Year and above</option>
				<option value="10 Year and above"> 10 Year and above</option>
			</select>
		</div>
		<div>
			<label>Present salary :* </label>
			<input type="text" name="salary" value="0" aria-required="true" maxlength="100" /> <br/>
		</div>
		<div>
			<label>Type of employment seeking : </label>
			<select name="emp_seeking" />
				<option value="" selected disabled>-- select --</option>
				<option value="Part time">Part time</option>
				<option value="Full time">Full time</option>
				<option value="Contract">Contract</option>
				<option value="Consulting">Consulting</option>
				<option value="Freelancing">Freelancing</option>
				<option value="Night shift">Night shift</option>
			</select>
		</div>
		
		<h4>Skills </h4>
		<div>
			<label> Your technical skills/strengths:* </label>
			<textarea name="skill_strength" aria-required="true" maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label> Your personal attributes: </label>
			<textarea name="attributes" maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label>Professional history, details about projects/work done. </label>
			<textarea name="project_work" maxlength="800"> </textarea><br/>
		</div>
		
		<h4>More About You</h4>
		<div>
			<label> Describe your work areas, roles and responsibilities involved in your current job.* </label>
			<textarea name ="roles" required maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label> What do you like or dislike about the current company you work for now?* </label>
			<textarea name="dislike_company" required maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label> How would your co-worker describe you as a person? </label>
			<textarea name="coworker" maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label> Reason for looking job change with the current company.* </label>
			<textarea name="change_reason" required maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label> Our clients are mostly USA / UK based, are you ready to work in night shift, if needed? </label>
			<textarea name="night_shift" maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label> Describe your family background?* </label>
			<textarea name="family_bg" required maxlength="800"> </textarea><br/>
		</div>
		<div>
			<label> What are the three most important accomplishments in your life so far? <br/>
			(Please complete this even if you are a fresher.)</label>
			<textarea name="accomplishments"> </textarea><br/>
			<input type="hidden" name="urls" id="urls" value="<?php echo JOBPOST_URL; ?>">
		</div>
		<!--add capcha -->
		<div>
			<label>Captcha</label> 
			<img src="<?php echo JOBPOST_URL; ?>/templates/captcha.php" class="cap">
			<a href="#" class="refresh_captcha"> <img src="<?php echo JOBPOST_URL; ?>/templates/image/reload1.png" > </a>
			<input type="text" name="rtcjp_captcha" id="rtcjp_captcha" value="" maxlength='6' class="demoInputBox"><br>
			<input type="hidden" name="rtcjp_captcha_session" id="rtcjp_captcha_session" value="<?php echo $_SESSION['cap_code'];?>"><br>
			<div id="captcha-error"></div>
		</div>
		<button type="submit" name="fill_up_form" class="btn btn-info" id="fill_up_form" > Applay Job </button>
	</div>	
</form>
<?php
get_footer();
?>
