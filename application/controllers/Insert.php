<?php
    class Insert extends MY_Controller 
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
                $this->form_validation->set_rules('cep','cep','required');

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
                                          'cep'         => form_error('cep'),
                                          'type'        => 'null',
                                          'referrer'    => $this->agent->referrer(),
                                          'platform'    => $this->agent->platform(),
                                          'csrf_token'  => $this->security->get_csrf_hash())));
                    return;

                } 
                else
                {
                    $this->add_usuario();
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
                'jquery/jquery-3.7.1.min.js'=> 'text/javascript',
                'jquery/jquery.mask.min.js' => 'text/javascript',
                'ajax_insert.js'            => 'text/javascript',
                'jquery_mask.js'            => 'text/javascript'
            );

            $data['topnav'] = $this->create_topnav('i');
            
            $data['title'] = 'Insersão de Dados';

            $data['page_title'] = 'inserir';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/insert');
            $this->load->view('templates/footer');

        }
    }
?>