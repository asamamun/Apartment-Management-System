<!DOCTYPE html>
<html>
<head>
    <title>Date Range Search</title>
    <style>
        table,tr,th,td{
           border: 1px solid black;
           border-collapse: collapse;
           margin: 0 auto;
        }
    </style>
</head>
<body>
    <h2>Date Range Search</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        From: <input type="date" name="start_date">
        To:<input type="date" name="end_date">
        <input type="submit" name="search" value="Search">
    </form>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "housing_society";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        // Validate input
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        if ($start_date > $end_date) {
            echo "End date must be after start date.";
            exit();
        }

        // Construct SQL query
        $sql = "SELECT * FROM visitors WHERE entry_time BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display results
            echo "<h3>Search Results:</h3>";
            echo "<table border='1'>";
            echo "<tr>
                  <th>ID</th>
                  <th>apt_id </th>
                  <th>visitor_name</th>
                  <th>address</th>
                  <th>persons</th>
                  <th>phone</th>
                  <th>purpose</th>
                  <th>entry_time</th>
                  <th>exit_time</th>
            </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["apt_id"]."</td>
                <td>".$row["visitor_name"]."</td>
                <td>".$row["address"]."</td>
                <td>".$row["persons"]."</td>
                <td>".$row["phone"]."</td>
                <td>".$row["purpose"]."</td>
                <td>".$row["entry_time"]."</td>
                <td>".$row["exit_time"]."</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }
    }
    $conn->close();
    ?>

</body>
</html>
