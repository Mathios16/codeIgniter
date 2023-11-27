<?php

    class Pages extends MY_Controller {


        public function __construct() {
            parent::__construct();

            $this->load->helper(array('html', 'url_helper','form','security'));

            $this->load->library(array('table','session','form_validation','javascript','javascript/jquery'));

        }

        public function index() {

            if($this->get_session('id') === TRUE)
            {
                redirect('pages/line');
                return;
            }

            if($this->input->server('REQUEST_METHOD') == 'POST') 
            {
                $this->form_validation->set_rules('email','email','required');
                $this->form_validation->set_rules('password','senha','required');

                if( ! $this->form_validation->run())
                {
                    $this->output->set_content_type('aplication/json')
                                    ->set_output(
                                    json_encode(
                                    array('error'=> TRUE,
                                          'email'=> form_error('email'),
                                          'password'=> form_error('password'),
                                          'type' => 'nulo',
                                          'csrf_token' => $this->security->get_csrf_hash())));
                    return;

                } 
                else
                {
                    if($this->get_tempo_espera()-time() < 0 && ! empty($this->get_tempo_espera()))
                        $this->reset_tentativas();

                    if($this->get_tentativas() >= 3)
                    {
                        if(empty($this->get_tempo_espera()))
                            $this->set_tempo_espera();
                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'=> TRUE,
                                              'email'=> '',
                                              'password'=> 'tentativas excedidas, aguardar ',
                                              'type' => 'exedTent',
                                              'tempo' => $this->get_tempo_espera(),
                                              'csrf_token' => $this->security->get_csrf_hash())));
                        return;

                    }
                    else if( ! $this->verifica_banco($this->input->post('password'), 'senha'))
                    {
                        $this->add_tentativas();
                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'=> TRUE,
                                              'email'=> '',
                                              'password'=> 'dados incorretos',
                                              'type' => 'wrongPassword',
                                              'csrf_token' => $this->security->get_csrf_hash())));
                        return;

                    } 
                    else if( ! $this->verifica_banco($this->input->post('email'), 'email'))
                    {
                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'=> TRUE,
                                              'email'=> '',
                                              'password'=> 'dados incorretos',
                                              'type' => 'wrongEmail',
                                              'csrf_token' => $this->security->get_csrf_hash())));
                        return;

                    }   
                    else 
                    {
                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'=> FALSE)));
                        $this->session->set_userdata('id',$this->get_id());
                        return;

                    }
                }
            }

            $data['scripts'] = array(
                'jquery-3.7.1.min.js' => 'text/javascript',
                'ajax.js' => 'text/javascript',
                'timer.js' => 'text/javascript'
            );
            
            $data['title'] = 'Teste do '.$this->searchDB();

            $this->load->view('templates/header');
            $this->load->view('pages/index', $data);
            $this->load->view('templates/footer', $data);

        }

        public function select_table(){

            $data['type'] = 't';

            $data['table_heading'] = explode(",", $this->get_parameter());
            foreach($data['table_heading'] as $key => $val)
                $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);

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

            $data['consult'] = $this->db->select($this->get_parameter())
                                        ->where($this->get_trigrama().'id', $this->session->id)
                                        ->get($this->searchDB())
                                        ->result();

            $this->load->view('templates/header');
            $this->load->view('pages/view', $data);
            $this->load->view('templates/footer');

            
        }
        
        public function close_session() {

            $this->session->unset_userdata('id');
            redirect('pages');

        }

        /*
        auxiliares
        */

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

        public function verifica_banco($val, $name) : bool {
            return (empty($this->db->select($this->get_trigrama().'id')
                                   ->where($this->get_trigrama().$name, $val)
                                   ->get($this->searchDB())
                                   ->result())
                    ? FALSE : TRUE);
        }
        public function get_id() {
            
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

        public function add_tentativas() {

            if($this->get_tentativas() === FALSE)
                $this->db->insert('tentativas', array('tnt_id' => 0, 'tnt_num' => 0, 'tnt_tabela' => $this->searchDB()));

            $this->db->set('tnt_num', $this->get_tentativas()+1)
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }

        public function reset_tentativas() {

            if($this->get_tentativas() === FALSE)
                $this->db->insert('tentativas', array('tnt_id' => 0, 'tnt_num' => 0, 'tnt_tabela' => $this->searchDB()));

            $this->db->set(array('tnt_num' => 0, 'tnt_tempo' => NULL))
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }

        public function set_tempo_espera() {

             $this->db->set('tnt_tempo', time()+30)
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }

        public function get_tentativas() {

            $consult = $this->db->select('tnt_num')
                                ->where('tnt_tabela', $this->searchDB())
                                ->get('tentativas')
                                ->result();

            if(empty($consult))
                return FALSE;

            return $consult[0]->tnt_num;
        }

        public function get_tempo_espera() {

            $consult = $this->db->select('tnt_tempo')
                                ->where('tnt_tabela', $this->searchDB())
                                ->get('tentativas')
                                ->result();
            
            if(empty($consult))
            {
                $this->set_tempo_espera();
                $this->get_tempo_espera();
            }
            
            return $consult[0]->tnt_tempo;
        
        }
    }

?>