<?php

    class testeSession extends CI_Controller {


        public function __construct() {
            parent::__construct();
            $this->load->helper('url_helper');
        }

        public function searchDB() {

            $data['reflection'] = new ReflectionClass('testeSession');
            $data['nameClass'] = $data['reflection']->getName();

        }

        public function index(){

            $data[$data['nameClass']] = $this->db->select('*')->get($data['nameClass'])->result();
            $data['title'] = 'Teste de banco de dados';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/index', $data);
            $this->load->view('templates/footer');

        }

        public function view(){

            $data['bd'] = $this->db->select('bd_id, bd_nome')->where('bd_id',$this->uri->segment(3))->get('bd')->result();

            if (empty($data['bd']))
                show_404();

            $this->load->view('templates/header', $data);
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

        }

    }

?>