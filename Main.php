<html>
<head>
<link rel="stylesheet" type="text/css" href="main.css">


<script>
var slideimages=new Array()
var slidelinks=new Array()

function slideshowimages(){
  for (i=0;i<slideshowimages.arguments.length;i++){
  slideimages[i]=new Image()
  slideimages[i].src=slideshowimages.arguments[i]
  }
}

function slideshowlinks(){
  for (i=0;i<slideshowlinks.arguments.length;i++)
  slidelinks[i]=slideshowlinks.arguments[i]
}

function gotoshow(){
  if (!window.winslide||winslide.closed)
    winslide=window.open(slidelinks[whichlink])
  else
    winslide.location=slidelinks[whichlink]
    winslide.focus()
}

</script>

</head>
<title>
Online Banking
</title>

<body >
<div id="title"><h1><img  src="bank.jpg" alt="Bank" width="200" height="100" align="left" >Online banking</h1> </div>
<br>

<div id="notice">
<h2>
<a class="tile" href="main.php"> Products</a>
<a class="tile" href="main.php">About us</a>
<a class="tile" href="main.php">Contact us</a> </h2>
</div>
<!-- Q29weXJpZ2h0IDIwMTUgYnkgQW1leSBNaGFkZ3V0 -->

<br><br>

<?php
//db
$servername = "localhost";
$busername = "root";
$bpassword = "";
$dbname = "banking";

$loginErr="";




if ($_SERVER["REQUEST_METHOD"] == "POST") {

$uname= $_POST['uname']; 
$pass = $_POST['pass'];



// Create connection
$conn = new mysqli($servername, $busername, $bpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
 

$sql = "SELECT * FROM users WHERE username = '$uname' AND password = '$pass'";
$result = $conn->query($sql);
if($result->num_rows==0)
{
 $loginErr="*Invalid username and password";
}
else
{
  header("Location:wallet.php");
   session_start(); 
   $_SESSION['user']=$uname;
}
$conn->close();
}
?>

<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onload="clear()" autocomplete="off">
<script>


function clear()
{
document.getElementById("uname").value="";
document.getElementById("pass").value="";
}
</script>
<div id="paral">
<!-- Q29weXJpZ2h0IDIwMTUgYnkgQW1leSBNaGFkZ3V0 -->

<p style="font-size:30px" align="center"> <b>Sign In</b></p>
<p style="font-size:20px" >Username:&nbsp;&nbsp;<input name="uname" id="uname" type="text"></input>
<p style="font-size:20px" >Password:&nbsp;&nbsp;&nbsp;<input name="pass" id="uname" type="password"></input>
<span class="error"><?php echo $loginErr;?></span>
<button id="login" type="submit" >Login</button>
</div>
</form>




<div id="middle1">
<a href="javascript:gotoshow()"><img src="register.jpg" name="slide" border=0 width="800px" height="340px"></a>

<script>
//configure the paths of the images, plus corresponding target links
slideshowimages("register.jpg", "img2.jpg", "img3.jpg")
slideshowlinks("form.php", "form.php", "form.php")

//configure the speed of the slideshow, in miliseconds
var slideshowspeed=2000
var whichlink=0
var whichimage=0

function slideit(){
  if (!document.images)
    return
    document.images.slide.src=slideimages[whichimage].src
    whichlink=whichimage

  if (whichimage<slideimages.length-1)
    whichimage++
  else
    whichimage=0
    setTimeout("slideit()",slideshowspeed)
}
slideit()
</script>

</div>

</body>


</html>
