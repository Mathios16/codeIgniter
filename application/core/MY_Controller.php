<?php

    class MY_Controller extends CI_Controller 
    {

        public function __construct() 
        {

            parent::__construct();

            $this->load->helper(array('html', 'url_helper','form','security'));

            $this->load->library(array('session','encryption', 'pagination'));


            $this->remove_sessions();

            $adm_only_class = array(
                ''
            );

            $adm_only_pages = array(
                "/update\/\d/",
                "/pages\/table\/\d/"
            );

            if($this->get_usuario_acesso($this->get_id_session()) != 'adm')
            {
                foreach($adm_only_class as $key)
                {
                    if(static::class == $key)
                    {
                        redirect('pages/line');
                        return;
                    }
                    foreach($adm_only_pages as $value)
                    {
                        if(preg_match($value, $this->uri->uri_string()))
                        {
                            redirect('pages/line');
                            return;
                        }
                    }
                }
            } 
        }


        /*********
         * BANCO *
         *********/


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
                        .$this->get_trigrama().'tp_identificador , '
                        .$this->get_trigrama().'telefone , '
                        .$this->get_trigrama().'cep , '
                        .$this->get_trigrama().'github';

            return $parameter;
        }

        protected function get_endereco() : String 
        {

            $parameter = $this->get_trigrama().'logradouro , '
                        .$this->get_trigrama().'bairro , '
                        .$this->get_trigrama().'cidade , '
                        .$this->get_trigrama().'estado';

            return $parameter;
        }

        protected function get_trigrama() : String 
        {

            return ' usu_';

        }


        
        /****************
         * INSERSÕES BD *
         ****************/


        protected function add_usuario()
        {

            $values = array(
                $this->get_trigrama().'nome'            => $this->input->post('name'),
                $this->get_trigrama().'email'           => $this->input->post('email'),
                $this->get_trigrama().'senha'           => $this->input->post('password'),
                $this->get_trigrama().'identificador'   => $this->input->post('identifier'),
                $this->get_trigrama().'tp_identificador'=> $this->input->post('tipo_pessoa'),
                $this->get_trigrama().'telefone'        => $this->input->post('phone'),
                $this->get_trigrama().'cep'             => $this->input->post('cep'),
                $this->get_trigrama().'logradouro'      => $this->input->post('logradouro'),
                $this->get_trigrama().'bairro'          => $this->input->post('bairro'),
                $this->get_trigrama().'cidade'          => $this->input->post('cidade'),
                $this->get_trigrama().'estado'          => $this->input->post('estado'),
                $this->get_trigrama().'github'          => $this->input->post('github')
            );


            $this->db->insert($this->searchDB(), $values);
        }

        protected function update_usuario($attr, $value, $id)
        {

            $this->db->set($attr, $value)
                     ->where($this->get_trigrama().'id', $id)
                     ->update($this->searchDB());

        }


        /****************
         * CONSULTAS BD *
         ****************/


        protected function get_id_post() 
        {
            
            $where = array(
                $this->get_trigrama().'email'=> $this->input->post('email'),
                $this->get_trigrama().'senha'=> $this->input->post('password')
            );

            $consult = $this->db->select($this->get_trigrama().'id')
                                ->where($where)
                                ->get($this->searchDB())
                                ->result();

            if (empty($consult))
                return FALSE;
            
            return $consult[0]->usu_id;

        }

        protected function get_id_session()
        {
            return $this->encryption->decrypt($this->session->id);
        }

        protected function get_usuario_session($attr = NULL) 
        {
            
            $id = $this->get_id_session();

            if($attr == 'completo')
            {
                $parametros = $this->get_parameter().' , '.$this->get_endereco();
            }
            else if( $attr == 'endereco')
            {
                $parametros = $this->get_endereco();
            }
            else
            {
                $parametros = $this->get_parameter();
            }

            $consult = $this->db->select($parametros)
                                        ->where($this->get_trigrama().'id', $id)
                                        ->get($this->searchDB())
                                        ->result();

            if (empty($consult))
                return FALSE;
            
            return $consult[0];

        }

        protected function get_usuario($id, $attr = NULL) 
        {
            if($attr == 'completo')
            {
                $parametros = $this->get_parameter().' , '.$this->get_endereco();
            }
            else if( $attr == 'endereco')
            {
                $parametros = $this->get_endereco();
            }
            else if( $attr == 'usuario')
            {
                $parametros = $this->get_parameter();
            }
            else
            {
                $parametros = $this->get_trigrama().$attr;
                
            }
            $consult = $this->db->select($parametros)
                                ->where($this->get_trigrama().'id', $id)
                                ->get($this->searchDB())
                                ->result();

            if (empty($consult))
                return FALSE;
            
            return $consult[0];

        }

        protected function get_usuario_acesso($id) 
        {

            $consult = $this->db->select($this->get_trigrama().'acesso')
                                ->where($this->get_trigrama().'id', $id)
                                ->get($this->searchDB())
                                ->result();

            if (empty($consult))
                return FALSE;
            
            return $consult[0]->usu_acesso;

        }

        protected function verifica_banco($val, $name) : bool 
        {
            return (empty($this->db->select($this->get_trigrama().'id')
                                   ->where($this->get_trigrama().$name, $val)
                                   ->get($this->searchDB())
                                   ->result())
                    ? FALSE : TRUE);
        }



        /*********************
         * CONSULTAS SESSION *
         *********************/


        protected function add_session()
        {
            $id = $this->get_id_post();
            $this->db->insert('controle_sessoes', 
                        array('cts_id'       => 0,
                              'cts_tabela'   => $this->searchDB(),
                              'cts_usu_chave'=> $this->encryption->encrypt($id),
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



        /*************
         * PAGINAÇÃO *
         *************/


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


        /**********************
         * NAVEGAÇÃO SUPERIOR *
         **********************/


        public function create_topnav($type)
        {

            $selects_adm = array(
                'pages/table' => 'Todos Dados',
                'pages/line' => 'Seus Dados'
            );

            $html = "<div class='topnav'>";
            
            $active = FALSE;
            for($i = 0; $i < 5; $i++)
            {
                switch($type)
                {
                    case 'l': 
                    case 't': if($i == 0) $active = TRUE; break;
                    case 'i': if($i == 1) $active = TRUE; break;
                    case 'u': if($i == 2) $active = TRUE;
                };
                if($this->get_usuario_acesso($this->get_id_session()) == 'adm')
                {
                    switch($i)
                    {
                        case 0: $html .= $this->create_subtopnav($selects_adm, 'Dados', $active); break;
                        case 1: $html .= $this->create_topnav_item('insert',        'Inserir Dados',    $active); break;
                        case 2: $html .= $this->create_topnav_item('update',        'Atualizar Dados',  $active); break;
                    };
                }
                else
                {
                    switch($i)
                    {
                        case 0: $html .= $this->create_topnav_item('pages/line',    'Seus Dados',       $active); break;
                        case 1: $html .= $this->create_topnav_item('insert',        'Inserir Dados',    $active); break;
                        case 2: $html .= $this->create_topnav_item('update',        'Atualizar Dados',  $active); break;
                    };
                }
                $active = FALSE;
            }

            $html .= "<a href = ".site_url('logout/close_session').">Fechar Sessão</a></div>";

            return $html;

        }

        private function create_topnav_item($url, $nome, $active = FALSE, $subtopnav = NULL) : string
        {

            if($active == FALSE)
                $html = '<br><a href = ';
            else
                $html = '<br><a class="active" href = ';

            $html .= site_url($url);

            $html .= '>'.$nome.$subtopnav.'</a>';
            return $html;
        }

        private function create_subtopnav($array, $title, $active) : string
        {
            $html = '<div class="subtopnav">';
            if($active == FALSE)
                $html .= '<span>'.$title.'</span>';
            else
                $html .= '<span class="active">'.$title.'</span>';

            foreach($array as $url => $nome)
            {
                $html .= '<br><a class="subtopnav-item" href = ';
                $html .= site_url($url);
                $html .= '>'.$nome.'</a>';
            };

            $html .= '</div>';
            return $html;
        }
    }

?>