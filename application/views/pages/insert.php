<?php 
    echo $topnav;
    echo '<div class="container">';
    echo '<h2>'.$title.'</h2></div><div class="container">';

    echo form_open('insert', array( 'id' => 'insert')); 

    $data['pessoa_fisica'] = array(
        'name'  => 'tipo_pessoa',
        'value' => 'Física',
        'id'    => 'fisica'
    );

    $data['pessoa_juridica'] = array(
        'name'  => 'tipo_pessoa',
        'value' => 'Juríidica',
        'id'    => 'juridica'
    );

    $data['name'] = array(
        'name'        => 'name',
        'placeholder' => 'nome'
    );

    $data['email'] = array(
        'name'        => 'email',
        'placeholder' => 'email'
    );

    $data['password'] = array(
        'name'        => 'password',
        'placeholder' => 'senha'
    );

    $data['identifier'] = array(
        'type'        => 'hidden',
        'name'        => 'identifier',
        'placeholder' => 'identificadors'
    );


    $data['phone'] = array(
        'name'        => 'phone',
        'placeholder' => 'telefone'
    );

    $data['insert'] = array(
        'type' => 'submmit',
        'name' => 'login'
    );

    echo form_input($data['name']).'</br>';
    echo '<div class="error-name"></div>';

    echo form_input($data['email']).'</br>';
    echo '<div class="error-email"></div>';

    echo form_password($data['password']).'</br>';
    echo '<div class="error-password"></div>';

    echo form_input($data['phone']).'</br>';
    echo '<div class="error-phone"></div>';

    
    echo '<fieldset id = "tipo_pessoa">';
    echo '<legend>Escolha o tipo de pessoa:</legend>';
    echo '<div>'.form_radio($data['pessoa_fisica'], 'Fisica').form_label('Física', 'fisica').'</div>';
    echo '<div>'.form_radio($data['pessoa_juridica'], 'Jurídica').form_label('Jurídica', 'juridica').'</div>';
    echo '</fieldset>';


    echo form_input($data['identifier']).'</br>';
    echo '<div class="error-identifier"></div>';

    echo '<br><button type="submit">Inserir</button>';
    echo form_close();

    echo '</div>';

?>