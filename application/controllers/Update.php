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
                $this->form_validation->set_rules('identifier','identificador','required');
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
                    $original = NULL;
                    $id = NULL;
                    if($this->uri->segment(2) == NULL)
                    {
                        $original = $this->get_usuario_session();
                        $id = $this->get_id_session();
                    }
                    else
                    {
                        $original = $this->get_usuario($this->uri->segment(2));
                        $id = $this->uri->segment(2);
                    }
                    
                    if( $this->input->post('name') != $original->usu_nome)
                    {
                        $this->update_usuario($this->get_trigrama().'nome', $this->input->post('name'), $id);
                    }

                    if( $this->input->post('email') != $original->usu_email)
                    {
                        $this->update_usuario($this->get_trigrama().'email', $this->input->post('email'), $id);
                    }

                    if( $this->input->post('password') != $original->usu_senha)
                    {
                        $this->update_usuario($this->get_trigrama().'senha', $this->input->post('password'), $id);
                    }

                    if( $this->input->post('phone') != $original->usu_telefone)
                    {
                        $this->update_usuario($this->get_trigrama().'telefone', $this->input->post('phone'), $id);
                    }

                    if( $this->input->post('identifier') != $original->usu_identificador)
                    {
                        $this->update_usuario($this->get_trigrama().'identificador', $this->input->post('identifier'), $id);
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

            if($this->uri->segment(2) == NULL)
            {
                $data['valores'] = $this->get_usuario_session();
                $data['type'] = 'update';
            }
            else
            {
                $data['valores'] = $this->get_usuario($this->uri->segment(2));
                $data['type'] = 'update/'.$this->uri->segment(2);
            }

            $data['scripts'] = array(
                'jquery/jquery-3.7.1.min.js' => 'text/javascript',
                'jquery/jquery.mask.min.js' => 'text/javascript',
                'ajax_update.js' => 'text/javascript',
                'ajax_mask.js' => 'text/javascript'
            );

            $data['topnav'] = $this->create_topnav('u');
            
            $data['title'] = 'Atualização de Dados';

            $data['page_title'] = 'atualizar';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/update');
            $this->load->view('templates/footer');

        }
    }
?>