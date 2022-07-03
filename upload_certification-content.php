<!DOCTYPE html>
<html>
   <head>
   </head>
   <body>
     <div class="container">
        <br />
        <br />
        <div class="panel panel-default">
          <div class="panel-heading"><h2>Upload certification topics</h2></div>
          <br />
          <br />
          <div class="panel-body">
          <div class="table-responsive">
           <span id="message"></span>
              <form method="post" id="import_excel_form" enctype="multipart/form-data">
                <table class="table">
                  <tr>
                    <td width="25%" text-align="right">Select Excel File</td>
                    <td width="50%"><input type="file" name="import_excel" /></td>
                    <td width="25%"><input type="submit" name="import" id="import" class="btn" style = "background-color: #EC1D25; color: #FFFFFF"  value="Upload Certification Topics" /></td>
                  </tr>
                </table>
              </form>
           <br />
          </div>
          </div>
        </div>
     </div>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  </body>
</html>
<script>
$(document).ready(function(){
  $('#import_excel_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"certification-topics.php",
      method:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      beforeSend:function(){
        $('#import').attr('disabled', 'disabled');
        $('#import').val('Uploading...');
      },
      success:function(data)
      {
        $('#message').html(data);
        $('#import_excel_form')[0].reset();
        $('#import').attr('disabled', false);
        $('#import').val('Upload Content');
      }
    })
  });
});
</script>
<html>
   <head>
   </head>
   <body>
     <div class="container">
        <br />
        <br />
        <div class="panel panel-default">
          <div class="panel-heading"><h2>Upload certification objectives </h2></div>
          <br />
          <br />
          <div class="panel-body">
          <div class="table-responsive">
           <span id="message"></span>
              <form method="post" id="import_excel_form2" enctype="multipart/form-data">
                <table class="table">
                  <tr>
                    <td width="25%" text-align="right">Select Excel File</td>
                    <td width="50%"><input type="file" name="import_excel" /></td>
                    <td width="25%"><input type="submit" name="import" id="import" class="btn" style = "background-color: #EC1D25; color: #FFFFFF"  value="Upload Certification Objectives" /></td>
                  </tr>
                </table>
              </form>
           <br />
          </div>
        </div>
     </div>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  </body>
</html>
<script>
$(document).ready(function(){
  $('#import_excel_form2').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"certification-objectives.php",
      method:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      beforeSend:function(){
        $('#import').attr('disabled', 'disabled');
        $('#import').val('Uploading...');
      },
      success:function(data)
      {
        $('#message').html(data);
        $('#import_excel_form')[0].reset();
        $('#import').attr('disabled', false);
        $('#import').val('Upload Content');
      }
    })
  });
});
</script>
