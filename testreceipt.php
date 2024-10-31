<?php
session_start();
include 'dbConn.php';

require __DIR__ . "/vendor/autoload.php";

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

$html .= '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Receipt</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer Name:</th>
                    <td>' . $row['customer_name'] . '</td>
                </tr>
                <tr>
                    <th>Customer Email:</th>
                    <td>' . $row['customer_email'] . '</td>
                </tr>
                <tr>
                    <th>Customer No. Tel:</th>
                    <td>' . $row['customer_notel'] . '</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Booking Id:</th>
                    <td>' . $row['booking_id'] . '</td>
                </tr>
                <tr>
                    <th>Hotel Name:</th>
                    <td>' . $row['hotel_name'] . '</td>
                </tr>
                <tr>
                    <th>Room Type:</th>
                    <td>' . $row['room_type'] . '</td>
                </tr>
                <tr>
                    <th>Room Id:</th>
                    <td>' . $row['room_id'] . '</td>
                </tr>
                <tr>
                    <th>Days:</th>
                    <td>' . $row['day'] . '</td>
                </tr>
                <tr>
                    <th>Check In Date:</th>
                    <td>' . $row['checkin_date'] . '</td>
                </tr>
                <tr>
                    <th>Check Out Date:</th>
                    <td>' . $row['checkout_date'] . '</td>
                </tr>
                <tr>
                    <th>Payment Id:</th>
                    <td>' . $row['payment_id'] . '</td>
                </tr>
                <tr>
                    <th>Payment Date:</th>
                    <td>' . $row['payment_date'] . '</td>
                </tr>
                <tr>
                    <th>Payment Method:</th>
                    <td>' . $row['payment_method'] . '</td>
                </tr>
                <tr>
                    <th>Service Tax (10%):</th>
                    <td>RM ' . $row['service_charge'] . '</td>
                </tr>
                <tr>
                    <th>Total Room Price:</th>
                    <td>RM ' . $row['total_price'] . '</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>';
 
// reference the Dompdf namespace 
use Dompdf\Dompdf;

$dompdf = new Dompdf;
$dompdf->loadHtml($html);
// Setup the paper size and orientation
$dompdf->SetPaper("A4", "portrait");
// Render html to pdf 
$dompdf->render();
// Name PDF file
$dompdf->stream('receipt.pdf')


?>
