<?php
session_start();
include 'dbConn.php';

$cust_id = $_SESSION['custID'];
$book_id = $_GET['bookingID'];
$query = "SELECT * FROM booking
    INNER JOIN customer ON booking.customer_id=customer.customer_id 
    INNER JOIN room ON booking.room_id=room.room_id
    INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
    INNER JOIN payment ON booking.booking_id = payment.booking_id
    WHERE booking.customer_id= $cust_id AND booking.booking_id = $book_id";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-image: url("image/background7.jpg");
            background-repeat: no-repeat;
            background-size: 100% 110%;
        }

        .container {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            text-align: left;
        }

        h2 {
            margin-top: 0;
        }

        .back{
            background-color: red;
            color: white;
            height: 30px;
            width: 150px;
            margin-top: 2%;
            margin-left: -12%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.2s ease-in;
        }

        .print1{
            margin-top: -2%;
            margin-left: 10%;
        }

        .print{
            background-color: lightgreen;
            color: white;
            height: 30px;
            width: 150px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: 0.2s ease-in;
        }

        .back:hover{
            background-color: rgb(164, 0, 0);
        }

        .print:hover{
            background-color: rgb(0, 136, 84);
        }


    </style>
</head>
<body>
    <div class= "container">
    <h2>Receipt</h2>
    <table>
        <thead>
            <tr>
                <th>Customer Name:</th>
                <td><?php echo $row['customer_name']; ?></td>
            </tr>
            <tr>
                <th>Customer Email:</th>
                <td><?php echo $row['customer_email']; ?></td>
            </tr>
            <tr>
                <th>Customer No. Tel:</th>
                <td><?php echo $row['customer_notel']; ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Booking Id:</th>
                <td><?php echo $row['booking_id']; ?></td>
            </tr>
            <tr>
                <th>Hotel Name:</th>
                <td><?php echo $row['hotel_name']; ?></td>
            </tr>
            <tr>
                <th>Room Type:</th>
                <td><?php echo $row['room_type']; ?></td>
            </tr>
            <tr>
                <th>Room Id:</th>
                <td><?php echo $row['room_id']; ?></td>
            </tr>
            <tr>
                <th>Days:</th>
                <td><?php echo $row['day']; ?></td>
            </tr>
            <tr>
                <th>Check In Date:</th>
                <td><?php echo $row['checkin_date']; ?></td>
            </tr>
            <tr>
                <th>Check Out Date:</th>
                <td><?php echo $row['checkout_date']; ?></td>
            </tr>
            <tr>
                <th>Payment Id:</th>
                <td><?php echo $row['payment_id']; ?></td>
            </tr>
            <tr>
                <th>Payment Date:</th>
                <td><?php echo $row['payment_date']; ?></td>
            </tr>
            <tr>
                <th>Payment Method:</th>
                <td><?php echo $row['payment_method']; ?></td>
            </tr>
            <tr>
                <th>Card Number</th>
                <td><?php echo $row['card_number']; ?></td>
            </tr>
            <tr>
                <th>Billing Adress</th>
                <td><?php echo $row['billing_address']; ?></td>
            </tr>
            <tr>
                <th>Service Tax (10%):</th>
                <td>RM <?php echo $row['service_charge']; ?></td>
            </tr>
            <tr>
                <th>Total Room Price:</th>
                <td>RM <?php echo $row['total_price']; ?></td>
            </tr>
            
        </tbody>
    </table>
    </div class="back"><input class="back" type="button" value="Back" onclick="history.back()"></div><br>
    <div class="print1"><button class="print"onclick="window.print()">Print Receipt</button></div>
    
</body>
</html>