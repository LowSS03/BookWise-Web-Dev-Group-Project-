<!DOCTYPE html>
<html>
<head>
  <title>Hotel Reservation</title>
  <style>
    .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
    }

    .form-group input[type="date"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .form-group input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Hotel Reservation</h2>
    <form>
      <div class="form-group">
        <label for="check-in-date">Check-in Date:</label>
        <input type="date" id="check-in-date" name="check-in-date" required>
      </div>
      <div class="form-group">
        <label for="check-out-date">Check-out Date:</label>
        <input type="date" id="check-out-date" name="check-out-date" required>
      </div>
      <input type="submit" value="Submit">
    </form>
  </div>
</body>
</html>
