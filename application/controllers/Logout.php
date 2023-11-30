<?php

    class Logout extends MY_Controller
    {

        public function __construct()
        {
            parent::__construct();
        }

        public function close_session() 
        {

            $this->db->where('cts_usu_chave', $this->session->id)
                     ->delete('controle_sessoes');

            $this->session->unset_userdata('id');

            redirect('login');

        }
    }

?>