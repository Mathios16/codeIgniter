<?php 

    echo '<div class="topnav">';
    if($type === 't')
    {
        echo '<br><a href = ';
        echo site_url('pages/line');
        echo '>ver seus dados</a>';
    }
    else
    {
        echo '<br><a href = ';
        echo site_url('pages/table');
        echo '>ver todos os dados</a>';
    }

    echo '<a href = '.site_url('logout/close_session').'>Fechar sessao</a></br>';
    echo '</div>';
    echo '<div class="container">';
    $this->table->set_heading($table_heading);

    foreach($consult as $key => $value)
    {
        foreach($value as $val)
        {
            $colum[$val] = $val; 
        }
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


    if( $type === 't'){

        echo $pagination;

    }
    

    echo '</div>';

?>
