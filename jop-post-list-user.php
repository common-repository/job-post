<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<style>
.pg_main span,.pg_main a{
	padding: 5px;
    border: 1px solid #00A0D2;
	text-decoration: none;
}
</style>

<?php
global $wpdb;

define( 'USER_LIST_URL', "edit.php?post_type=job_post&page=rctjp_admin_user_list_page" );
$max = 15;
if(isset($_GET['pg'])){
    $p = $_GET['pg'];
}else{
    $p = 1;
}
$limit = ($p - 1) * $max;
$prev = $p - 1;
$next = $p + 1;
$limits = (int)($p - 1) * $max;

$results_count = $wpdb->get_results( 'SELECT count(*) as count FROM '.$wpdb->prefix.'applay_position LEFT JOIN '.$wpdb->prefix.'application_detail ON '.$wpdb->prefix.'application_detail.applay_position_id = '.$wpdb->prefix.'applay_position.id LEFT JOIN '.$wpdb->prefix.'cv_detail ON '.$wpdb->prefix.'cv_detail.applay_position_id = '.$wpdb->prefix.'applay_position.id');
$totalposts = ceil($results_count[0]->count / $max);

if(!isset($_REQUEST['jobs'])){
?>
<h1> Job Post : Applications </h1>
<table class="widefat fixed" cellspacing="0">
    <thead>
    <tr>
            <th id="cb" class="manage-column column-cb check-column" scope="col"></th> 
            <th id="columnname" class="manage-column column-columnname" scope="col">Application</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Name</th> 
			<th id="columnname" class="manage-column column-columnname" scope="col">City</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Phone number</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Email address</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Qualification</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Experiance</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Salary</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Upload CV</th>
	</tr>
    </thead>
   <tfoot>
    <tr>
            <th class="manage-column column-cb check-column" scope="col"></th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Application</th>
            <th id="columnname" class="manage-column column-columnname" scope="col">Name</th> 
			<th id="columnname" class="manage-column column-columnname" scope="col">City</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Phone number</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Email address</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Qualification</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Experiance</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Salary</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Upload CV</th>
    </tr>
    </tfoot>
    <tbody>
		<?php
		//foreach ($catPost as $post) : setup_postdata($post);
			//echo $post->ID;
			//$results = $wpdb->get_results( 'SELECT *, '.$wpdb->prefix.'applay_position.id as job_id FROM  '.$wpdb->prefix.'applay_position LEFT JOIN '.$wpdb->prefix.'application_detail ON '.$wpdb->prefix.'application_detail.applay_position_id = '.$wpdb->prefix.'applay_position.id group by '.$wpdb->prefix.'application_detail.applay_position_id ORDER BY '.$wpdb->prefix.'application_detail.applay_position_id DESC  LIMIT '.$limits.','.$max.'');
			$results = $wpdb->get_results( 'SELECT *, '.$wpdb->prefix.'applay_position.id as job_id, '.$wpdb->prefix.'cv_detail.name as upload_name, '.$wpdb->prefix.'application_detail.name as detail_name FROM '.$wpdb->prefix.'applay_position LEFT JOIN '.$wpdb->prefix.'application_detail ON '.$wpdb->prefix.'application_detail.applay_position_id = '.$wpdb->prefix.'applay_position.id LEFT JOIN '.$wpdb->prefix.'cv_detail ON '.$wpdb->prefix.'cv_detail.applay_position_id = '.$wpdb->prefix.'applay_position.id ORDER BY '.$wpdb->prefix.'applay_position.id DESC LIMIT '.$limits.','.$max.'');
			echo "<pre>";
			$index = 1;
			if(count($results)>0){
				foreach($results as $res){
					echo '<tr class="alternate">';
						echo '<th class="check-column" scope="row"><center>'.$index.'</center></th>';
						echo '<td class="column-columnname">'.($res->fill_form == "Y" ? '<a href="'.USER_LIST_URL.'&jobs='.$res->job_id.'">'.$res->position_name: $res->position_name).'</td>';
						echo '<td class="column-columnname">'.($res->fill_form == "Y" ? $res->detail_name : $res->upload_name).'</td>';
						echo '<td class="column-columnname">'.($res->city ? $res->city : "-").'</td>';
						echo '<td class="column-columnname">'.($res->phone_number ? $res->phone_number : "-").'</td>';
						echo '<td class="column-columnname">'.($res->email_address ? $res->email_address : "-").'</td>';
						echo '<td class="column-columnname">'.($res->qualification ? $res->qualification : "-").'</td>';
						echo '<td class="column-columnname">'.($res->year_experiance ? $res->year_experiance : "-").'</td>';
						echo '<td class="column-columnname">'.($res->salary ? $res->salary : "-").'</td>';
						echo '<td class="column-columnname"><a href="'.JOBPOST_URL.'/uploads/'.$res->upload_name.'_'.$res->cv_file_name.'" download>'.$res->cv_file_name.'</a></td>';
					echo '</tr>';
					$index++;
				}
			}
			else{
				echo '<tr class="alternate">';
				echo '<td class="column-columnname" colspan="5">  No Records Found </td>';
				echo '</tr>';
			}
		//endforeach;	
		?>
    </tbody>
</table>
<br/>
<?php
echo rctjp_pagination($totalposts,$p,$lpm1,$prev,$next);
}
if(isset($_REQUEST['jobs'])){
	
	$job = $_GET['jobs'];
	$result = $wpdb->get_results( 'SELECT * FROM  '.$wpdb->prefix.'applay_position LEFT JOIN '.$wpdb->prefix.'application_detail ON '.$wpdb->prefix.'application_detail.applay_position_id = '.$wpdb->prefix.'applay_position.id where '.$wpdb->prefix.'applay_position.id ='. $job);
	echo "<pre>";
	//print_r($result);
	foreach($result as $data){
		echo '<h1> Applay Position : '.$data->position_name.'</h1>';
		echo '<h2> Personal Information :</h2>'; 
		?>
			<table class="form-table" >
				<body>
					<tr class="user-description-wrap alternate">
						<th> Name : </th>
						<td > <?php echo $data->name; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th> Age : </th>
						<td>  <?php echo $data->age; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th> Gender : </th>
						<td><?php echo ($data->gender == 'F' ? 'Female' : 'Male') ; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th> Current Location (city) : </th>
						<td> <?php echo $data->city; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th> Contact Phone / Mobile : </th>
						<td> <?php echo $data->phone_number; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th>  Contact Email : </th>
						<td> <?php echo $data->email_address; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th> Qualification : </th>
						<td>  <?php echo $data->qualification; ?> </td>
					</tr>
								
				</body>
			</table>
		<?php
		
		echo '<h2> Education :</h2>'; 
		echo '<table class="widefat fixed" cellspacing="0">
				<head>
					<tr>
						<th class="manage-column column-columnname" scope="col"><b>Qualification </b></th>
						<th class="manage-column column-columnname" scope="col"><b>School/College Name </b> </th>
						<th class="manage-column column-columnname" scope="col"><b>Year</b> </th>
						<th class="manage-column column-columnname" scope="col"><b>Marks</b>[%]</th>
						<th class="manage-column column-columnname" scope="col"><b>Location</b></th>
					</tr>
				</head>
				<body>
					<tr class="alternate">
						<td class="column-columnname">S.S.C. / Eq : </td>
						<td class="column-columnname">'.$data->ssc_school .'</td>
						<td class="column-columnname">'.$data->ssc_year .'</td>
						<td class="column-columnname">'.$data->ssc_mark .'</td>
						<td class="column-columnname">'.$data->ssc_location .'</td>
					</tr>
					<tr class="alternate">
						<td class="column-columnname">H.S.C. / Eq  : </td>
						<td class="column-columnname">'.$data->hsc_school .'</td>
						<td class="column-columnname">'.$data->hsc_year .'</td>
						<td class="column-columnname">'.$data->hsc_mark .'</td>
						<td class="column-columnname">'.$data->hsc_location .'</td>
					</tr>
					<tr class="alternate">
						<td class="column-columnname">Graduation : </td>
						<td class="column-columnname">'.$data->gdu_school .'</td>
						<td class="column-columnname">'.$data->gdu_year .'</td>
						<td class="column-columnname">'.$data->gdu_mark .'</td>
						<td class="column-columnname">'.$data->gdu_location .'</td>
					</tr>
					<tr class="alternate">
						<td class="column-columnname">PG / Diploma : </td>
						<td class="column-columnname">'.$data->pg_school .'</td>
						<td class="column-columnname">'.$data->pg_year .'</td>
						<td class="column-columnname">'.$data->pg_mark .'</td>
						<td class="column-columnname">'.$data->pg_location .'</td>
					</tr>
					<tr class="alternate">
						<td class="column-columnname">Any other Education or Qualification : </td>
						<td class="column-columnname">'.$data->otr_school .'</td>
						<td class="column-columnname">'.$data->otr_year .'</td>
						<td class="column-columnname">'.$data->otr_mark .'</td>
						<td class="column-columnname">'.$data->ort_location .'</td>
					</tr>
				</body>
			</table>';
		echo '<h2> Employment </h2>'; 
		?>
			<table class="form-table" >
				<body>
					<tr class="user-description-wrap alternate">
						<th> Years Of Experience : </th>
						<td > <?php echo $data->year_experiance; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th> Present Salary : </th>
						<td>  <?php echo $data->salary; ?> </td>
					</tr>
					<tr class="user-description-wrap alternate">
						<th> Type Of Employment seeking: </th>
						<td><?php echo $data->emp_seeking; ?> </td>
					</tr>
				</body>
			</table>
		
		<h2> Skills : </h2>

		<table class="form-table">
			<tbody>
				<tr class="user-description-wrap">
					<th><label for="skill_strength">Technical Skills/Strengths:</label></th>
					<td><textarea name="skill_strength" id="skill_strength" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->skill_strength ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="attributes">Personal Attributes:</label></th>
					<td><textarea name="attributes" id="attributes" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->attributes ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="project_work">Professional History, Details about projects/work done.:</label></th>
					<td><textarea name="project_work" id="project_work" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->project_work ?></textarea>
				</tr>
			</tbody>
		</table>
		<h2> More About You :</h2>
		<table class="form-table">
			<tbody>
				<tr class="user-description-wrap">
					<th><label for="roles">Work Areas, Roles and Responsibilities involved in your current job :</label></th>
					<td><textarea name="roles" id="roles" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->roles ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="dislike_company">Like or dislike about the current company :</label></th>
					<td><textarea name="dislike_company" id="dislike_company" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->dislike_company ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="co-worker">How would your co-worker describe you as a person? :</label></th>
					<td><textarea name="co-worker" id="co-worker" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->coworker ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="change_reason">Reason for looking job change with the current company. :</label></th>
					<td><textarea name="change_reason" id="change_reason" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->change_reason ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="night_shift">Our clients are mostly USA / UK based, are you ready to work in night shift, if needed? :</label></th>
					<td><textarea name="night_shift" id="night_shift" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->night_shift ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="family_bg">Describe your family background? :</label></th>
					<td><textarea name="family_bg" id="family_bg" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->family_bg ?></textarea>
				</tr>
				<tr class="user-description-wrap">
					<th><label for="accomplishments">What are the three most important accomplishments in your life so far? : <br />(Please complete this even if you are a fresher.)</label></th>
					<td><textarea name="accomplishments" id="accomplishments" rows="5" cols="50" style="color:#000;" disabled > <?php echo $data->accomplishments ?></textarea>
				</tr>
				
			</tbody>
		</table>
<?php	
	}
}

