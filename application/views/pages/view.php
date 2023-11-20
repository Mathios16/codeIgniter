<table>
    <tr>
        <?php
            foreach($bd as $index => $val)
                echo '<th>'.$index.'</th>';
            
            echo '</tr><tr>';

            foreach($bd as $index => $val)
                if($index%2 == 0)
                    echo '<td>'.$val.'</td>';
            
            echo '</tr><tr>';

            foreach($bd as $index => $val)
                if($index%2 != 0)
                    echo '<td>'.$val.'</td>';
            
            echo '</tr>';
        ?>
    </tr>
</table>
<br><p><a href = "<?php echo site_url('pages/index') ?>">Index</a></p>
