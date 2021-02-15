<?php
get_header();

$p = ['a'];


array_push($p, $_POST);
var_dump($p);
?>

<?php get_footer(); ?>