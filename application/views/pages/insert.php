<?php 
    echo $topnav;
    echo '<div class="container">';
    echo '<h2>'.$title.'</h2></div><div class="container">';

    echo form_open('insert', array( 'id' => 'insert')); 

    $data['pessoa_fisica'] = array(
        'name'  => 'tipo_pessoa',
        'value' => 'cpf',
        'id'    => 'fisica'
    );

    $data['pessoa_juridica'] = array(
        'name'  => 'tipo_pessoa',
        'value' => 'cnpj',
        'id'    => 'juridica'
    );

    $data['name'] = array(
        'name'        => 'name',
        'placeholder' => 'nome',
        'id'          => 'nome'
    );

    $data['email'] = array(
        'name'        => 'email',
        'placeholder' => 'email',
        'id'          => 'email'
    );

    $data['password'] = array(
        'name'        => 'password',
        'placeholder' => 'senha',
        'id'          => 'senha'
    );

    $data['identifier'] = array(
        'type'        => 'hidden',
        'name'        => 'identifier',
        'placeholder' => 'identificador'
    );


    $data['phone'] = array(
        'name'        => 'phone',
        'placeholder' => 'telefone',
        'id'          => 'telefone'
    );

    $data['cep'] = array(
        'name'        => 'cep',
        'placeholder' => 'cep',
        'id'          => 'cep'
    );

    $data['insert'] = array(
        'type' => 'submmit',
        'name' => 'login'
    );

    echo '<div class="container-item">'.form_input($data['name']);
    echo '<div class="error-name"></div>';

    echo form_input($data['email']).'</br>';
    echo '<div class="error-email"></div></div>';

    echo '<div class="container-item">'.form_password($data['password']);
    echo '<div class="error-password"></div>';

    echo form_input($data['phone']).'</br>';
    echo '<div class="error-phone"></div></div>';

    
    echo '<div class="container-item">'.'<fieldset id = "tipo_pessoa">';
    echo '<legend>Escolha o tipo de pessoa:</legend>';
    echo '<div class="container-item">'.form_radio($data['pessoa_fisica'], 'Fisica').form_label('Física', 'fisica');
    echo form_radio($data['pessoa_juridica'], 'Jurídica').form_label('Jurídica', 'juridica').'</div>';
    echo '</fieldset>';

    echo form_input($data['identifier']).'</br>';
    echo '<div class="error-identifier"></div></div>';

    echo '<div class="container-item">'.form_input($data['cep']);
    echo '<div class="error-cep"></div></div>';

    echo '<br><button type="submit">Inserir</button>';
    echo form_close();

    echo '</div>';

?>