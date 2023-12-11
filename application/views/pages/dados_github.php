<?php 
        echo '<div class="container">';
        echo '<h2>'.$title.'</h2></div><div class="container">';

        echo form_open('github', array( 'id' => 'github')); 

        $data['username'] = array(
                'name'        => 'username',
                'placeholder' => 'usuario'
        );

        $data['login'] = array(
                'type' => 'submmit',
                'name' => 'login'
        );

        echo form_input($data['username']).'</br>';
        echo '<div class="error-email"></div>';

        echo '<br><button type="submit">login</button>';
        echo form_close();

        echo '</div>';

?>