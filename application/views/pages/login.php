<?php 
        echo '<h2>'.$title.'</h2><br>';

        echo form_open('login/index', array( 'id' => 'login')); 

        $data['email'] = array(
                'name'        => 'email',
                'placeholder' => 'email'
        );

        $data['senha'] = array(
                'name'        => 'password',
                'placeholder' => 'senha'
        );

        $data['login'] = array(
                'type' => 'submmit',
                'name' => 'login'
        );

        echo form_input($data['email']).'</br>';
        echo '<div class="error-email"></div>';

        echo form_password($data['senha']).'</br>';
        echo '<div class="error-password"></div>';
        echo '<br><button type="submit">login</button>';
        echo form_close();

?>