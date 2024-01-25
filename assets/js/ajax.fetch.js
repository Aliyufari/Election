$(document).ready(function(){
	$('.dynamic').change(function(){
	  if ($(this).val() != '') {
	    let select = $(this).attr("name");
	    let value = $(this).val();
	    let dependent = $(this).data('dependent');
	    let _token = $('input[name="_token"]').val();

	    $.ajax({
	      url:"/admin/ajax",
	      method:"POST",
	      data:
	      {
	        select:select,
	        value:value,
	        _token:_token,
	        dependent:dependent
	      },
	      success:function(result){
	        $('#' + dependent).html(result);
	      }
	    });
	  }
	});
});