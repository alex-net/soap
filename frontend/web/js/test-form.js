jQuery(function($){
	var form=$('#tst-form');; // .yiiActiveForm('data');
	$('#tst-form').on('beforeSubmit',function(e){
		var from = $(this);
		$('.succmess,.errrmes').removeClass('vis');
		$.post('',$(this).serialize(),function(data){
			if (typeof data.formerrors !='undefined'){
				form.yiiActiveForm('updateMessages',data.formerrors,true);
				//form.yiiActiveForm('updateMessages',{date:['sda']},true);
				console.log('asa');
				console.log(data.formerrors);
				return;
			}
			if (typeof data.error !='undefined'){
				console.log(data.error);
				$('.errrmes').html('Error: '+JSON.stringify(data.error)).addClass('vis');
			}
			else
				$('.succmess').html('Info: '+JSON.stringify(data)).addClass('vis');
			
		});
		
		//console.log('submit');
		return false;
	});
	
});