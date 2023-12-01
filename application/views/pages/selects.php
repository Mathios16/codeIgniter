<?php 

    echo '<div class="topnav">';
    if($type === 't')
    {
        echo '<br><a  href = ';
        echo site_url('pages/line');
        echo '>Seus dados</a>';

        echo '<br><a class="active" href = ';
        echo site_url('pages/table');
        echo '>Todos os dados</a>';
    }
    else
    {
        echo '<br><a class="active" href = ';
        echo site_url('pages/line');
        echo '>Seus dados</a>';

        echo '<br><a href = ';
        echo site_url('pages/table');
        echo '>Todos os dados</a>';
    }

    echo '<a href = '.site_url('logout/close_session').'>Fechar sessão</a>';
    echo '</div>';
    echo '</br><div class="container">';
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

    echo '</div>';

    if( $type === 't'){

        echo '<div class="pagination-flex">';

        echo $pagination.'</div>';

    }

?>
