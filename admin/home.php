<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-info">
<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Training Packages</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `package_list` where status = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Pending Enrollees</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `enrollee_list` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Verified Enrollees</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `enrollee_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">In-Session</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `enrollee_list` where `status` = 2")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Completed</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `enrollee_list` where `status` = 3")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Cancelled</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `enrollee_list` where `status` = 4")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">All Learners</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `student` where 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>


<hr class="border-info">
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3"><a href="..//../admin/?page=students">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Register Learner</span>
            <span class="info-box-number text-right">
              
            </span>
            </div>
            <!-- /.info-box-content -->
        </div></a>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3"><a href="..//../admin/?page=fees">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Assign Reg_No</span>
            <span class="info-box-number text-right">
               
            </span>
            </div>
            <!-- /.info-box-content -->
        </div></a>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3"><a href="..//../admin/?page=payments">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Make Payments</span>
            <span class="info-box-number text-right">
               
            </span>
            </div>
            <!-- /.info-box-content -->
        </div></a>
        <!-- /.info-box -->
    </div>
    <?php if($_settings->userdata('type') == 1):?>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
    <a href="..//../admin/?page=reports">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Reports</span>
            <span class="info-box-number text-right">
               
            </span>
            </div>
            <!-- /.info-box-content -->
        </div></a> 
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3"><a href="..//../admin/?page=expenses">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Expenses</span>
            <span class="info-box-number text-right">
               
            </span>
            </div>
            <!-- /.info-box-content -->
        </div></a>
        <!-- /.info-box -->
    </div>
<?php endif; ?>

    <?php endif;?>
    <?php if (isset($_SESSION['userdata']['sname']) && isset($_SESSION['userdata']['id_no'])): ?>
    <div class="row">   
        <div class="col-12 col-sm-12 col-md-6 col-lg-3"><a href="..//../admin/?page=payments">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-book"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">My Payments</span>
            <span class="info-box-number text-right">
               
            </span>
            </div>
            <!-- /.info-box-content -->
        </div></a>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3"><a href="..//../admin/?page=fees">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-receipt"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">My Fees</span>
            <span class="info-box-number text-right">
              
            </span>
            </div>
            <!-- /.info-box-content -->
        </div></a>
        <!-- /.info-box -->
    </div>
    </div>
    <?php endif; ?>

</div>