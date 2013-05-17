$(function(){
	$('.y_list_cont>table>tbody>tr').hover(function(){
		$(this).css({background:'#e1f0fa'});
	},function(){
		$(this).css({background:'#fff'});
	});

	// $('.y_nav').find('ul>li').click(function(){
	// 	$(this).addClass('selected').siblings('.y_nav>ul>li').removeClass('selected');
	// 	var _select = $(this).index();
	// 	if(_select==0){
	// 		$('.y_nav>.arrow').css({left:'150px'});
	// 	}
	// 	else if(_select==1){
	// 		$('.y_nav>.arrow').css({left:'375px'});
	// 	}
	// 	else if(_select==2){
	// 		$('.y_nav>.arrow').css({left:'600px'});
	// 	}
	// 	else if(_select==3){
	// 		$('.y_nav>.arrow').css({left:'825px'});
	// 	}
	// 	else if(_select==4){
	// 		$('.y_nav>.arrow').css({left:'1050px'});
	// 	}
	// });

	$('.select>p').click(function(e){
		$(this).next('ul').show();	
		e.stopPropagation(); //阻止事件冒泡，否则事件会冒泡到下面的文档点击事件 	
	});
	$('.select>ul>li').click(function(){
		var text = $(this).find('a').text();
		$(this).parent('ul').prev('p').text(text);
		$('.select>ul').hide();
	});
	//点击空白处隐藏弹出层
	 $(document).bind("click",function(e){
		var target  = $(e.target);
		if(target.closest(".select>ul").length == 0){
			$(".select>ul").hide();
		}
	 });


});