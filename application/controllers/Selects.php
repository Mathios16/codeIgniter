<?php

    class Selects extends MY_Controller 
    {

        public function __construct() 
        {

            parent::__construct();

            $this->load->helper(array('html', 'url_helper','form','security'));

            $this->load->library(array('table','form_validation'));

        }

        public function select_table()
        {

            $data['type'] = 't';

            $data['table_heading'] = explode(",", $this->get_parameter());
            foreach($data['table_heading'] as $key => $val)
                $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);


            $data['consult'] = $this->data_pagination($this->searchDB(), $this->get_parameter(), $this->uri->segment(3));

            $data['pagination'] = $this->create_pagination(base_url('selects/select_table'), $this->searchDB());

            $data['page_title'] = 'table';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/selects');
            $this->load->view('templates/footer');

        }

        public function select_line() 
        {

            $data['type'] = 'l';

            $data['table_heading'] = explode(",", $this->get_parameter());
            foreach($data['table_heading'] as $key => $val)
                $data['table_heading'][$key] = str_replace($this->get_trigrama(), '', $val);

            $id = $this->get_sessions('cts_usu_id', $this->session->id);

            $data['consult'] = $this->db->select($this->get_parameter())
                                        ->where($this->get_trigrama().'id', $id)
                                        ->get($this->searchDB())
                                        ->result();
            
            $data['page_title'] = 'line';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/selects');
            $this->load->view('templates/footer');

        }

    }

?>