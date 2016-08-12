</div>
<div class="sidebar">
	<ul class="mypages">
		<li><a target="_blank" class="my-a my-tqq" href="http://<?php echo dopt('d_tqq'); ?>"><span><strong>腾讯微博</strong></span>腾讯微博 &raquo;</a></li>
		<li><a target="_blank" class="my-a my-weibo" href="http://<?php echo dopt('d_weibo'); ?>"><span><strong>新浪微博</strong></span>新浪微博 &raquo;</a></li>
		<li><a target="_blank" class="my-a my-feed" href="http://<?php echo dopt('d_rss'); ?>"><span><strong>订阅本站</strong></span>订阅本站<em></em></a>
			<div class="mypages-dropdown">
				<a target="_blank" href="http://fusion.google.com/add?feedurl=http://<?php echo dopt('d_rss'); ?>">Google</a>
				<a target="_blank" href="http://www.xianguo.com/subscribe.php?url=http://<?php echo dopt('d_rss'); ?>">鲜果</a>
				<a target="_blank" href="http://www.zhuaxia.com/add_channel.php?url=http://<?php echo dopt('d_rss'); ?>">抓虾</a>
				<a target="_blank" href="http://mail.qq.com/cgi-bin/feed?u=http://<?php echo dopt('d_rss'); ?>">QQ邮箱</a>
				<a target="_blank" href="http://reader.youdao.com/b.do?keyfrom=http://<?php echo dopt('d_rss'); ?>">有道</a>
				<a target="_blank" href="http://add.my.yahoo.com/rss?url=http://<?php echo dopt('d_rss'); ?>">Yahoo</a>
			</div>
		</li>
		<li><a target="_blank" class="my-a my-theme" href="http://www.daqianduan.com/d5/"><span><strong>本站主题</strong></span>本站主题 &raquo;</a></li>
	</ul>
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sidebar')) : else : ?>
		<div class="widget_tips">
			请前往“后台 - 外观 - 小工具”进行主题边栏设置
		</div>
	<?php endif; ?>
</div>