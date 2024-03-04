<?php require_once('../config.php'); 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM student where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>
        <div class="form-group">
            <label for="" class="control-label">Id No.</label>
            <input type="text" class="form-control" name="id_no"  value="<?php echo isset($id_no) ? $id_no :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Name</label>
            <input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Contact</label>
            <input type="text" class="form-control" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Email</label>
            <input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Address</label>
            <textarea name="address" id="" cols="30" rows="3" class="form-control" required=""><?php echo isset($address) ? $address :'' ?></textarea>
        </div>
        <div class="form-group">
            <label for="type">Student Type</label>
            <select name="type" id="type" class="custom-select">
                <option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected': '' ?>>Current/New</option>
                <option value="4" <?php echo isset($meta['type']) && $meta['type'] == 4 ? 'selected': '' ?>>Almuni</option>
            </select>
        </div>
    </form>
</div>
<script>
    $('#manage-student').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-student').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:"../classes/Master.php?f=save_student",
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

    $('.select2').select2({
        placeholder:"Please Select here",
        width:'100%'
    })
</script>