</div>

<div class="footer">
	<div class="inner">
		<p class="manage">
			<?php wp_loginout(); ?><?php if( dopt('d_track_b')!='' ) echo ' | '.dopt('d_track'); ?>
		</p>
		<p class="copyright">
			版权所有，保留一切权利！ &copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>　Theme D5 By <a href="http://www.daqianduan.com" target="_blank">大前端</a>
		</p>
	</div>
</div>

<script src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script> 
<script src="<?php bloginfo('template_url'); ?>/js/common.js"></script>
<?php if(is_single() || is_page()){ ?>
<script src="<?php bloginfo('template_url'); ?>/js/post.js"></script>
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>