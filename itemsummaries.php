<?php
require 'includes/config.php';
if (isset($_POST['sdate'])) {
    // echo "<script>";
    //     echo " console.log('ok');";
    //     echo " alert('ok');";
    // echo "</script>";

    //get all the inputs 
    $startDate = $_POST['sdate'];
    $endDate = $_POST['edate'];

    //make sure that the start date is sooner than the end date
    $startDateTimeStamp = strtotime($startDate);
    $endDateTimeStamp = strtotime($endDate);

    if (!($endDateTimeStamp > $startDateTimeStamp)) {
        echo "<script>";
        echo " alert('The start date should be sooner than the end date');";
        echo "</script>";
        die();
    }

    //generate all dates from the starting date to the ending date
    //the dates should be at most 31
    $dates = array($startDate);
    $datesGenerated = 0;

    $currentTimeStamp = $startDateTimeStamp;
    while ($datesGenerated <= 31) {
        ++$datesGenerated;
        $currentTimeStamp += 86400;
        if ($currentTimeStamp == $endDateTimeStamp) {
            array_push($dates, date("Y-m-d", $endDateTimeStamp));
            break;
        }
        array_push($dates, date("Y-m-d", $currentTimeStamp));
    }

    // print_r($dates);
    $itemsPerDate = array();
    $quantityPerItem = array();
    $totalPerItem = array();

    foreach ($dates as $date) {
        $currentItems = array();
        $sql = "SELECT * FROM sales WHERE date_sold = '$date' ORDER BY item_name ASC";
        $result = mysqli_query($conn, $sql);
        $all_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($all_data as $row) {
            if (!in_array($row['item_name'], $currentItems)) {
                array_push($currentItems, $row['item_name']);
            }
        }
        array_push($itemsPerDate, $currentItems);
    }

    // foreach ($itemsPerDate as $itemsInDate) {
    //     print_r($itemsInDate);
    //     echo "<br/>";
    //     echo "<br/>";
    //     echo "<br/>";
    // }
    // echo "****************************************<br/>";

    for ($dateCounter = 0; $dateCounter < count($dates); $dateCounter++) {
        $itemsOnCurrentDate = $itemsPerDate[$dateCounter];
        $currentDate = $dates[$dateCounter];
        $currentItemQuantity = array();
        $currentTotal = array();

        foreach ($itemsOnCurrentDate as $item) {
            $sqlitem = "SELECT SUM(total_price) as totalprice, SUM(quantity_sold) as qsold FROM sales  WHERE date_sold='$currentDate' AND item_name= '$item' ";
            $query = mysqli_query($conn, $sqlitem);
            $result = mysqli_fetch_assoc($query);
            array_push($currentItemQuantity, $result['qsold']);
            array_push($currentTotal, $result['totalprice']);
        }
        array_push($quantityPerItem, $currentItemQuantity);
        array_push($totalPerItem, $currentTotal);
    }

    // foreach ($quantityPerItem as $quantityInDate) {
    //     print_r($quantityInDate);
    //     echo "<br/>";
    //     echo "<br/>";
    //     echo "<br/>";
    // }

    // echo "****************************************<br/>";

    // foreach ($totalPerItem as $totalInDate) {
    //     print_r($totalInDate);
    //     echo "<br/>";
    //     echo "<br/>";
    //     echo "<br/>";
    // }

    echo '<table  class="display table table-striped table-bordered" cellspacing="0" width="100%">';
        echo '<thead>';
            echo '<tr>';
                echo '<th>Date</th>';
                echo '<th>Item</th>';
                echo '<th>Quantity Sold(kgs)</th>';
                echo '<th>Total Price</th>';
                echo '<th>Grand Total</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
            for($outerCounter = 0; $outerCounter < count($dates); $outerCounter++){
                $total = 0;
                for($innerCounter = 0; $innerCounter < count($itemsPerDate[$outerCounter]); $innerCounter++){
                    $total += $totalPerItem[$outerCounter][$innerCounter];
                    echo '<tr>';
                        if($innerCounter == 0){
                            echo '<td rowspan="'.count($itemsPerDate[$outerCounter]).'">'.$dates[$outerCounter].'</td>';
                        }
                        echo '<td>'.$itemsPerDate[$outerCounter][$innerCounter].'</td>';
                        echo '<td>'.$quantityPerItem[$outerCounter][$innerCounter].'</td>';
                        echo '<td>'.$totalPerItem[$outerCounter][$innerCounter].'</td>';
                        // if($innerCounter == count($itemsPerDate[$outerCounter]) - 1){
                            echo '<td style="background-color: '.(($innerCounter == count($itemsPerDate[$outerCounter]) -1) ? 'aqua': null).'" >'.$total.'</td>';
                        // }
                        // if($innerCounter == count($itemsPerDate[$outerCounter]) - 1){
                        //     echo '<td colspan="4">'.$total.'</td>';
                        // }
                    echo '</tr>'; 
                }
            }
        echo '</tbody>';
    echo '</table>';
}
?>


<!-- echo'<table class="display table table-striped table-bordered" cellspacing="0" width="100%">';
    echo '<thead>';
        echo '<tr>';
            echo '<th>#</th>';
            echo '<th>Item Name</th>';
            echo '<th>Amount Sold(kgs)</th>';
            echo '<th>Total Price</th>';
            echo '</tr>';
        echo '</thead>';
    echo '<tbody>';
        echo '</tbody>';
    echo '</table>'; -->