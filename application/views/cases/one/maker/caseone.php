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
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Fields</h6>
      </div>
      <div class="card-body">
        <form method="post" action="/caseone">
        <span class="text-danger">All Required</span>
        <div class="row">
          <div class="col-lg-6 mb-6">
            <div class="form-group">
              <label for="alphanumericInput">Text 1</label>
              <input name="text1" type="text" class="form-control" id="alphanumericInput" placeholder="Alphanumeric" required>
            </div>
            <div class="form-group">
              <label for="alphabethInput">Text 2</label>
              <input name="text2" type="text" class="form-control" id="alphabethInput" placeholder="Alphabeth" required>
            </div>
            <div class="form-group">
              <label for="numericInput">Text 3</label>
              <input name="text3" type="number" class="form-control" id="numericInput" placeholder="Numeric" required>
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput1">Text 4</label>
              <input name="text4" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" required>
            </div>
          </div>
          <div class="col-lg-6 mb-6">
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select</label>
              <select name="options" class="form-control" id="exampleFormControlSelect1" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect2">Multiple select</label>
              <select name="multipleoptions[]" multiple class="form-control" id="exampleFormControlSelect2" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Textarea</label>
              <textarea name="alltext" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
            </div>
          </div>
          <div class="col-lg-12 mb-6 d-flex justify-content-center">
              <button type="submit" class="btn btn-primary" id="submitbutton">Submit</button>
          </div>
        </div>
        </form>
      </div>
    </div>
    
  </div>

<?php
}
?>