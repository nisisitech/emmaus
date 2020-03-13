<?php
if (isset($_POST['year'])) {
  include('includes/config.php');
  $year = $_POST['year'];
  $month = $_POST['month'];
  //check all sales
  echo '<div class="panel-body p-20">';
  echo '<h3>SUMMARY OF SALES</h3><br>';
  require 'includes/config.php';
  echo '<table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Item Name</th>';
  echo '<th>Amount Sold(kgs)</th>';
  echo '<th>Total Price</th>';
  echo '<th></th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  $sql = "SELECT DISTINCT item_name FROM sales WHERE MONTH(date_sold)='$month' AND YEAR(date_sold)='$year'ORDER BY item_name ASC";
  $query = mysqli_query($conn, $sql);
  $sales = mysqli_fetch_all($query, MYSQLI_ASSOC);
  foreach ($sales as $sale) {
    $item = $sale['item_name'];

    //result
    $sql1 = "SELECT SUM(total_price) AS totalsum,SUM(quantity_sold) AS totalsold  FROM sales WHERE item_name='$item' AND MONTH(date_sold)='$month' AND YEAR(date_sold)='$year' ";
    $result1 = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_assoc($result1);
    $sumsold = $row['totalsold'];
    $sumprice = $row['totalsum'];
    echo '<tr>';
    echo '<td>' . $item . '</td>';
    echo '<td>' . $sumsold . '</td>';
    echo '<td>' . $sumprice . '</td>';
    echo '</tr>';
  }
  $resultsum = mysqli_query($conn, "SELECT SUM(total_price) AS totalsum FROM sales WHERE MONTH(date_sold)='$month' AND YEAR(date_sold)='$year'");
  $rowsum = mysqli_fetch_assoc($resultsum);
  $sum = $rowsum['totalsum'];
  echo '<tr><td colspan="2" style="text-align:center;">Total Amount: </td>';
  echo '<td colspan="1" style="text-decoration:bold;color:blue;">' . $sum . '</td></tr>';
   echo '<tr><td colspan="3"></td></tr>';
   echo '<tr><td colspan="3" style="text-align:center;"> EXPENSES</td></tr>';
  // get details of the expenses incurred
  $sqlexp = "SELECT * FROM expenses WHERE MONTH(ex_date)='$month' AND YEAR(ex_date)='$year' ORDER BY ex_name ASC";
  $queryexp = mysqli_query($conn, $sqlexp);
  $expenses = mysqli_fetch_all($queryexp, MYSQLI_ASSOC);
  foreach ($expenses as $expense) {
    $name = $expense['ex_name'];
    $expcost = $expense['ex_cost'];
    $expdate = $expense['ex_date'];
    echo '<tr>';
    echo '<td>' . $name . '</td>';
    echo '<td>' . $expcost. '</td>';
    echo '<td>' . $expdate . '</td>';
    echo '</tr>';
  }
  echo '<tr><td colspan="3"></td></tr>';
   echo '<tr><td colspan="3" style="text-align:center;"> PURCHASES</td></tr>';
  $sqlp = "SELECT * FROM purchases WHERE MONTH(purchase_date)='$month' AND YEAR(purchase_date)='$year' ORDER BY item_name ASC";
  $queryp = mysqli_query($conn, $sqlp);
  $epurchases = mysqli_fetch_all($queryp, MYSQLI_ASSOC);
  foreach ($epurchases as $purchase) {
    $pname = $purchase['item_name'];
    $pcost = $purchase['amount_spent'];
    $pqty = $purchase['quantity'];
    $pdate = $purchase['purchase_date'];
    echo '<tr>';
    echo '<td>' . $pname . '</td>';
    echo '<td>' . $pcost. '</td>';
    echo '<td>' . $pqty. '</td>';
    echo '<td>' . $pdate . '</td>';
    echo '</tr>';
  }
  //get details of all purchases
  $queery = mysqli_query($conn, "SELECT SUM(ex_cost) AS totalexp FROM expenses WHERE MONTH(ex_date)='$month' AND YEAR(ex_date)='$year'");
  $rowsexp = mysqli_fetch_assoc($queery);
  $sumexp = $rowsexp['totalexp'];
  $queeryp = mysqli_query($conn, "SELECT SUM(amount_spent) AS totalpurch FROM purchases WHERE MONTH(purchase_date)='$month' AND YEAR(purchase_date)='$year'");
  $rowspurch = mysqli_fetch_assoc($queeryp);
  $sumpurch = $rowspurch['totalpurch'];
  $net= $sum-($sumexp+$sumpurch);
  echo '<tr><td colspan="2" style="text-align:center;">Total Amount on Expenses: </td>';
  echo '<td colspan="1" style="text-decoration:bold;color:blue;">' . $sumexp . '</td></tr>';
  echo '<tr><td colspan="2" style="text-align:center;">Total Amount on Purchases: </td>';
  echo '<td colspan="1" style="text-decoration:bold;color:blue;">' . $sumpurch . '</td></tr>';
  echo '<tr><td colspan="2" style="text-align:center;">Profit/Loss: </td>';
  echo '<td colspan="1" style="text-decoration:bold;color:blue;">' . $net . '</td></tr>';
  echo '</tbody></table>';
}
