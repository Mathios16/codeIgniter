<?php 
        echo '<h2>'.$title.'</h2><br>';
        echo form_open('pages/table'); 

        $data['email'] = array(
                'name'          => 'email',
                'placeholder'   => 'email'
        );

        $data['senha'] = array(
                'type'          => 'password',
                'name'          => 'password',
                'placeholder'   => 'senha',
        );

        echo form_input($data['email']).'</br>';
        echo form_password($data['senha']).'</br></br>';

        echo form_submit('submit','Login');
        echo form_close();

?>
