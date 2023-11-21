<?php
    function validation($object, $name) {

        if( ! get_session($object, "{$name}") )
            session_start();

        if( ! ($object->input->server('REQUEST_METHOD') == 'POST')) 
            show_error('metodo incorreto');

        if( ! $object->input->post($name))
            show_error($name.' não foi determinada');

    }
?>