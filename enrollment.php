<style>
    #service-list tbody tr{
        cursor: pointer;
    }
    #package-details{
        display:none
    }
</style>
<div class="py-3">
    <div class="card card-outline card-navy rounded-0">
        <div class="card-header rounded-0">
            <h5 class="card-title">Enrollment Form</h5>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body rounded-0">
            <div class="container-fluid">
                <form action="" id="enrollment-form" method="POST">
                    <input type="hidden" name="id">
                    <fieldset>
                        <legend class="text-navy">Enrollee Information</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="firstname" class="control-label">First Name</label>
                                    <input type="text" name="firstname" id="firstname" autofocus class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="middlename" class="control-label">Middle Name</label>
                                    <input type="text" name="middlename" id="middlename" class="form-control form-control-border border-navy" placeholder="optional">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender" class="control-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control form-control-border border-navy" required>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>TransGender</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dob" class="control-label">ID No.</label>
                                    <input type="text" name="dob" id="dob" class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact" class="control-label">Contact</label>
                                    <input type="text" name="contact" id="contact" class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address" class="control-label">Address <small><span class="text-muted">(Block/Room #, Bulding/Lot, Subd./St., Bregy, City, State, Zip Code)</span></small></label>
                                    <input type="textarea" rows="1" name="address" id="address" class="form-control form-control-border border-navy" placeholder="Block/Room #, Bulding/Lot, Subd./St., Bregy, City, State, Zip Code" required></input>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <hr class="bg-navy border-navy">
                    <fieldset>
                        <legend class="text-navy">Enrollment Information</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="package_id" class="control-label">Training Package</label>
                                    <select name="package_id" id="package_id" class="form-control form-control-border border-navy select2" required>
                                        <option value="" selected disabled></option>
                                        <?php 
                                            $package_arr = [];
                                            $packages = $conn->query("SELECT * FROM `courses` where `status` = 1 order by `course` asc");
                                            while($row = $packages->fetch_assoc()):
                                                $package_arr[$row['id']] = $row;
                                        ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['course'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div><br>
                        <div class="row" id="package-details" style="">
                            <input type="hidden" name="cost" value="0">
                            <div class="col-md-12">
                                <span class="mr-3 text-muted"><i class="fa fa-calendar mr-2"></i> <span id="duration"></span></span>
                                <span class="mr-3 text-muted"><i class="fa fa-tags mr-2"></i> <span id="total_amount"></span></span>
                            </div>
                            <div class="col-md-12">
                                <p id="description"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date" class="control-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control form-control-border border-navy" required>
                                </div>
                            </div><br>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="time" class="control-label">Preferred Time</label>
                                    <select name="time" id="time" class="form-control form-control-border border-navy select2" required>
                                        <?php 
                                        $time = date("Y-m-d")." 8:00";
                                        for($i = 0 ; $i < 9;$i++):
                                        ?>
                                        <option><?= date("h:i A",strtotime($time." +{$i} hours")) ?> - <?= date("h:i A",strtotime($time." +".($i + 1)." hours +30 mins")) ?></option>
                                        <?php
                                            $i++;
                                            endfor;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <hr class="bg-navy border-navy">
                    <div class="col-12 text-center">
                    <button  class="w3-btn w3-yellow w3-margin-top w3-round" type="submit">Submit Enrollment</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Include jQuery -->
 <script src="plugins/select2/js/select2.js"></script>

 <script>
    var packageData = <?= json_encode($package_arr) ?>;
    function calc(){
        var total = 0;
        $('.service_id:checked').each(function(){
            var cost = $('input[name="cost['+$(this).val()+']"]').val();
            total += parseFloat(cost);
        });
        $('#total_amount').text(parseFloat(total).toLocaleString('en-US',{style:"decimal", minimumFractionDigits: 2, maximumFractionDigits: 2}));
        $('[name="total"]').val(parseFloat(total));
    }
    $(function(){
        $('#package_id').select2({
            placeholder: "Please Select Package Here.",
            width: "100%"
        });
        $('#package_id').change(function(){
            var id = $(this).val();
            if(packageData[id]){
                $('#duration').text(packageData[id].training_duration);
                $('#total_amount').text(parseFloat(packageData[id].total_amount).toLocaleString("en-US"));
                $('input[name="total_amount"]').val(packageData[id].total_amount);
                $("#description").text(packageData[id].description);
                $('#package-details').show('slow');
            }else{
                $('#package-details').hide('');
            }
        });
        $('#service-list tbody tr').click(function(){
            if($(this).find('.service_id').is(":checked") == true){
                $(this).find('.service_id').prop("checked",false).trigger("change");
            }else{
                $(this).find('.service_id').prop("checked",true).trigger("change");
            }
            calc();
        });
        $('#enrollment-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            start_loader();
            $.ajax({
                url: "classes/Master.php?f=save_enrollment",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred",'error');
                    end_loader();
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        uni_modal("Success","message.php?reg_no="+resp.reg_no);
                        $('#uni_modal').on('hide.bs.modal',function(e){
                            location.reload();
                        });
                        $('#uni_modal').on('shown.bs.modal',function(e){
                            end_loader();
                        });
                        _this[0].reset();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    }else{
                        el.addClass("alert-danger");
                        el.text("An error occurred due to unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    end_loader();
                    $('html, body').animate({scrollTop:_this.offset().top},'fast');
                }
            });
        });
    });
</script>
