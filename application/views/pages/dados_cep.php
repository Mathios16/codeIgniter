<?php 

    echo $topnav;

    echo '</br><div class="container">';
    $this->table->set_heading($table_heading);

    $i = 0;
    foreach($consult as $val)
    {
        $colum[$table_heading[$i]] = $val;
        $i++; 
    }
    $this->table->add_row($colum);
    $colum = NULL;
    

    $template = array(
        'table_open'=> '<table id="table">',

        'thead_open'=> '<thead class="tbl-header">',
        'thead_close'=> '</thead>',

        'tbody_open'=> '<tbody class="tbl-content">',
        'tbody_close'=> '</tbody>',

        'table_close'=> '</table>',

    );
    
    $this->table->set_template($template);
    echo $this->table->generate();

    echo '</div>';

?>
