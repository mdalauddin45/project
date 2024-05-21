<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name" required> <br /><br />
        <label for="email">Email</label>
        <input type="email" name="email" required> <br /><br />
        <label for="mbl">Number</label>
        <input type="text" name="mbl" required> <br /><br />
        <input type="submit" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $servername = "localhost";
        $username = "root";
        $userpass = "123456";
        $database = "lab";

        $conn = new mysqli($servername, $username, $userpass, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $_POST['name'];
        $email =$_POST['email'];
        $mbl = $_POST['mbl'];

        $sql = "INSERT INTO users (name, email, number) VALUES ('$name', '$email', '$mbl')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
