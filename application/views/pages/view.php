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

?>

<br><p><a href = "<?php echo site_url('pages/index') ?>">Voltar</a></p>

<br><p><a href = "<?php echo site_url('pages/close_session') ?>">Fechar sessao</a></p>

