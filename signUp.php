<?php
include 'dbConn.php';

function checkExistingData($connection, $query, $name, $email, $phone, $address) {
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($row['customer_name']) && $row['customer_name'] === $name) {
                return "Name already exists. Please try another name.";
            }
            if (isset($row['customer_email']) && $row['customer_email'] === $email) {
                return "Email already exists. Please try another email.";
            }
            if (isset($row['hotel_name']) && $row['hotel_name'] === $name) {
                return "Name already exists. Please try another name.";
            }
            if (isset($row['hotel_email']) && $row['hotel_email'] === $email) {
                return "Email already exists. Please try another email.";
            }
            if (isset($row['hotel_notel']) && $row['hotel_notel'] === $phone) {
                return "Phone Number already exists. Please try another phone number for hotel.";
            }
            if (isset($row['address']) && $row['address'] === $address) {
                return "Address already exists. Please try another address.";
            }
        }
    }
    return "";
}

if (isset($_POST['registerBtn'])) {
    // Retrieve form data
    $userType = $_POST['userType'];
    $username = $_POST['userName'];
    $image = $_POST['hotelImage'];
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    $phone = $_POST['userPhone'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
    $state = $_POST['state'];

    // Check if required fields are empty
    if (empty($userType) || empty($username) || empty($email) || empty($password)) {
        echo '<script>alert("Please fill in all required fields.")</script>';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $username)) {
        echo '<script>alert("Username can only contain letters and spaces.")</script>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format. Please enter a valid email address.")</script>';
    } else {
        $nameExistMessage = "";
        $emailExistMessage = "";

        if ($userType === 'Customer') {
            $nameQuery = "SELECT `customer_name` FROM `customer` WHERE `customer_name` = '$username'";
            $emailQuery = "SELECT `customer_email` FROM `customer` WHERE `customer_email` = '$email'";

            $nameExistMessage = checkExistingData($connection, $nameQuery, $username, $email, $phone, $address);
            $emailExistMessage = checkExistingData($connection, $emailQuery, $username, $email, $phone, $address);
        } elseif ($userType === 'Hotel') {
            $nameQuery = "SELECT `hotel_name` FROM `hotel` WHERE `hotel_name` = '$username'";
            $emailQuery = "SELECT `hotel_email` FROM `hotel` WHERE `hotel_email` = '$email'";
            $phoneQuery = "SELECT `hotel_notel` FROM `hotel` WHERE `hotel_notel` = '$phone'";
            $addressQuery = "SELECT `address` FROM `hotel` WHERE `address` = '$address'";

            $nameExistMessage = checkExistingData($connection, $nameQuery, $username, $email, $phone, $address);
            $emailExistMessage = checkExistingData($connection, $emailQuery, $username, $email, $phone, $address);
            $phoneExistMessage = checkExistingData($connection, $phoneQuery, $username, $email, $phone, $address);
            $addressExistMessage = checkExistingData($connection, $addressQuery, $username, $email, $phone, $address);
        }

        if (!empty($nameExistMessage) || !empty($emailExistMessage)) {
            // Check if both name and email exist
            if (!empty($nameExistMessage) && !empty($emailExistMessage)) {
                echo '<script>alert("Name Exist Please Try Another Name or Email Exist Please Try Another Email")</script>';
            } elseif (!empty($nameExistMessage)) {
                echo '<script>alert("Name Exist Please Try Another Name")</script>';
            } elseif (!empty($emailExistMessage)) {
                echo '<script>alert("Email Exist Please Try Another Email")</script>';
            }
        } else {
            if ($userType === 'Customer') {
                $query = "INSERT INTO `customer` (`customer_name`, `customer_email`, `password`, `customer_notel`) VALUES ('$username', '$email', '$password', '$phone')";
                echo '<script>alert("Signup Successful")</script>';
                header("Location: Login.php");
            } elseif ($userType === 'Hotel') {
                $query = "INSERT INTO `hotel` (`hotel_name`, `hotel_image`,`hotel_email`, `hotel_password`, `hotel_notel`, `address`, `postcode`, `state`) VALUES ('$username', '$image', '$email', '$password', '$phone', '$address', '$postcode', '$state')";
                echo '<script>alert("Signup Successful")</script>';
                header("Location: Login.php");
            }

            if (mysqli_query($connection, $query)) {
                echo '<script>alert("Signup Successful")</script>';
                header("Location: Login.php");
            } else {
                echo '<script>alert("Sorry, something went wrong. Please try again.")</script>';
            }
        }
    }
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        .bg-image {
            background-image: url("image/klcc1.jpg");
            filter: blur(6px);
            -webkit-filter: blur(2px);
            height: 100%; 
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .login-container {
            background-image: url("image/klcc1.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            height: 85%;
            width: 80%;
            padding: 20px;
            text-align: center;
        }

        :root {
            --background-color: rgba(0, 0, 0, 0.4);
            --text-color: hsl(0, 0%, 100%);
        }

        .wrapper {
            margin-left: 15%;
            height: 35px;
            width: 70%;
            display: grid;
            place-content: center;
            background-color: var(--background-color);
            font-family: "Oswald", sans-serif;
            font-size: clamp(1.5625rem, 1.5234rem + 0.625vw, 1.875rem);
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-color);
        }

        .wrapper > div {
            grid-area: 1/1/-1/-1;
        }

        .top {
            clip-path: polygon(0% 0%, 100% 0%, 100% 48%, 0% 58%);
        }

        .bottom {
            clip-path: polygon(0% 60%, 100% 50%, 100% 100%, 0% 100%);
            color: transparent;
            background: -webkit-linear-gradient(177deg, black 53%, var(--text-color) 65%);
            background: linear-gradient(177deg, black 30%, var(--text-color) 65%);
            background-clip: text;
            -webkit-background-clip: text;
            transform: translateX(-0.02em);
        }

        .block{
            background-color: rgb(0, 0, 0, 0.5);
            overflow: auto;
            max-height: 90%;
            min-height: 90%;
        }

        .block::-webkit-scrollbar {
            display: none;
        }

        .form-control{
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #3498db;
            padding: 14px 0px;
            width: 230px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            cursor: pointer;
        }

        .form-control:focus{
            width: 280px;
            border-color: #2ecc71;
        }

        .form-control.has-value,
        .form-control:focus:not(:placeholder-shown) {
            color: white;
            background-color: rgb(0, 0, 0, 0.5);
        }

        option{
            text-align: center;
        }

        .image-block{
            height: 150px;
            width: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 170px;
            margin-top: 30%;
            margin-left: 62.5%;
        }

        .image {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .image-location{
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #3498db;
            padding: 14px 0px;
            width: 230px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            cursor: pointer;
        }

        .image-location:focus{
            width: 280px;
            border-color: #2ecc71;
        }

        .image-location.has-value,
        .image-location:focus:not(:placeholder-shown) {
            color: white;
            background-color: rgb(0, 0, 0, 0.5);
        }

        .name{
            height: 100px;
            background-color: transparent;
            width: 300px;
            text-align: center;
            margin-top: -40%;
            margin-left: 18%;
        }

        .email{
            height: 100px;
            background-color: transparent;
            width: 300px;
            text-align: center;
            margin-top: -10%;
            margin-left: 57%;
        }

        .password{
            height: 100px;
            background-color: transparent;
            width: 300px;
            text-align: center;
            margin-left: 18%;
        }

        .phone{
            height: 100px;
            background-color: transparent;
            width: 300px;
            text-align: center;
            margin-top: -10%;
            margin-left: 57%;
        }

        .address{
            height: 100px;
            background-color: transparent;
            width: 300px;
            text-align: center;
            margin-left: 18%;
        }

        .postcode{
            height: 100px;
            background-color: transparent;
            width: 300px;
            text-align: center;
            margin-left: 18%;
        }

        .state{
            height: 100px;
            background-color: transparent;
            width: 300px;
            text-align: center;
            margin-left: 18%;
        }

        ::placeholder{
            color: #00f2ff;
        }

        .buttons {
            display: flex;
            width: 380px;
            gap: 10px;
            --b: 2px;   /* the border thickness */
            --h: 1.8em; /* the height */
            margin-left: 35%;
        }

        .buttons button {
            /*--_c: #88C100;*/
            --_c: #2ecc71;
            flex: calc(1.25 + var(--_s,0));
            min-width: 50px;
            font-size: 15px;
            height: var(--h);
            cursor: pointer;
            color: var(--_c);
            border: var(--b) solid var(--_c);
            background: 
                conic-gradient(at calc(100% - 1.3*var(--b)) 0,var(--_c) 209deg, #0000 211deg) 
                border-box;
            clip-path: polygon(0 0,100% 0,calc(100% - 0.577*var(--h)) 100%,0 100%);
            padding: 0 calc(0.288*var(--h)) 0 0;
            margin: 0 calc(-0.288*var(--h)) 0 0;
            box-sizing: border-box;
            transition: flex .4s;
        }
        
        .buttons button + button {
            --_c: #FF003C;
            flex: calc(.75 + var(--_s,0));
            background: 
                conic-gradient(from -90deg at calc(1.3*var(--b)) 100%,var(--_c) 119deg, #0000 121deg) 
                border-box;
            clip-path: polygon(calc(0.577*var(--h)) 0,100% 0,100% 100%,0 100%);
            margin: 0 0 0 calc(-0.288*var(--h));
            padding: 0 0 0 calc(0.288*var(--h));
        }

        .buttons button:focus-visible {
            outline-offset: calc(-2*var(--b));
            outline: calc(var(--b)/2) solid #000;
            background: none;
            clip-path: none;
            margin: 0;
            padding: 0;
        }

        .buttons button:focus-visible + button {
            background: none;
            clip-path: none;
            margin: 0;
            padding: 0;
        }

        .buttons button:has(+ button:focus-visible) {
            background: none;
            clip-path: none;
            margin: 0;
            padding: 0;
        }

        button:hover,
        button:active:not(:focus-visible) {
            --_s: .75;
        }

        button:active {
            box-shadow: inset 0 0 0 100vmax var(--_c);
            color: #fff;
        }

        input[type=file]::file-selector-button {
            background: transparent;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type=file]::file-selector-button:hover {
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
        }

    </style>
</head>
<body>
<div class="bg-image"></div>
    <div class="login-container">
        <section class="wrapper">
            <div class="top">Welcome To BookWise. Register An Account.</div>
            <div class="bottom" aria-hidden="true">Welcome To BookWise. Register An Account.</div>
        </section>
        <div class="block">
        <form action="#" method="post">
                <h2>Type of User:</h2>
                <div class="select">
                        <select name="userType" id="userType" class="form-control">
                            <option value="">-----</option>
                            <option value="Customer">Customer</option>
                            <option value="Hotel">Hotel</option>
                        </select>
                </div>
                <div class="image-block">
                    <div id="hotelImageRow" style="display: none;">
                        <h2>Hotel Image:</h2>
                    </div>
                    <div id="hotelImageInputRow" style="display: none;">
                        <div class="image">
                            <img id="imagePreview" src="#" alt="Preview" height="100" width="100" style="display: none;"><br/>
                            <input class="image-location" type="file" name="hotelImage" onchange="previewImage(event)" style="margin-left: 20px;">
                        </div>
                    </div>
                </div>

                <div class="name">
                    <div id="nameRow" style="display: none;">
                        <h2>Name:</h2>
                    </div>
                    <div id="nameInputRow" style="display: none;">
                        <input class="form-control" type="text" placeholder="Please Enter Your Name" name="userName">
                    </div>
                </div>

                <div class="email">
                    <div id="emailRow" style="display: none;">
                        <h2>Email Address:</h2>
                    </div>
                    <div id="emailInputRow" style="display: none;">
                        <h2><input class="form-control" type="text" placeholder="Please Enter Your Email Address" name="userEmail"></h2>
                    </div>
                </div>

                <div class="password">
                    <div id="passwordRow" style="display: none;">
                        <h2>Password:</h2>
                    </div>
                    <div id="passwordInputRow" style="display: none;">
                        <h2><input class="form-control" type="password" placeholder="Please Enter Your Password" name="userPassword"></h2>
                    </div>
                </div>

                <div class="phone">
                    <div id="phoneRow" style="display: none;">
                        <h2>Phone Number:</h2>
                    </div>
                    <div id="phoneInputRow" style="display: none;">
                        <h2><input class="form-control" type="text" placeholder="Please Enter Your Phone Number" name="userPhone"></h2>
                    </div>
                </div>

                <div class="address">
                    <div id="addressRow" style="display: none;">
                        <h2>Address:</h2>
                    </div>
                    <div id="addressInputRow" style="display: none;">
                        <h2><input class="form-control" type="text" placeholder="Please Enter Your Address" name="address"></h2>
                    </div>
                </div>
    
                <div class="postcode">
                    <div id="postcodeRow" style="display: none;">
                        <h2>Postcode:</h2>
                    </div>
                    <div id="postcodeInputRow" style="display: none;">
                        <td><input class="form-control" type="text" placeholder="Please Enter Your Postcode" name="postcode"></td>
                    </div>
                </div>

                <div class="state">
                    <div id="stateRow" style="display: none;">
                        <h2>State:</h2>
                    </div>
                    <div id="stateInputRow" style="display: none;">
                        <td>
                            <select name="state" class="form-control">                    
                                <option value="Johor">Johor</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Kuala Lumpur">Kuala Lumpur</option>
                                <option value="Labuan">Labuan</option>
                                <option value="Melaka">Melaka</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Penang">Penang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Putrajaya">Putrajaya</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                            </select>
                        </td>
                    </div>
                </div>
                <br/>
                <br/>
                <br/>
                <div class="buttons">
                    <button id="registerBtn" style="display: none;" type="submit" name="registerBtn" value="register">Register</button>
                    <button type="reset" name="cancelBtn" value="cancel" onclick="window.location.href='homepage.php'">Cancel</button>
                </div>
        </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement = document.getElementById('imagePreview');
                imgElement.src = reader.result;
                imgElement.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        var userTypeSelect = document.getElementById('userType');
        userTypeSelect.addEventListener('change', function() {
            var hotelImageRow = document.getElementById('hotelImageRow');
            var hotelImageInputRow = document.getElementById('hotelImageInputRow');
            var nameRow = document.getElementById('nameRow');
            var nameInputRow = document.getElementById('nameInputRow');
            var emailRow = document.getElementById('emailRow');
            var emailInputRow = document.getElementById('emailInputRow');
            var passwordRow = document.getElementById('passwordRow');
            var passwordInputRow = document.getElementById('passwordInputRow');
            var phoneRow = document.getElementById('phoneRow');
            var phoneInputRow = document.getElementById('phoneInputRow');
            var addressRow = document.getElementById('addressRow');
            var addressInputRow = document.getElementById('addressInputRow');
            var postcodeRow = document.getElementById('postcodeRow');
            var postcodeInputRow = document.getElementById('postcodeInputRow');
            var stateRow = document.getElementById('stateRow');
            var stateInputRow = document.getElementById('stateInputRow');
            var registerBtn = document.getElementById('registerBtn');

            if (this.value === 'Customer') {
                hotelImageRow.style.display = 'none';
                hotelImageInputRow.style.display = 'none';
                nameRow.style.display = 'block';
                nameInputRow.style.display = 'block';
                emailRow.style.display = 'block';
                emailInputRow.style.display = 'block';
                passwordRow.style.display = 'block';
                passwordInputRow.style.display = 'block';
                phoneRow.style.display = 'block';
                phoneInputRow.style.display = 'block';
                addressRow.style.display = 'none';
                addressInputRow.style.display = 'none';
                postcodeRow.style.display = 'none';
                postcodeInputRow.style.display = 'none';
                stateRow.style.display = 'none';
                stateInputRow.style.display = 'none';
                registerBtn.style.display = 'block';
            } else if (this.value === 'Hotel') {
                hotelImageRow.style.display = 'block';
                hotelImageInputRow.style.display = 'block';
                nameRow.style.display = 'block';
                nameInputRow.style.display = 'block';
                emailRow.style.display = 'block';
                emailInputRow.style.display = 'block';
                passwordRow.style.display = 'block';
                passwordInputRow.style.display = 'block';
                phoneRow.style.display = 'block';
                phoneInputRow.style.display = 'block';
                addressRow.style.display = 'block';
                addressInputRow.style.display = 'block';
                postcodeRow.style.display = 'block';
                postcodeInputRow.style.display = 'block';
                stateRow.style.display = 'block';
                stateInputRow.style.display = 'block';
                registerBtn.style.display = 'block';
            } else {
                hotelImageRow.style.display = 'none';
                hotelImageInputRow.style.display = 'none';
                nameRow.style.display = 'none';
                nameInputRow.style.display = 'none';
                emailRow.style.display = 'none';
                emailInputRow.style.display = 'none';
                passwordRow.style.display = 'none';
                passwordInputRow.style.display = 'none';
                phoneRow.style.display = 'none';
                phoneInputRow.style.display = 'none';
                addressRow.style.display = 'none';
                addressInputRow.style.display = 'none';
                postcodeRow.style.display = 'none';
                postcodeInputRow.style.display = 'none';
                stateRow.style.display = 'none';
                stateInputRow.style.display = 'none';
                registerBtn.style.display = 'none';
            }
        });
    </script>

    <script>
        /* ===== Logic for creating fake Select Boxes ===== */
        $('.sel').each(function() {
        $(this).children('select').css('display', 'none');
        
        var $current = $(this);
        
        $(this).find('option').each(function(i) {
            if (i == 0) {
            $current.prepend($('<div>', {
                class: $current.attr('class').replace(/sel/g, 'sel__box')
            }));
            
            var placeholder = $(this).text();
            $current.prepend($('<span>', {
                class: $current.attr('class').replace(/sel/g, 'sel__placeholder'),
                text: placeholder,
                'data-placeholder': placeholder
            }));
            
            return;
            }
            
            $current.children('div').append($('<span>', {
            class: $current.attr('class').replace(/sel/g, 'sel__box__options'),
            text: $(this).text()
            }));
        });
        });

        // Toggling the `.active` state on the `.sel`.
        $('.sel').click(function() {
        $(this).toggleClass('active');
        });

        // Toggling the `.selected` state on the options.
        $('.sel__box__options').click(function() {
        var txt = $(this).text();
        var index = $(this).index();
        
        $(this).siblings('.sel__box__options').removeClass('selected');
        $(this).addClass('selected');
        
        var $currentSel = $(this).closest('.sel');
        $currentSel.children('.sel__placeholder').text(txt);
        $currentSel.children('select').prop('selectedIndex', index + 1);
        });
    </script>
</body>
</html>
