<?php

function blockspare_blocks_render_block_core_latest_posts_grid($attributes)
{

    $categories = isset($attributes['categories']) ? $attributes['categories'] : '';

    /* Setup the query */
    $grid_query = new WP_Query(
        array(
            'posts_per_page' => $attributes['postsToShow'],
            'post_status' => 'publish',
            'order' => $attributes['order'],
            'orderby' => $attributes['orderBy'],
            'cat' => $categories,
            'offset' => $attributes['offset'],
            'post_type' => $attributes['postType'],
            'ignore_sticky_posts' => 1,
        )
    );

    $blockspare_content_markup = '';

    /* Start the loop */
    if ($grid_query->have_posts()) {

        while ($grid_query->have_posts()) {
            $grid_query->the_post();

            /* Setup the post ID */
            $post_id = get_the_ID();

            /* Setup the featured image ID */
            $post_thumb_id = get_post_thumbnail_id($post_id);

            /* Setup the post classes */
            $post_classes = 'blockspare-post-single';

            /* Add sticky class */
            if (is_sticky($post_id)) {
                $post_classes .= ' sticky';
            } else {
                $post_classes .= null;
            }


            if ($attributes['enableBackgroundColor']) {
                $post_classes .= ' has-background';
            }


            $bxshadow = '';

            if ($attributes['enableBoxShadow']) {
                $bxshadow = $attributes['xOffset'] . "px " . $attributes['yOffset'] . "px " . $attributes['blur'] . "px " . $attributes['spread'] . "px " . $attributes['shadowColor'];
            }

            if ($attributes['equalImageHeight']) {
                $post_classes .= ' has-img-equal-height';
            } else {
                $post_classes .= '';
            }
            /* Join classes together */
            $post_classes = join(' ', get_post_class($post_classes, $post_id));


            $item_background_color = ($attributes['enableBackgroundColor']) ? esc_attr($attributes['backGroundColor']) : '';
            $item_style = '';
            if (($attributes['design'] != 'blockspare-grid-layout-4') && ($attributes['design'] != 'blockspare-grid-layout-5') && ($attributes['design'] != 'blockspare-grid-layout-6')) {
                $item_style .= 'background-color:' . esc_attr($item_background_color) . ';';
                $item_style .= ' border-radius:' . esc_attr($attributes['borderRadius']) . "px;";
                $item_style .= ' box-shadow:' . esc_attr($bxshadow) . ';';
            }

            /* Start the markup for the post */
            $blockspare_content_markup .= sprintf(
                '<article id="post-%1$s" class="%2$s" style="%3$s">',
                esc_attr($post_id),
                esc_attr($post_classes),
                $item_style

            );

            /* Get the featured image */
            if (isset($attributes['displayPostImage']) && $attributes['displayPostImage'] && $post_thumb_id) {


                if (!empty($attributes['imageSize'])) {
                    $post_thumb_size = $attributes['imageSize'];
                }

                if (has_post_thumbnail($post_id)) {
                    /* Output the featured image */
                    $blockspare_content_markup .= sprintf(
                        '<figure class="blockspare-post-img">
                               <a href="%1$s" rel="bookmark" aria-hidden="true" tabindex="-1" > %2$s</a></figure>',
                        esc_url(get_permalink($post_id)),
                        wp_get_attachment_image($post_thumb_id, $post_thumb_size)


                    );
                }

            }


            /* Wrap the text content */
            $blockspare_content_markup .= sprintf(
                '<div class="blockspare-post-content %1$s">',
                $attributes['contentOrder']

            );

            $blockspare_content_markup .= sprintf(
                '<div class="blockspare-bg-overlay" style="background-color: %1$s"></div>',
                ($attributes['enableBackgroundColor']) ? esc_attr($attributes['backGroundColor']) : ''

            );


            $blockspare_content_markup .= sprintf(
                '<header class="blockspare-block-post-grid-header">'
            );
            if ($attributes['displayPostCategory']) {
                $blockspare_content_markup .= sprintf(
                    '<div class="blockspare-post-category" style="color:%2$s;">%1$s</div>',
                    get_the_category_list(esc_html__(' ', 'blockspare'), '', $post_id),
                    esc_attr($attributes['linkColor'])
                );
            }

            /* Get the post title */
            $title = get_the_title($post_id);

            if (!$title) {
                $title = __('Untitled', 'blockspare');
            }

            if (isset($attributes['displayPostTitle']) && $attributes['displayPostTitle']) {

                if (isset($attributes['postTitleTag'])) {
                    $post_title_tag = $attributes['postTitleTag'];
                } else {
                    $post_title_tag = 'h4';
                }

                $blockspare_content_markup .= sprintf(
                    '<%3$s class="blockspare-block-post-grid-title" style="font-size: %5$s;"><a style="color:%4$s;" href="%1$s" rel="bookmark">%2$s</a></%3$s>',
                    esc_url(get_permalink($post_id)),
                    esc_html($title),
                    esc_attr($post_title_tag),
                    esc_attr($attributes['postTitleColor']),
                    esc_attr($attributes['postTitleFontSize']) . 'px'
                );
            }

            if (isset($attributes['postType']) && ($attributes['postType'] === 'post') && (isset($attributes['displayPostAuthor']) || isset($attributes['displayPostDate']))) {
                /* Wrap the byline content */

                $blockspare_content_markup .= sprintf(
                    '<div class="blockspare-block-post-grid-byline">'
                );

                /* Get the post author */
                if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor']) {
                    $blockspare_content_markup .= sprintf(
                        '<div class="blockspare-block-post-grid-author"><a style="color:%3$s;" class="blockspare-text-link" href="%2$s" itemprop="url" rel="author"><span itemprop="name">%1$s</span></a></div>',
                        esc_html(get_the_author_meta('display_name', get_the_author_meta('ID'))),
                        esc_html(get_author_posts_url(get_the_author_meta('ID'))),
                        esc_attr($attributes['linkColor'])
                    );
                }

                /* Get the post date */
                if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
                    $blockspare_content_markup .= sprintf(
                        '<time style="color: %3$s" datetime="%1$s" class="blockspare-block-post-grid-date" itemprop="datePublished">%2$s</time>',
                        esc_attr(get_the_date('c', $post_id)),
                        esc_html(get_the_date('', $post_id)),
                        esc_attr($attributes['generalColor'])
                    );
                }

                /* Close the byline content */
                $blockspare_content_markup .= sprintf(
                    '</div>'
                );
            }

            /* Close the header content */
            $blockspare_content_markup .= sprintf(
                '</header>'
            );


            /* Get the excerpt */

            global $post;


            $excerpt = blockspare_post_excerpt($post_id, $post);

            if (!$excerpt) {
                $excerpt = null;
            }

            if (!empty($excerpt)) {
                $excerpt = explode(' ', $excerpt);
                $trim_to_length = (int)$attributes['excerptLength'] ? (int)$attributes['excerptLength'] : 55;
                if (count($excerpt) > $trim_to_length) {
                    $excerpt = implode(' ', array_slice($excerpt, 0, $trim_to_length)) . '...';
                } else {
                    $excerpt = implode(' ', $excerpt);
                }

            }


            if ((isset($attributes['displayPostExcerpt']) && $excerpt != null) || isset($attributes['displayPostLink'])) {


                /* Wrap the excerpt content */
                $blockspare_content_markup .= sprintf(
                    '<div class="blockspare-block-post-grid-excerpt" style="color: %1$s">',
                    esc_attr($attributes['generalColor'])

                );

                if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) {
                    $blockspare_content_markup .= sprintf(
                        '<div class="blockspare-block-post-grid-excerpt-content">%s</div>',
                        wp_kses_post($excerpt)
                    );
                }


                /* Get the read more link */
                if (isset($attributes['displayPostLink']) && $attributes['displayPostLink']) {
                    $blockspare_content_markup .= sprintf(
                        '<p><a style="color:%4$s;" class="blockspare-block-post-grid-more-link blockspare-text-link" href="%1$s" rel="bookmark">%2$s <span class="screen-reader-text">%3$s</span></a></p>',
                        esc_url(get_permalink($post_id)),
                        esc_html($attributes['readMoreText']),
                        esc_html($title),
                        esc_attr($attributes['linkColor'])
                    );
                }


            /* Close the excerpt content */
            $blockspare_content_markup .= sprintf(
                '</div>'
            );

            }

            /* Close the text content */
            $blockspare_content_markup .= sprintf(
                '</div>'
            );

            /* Close the post */
            $blockspare_content_markup .= "</article>\n";
        }

        /* Restore original post data */
        wp_reset_postdata();

        /* Build the block classes */
        $class = "wp-block-blockspare-block-blockspare-latest-posts blockspare-post-wrap align{$attributes['align']}";

        if (isset($attributes['className'])) {
            $class .= ' ' . $attributes['className'];
        }


        $list_layout_class = $attributes['design'];

        /* Layout orientation class */
        $grid_class = 'blockspare-latest-post-wrap blockspare-is-grid ' . $list_layout_class . ' ' . 'column-' . $attributes['columns'];


        /* Post grid section title */
        if (isset($attributes['displaySectionTitle']) && $attributes['displaySectionTitle'] && !empty($attributes['sectionTitle'])) {
            if (isset($attributes['sectionTitleTag'])) {
                $section_title_tag = $attributes['sectionTitleTag'];
            } else {
                $section_title_tag = 'h4';
            }

            $section_title = '<' . esc_attr($section_title_tag) . '>' . esc_html($attributes['sectionTitle']) . '</' . esc_attr($section_title_tag) . '>';
        } else {
            $section_title = null;
        }

        /* Post grid section tag */
        if (isset($attributes['sectionTag'])) {
            $section_tag = $attributes['sectionTag'];
        } else {
            $section_tag = 'section';
        }

        /* Output the post markup */
        $block_content = sprintf(
            '<%1$s class="%2$s" style="margin-top: %6$s;margin-bottom: %7$s;" ><div class="%4$s">%5$s</div></%1$s>',
            $section_tag,
            esc_attr($class),
            $section_title,
            esc_attr($grid_class),
            $blockspare_content_markup,
            esc_html($attributes['marginTop']) . 'px',
            esc_html($attributes['marginBottom']) . 'px'


        );
        return $block_content;
    }


}

