
<?php require_once('../config.php'); 
 $studentIdNo =$_GET['id_no'];
 
	$qry = $conn->query("SELECT * FROM ticket_downloads where student_id = $studentIdNo ");
    if ($qry->num_rows > 0) {
    $updated_count_query = $conn->query("SELECT download_count FROM ticket_downloads WHERE student_id = '$studentIdNo'");
    $updated_count_row = $updated_count_query->fetch_assoc();
    $download_count = $updated_count_row['download_count'];?>

<div class="container-fluid">
	<form id="manage-download">
		<div id="msg"></div>
		<input type="hidden" name="id_no" value="<?php echo isset($studentIdNo) ? $studentIdNo : '' ?>">
	
        <div class="form-group">
            <label for="" class="control-label">Edit No of lessons below </label>
            <input type="text" class="form-control text-right" name="amount"  value="<?php echo isset($download_count) ? $download_count : '' ?>" required>
        </div>
        
	</form>
</div>
<?php } else{?>
<div class="container-fluid">
<form id="manage-download">
    <div id="msg"></div>
    <input type="hidden" name="id_no" value="<?php echo isset($studentIdNo) ? $studentIdNo : '' ?>">

    <div class="form-group">
        <label for="" class="control-label">Student has not started a Lesson</label>
        <input type="text" style="color:red;"class="form-control text-right" name="amount"  value="<?php echo 'print first!' ?>" required readonly>
    </div>
    
</form>
</div>

<?php } ?>
<script>
	$('.select2').select2({
		placeholder:'Please select here',
		width:'100%'
	})
	$('#ef_id').change(function(){
		var amount= $('#ef_id option[value="'+$(this).val()+'"]').attr('data-balance')
		$('#balance').val(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	})
	$('#manage-download').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url: `../classes/Master.php?f=save_download`,

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
