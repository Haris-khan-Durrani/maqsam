<div class="css-modal-checkbox-container Harismodal" style="display:none">
	

    <label class="phone-call" for="css-modal-checkbox" >    <svg class="widgetButton-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <g>
            <path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"></path>
        </g>
    </svg></label>

</div>
<input type="checkbox" id="css-modal-checkbox" />	
<div class="cmc Harismodal" style="display:none">
    <div class="cmt">
	<div class="popupheading">
        <img src="<?php echo $logourl; ?>" style="width: 200px;padding-top: 10px;">
<h1>Get a call within 30 seconds</h1>
<h2>  Leave your number below
    </h2>and we will call you right away!

    </div>
  <div class="mainform">
            <div>
                <label for="widgetModal-clientName">Name (required)</label>
                <input type="text" class="widgetModal-fields" id="widgetModal-clientName">
            </div>
                <div>
                    <label for="phone"> Enter your number with country code (The call is free)</label><br>
                    <input type="tel" class="widgetModal-fields" id="phone" data-intelinput="phone" data-intelinput-default-country="ae" data-validation="required phone" data-validation-rules="{phone: true, required: true}" data-validation-messages="{required: 'Please enter your phone number', phone: 'Please enter a valid phone number'}">

                    <button class="widgetModal-formButton" id="lc_submit_button" onclick="callnow()">Call me!</button>
            </div>
<div class="errordiv"></div>

            <!-- <div class="d-flex text-bold justify-content-center align-items-center" id="timer"></div> -->
<input type="hidden" value="<?php echo $btk; ?>" id="btk">
<input type="hidden" value="<?php echo $sid; ?>" id="sid">

        </div>
           


        <div class="footerpop" style="padding-top: 20px;">
<?php echo $pow; ?>

        </div>
         


       



	</div>
	<label for="css-modal-checkbox" class="css-modal-close"></label>
</div>



<style>
	#css-modal-checkbox:checked + .cmc .cmt{
		border-color:<?php echo $bc." !important"; ?>
	}
	
	
	.phone-call,.phone-call:before {
			background-color:<?php echo $bc." !important"; ?>
	}
	
</style>




<script>
window.jQuery = window.$ = function() {
    return {
      on: function() {}
    };
  };
  window.$.fn = {};


</script>