<script src="https://checkout.payabbhi.com/v1/checkout.js"></script>
<script>
  var checkout_args = {
    access_id: "<?php echo $access_id; ?>",
    order_id: "<?php echo $payabbhi_order_id; ?>",
    amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "Order # <?php echo $merchant_order_id; ?>",
    prefill: {
     name:"<?php echo $card_holder_name; ?>",
     email: "<?php echo $email; ?>",
     contact: "<?php echo $phone; ?>"
    },
    notes: {
      merchant_order_id: "<?php echo $merchant_order_id; ?>"
    },
    theme: {
      color: "#F6A821",
      close_button: true
    }
  };
  checkout_args.handler = function(payment){
    document.getElementById('order_id').value = payment.order_id;
    document.getElementById('payment_id').value = payment.payment_id;
    document.getElementById('payment_signature').value = payment.payment_signature;
    document.getElementById('checkout-form').submit();
  };
  var submit_btn, payabbhiCheckout;

  function openCheckout(el){
    if(typeof Payabbhi == 'undefined'){
      setTimeout(openCheckout, 200);
      if(!submit_btn && el){
        submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait while we are processing your payment.';
      }
    } else {
      if(submit_btn){
        submit_btn.disabled = false;
        submit_btn.value = "<?php echo $button_confirm; ?>";
      }
      payabbhiCheckout = new Payabbhi(checkout_args);
      payabbhiCheckout.open();
    }
  }

</script>
<form name='checkoutform' id="checkout-form" action="<?php echo $return_url; ?>" method="POST">
  <input type="hidden" name="order_id" id="order_id">
  <input type="hidden" name="payment_id" id="payment_id">
  <input type="hidden" name="payment_signature" id="payment_signature">
</form>
<div class="buttons">
  <div class="pull-right">
    <input type="submit" onclick="openCheckout(this);" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
  </div>
</div>
