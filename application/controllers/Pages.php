<?php

    class Pages extends MY_Controller {


        public function __construct() {
            parent::__construct();

            $this->load->library('table');
            $this->load->library('session');

            $this->load->helper('html');
            $this->load->helper('url_helper');
            $this->load->helper('form');
            $this->load->helper('security');
            $this->load->library('javascript');
            $this->load->library('javascript/jquery');
        }

        public function index() {

            if($this->get_session('password') === TRUE)
            {
                redirect('pages/line');
                return;
            }
            

            $data['title'] = 'Teste do '.$this->searchDB();

            $data['library_src'] = $this->jquery->script();

            //$this->jquery->event("#click", $this->javascript->valida_pagina());

            $this->load->view('templates/header');
            $this->load->view('pages/index', $data);
            $this->load->view('templates/footer');

        }

        public function select_table(){

            $data['type'] = 't';


            $data['table_heading'] = explode(",", $this->get_parameter());
            foreach($data['table_heading'] as $key => $val)
                $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);


            if( ! $this->get_session('id'))
            {
                if($this->input->post('password') && $this->input->post('email'))
                    $this->validation(array('password', 'email'));

                
                $this->session->set_userdata('id',$this->get_id());
            }

            $data['consult'] = $this->db->select($this->get_parameter())
                                        ->get($this->searchDB())
                                        ->result();

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

        }

        public function select_line() {

            $data['type'] = 'l';


            $data['table_heading'] = explode(",", $this->get_parameter());
            foreach($data['table_heading'] as $key => $val)
                $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);


            if( ! $this->get_session('id'))
            {
                if($this->input->post('password') && $this->input->post('email'))
                    $this->validation(array('password', 'email'));


                $this->session->set_userdata('id',$this->get_id());
            }

            $data['consult'] = $this->db->select($this->get_parameter())
                                        ->where($this->get_trigrama().'id', $this->session->id)
                                        ->get($this->searchDB())
                                        ->result();
                             
            if (empty($data['consult']))
                show_error('Senha pode estar errada');

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

            
        }
        
        public function close_session() {

            $this->session->unset_userdata('password');
            redirect('pages');

        }

        /*
        auxiliares
        */

        function validation($name_arr) {

            foreach($name_arr as $name)
            {
                if( ! ($this->input->server('REQUEST_METHOD') == 'POST')) 
                    show_error('metodo incorreto');
        
                if( ! $this->input->post($name))
                    show_error($name.' não foi determinada');
                
            }
    
        }

        function get_session($name) : bool {

            return ( $this->session->has_userdata($name) != NULL ? TRUE : FALSE );   
    
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

        public function get_id() {
            
            $where = array($this->get_trigrama().'email'=> $this->input->post('email'),
                           $this->get_trigrama().'senha'=> $this->input->post('password'));

            return $this->db->select($this->get_trigrama().'id')
                                        ->where($where)
                                        ->get($this->searchDB())
                                        ->result()[0]->tsn_id;

        }
    }

?>