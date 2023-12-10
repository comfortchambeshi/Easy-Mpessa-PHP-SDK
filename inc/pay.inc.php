<?php 


if (isset($_POST['donate_btn'])) {
      include_once '../classes/VodacomMpessa.php';
      include '../classes/db.php';
      include '../classes/main.php';

      
      $main = new main();


      $VodacomMpessa = new VodacomMpessa();




      //Form data
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $email = $_POST['email'];
      $phone_number = $_POST['phone_number'];
      $address = $_POST['address'];
      $city_town = $_POST['city_town'];
      $amount = $_POST['amount'];
      //Call payment function

      
      /*$verify = $VodacomMpessa->verifyTransaction("yjUqDoZ6fJtLsBEBzjWIE4eSbW7K1zb", "TZN");
      print_r($verify);
      exit();*/
      

      //Initiate transaction
      $pay = $VodacomMpessa->c2b($amount, $phone_number, "GHS", 'GHA', "Product title");
      //Insert transaction into table
       

       $output_ResponseDesc = $pay["result"]["output_ResponseDesc"];

       

       if($pay)
       {
            $output_ThirdPartyConversationID =  $pay["result"]["output_ThirdPartyConversationID"];
            $input_TransactionReference = $output_ThirdPartyConversationID;
            //Insert transaction into table
            $insert = $main->insertTransaction($first_name, $last_name, 'Product title here', $amount, "GHS", $output_ThirdPartyConversationID, $input_TransactionReference, "mpessa", $email);

           
           
       }
   
  
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500">
     <title>Payment submit</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway+Dots">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="../assets/css/Highlight-Blue.css">
    <link rel="stylesheet" href="../assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="../assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="../assets/css/News-article-for-homepage-by-Ikbendiederiknl.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>

<body>

<div class="news-block" style="padding-top: 0px;">
        <section class="login-clean">
            <form id="content" action="" method="post" style="width: 500px;max-width: 100%;" >

             <h3 id="status"></h3>
            </form>
        </section>
    </div>

      
<script>
$(document).ready(function() {
  // Function to check the status
  function checkStatus() {
    // Get the transaction ID from the HTML form
    var transaction_id = $('#transaction-id').val();
    
    // Send an AJAX request to the PHP file
    $.ajax({
      url: 'check.php?txn=<?php echo $output_ThirdPartyConversationID; ?>',
      type: 'POST',
      data: { transaction_id: transaction_id },
      success: function(response) {
        console.log(response);
        // Display the status
        if(response == 'pending') {
          $('#status').html('<div class="text-center"><div class="spinner-border" role="status"> <span class="sr-only">Loading...</span> </div></div><h4 class="text-center">Transaction in progress...</h4>');

        } else if(response == 'success') {
            // if status is approved, display message and redirect
        $('#status').html('<h4 class="text-success">Transaction processed successfully!</h4>');
        setTimeout(function() {
          window.location.href = '../redirect.php?status=approved'; // replace with the URL you want to redirect to
        }, 5000);
          
        } else if(response == 'rejected') {
          $('#status').html('<h4 class="text-danger">Transaction failed!</h4>');
          setTimeout(function() {
          window.location.href = '../redirect.php?status=failed'; // replace with the URL you want to redirect to
        }, 5000);
          
        }
      }
    });
  }
  
  // Check the status every 3 seconds
  setInterval(checkStatus, 3000);
});
</script>

<div id="status"></div>



