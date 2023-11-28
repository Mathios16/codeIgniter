
    <?php
    if(isset($scripts))
        foreach($scripts as $name => $type)
            echo '<script type=\''.$type.'\' src=\''.site_url('/public/javascript/'.$name).'\'></script>';
    ?>
    </body>
</html>