<?php
//source: http://www.infotuts.com/import-csv-file-data-in-mysql-php/
error_reporting(0);

$database = 'undp';

// path where your CSV file is located
define('CSV_PATH','uploads/');//C:/wamp/www/undp/uploads/

//upload file
//source: http://www.w3schools.com/php/php_file_upload.asp
$target_dir = "uploads/";

//create directory if not exist
if ( ! is_dir($target_dir)) {
  mkdir($target_dir);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

//database connect
$connect = mysql_connect('localhost','root','');
if (!$connect) {
die('Could not connect to MySQL: ' . mysql_error());
}

$cid = mysql_select_db($database, $connect); // supply your database name


//if(isset($_POST['submit'])) {
  //upload

  // Check if file already exists
  if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 10485760) {//10485760: 10MB
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "csv") {
      echo "Sorry, only CSV files are allowed.";
      $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $file_name = basename( $_FILES["fileToUpload"]["name"]);
        echo "The file ". $file_name . " has been uploaded.";

        //after uploading write to the database
        $csv_file = CSV_PATH . $file_name; // Name of your CSV file

        
        //added so commented for not adding again
        //uncomment the following code in production



        #adding Name of Interviewer, Agency in table:interviewer

        $csvfile = fopen($csv_file, 'r');
        $theData = fgets($csvfile);
        
        $csv_interviewer[] = [];//created empty array to store and check unique interviewer and add only those unique interviewer in database
        $query_retrive_interviewer = "SELECT name from interviewer";
        $retrived_interviewer = mysql_query($query_retrive_interviewer, $connect);
        while($row = mysql_fetch_assoc($retrived_interviewer)) {
          $csv_interviewer[] = $row['name'];
        }
        //print_r($csv_interviewer);
        //exit(0);

        $i = 0;//0
        while (!feof($csvfile)) {
          $csv_data[] = fgets($csvfile, 1024);
          $csv_array = explode(",", $csv_data[$i]);
          $insert_csv = array();
          
          $insert_csv['name_of_interviewer'] = $csv_array[0];
          $insert_csv['agency'] = $csv_array[1];

          //if(in_array($insert_csv['name_of_interviewer'], $csv_interviewer)) {
          if(!is_numeric(array_search($insert_csv['name_of_interviewer'], $csv_interviewer))) {
            //returns empty value if exists in array

            //add to table interviewer only if there interviewer is not present in array
            //execute only if there is data: other wise blank row will be inserted at the last
            if($insert_csv['name_of_interviewer'] != '') {
              $query = "INSERT INTO interviewer(name,agency)
              VALUES(' " . $insert_csv['name_of_interviewer'] . "','" . $insert_csv['agency'] . "')";
              
              $n=mysql_query($query, $connect );
            }
          
            //updating array after adding in database table
            $csv_interviewer[] = $insert_csv['name_of_interviewer'];
          }//end else

          $i++;//incrementing i to read new line
        }//end while

        //print_r($csv_interviewer);
        #adding interviewer complete

        
        
        #adding Age in table:age
        //we don't need this, there is alreay age group in database
        
        /*$csvfile = fopen($csv_file, 'r');//re-opening the file
        $theData = fgets($csvfile);
        $csv_age[] = [];//created empty array to store and check unique age group and add only those unique age_group in database
        $query_retrive_age = "SELECT name from age";
        $retrived_age = mysql_query($query_retrive_age, $connect);
        while($row = mysql_fetch_assoc($retrived_age)) {
          $csv_age[] = $row['name'];
        }
        //print_r($csv_age);
        //exit(0);

        $i = 0;//0
        while (!feof($csvfile)) {
          $csv_data[] = fgets($csvfile, 1024);
          $csv_array = explode(",", $csv_data[$i]);
          $insert_csv = array();
          
          $insert_csv['name_of_age'] = $csv_array[11];//O - A, 9 - J

          //if(in_array($insert_csv['name_of_age'], $csv_age)) {
          if(!is_numeric(array_search($insert_csv['name_of_age'], $csv_age))) {
            //returns empty value if exists in array

            //add to table age only if there age is not present in array
            //execute only if there is data: other wise blank row will be inserted at the last
            if($insert_csv['name_of_age'] != '') {
              $query = "INSERT INTO age(name)
              VALUES(' " . $insert_csv['name_of_age'] . " ') ";
              
              $n=mysql_query($query, $connect );
            }
          
            //updating array after adding in database table
            $csv_age[] = $insert_csv['name_of_age'];
          }//end else

          $i++;//incrementing i to read new line
        }//end while*/

        //print_r($csv_age);
        #adding Age group complete




        #adding Caste_ethnicity in table:ethnicity
        //we don't need this, there is already ethnicity
        
        /*$csvfile = fopen($csv_file, 'r');//re-opening the file
        $theData = fgets($csvfile);
        $csv_ethnicity[] = [];//created empty array to store and check unique ethnicity and add only those unique ethnicity in database
        $query_retrive_ethnicity = "SELECT name from ethnicity";
        $retrived_ethnicity = mysql_query($query_retrive_ethnicity, $connect);
        while($row = mysql_fetch_assoc($retrived_ethnicity)) {
          $csv_ethnicity[] = $row['name'];
        }
        //print_r($csv_ethnicity);
        //exit(0);

        $i = 0;//0
        while (!feof($csvfile)) {
          $csv_data[] = fgets($csvfile, 1024);
          $csv_array = explode(",", $csv_data[$i]);
          $insert_csv = array();
          
          $insert_csv['ethnicity'] = $csv_array[13];//O - A, 9 - J

          //if(in_array($insert_csv['name_of_ethnicity'], $csv_ethnicity)) {
          if(!is_numeric(array_search($insert_csv['ethnicity'], $csv_ethnicity))) {
            //returns empty value if exists in array

            //add to table ethnicity only if there ethnicity is not present in array
            //execute only if there is data: other wise blank row will be inserted at the last
            if($insert_csv['ethnicity'] != '') {
              $query = "INSERT INTO ethnicity(name)
              VALUES(' " . $insert_csv['ethnicity'] . " ') ";
              
              $n=mysql_query($query, $connect );
            }
          
            //updating array after adding in database table
            $csv_ethnicity[] = $insert_csv['ethnicity'];
          }//end else

          $i++;//incrementing i to read new line
        }//end while*/

        //print_r($csv_ethnicity);
        #adding ethnicity complete



        #adding Occupation in table:occupation
        //we don't need this, there is already occupation in database

        /*$csvfile = fopen($csv_file, 'r');//re-opening the file
        $theData = fgets($csvfile);
        $csv_occupation[] = [];//created empty array to store and check unique occupation and add only those unique occupation in database
        $query_retrive_occupation = "SELECT name from occupation";
        $retrived_occupation = mysql_query($query_retrive_occupation, $connect);
        while($row = mysql_fetch_assoc($retrived_occupation)) {
          $csv_occupation[] = $row['name'];
        }
        //print_r($csv_occupation);
        //exit(0);

        $i = 0;//0
        while (!feof($csvfile)) {
          $csv_data[] = fgets($csvfile, 1024);
          $csv_array = explode(",", $csv_data[$i]);
          $insert_csv = array();
          
          $insert_csv['occupation'] = $csv_array[15];//O - A, 9 - J, 15 - P

          //if(in_array($insert_csv['name_of_occupation'], $csv_occupation)) {
          if(!is_numeric(array_search($insert_csv['occupation'], $csv_occupation))) {
            //returns empty value if exists in array

            //add to table occupation only if there occupation is not present in array
            //execute only if there is data: other wise blank row will be inserted at the last
            if($insert_csv['occupation'] != '') {
              $query = "INSERT INTO occupation(name)
              VALUES(' " . $insert_csv['occupation'] . " ') ";
              
              $n=mysql_query($query, $connect );
            }
          
            //updating array after adding in database table
            $csv_occupation[] = $insert_csv['occupation'];
          }//end else

          $i++;//incrementing i to read new line
        }//end while*/

        //print_r($csv_occupation);
        #adding occupation complete

        


        fclose($csvfile);

        echo "File data successfully imported to database!!";
        mysql_close($connect);
        //import finish
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
  }

//}//end isset
?>