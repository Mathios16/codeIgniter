<?php session_start(); ?>

<h2><?php echo $title; ?></h2>

<div class = "container">
        <?php echo form_open('pages/selectLine'); ?>
                <input type = "text" name = "nome" required></br>
                <input type = "text" name = "e-mail" required></br>
                <input type = "password" name = "senha" required></br>

                <button type = "submit" name = "Login">Login</button>
        </form>
</div>
