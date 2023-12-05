<?php
    class Update extends MY_Controller 
    {

        public function __construct() 
        {

            parent::__construct();

            $this->load->helper(array('form','security'));

            $this->load->library(array('form_validation','javascript','javascript/jquery', 'user_agent'));

        }

        public function index() 
        {

            if($this->input->server('REQUEST_METHOD') == 'POST') 
            {

                $this->form_validation->set_rules('name','nome','required');
                $this->form_validation->set_rules('email','email','required|valid_email');
                $this->form_validation->set_rules('password','senha','required');
                $this->form_validation->set_rules('identifier','tipo pessoa','required');
                $this->form_validation->set_rules('phone','telefone','required');

                if( ! $this->form_validation->run())
                {

                    $this->output->set_content_type('aplication/json')
                                    ->set_output(
                                    json_encode(
                                    array('error'       => TRUE,
                                          'name'        => form_error('name'),
                                          'email'       => form_error('email'),
                                          'password'    => form_error('password'),
                                          'identifier'  => form_error('identifier'),
                                          'phone'       => form_error('phone'),
                                          'type'        => 'null',
                                          'referrer'    => $this->agent->referrer(),
                                          'platform'    => $this->agent->platform(),
                                          'csrf_token'  => $this->security->get_csrf_hash())));
                    return;

                } 
                else
                {
                    $original = $this->get_usuario();
                    
                    if( $this->input->post('name') != $original->usu_nome)
                    {
                        $this->update_usuario($this->get_trigrama().'nome', $this->input->post('name'), $this->get_id());
                    }

                    if( $this->input->post('email') != $original->usu_email)
                    {
                        $this->update_usuario($this->get_trigrama().'email', $this->input->post('email'), $this->get_id());
                    }

                    if( $this->input->post('password') != $original->usu_senha)
                    {
                        $this->update_usuario($this->get_trigrama().'senha', $this->input->post('password'), $this->get_id());
                    }

                    if( $this->input->post('phone') != $original->usu_telefone)
                    {
                        $this->update_usuario($this->get_trigrama().'telefone', $this->input->post('phone'), $this->get_id());
                    }

                    if( $this->input->post('identifier') != $original->usu_identificador)
                    {
                        $this->update_usuario($this->get_trigrama().'identificador', $this->input->post('identifier'), $this->get_id());
                    }

                    $this->output->set_content_type('aplication/json')
                                ->set_output(
                                json_encode(
                                array('error'    => FALSE,
                                      'referrer' => $this->agent->referrer(),
                                      'platform' => $this->agent->platform())));
                    
                    return;

                }
            }

            $data['scripts'] = array(
                'jquery/jquery-3.7.1.min.js' => 'text/javascript',
                'jquery/jquery.mask.min.js' => 'text/javascript',
                'ajax_update.js' => 'text/javascript'
            );

            $data['topnav'] = $this->create_topnav('u');
            
            $data['title'] = 'Atualização de Dados';

            $data['page_title'] = 'atualizar';

            $data['valores'] = $this->get_usuario();

            $this->load->view('templates/header', $data);
            $this->load->view('pages/update');
            $this->load->view('templates/footer');

        }
    }
?>