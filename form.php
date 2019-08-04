<html>

<head>
<link rel="stylesheet" type="text/css" href="form.css">
</head>


<body>
<!-- Q29weXJpZ2h0IDIwMTUgYnkgQW1leSBNaGFkZ3V0 -->

<?php
// define variables and set to empty values
$fname =$mname =$lname = $age= $gender = $address = $city =$pincode =$answer =$username =$questions = $email= $password1 =$password2 = $phone="";
$fnameErr =$mnameErr =$lnameErr = $ageErr= $genderErr = $addressErr = $cityErr =$pincodeErr =$answersErr =$usernameErr =$questionsErr = $emailErr= $cardnumErr=$passwordErr =$password1Err = $phoneErr="";

$count=15;
//db
$servername = "localhost";
$busername = "root";
$bpassword = "";
$dbname = "banking";




if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
if (empty($_POST["password1"])) {                                        //password
     $passwordErr = "*Password is empty";
   } else {
     $password1 = test_input($_POST["password1"]);
     $password2 = test_input($_POST["password2"]);
     if($password1!=$password2)
       {
         $passwordErr = "*Passwords do not match";
       }
      else
      {
       $count=$count-1;
      }
     
   } 


if(empty($_POST["phone"])) {                                        //phone
     $phoneErr = "*Phone number required";
   } else {
      $phone=test_input(test_input($_POST["phone"]));
if (!preg_match("/^[1-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/",$phone)) {
       $phoneErr = "*Invalid phone number"; 
}else
      {
       $count=$count-1;
      }
   } 

if(empty($_POST["cardnum"])) {                                        //phone
     $cardnumErr = "*Card number required to link with a/c";
   } else {
      $cardnum=test_input(test_input($_POST["cardnum"]));
if (!preg_match("/^[1-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/",$cardnum)) {
       $cardnumErr = "*Invalid card number"; 
}else
      {
       $count=$count-1;
      }
   } 


