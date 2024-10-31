

<?php

include("dbConn.php");
    $hotelname = "";
    $hotelcity = "";
    $hotelname = $_POST["hotelnametf"];
    $cityname = $_POST["cityselect"];
    $query = "";


    echo $hotelname;
    echo $cityname;

   

    

    if($cityname == "" && $hotelname == ""){
        header("Location: viewhotel.php");
    }else  if(!$hotelname == "" && $cityname == ""){
        echo "nohotel";
        
        $query = "SELECT * ,  MIN(room.room_price) AS price
        FROM hotel
INNER JOIN room ON room.hotel_id=hotel.hotel_id
WHERE hotel_name LIKE '%$hotelname%'
GROUP BY hotel.hotel_id";






    }else if(!$cityname == "" && $hotelname == ""){
        echo "nocity";
        $query = "SELECT * ,  MIN(room.room_price) AS price
        FROM hotel
INNER JOIN room ON room.hotel_id=hotel.hotel_id
WHERE hotel.state = '$cityname'
GROUP BY hotel.hotel_id";
    }else if(!$cityname == "" && !$hotelname == ""){
        echo "allright";
        $query = "SELECT * ,  MIN(room.room_price) AS price
        FROM hotel
INNER JOIN room ON room.hotel_id=hotel.hotel_id
WHERE hotel_name LIKE '%$hotelname%' AND hotel.state = '$cityname'
GROUP BY hotel.hotel_id
";
    }

    $result = mysqli_query($connection, $query);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #datepicker{

            margin-left: 20%;
            margin-right: 20%;
            margin-top: 30px;
            margin-bottom: 30px;
            
            height: 100px;
        }

        .content{
            padding-top: 30px;
            padding-bottom: 30px;
            text-align: center;
            border: 2px solid yellow;
        }
        #datefield{
            
            height: 30px;
            width: 200px;
            margin-right: 20px;
            margin-left: 20px;
        }

        #citylabel{
            margin-right: 20px;
            width: 200px;
            height: 30px;
        }

        #hotelcontent{
            margin-bottom: 10px;
            height: 30%;
            width: 60%;
            float: right;
            margin-right: 5%;
            border: 5px solid rgba(160, 203, 229, 0.8);
        }
        
        #imageposition{
            float: left;
        }

        #hoteldes{
            float: right;
        }

        img {
  float: left;
  padding-left: 20px;
  padding-bottom: 20px;
  padding-right: 30px;
}

#contentright{
    float:right;
}

span{
    padding-left: 10px;
    padding-right: 20px;
}
#button{
    margin-right: 20px;
    background-color: rgba(76, 68, 239, 0.8);
    /* color: yellow;
    width: 150px; */
    padding: 5px 10px 5px 10px;
    text-align:center;
    border-radius: 2.5px;
    color: white;
}

a{
    color: white;
    text-decoration: none;
}

#filter{
    margin-left: 5%;
    background-color: blue;
    width: 20%;
    height: 300px;
}


    </style>
</head>
<body>
    <div id="datepicker">
        
    <form action="headerfilter.php" method="post">
<div class="content">
            <label for="city" id = ""citylabel>Choose the City:</label>
                <select name="cityselect" id="citylabel">
                    <option value="">Please Select The City:</option>
                    <option value="penang">Penang</option>
                    <option value="perak">Perak</option>
                    <option value="selangor">Selangor</option>
                    <option value="kl">Kuala Lumpur</option>
                    <option value="johor">Johor</option>
                    <option value="malacca">Malacca</option>
                    <option value="kedah">Kedah</option>
                    <option value="negeri">Negeri Sembilan</option>
                </select>
                            <label for="hotelnamelabel">Hotel Name: </label>
        <input id = "hotelf" type="text" name="hotelnametf">
        <input id = "search" type="submit" value = "Search">
</form>
       
        </div>
    </div>

    <?php 
 

        while($row = mysqli_fetch_assoc($result)){
    ?>
    <div id="hotelcontent">
       
       <p><img src="data:image;base64,<?php echo base64_encode($row['hotel_image']); ?>" alt="Hotel Image" height="100" width="100"></p>
       <p name = "hotelname"><?php echo $row['hotel_name']; ?></p>
       <!-- <input type="hidden" name="HotelID" value="<?php echo $row['booking_id'];?>"> -->
       <p><?php echo $row['hotel_email']; ?></p>
       <p></p>
   
       <div id="contentright">
       <?php echo $row['price']; ?><span><a id="button" href="room.php?hotelID=<?php echo $row['hotel_id']; ?>" class=”button”> Check Availability </a></span>
           <!-- <div id="button"><p><a href="testhotelname.php">See Availability</a></p></div> -->
           <!-- <input id = "button" type="submit" value="See Availability"></input> -->
           
       </div>
   
   
       </div>
    <?php 
}
mysqli_close($connection);

 ?>

    <div id="filter">
    <p><b>Filter By:</b></p>
    <hr>
    <p><b>Price:</b></p>
    <form action="" method = "post">
        

        <p><input type="radio" name="price" value="Below 200" id="">Below RM200</p>
        <p><input type="radio" name="price"  value="Below 300" id="">Below RM300</p>
        <p><input type="radio" name="price" value="Below 400" id="">Below RM400</p>
        <p><input type="radio" name="price" value="Below 500" id="">Below RM500</p>
        <p><input type="radio" name="price" value="Above 500" id="ss">Above RM500</p>
        <input type="submit" name = "submit" value="Submit">
        <button type = "button" onclick="back()">Clear</button>

        <script>
        function back(){
            location.replace('viewhotel.php')
        
        }
    </script>

    </form>
    </div>
</body>
</html>