<?php 

    echo $topnav;

    echo '</br><div class="container">';
    $this->table->set_heading($table_heading);
    if(gettype($consult) == 'array')
    {
        foreach($consult as $key => $value)
        {
            $i = 0;
            foreach($value as $val)
            {
                $colum[$table_heading[$i]] = $val; 
                $i++;
            }
            $this->table->add_row($colum);
            $colum = NULL;
        }
    }
    else
    {
        $i = 0;
        foreach($consult as $val)
        {
            $colum[$table_heading[$i]] = $val;
            $i++; 
        }
        $this->table->add_row($colum);
        $colum = NULL;
    }
    

    $template = array(
        'table_open'=> '<table id="table">',

        'thead_open'=> '<thead class="tbl-header">',
        'thead_close'=> '</thead>',

        'tbody_open'=> '<tbody class="tbl-content">',
        'tbody_close'=> '</tbody>',

        'table_close'=> '</table>',

    );

    if($type == 't')
    {
        $template = array_merge($template,array(
            'row_end'       => '<td><button><a href="'.site_url('update').'/'.'">Editar</a></button></td></tr>',
            'row_alt_end'   => '<td><button><a href="'.site_url('update').'/">Editar</a></button></td></tr>',
        ));
    }

    
    $this->table->set_template($template);
    echo $this->table->generate();

    echo '</div>';

    if($type == 't')
    {
        echo '<div class="pagination-flex">'.$pagination.'</div>';
    } 

?>
