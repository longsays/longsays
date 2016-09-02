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
		
			<p class="copyright" align="center">
			版权所有，保留一切权利！<b> &copy; 2011-<?php echo date('Y'); ?></b> | <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> | <a href="//www.longsays.com/sitemap.xml" target="_blank">谷歌地图</a> | <a href="//www.longsays.com/sitemap.html" target="_blank">百度地图</a> 
			<br />
			<a href="https://plus.google.com/108270394069994455147?rel=author" target="_blank" >Google+</a> | <a href="https://twitter.com/changsheng_duan" target="_blank">Twitter</a> 
			<br />
			Host By <a href="//u.longsays.com/aliyun" target="_blank" title="阿里云-全球领先的云计算服务平台">阿里云</a> and <a href="//u.longsays.com/qcloud" target="_blank" title="腾讯云 - 值得信赖">腾讯云</a> | Storage By <a href="//u.longsays.com/upyun" target="_blank" title="又拍云－新一代 CDN 服务提供商">又拍云</a> and <a href="//u.longsays.com/qiniu" target="_blank" title="七牛云官网 - 国内领先的企业级云服务商">七牛云</a>
			<br />
			<?php
				/**
				 * Fires before the Twenty Fifteen footer text for footer customization.
				 *
				 * @since Twenty Fifteen 1.0
				 */
				do_action( 'twentyfifteen_credits' );
			?> | <b><?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds. </b> 			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentyfifteen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentyfifteen' ), 'WordPress' ); ?></a>
			</p>
		<DIV align="center" style="font-size:10px"><b>大其心，容天下之物。虚其心，助天下之善。平其心，观天下之事。潜其心，明天下之理。定其心，应天下之变。</b></DIV>

		</div><!-- .site-info -->
		
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
