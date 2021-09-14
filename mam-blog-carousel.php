<?php
/**
 * Plugin Name: Move Ahead Media Blog Posts Carousel
 * Plugin URI: https://github.com/moveaheadmedia/blog-carousel/
 * Description: You can use this shortcode [mam-blog-carousel] to show recent 12 blog posts as carousel
 * Version: 1.0
 * Author: Move Ahead Media
 * Author URI: https://github.com/moveaheadmedia
 * You can use this shortcode [mam-blog-carousel] to show recent 12 blog posts as carousel
 * Requires jQuery to be installed
 */

function mam_blog_carousel($atts, $content = "")
{
    $attributes = shortcode_atts(array(
        'limit' => 12,
        'slidesToShow' => 3,
        'slidesToScroll' => 3,
        'infinite' => true,
        'dots' => false,
        'arrows' => true,
        'centerMode' => false,
        'adaptiveHeight' => true,
        'responsive' => array(
            array(
                'breakpoint' => 992,
                'settings' => array(
                    'slidesToShow' => 2,
                    'slidesToScroll' => 2,
                )
            ),
            array(
                'breakpoint' => 400,
                'settings' => array(
                    'slidesToShow' => 1,
                    'slidesToScroll' => 1,
                )
            )
        )
    ), $atts);
    $data = $content;
    if ($data == "") {
        $data = json_encode($attributes);
    }

    $the_query = new WP_Query(array(
        'posts_per_page' => $attributes['limit']
    ));

    ob_start();
    ?>
    <?php if ($the_query->have_posts()) : ?>
    <div class="mam-blog-carousel">
        <div data-slick='<?php echo $data; ?>'>
            <?php while ($the_query->have_posts()) :
                $the_query->the_post();
                $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                if (!$image) {
                    $image = 'https://via.placeholder.com/300/EA4628/';
                }
                ?>
                <div class="mam-blog-carousel-slide">
                    <div class="mam-blog-carousel-slide-inner">
                        <a href="<?php echo get_permalink(); ?>" class="mam-blog-carousel-link"></a>
                        <div class="mam-blog-carousel-image" style="background-image: url('<?php echo $image; ?>');"
                             data-same-height="mam-blog-carousel-image">
                            <img src="<?php echo $image; ?>"
                                 alt="<?php echo get_the_title(); ?>"/>
                        </div>
                        <div class="mam-blog-carousel-title" data-same-height="mam-blog-carousel-title">
                            <h3><?php echo get_the_title(); ?></h3></div>
                        <div class="mam-blog-carousel-excerpt"
                             data-same-height="mam-blog-carousel-excerpt"><?php echo get_the_excerpt(); ?></div>
                        <a href="<?php echo get_permalink(); ?>"
                           class="mam-blog-carousel-button btn btn-primary"><?php echo __('Read More'); ?></a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php echo __('No Posts!'); ?></p>
<?php endif; ?>
    <?php
    return ob_get_clean();
}

add_shortcode('mam-blog-carousel', 'mam_blog_carousel');

function mam_blog_add_scripts()
{
    wp_enqueue_style('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
    wp_enqueue_style('slick-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');
    wp_enqueue_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'));
    wp_enqueue_script('mam-blog-carousel', plugin_dir_url(__FILE__) . 'scripts.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'mam_blog_add_scripts');