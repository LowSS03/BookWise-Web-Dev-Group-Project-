<?php
session_start();
include 'dbConn.php';
$roomID = $_GET['roomID'];

$query = "SELECT * FROM room WHERE room_id = '$roomID'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$customerQuery = "SELECT * FROM customer";
$customerResult = mysqli_query($connection, $customerQuery);
$customerData = mysqli_fetch_all($customerResult, MYSQLI_ASSOC);

$totalRoomPrice = ""; // Default value

if (isset($_POST['btnBook'])) {
    $hotelID = $_POST['hotelID'];
    $customerID = $_POST['customerID'];
    $roomID = $_POST['roomID'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $day = $_POST['day'];
    $service = $_POST['serviceTax'];

    // Check if the room is available for the selected dates
    $availabilityQuery = "SELECT * FROM booking WHERE room_id = '$roomID' AND ('$checkin' BETWEEN checkin_date AND checkout_date OR '$checkout' BETWEEN checkin_date AND checkout_date)";
    $availabilityResult = mysqli_query($connection, $availabilityQuery);
    $numRows = mysqli_num_rows($availabilityResult);

    if ($numRows > 0) {
        echo "<script>";
        echo "alert('The room is not available for the selected dates. Please choose different dates.');";
        echo "</script>";
    } else {
        // Calculate total room price
        $roomPrice = $row['room_price'];
        $totalRoomPrice = number_format($roomPrice * $day, 2);

        // Add service charge to the total room price
        $total = $totalRoomPrice + $service;
        $totalVal = $_POST['totalVal'];

        $query = "INSERT INTO `booking`(`hotel_id`,`customer_id`,`room_id`,`checkin_date`,`checkout_date`,`day`,`service_charge`,`total_price`) VALUES ('$hotelID','$customerID','$roomID','$checkin','$checkout','$day','$service','$totalVal')";
        if (mysqli_query($connection, $query)) {
            // Update the room status to 'Occupied'
            $updateRoomQuery = "UPDATE room SET room_status = 'Occupied' WHERE room_id = '$roomID'";
            mysqli_query($connection, $updateRoomQuery);

            echo "<script>";
            echo "alert('Booking Successful');";
            echo "window.location = 'roomList.php';";
            echo "</script>";
        } else {
            echo 'Sorry, something went wrong. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Basic Styling */
        html, body {
            background: linear-gradient(45deg, #49a09d, #5f2c82);
            height: 100%;
            width: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: -20px auto 0; /* Updated margin */
            padding: 15px;
            display: flex;
        }

/* Columns */
.left-column {
  width: 65%;
  position: relative;
}
 
.right-column {
  width: 35%;
  margin-top: 60px;
}

/* Left Column */
.left-column {
  width: 65%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}

.left-column img {
  max-width: 80%;
  max-height: 80%;
}

/* Product Description */
.room_description {
  border-bottom: 1px solid #E1E8EE;
  margin-bottom: 20px;
}
.room_description span {
  font-size: 15px;
  color: #358ED7;
  letter-spacing: 1px;
  text-transform: uppercase;
  text-decoration: none;
}
.room_description h1 {
  font-weight: 300;
  font-size: 52px;
  color: white;
  letter-spacing: -2px;
}
.room_description p {
  font-size: 16px;
  font-weight: 300;
  color: #c0c0c0;
  line-height: 24px;
}

.inside {
  margin-bottom: 20px;
}
  
.part {
  border-bottom: 1px solid #E1E8EE;
  margin-bottom: 20px;
}

.price {
  display: flex;
  align-items: center;
}
 
.price span {
  font-size: 26px;
  font-weight: 300;
  color: #c0c0c0;
  margin-right: 20px;
}
 
.book_btn {
  margin-left: 20px;
  display: inline-block;
  background-color: #7DC855;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  color: #FFFFFF;
  text-decoration: none;
  padding: 12px 30px;
  transition: all .5s;
}
.book_btn:hover {
  background-color: teal;
}

.cancel_btn {
  display: inline-block;
  background-color: red;
  border-radius: 6px;
  border: none;
  font-size: 16px;
  color: #FFFFFF;
  text-decoration: none;
  padding: 12px 30px;
  transition: all .5s;
}
.cancel_btn:hover {
  background-color: orange;
}
    </style>
</head>
<body>
<main class="container">
 
 <!-- Left Column / Headphones Image -->
 <div class="left-column">
 <img src="data:image;base64,<?php echo base64_encode($row['room_image']); ?>" alt="Room Image">
 <!-- <?php echo $encodedImage; ?> -->
 </div>


 <!-- Right Column -->
 <div class="right-column">
 <form action="#" method="POST" onsubmit="return validateForm()">
   <!-- Product Description -->
   <div class="room_description">
     <span><?php echo $_SESSION['hotelID'];?> <?php echo $_SESSION['hotelName'];?></span>
     <input type="hidden" name="hotelID" value="<?php echo $_SESSION['hotelID'];?>">
     <h1><?php echo $roomID; ?><input type="hidden" name="roomID" value="<?php echo $roomID;?>"></h1>
     <p>
        Room Type: <?php echo $row['room_type']; ?> <br/>
        Room Price/Day : RM<?php echo $row['room_price']; ?>
    </p>
   </div>

   <!-- Product Configuration -->
   <div class="product-configuration">
   <div class="part">
       <span>Customer Name</span>
       <div class="inside">
            <select name="customerID" onchange="fetchCustomerId(this)">
                <?php foreach ($customerData as $customer) { ?>
                    <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['customer_name']; ?></option>
                <?php } ?>
            </select>
       </div>
     </div>

     <div class="part">
     <span>Check In Date</span>
         <div class="inside">
            <input type="date" id="checkin" name="checkin" onchange="calculateDays()">
        </div>  

       <span>Check Out Date</span>
       <div class="inside">
            <input type="date" id="checkout" name="checkout" onchange="calculateDays()">
       </div>
       </div>

     <div class="part">
         <span>Day: </span> <span id="dayDisplay"></span>
         <div>
         <input type="hidden" id="day" name="day" readonly>
        </div>  

        <span>Total Room Price: RM</span><span id="totalRoomPriceDisplay"><?php echo $totalRoomPrice; ?></span>
       <div>
       <input type="hidden" id="totalRoomPrice" name="totalRoomPrice" value="<?php echo $totalRoomPrice; ?>" readonly>
       </div>

       <span>Service Tax(10%): RM</span><span id="serviceTaxDisplay"></span>
        <div class="inside">
            <input type="hidden" id="serviceTax" name="serviceTax" readonly>
        </div> 
       </div>

   <div class="price">
     <span>RM</span><span id="totalDisplay"></span>
    <input type="hidden" id="total" name="totalVal" readonly>

     <input type="button" value="Back" onclick="history.back()" class="cancel_btn">
     <input type="submit" value="Book" name="btnBook" class="book_btn">
   </div>
                </form>
 </div>
</main>

<script>
        function fetchCustomerId(select) {
            var selectedOption = select.options[select.selectedIndex];
            var customerName = selectedOption.value;
            var customerIdInput = document.getElementById("customerID");
            customerIDInput.value = customerID;
        }

        
        function calculateDays() {
            var checkin = new Date(document.getElementById("checkin").value);
            var checkout = new Date(document.getElementById("checkout").value);
            var timeDiff = checkout.getTime() - checkin.getTime();
            var dayDiff = Math.ceil((timeDiff / (1000 * 3600 * 24)) + 1);
            if (!isNaN(dayDiff) && dayDiff >= 0) {
                document.getElementById("day").value = dayDiff;
                document.getElementById("dayDisplay").textContent = dayDiff + (dayDiff === 1 ? " day" : " days");
            } else {
                document.getElementById("day").value = "";
                document.getElementById("dayDisplay").textContent = "";
            }
            calculateTotalRoomPrice();
        }

        function calculateTotalRoomPrice() {
            var roomPrice = <?php echo $row['room_price']; ?>;
            var day = parseInt(document.getElementById("day").value);
            var totalRoomPrice = 0;
            var serviceTaxRate = 0.1;

            if (!isNaN(day) && day >= 0) {
                totalRoomPrice = roomPrice * day;
                var formattedTotalRoomPrice = totalRoomPrice.toFixed(2);
                var serviceTax = totalRoomPrice * serviceTaxRate;
                var total = totalRoomPrice + serviceTax; // Calculate the total

                document.getElementById("totalRoomPriceDisplay").textContent = formattedTotalRoomPrice;
                document.getElementById("serviceTax").value = serviceTax.toFixed(2);
                document.getElementById("serviceTaxDisplay").textContent = serviceTax.toFixed(2);
                document.getElementById("total").value = total.toFixed(2); // Set the total value
                document.getElementById("totalDisplay").textContent = total.toFixed(2); // Display the total
            } else {
                document.getElementById("totalRoomPriceDisplay").textContent = "";
                document.getElementById("serviceTax").value = "";
                document.getElementById("serviceTaxDisplay").textContent = "";
                document.getElementById("total").value = "";
                document.getElementById("totalDisplay").textContent = ""; // Clear the total display
            }
        }

        function validateForm() {
            var checkin = document.getElementById("checkin").value;
            var checkout = document.getElementById("checkout").value;

            if (checkin === "" || checkout === "") {
                alert("Please select check-in and check-out dates.");
                return false;
            }

            var checkinDate = new Date(checkin);
            var checkoutDate = new Date(checkout);

            if (checkoutDate <= checkinDate) {
                alert("Check-out date cannot be before the check-in date.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>