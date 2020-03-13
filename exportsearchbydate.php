<?php
include('includes/config.php');
$output ='';
if(isset($_POST['exportdailyreport'])){
   $date =$_POST['date'];

   //export data to excel
   $output .='<table border="1" cellspacing ="1">
      <tr>
        <th>#</th>
        <th>Item Name</th>
        <th>Amount Sold(kgs)</th>
        <th>Total Price</th>
        <th>Date sold</th>
      </tr>';
   
    
      $sql = "SELECT * FROM sales WHERE date_sold='$date'";
      $result = mysqli_query($conn, $sql);
      $all_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $allrows=mysqli_num_rows($result);
      $result1 = mysqli_query($conn,"SELECT SUM(total_price) AS totalsum FROM sales WHERE date_sold='$date' "); 
      $row = mysqli_fetch_assoc($result1); 
      $sum = $row['totalsum'];
      $count=1;
    
      foreach ($all_items as $item) {
       $item_name = $item['item_name'];
       $qsold = $item['quantity_sold'];
       $tp = $item['total_price'];
       $dates=$item['date_sold'];
        $output .= '<tr>
        <td>'.$count.'</td>
        <td>'.$item_name.'</td>
        <td>'.$qsold.'</td>
        <td>'.$tp.'</td>
        <td>'.$dates.'</td>
      </tr>'; 
      $count++;

     }
     $output .= '<tr><td colspan="3" style="text-align:center;">Total Amount: </td>
      <td colspan="2" style="text-decoration:bold;color:blue;">'.$sum. '</td></tr></table><br>';
      $sql = "SELECT DISTINCT item_name FROM sales WHERE date_sold = '$date'";
      $result = mysqli_query($conn, $sql);
      $sales = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $ct=1;

                      $output .= '<h3>SUMMARY OF SALES</h3><br>';
                    require 'includes/config.php';
                    $output .='<table border="1" cellspacing ="1">
                        <tr>
                        <th>#</th>
                          <th>Item Name</th>
                          <th>Amount Sold(kgs)</th>
                          <th>Total Price</th>
                        </tr>
                        <tr>
                        <th>#</th>
                          <th></th>
                          <th>'.$date.'</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>';
      // if(mysqli_num_rows($sales)>0){
      foreach($sales as $sale){
          $item=$sale['item_name'];
          $result1 = mysqli_query($conn,"SELECT SUM(total_price) AS totalsum,SUM(quantity_sold) AS totalsold FROM sales WHERE date_sold='$date'AND item_name='$item'"); 
          $row = mysqli_fetch_assoc($result1); 
          $sumprice = $row['totalsum'];
          $sumsold = $row['totalsold'];
          $output .= '<tr>
          <td>'.$ct.'</td>
          <td>'.$item.'</td>
          <td>'.$sumsold.'</td>
          <td>'.$sumprice.'</td>
          </tr>';
          $ct++;
      }
      $sqlquery=mysqli_query($conn,"SELECT DISTINCT item_name from items WHERE item_name NOT IN($sql)");
      $notinsales= mysqli_fetch_all($sqlquery, MYSQLI_ASSOC);
      foreach ($notinsales as $nonsold){
        $nitem=$nonsold['item_name'];
        $output .= '<tr>
              <td>#</td>
              <td>'.$nitem.'</td>
              <td>0</td>
              <td>0</td> 
              </tr>';
      } 
      $output .='<tr><td  style="text-align:center;"> </td>
      <td  style="text-align:center;">Total Amount: </td>
      <td style="text-decoration:bold;color:blue;">'.$sum. '</td></tr>';
$daten=explode('-',$date);    
$dateexp=$daten[0].$daten[1].$daten[2];
$filename='report'.$dateexp.'.xls';
$output .= '</table>';
header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename='.$filename);
echo $output;

}

?>