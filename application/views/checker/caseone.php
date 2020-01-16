<?php
if(!is_null($this->session->flashdata('status'))){
  ?>
  <!-- Content Column -->
  <div class="col-lg-12 mb-6">

    <!-- Form Card -->
    <div class="card shadow mb-6">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Fields</h6>
      </div>
      <div class="card-body">
        <?php
        if('success' == $this->session->flashdata('status'))
        {
          ?>
          <div class="col-lg-12 mb-6 d-flex justify-content-center">
            <button type="button" class="btn btn-success btn-circle btn-lg"><i class="fas fa-check"></i></button>
          </div>
          <div class="col-lg-12 mb-6 d-flex justify-content-center">
            <a href="caseone" class="rounded-circle border-0"><i class="fas fa-chevron-left"></i><span> Success!</span></a>
          </div>
          <?php
        }
        else
        {
          ?>
          <div class="col-lg-12 mb-6 d-flex justify-content-center">
            <button type="button" class="btn btn-danger btn-circle btn-lg"><i class="fas fa-times"></i></button>
          </div>
          <div class="col-lg-12 mb-6 d-flex justify-content-center">
            <a href="caseone" class="rounded-circle border-0"><i class="fas fa-chevron-left"></i><span> Failed! Sorry.. failed to insert to db..</span></a>
          </div>
          <?php
        }
        ?>
       
      </div>
    </div>
    
  </div>
  <?php
}
else
{
  
?>

  <!-- Content Column -->
  <div class="col-lg-12 mb-6">

    <!-- Form Card -->
    <div class="card shadow mb-6">
      <div class="card-header py-1 nav nav-tabs nav-fill" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-queue-tab" data-toggle="tab" href="#nav-queue" role="tab" aria-controls="nav-queue" aria-selected="true"><h6 class="m-0 font-weight-bold text-primary">Queue List</h6></a>
            <a class="nav-item nav-link" id="nav-accepted-tab" data-toggle="tab" href="#nav-accepted" role="tab" aria-controls="nav-accepted" aria-selected="false"><h6 class="m-0 font-weight-bold text-success">Accepted</h6></a>
            <a class="nav-item nav-link" id="nav-rejected-tab" data-toggle="tab" href="#nav-rejected" role="tab" aria-controls="nav-rejected" aria-selected="false"><h6 class="m-0 font-weight-bold text-danger">Rejected</h6></a>
      </div>
      <div class="card-body tab-content">
        <div class="table-responsive tab-pane fade show active" id="nav-queue" role="tabpanel">
          <table class="table table-bordered" id="dataTableQueue" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Candidate Name</th>
                <th>Text 1</th>
                <th>Text 2</th>
                <th>Text 3</th>
                <th>Text 4</th>
                <th>Options</th>
                <th>Multiple Options</th>
                <th>Alltext</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach($fetchdata as $data)
            {
              if($data->acceptedFlag != 'queue')continue;
              ?>
              <tr>
                <td><?php echo $data->candidateName;?></td>
                <td><?php echo $data->text1;?></td>
                <td><?php echo $data->text2;?></td>
                <td><?php echo $data->text3;?></td>
                <td><?php echo $data->text4;?></td>
                <td><?php echo $data->options;?></td>
                <td><?php echo $data->multipleoptions;?></td>
                <td><?php echo $data->alltext;?></td>
                <td>
                  <a href="#"><i class="fas fa-check text-success" onclick="actionButton(<?php echo $data->id;?>,true)"></i></a>
                  <a href="#"><i class="fas fa-times text-danger" onclick="actionButton(<?php echo $data->id;?>,false)"></i></a>
                </td>
              </tr>
              <?php
            }
            ?>
              
            </tbody>
          </table>
        </div>
        <div class="table-responsive tab-pane fade" id="nav-accepted" role="tabpanel">
          <table class="table table-bordered" id="dataTableAccepted" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Candidate Name</th>
                <th>Text 1</th>
                <th>Text 2</th>
                <th>Text 3</th>
                <th>Text 4</th>
                <th>Options</th>
                <th>Multiple Options</th>
                <th>Alltext</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach($fetchdata as $data)
            {
              if($data->acceptedFlag != 'accept')continue;
              ?>
              <tr>
                <td><?php echo $data->candidateName;?></td>
                <td><?php echo $data->text1;?></td>
                <td><?php echo $data->text2;?></td>
                <td><?php echo $data->text3;?></td>
                <td><?php echo $data->text4;?></td>
                <td><?php echo $data->options;?></td>
                <td><?php echo $data->multipleoptions;?></td>
                <td><?php echo $data->alltext;?></td>
              </tr>
              <?php
            }
            ?>
              
            </tbody>
          </table>
        </div>
        <div class="table-responsive tab-pane fade" id="nav-rejected" role="tabpanel">
          <table class="table table-bordered" id="dataTableRejected" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Candidate Name</th>
                <th>Text 1</th>
                <th>Text 2</th>
                <th>Text 3</th>
                <th>Text 4</th>
                <th>Options</th>
                <th>Multiple Options</th>
                <th>Alltext</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach($fetchdata as $data)
            {
              if($data->acceptedFlag != 'reject')continue;
              ?>
              <tr>
                <td><?php echo $data->candidateName;?></td>
                <td><?php echo $data->text1;?></td>
                <td><?php echo $data->text2;?></td>
                <td><?php echo $data->text3;?></td>
                <td><?php echo $data->text4;?></td>
                <td><?php echo $data->options;?></td>
                <td><?php echo $data->multipleoptions;?></td>
                <td><?php echo $data->alltext;?></td>
              </tr>
              <?php
            }
            ?>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>

<?php
}
?>