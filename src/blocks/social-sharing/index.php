<?php
/**
 * Server-side rendering for the sharing block
 *
 * @since   1.1.2
 * @package Blockspare
 */

/**
 * Register the block on the server
 */
function blockspare_register_social_sharing_block()
{

    if (!function_exists('register_block_type')) {
        return;
    }
    ob_start();
    include BLOCKSPARE_PLUGIN_DIR . '/src/blocks/social-sharing/block.json';

    $metadata = json_decode(ob_get_clean(), true);

    register_block_type(
        'blockspare-blocks/blockspare-social-sharing',

        array(
            'style' => 'blockspare-style-css',
            'attributes' => $metadata['attributes'],
            'render_callback' => 'blockspare_render_social_sharing_block',
        )
    );
}

add_action('init', 'blockspare_register_social_sharing_block');


/**
 * Add the pop-up share window to the footer
 */
function blockspare_social_sharing_block_icon_footer_script()
{

    if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
        return;
    }
    ?>
    <script type="text/javascript">
        function blockspareBlocksShare(url, title, w, h) {
            var left = (window.innerWidth / 2) - (w / 2);
            var top = (window.innerHeight / 2) - (h / 2);
            return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=600, height=600, top=' + top + ', left=' + left);
        }
    </script>
    <?php
}

add_action('wp_footer', 'blockspare_social_sharing_block_icon_footer_script');

/**
 * Render the sharing links
 *
 * @param array $attributes The block attributes.
 *
 * @return string The block HTML.
 */
function blockspare_render_social_sharing_block($attributes)
{

    global $post;

    if (has_post_thumbnail()) {
        $thumbnail_id = get_post_thumbnail_id($post->ID);
        $thumbnail = $thumbnail_id ? current(wp_get_attachment_image_src($thumbnail_id, 'large', true)) : '';
    } else {
        $thumbnail = null;
    }

    $icon_style = '';

    if ($attributes['iconColorOption'] != 'blockspare-default-official-color') {

        $icon_style = "color:" . $attributes['customfontColorOption'] . ';';
        $icon_style .= " background-color:" . $attributes['custombackgroundColorOption'] . ';';

    }


    $is_amp_endpoint = function_exists('is_amp_endpoint') && is_amp_endpoint();

    $share_url = '';


    if (isset($attributes['facebook']) && $attributes['facebook']) {
        $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '&title=' . get_the_title() . '';
        $share_url .= blockspare_render_social_sharing_block_item($attributes['facebookTitle'], $facebook_url, 'blockspare-share-facebook', 'fab fa-facebook-f', $icon_style, $is_amp_endpoint);
    }

    if (isset($attributes['twitter']) && $attributes['twitter']) {
        $twitter_url = 'http://twitter.com/share?text=' . get_the_title() . '&url=' . get_the_permalink() . '';
        $share_url .= blockspare_render_social_sharing_block_item($attributes['twitterTitle'], $twitter_url, 'blockspare-share-twitter', 'fab fa-twitter', $icon_style, $is_amp_endpoint);
    }


    if (isset($attributes['pinterest']) && $attributes['pinterest']) {

        $pinterest_url = 'https://pinterest.com/pin/create/button/?&url=' . get_the_permalink() . '&description=' . get_the_title() . '&media=' . esc_url($thumbnail) . '';
        $share_url .=  blockspare_render_social_sharing_block_item($attributes['pinterestTitle'], $pinterest_url, 'blockspare-share-pinterest', 'fab fa-pinterest-p', $icon_style, $is_amp_endpoint);
    }

    if (isset($attributes['linkedin']) && $attributes['linkedin']) {

        $linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink() . '&title=' . get_the_title() . '';
        $share_url .= blockspare_render_social_sharing_block_item($attributes['linkedinTitle'], $linkedin_url, 'blockspare-share-linkedin', 'fab fa-linkedin-in', $icon_style, $is_amp_endpoint);
    }

    if (isset($attributes['reddit']) && $attributes['reddit']) {


        $reddit_url = 'https://www.reddit.com/submit?url=' . get_the_permalink() . '';
        $share_url .= blockspare_render_social_sharing_block_item($attributes['redditTitle'], $reddit_url, 'blockspare-share-reddit', 'fab fa-reddit-alien', $icon_style, $is_amp_endpoint);
    }

    if (isset($attributes['email']) && $attributes['email']) {

        $email_url = 'mailto:?subject=' . get_the_title() . '&body=' . get_the_title() . '&mdash;' . get_the_permalink() . '';
        $share_url .= blockspare_render_social_sharing_block_item($attributes['emailTitle'], $email_url, 'blockspare-share-email', 'fas fa-envelope', $icon_style, false);
    }

    $block_content = sprintf(
        '
<div style="text-align: %7$s" >
			<ul class="blockspare-social-sharing %2$s %3$s %4$s %5$s %6$s">%1$s</ul>
			</div>
		',
        $share_url,
        isset($attributes['iconColorOption']) ? $attributes['iconColorOption'] : null,
        isset($attributes['buttonOptions']) ? $attributes['buttonOptions'] : null,
        isset($attributes['buttonShapes']) ? $attributes['buttonShapes'] : null,
        isset($attributes['buttonSizes']) ? $attributes['buttonSizes'] : null,
        isset($attributes['buttonFills']) ? $attributes['buttonFills'] : null,
        isset($attributes['sectionAlignment']) ? $attributes['sectionAlignment'] : null


    );

    return $block_content;
}

function blockspare_render_social_sharing_block_item($attribute_title, $attribute_url, $item_class, $icon_class, $icon_style, $is_amp_endpoint)
{


    $share_url = '';

    if (!$is_amp_endpoint) {
        $share_url .= sprintf(
            '<li>
				<a
					href="%1$s"
					class="%4$s"
					title="%2$s" 
					style="%3$s">
					<i class="%5$s"></i> <span class="blockspare-social-text">%2$s</span>
				</a>
			</li>',
            $attribute_url,
            esc_html__($attribute_title),
            esc_attr__($icon_style),
            esc_attr__($item_class),
            esc_attr__($icon_class)

        );
    } else {

        $href_format = sprintf('href="javascript:void(0)" onClick="javascript:blockspareBlocksShare(\'%1$s\', \'%2$s\', \'600\', \'600\')"', esc_url($attribute_url), esc_html__($attribute_title));

        if ($is_amp_endpoint) {
            $href_format = sprintf('href="%1$s"', esc_url($attribute_url));
        }
        $share_url .= sprintf(
            '<li>
				<a
					%1$s
					class="%4$s"
					title="%2$s" 
					style="%3$s">
					<i class="%5$s"></i> <span class="blockspare-social-text">%2$s</span>
				</a>
			</li>',
            $href_format,
            esc_html__($attribute_title),
            esc_attr__($icon_style),
            esc_attr__($item_class),
            esc_attr__($icon_class)

        );
    }


    return $share_url;
}
