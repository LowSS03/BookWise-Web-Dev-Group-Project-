<?php
include 'dbConn.php';

function checkExistingData($connection, $query, $name, $email) {
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
        }
    }
    return "";
}

if (isset($_POST['registerBtn'])) {
    $userType = $_POST['userType'];
    $username = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    $phone = $_POST['userPhone'];

    $nameExistMessage = "";
    $emailExistMessage = "";

    if (empty($userType)) {
        echo '<script>alert("Please select the type of user.")</script>';
    } else {
        if ($userType === 'Customer') {
            $nameQuery = "SELECT `customer_name` FROM `customer` WHERE `customer_name` = '$username'";
            $emailQuery = "SELECT `customer_email` FROM `customer` WHERE `customer_email` = '$email'";

            $nameExistMessage = checkExistingData($connection, $nameQuery, $username, $email);
            $emailExistMessage = checkExistingData($connection, $emailQuery, $username, $email);
        } elseif ($userType === 'Hotel') {
            $nameQuery = "SELECT `hotel_name` FROM `hotel` WHERE `hotel_name` = '$username'";
            $emailQuery = "SELECT `hotel_email` FROM `hotel` WHERE `hotel_email` = '$email'";

            $nameExistMessage = checkExistingData($connection, $nameQuery, $username, $email);
            $emailExistMessage = checkExistingData($connection, $emailQuery, $username, $email);
        }

        if (!empty($nameExistMessage) || !empty($emailExistMessage)) {
            echo '<script>alert("Name Exist Please Try Another Name or Email Exist Please Try Another Email")</script>';
        } else {
            if ($userType === 'Customer') {
                $query = "INSERT INTO `customer` (`customer_name`, `customer_email`, `password`, `customer_notel`) VALUES ('$username', '$email', '$password', '$phone')";
            } elseif ($userType === 'Hotel') {
                $query = "INSERT INTO `hotel` (`hotel_name`, `hotel_email`, `hotel_password`, `hotel_notel`) VALUES ('$username', '$email', '$password', '$phone')";
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
</head>
<body>
    <h2>Welcome To Hotel Wise. Register An Account.</h2>
    <div>
        <form action="#" method="post">
            <table>
                <tr>
                    <td>Type of User:</td>
                </tr>
                <tr>
                    <td>
                        <select name="userType" id="userType" class="form-control">
                            <option value="">-----</option>
                            <option value="Customer">Customer</option>
                            <option value="Hotel">Hotel</option>
                        </select>
                    </td>
                </tr>

                <tr id="hotelImageRow" style="display: none;">
                    <td>Hotel Image:</td>
                </tr>
                <tr id="hotelImageInputRow" style="display: none;">
                    <td>
                        <img id="imagePreview" src="#" alt="Preview" height="175" width="175" style="display: none;"><br/>
                        <input type="file" name="hotelImage" onchange="previewImage(event)">
                    </td>
                </tr>

                <tr id="nameRow" style="display: none;">
                    <td>Name:</td>
                </tr>
                <tr id="nameInputRow" style="display: none;">
                    <td><input type="text" placeholder="Please Enter Your Name" name="userName"></td>
                </tr>

                <tr id="emailRow" style="display: none;">
                    <td>Email Address:</td>
                </tr>
                <tr id="emailInputRow" style="display: none;">
                    <td><input type="text" placeholder="Please Enter Your Email Address" name="userEmail"></td>
                </tr>

                <tr id="passwordRow" style="display: none;">
                    <td>Password:</td>
                </tr>
                <tr id="passwordInputRow" style="display: none;">
                    <td><input type="password" placeholder="Please Enter Your Password" name="userPassword"></td>
                </tr>

                <tr id="phoneRow" style="display: none;">
                    <td>Phone Number:</td>
                </tr>
                <tr id="phoneInputRow" style="display: none;">
                    <td><input type="text" placeholder="Please Enter Your Phone Number" name="userPhone"></td>
                </tr>

                <tr>
                    <td>
                        <button id="registerBtn" style="display: none;" type="submit" name="registerBtn" value="register">Register</button>
                        <button type="reset" name="cancelBtn" value="cancel">Cancel</button>
                    </td>
                </tr>
            </table>
        </form>
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
                registerBtn.style.display = 'none';
            }
        });
    </script>
</body>
</html>
