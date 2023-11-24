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
                                            'csrf_token' => $this->security->get_csrf_hash())));
                    return;
                } 
                else{
                    if($this->get_tentativas() >= 3)
                    {
                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'=> TRUE,
                                                'email'=> '',
                                                'password'=> 'tentativas excedidas',
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
                                                'password'=> 'senha não constam no banco',
                                                'csrf_token' => $this->security->get_csrf_hash())));
                        return;
                    } 
                    else if( ! $this->verifica_banco($this->input->post('email'), 'email'))
                    {
                        $this->add_tentativas();
                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'=> TRUE,
                                                'email'=> 'email não consta no banco',
                                                'password'=> '',
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
            
            $data['title'] = 'Teste do '.$this->searchDB();

            $this->load->view('templates/header');
            $this->load->view('pages/index', $data);
            $this->load->view('templates/footer');

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

            if( ! $this->get_tentativas())
                $this->db->insert('tentativas', array('tnt_num' => 0, 'tnt_tabela' => $this->searchDB()));
            $this->db->set('tnt_num', 'tnt_num+1')
                     ->where('tnt_tabela', $this->get_session('id'))
                     ->update('tentativas');

        }

        public function get_tentativas() {

            $consult = $this->db->select('tnt_num')
                        ->where('tnt_tabela', $this->get_session('id'))
                        ->get('tentativas')
                        ->result();

            if(empty($consult))
                return FALSE;

            return $consult[0]->tnt_num;
        }
    }

?>