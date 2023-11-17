<?php
    function validation($in, $name) {

        if(!($in->server('REQUEST_METHOD') == 'POST')) 
            show_error('metodo incorreto');

        if(!$in->post($name))
            show_error($name.' não foi determinada');

    }
?>