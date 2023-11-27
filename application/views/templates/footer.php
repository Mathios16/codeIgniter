
    <?php
        foreach($scripts as $name => $type)
        {
            echo '<script type=\''.$type.'\' src=\'http://127.0.0.1/new.teste/public/'.$name.'\'></script>';
        }
    ?>
    </body>
</html>