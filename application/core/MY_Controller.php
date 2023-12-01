<?php

    class MY_Controller extends CI_Controller 
    {

        public function __construct() 
        {

            parent::__construct();

            $this->load->helper(array('html', 'url_helper','form','security'));

            $this->load->library(array('session','encryption', 'pagination'));


            $this->remove_sessions();
            
        }


        /***BANCO***/


        protected function searchDB() : String 
        {

            $nameClass = 'usuarios';

            return $nameClass;

        }

        protected function get_parameter() : String 
        {

            $parameter = $this->get_trigrama().'nome , '
                        .$this->get_trigrama().'email , '
                        .$this->get_trigrama().'senha , '
                        .$this->get_trigrama().'identificador , '
                        .$this->get_trigrama().'telefone ';

            return $parameter;
        }

        protected function get_trigrama() : String 
        {

            return ' usu_';

        }


        /***CONSULTAS BD***/


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
            
            return $consult[0]->$this->get_trigrama().'id';

        }

        protected function get_usuario($email, $senha, $dado) 
        {
            
            $where = array($this->get_trigrama().'email'=> $email,
                           $this->get_trigrama().'senha'=> $senha);

            $consult = $this->db->select($this->get_trigrama().$dado)
                                ->where($where)
                                ->get($this->searchDB())
                                ->result();

            if (empty($consult))
                return FALSE;
            
            return $consult[0]->$this->get_trigrama().$dado;

        }

        protected function verifica_banco($val, $name) : bool 
        {
            return (empty($this->db->select($this->get_trigrama().'id')
                                   ->where($this->get_trigrama().$name, $val)
                                   ->get($this->searchDB())
                                   ->result())
                    ? FALSE : TRUE);
        }


        /***CONSULTAS SESSION***/


        protected function add_session()
        {
            $id = $this->get_id();
            $this->db->insert('controle_sessoes', 
                        array('cts_id'       => 0,
                              'cts_tabela'   => $this->searchDB(),
                              'cts_usu_chave'=> $this->encryption->encrypt($id),
                              'cts_status'   => 'usu',
                              'cts_tempo'   => time()+7200));
            $this->session->set_userdata('id', $this->get_last_sessions());
        }
        
        protected function get_session($name, $key)
        {
            $consult = $this->db->select($name)
                                ->where('cts_usu_chave', $key)
                                ->get('controle_sessoes')
                                ->result();

            if(empty($consult))
                return FALSE;

            return $consult[0]->$name;
        }

        protected function get_last_sessions()
        {
            $consult = $this->db->select('cts_usu_chave')
                                ->limit(1)
                                ->order_by('cts_id','desc')
                                ->get('controle_sessoes')
                                ->result();

            if(empty($consult))
                return FALSE;

            return $consult[0]->cts_usu_chave;
        }

        protected function get_num_sessions($key) : int
        {

            $count = 0;

            $consult = $this->db->select('cts_usu_chave')
                                ->get('controle_sessoes')
                                ->result();

            if(empty($consult))
                return 0;

            foreach($consult as $key => $value)
            {
                if($this->encryption->decrypt($value->cts_usu_chave) == $this->encryption->decrypt($key))
                {
                    $count++;
                }
            }

            return $count;

        }

        protected function remove_sessions()
        {

            $this->db->where('cts_tempo <=', time())
                     ->delete('controle_sessoes');

        }

        protected function has_session($name) : bool 
        {

            return ( $this->session->has_userdata($name) != NULL ? TRUE : FALSE );   
    
        }


        /***PAGINAÇÃO***/


        public function data_pagination($db, $parameters, $page, $num_lines = NULL)
        {

            if($num_lines === NULL)
                $num_lines = $this->get_pagination_lines($db);

            return $this->db->select($parameters)
                            ->limit($num_lines, $page)
                            ->get($db)
                            ->result();

        }

        public function create_pagination($base_url, $db)
        {

            $config = array(
                'base_url'        => $base_url,
                'total_rows'      => $this->db->count_all_results($db),
                'per_page'        => $this->get_pagination_lines($db),
                'use_page_numbers'=> TRUE,
                'attributes'      => array('class' => 'pagination')
            );

            return $this->pagination->initialize($config)->create_links();
        }

        public function get_pagination_lines($db) : int
        {
            return round($this->db->count_all_results($db)/2, 0, PHP_ROUND_HALF_UP);
        }

    }

?>