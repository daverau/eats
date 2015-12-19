<div class="box bg-white">

    <h2>My Account</h2>
    
    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>

    <h3>Account type: <?php echo Session::get('user_account_type'); ?></h3>
    
    <!-- basic implementation for two account type: type 1 and type 2 -->    
    <?php if (Session::get('user_account_type') == 1) { ?>
    <form action="<?php echo URL; ?>login/changeaccounttype_action" method="post">
        <label></label>
        <input type="submit" name="user_account_upgrade" value="Upgrade my account" />
    </form>
    <?php } elseif (Session::get('user_account_type') == 2) { ?>
    <form action="<?php echo URL; ?>login/changeaccounttype_action" method="post">
        <label></label>
        <input type="submit" name="user_account_downgrade" value="Downgrade my account" />
    </form>    
    <?php } ?>
    
</div>