<?php
require ('includes/config.php');
$output='';
if (isset($_POST['export_purchases'])) {
    $query = "SELECT * FROM purchases ORDER BY purchase_date DESC";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Purchase Name</th>  
                         <th>Quantity</th>  
                         <th>Amount</th>
                         <th>Purchase Date</th>  
                    </tr>
  ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
    <tr>  
                         <td>' . $row["item_name"] . '</td>  
                         <td>' . $row["quantity"] . '</td>
                         <td>' . $row["amount_spent"] . '</td>  
                         <td>' . $row["purchase_date"] . '</td>  
       
                    </tr>
   ';
        }
        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=allpurchases.xls');
        echo $output;
    }
}
