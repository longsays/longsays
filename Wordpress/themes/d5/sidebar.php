</div>
<div class="sidebar">
	<ul class="mypages">
		
		<li><a target="_blank" rel="nofollow" class="my-a my-feed" href="http://<?php echo dopt('d_rss'); ?>"><span><strong>订阅本站</strong></span>订阅本站<em></em></a>
			<div class="mypages-dropdown">
				<a target="_blank" rel="nofollow" href="http://fusion.google.com/add?feedurl=http://<?php echo dopt('d_rss'); ?>">Google</a>
				<a target="_blank" rel="nofollow" href="http://www.xianguo.com/subscribe.php?url=http://<?php echo dopt('d_rss'); ?>">鲜果</a>
				<a target="_blank" rel="nofollow" href="http://www.zhuaxia.com/add_channel.php?url=http://<?php echo dopt('d_rss'); ?>">抓虾</a>
				<a target="_blank" rel="nofollow" href="http://mail.qq.com/cgi-bin/feed?u=http://<?php echo dopt('d_rss'); ?>">QQ邮箱</a>
				<a target="_blank" rel="nofollow" href="http://reader.youdao.com/b.do?keyfrom=http://<?php echo dopt('d_rss'); ?>">有道</a>
				<a target="_blank" rel="nofollow" href="http://add.my.yahoo.com/rss?url=http://<?php echo dopt('d_rss'); ?>">Yahoo</a>
			</div>
		</li>
		<li><a target="_blank" class="my-a my-theme" href="http://www.longsays.com/archive"><span><strong>本站存档</strong></span>本站存档 &raquo;</a></li>
<li> <a rel="nofollow" target="_blank" href='http://me.alipay.com/longsays'> <img height="25" width="106" src='http://bcs.duapp.com/duling/%E8%B5%9E%E5%8A%A9.png' alt="支付宝收款" /> </a></li>
<li> <a rel="nofollow" target="_blank" href='http://goo.gl/qHsEU'> <img hspace="8" class="my-a" height="25" width="106" src='http://cdn.longsays.com/A4C6F9F6D1C61CC882D19A9E8BC4CB39C1D8EC4A.png' alt="自由开放的世界依赖于自由开放的网络" /> </a></li>
	</ul>
	
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sidebar')) : else : ?>
		<div class="widget_tips">
			请前往“后台 - 外观 - 小工具”进行主题边栏设置
		</div>
	<?php endif; ?>
</div>