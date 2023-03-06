<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

						// Widgets area inside page content
						hampton_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					hampton_create_widgets_area('widgets_below_page');

					$hampton_body_style = hampton_get_theme_option('body_style');
					if ($hampton_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			$hampton_footer_scheme =  hampton_is_inherit(hampton_get_theme_option('footer_scheme')) ? hampton_get_theme_option('color_scheme') : hampton_get_theme_option('footer_scheme');
			?>
			
			<footer class="site_footer_wrap scheme_<?php echo esc_attr($hampton_footer_scheme); ?>">
				<?php
				// Footer sidebar
				$hampton_footer_name = hampton_get_theme_option('footer_widgets');
				$hampton_footer_present = !hampton_is_off($hampton_footer_name) && is_active_sidebar($hampton_footer_name);
				if ($hampton_footer_present) { 
					hampton_storage_set('current_sidebar', 'footer');
					$hampton_footer_wide = hampton_get_theme_option('footer_wide');
					ob_start();
					do_action( 'hampton_action_before_sidebar' );
					if ( is_active_sidebar( $hampton_footer_name ) ) {
						dynamic_sidebar( $hampton_footer_name );
					}
					do_action( 'hampton_action_after_sidebar' );
					$hampton_out = ob_get_contents();
					ob_end_clean();
					$hampton_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $hampton_out);
					$hampton_need_columns = true;
					if ($hampton_need_columns) {
						$hampton_columns = max(0, (int) hampton_get_theme_option('footer_columns'));
						if ($hampton_columns == 0) $hampton_columns = min(6, max(1, substr_count($hampton_out, '<aside ')));
						if ($hampton_columns > 1)
							$hampton_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($hampton_columns).' widget ', $hampton_out);
						else
							$hampton_need_columns = false;
					}
					?>
					<div class="footer_wrap widget_area<?php echo !empty($hampton_footer_wide) ? ' footer_fullwidth' : ''; ?>">
						<div class="footer_wrap_inner widget_area_inner">
							<?php 
							if (!$hampton_footer_wide) { 
								?><div class="content_wrap"><?php
							}
							if ($hampton_need_columns) {
								?><div class="columns_wrap"><?php
							}
							hampton_show_layout($hampton_out);
							if ($hampton_need_columns) {
								?></div><!-- /.columns_wrap --><?php
							}
							if (!$hampton_footer_wide) {
								?></div><!-- /.content_wrap --><?php
							}
							?>
						</div><!-- /.footer_wrap_inner -->
					</div><!-- /.footer_wrap -->
				<?php
				}
	
				// Logo
				if (hampton_is_on(hampton_get_theme_option('logo_in_footer'))) {
					$hampton_logo_image = '';
					if (hampton_get_retina_multiplier(2) > 1)
						$hampton_logo_image = hampton_get_theme_option( 'logo_footer_retina' );
					if (empty($hampton_logo_image)) 
						$hampton_logo_image = hampton_get_theme_option( 'logo_footer' );
					$hampton_logo_text   = get_bloginfo( 'name' );
					if (!empty($hampton_logo_image) || !empty($hampton_logo_text)) {
						?>
						<div class="logo_footer_wrap">
							<div class="logo_footer_wrap_inner">
								<?php
								if (!empty($hampton_logo_image)) {
									$hampton_attr = hampton_getimagesize($hampton_logo_image);
                                    $alt = basename($hampton_logo_image);
                                    $alt = substr($alt,0,strlen($alt) - 4);
									echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($hampton_logo_image).'" class="logo_footer_image" alt="'.esc_attr($alt).'"'.(!empty($hampton_attr[3]) ? sprintf(' %s', $hampton_attr[3]) : '').'></a>' ;
								} else if (!empty($hampton_logo_text)) {
									echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($hampton_logo_text) . '</a></h1>';
								}
								?>
							</div>
						</div>
						<?php
					}
				}

				// Socials
				if ( hampton_is_on(hampton_get_theme_option('socials_in_footer')) && ($hampton_output = hampton_get_socials_links()) != '') {
					?>
					<div class="socials_footer_wrap socials_wrap">
						<div class="socials_footer_wrap_inner">
							<?php hampton_show_layout($hampton_output); ?>
						</div>
					</div>
					<?php
				}
				
				// Footer menu
				$hampton_menu_footer = hampton_get_nav_menu('menu_footer');
				if (!empty($hampton_menu_footer)) {
					?>
					<div class="menu_footer_wrap">
						<div class="menu_footer_wrap_inner">
							<?php hampton_show_layout($hampton_menu_footer); ?>
						</div>
					</div>
					<?php
				}
				
				// Copyright area
				$hampton_copyright_scheme = hampton_is_inherit(hampton_get_theme_option('copyright_scheme')) ? $hampton_footer_scheme : hampton_get_theme_option('copyright_scheme');
				?> 
				<div class="copyright_wrap scheme_<?php echo esc_attr($hampton_copyright_scheme); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<div class="copyright_text"><?php
								$hampton_copyright = hampton_prepare_macros(hampton_get_theme_option('copyright'));
								if (!empty($hampton_copyright)) {
									if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $hampton_copyright, $hampton_matches)) {
										$hampton_copyright = str_replace($hampton_matches[1], date(str_replace(array('{', '}'), '', $hampton_matches[1])), $hampton_copyright);
                                        $hampton_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $hampton_copyright);
									}
									hampton_show_layout(nl2br($hampton_copyright));
								}
							?></div>
						</div>
					</div>
				</div>

			</footer><!-- /.site_footer_wrap -->
			
		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (hampton_is_on(hampton_get_theme_option('debug_mode')) && file_exists(hampton_get_file_dir('images/makeup.jpg'))) { ?>
		<img alt="makeup" src="<?php echo esc_url(hampton_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>