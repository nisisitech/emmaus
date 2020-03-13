<?php
require ('includes/config.php');
$output='';
if(isset($_POST['exportreport'])){
$month=$_POST['month'];
$year=$_POST['year'];

//check all sales
require 'includes/config.php';
$output .= '<table cellspacing="1">
<tr>
<th>Item Name</th>
<th>Amount Sold(kgs)</th>
<th>Total Price</th>
</tr>';


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
  $output .= '<tr>
  <td>' . $item . '</td>
  <td>' . $sumsold . '</td>
  <td>' . $sumprice . '</td>
  </tr>';
}
$resultsum = mysqli_query($conn, "SELECT SUM(total_price) AS totalsum FROM sales WHERE MONTH(date_sold)='$month' AND YEAR(date_sold)='$year'");
$rowsum = mysqli_fetch_assoc($resultsum);
$sum = $rowsum['totalsum'];
$output .= '<tr><td colspan="2" style="text-align:center;">Total Amount: </td>
<td colspan="1" style="text-decoration:bold;color:blue;">' . $sum . '</td></tr>
 <tr><td colspan="3"></td></tr>
 <tr><td colspan="3" style="text-align:center;"> EXPENSES</td></tr>';
// get details of the expenses incurred
$sqlexp = "SELECT * FROM expenses WHERE MONTH(ex_date)='$month' AND YEAR(ex_date)='$year' ORDER BY ex_name ASC";
$queryexp = mysqli_query($conn, $sqlexp);
$expenses = mysqli_fetch_all($queryexp, MYSQLI_ASSOC);
foreach ($expenses as $expense) {
  $name = $expense['ex_name'];
  $expcost = $expense['ex_cost'];
  $expdate = $expense['ex_date'];
  $output .='<tr>
  <td>' . $name . '</td>
  <td>' . $expcost. '</td>
  <td>' . $expdate . '</td>
  </tr>';
}
$output .='<tr><td colspan="3"></td></tr>
  <tr><td colspan="3" style="text-align:center;"> PURCHASES</td></tr>';
$sqlp = "SELECT * FROM purchases WHERE MONTH(purchase_date)='$month' AND YEAR(purchase_date)='$year' ORDER BY item_name ASC";
$queryp = mysqli_query($conn, $sqlp);
$epurchases = mysqli_fetch_all($queryp, MYSQLI_ASSOC);
foreach ($epurchases as $purchase) {
  $pname = $purchase['item_name'];
  $pcost = $purchase['amount_spent'];
  $pqty = $purchase['quantity'];
  $pdate = $purchase['purchase_date'];
  $output .='<tr>
  <td>' . $pname . '</td>
  <td>' . $pcost. '</td>
  <td>' . $pqty. '</td>
  <td>' . $pdate . '</td>
  </tr>';
}
//get details of all purchases
$queery = mysqli_query($conn, "SELECT SUM(ex_cost) AS totalexp FROM expenses WHERE MONTH(ex_date)='$month' AND YEAR(ex_date)='$year'");
$rowsexp = mysqli_fetch_assoc($queery);
$sumexp = $rowsexp['totalexp'];
$queeryp = mysqli_query($conn, "SELECT SUM(amount_spent) AS totalpurch FROM purchases WHERE MONTH(purchase_date)='$month' AND YEAR(purchase_date)='$year'");
$rowspurch = mysqli_fetch_assoc($queeryp);
$sumpurch = $rowspurch['totalpurch'];
$net= $sum-($sumexp+$sumpurch);
$output .= '<tr><td colspan="2" style="text-align:center;">Total Amount on Expenses: </td>
<td colspan="1" style="text-decoration:bold;color:blue;">' . $sumexp . '</td></tr>
<tr><td colspan="2" style="text-align:center;">Total Amount on Purchases: </td>
<td colspan="1" style="text-decoration:bold;color:blue;">' . $sumpurch . '</td></tr>
<tr><td colspan="2" style="text-align:center;">Profit/Loss: </td>
<td colspan="1" style="text-decoration:bold;color:blue;">' . $net . '</td></tr>';
$output .= '</table>';
$tablename='monthlyreports.xls';
header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename='.$tablename);
echo $output;

}
