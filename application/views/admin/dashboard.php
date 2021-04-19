<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small><?=$this->config->item('app_name')?></small>
      </h1>
    </section>
    
    <section class="content">
        
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?=count($manual_bills);?></h3>
                  <p>Total Manual Bills</p>
                </div>
                <?php  	if($_SESSION['role'] == ROLE_STORE_ADMIN)
				{?>
              
                <a href="<?=base_url()?>admin/bill-report/<?=$_SESSION['store_id']?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <?php }else{?>

                <a href="<?=base_url()?>admin/store-list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <?php }?>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?=count($salenotes)?></h3>
                  <p>Total Sale Notes</p>
                </div>
                <a href="<?=base_url()?>admin/salenote" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>₹</h3>
                  <p>Sale Report</p>
                </div>
                <a href="<?=base_url()?>admin/sale-report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>₹</h3>
                  <p>Deposit Report</p>
                </div>
                <a href="<?=base_url()?>admin/deposit-report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>
    </section>
</div>