<?php
require('config.php');

?>
<form action="submit.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
    <input type="hidden" name="freight_id" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="amount" value="<?php echo $_GET['amount']; ?>">
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo $publishableKey?>"
        data-amount="<?php echo $_GET['amount']*100;?>"
        data-name="Payment System For Freights"
        data-description="Payment System For Freights"
        data-image="https://www.logostack.com/wp-content/uploads/designers/eclipse42/small-panda-01-600x420.jpg"
        data-currency="pkr"
        data-email="abc@gmail.com"
        data-allow-remember-me="false" <!-- Add this line if you don't want to remember the user -->
    
    </script>
</form>
