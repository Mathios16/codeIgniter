<?php

    class testeSession extends CI_Controller {


        public function __construct() {
            parent::__construct();
            $this->load->helper('url_helper');
        }

        public function searchDB() : String {

            $data['reflection'] = new ReflectionClass('testeSession');
            $data['nameClass'] = $data['reflection']->getName();

            return $data['nameClass'];

        }

        public function getTrigrama() : String {

            $data['trigrama'] = strstr(searchDB(),'[a-z]');
            $data['trigrama'] += stripos(searchDB(), '[A-Z]');
            $data['trigrama'] += strrchr(searchDB(),'[a-z]');

            return $data['trigrama'];
        }

        public function index(){

            $data[searchDB()] = $this->db->select('*')->get(searchDB())->result();
            $data['title'] = 'Teste de banco de dados';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/index', $data);
            $this->load->view('templates/footer');

        }

        public function view(){

            $data[searchDB()] = $this->db->select('*')->where(getTrigrama().'_id',$this->uri->segment(3))->get(searchDB())->result();

            if (empty(searchDB()))
                show_404();

            $this->load->view('templates/header', $data);
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

        }

    }

?>