function rctjp_pagination($totalposts,$p,$lpm1,$prev,$next){
    $adjacents = 3;
    if($totalposts > 1)
    {
        $pagination .= "<center><div class='pg_main'>";
        //previous button
        if ($p > 1)
        $pagination.= "<a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$prev\"><< Previous</a> ";
        else
        $pagination.= "<span class=\"disabled\"><< Previous</span> ";
        if ($totalposts < 7 + ($adjacents * 2)){
            for ($counter = 1; $counter <= $totalposts; $counter++){
                if ($counter == $p)
                $pagination.= "<span class=\"current\">$counter</span>";
                else
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$counter\">$counter</a> ";}
        }elseif($totalposts > 5 + ($adjacents * 2)){
            if($p < 1 + ($adjacents * 2)){
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $p)
                    $pagination.= " <span class=\"current\">$counter</span> ";
                    else
                    $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$counter\">$counter</a> ";
                }
                $pagination.= " ... ";
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$lpm1\">$lpm1</a> ";
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$totalposts\">$totalposts</a> ";
            }
            //in middle; hide some front and some back
            elseif($totalposts - ($adjacents * 2) > $p && $p > ($adjacents * 2)){
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=1\">1</a> ";
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=2\">2</a> ";
                $pagination.= " ... ";
                for ($counter = $p - $adjacents; $counter <= $p + $adjacents; $counter++){
                    if ($counter == $p)
                    $pagination.= " <span class=\"current\">$counter</span> ";
                    else
                    $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$counter\">$counter</a> ";
                }
                $pagination.= " ... ";
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$lpm1\">$lpm1</a> ";
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$totalposts\">$totalposts</a> ";
			}else{
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=1\">1</a> ";
                $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=2\">2</a> ";
                $pagination.= " ... ";
                for ($counter = $totalposts - (2 + ($adjacents * 2)); $counter <= $totalposts; $counter++){
                    if ($counter == $p)
                    $pagination.= " <span class=\"current\">$counter</span> ";
                    else
                    $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$counter\">$counter</a> ";
                }
            }
        }
        if ($p < $counter - 1)
        $pagination.= " <a href=\"?post_type=job_post&page=rctjp_admin_user_list_page&pg=$next\">Next >></a>";
        else
        $pagination.= " <span class=\"disabled\">Next >></span>";
        $pagination.= "</center>\n";
    }
    return $pagination;
}
?>

