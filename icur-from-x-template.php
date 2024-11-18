<?php
/* Template Name: ICUR From X Template */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<style>
    body {
        background-color: white;  
        color: black;
        margin: 2em;  
    }

    h1 {
        color: pink;
        font-size: 2em;
        background: black;
        padding: 0.5em;
        text-align: center;
    }

    h2 {
        color: #630755;
        font-size: 1.5em;
        padding: 0.5em;
        text-align: center;
    }

    .icur-from-x {
        color: red;
    }

    .icur-from-x-note {
        color: #3d3d3d;
        padding: .6em 0;
        font-weight: bold;
    }

    .icur-from-x-hostnames {
        color: #7ea830;
        padding: .6em 0;
        font-weight: bold;
        background: #343131;
        text-align: center;
    }

    .icur-from-x-sitenote {
        color: #191b17;
        padding: .5em;
        margin: .5em;
        font-weight: bold;
        border: 6px dotted #d86624;
    }
</style>
<body>

<h1>ICUR From X</h1>

<p class="icur-from-x-note">
    The owner of this website is letting you know about where you clicked on the link that brought you here. Please contingue reading, and have a nice day!
</p>
<p class="icur-from-x-note">
    Visitors following links shared or distributed on networks originating from by the  following hostnames will see this message:
</p>
<p class="icur-from-x-hostnames">
<?php echo get_option('icur_from_x_hostnames'); ?>
</p>

<h2>Site Note!</h2>

<p class="icur-from-x-sitenote">
<?php echo get_option('icur_from_x_custom_html'); ?>
</p>

<p>To view the orginal content, please copy the Universal Resource Locator (URL) and paste it into your browser.</p>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        ?>
        <h1><?php the_permalink(); ?></h1>
        <?php
    endwhile;
endif;
?>

</body>
</html>
