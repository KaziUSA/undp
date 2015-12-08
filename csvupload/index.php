<html>
	<head>
		<title>CSV Upload</title>
		<style>
		.warning {color: red;}
		.success {color: green;}
		.form-control {
			margin-bottom: 10px;
		}
		</style>
	</head>
	<body>
		<form action="do_action.php" method="POST" enctype="multipart/form-data">
		  <p>Please upload csv format. <span class="warning">Please backup your database before uploading the csv. And check if the file you are going to upload is already present in uploads folder. If there is, then please delete that file if you want to reupload it.</span></p>

		  <div class="success">
		  	<p>Currently if you upload Round_3_Survey.csv which is present in /undp/csvupload/uploads:</p>
		  	<ul>
		  		<li>Name_of_interviewer, Agency will be uploaded in table:interviewer</li>
		  		<!--<li>Commented: Age will be uploaded in table:age</li>
		  		<li>Commented: Caste_Ethnicity will be uploaded in table:ethnicity</li>
		  		<li>Commented: Occupation will be uploaded in table:occupation</li>-->
		  	</ul>
		  </div>

		  <div class="form-control">
		  	<input type="file" name="fileToUpload" id="fileToUpload"> <span class="warning">Max Size: 10MB</span>
		  </div>

		  <div class="form-control">
		  	<input type="submit" name="submit" value="submit">
	  	</div>
		</form>
	</body>
</html>
