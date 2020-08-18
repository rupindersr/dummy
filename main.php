<?php
session_start();
if(!isset($_SESSION["username"])){
    header("location: index.php");
}
$myusername = $_SESSION["username"];

require('config.php');
if(isset($account_type)){
  if(!empty($account_type)){

   

    
    $id = $_SESSION["id"];
    $query = "select * from users where username='$myusername'";
    $data = mysqli_query($conn, $query) or die("Error".mysqli_error($con));
    $response = mysqli_fetch_array($data);
    $account_type = $_POST['account_type'];
    $amount = $_POST['amount'];
    $account_type = $_POST['action_type'];
   
    if($account_type=='withdrawl'){
      if($account_type=='saving' && $_POST['amount'] > $response['saving_balance']){
        exit("You are out of cash");
     
      }
      elseif($account_type=='checking' && $_POST['amount'] > $response['checking_balance']){
        exit("You are out of cash");
      }
      elseif($account_type=='interest' && $_POST['amount'] > $response['interest_balance']){
        exit("You are out of cash");
      }
      else{
        $query = "INSERT INTO transactions (`user_id`, `account_type`, `action_type`, `amount`)
        VALUES ($id, $account_type, $account_type, $amount)";
        $data = mysqli_query($conn, $query) or die("Error".mysqli_error($con));
        $_POST['amount']
      }
        
        
      }
      else{
        $query = "INSERT INTO transactions (`user_id`, `account_type`, `action_type`, `amount`)
        VALUES ('John', 'Doe', 'john@example.com')";
        $data = mysqli_query($conn, $query) or die("Error".mysqli_error($con));

      }
      
    }
    


  }
}

$query = "select * from users where username='$myusername'";
$data = mysqli_query($conn, $query) or die("Error".mysqli_error($con));
$response = mysqli_fetch_array($data);



?>


<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="/main.php" method="post">
  
<label for="fname">Name:</label>
  <input type="text" id="name" name="name" value="<?php echo $_SESSION["name"]?>"><br>
  <br>
  <label for="Account Type">Account Type:</label><br>
    <select name="account_type" onchange="this.form.submit()">
         <option value="">Select</option>
        <option value="saving" selected>Saving</option>
        <option value="checking">Checking</option>
        <option value="interest">Interest</option>
    </select>
    <br>
    <br>
    <label for="Action Type">Action type:</label><br>
    <select name="action_type">
  
        <option value="deposit">Deposit</option>
        <option value="withdrawl">Withdrawl</option>
    </select>
    <br>
    <br>
    <label for="fname">Amount:</label>
  <input type="text" id="Amount" name="amount" value="" required><br>
  <br>
  <br>
  <h3>
  Saving Balance: <?php echo $response['saving_balance'];  ?> </br>
  Checking Balance: <?php echo $response['checking_balance'];  ?> </br>
  Interest Balance: <?php echo $response['interest_balance'];  ?> </br> 
  </h3>
  <br>
    
  <input type="submit" value="Submit">

</form> 


</body>
</html>
