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

        $csvfile = fopen($csv_file, 'r');
        $theData = fgets($csvfile);

        #adding interviewer: Name of Interviewer, Agency
        $i = 0;//0
        while (!feof($csvfile)) {
          $csv_data[] = fgets($csvfile, 1024);
          $csv_array = explode(",", $csv_data[$i]);
          $insert_csv = array();
          
          $insert_csv['name_of_interviewer'] = $csv_array[0];
          $insert_csv['agency'] = $csv_array[1];

          //execute only if there is data: other wise blank row will be inserted at the last
          if($insert_csv['name_of_interviewer'] != '') {
            $query = "INSERT INTO interviewer(name,agency)
            VALUES(' " . $insert_csv['name_of_interviewer'] . "','" . $insert_csv['agency'] . "')";
            
            $n=mysql_query($query, $connect );
          }
          $i++;
        }//end while
        #adding interviewer complete

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