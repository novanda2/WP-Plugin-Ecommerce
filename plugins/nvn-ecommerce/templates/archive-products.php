<?php

get_header();

$description = get_the_archive_description();
?>

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <?php get_template_part('template-parts/content/content', get_theme_mod('display_excerpt_or_full_post', 'excerpt')); ?>
    <?php endwhile; ?>

   

<?php else : ?>
    <?php get_template_part('template-parts/content/content-none'); ?>
<?php endif; ?>

<?php get_footer(); ?>