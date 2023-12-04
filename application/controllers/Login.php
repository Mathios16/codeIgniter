<?php

    class Login extends MY_Controller 
    {

        public function __construct() 
        {

            parent::__construct();

            $this->load->helper(array('form','security'));

            $this->load->library(array('form_validation','javascript','javascript/jquery', 'user_agent'));

        }

        public function index() 
        {

            if($this->has_session('id') === TRUE)
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
                                    array('error'       => TRUE,
                                          'email'       => form_error('email'),
                                          'password'    => form_error('password'),
                                          'type'        => 'null',
                                          'referrer'    => $this->agent->referrer(),
                                          'platform'    => $this->agent->platform(),
                                          'csrf_token'  => $this->security->get_csrf_hash())));
                    return;

                } 
                else
                {

                    if($this->get_tempo_espera()-time() <= 0 && ! empty($this->get_tempo_espera()))
                    {
                        $this->reset_tentativas();
                    }

                    if($this->get_tentativas() >= 3)
                    {

                        if(empty($this->get_tempo_espera()))
                        {
                            $this->set_tempo_espera();
                        }

                        $this->add_num_esperas();

                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'       => TRUE,
                                              'email'       => '',
                                              'password'    => 'Tentativas excedidas, aguardar ',
                                              'type'        => 'exedTent',
                                              'tempo'       => $this->get_tempo_espera(),
                                              'referrer'    => $this->agent->referrer(),
                                              'platform'    => $this->agent->platform(),
                                              'csrf_token'  => $this->security->get_csrf_hash())));
                        return;

                    }
                    else if( ! $this->verifica_banco($this->input->post('password'), 'senha'))
                    {

                        $this->add_tentativas();
                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'       => TRUE,
                                              'email'       => '',
                                              'password'    => 'Dados incorretos',
                                              'type'        => 'wrongPassword',
                                              'referrer'    => $this->agent->referrer(),
                                              'platform'    => $this->agent->platform(),
                                              'csrf_token'  => $this->security->get_csrf_hash())));
                        return;

                    } 
                    else if( ! $this->verifica_banco($this->input->post('email'), 'email'))
                    {

                        $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'       => TRUE,
                                              'email'       => '',
                                              'password'    => 'Dados incorretos',
                                              'type'        => 'wrongEmail',
                                              'referrer'    => $this->agent->referrer(),
                                              'platform'    => $this->agent->platform(),
                                              'csrf_token'  => $this->security->get_csrf_hash())));
                        return;

                    }
                    else 
                    {
                        
                        $this->add_session();

                        if($this->get_num_sessions($this->session->id) >= 3)
                        {

                            $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'       => TRUE,
                                              'email'       => '',
                                              'password'    => 'Usuario em uso',
                                              'type'        => 'exedSessions',
                                              'referrer'    => $this->agent->referrer(),
                                              'platform'    => $this->agent->platform(),
                                              'csrf_token'  => $this->security->get_csrf_hash())));

                            return;

                        }
                        else
                        {

                            $this->reset_num_esperas();
                            $this->output->set_content_type('aplication/json')
                                        ->set_output(
                                        json_encode(
                                        array('error'    => FALSE,
                                              'referrer' => $this->agent->referrer(),
                                              'platform' => $this->agent->platform())));
                        
                        return;

                        }

                    }
                }
            }

            $data['scripts'] = array(
                'jquery-3.7.1.min.js' => 'text/javascript',
                'ajax_login.js' => 'text/javascript',
                'timer.js' => 'text/javascript'
            );
            
            $data['title'] = 'Exercício de Validação';

            $data['page_title'] = 'page';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/login');
            $this->load->view('templates/footer');

        }


        /**************
         * AUXILIARES *
         **************/


        /***SETS***/


        private function add_tentativas() 
        {

            $this->db->set('tnt_num', $this->get_tentativas()+1)
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }
        
        private function add_num_esperas() 
        {

            $this->db->set('tnt_num_esperas', $this->get_num_esperas()+1)
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }
        
        private function set_tempo_espera() 
        {

             $this->db->set('tnt_tempo', time()+(30*($this->get_num_esperas())))
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }


        /***GETS***/


        private function get_tentativas() 
        {

            $consult = $this->db->select('tnt_num')
                                ->where('tnt_tabela', $this->searchDB())
                                ->get('tentativas')
                                ->result();

            if(empty($consult))
                return FALSE;

            return $consult[0]->tnt_num;
        }
        
        private function get_num_esperas() 
        {

            $consult = $this->db->select('tnt_num_esperas')
                                ->where('tnt_tabela', $this->searchDB())
                                ->get('tentativas')
                                ->result();

            if(empty($consult))
                return FALSE;

            return $consult[0]->tnt_num_esperas;
        }

        private function get_tempo_espera() 
        {
            if($this->get_tentativas() === FALSE)
                $this->db->insert('tentativas', array('tnt_id' => 0, 'tnt_num' => 0, 'tnt_tabela' => $this->searchDB()));

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


        /***RESETS***/


        private function reset_tentativas() 
        {

            $this->db->set(array('tnt_num' => 0, 'tnt_tempo' => NULL))
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }

        private function reset_num_esperas() 
        {

            $this->db->set('tnt_num_esperas', 1)
                     ->where('tnt_tabela', $this->searchDB())
                     ->update('tentativas');

        }


    }

?>