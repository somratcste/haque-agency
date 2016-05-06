<?php include ("header.php") ; ?>
<?php include ("left-sidebar-set.php") ; ?>

<div class="content-wrapper">
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Change Your Password </h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Old Password </label>
                <div class="col-sm-6">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Insert Old Password">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">New Password </label>
                <div class="col-sm-6">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Insert New Password">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Confirm Password </label>
                <div class="col-sm-6">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Confirm New Password">
                </div>
              </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right">SUBMIT</button>
            </div><!-- /.box-footer -->
          </form>

          

        </div><!-- /.box -->
    </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>