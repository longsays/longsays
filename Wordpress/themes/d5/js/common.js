(function($) {		

	//title
	$('.excerpt-tit a').click(function() {
		myloadoriginal = this.text;
		$(this).text('文章正在加载中...');
		var myload = this;
		setTimeout(function() {
			$(myload).text(myloadoriginal);
		},2011);
	});
	
	//dshare 
	dshare();
	function dshare() {
		var thelink = encodeURIComponent(document.location), 
			thetitle =  encodeURIComponent(document.title.substring(0,60)), 
			windowName = '分享到',
			param = getParamsOfShareWindow(600, 560),
			
			ds_tqq = 'http://v.t.qq.com/share/share.php?title=' + thetitle + '&url=' + thelink + '&site=',
			ds_qzone = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + thelink + '&title=',
			ds_tsina = 'http://v.t.sina.com.cn/share/share.php?url=' + thelink + '&title=' + thetitle,
			ds_douban = 'http://www.douban.com/recommend/?url=' + thelink + '&title=' + thetitle,
			ds_renren = 'http://share.renren.com/share/buttonshare?link=' + thelink + '&title=' + thetitle,
			ds_kaixin = 'http://www.kaixin001.com/repaste/share.php?rurl=' + thelink + '&rcontent=' + thelink + '&rtitle=' + thetitle,
			ds_facebook = 'http://facebook.com/share.php?u=' + thelink + '&t=' + thetitle,
			ds_twitter = 'http://twitter.com/share?url=' + thelink + '&text=' + thetitle;
			
	 	$('.dshare').each(function() {
			$(this).attr('title',windowName + $(this).text());
			$(this).click(function() {
				var httpUrl = eval($(this).attr('class').substring($(this).attr('class').lastIndexOf('ds_')));
				window.open(httpUrl, windowName, param);
			});
		});

		function getParamsOfShareWindow(width, height) {
			return ['toolbar=0,status=0,resizable=1,width=' + width + ',height=' + height + ',left=',(screen.width-width)/2,',top=',(screen.height-height)/2].join('');
		}
	}
	

})(jQuery);