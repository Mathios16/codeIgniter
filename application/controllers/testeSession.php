<?php

    class testeSession extends CI_Controller {


        public function __construct() {
            parent::__construct();
            $this->load->helper('url_helper');
        }

        private function searchDB() : String {

            $reflection = new ReflectionClass($this);
            $nameClass = strtolower($reflection->getName());

            return $nameClass;

        }

        private function getParameter() : String {

            $parameter = $this->getTrigrama().'nome, ';
            $parameter = $this->getTrigrama().'email';

            return $parameter;
        }

        private function getTrigrama() : String {

            $trigrama = strstr($this->searchDB(),'[a-z]');
            $trigrama += strtolower(stripos($this->searchDB(), '[A-Z]'));
            $trigrama += strrchr($this->searchDB(),'[a-z]');
            $trigrama += '_';

            return $trigrama;
        }

        

        public function selectTable(){

            $data[$this->searchDB()] = $this->db->select($this->getParameter())
                                                ->get($this->searchDB())
                                                ->result();
            $data['title'] = 'Teste do'.$this->searchDB();

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

        }

        public function selectLine($senha = FALSE){

            if($senha == FALSE)
                $this->selectTable();

            $data[$this->searchDB()] = $this->db->select($this->getParameter())
                                                ->where($this->getTrigrama().'senha',$this->uri->segment(3))
                                                ->get($this->searchDB())
                                                ->result();

            if (empty($this->searchDB()))
                show_error('Senha pode estar errada');

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

        }

    }

?>