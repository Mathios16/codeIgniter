<?php 

    $this->table->set_heading($table_heading);

    foreach($consult as $key => $value)
    {
        foreach($value as $val)
            $colum["{$val}"] = $val; 

        $this->table->add_row($colum);
        $colum = NULL;
    }
    
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

<button><a href = "<?php echo site_url('pages/close_session') ?>">Fechar sessao</a></button>

