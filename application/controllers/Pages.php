<?php

    class Pages extends MY_Controller {


        public function __construct() {
            parent::__construct();

            $this->load->library('table');

            $this->load->helper('url_helper');
            $this->load->helper('form');
            $this->load->helper('has_session');
            $this->load->helper('validation_post');
        }

        public function index() {

            if(get_session('password'))
                $this->select_view();

            $data['title'] = 'Teste do '.$this->searchDB();

            $this->load->view('templates/header');
            $this->load->view('pages/index', $data);
            $this->load->view('templates/footer');

        }

        public function select_view() {

            $this->load->view('templates/header');
            $this->load->view('pages/select_view');
            $this->load->view('templates/footer');

        }

        public function close_session() {

            unset($_SESSION);

            $this->index();

        }

        public function select_table(){

            validation($this, 'password');
            validation($this, 'email');

            $data['table_heading'] = explode(" , ", $this->get_parameter());

            $data['consult'] = $this->db->select($this->get_parameter())
                                        ->get($this->searchDB())
                                        ->result();

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

        }

        public function select_line() {

            validation($this, 'password');
            validation($this, 'email');

            $data['table_heading'] = explode(" , ", $this->get_parameter());

            $where = array($this->get_trigrama().'email'=> $this->input->post('email'),
                           $this->get_trigrama().'senha'=> $this->input->post('password'));

            $data['consult'] = $this->db->select($this->get_parameter())
                                        ->where($where)
                                        ->get($this->searchDB())
                                        ->result();
                             
            if (empty($data['consult']))
                show_error('Senha pode estar errada');

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

            
        }



        private function get_parameter() : String {

            $parameter = $this->get_trigrama().'nome , '
                        .$this->get_trigrama().'email , '
                        .$this->get_trigrama().'senha';

            return $parameter;
        }

        private function get_trigrama() : String {

            $trigrama = ' tsn_';

            return $trigrama;
        }
    }

?>