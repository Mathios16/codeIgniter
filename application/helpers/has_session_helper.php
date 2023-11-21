<?php

    function get_session($object, $name) : bool {

        return ( $object->session->has_userdata($name) != NULL ? TRUE : FALSE );   

    }

?>