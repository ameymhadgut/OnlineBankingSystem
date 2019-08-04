<html>
<head>

<link rel="stylesheet" type="text/css" href="main.css">
</head>
<title>
Online Banking
</title>

<body style="color:lightblue">
<!-- Q29weXJpZ2h0IDIwMTUgYnkgQW1leSBNaGFkZ3V0 -->

<?php
//db
session_start();
 $uname=$_SESSION['user'];

$fname=$mname=$lname="";

$servername = "localhost";
$busername = "root";
$bpassword = "";
$dbname = "banking";


// Create connection
$conn = new mysqli($servername, $busername, $bpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT fname,mname,lname,balance FROM users WHERE username = '$uname'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$fname=$row["fname"];
$mname=$row["mname"];
$lname=$row["lname"];
$balance=intval($row["balance"]);
$Err1=$Err2=$Err3="";





//delete a/c
if(isset($_POST['delete']))
{
 
 
 $sql = "DELETE FROM `banking`.`users` WHERE `users`.`username` = '$uname'  ";
 if ($conn->query($sql) === TRUE) {
    $Err3="A/c deleted successfully";
     } else {
    $Err3="Error in deleteing: " . $conn->error;
       }
header("Refresh:2; url=Main.php");
}

//addcash
if(isset($_POST['add']))
{
 $amt=$_POST['addcash'];
if($amt<0)
{ $Err1="Invalid amount";
}
else{
 
 $total1=$balance+$amt;
 $sql = "UPDATE users SET balance=$total1 WHERE username = '$uname'";
 if ($conn->query($sql) === TRUE) {
    $Err1="Cash added successfully";
	
     } else {
    $Err1="Error: " . $conn->error;
       }

}
header("Refresh:1");
}



//transfercash
if(isset($_POST['transfer']))
{
 $amt=$_POST['transcash'];
if($amt<0)
{ $Err2="Invalid amount";
}
else{
 if($amt>$balance)
	 $Err2="Account balance insufficient";
 else{
	 $uname2=$_POST['touser'];
 $total1=$balance-$amt;
 
 
 $sql = "SELECT balance FROM users WHERE username = '$uname2'";
 if ($conn->query($sql) === TRUE) {
    $Err2="";
     } else {
    $Err2="Invalid requested username for transfer: " . $conn->error;
       }
	   $result = $conn->query($sql);
$row = $result->fetch_assoc();
$balance2=intval($row["balance"]);
$total2=$balance2+$amt;
 
 $sql = "UPDATE users u1 JOIN users u2 ON u1.username='$uname' AND u2.username='$uname2' SET u1.balance=$total1, u2.balance=$total2 ";
 if ($conn->query($sql) === TRUE) {
    $Err2="Cash transfered successfully";
     } else {
    $Err2="Invalid transfer: " . $conn->error;
       }
}
header("Refresh:1");
}}
?>

<div id="title">
<h1><img src="bank.jpg" alt="TSEC" width="200" height="130" align="left" ><br>Online banking</h1>
</div>
<br>
<div id="notice"> <h2> <a class="tile" href="admission.html"> Products</a> <a class="tile" href="alumni.html">About us</a> <a class="tile" href="form.html">
Contact us</a> <a class="tile" href="main.php">Logout</a> <p align="right">Welcome, <?php echo $uname ?></p> </h2></div>
<br><br>




<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
<div id="paral">
<p style="font-size:30px" align="center"> <b>Details</b></p>
<p style="font-size:20px" >Name: <?php echo $fname. " " .$mname ." " .$lname?></p>
<!-- Q29weXJpZ2h0IDIwMTUgYnkgQW1leSBNaGFkZ3V0 -->

<p style="font-size:20px" >Balance: Rs.<?php echo intval($balance); ?></p><br>
<button class="submit" id="delete" name="delete" align="center" type="submit" width="150%" >Delete a/c</button>
<br><span class="message"><?php echo $Err3;?></span>
</div>
</form>


<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"  >
<div id="middle1">
<p style="text-align:center"><button class="submit" id="add" name="add" align="right" type="submit" width="150%" >Add cash</button>
<br><br>Amount to add: Rs.&nbsp;<input id="addcash" type="number" name="addcash" value="" ><br><span class="message"><?php echo $Err1;?></span>

<br><br>
</form>

<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
<p style="text-align:center"><button class="submit" id="transfer" name="transfer" align="right" type="submit" width="150%" >Transfer cash</button>
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;To username:&nbsp;<input id="touser" name="touser" type="text" value=""><br><br>Amount to transfer: Rs.&nbsp;
<input id="transcash" type="number" name="transcash" value=""><br><span class="message"><?php echo $Err2;?></span>
<br><br>
</form>


</body>

</html>
