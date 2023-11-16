<h2><?php echo $title; ?></h2>

<?php foreach ($bd as $bd_item): ?>

        <h3><p><a href="<?php echo site_url('pages/view/'.$bd_item->bd_id); ?>"><?php echo $bd_item->bd_id;?></a></p></h3>
        <div class="main">
                <?php echo $bd_item->bd_nome; ?>
        </div>
        

<?php endforeach; ?>