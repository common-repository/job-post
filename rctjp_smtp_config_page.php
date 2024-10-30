<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
if(isset($_POST['smtp_save'])){
	
	$smtp_host = esc_html( $_POST['smtp_host'] );
	$smtp_port = intval( $_POST['smtp_port'] );
	$smtp_username = sanitize_email( $_POST['smtp_username'] );
	$smtp_password = esc_html( $_POST['smtp_password'] );
	$smtp_form_email = sanitize_email( $_POST['smtp_form_email'] );
	
	update_option( 'rctjp_smtp_host', $smtp_host);
	update_option( 'rctjp_smtp_port', $smtp_port);
	update_option( 'rctjp_smtp_username', $smtp_username);
	update_option( 'rctjp_smtp_password', $smtp_password);
	update_option( 'rctjp_smtp_form_email', $smtp_form_email );
	
	
}
$rctjp_smtp_host = get_option('rctjp_smtp_host');
$rctjp_smtp_port = get_option('rctjp_smtp_port');
$rctjp_smtp_form_email = ( get_option('rctjp_smtp_form_email') ? get_option('rctjp_smtp_form_email') : get_option('admin_email'));

?>
<h1> SMTP Confing Setting </h1>
(SMTP server name, port, user/passwd)
<form action="" method="post">
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row">
					<label for="user_login"> SMTP Host </label>
				</th>
				<td>
					<input name="smtp_host" type="text" id="rctjp_smtp_host" value="<?php echo $rctjp_smtp_host; ?>" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60">
					<p><span id="footer-thankyou">(For Example : smtp.gmail.com)</span></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="user_login"> SMTP port </label>
				</th>
				<td>
					<input name="smtp_port" type="text" id="rctjp_smtp_port" value="<?php echo $rctjp_smtp_port; ?>" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="10">
					<p><span id="footer-thankyou">(For Example : 465)</span></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="user_login"> User Email Address </label>
				</th>
				<td>
					<input name="smtp_username" type="text" id="rctjp_smtp_username" value="<?php echo get_option('rctjp_smtp_username'); ?>" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60">
					<p><span id="footer-thankyou">(For Example : example@gmail.com)</span></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="user_login"> Password </label>
				</th>
				<td>
					<input name="smtp_password" type="password" id="rctjp_smtp_password" value="<?php echo get_option('rctjp_smtp_password'); ?>" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="user_login"> To Email Address </label>
					<br><p><span id="footer-thankyou">(which you have sent mail )</span></p>
				</th>
				<td>
					<input name="smtp_form_email" type="text" id="rctjp_smtp_form_email" value="<?php echo $rctjp_smtp_form_email; ?>" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60">
				</td>
			</tr>
			<tr class="form-field">
				<td> <input type="submit" name="smtp_save" value="Save Setting" class="button button-primary"> </td>
			</tr>
		</tbody>
	</table>
</form>