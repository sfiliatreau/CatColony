<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
      <!--
        Sarah Howard
        CSC 235
        Project 3 - CRUD
        dbfJoin.php
        2022.04.03

        Credit: based on Lessons 5 and 6 from class (couldn't find author info)
        -->

    <title>Raccoon B&B Overstock Shop | Inventory</title>

    <meta name="description" content="Inventory for Raccoon B&B's Overstock Shop">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <?PHP
       // Set up logging constants - edit to change verbosity
       define("ECHO_SUCCESS", true);
       define("ECHO_SQL", false);
       
       // Set up connection constants
       // LOCAL
       define("SERVER_NAME", "localhost");
       define("DBF_USER_NAME", "root");
       define("DBF_PASSWORD", "mysql");
       define("DBF_DATABASE", "raccoonBnB");

       /*// PROD
           define("SERVER_NAME", "http://us-cdbr-east-05.cleardb.net");
           define("DBF_USER_NAME", "bceaf6f174ba2d");
           define("DBF_PASSWORD", "f5b37b09");
           define("DBF_DATABASE", "raccoonBnB");
       */

        // Create connection object
        $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        // Select the database
        $conn->select_db(DBF_DATABASE);

        /********************************************
         * displayResult( ) - Execute a query and display the result
         * Parameters: $rs  - Result set to display as 2D array
         *             $sql - SQL string used to display an error msg
         ********************************************/
        function displayResult($result, $sql) {
          if ($result->num_rows > 0) {
              echo "<table border='1'>\n";
              //print heading (field names)
              $heading = $result->fetch_assoc();
              echo "<tr>\n";
              //print field names as table headings
              foreach($heading as $key=>$value) {
                  echo "<th>" . $key . "</th>\n";
              }
              echo "</tr>\n";
          
              //print the values for the first row
              echo "<tr>";
              foreach($heading as $key=>$value) {
                  echo "<td>" . $value . "</.td>\n";
              }
              // output rest of the records
              while($row = $result->fetch_assoc()) {
                  //print_r($row);
                  //echo "<br />";
                  echo "<tr>\n";
                  // print data
                  foreach($row as $key=>$value) {
                      echo "<td>" . $value . "</td>\n";
                  }
                  echo "</tr>\n";
              }
              echo "</table>\n";
          // No results
          } else {
            echo "<strong>zero results using SQL: </strong>" . $sql;
          }
        
        } // end of displayResult( )

        /********************************************
        * runQuery( ) - Execute a query and display message
        *    Parameters:  $sql         -  SQL String to be executed.
        *                 $msg         -  Text of message to display on success or error
        *     ___$msg___ successful.    Error when: __$msg_____ using SQL: ___$sql____.
        *                 $echoSuccess - boolean True=Display message on success
        ********************************************/
        function runQuery($sql, $msg, $echoSuccess) {
        global $conn;
          
        // run the query
        if ($conn->query($sql) === TRUE) {
            if($echoSuccess) {
              echo $msg . " successful.<br />";
            }
        } else {
            echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
        }   
        } // end of runQuery( ) 
    ?>

  </head>


  <body>
      <!-- skip navigation link -->
      <a id="skipNav" href="#mainContent">Skip to main content</a>

    <div id="pageContainer">
    
      <header>
        <h2>Racoon B&B Employee Portal</h2>

        <nav>
          <ul>
            <li><a href="">Home</a></li>
            <li><a href="">Orders</a></li>
            <li><a href="">Inventory</a></li>
            <li><a href="">Help</a></li>
          </ul>
        </nav>

      </header>

    <!-- Start main HTML chunk -->
    <main id="mainContent">

    <h1>Overstock Inventory</h1>

    <h2>JOIN</h2>
    <pre> SELECT  p.productName, c.colorName, d.departmentName,
                  d.managerName, m.manufacturerName
          FROM product p
          JOIN color c ON c.id_color = p.id_color
          JOIN department d ON d.id_department = p.id_department
          JOIN manufacturer m ON m.id_manufacturer = p.id_manufacturer
    </pre>
    <?PHP $sql = "SELECT  p.productName, c.colorName, d.departmentName,
                  d.managerName, m.manufacturerName
          FROM product p
          JOIN color c ON c.id_color = p.id_color
          JOIN department d ON d.id_department = p.id_department
          JOIN manufacturer m ON m.id_manufacturer = p.id_manufacturer";
      $result = $conn->query($sql);
      displayResult($result, $sql);
      echo "<br />"; ?>
    
    <h2>LEFT OUTER JOIN</h2>
    <pre> SELECT d.departmentName, p.productName
          FROM department d
          LEFT JOIN product p ON p.id_department = d.id_department</pre>
    <?PHP $sql = "SELECT d.departmentName, p.productName
                  FROM department d
                  LEFT JOIN product p ON p.id_department = d.id_department";
      $result = $conn->query($sql);
      displayResult($result, $sql);
      echo "<br />"; ?>

    <h2>RIGHT OUTER JOIN</h2>
    <pre>SELECT p.productName, c.colorName
         FROM product p
         RIGHT JOIN color c ON c.id_color = p.id_color
    </pre>
    <?PHP $sql = "SELECT p.productName, c.colorName
         FROM product p
         RIGHT JOIN color c ON c.id_color = p.id_color";
      $result = $conn->query($sql);
      displayResult($result, $sql);
      echo "<br />"; ?>

    <h2>Description of JOINs</h2>
    <p>A JOIN (INNER JOIN) displays matching records for two or more tables.
      It will exclude data that has no match. This join is the most common. In
      our example, JOINs allow us to populate a complete inventory table while
      still conforming to DRY and normalization principles in the actual database.
    </p>
    <p>A LEFT JOIN will take all the records from the first (left) table and any
      matching records from the second (right) table. This is useful when you are
      critically interested in the data from the left table and don't want to lose
      it if it has no match. In our example, the left join allowed us to see a list
      of all departments and their products, even if a department had no products.
    </p>
    <p>A RIGHT JOIN is just the opposite of a LEFT JOIN. It shows all the data from
      the second (right) table, along with matching data from the first (left) table.
      In our example, we queried all products and their colors, as well as any other
      colors we had in the system (even if they were not currently in use).

    </p>

    </main>

    <footer>
    <p><small>Sarah Howard | CSC 235 | prjCRUD | 2022.04.03</small></p>
    </footer>

    </div>

</body>

</html>