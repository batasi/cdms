
<?php require_once('../config.php'); 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM expenses where id = {$_GET['id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form id="manage-expenses">
		<div id="msg"></div>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
	
        <div class="form-group">
            <label for="" class="control-label">Expense Amount</label>
            <input type="text" class="form-control text-right" name="amount"  value="<?php echo isset($amount) ? number_format($amount) :0 ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Remarks</label>
            <textarea name="remarks" id="" cols="30" rows="3" class="form-control" required=""><?php echo isset($remarks) ? $remarks :'' ?></textarea>
        </div>
	</form>
</div>
<script>
	$('.select2').select2({
		placeholder:'Please select here',
		width:'100%'
	})
	$('#ef_id').change(function(){
		var amount= $('#ef_id option[value="'+$(this).val()+'"]').attr('data-balance')
		$('#balance').val(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	})
	$('#manage-expenses').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:"../classes/Master.php?f=save_expenses",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    end_loader();
                }
            })
        })
</script>
