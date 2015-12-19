<div class="content">

    <h1>Request a password reset</h1>

    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>

    <!-- request password reset form box -->
    <form method="post" action="<?php echo URL; ?>login/requestpasswordreset_action" name="password_reset_form">
        <label for="password_reset_input_username">
            Enter your email address and you'll get an email message with a link:
        </label>
        <input id="password_reset_input_username" class="password_reset_input" type="text" name="user_email" required />
        <input type="submit"  name="request_password_reset" value="Reset my password" />
    </form>
    
</div>