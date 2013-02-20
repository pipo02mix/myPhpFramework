
<?php $name = $request->get('name', 'World') ?>

<?php echo $foo; ?>
 
Hello <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>