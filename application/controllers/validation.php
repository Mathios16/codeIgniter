<?php

    class validation extends CI_Controller {


        public function __construct() {
            parent::__construct();
            $this->load->helper('url_helper');
        }


        public function validation() {

            if(!isset($_SESSION['senha']))
                show_error('Senha não foi determinada');

            $this->load->view('templates/header');
            $this->load->view('testeSession/selectLine', $_SESSION['senha']);
            $this->load->view('templates/footer');

        }

    }

?>