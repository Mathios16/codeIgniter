<?php

    class bd_connection extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

    }

?>