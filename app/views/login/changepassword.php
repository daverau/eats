<div class="content">

    <h1>Set new password</h1>

    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>

    <!-- new password form box -->
    <form method="post" action="<?php echo URL; ?>login/setnewpassword" name="new_password_form">

        <input type='hidden' name='user_email' value='<?php echo $this->user_email; ?>' />
        <input type='hidden' name='user_password_reset_hash' value='<?php echo $this->user_password_reset_hash; ?>' />

        <label for="reset_input_password_new">
            New password (min. 6 characters! 
            <span class="login-form-password-pattern-reminder">
                Please note: using a long sentence as a password is much much safer then something like "!c00lPa$$w0rd"). Have a look on
                <a href="http://security.stackexchange.com/questions/6095/xkcd-936-short-complex-password-or-long-dictionary-passphrase">
                    this interesting security.stackoverflow.com thread
                </a>.            
            </span>
        </label>
        <input id="reset_input_password_new" class="reset_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />  

        <input type="submit"  name="submit_new_password" value="Submit new password" />
    </form>

    <a href="<?php echo URL; ?>login/index">Back to Login Page</a>
    
</div>