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

    $data['logradouro'] = array(
        'type'        => 'hidden',
        'name'        => 'logradouro',
        'id'          => 'logradouro',
        'value'       => $valores->usu_logradouro
    );

    $data['bairro'] = array(
        'type'        => 'hidden',
        'name'        => 'bairro',
        'id'          => 'bairro',
        'value'       => $valores->usu_bairro
    );

    $data['cidade'] = array(
        'type'        => 'hidden',
        'name'        => 'cidade',
        'id'          => 'cidade',
        'value'       => $valores->usu_cidade
    );

    $data['estado'] = array(
        'type'        => 'hidden',
        'name'        => 'estado',
        'id'          => 'estado',
        'value'       => $valores->usu_estado
    );

    $data['github'] = array(
        'name'        => 'github',
        'placeholder' => 'github',
        'id'          => 'github',
        'value'       => $valores->usu_github
    );

    $data['insert'] = array(
        'type' => 'submmit',
        'name' => 'login'
    );

    echo '<div class="container-item">'.form_input($data['name']);
    echo '<div class="error-name"></div>';

    echo form_input($data['email']);
    echo '<div class="error-email"></div>';

    echo form_input($data['password']);
    echo '<div class="error-password"></div></div>';

    echo '<div class="container-item">'.form_input($data['phone']);
    echo '<div class="error-phone"></div>';

    echo form_input($data['cep']);
    echo '<div class="error-cep"></div>';

    echo form_input($data['logradouro']);

    echo form_input($data['bairro']);

    echo form_input($data['cidade']);

    echo form_input($data['estado']).'</div>';

    echo '<div class="container-item">'.form_input($data['github']);
    echo '<div class="error-github"></div>';

    echo '<h4>'.$valores->usu_tp_identificador.'</h4>';

    echo form_input($data['identifier']);
    echo '<div class="error-identifier"></div></div>';

    echo '<br><button type="submit">Atualizar</button>';
    echo form_close();

    echo '</div>';

?>