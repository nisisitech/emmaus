<?php
$output ='';
require 'includes/config.php';
if(isset($_POST['export_expenses'])){

    $query = "SELECT * FROM expenses";
 $result = mysqli_query($conn, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Name</th>  
                         <th>Expense Cost</th>  
                         <th>Expense Date</th> 
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$row["ex_name"].'</td>  
                         <td>'.$row["ex_cost"].'</td>  
                         <td>'.$row["ex_date"].'</td> 
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=allexpenses.xls');
  echo $output;
 }
}

?>