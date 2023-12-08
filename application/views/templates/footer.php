
    <script type="module">
        import { Octokit } from "https://esm.sh/@octokit/core";
    </script>
    <?php
    if(isset($scripts))
        foreach($scripts as $name => $type)
            echo '<script type=\''.$type.'\' src=\''.site_url('/public/javascript/'.$name).'\'></script>';
    ?>
    </body>
</html>