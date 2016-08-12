$(function(){
	//导航切换
	$('.d_mainbox:eq(0)').show();
	$('.d_tab a').each(function(i) {
		$(this).click(function(){
			$(this).addClass('d_tab_on').siblings().removeClass('d_tab_on');
			$($('.d_mainbox')[i]).show().siblings('.d_mainbox').hide();
		})
	});

	var avatar_txt = '<div style="padding-top:10px;color:#390;">请确保网站根目录有“avatar”文件夹，并设置权限为777，地址：http://你的网站/avatar</div>';
	if( $('#d_avatar_b')[0].checked == true ){
		$('#d_avatar_b').parent().parent().append(avatar_txt);
	}
	$('#d_avatar_b').parent().click(function(){
		if( $('#d_avatar_b')[0].checked == true ){
			
			$('#d_avatar_b').parent().parent().append(avatar_txt);
			
		}else{
			$('#d_avatar_b').parent().parent().find('div').remove();
		}
	})
	
	//广告系统实时预览
	$('.d_mainbox:last .d_tarea').each(function(i) {
		$(this).bind('keyup',function(){
			$(this).next().html( $(this).val() );
		}).bind('change',function(){
			$(this).next().html( $(this).val() );
		}).bind('click',function(){
			$(this).next().html( $(this).val() );
			if( $(this).next().attr('class') != 'd_adviewcon' ){
				$(this).after('<div class="d_adviewcon">' + $(this).val() + '</div>');
			}else{
				$(this).next().slideDown();
			}
		})
		
	});
	
})