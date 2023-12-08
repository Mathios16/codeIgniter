<?php 

    echo $topnav;

    echo '</br><div class="container">';
    echo '<table id="table">';
    echo '<thead class="tbl-header">';
    echo '<tr>';
    foreach($table_heading as $value)
        echo'<th>'.$value.'</th>';

    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="tbl-content">';
    echo '<tr>';
    echo '<td id="cep">'.$cep.'</td>';
    echo '<td id="logradouro"></td>';
    echo '<td id="bairro"></td>';
    echo '<td id="localidade"></td>';
    echo '<td id="uf"></td>';
    echo '</tbody>';
    echo '</div>';

?>
