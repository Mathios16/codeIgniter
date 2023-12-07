<?php 
    echo $topnav;
    echo '<div class="container"><h2>'.$title.'</h2></div><div class="container">';

    echo form_open($type, array( 'id' => 'update')); 

    $data['name'] = array(
        'name'        => 'name',
        'placeholder' => 'nome',
        'id'          => 'nome',
        'value'       => $valores->usu_nome
    );

    $data['email'] = array(
        'name'        => 'email',
        'placeholder' => 'email',
        'id'          => 'email',
        'value'       => $valores->usu_email
    );

    $data['password'] = array(
        'name'        => 'password',
        'placeholder' => 'senha',
        'id'          => 'senha',
        'value'       => $valores->usu_senha
    );

    $data['identifier'] = array(
        'name'        => 'identifier',
        'placeholder' => 'identificador',
        'id'          => 'identificador',
        'value'       => $valores->usu_identificador
    );


    $data['phone'] = array(
        'name'        => 'phone',
        'placeholder' => 'telefone',
        'id'          => 'telefone',
        'value'       => $valores->usu_telefone
    );

    $data['cep'] = array(
        'name'        => 'cep',
        'placeholder' => 'cep',
        'id'          => 'cep',
        'value'       => $valores->usu_cep
    );

    $data['insert'] = array(
        'type' => 'submmit',
        'name' => 'login'
    );

    echo '<div class="container-item">'.form_input($data['name']);
    echo '<div class="error-name"></div>';

    echo form_input($data['email']).'</br>';
    echo '<div class="error-email"></div>';

    echo form_input($data['password']);
    echo '<div class="error-password"></div></div>';

    echo '<div class="container-item">'.form_input($data['phone']).'</br>';
    echo '<div class="error-phone"></div>';

    echo form_input($data['cep']).'</br>';
    echo '<div class="error-phone"></div></div>';

    echo '<div class="container-item">'.'<h4>'.$valores->usu_tp_identificador.'</h4>';

    echo form_input($data['identifier']).'</br>';
    echo '<div class="error-identifier"></div></div>';

    echo '<br><button type="submit">Atualizar</button>';
    echo form_close();

    echo '</div>';

?>