<!-- Earnings (Monthly) Card Example -->
<div class="row">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ballance</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">999,999,999</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-coins fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if($this->session->role == 'maker')
{
  ?>
<!-- Input Form -->
<div class="row">
  <div class="col-lg-6 mb-4">
    <p>
      <a class="btn btn-info btn-icon-split" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        <span class="icon text-white-50">
          <i class="fas fa-info-circle"></i>
        </span>
        <span class="text">New Transaction</span>
      </a>
    </p>
    <div class="collapse" id="collapseExample">
      <div class="card">
        <div class="card-body">
          <div class="row">
              <div class="col-lg-6 col-xl-6 col-md-6">
                <form>
                  <div class="form-group">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input name="type" type="radio" id="addRadio" class="custom-control-input" required> 
                      <label class="custom-control-label text-success" for="addRadio"><i class="fas fa-plus"></i>(Add)</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input name="type" type="radio" id="addExpense" class="custom-control-input" required>
                      <label class="custom-control-label text-danger" for="addExpense"><i class="fas fa-minus"></i>(Expense)</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input name="amount" type="number" class="form-control" id="amount" placeholder="1000" required>
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <input name="description" type="text" class="form-control" id="description" placeholder="Add your description here" required>
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" class="form-control" id="status" readonly>
                  </div>
                </form>
              </div>
              <div class="col-lg-6 col-xl-6 col-md-6 d-flex align-items-center text-center">
                <a role="button" class="btn btn-success btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                  </span>
                  <span class="text text-white">Ok</span>
                </a>
              </div>         
          </div>
        </div>          
      </div>
    </div>
  </div>
</div>
  <?php
}
?>

<!-- Transaction Table -->
<div class="row">
  <div class="col-lg-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Transactions List</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTableTransactions" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Plus/Minus</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><i class="fas fa-plus text-success"></i></td>
                <td>999,999,999</td>
                <td>Enter my description 50 character in here... Yuhuu</td>
                <td>Approve</td>
                <td>
                  <?php
                  if($this->session->role == 'maker')
                  {
                    ?>
                    <button class="btn btn-primary btn-icon-split" disabled>
                      <span class="icon text-white">
                        <i class="fas fa-edit"></i>
                      </span>
                      <span class="text text-white">Edit</span>
                    </button>
                    <button class="btn btn-danger btn-icon-split">
                      <span class="icon text-white">
                        <i class="fas fa-trash"></i>
                      </span>
                      <span class="text text-white">Cancel</span>
                    </button>
                    <?php
                  }else{
                    ?>
                    <button class="btn btn-success btn-icon-split" disabled>
                      <span class="icon text-white">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="text text-white">Approve</span>
                    </button>
                    <button class="btn btn-danger btn-icon-split">
                      <span class="icon text-white">
                        <i class="fas fa-times"></i>
                      </span>
                      <span class="text text-white">Reject</span>
                    </button>
                    <?php
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>