<div class="content">
    
    <h1>Overview</h1>
    
    <p>
        This controller/action/view shows a list of all users in the system.
        You could use the underlaying code to build things that use profile information
        of one or multiple/all users.
    </p>
    
    <p>
        <span style="color: red;">NOTE: be sure NOT to show email adresses of users in a real app. This is just a demo.</span>
        
        <table class="overview-table">
        <?php
        
        foreach ($this->users as $user) {
            
            if ($user->user_active == 0) {
                echo '<tr class="inactive">';            
            } else {
                echo '<tr class="active">';            
            }        
            echo '<td>'.$user->user_id.'</td>';            
            echo '<td class="avatar"><img src="'.$user->user_avatar_link.'" /></td>';
            echo '<td>'.$user->user_email.'</td>';
            echo '<td>Active: '.$user->user_active.'</td>';            
            echo '<td><a href="'.URL.'overview/showuserprofile/'.$user->user_id.'">Show user\'s profile</a></td>';
            echo "</tr>";
            
        }
        
        ?>        
        </table>
    </p>    
    
</div>
