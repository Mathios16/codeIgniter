<?php

    function get_session($name) : bool {

        return ( isset($_SESSION["{$name}"]) != NULL ? TRUE : FALSE );   

    }

?>