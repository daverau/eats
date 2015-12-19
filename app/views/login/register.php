	<div class="box bg-white signup">
		<h2>Track Your Health</h2>
		<ol>
			<li>Eat more thoughtfully by noticing what you're eating</li>
			<li>Make good choices by setting healthy goals</li>
			<li>Identify foods that irritate</li>
			<li>Stimulate positive thoughts and mindfulness by journaling your moods</li>
		</ol>

<hr />

    <h2>Sign Up</h2>

    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>

    <!-- register form -->
    <form method="post" class="align-center" action="<?php echo URL; ?>login/register_action" name="registerform">

        <!-- the user name input field uses a HTML5 pattern check -->
        <p><input id="login_input_username" class="login_input" type="email" name="user_email" placeholder="email address" required /></p>

        <p><input id="login_input_password_new" class="login_input" type="password" name="user_password_new" placeholder="password" pattern=".{6,}" required autocomplete="off" />  </p>
        
        <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
        <!-- to avoid weird with-slash-without-slash issues: simply always use the URL constant here -->
        <?php
        /*
        <img src="<?php echo URL; ?>login/showCaptcha" />

        <label>Please enter those characters</label>
        <input type="text" name="captcha" required />
        */
        ?>
        <input type="submit"  name="register" value="Sign Up" />
        
    </form>
    
</div>

