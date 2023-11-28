<?php

    class MY_Controller extends CI_Controller 
    {

        public function __construct() 
        {

            parent::__construct();

            $this->load->helper(array('html', 'url_helper','form','security'));

            $this->load->library(array('session','encryption'));
            
        }

        protected function searchDB() : String 
        {

            $nameClass = 'testesession';

            return $nameClass;

        }

        
        protected function has_session($name) : bool 
        {

            return ( $this->session->has_userdata($name) != NULL ? TRUE : FALSE );   
    
        }

        protected function get_session($name) 
        {

            return $this->session->has_userdata($name);   
    
        }

        protected function get_parameter() : String 
        {

            $parameter = $this->get_trigrama().'nome , '
                        .$this->get_trigrama().'email , '
                        .$this->get_trigrama().'senha';

            return $parameter;
        }

        protected function get_trigrama() : String 
        {

            return ' tsn_';

        }

        protected function verifica_banco($val, $name) : bool 
        {
            return (empty($this->db->select($this->get_trigrama().'id')
                                   ->where($this->get_trigrama().$name, $val)
                                   ->get($this->searchDB())
                                   ->result())
                    ? FALSE : TRUE);
        }
        protected function get_id() 
        {
            
            $where = array($this->get_trigrama().'email'=> $this->input->post('email'),
                           $this->get_trigrama().'senha'=> $this->input->post('password'));

            $consult = $this->db->select($this->get_trigrama().'id')
                                ->where($where)
                                ->get($this->searchDB())
                                ->result();

            if (empty($consult))
                return FALSE;
            
            return $consult[0]->tsn_id;

        }

        protected function get_key_session() 
        {

            $consult = $this->db->select('cts_usu_chave')
                                ->where('cts_usu_id', $this->get_id())
                                ->get('controle-sessoes')
                                ->result();

            return $consult[0]->cts_usu_chave;

        }

        protected function add_session()
        {

            $this->db->insert('controle_sessoes', 
                        array('cts_id'       => 0,
                              'cts_tabela'   => $this->searchDB(),
                              'cts_usu_chave'=> $this->encrypt->encode($this->get_id()),
                              'cts_usu_id'   => $this->get_id(),
                              'cts_status'   => 'usu'));

        }

    }

?>