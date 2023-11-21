<h2><?php echo $title; ?></h2>

<div>
        <?php 
        
                echo form_open('pages/table'); 

                echo form_input('email','email').'</br>';
                echo form_password('password','').'</br>';
        
                echo form_submit('submit','Login');
                echo form_close();

        ?>
</div>
