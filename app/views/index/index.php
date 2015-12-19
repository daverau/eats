<?php
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }
    }
?>
    
	<div class="box bg-white signin">
	
		<div class="feeling">
			<h2>Feeling Well?</h2>
			<p><a href="<?=URL?>login/register" id="signup_link">Sign-up</a> to track your health.</p>
		</div>
	
		<form name="loginform-custom" id="loginform-custom" action="<?=URL?>login/login" method="post">
			<p class="login-username">
				<input type="text" name="user_email" id="user_login" class="input" size="20" tabindex="10" placeholder="Email" /> &nbsp;
			</p>
			<p class="login-password">
				<input type="password" name="user_password" id="user_pass" class="input" value="" size="20" tabindex="20" placeholder="Password" /> <a href="<?=URL?>login/requestpasswordreset" id="forgot_link" class="lite">?</a>
			</p>
			
			<p class="hide"><label><input name="user_rememberme" type="checkbox" id="rememberme" tabindex="90" /> Remember me</label></p>
			<p class="login-submit">
				<input type="submit" name="submit" id="wp-submit" class="button-primary" value="Sign in" tabindex="100" />
			</p>
		</form>
	</div>

	<div class="box signup bg-white hidden">
	<h2>Sign up</h2>
	
		<form method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form" id="signup">
			<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
			<input type="hidden" name="user-cookie" value="1" />
			
			<p><input type="text" name="user_email" placeholder="Email address" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="20" id="user_email" tabindex="102" /></p>
			
			<p class="tiny">Daily calorie goal: 
			<input id="calories" type="text" tabindex="30" size="20" value="<?php echo esc_attr(stripslashes($calories)); ?>" name="calories" placeholder="2000" /></p>
			
			<p><button>Sign up</button></p>
			
			<script>
			$('p:not(.login-remember) label').hide();
			$('#user_login').attr('placeholder', 'Email address');
			$('#user_pass').attr('placeholder', 'Password');
			$('#calories').attr('placeholder', 'Daily calorie goal');

			$("#forgot_link").click(function () { 
				$('#forgot, #loginform-custom').toggle();
			});
			</script>
		</form>
		
	</div>



<script type="text/javascript">
	$(document).ready(function(){
	
		
		$("#signup button").click(function () { 
			$('#signup').submit();
		});

		$("#signup_link").click(function () {
			$('.signup').toggleClass('hidden');
			$('.signin').toggleClass('hidden');
		});
	});

</script>
