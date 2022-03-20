<?php
  // Tell server that you will be tracking session variables
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
      <!--
        Sarah Howard
        CSC 235
        Project 1
        index.php
        2022-03-20

        Credit: based on "Arrays, Sessions, and Forms" - Written by Peter K. Johnson
        https://webexplorations.com/
        -->
    <title>Cat Stats</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="stylesheet" href="styles/styles.css">
  </head>



  <body>
  <?php
    // The filename of the currently executing script to be used
    // as the action=" " attribute of the form element.
    $self = $_SERVER['PHP_SELF'];

    //Check to see if this is the first time viewing the page
    //The hidSubmitFlag will not exist if this is the first time
    if(array_key_exists('hidSubmitFlag', $_POST)) {
      echo "<h2>Welcome back!</h2>";
      //Look at the hidden submitFlag variable to determine what to do
      $submitFlag = $_POST['hidSubmitFlag'];
      /*echo("DEBUG: hidSubmitFlag is: $submitFlag<br>");
      echo("DEBUG: hidSubmitlFlag is type of: " . gettype($submitFlag) . "<br>");
      */
      //Get the array that was stored as a session variable
      $catArray = unserialize(urldecode($_SESSION['serializedArray']));

      switch($submitFlag) {
        case "01": addRecord(); break;
        case "99": deleteRecord(); break;
        default: displayCats($catArray);
      }
    }
    else {
      echo "<h2>Welcome to the Cat Stats Page</h2>";
      // Create the cat array
      $catArray = array ();
      
      $catArray[0][0] ="Bro";
      $catArray[0][1] ="Male";
      $catArray[0][2] ="2020-04-01";
      $catArray[0][3] ="DSH";
      $catArray[0][4] ="Black/White";
      $catArray[0][5] ="Yes";
      
      $catArray[1][0] ="Cheezy Puff";
      $catArray[1][1] ="Male";
      $catArray[1][2] ="2020-04-01";
      $catArray[1][3] ="DMH";
      $catArray[1][4] ="Buff Tabby";
      $catArray[1][5] ="Yes";

      $catArray[2][0] ="Smokey";
      $catArray[2][1] ="Female";
      $catArray[2][2] ="2019-01-01";
      $catArray[2][3] ="DSH";
      $catArray[2][4] ="Gray Tabby";
      $catArray[2][5] ="Yes";

      //Save this array as a serialized session variable
      $_SESSION['serializedArray'] = urlencode(serialize($catArray));
    }

    /*echo("DEBUG: catArray:");
    print_r($catArray);
    echo("<br /><br />");
    */

    /* =========================================
               Functions are alphabetical
      ========================================= */
      function addRecord( )
      {
        global $catArray;
        //Add the new info into the array
        //items stacked for readability
        $catArray[] = array(  $_POST['txtName'],
                              $_POST['txtSex'],
                              $_POST['txtDOB'],
                              $_POST['txtBreed'],
                              $_POST['txtColor'],
                              $_POST['txtSpayedNeutered']
                            );
        //the sort will be on the first column (cat name) so use this
        //to re-order the displays
        sort($catArray);
        //save the updated array in its session variable
        $_SESSION['serializedArray'] = urlencode(serialize($catArray));
      } // end of addRecord( )
      
      
      function deleteRecord( )
      {
          global $catArray;
          global $deleteMe;

          //Get the seleced index from the lstItem
          $deleteMe = $_POST['lstItem'];
          //Remove the selected index from the array
          unset($catArray[$deleteMe]);
          //Save the updated array in its session variable
          $_SESSION['serializedArray'] = urlencode(serialize($catArray));
          echo "<h2>Record deleted</h2>";
      } // end of deleteRecord( )
      
      
      function displayCats( )
      {
        global $catArray;
        echo '<table border="1">';
        
        // display the header
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Sex</th>';
        echo '<th>DOB</th>';
        echo '<th>Breed</th>';
        echo '<th>Color</th>';
        echo '<th>Spayed/Neutered?</th>';
        echo '</tr>';

        // walk through each record or row
        foreach($catArray as $record)
        { 
          echo '<tr>';
          //for each column in the row
          foreach($record as $value)
          {
            echo "<td>$value</td>";
          }
          echo "</tr>";
        }
        //stop the table
        echo '</table>';
      } // end of displayCats( )

  ?>

    <!-- skip navigation link -->
    <a id="skipNav" href="#main">Skip to main content</a>
    <header>
      <h1>Cat Stats</h1>
    </header>

    <main id="main">


      <h2>Current Cats:</h2><br>
      <p>
        <?php displayCats(); ?>
      </p>
    
      <!-- Add items -->
      <form action="<?php $self ?>"
        method="POST"
        name="frmAdd">
        <fieldset id="fieldsetAdd">
        <legend>Add a Cat</legend>

          <label for="txtName">Name:</label>
          <input type="text" name="txtName" id="txtName"
            value="Test Cat" />
          <br /><br />

          <label for="txtSex">Sex:</label>
          <input type="text" name="txtSex" id="txtSex"
            value="Female" />
          <br /><br />

          <label for="txtDOB">Date of Birth:</label>
          <input type="text" name="txtDOB" id="txtDOB"
            value="2020-04-01" size="10" />
          <br /><br />

          <label for="txtBreed">Breed:</label>
          <input type="text" name="txtBreed" id="txtBreed"
            value="Test Breed" />
          <br /><br />

          <label for="txtColor">Color:</label>
          <input type="text" name="txtColor" id="txtColor"
            value="Test Color" />
          <br /><br />

          <label for="txtSpayedNeutered">Spayed/Neutered?:</label>
          <input type="text" name="txtSpayedNeutered" id="txtSpayedNeutered"
            value="Yes" />
          <br /><br />

          <!-- This field is used to determine if the page has been viewed already.
                  Code 01 = Add
          -->
          <input type="hidden" name ="hidSubmitFlag" id="hidSubmitFlag" value="01">
          <input name="btnSubmit" type="submit" value="Add Cat">

        </fieldset>
      </form>

      <!-- Delete items -->
      <form action="<?php $self ?>"
        method="POST"
        name="frmDelete">
        <fieldset id="fieldsetDelete">
        <legend>Select a cat to delete:</legend>
          <select name="lstItem">
            <?php
              //populate the list box using data from the array
              foreach($catArray as $index => $lstRecord ) {
                //Make the value the index and the text displayed the
                //description from the array
                //The index will be used by deleteRecord()
                echo "<option value='" . $index . "'>" . $lstRecord[0]
                . "</option>\n";
              }
            ?>
          </select>

          <!-- This field is used to determine if the page has been
              viewed already. Code 99 = Delete
          -->
          <input type="hidden" name="hidSubmitFlag" id="hidSubmitFlag" value="99">
          <br>
          <br>
          <input name="btnSubmit" type="submit" value="Delete Cat" id=btndelete>
        </fieldset>
      </form>


    </main>

    <script src="scripts/scripts.js"></script>


  </body>

</html>