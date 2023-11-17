<?php

    class MY_Controller extends CI_Controller {

        public function __construct() {
            parent::__construct();
        }

        protected function searchDB() : String {

            $nameClass = 'testesession';

            return $nameClass;

        }

        protected function getParameter() : String {

            $parameter = $this->getTrigrama().'nome , '
                        .$this->getTrigrama().'email';

            return $parameter;
        }

        protected function getTrigrama() : String {

            $trigrama = ' tsn_';

            return $trigrama;
        }
    }
?>