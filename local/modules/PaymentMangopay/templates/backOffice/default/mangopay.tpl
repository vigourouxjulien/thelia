{extends file="admin-layout.tpl"}


{block name="before-javascript-include"}

<div class="modal fade" id="myAjaxModal" tabindex="-1" role="dialog" aria-labelledby="myAjaxModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myAjaxModalConfirmation" tabindex="-1" role="dialog" aria-labelledby="myAjaxModalConfirmation" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>

			<form action="" method="post" role="form">

			<div class="modal-body">
				<p></p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{intl d='paymentmangopay.bo.default' l='Close'}</button>
				<button type="submit" class="btn btn-info">{intl d='paymentmangopay.bo.default' l='Save'}</button>
			</div>

			</form>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{/block}

{block name="javascript-initialization"}

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
	$('.mangopay-confirmation-action').on('click',function(){
		var myUrl = $(this).attr('href');
		var modaltitle = $(this).data('modaltitle');
		var modaldesc = $(this).data('modaldesc');
		console.log(modaltitle);
		$('#myAjaxModalConfirmation .modal-title').html(modaltitle);
		$('#myAjaxModalConfirmation .modal-body p').html(modaldesc);
		$('#myAjaxModalConfirmation form').attr('action',myUrl);
		$('#myAjaxModalConfirmation').modal('show');

		return false;
	});
    $('.mangopay-ajax-action').on('click',function(){
        var myUrl = $(this).attr('href');
		$.ajax({
			type: "POST",
			url: myUrl+"/",
			dataType: "html",
			success: function(msg){
				$('#myAjaxModal .modal-content').html(msg);
				$('#myAjaxModal').modal('show');
			}
		});
        return false;
    });
</script>

{/block}