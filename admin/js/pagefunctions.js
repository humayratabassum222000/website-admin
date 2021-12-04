$(document).ready(function(){
	/*=======================================
	======== Add Product Page Function ======*/
	$('.sl-main').click(function(){
		var main 	= $(this).attr('data-main');
		var id		= $(this).attr('id');
		
		$('.sl-sub-ul').each(function() {
			$(this).hide();
			$(this).find('li').removeClass('active');
			$(this).closest('div.col-sm-4').prev().find('ul li').removeClass('active');
		});
		
		$('#subLabel').show();
		$('.main').html(main);
		$('input[name="category"]').val(main);
		
		$('#sub').html('');
		$('.tab-content #next-btn').hide();
		
		$(this).addClass('active');
		
		$('#s'+id).slideDown('slow');
	});
	$('.sl-sub').click(function(){
		var sub	= $(this).attr('data-sub');
		
		$('.tab-content #next-btn').show();
		$('.sub').html(sub);
		$('input[name="subcategory"]').val(sub);
		
		$('.sl-sub').each(function() {
			$(this).removeClass('active');
		});
		$(this).addClass('active');
	});
	$('#next-btn').click(function(){
		$('#step1-btn').removeClass('active');
		$('#step2-btn').addClass('active');
	});
	
	/*===============================================
	=== Updata And Delete Product Page Functions ===*/
	
	$('.btn.folder-btn').click(function(){
		var main	= $(this).attr('data-category-id');
		
		$('select.sub-select').each(function(){
			$(this).hide();
		});
		$('#'+main+'-sub').show();
	});
	$('select.sub-select').change(function(){
		var prid = $(this).val();
		
		$('#field-1-id').val(prid);
		getProduct(prid);
		showDetails();
	});

	/*===============================================
	== Add Update Delete Common Functions ====*/
	idi	= 1;
	$("input[name='color[]']").change(function(){
		if(this.checked) {
			var color	= $(this).val();
			$('#proimg1').remove();
			idi++;
			insertColoredProductInputField(idi, color);
		} else {
			var color	= $(this).val();
			$('#proimg'+color).remove();
			idi--;
			if(idi <= 1) {
				insertNoColoredProductInputField();	
			}
		}
	});

	if($(".ava-color").length > 0) {
		$(".ava-color").each(function(i){
			var color	= $(this).find('input').val();
			$(this).css({"background": color});
		});
	}
	if($(".new-category").length > 0){
		$(".new-category input[type='file']").prop('disabled', true);
		$(".form-control.select-main").bind("change keyup", function(){
			var mainCat = $(this).val();
			
			if(mainCat == 'other') {
				$("#brandDiv").html('<input type="text" name="main" class="form-control" required="true" placeholder="Enter Category Name Here...">');
				
				$('.new-category').slideDown();
				$(".new-category input[type='file']").prop('disabled', false);
			}
		});
	}
});
function replace_comma(textToreplace){
	newText	= textToreplace.replace(/~comma~/g,',');
	return newText;
}
function getProduct(value) {
	$('.checking').show();
	$('.not-found').hide();
	
	$.post("ajax.php",{
		prid: value,
		getProducts: 1
	},
	function(data, status){
		if(data == 0) { 
			$('.not-found').show();
			$('.checking').hide();
			hideDetails();
		}
		else {
			$('.not-found').hide();
			$('.checking').hide();
			
			var result 	= data.split(',');
			
			$('.ava-color').find('input').prop('checked', false);
			$('.ava-size').find('input').prop('checked', false);
			
			
			$('#field-1-2').val(replace_comma(result[0])); 
			$('#field-1-3').val(replace_comma(result[1])); 
			$('#field-1-4').val(replace_comma(result[2])); 
			$('#field-1-5-1').val(result[3]); 
			$('#field-1-8').val(result[6]); 
			$('#field-1-9').val(result[7]); 
			$('#field-1-9-1').val(result[8]);
			if(result[9] == 1) {
				$('.new_arrival').find('input').prop('checked', true);
			} else {
				$('.new_arrival').find('input').prop('checked', false);
			}
			
			if(result[10] == 1) {
				$('.trending').find('input').prop('checked', true);
			}else {
				$('.trending').find('input').prop('checked', false);
			}
			
			var size = result[4].split('|');
			for(i = 0; i<size.length; i++) {
				$('#checkbox'+size[i]).prop('checked', true);
			}
			
			var color_array 	= result[5].split('|');
			var newColor_array 	= color_array.filter(function(v){return v!==''});
			
			if(newColor_array.length === 0) {
				insertNoColoredProductInputField();
			} else {
				$('.product-image').html('');
				for(i = 0; i<newColor_array.length; i++) {
					var color	= newColor_array[i];					
					$('input[value="'+color+'"]').prop('checked', true);
					idi		 = i+2; 
					insertColoredProductInputField(idi, color);
				}
			}
			$('#field-1-4').summernote({
				height: 300,
				tabsize: 2
			});
			showDetails();
		}
	});
}
function insertColoredProductInputField(idi, color) {
	var html = 	'<div class="col-xs-12 col-sm-6 proimg-md" id="proimg'+color+'">';
	html	+=	'	<label for="input-b'+idi+'" class="control-label">';
	html	+=	'		Upload <span class="label-color-span" style="background: '+color+'">'+color+'</span> Product Image <span class="image-size">(Size: 960&times;1280)</span>';
	html	+=	'	</label>';
	html 	+=	'	<input	id="input-b'+idi+'" name="'+color+'pr_img[]" type="file" class="file" multiple'; 
	html	+=	'			data-show-upload="false"';
	html	+=	'			data-show-caption="true"';
	html	+=	'			data-msg-placeholder="Select {files} for upload...">';												
	html	+=	'</div>';
	
	$('.product-image').append(html);
	
	$("#input-b"+idi).fileinput({
		rtl: true,
		allowedFileExtensions: ["jpg"]
	});
}
function insertNoColoredProductInputField(){
	var html = 	'<div class="col-xs-12 col-sm-6 proimg-md" id="proimg1">';
	html	+=	'	<label for="input-b0" class="control-label">Product Image</label>';
	html 	+=	'	<input	id="input-b0" name="pr_img[]" type="file" class="file" multiple'; 
	html	+=	'			data-show-upload="false"';
	html	+=	'			data-show-caption="true"';
	html	+=	'			data-msg-placeholder="Select {files} for upload...">';												
	html	+=	'</div>';
	
	$('.product-image').html(html);
	
	$("#input-b0").fileinput({
		rtl: true,
		allowedFileExtensions: ["jpg"]
	});
}
function showDetails(){
	$('#q-product-details').fadeIn();
}
function hideDetails(){
	$('#q-product-details').hide();
}