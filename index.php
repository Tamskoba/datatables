<?php 
  require 'vendor/autoload.php';

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

  $inputFileName = 'files/Liste des clients.xlsx';

  try {
    /** Load $inputFileName to a Spreadsheet Object  **/
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    /**  Advise the Reader that we only want to load cell data  **/
    $reader->setReadDataOnly(true);

    $spreadsheet = $reader->load($inputFileName);

    $worksheet = $spreadsheet->getActiveSheet();

    $dataArray = array();

    foreach ($worksheet->getRowIterator() as $row) {
        $line = array();
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(TRUE); 

        foreach ($cellIterator as $cell) {           
              $line[] = $cell->getValue();                
        }
        $dataArray[] = $line;
    } 

  } catch(\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    die('Error loading file: '.$e->getMessage());
  }

?>
<html>
<head>
  <title>DataTables Example</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link href='css\bootstrap.min.css' rel='stylesheet' type='text/css'/> 		
  <script src="https://kit.fontawesome.com/3c6b498a1b.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="row">
    <div class="col-10">
      <table id="example" class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Email</th>
            <th>Ville</th>        
          </tr>
        </thead>
        <tbody>
          <!-- Data will be inserted here dynamically -->
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      // Create DataTable
      var table = $('#example').DataTable();
      
      // Insert data
      var MSdata = <?php echo json_encode($dataArray); ?>

      // Loop through the data and add it to the table
      for (var i = 1; i < MSdata.length; i++) {
        table.row.add(MSdata[i]).draw();
      }
    });
  </script>
</body>
</html>