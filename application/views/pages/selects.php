<div class="container">
    
    <?php 
        $this->table->set_heading($table_heading);

        foreach($consult as $key => $value)
        {
            foreach($value as $val)
                $colum["{$val}"] = $val; 

            $this->table->add_row($colum);
            $colum = NULL;
        }

        $template = array(
                            'table_open'=> '<table>',

                            'thead_open'=> '<thead class="tbl-header">',
                            'thead_close'=> '</thead>',

                            'tbody_open'=> '<tbody class="tbl-content">',
                            'tbody_close'=> '</tbody>',

                            'table_close'=> '</table>',
        );
        
        $this->table->set_template($template);
        echo $this->table->generate();

        if($type === 't')
        {
            echo '<br><button><a href = ';
            echo site_url('pages/line');
            echo '>ver seus dados</a></button>';
        }
        else
        {
            echo '<br><button><a href = ';
            echo site_url('pages/table');
            echo '>ver todos os dados</a></button>';
        }

    ?>
    <button> <a href = "<?php echo site_url('selects/close_session') ?>">Fechar sessao</a></button>
</div>
