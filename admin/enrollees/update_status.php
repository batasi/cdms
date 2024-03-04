<div class="container-fluid">
    <form action="" id="update_status_form">
        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : "" ?>">
        <div class="form-group">
            <label for="status" class="control-label text-navy">Status</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="0" <?= isset($_GET['status']) && $_GET['status'] == 0 ? "selected" : "" ?>>Pending</option>
                <option value="1" <?= isset($_GET['status']) && $_GET['status'] == 1 ? "selected" : "" ?>>Verified</option>
                <option value="4" <?= isset($_GET['status']) && $_GET['status'] == 4 ? "selected" : "" ?>>Cancelled</option>
            </select>
            
        </div>
    </form>
</div>
<script>
        $('#update_status_form').submit(function(e){
            e.preventDefault()
            start_loader()
            var el = $('<div>')
            el.addClass("pop-msg alert")
            el.hide()
            $.ajax({
                url: "..//../classes/Master.php?f=update_status",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: function(err){
                    console.log(err)
                    alert_toast("An error occured while saving the data,", "error")
                    end_loader()
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        location.reload()
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
