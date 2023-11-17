<?php

    class bd_connection extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function get_bd($id = FALSE) {

            if ($id === FALSE) {
                $query = $this->db->get('testesession');
                return $query->result_array();
            }

            $query = $this->db->get_where('testesession',array('tsn_id' => $id));
            return $query->row_array();

        }

        public function insert_bd($data = FALSE) {

            if($data === FALSE) 
                show_error('falta dados');

            $this->db->insert('',$data);

        }
    }

?>