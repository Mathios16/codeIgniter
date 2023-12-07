<?php

    class Selects extends MY_Controller 
    {

        public function __construct() 
        {

            parent::__construct();

            $this->load->helper(array('html','form','security'));

            $this->load->library(array('table','form_validation'));


            if($this->has_session('id') === FALSE)
            {
                redirect('login/index');
                return;
            }

        }

        public function select_table()
        {

            $data['type'] = 't';
            $data['topnav'] = $this->create_topnav('t');


            $data['table_heading'] = explode(",", 'id,'.$this->get_parameter());

            foreach($data['table_heading'] as $key => $val)
            {
                if($key == 5)
                    $data['table_heading'][$key] = 'tp';
                else
                    $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);
            }

            $data['consult'] = $this->data_pagination($this->searchDB(), $this->get_trigrama().'id,'.$this->get_parameter(), $this->uri->segment(3));
            $data['pagination'] = $this->create_pagination(base_url('selects/select_table'), $this->searchDB());

            $data['total_pages'] = $this->db->count_all_results($this->searchDB());

            $data['page_title'] = 'table';

            $data['scripts'] = array(
                'jquery/jquery-3.7.1.min.js' => 'text/javascript',
                'get_id.js' => 'text/javascript'
            );

            $this->load->view('templates/header', $data);
            $this->load->view('pages/selects');
            $this->load->view('templates/footer');

        }

        public function select_line() 
        {

            $data['type'] = 'l';
            $data['topnav'] = $this->create_topnav('l');

            $data['table_heading'] = explode(",", $this->get_parameter());
            foreach($data['table_heading'] as $key => $val)
            {
                if($key == 4)
                    $data['table_heading'][$key] = 'tp';
                else
                    $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);
            }

            $data['consult'] = $this->get_usuario_session();
            
            $data['page_title'] = 'line';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/selects');
            $this->load->view('templates/footer');

        }

        public function select_dados_cep()
        {

            $data['type'] = 'c';
            $data['topnav'] = $this->create_topnav('c');

            $data['table_heading'] = array(

            );

            foreach($data['table_heading'] as $key => $val)
            {
                $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);
            }
            
            $data['page_title'] = 'cep';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/selects');
            $this->load->view('templates/footer');

        }

    }

?>