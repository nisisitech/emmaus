<?php
//export all items in store
include('includes/config.php');
$output = '';
if (isset($_POST['export'])) {
     $query = "SELECT * FROM items";
     $result = mysqli_query($conn, $query);
     if (mysqli_num_rows($result) > 0) {
          $output .= '
       <table class="table" bordered="1">  
                        <tr>  
                             <th>Item Name</th>  
                             <th>Quantity Remaining</th>  
                        </tr>
      ';
          while ($row = mysqli_fetch_array($result)) {
               $output .= '
        <tr>  
                             <td>' . $row["item_name"] . '</td>  
                             <td>' . $row["stock_bought"] . '</td>  
                             
                        </tr>
       ';
          }
          $output .= '</table>';
          header('Content-Type: application/xls');
          header('Content-Disposition: attachment; filename=itemsinstore.xls');
          echo $output;
     }
}

?>