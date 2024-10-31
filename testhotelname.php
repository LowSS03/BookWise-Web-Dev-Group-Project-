<?php

    $gendertype = "";
    if(isset($_POST['price'])){

        $gendertype = $_POST['price'];
        echo $gendertype;
        
    }

    if ($gendertype == "Below 200"){
        echo "now is 200";
        header("Location: price1.php");
    }else if($gendertype == "Below 300"){
        header("Location: price2.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method = "post">
        

        <p><input type="radio" name="price" value="Below 200" id="">Below RM200</p>
        <p><input type="radio" name="price"  value=300 id="">Below RM300</p>
        <p><input type="radio" name="price" value=400 id="">Below RM400</p>
        <p><input type="radio" name="price" value=500 id="">Below RM500</p>
        <input type="submit" name = "submit" value="Submit">
        <button type="button" onclick = "clearSelection('price');">Clear </button>

    </form>

    <script>
        const clearSelection = (name) => {
            const radioBtns = document.querySelectorAll(
                "input[type='radio'][name='" + name + "']"
            );
            radioBtns.forEach((radioBtn) => {
                if (radioBtn.checked === true) radioBtn.checked = false;
            });
        };
    </script>
</body>
</html>