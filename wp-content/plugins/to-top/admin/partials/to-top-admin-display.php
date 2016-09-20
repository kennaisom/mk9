<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       catchthemes.com
 * @since      1.0
 *
 * @package    To_Top
 * @subpackage To_Top/admin/partials
 */
?>

<!-- For Facebook -->
<div id="fb-root"></div>

<div id="to-top" class="wrap">
    <h1 class="title"><?php esc_html_e( 'To Top Settings', 'to-top' ); ?></h1>
    <?php if( isset($_GET['settings-updated']) ) { ?>
        <div id="message" class="notice updated fade">
            <p><strong><?php esc_html_e( 'Plugin Options Saved.', 'to-top' ) ?></strong></p>
        </div>
    <?php } ?>

	<div id="plugin-option-header">
        <div id="plugin-social">
            <ul>
                <li class="widget-fb">
                    <div data-show-faces="false" data-width="80" data-layout="button_count" data-send="false" data-href="<?php echo esc_url( 'https://facebook.com/catchthemes' ); ?>" class="fb-like"></div>
                </li>

                <li class="widget-tw">
                    <a data-dnt="true" data-show-screen-name="true" data-show-count="true" class="twitter-follow-button" href="<?php echo esc_url( 'https://twitter.com/catchthemes' ); ?>"> <?php esc_html_e( 'Follow @catchthemes', 'to-top' ) ?></a>
                </li>
            </ul>
        </div><!-- #plugin-social -->

        <div id="plugin-option-title">
            <h2 class="logo">
                <a href="<?php echo esc_url( __( 'https://catchthemes.com/', 'to-top' ) ); ?>" title="<?php esc_attr_e( 'Catch Themes', 'to-top' ); ?>" target="_blank">

                <img src="https://catchthemes.com/wp-content/themes/catchthemes/images/logo.png" alt="<?php esc_html_e( 'Catch Themes', 'to-top' ); ?>" />
            </a>
            </h2>
        </div><!-- #plugin-option-title -->

        <div id="plugin-support">
            <ul>
                <li>
                    <a class="button" href="<?php echo esc_url( __('https://catchthemes.com/forum/to-top/', 'to-top' )); ?>" title="<?php esc_attr_e('Support Forum', 'to-top' ); ?>" target="_blank"><?php printf(__('Support Forum', 'to-top' )); ?></a>
                </li>
                <li>
                    <a class="button" href="<?php echo esc_url( __('https://catchthemes.com/wp-plugins/to-top/', 'to-top' )); ?>" title="<?php esc_attr_e('Plugin Details', 'to-top' ); ?>" target="_blank"><?php printf(__('Plugin Details', 'to-top' ) ); ?></a>
                </li>
                <li>
                    <a class="button" href="<?php echo esc_url( __('https://www.facebook.com/catchthemes/', 'to-top' ) ); ?>" title="<?php esc_attr_e( 'Like Catch Themes on Facebook', 'to-top' ); ?>" target="_blank"><?php printf(__('Facebook', 'to-top' )); ?></a>
                </li>
                <li>
                    <a class="button" href="<?php echo esc_url( __('https://twitter.com/catchthemes/', 'to-top' ) ); ?>" title="<?php esc_attr_e( 'Follow Catch Themes on Twitter', 'to-top' ); ?>" target="_blank"><?php printf( __('Twitter', 'to-top' ) ); ?></a>
                </li>
                <li>
                    <a class="button" href="<?php echo esc_url( __('https://wordpress.org/support/view/plugin-reviews/to-top', 'to-top' ) ); ?>" title="<?php esc_attr_e('Rate us 5 Star on WordPress', 'to-top' ); ?>" target="_blank"><?php printf( __('5 Star Rating', 'to-top' ) ); ?></a>
                </li>
            </ul>
        </div><!-- #plugin-support -->
    </div><!-- #plugin-option-header -->

    <div id="customizer-message" class="update-nag">
        <?php
            $customizer_link = add_query_arg( array(
                    'autofocus[panel]' => 'to_top_panel',
                ),
                admin_url('customize.php')
            );

            $settings_link = '<a href="' . esc_url( $customizer_link ) . '">' .esc_html__( 'Customizer', 'to-top' ) . '</a>';
        ?>
        <p><strong><?php esc_html_e( 'Want Live Preview? Change the settings from ', 'to-top' ); echo $settings_link; ?></strong></p>
    </div><!-- #message -->

    <div id="to_top_main">
        <form method="post" action="options.php">
            <?php settings_fields( 'to-top-group' ); ?>
            <?php $settings = to_top_get_options( 'to_top_options' ); ?>
            <div class="option-container">
                <h3 class="option-toggle option-active"><a href="#"><?php esc_html_e( 'Basic Settings', 'to-top' ); ?></a></h3>
                <div class="option-content inside open">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Scroll Offset (px)', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input min="1" type="number" id="to_top_options[scroll_offset]" name="to_top_options[scroll_offset]" value="'. absint( $settings['scroll_offset'] ) .'"/>px';

                                        echo '<p class="description">'. esc_html__( 'Number of pixels to be scrolled before the button appears', 'to-top' ) .'</p>';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Icon Opacity (%)', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input min="1" max="100" type="number" id="to_top_options[icon_opacity]" name="to_top_options[icon_opacity]" value="'. absint( $settings['icon_opacity'] ) .'"/>%';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Style', 'to-top' ); ?></th>

                                <td>
                                    <?php
                                        echo '<select id="to_top_options_style" name="to_top_options[style]">';
                                            echo '<option value="icon"' . selected( $settings['style'], 'icon', false) . '>'. esc_html__( 'Icon Using Dashicons', 'to-top') .'</option>';
                                            echo '<option value="genericon-icon"' . selected( $settings['style'], 'genericon-icon', false) . '>'. esc_html__( 'Icon Using Genericons', 'to-top') .'</option>';
                                            echo '<option value="font-awesome-icon"' . selected( $settings['style'], 'font-awesome-icon', false) . '>'. esc_html__( 'Icon Using Font Awesome Icons', 'to-top') .'</option>';
                                            echo '<option value="image"' . selected( $settings['style'], 'image', false) . '>'. esc_html__( 'Image', 'to-top') .'</option>';
                                        echo '</select>';
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php submit_button( esc_html__( 'Save Changes', 'top-up' ) ); ?>
                </div>

                <div class="to_top_icon_settings">
                    <h3 class="option-toggle "><a href="#"><?php esc_html_e( 'Icon Settings', 'to-top' ); ?></a></h3>
                    <div class="option-content inside open">
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Select Icon Type', 'to-top' ); ?></th>

                                    <td>
                                        <?php
                                            echo '<input type="radio" id="to_top_options_icon_type_1" name="to_top_options[icon_type]" value="dashicons-arrow-up"' . checked( 'dashicons-arrow-up', $settings['icon_type'], false ) . '/>';
                                            echo '<label class="dashicon_label" for="to_top_options_icon_type_1"><span class="dashicon_to_top_admin dashicons dashicons-arrow-up"></span></label>';

                                            echo '<input type="radio" id="to_top_options_icon_type_2" name="to_top_options[icon_type]" value="dashicons-arrow-up-alt"' . checked( 'dashicons-arrow-up-alt', $settings['icon_type'], false ) . '/>';
                                            echo '<label class="dashicon_label" for="to_top_options_icon_type_2"><span class="dashicon_to_top_admin dashicons dashicons-arrow-up-alt"></span></label>';

                                            echo '<input type="radio" id="to_top_options_icon_type_3" name="to_top_options[icon_type]" value="dashicons-arrow-up-alt2"' . checked( 'dashicons-arrow-up-alt2', $settings['icon_type'], false ) . '/>';
                                            echo '<label class="dashicon_label" for="to_top_options_icon_type_3"><span class="dashicon_to_top_admin dashicons dashicons-arrow-up-alt2"></span></label>';
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Icon Color', 'to-top' ); ?></th>

                                    <td>
                                        <?php
                                            echo '<input type="text" class="to_top_icon_color" name="to_top_options[icon_color]" value="'. sanitize_text_field( $settings['icon_color'] ) .'"/>';
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Icon Background Color', 'to-top' ); ?></th>

                                    <td>
                                        <?php
                                            echo '<input type="text" class="to_top_icon_bg_color" name="to_top_options[icon_bg_color]" value="'. sanitize_text_field( $settings['icon_bg_color'] ) .'"/>';
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Icon Size (px)', 'to-top' ); ?></th>
                                    <td>
                                        <?php
                                            echo '<input min="0" type="number" id="to_top_icon_size" name="to_top_options[icon_size]" value="'. absint( $settings['icon_size'] ) .'"/>px';
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Border Radius (%)', 'to-top' ); ?></th>
                                    <td>
                                        <?php
                                            echo '<input min="0" max="50" type="number" id="to_top_border_radius" name="to_top_options[border_radius]" value="'. absint( $settings['border_radius'] ) .'"/>%';

                                            echo '<p class="description">'. esc_html__( '0 will make the icon background square, 50 will make it a circle', 'to-top' ) .'</p>';
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php submit_button( esc_html__( 'Save Changes', 'top-up' ) ); ?>
                    </div>
                </div>

                <div class="to_top_image_settings">
                    <h3 class="option-toggle"><a href="#"><?php esc_html_e( 'Image Settings', 'to-top' ); ?></a></h3>
                    <div class="option-content inside open">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Image', 'to-top' ); ?></th>
                                <td>
                                    <input class="upload-url" size="65" type="text" name="to_top_options[image]" value="<?php echo esc_url( $settings['image'] ); ?>" />
                                    <input ref="<?php esc_attr_e( 'Insert Image','to-top' );?>" class="to_top_upload_image button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Change Image','to-top' );?>" />
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Image Width (px)', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input min="0" max="200" type="number" size="65" id="to_top_options[image_width]" name="to_top_options[image_width]" value="'. absint( $settings['image_width'] ) .'"/>px';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Image Alt', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input type="text" size="65" id="to_top_options[image_alt]" name="to_top_options[image_alt]" value="'. sanitize_text_field( $settings['image_alt'] ) .'"/>';
                                    ?>
                                </td>
                            </tr>
                         </tbody>
                    </table>
                    <?php submit_button( esc_html__( 'Save Changes', 'top-up' ) ); ?>
                    </div>
                </div>

                <h3 class="option-toggle option-active"><a href="#"><?php esc_html_e( 'Advanced Settings', 'to-top' ); ?></a></h3>
                <div class="option-content inside">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Location', 'to-top' ); ?></th>

                                <td>
                                    <?php
                                        echo '<select id="to_top_options[location]" name="to_top_options[location]">';
                                            echo '<option value="bottom-right"' . selected( $settings['location'], 'bottom-right', false) . '>'. esc_html__( 'Bottom Right', 'to-top') .'</option>';
                                            echo '<option value="bottom-left"' . selected( $settings['location'], 'bottom-left', false) . '>'. esc_html__( 'Bottom Left', 'to-top') .'</option>';
                                            echo '<option value="top-right"' . selected( $settings['location'], 'top-right', false) . '>'. esc_html__( 'Top Right', 'to-top') .'</option>';
                                            echo '<option value="top-left"' . selected( $settings['location'], 'top-left', false) . '>'. esc_html__( 'Top Left', 'to-top') .'</option>';
                                        echo '</select>';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Margin X (px)', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input min="1" type="number" id="to_top_options[margin_x]" name="to_top_options[margin_x]" value="'. absint( $settings['margin_x'] ) .'"/>px';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Margin Y (px)', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input min="1" type="number" id="to_top_options[margin_y]" name="to_top_options[margin_y]" value="'. absint( $settings['margin_y'] ) .'"/>px';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Show on WP-ADMIN?', 'to-top' ); ?></th>

                                <td>
                                    <?php
                                        echo '<input name="to_top_options[show_on_admin]" id="to_top_options[show_on_admin]" type="checkbox" value="1" class="to_top_options[show_on_admin]" ' . checked( 1, $settings['show_on_admin'], false ) . ' />' . esc_html__( 'Check to Enable','to-top' );
                                        echo '<p class="description">' . esc_html__( 'Button will be shown on admin section', 'to-top' ) .'</p>';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Enable Auto Hide', 'to-top' ); ?></th>

                                <td>
                                    <?php
                                        echo '<input name="to_top_options[enable_autohide]" id="to_top_options[enable_autohide]" type="checkbox" value="1" class="to_top_options[enable_autohide]" ' . checked( 1, $settings['enable_autohide'], false ) . ' />' . esc_html__( 'Check to Enable','to-top' );
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Auto Hide Time (secs)', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input min="1" type="number" id="to_top_options[autohide_time]" name="to_top_options[autohide_time]" value="'. absint( $settings['autohide_time'] ) .'"/>sec(s)';

                                        echo '<p class="description">'. esc_html__( 'Button will be auto hidden after this duration in seconds, if enabled', 'to-top' ) .'</p>';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Hide on Small Devices?', 'to-top' ); ?></th>

                                <td>
                                    <?php
                                        echo '<input name="to_top_options[enable_hide_small_device]" id="to_top_options[enable_hide_small_device]" type="checkbox" value="1" class="to_top_options[enable_hide_small_device]" ' . checked( 1, $settings['enable_hide_small_device'], false ) . ' />' . esc_html__( 'Check to Enable','to-top' );
                                        echo '<p class="description">' . esc_html__( 'Button will be hidden on small devices when the width below matches', 'to-top' ) .'</p>';
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php esc_html_e( 'Small Device Max Width (px)', 'to-top' ); ?></th>
                                <td>
                                    <?php
                                        echo '<input min="1" type="number" id="to_top_options[small_device_max_width]" name="to_top_options[small_device_max_width]" value="'. absint( $settings['small_device_max_width'] ) .'"/>px';

                                        echo '<p class="description">'. esc_html__( 'Button will be hidden on devices with lesser or equal width', 'to-top' ) .'</p>';
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php submit_button( esc_html__( 'Save Changes', 'top-up' ) ); ?>
                </div>

                <h3 class="option-toggle option-active"><a href="#"><?php esc_html_e( 'Reset Settings', 'to-top' ); ?></a></h3>
                <div class="option-content inside">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Reset All Settings', 'to-top' ); ?></th>

                                <td>
                                    <?php
                                        echo '<input name="to_top_options[reset]" id="to_top_options[reset]" type="checkbox" value="1" class="to_top_options[reset]" ' . checked( 1, $settings['reset'], false ) . ' />' . esc_html__( 'Check to Reset All Settings','to-top' );
                                        echo '<p class="description">' . esc_html__( 'Caution: All data will be lost', 'to-top' ) .'</p>';
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php submit_button( esc_html__( 'Save Changes', 'top-up' ) ); ?>
                </div>
            </div>
        </form>
    </div><!-- #social -->
</div><!-- .wrap -->
