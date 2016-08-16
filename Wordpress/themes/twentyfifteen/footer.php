<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
		
			<p class="copyright">
			版权所有，保留一切权利！ &copy; 2011-<?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>　Host By <a href="//u.longsays.com/aliyun" target="_blank" title="阿里云-全球领先的云计算服务平台">阿里云</a> and <a href="//u.longsays.com/qcloud" target="_blank" title="腾讯云 - 值得信赖">腾讯云</a> | Storage By <a href="//u.longsays.com/upyun" target="_blank" title="又拍云－新一代 CDN 服务提供商">又拍云</a> and <a href="//u.longsays.com/qiniu" target="_blank" title="七牛云官网 - 国内领先的企业级云服务商">七牛云</a>
			<br />
			<?php
				/**
				 * Fires before the Twenty Fifteen footer text for footer customization.
				 *
				 * @since Twenty Fifteen 1.0
				 */
				do_action( 'twentyfifteen_credits' );
			?> | <a href="https://plus.google.com/108270394069994455147?rel=author" target="_blank" >Google+</a> | <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.  			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentyfifteen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentyfifteen' ), 'WordPress' ); ?></a>
			</p>

		</div><!-- .site-info -->
		
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
