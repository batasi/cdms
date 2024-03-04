<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<?php require_once('../config.php'); ?>
<?php 
    $month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Payment Reports</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<form action="" id="filter-data">
				<div class="row align-items-end">
					<div class="col-md-8">
						<div class="form-group">
						<div class="row justify-content-center pt-4">
						<label for="" class="mt-2">Month</label>
						<div class="col-sm-3">
							<input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
						</div>
					</div>
					</div>
					</div>		
					<div class="col-md-4">
						<div class="form-group">
							<button class="btn btn-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Print</button>
						</div>
					</div>
				</div>
			</form>
        <div id="outprint">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="35%">
					<col width="35%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>DateTime</th>
						<th>Reg. No</th>
						<th>Fullname</th>
						<th>Remarks</th>
						<th class="text-right">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$total = 0;
						$qry = $conn->query("SELECT p.*,s.name as sname, ef.ef_no,s.id_no FROM payments p inner join student_ef_list ef on ef.id = p.ef_id inner join student s on s.id = ef.student_id where date_format(p.date_created,'%Y-%m') = '$month' order by unix_timestamp(p.date_created) asc ");
						if($qry->num_rows > 0):
						while($row = $qry->fetch_assoc()):
				    	$total += $row['amount'];

						
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo ($row['ef_no']) ?></td>
							<td><?php echo ucwords($row['sname']) ?></td>
							<td><?php echo $row['remarks'] ?></td>
							<td class="text-right"><?php echo number_format($row['amount'],2) ?></td>
						</tr>
					<?php endwhile;
					 else:
					?>
					<tr>
                            <th class="text-center" colspan="7">No Data.</th>
                    </tr>
                    <?php 
                        endif;
                    ?>
				</tbody>
				<tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th class="text-right"><?php echo number_format($total,2) ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('#print').click(function(){
            var _h = $("head").clone()
            var _p = $('#outprint').clone()
            var el = $("<div>")
            start_loader()
            $('script').each(function(){
                if(_h.find('script[src="'+$(this).attr('src')+'"]').length <= 0){
                    _h.append($(this).clone())
                }
            })
			var ao = "";
			
            _h.find('title').text("Payment Report - Print View")
            _p.prepend("<hr class='border-navy bg-navy'>")
            _p.prepend("<div class='mx-5 py-4'><h1 class='text-center'><?= $_settings->info("name") ?></h1>"
                        +"<h5 class='text-center'>' Payments Report of <?php echo date("F, Y",strtotime($month)) ?></h5><h5 class='text-center'>"+ao+"</h5></div>")
            _p.prepend("<img src='<?= validate_image($_settings->info('logo')) ?>' id='print-logo' />")
            el.append(_h)
            el.append(_p)

            var nw = window.open("","_blank","height=800,width=1200,left=200")
                nw.document.write(el.html())
                nw.document.close()
                setTimeout(()=>{
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        end_loader()
                    }, 300);
                },300)
        })
	})
</script>
<script>
$('#month').change(function(){
    location.replace('..//../admin/?page=reports&month='+$(this).val())
})

</script>