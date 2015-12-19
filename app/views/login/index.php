    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>

	<div class="box bg-white signin">
	
		<div class="feeling">
		<h2>Feeling Well Today?</h2>
		<p><a href="<?=URL?>login/register" id="signup_link">Sign-up</a> to track your foods &amp; moods.</p>
		</div>
	
			<form name="loginform-custom" id="loginform-custom" action="<?=URL?>login/login" method="post">
			<p class="login-username">
				<input type="text" name="user_email" id="user_login" class="input" size="20" tabindex="10" placeholder="Email" />
			</p>
			<p class="login-password">
				<input type="password" name="user_password" id="user_pass" class="input" value="" size="20" tabindex="20" placeholder="Password" />
			</p>
			
			<p class="hide"><label><input name="user_rememberme" type="checkbox" id="rememberme" checked="checked" tabindex="90" /> Remember me</label></p>
			<p class="login-submit">
				<input type="submit" name="submit" id="wp-submit" class="button-primary" value="Sign in" tabindex="100" />
			</p>
			<p class="tiny"><a href="<?=URL?>login/requestpasswordreset" id="forgot_link" class="lite">Forgot password?</a></p>
		</form>
	</div>

</div>