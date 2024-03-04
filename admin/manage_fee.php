<?php require_once('../config.php') ?>

<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM student_ef_list where id = {$_GET['id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}

?>
<?php
require_once('../config.php');

// Get the current year
$currentYear = date('Y');

// Get the latest ADM No. from the database
$latestAdmNoQuery = $conn->query("SELECT ef_no FROM student_ef_list ORDER BY id DESC LIMIT 1");
$latestAdmNoRow = $latestAdmNoQuery->fetch_assoc();

// Check if there's a latest ADM No.
if ($latestAdmNoRow) {
    $latestAdmNo = $latestAdmNoRow['ef_no'];

    // Extract the year part and numeric part from the latest ADM No.
    $latestAdmNoParts = explode('/', $latestAdmNo);
    
    // Check if the array has at least two elements
    if (count($latestAdmNoParts) >= 4) {
        $latestYearPart = $latestAdmNoParts[1];
        $latestNumericPart = intval($latestAdmNoParts[2]);

        // Check if the year part matches the current year
        if ($latestYearPart == $currentYear) {
            // Increment the numeric part by 1
            $newNumericPart = $latestNumericPart + 1;
        } else {
            // Set the year part to the current year and reset the numeric part to 001
            $latestYearPart = $currentYear;
            $newNumericPart = 1; // Reset to 001
        }

        // Generate the new ADM No.
        $newAdmNo = "PACE/$latestYearPart/" . sprintf('%03d', $newNumericPart);
    } else {
        // If the ADM No. format is unexpected, generate a default ADM No.
        $newAdmNo = "PACE/$currentYear/0001";
    }
} else {
    // If there are no existing ADM Nos., generate a default ADM No.
    $newAdmNo = "PACE/$currentYear/0001";
}

// Use $newAdmNo in your form
?>

        <div class="container-fluid">
            <form id="manage-fees">
                <div id="msg"></div>
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="form-group">
            <label for="" class="control-label">Enrollment No./ ADM. No.</label>
            <input type="text" class="form-control" name="ef_no" value="<?php echo $newAdmNo; ?>" required>
        </div>

		<div class="form-group">
			<label for="" class="control-label">Student</label>
			<select name="student_id" id="student_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$student = $conn->query("SELECT * FROM student order by name asc ");
					while($row= $student->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($student_id) && $student_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']).' | '. $row['id_no'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Course</label>
			<select name="course_id" id="course_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$student = $conn->query("SELECT *,concat(course,'-') as class FROM courses order by course asc ");
					while($row= $student->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" data-amount = "<?php echo $row['total_amount'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		 <div class="form-group">
            <label for="" class="control-label">Fee</label>
            <input type="text" class="form-control text-right" name="total_fee"  value="<?php echo isset($total_fee) ? number_format($total_fee) :'' ?>" required>
        </div>
	</form>
</div>
<script>
	$('.select2').select2({
		placeholder:'Please select here',
		width:'100%'
	})
	$('#course_id').change(function(){
    var amount = $('#course_id option[value="'+$(this).val()+'"]').attr('data-amount');
    $('[name="total_fee"]').val(amount); // Send raw fee amount without formatting
    });

    $('#manage-fees').submit(function(e){
    e.preventDefault();
    var _this = $(this);
    $('.pop-msg').remove();
    var el = $('<div>');
    el.addClass("pop-msg alert");
    el.hide();
    start_loader();
    $.ajax({
        url: "../classes/Master.php?f=save_fees",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        dataType: 'json',
        error: err => {
            console.log(err);
            alert_toast("An error occurred", 'error');
            end_loader();
        },
        success: function(resp){
            if(resp.status == 'success'){
                location.reload();
            } else if(!!resp.msg){
                el.addClass("alert-danger");
                el.text(resp.msg);
                _this.prepend(el);
            } else {
                el.addClass("alert-danger");
                el.text("An error occurred due to an unknown reason.");
                _this.prepend(el);
            }
            el.show('slow');
            end_loader();
        }
    });
    });

   
</script>
