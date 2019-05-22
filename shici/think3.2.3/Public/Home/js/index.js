/**
 * 作者介绍展开
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function toggle(obj, type) {
	$(obj).parents('.author-desc').hide();

	var $_this = $(obj).parents('.author-desc').siblings('.author-desc');
	$_this.show();

	if(type == 2) {
		window.location.href = '#'+$_this.attr('id');
	}
	// document.getElementById('long_1').style.display = 'block';
    // document.getElementById('short_1').style.display = 'none';
}

$(function(){
	$(window).scroll(function() {
        var totop_timer = null;
	    if (totop_timer) {
	        totop_timer = null;
	    }
		totop_timer = setTimeout(function(){
	        var wsc_top = $(window).scrollTop();
	        if (wsc_top >= 500) {
	            $("#to_top").show();
	        }else{
	            $("#to_top").hide();
	        }
	    },200)
	});

	$(document).on('click', '#to_top', function(event) {
	    event.preventDefault();
	    // $(window).scrollTop(0);
	    $("html,body").animate({"scrollTop":0})
	});

	$(document).on('click','#menu_toggle', function(event){
		$("#menu_box").slideToggle("normal");
	})

	console.log($(window).width());

	// 古籍详情
	$(document).on('click','#yizhu_btn',function(e){
		var $_this = $(this);
		var val = $_this.data('val');
		var win_width = $(window).width();
		if(win_width <= 768) {
			$('#fanyi_quanping').text('原文');
			$('#book_detail_r').addClass('book-detail-fanyi-quanping');
			$('#book_detail_l').addClass('hidden');
		} else {
			if(val == 1) {
				// 开始显示出译文
				$_this.text('全屏');
				$_this.data('val',2);
				$('#book_detail_l').addClass('yizhu-l');
				$('#book_detail_r').addClass('yizhu-r');
			} else {
				// 隐藏译文
				$_this.text('译注');
				$_this.data('val',1);
				$('#book_detail_l').removeClass('yizhu-l');
				$('#book_detail_r').removeClass('yizhu-r');
			}
		}
	});

	$(document).on('click','#fanyi_quanping',function(e) {
		// 翻译全屏
		var $_this = $(this);
		var val = $_this.data('val');
		var win_width = $(window).width();
		if(win_width <= 768) {
			// $('#yizhu_btn').text('原文');
			$('#book_detail_r').removeClass('book-detail-fanyi-quanping');
			$('#book_detail_l').removeClass('hidden');
		} else {
			if(val == 1) {
				// 翻译全屏
				$_this.text('分屏');
				$_this.data('val',2);
				$('#book_detail_r').addClass('book-detail-fanyi-quanping');
				$('#book_detail_l').addClass('hidden');
			} else {
				$_this.text('全屏');
				$_this.data('val',1);
				$('#book_detail_r').removeClass('book-detail-fanyi-quanping');
				$('#book_detail_l').removeClass('hidden');
			}
		}
	})

	// 书籍详情篇章详情
})

