<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>@Megavision</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Sales Performance</h5>
          <div class="card-tools"><input type="text" name="daterange" /></div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <p class="text-center">
                <strong id="date-title"></strong>
              </p>

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="sales-chart" height="180" style="height: 180px;"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./card-body -->
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-4 col-6">
              <div class="description-block border-right">
                <span id="sales-description-percentage"></span>
                <h5 class="description-header" id="sales-description-header"></h5>
                <span class="description-text">TOTAL SALES</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-6">
              <div class="description-block border-right">
                <span id="income-description-percentage"></span>
                <h5 class="description-header" id="income-description-header"></h5>
                <span class="description-text">TOTAL INCOME</span>
              </div>
              <!-- /.description-block -->
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Recent Order</h5>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered table-hover datatables" width="100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Order Date</th>
                <th>Order Amount</th>
                <th>Phone</th>
                <th>Sales</th>
                <th>Office</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->