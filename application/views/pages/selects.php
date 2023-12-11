<?php 

    $template = array(
        'table_open'=> '<table id="table">',

        'thead_open'=> '<thead class="tbl-header">',
        'thead_close'=> '</thead>',

        'tbody_open'=> '<tbody class="tbl-content">',
        'tbody_close'=> '</tbody>',

        'table_close'=> '</table>',

    );

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
        $template = array_merge($template,array(
            'row_end'       => '<td><button><a href="'.site_url('update').'/'.'">Editar</a></button></td></tr>',
            'row_alt_end'   => '<td><button><a href="'.site_url('update').'/">Editar</a></button></td></tr>',
        ));

        $this->table->set_template($template);
        echo $this->table->generate();

        echo '</div>';

        echo '<div class="pagination-flex">'.$pagination.'</div>';
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

        $this->table->set_template($template);
        echo $this->table->generate();

        $this->table->set_heading($table_heading_cep);

        $i = 0;
        foreach($consult_cep as $val)
        {
            $colum[$table_heading[$i]] = $val;
            $i++; 
        }
        $this->table->add_row($colum);
        $colum = NULL;

        echo '</div><div class="container">';
        $this->table->set_template($template);
        echo $this->table->generate();
        ?>

        </div><div class="container">
            <img class="avatar" src=""/>
            <table id="git-usu">
                <thead class="tbl-header">
                    <tr>
                        <?php 
                            foreach($table_heading_github as $heading)
                                echo '<th>'.$heading.'</th>';
                        ?>
                    </tr>
                </thead>
                <tbody class="tbl-content">
                    <tr>
                        <td class="username"><?php echo $consult_github ?></td>
                        <td class="name"></td>
                        <td class="creation"></td>
                        <td class="url"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        </div><div class="container">
            <table id="git-repos">
                <thead class="tbl-header">
                    <tr>
                        <?php 
                            foreach($table_heading_repos as $heading)
                                echo '<th>'.$heading.'</th>';
                        ?>
                    </tr>
                </thead>
                <tbody class="tbl-repos">
                    
                </tbody>
            </table>
        </div>

        <?php
    }
?>