if (empty($_POST["fname"])) {                                        //fname
     $fnameErr = "*First name is required";
   } else {
     $fname = test_input($_POST["fname"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
       $fnameErr = "*Only letters and white space allowed"; 
     }else
      {
       $count=$count-1;
      }
   }

if (empty($_POST["username"])) {                                        //username
     $usernameErr = "*First name is required";
   } else {
     $username = test_input($_POST["username"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z0-9\-\.]*$/",$username)) {
       $usernameErr = "*Only letters and white space allowed"; 
     }else
      {
       $count=$count-1;
      }
   }

if (empty($_POST["mname"])) {                                        //mname
     $mnameErr = "*Middle name is required. Atleast Initials.";
   } else {
     $mname = test_input($_POST["mname"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$mname)) {
       $mnameErr = "*Only letters and white space allowed"; 
     }else
      {
       $count=$count-1;
      }
   }

if (empty($_POST["lname"])) {                                      //lname
     $lnameErr = "*Last name is required";
   } else {
     $lname = test_input($_POST["lname"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
       $lnameErr = "*Only letters and white space allowed"; 
     }else
      {
       $count=$count-1;
      }
   }

if(($_POST["age"])>150||($_POST["age"])<=0)                      //age
   {
  $ageErr ="*Invalid age";
   }
else
   {
  $age = test_input($_POST["age"]);
       $count=$count-1;
      
   }


if (empty($_POST["city"])) {                                        //city
     $cityErr = "*City is a required field";
   } else {
     $city = test_input($_POST["city"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$city)) {
       $cityErr = "*Invalid city name"; 
     }else
      {
       $count=$count-1;
      }
   }


   if (empty($_POST["email"])) {                                 // email
     $emailErr = "*Email is required";
   } else {
     $email = test_input($_POST["email"]);
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "*Invalid email format"; 
     }else
      {
       $count=$count-1;
      }
   }
     
 
   if (empty($_POST["address"])) {                              //address
     $addressErr = "*Address is required.";
   } else {
     $address = test_input($_POST["address"]);

       $count=$count-1;
   }

   if (empty($_POST["gender"])) {                                //gender
     $genderErr = "*Gender is required";
   } else {
     $gender = test_input($_POST["gender"]);

       $count=$count-1;
      
   }

if (empty($_POST["questions"])) {                                //questions
     $questionsErr = "*Security question is required";
   } else {
     $questions = test_input($_POST["questions"]);
      $count=$count-1;
      
   }
   
   if (empty($_POST["pincode"])) {                                //pincode
     $pincodeErr = "*Pincode is required";
   } else {
     $pincode = test_input($_POST["pincode"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[1-9][0-9][0-9][0-9][0-9][0-9]$/",$pincode)) {
       $pincodeErr = "*Invalid pincode"; 
     }else
      {
       $count=$count-1;
      }
   }

if (empty($_POST["answers"])) {                                        //answers
     $answersErr = "*Security question's answer is required";
   } else {
     $answers = test_input($_POST["answers"]);
 
       $count=$count-1;
      
     }
   
// Create connection
$conn = new mysqli($servername, $busername, $bpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}    
 
if($count==0)
{
$sql = "INSERT INTO users (fname,mname, lname,gender,age,address,city,pincode,username,password,s_quest,s_ans, email, phone,cardnum)
VALUES ('$fname' ,'$mname' ,'$lname',  '$gender ','$age','$address ', '$city' ,'$pincode ','$username' ,'$password1','$questions','$answer' ,'$email','$phone','$cardnum')";

if ($conn->query($sql) === TRUE) {
    echo "Account created successfully";
    header("Refresh:2; url=Main.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}

}


function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>


<div id="title">
<h1><img src="bank.jpg" alt="TSEC" width="200" height="150" align="left" ><br>Online banking</h1>
</div>
<!-- Q29weXJpZ2h0IDIwMTUgYnkgQW1leSBNaGFkZ3V0 -->

 <div id="signup">
<b>Sign-up</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="error">*all fields are required</span>
 </div>


 <form id="myform" name="myform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

  <div class="leftattribute">
  <b>Personal Details:</b><br>

  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;First Name:
  <input class="strings" id="fname" name="fname" type="text"><span class="error"><?php echo $fnameErr;?></span><br>
  

  <br>&nbsp;Middle Name:
  <input class="strings" id="mname" name="mname" type="text"><span class="error"><?php echo $mnameErr;?></span><br>
  
  
  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last Name:
  <input class="strings"  id="lname" name="lname" type="text"><span class="error"><?php echo $lnameErr;?></span><br>
 
  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender:&nbsp;<input type="radio" name="gender" value="M" >Male
  <input id="gender" type="radio" name="gender" value="F" >Female<span class="error"><?php echo $genderErr;?></span><br>

<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age:&nbsp;<input id="age" type="number" name="age"><span class="error"><?php echo $ageErr;?></span><br>

<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address:<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <textarea id="address" name="address" rows="2" cols="40">
</textarea><span class="error"><?php echo $addressErr;?></span><br>
  

<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City:
  <input class="strings"  list="city" id="city" name="city">
  <datalist name="city1" id="city1">
  <option value="Mumbai">
  <option value="Delhi">
  <option value="Banglore">
  <option value="Pune">
  <option value="Kolkata">
  </datalist>
  <span class="error"><?php echo $cityErr;?></span><br>

<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pin Code:
  <input class="strings"  id="pincode" name="pincode" type="text"><span class="error"><?php echo $pincodeErr;?></span><br>
 </div>

<div class="rightattribute">
 <b>Account Details:</b><br>
  <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username:
  <input class="strings" name="username" id="username" type="text"><span class="error"><?php echo $usernameErr;?></span><br>

  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password:
  <input class="strings"  name="password1" id="password1" type="password"><span class="error"><?php echo $passwordErr;?></span><br>
  
  <br> Confirm password:
  <input class="strings" name="password2" id="password2" type="password"><span class="error"><?php echo $passwordErr;?></span><br>

  <br>&nbsp;Security Question:
  <select class="strings" name="questions">
  <option value="bp">What is your birthplace?</option>
  <option value="dn">What is your dog's name?</option>
  <option value="pn">What is your pet name?</option>
  <option value="fc">Favourite Colour?</option>
  </select><br><span class="error"><?php echo $questionsErr;?></span>
 
  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Answer:
  <input class="strings" name="answers" type="text"><span class="error"><?php echo $answersErr;?></span><br>

<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
  <input class="strings"  id="email"  name="email" type="text"><span class="error"><?php echo $emailErr;?></span> <br>

<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone:&nbsp;<input class="strings" id="phone" name="phone" type="text" ><span class="error"><?php echo $phoneErr;?></span><br>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank card no.:&nbsp;<input class="strings" id="cardnum" name="cardnum" type="text" ><span class="error"><?php echo $cardnumErr;?></span><br>
</div>

<div id="tandc">
<p style="text-align:center"><button id="submit" align="right" type="submit" width="150%"  >Submit</button>
</div>

</form>

</body>


</html>
