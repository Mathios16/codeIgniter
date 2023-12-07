<?php 
    echo $topnav;
    echo '<div class="container"><h2>'.$title.'</h2></div><div class="container">';

    echo form_open($type, array( 'id' => 'update')); 

    $data['name'] = array(
        'name'        => 'name',
        'placeholder' => 'nome',
        'value'       => $valores->usu_nome
    );

    $data['email'] = array(
        'name'        => 'email',
        'placeholder' => 'email',
        'value'       => $valores->usu_email
    );

    $data['password'] = array(
        'name'        => 'password',
        'placeholder' => 'senha',
        'value'       => $valores->usu_senha
    );

    $data['identifier'] = array(
        'name'        => 'identifier',
        'placeholder' => 'identificador',
        'value'       => $valores->usu_identificador
    );


    $data['phone'] = array(
        'name'        => 'phone',
        'placeholder' => 'telefone',
        'value'       => $valores->usu_telefone
    );

    $data['insert'] = array(
        'type' => 'submmit',
        'name' => 'login'
    );

    echo '<div class="container-item">'.form_input($data['name']);
    echo '<div class="error-name"></div>';

    echo form_input($data['email']).'</br>';
    echo '<div class="error-email"></div></div>';

    echo '<div class="container-item">'.form_input($data['password']);
    echo '<div class="error-password"></div>';

    echo form_input($data['phone']).'</br>';
    echo '<div class="error-phone"></div>';

    echo '<h4>'.$valores->usu_tp_identificador.'</h4>';

    echo form_input($data['identifier']).'</br>';
    echo '<div class="error-identifier"></div></div>';

    echo '<br><button type="submit">Atualizar</button>';
    echo form_close();

    echo '</div>';

?>