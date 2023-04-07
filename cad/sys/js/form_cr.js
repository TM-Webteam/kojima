/**
 *
 */
$(function() {

	$(document).on('click', '.tag_style label', function(){
		if ($(this).hasClass("disabled")){
			return false;
		}
		var id = $(this).attr('for');
		var input = $(this).parents("form").find('#'+id);
		var input_checked = input.prop('checked');
		var name = input.attr('name');
		//var current = $(this).attr('class');
		var type = input.attr('type');

		if (type=='radio') {
			// radio
			// 一度全てのラベルの選択表示を解除
			$(input).parent().find('input[name='+name+']').each(function(){
			  $('label[for='+$(this).attr('id')+']').removeClass('selected');
			});
			// 任意項目ならチェックを外せるように
			if ($(this).parent().hasClass('optional')) {
				if (input_checked) {
					input.removeAttr('checked');
					$(this).removeClass('selected');
				} else {
					input.prop("checked",true);
					$(this).addClass('selected');
				}
			} else {
				input.prop("checked",true);
				$(this).addClass('selected');
			}

		} else {
			// checkbox
			if (input_checked) {
				input.removeAttr('checked');
				$(this).removeClass('selected');
			} else {
				//input.attr('checked', 'true');
				input.prop("checked",true);
				$(this).addClass('selected');
			}

		}

		return false;
	});

});