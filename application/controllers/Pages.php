<?php

    class Pages extends MY_Controller {


        public function __construct() {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->helper('form');
            $this->load->helper('validation_post');
        }

        public function index() {

            $data['title'] = 'Teste do '.$this->searchDB();

            $this->load->view('templates/header');
            $this->load->view('pages/index', $data);
            $this->load->view('templates/footer');

        }

        public function selectTable(){

            $data['db'] = $this->db->select($this->getParameter())
                                   ->get($this->searchDB())
                                   ->selectBD();

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

        }

        public function selectLine() {

            validation($this->input, 'senha');

            $data['db'] = $this->db->select($this->getParameter())
                                   ->where($this->getTrigrama().'senha',$this->input->post('senha'))
                                   ->get($this->searchDB())
                                   ->result();
                             
            if (empty($data['db']))
                show_error('Senha pode estar errada');

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

            
        }

        
    }

?>