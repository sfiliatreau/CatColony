<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
      <!--
        Sarah Howard
        CSC 235
        Project 3 - CRUD
        dbfCreate.php
        2022.04.03

        Credit: based on Lessons 4 and 5 from class (couldn't find author info)
        -->

    <title>Raccoon B&B Overstock Shop | Inventory</title>

    <meta name="description" content="Utility to create Raccoon Inn Overstock Shop Sample Database">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <?PHP
        // Set up logging constants - edit to change verbosity
        define("ECHO_SUCCESS", true);
        define("ECHO_SQL", false);
        
        // Set up connection constants
        /*// LOCAL
        define("SERVER_NAME", "localhost");
        define("DBF_USER_NAME", "root");
        define("DBF_PASSWORD", "mysql");
        */
        // PROD
           define("SERVER_NAME", "http://us-cdbr-east-05.cleardb.net");
           define("DBF_USER_NAME", "bceaf6f174ba2d");
           define("DBF_PASSWORD", "f5b37b09");
           define("DBF_DATABASE", "raccoonBnB");
        

        // Create server connection object
        $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }

    /********************************************
    * createDatabase($dbName)
    * Parameters      $dbName - string - name of database to create
    ********************************************/
    function createDatabase($dbName) {
        global $conn;

        // Check if db already exists
        $sql = "SELECT SCHEMA_NAME
                FROM INFORMATION_SCHEMA.SCHEMATA
                WHERE SCHEMA_NAME = '$dbName'";
        if ($result = $conn->query($sql)) {
            $row_count = $result->num_rows;
            // if db already exists, drop it.
            if ($row_count > 0) {
                $sql = "DROP DATABASE $dbName";
                runQuery($sql, "DROP $dbName", ECHO_SQL, ECHO_SUCCESS);
            } // end if($row_count...)
        } // end if($result...)

        // Create new db
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        runQuery($sql, "Creating $dbName...", ECHO_SQL, ECHO_SUCCESS);

        // Select the database
        $conn->select_db($dbName);
    }
    /********************************************
    * createTable()
    * Creates sample tables for database
    ********************************************/
    function createTable() {
      global $conn;

        // Create Table:color
        $sql = "CREATE TABLE IF NOT EXISTS color (
          id_color    INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          colorName   VARCHAR(25) NOT NULL
          )";

        runQuery($sql, "Table:color", ECHO_SQL, ECHO_SUCCESS);
      
      // Create Table:department
        $sql = "CREATE TABLE IF NOT EXISTS department (
            id_department     INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            departmentName    VARCHAR(25) NOT NULL,
            managerName       VARCHAR(100) NOT NULL
            )";
        runQuery($sql, "Table:race", ECHO_SQL, ECHO_SUCCESS);
    
      // Create Table:manufacturer
        $sql = "CREATE TABLE IF NOT EXISTS manufacturer (
            id_manufacturer     INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            manufacturerName    VARCHAR(25) NOT NULL,
            manufacturerURL     VARCHAR(255) NOT NULL
            )"; 
        runQuery($sql, "Table:manufacturer", ECHO_SQL, ECHO_SUCCESS);
      
      // Create Table:product
        $sql = "CREATE TABLE IF NOT EXISTS product (
            id_product    INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            productName   VARCHAR(25) NOT NULL,
            id_color      INT(6),
            price         FLOAT(4,2),
            qtyOnHand     MEDIUMINT,
            id_department INT(6),
            id_manufacturer INT(6)
            )";
        runQuery($sql, "Table:product", ECHO_SQL, ECHO_SUCCESS);
    }
    /********************************************
     * displayResult( ) - Execute a query and display the result
     * Parameters: $result - Result set to display as 2D array
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
    * displayTable() - displays a full table from db
    * Parameters      $tableName - string name of desired table
    ********************************************/
    function displayTable($tableName) {
      global $conn;

      $sql = "SELECT * FROM " . $tableName;
      $result = $conn->query($sql);

      displayResult($result, $sql);

    } // end of displayTable()


    /********************************************
    * populateTable()
    * Populates sample data for tables in createTable()
    ********************************************/
    function populateTable() {
      global $conn;

      // Populate Table:color
      $colorArray = array("black", "white", "clear", "multi");
      foreach($colorArray as $color) {
        $sql = "INSERT INTO color (colorName) VALUES ('" . $color . "')";
        runQuery($sql, "Creating record " . $color, ECHO_SQL, ECHO_SUCCESS);
      }

      // Populate Table:department
      $departmentArray = array(
        array("Bath", "Liz Tabor"),
        array("Kitchen", "John Fritz"),
        array("Bedroom", "Michael Howard"),
        array("Closet", NULL)
      );
      foreach($departmentArray as $department) {
        $sql = "INSERT INTO department (departmentName, managerName)
                VALUES('"
                . $department[0] . "', '"
                . $department[1] . "')";
        runQuery($sql, "Creating record " . $department[0], ECHO_SQL, ECHO_SUCCESS);
      }
      // Populate Table:manufacturer
      $manufacturerArray = array (
        array("Cannon", "https://www.cannonhome.com/"),
        array("InterDesign", "https://idesignlivesimply.com/"),
        array("LinenSpa", "https://www.linenspa.com/"),
        array("West Elm", "https://www.westelm.com/")
      );
      foreach($manufacturerArray as $manufacturer) {
        $sql = "INSERT INTO manufacturer (manufacturerName, manufacturerURL)
                VALUES('"
                . $manufacturer[0] . "', '"
                . $manufacturer[1] . "')";
        runQuery($sql, "Creating record " . $manufacturer[0], ECHO_SQL, ECHO_SUCCESS);
      }

      // Populate Table:product
      $productArray = array (
        array("Bath Towel",1,5.75,75,1,1),
        array("Wash Cloth",2,0.99,225,1,1),
        array("Shower Curtain",2,11.99,73,1,3),
        array("Pantry Organizer",3,3.99,52,2,2),
        array("Storage Jar",3,5.99,18,2,3),
        array("Firm Pillow",2,12.99,24,3,2)
      );
      foreach($productArray as $product) {
        $sql = "INSERT INTO product (productName, id_color, price, qtyOnHand, id_department, id_manufacturer)
                VALUES('"
                . $product[0] . "', '"
                . $product[1] . "', '"
                . $product[2] . "', '"
                . $product[3] . "', '"
                . $product[4] . "', '"
                . $product[5] . "')";
        runQuery($sql, "Creating record " . $product[0], ECHO_SQL, ECHO_SUCCESS);
      }
    }
    /********************************************
    * runQuery( ) - Execute a query and display message
    *    Parameters:  $sql         -  SQL String to be executed.
    *                 $msg         -  Text of message to display on success or error
    *     ___$msg___ successful.    Error when: __$msg_____ using SQL: ___$sql____.
    *                $echoSQL      -   boolean True=display sql message 
    *                $echoSuccess  -   boolean True=Display message on success
    ********************************************/
    function runQuery($sql, $msg, $echoSQL, $echoSuccess) {
    global $conn;

    //run the query
    if ($conn->query($sql) === TRUE) {
        if ($echoSQL) {
            echo "----\$sql string is: " . $sql . "<br>";
        }    
        if($echoSuccess) {
            echo $msg . " successful.<br>";
        } 
    } else {
            echo "<strong>Error when: " . $msg . "</strong> using SQL: "
                . $sql . "<br>";
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

    <h1>Overstock Inventory - Database Creation</h1>
    <p>
        <?PHP 
            createDatabase("raccoonBnB");
            createTable();
            populateTable();
            echo "<h2>Product</h2>";
            displayTable("product");
            echo "<h2>Department</h2>";
            displayTable("department");
            echo "<h2>Manufacturer</h2>";
            displayTable("manufacturer");
            echo "<h2>Color</h2>";
            displayTable("color");
        ?>
    </p>

    
    </main>

    <footer>
    <p><small>Sarah Howard | CSC 235 | prjCRUD | 2022.04.03</small></p>
    </footer>

    </div>

</body>

</html>
