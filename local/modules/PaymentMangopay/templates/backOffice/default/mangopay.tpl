{extends file="admin-layout.tpl"}


{block name="before-javascript-include"}

<div class="modal fade" id="naturaluser_creation_dialog" tabindex="-1" role="dialog" aria-labelledby="naturaluser_creation_dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{intl l='Add natural user' d='paymentmangopay.bo.default'}</h4>
			</div>
			{form name="naturaluser.mangopay.creation"}

			<form action="{url path="/admin/module/PaymentMangopay/naturaluser/add"}" method="post" role="form">
			<div class="modal-body">

				{form_hidden_fields form=$form}

				{render_form_field form=$form field="success_url" value={url path="/admin/module/PaymentMangopay/naturaluser/add"}}
                <div class="row">
                    <div class="col-md-6">

                        {form_field form=$form field='email'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='firstname'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='lastname'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='birthday'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='nationality'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr}>
                                <option value="">-- {intl l="Select Country"} --</option>
                                {loop type="country" name="country.list"}
                                <option value="{$ISOALPHA2}"
                                        {if $value != ""}
                                        {if $value == $ID}selected{/if}
                                {else}
                                {if $IS_DEFAULT}selected{/if}
                                {/if}

                                >{$TITLE}</option>
                                {/loop}
                            </select>
                        </div>
                        {/form_field}

                        {form_field form=$form field='countryofresidence'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr}>
                                <option value="">-- {intl l="Select Country"} --</option>
                                {loop type="country" name="country.list"}
                                <option value="{$ISOALPHA2}"
                                        {if $value != ""}
                                        {if $value == $ID}selected{/if}
                                {else}
                                {if $IS_DEFAULT}selected{/if}
                                {/if}

                                >{$TITLE}</option>
                                {/loop}
                            </select>
                        </div>
                        {/form_field}
                    </div>
                    <div class="col-md-6">
                        {form_field form=$form field='addressline1'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}
                        {form_field form=$form field='addressline2'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}
                        {form_field form=$form field='city'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}
                        {form_field form=$form field='region'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}
                        {form_field form=$form field='postalcode'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}
                        {form_field form=$form field='country'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr}>
                                <option value="">-- {intl l="Select Country"} --</option>
                                {loop type="country" name="country.list"}
                                <option value="{$ISOALPHA2}"
                                        {if $value != ""}
                                        {if $value == $ID}selected{/if}
                                {else}
                                {if $IS_DEFAULT}selected{/if}
                                {/if}

                                >{$TITLE}</option>
                                {/loop}
                            </select>
                        </div>
                        {/form_field}

                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				<button type="submit" class="btn btn-info">Ok</button>
			</div>

			</form>
			{/form}
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="legaluser_creation_dialog" tabindex="-1" role="dialog" aria-labelledby="legaluser_creation_dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{intl l='Add legal user' d='paymentmangopay.bo.default'}</h4>
			</div>
			{form name="legaluser.mangopay.creation"}

			<form action="{url path="/admin/module/PaymentMangopay/legaluser/add"}" method="post" role="form">

			<div class="modal-body">

				{form_hidden_fields form=$form}

				{render_form_field form=$form field="success_url" value={url path="/admin/module/PaymentMangopay/legaluser/add"}}

                <div class="row">
                    <div class="col-md-6">

                        {ifloop rel="formmangopayusersloop"}
                            {loop type="mangopayusersloop" name="formmangopayusersloop" isdefault=1}
                            {/loop}
                            {form_field form=$form field='isdefault'}
                            <input type="hidden" value="0" name="{$name}">
                            {/form_field}
                        {/ifloop}
                        {elseloop rel="formmangopayusersloop"}
                            {form_field form=$form field='isdefault'}
                            <div class="form-group {if $error}has-error{/if}">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox" value="1" name="{$name}" >
                                    {$label}
                                    </label>
                                </div>
                            </div>
                            {/form_field}
                        {/elseloop}

                        {form_field form=$form field='Email'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='Name'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalPersonType'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr} >
                                <option value="BUSINESS">BUSINESS</option>
                                <option value="ORGANIZATION">ORGANIZATION</option>
                            </select>
                        </div>
                        {/form_field}

                        {form_field form=$form field='HeadquartersAddressAddressLine1'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='HeadquartersAddressAddressLine2'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='HeadquartersAddressCity'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='HeadquartersAddressRegion'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='HeadquartersAddressPostalCode'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='HeadquartersAddressCountry'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr}>
                                <option value="">-- {intl l="Select Country"} --</option>
                                {loop type="country" name="country.list"}
                                <option value="{$ISOALPHA2}"
                                        {if $value != ""}
                                        {if $value == $ISOALPHA2}selected{/if}
                                {else}
                                {if $IS_DEFAULT}selected{/if}
                                {/if}

                                >{$TITLE}</option>
                                {/loop}
                            </select>
                        </div>
                        {/form_field}
                    </div>

                    <div class="col-md-6">

                        {form_field form=$form field='LegalRepresentativeFirstName'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeLastName'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeAddressAddressLine1'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeAddressAddressLine2'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeAddressCity'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeAddressRegion'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeAddressPostalCode'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeAddressCountry'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr}>
                                <option value="">-- {intl l="Select Country"} --</option>
                                {loop type="country" name="country.list"}
                                <option value="{$ISOALPHA2}"
                                        {if $value != ""}
                                        {if $value == $ISOALPHA2}selected{/if}
                                {else}
                                {if $IS_DEFAULT}selected{/if}
                                {/if}

                                >{$TITLE}</option>
                                {/loop}
                            </select>
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeEmail'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeBirthday'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <input type="text" id="{$label_attr.for}" {if $required}required="required"{/if} name="{$name}" class="form-control" value="{$value}" title="{$label}" placeholder="{$label}">
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeNationality'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr}>
                                <option value="">-- {intl l="Select Country"} --</option>
                                {loop type="country" name="country.list"}
                                <option value="{$ISOALPHA2}"
                                        {if $value != ""}
                                        {if $value == $ISOALPHA2}selected{/if}
                                {else}
                                {if $IS_DEFAULT}selected{/if}
                                {/if}

                                >{$TITLE}</option>
                                {/loop}
                            </select>
                        </div>
                        {/form_field}

                        {form_field form=$form field='LegalRepresentativeCountryOfResidence'}
                        <div class="form-group {if $error}has-error{/if}">
                            <label class="control-label">{$label} {if $required}*{/if}</label>
                            <select name="{$name}" id="{$label_attr.for}" class="form-control {if $required} required {/if}" {if $required} required {/if} {$attr}>
                                <option value="">-- {intl l="Select Country"} --</option>
                                {loop type="country" name="country.list"}
                                <option value="{$ISOALPHA2}"
                                        {if $value != ""}
                                        {if $value == $ISOALPHA2}selected{/if}
                                {else}
                                {if $IS_DEFAULT}selected{/if}
                                {/if}

                                >{$TITLE}</option>
                                {/loop}
                            </select>
                        </div>
                        {/form_field}

                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				<button type="submit" class="btn btn-info">Ok</button>
			</div>

			</form>
			{/form}
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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