<?php
    function validation($object, $name) {

        $_SESSION["{$name}"] = $object->input->post($name);

        if( ! ($object->input->server('REQUEST_METHOD') == 'POST')) 
            show_error('metodo incorreto');

        if( ! $object->input->post($name))
            show_error($name.' não foi determinada');

    }
?>