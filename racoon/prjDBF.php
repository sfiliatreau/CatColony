<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
      <!--
        Sarah Howard
        CSC 235
        Project 2 - Database Form
        prjDBF.php
        https://sarahhoward.site/sarah/prjDBF.php
        2021.11.14

        Credit: based on Lessons 3 and 4 from class (couldn't find author info)
        -->

    <title>Raccoon B&B Overstock Shop | Inventory</title>

    <meta name="description" content="Inventory for Raccoon B&B's Overstock Shop">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <?PHP
        //Set up constants for each table format
        define('PRODUCT', '0');
        define('DEPARTMENT', '1');
        define('MANUFACTURER', '2');
        define('COLOR', '3');

        $tableFormat = PRODUCT;
        $sql = "SELECT
                    p.name,
                    c.name,
                    p.price,
                    p.qtyOnHand,
                    p.url,
                    d.name,
                    d.manager,
                    m.name,
                    m.url
                FROM product p
                    JOIN color c ON c.id = p.color
                    JOIN department d ON d.id = p.department
                    JOIN manufacturer m ON m.id = p.manufacturer
                ORDER BY d.name ASC, p.name ASC";

        //Is this a return visit?
        if (array_key_exists('hidSubmitFlag', $_POST)) {
                // print_r($_POST);
                // echo '<br>';

            //display table based on selection
            if (isset($_POST['lstDisplay'])) {
                // Save item that was selected by user
                $selection = $_POST['lstDisplay'];
                //echo 'DEBUG $selection: ' . $selection . '<br>';

                switch ($selection) {
                    case "product": {
                            $tableFormat = PRODUCT;
                            $sql = "SELECT
                                        p.name,
                                        c.name,
                                        p.price,
                                        p.qtyOnHand,
                                        p.url,
                                        d.name,
                                        d.manager,
                                        m.name,
                                        m.url
                                    FROM product p
                                        JOIN color c ON c.id = p.color
                                        JOIN department d ON d.id = p.department
                                        JOIN manufacturer m ON m.id = p.manufacturer
                                    ORDER BY d.name ASC, p.name ASC";
                            break;
                        }
                    case "department": {
                            $tableFormat = DEPARTMENT;
                            $sql = "SELECT 
                                        name,
                                        manager
                                    FROM department";
                            break;
                        }
                    case "manufacturer": {
                            $tableFormat = MANUFACTURER;
                            $sql = "SELECT
                                        name,
                                        url
                                    FROM manufacturer";
                            break;
                        }
                    case "color": {
                        $tableFormat = COLOR;
                        $sql = "SELECT 
                                    name
                                FROM color";
                        break;
                    }
                    default:
                        echo $selection . ' is not a valid choice<br>';
                } // end of switch()
            } // end of if(isset())
        }

        //FUNCTIONS
        function displayData()
        {
            global $sql;
            global $tableFormat;
            // echo 'DEBUG: $sql: ' . $sql . '<br />';
            // Create a database object
            // PARAMETERS: server, user, password, database'
            $url = parse_url(getenv("CLEAR_DATABASE_URL"));

            $server = $url["host"];
            $username = $url["user"];
            $password = $url["pass"];
            $db = substr($url["path"], 1);

            $db = new mysqli($server, $username, $password, $db); //local
            //$db = new mysqli('sarahhoward.site', 'sarahhp6_web', '*DYmB2#$8F*b', 'sarahhp6_prjDBF'); //prod

            if ($db->connect_errno > 0) {
                die('Unable to connect to database [' . $db->connect_error . ']');
            }

            // Get the data from the database using SQL
            if (!$result = $db->query($sql)) {
                die('There was an error running the query [' . $db->error . ']');
            }

            // Display requested data

            switch ($tableFormat) {
                case PRODUCT: {
                        echo '<h2>Product</h2>';
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>Product Name</th>';
                        echo '<th>Color</th>';
                        echo '<th>Price</th>';
                        echo '<th>Qty On Hand</th>';
                        echo '<th>Product Page URL</th>';
                        echo '<th>Department</th>';
                        echo '<th>Manager</th>';
                        echo '<th>Manufacturer</th>';
                        echo '<th>Manufacturer Website</th>';
                        echo '</tr>';

                        while ($row = $result->fetch_array()) {
                            echo '<tr>';
                            echo '<td><strong>' . $row[0] . '</strong></td>';
                            echo '<td>' . $row[1] . '</td>';
                            echo '<td>' . $row[2] . '</td>';
                            echo '<td>' . $row[3] . '</td>';
                            $link = $row[4];
                            echo '<td><a href="' . $link . '" target="_blank">'
                                . $link . '</a></td>';
                            echo '<td>' . $row[5] . '</td>';
                            echo '<td>' . $row[6] . '</td>';
                            echo '<td>' . $row[7] . '</td>';
                            $link = $row[8];
                            echo '<td><a href="' . $link . '" target="_blank">'
                                . $link . '</a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        break;
                    }

                case DEPARTMENT: {
                        echo '<h2>Departments</h2>';
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>Department Name</th>';
                        echo '<th>Manager Name</th>';
                        echo '</tr>';

                        while ($row = $result->fetch_array()) {
                            echo '<tr>';
                            echo '<td>' . $row[0] . '</td>';
                            echo '<td>' . $row[1] . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        break;
                    }

                case MANUFACTURER: {
                        echo '<h2>Manufacturers</h2>';
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>Name</th>';
                        echo '<th>URL</th>';
                        echo '</tr>';

                        while ($row = $result->fetch_array()) {
                            echo '<tr>';
                            echo '<td>' . $row[0] . '</td>';
                            $link = $row[1];
                            echo '<td><a href="' . $link . '" target="_blank">'
                                . $link . '</a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        break;
                    }

                case COLOR: {
                        echo '<h2>Colors</h2>';
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>Name</th>';
                        echo '</tr>';
                    
                        while($row = $result->fetch_array( )){
                            echo '<tr>';
                            echo '<td>' . $row[0] . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        break;
                    }
                default:
                    echo $tableFormat . ' is not a valid table format.<br />';
            } // end of switch( )


            // show total results
            echo '<br />Total results: ' . $result->num_rows;

            // Close the database object
            $db->close();
        } // end of displayData( )
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

    <!-- Start Form -->
    <form name="frmDBF"
        action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>'
        method="POST">

        <fieldset id="fieldsetTableChoice">
        <legend>Choose which inventory information to view</legend>

            <label for="lstDisplay">Table:</label>
            <select name="lstDisplay" id="lstDisplay" onchange="this.form.submit()">
                <option value="none">Select a table</option>
                <option value="product">Product</option>
                <option value="department">Department</option>
                <option value="manufacturer">Manufacturer</option>
                <option value="color">Color</option>
            </select>
            <br>  


            <!-- submission flag -->
            <input type="hidden" name ="hidSubmitFlag" id="hidSubmitFlag" value="true">
            
            <!-- set up alternaitve button in case JS is not active -->
            <noscript>
                <br>
                <input type="submit" name="btnSubmit" value="View">
                <br><br>
            </noscript>

        </fieldset>
    </form>

    <?PHP displayData() ?>

    <h2>My Incremental Workflow</h2>
        <p>The following steps were taken to create this page:</p>
        <ol>
            <li>Created a basic sketch of the site on pen and paper</li>
            <li>Created a spreadsheet with the basic sample data</li>
            <li>Broke the large table into multiple tables to reach 1NF</li>
            <li>Loaded the sample data into MySQL database</li>
            <li>Wrote and verified the basic html code for the site</li>
            <li>Coded the basic PHP framework to make the db calls and populate the tables</li>
            <li>Filled out one table's SQL queries and PHP/HTML needed to display the data
                <ol>
                    <li>Tested each table display before moving on to the next</li>
                </ol>
            </li>
            <li>Asked my husband to QA the final page</li>
            <li>Made code/style adjustments based on feedback</li>
            <li>Published page</li>
        </ol>
    
    </main>

    <footer>
    <p><small>Sarah Howard | CSC 235 | prjDBF | 2021.11.14</small></p>
    </footer>

    </div>

</body>

</html>