/**
 * Registers the post grid block on server
 */
function blockspare_blocks_register_block_core_latest_posts_grid()
{

    /* Check if the register function exists */
    if (!function_exists('register_block_type')) {
        return;
    }
    ob_start();
    include BLOCKSPARE_PLUGIN_DIR . '/src/blocks/latest-posts-grid/block.json';

    $metadata = json_decode(ob_get_clean(), true);

    /* Block attributes */
    register_block_type(
        'blockspare/blockspare-latest-posts-grid',
        array(

            'attributes' => $metadata['attributes'],
            'render_callback' => 'blockspare_blocks_render_block_core_latest_posts_grid',
        )
    );
}

add_action('init', 'blockspare_blocks_register_block_core_latest_posts_grid');


if (!function_exists('blockspare_post_excerpt')) {
    /**
     * Get the post excerpt.
     *
     * @since 1.7
     */
    function blockspare_post_excerpt($object)
    {
        return blockspare_get_excerpt($object['id']);
    }
}

if (!function_exists('blockspare_get_excerpt')) {
    /**
     * Get the excerpt.
     *
     * @since 1.7
     */
    function blockspare_get_excerpt($post_id, $post = null)
    {
        $excerpt = apply_filters('the_excerpt', get_post_field('post_excerpt', $post_id, 'display'));
        if (!empty($excerpt)) {
            return $excerpt;
        }

        $max_excerpt = 100; // WP default is 55.

        if (!empty($post['post_content'])) {
            return apply_filters('the_excerpt', wp_trim_words($post['post_content'], $max_excerpt));
        }
        $post_content = apply_filters('the_content', get_post_field('post_content', $post_id));
        return apply_filters('the_excerpt', wp_trim_words($post_content, $max_excerpt));
    }
}

    


    
