<link rel="stylesheet" href="<?php echo plugin_dir_url( __DIR__ )?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo plugin_dir_url( __DIR__ )?>assets/css/main.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo plugin_dir_url( __DIR__ ) ?>assets/prism/prism.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="<?php echo plugin_dir_url( __DIR__ ) ?>assets/css/jquery.range.css">

<!-- MAIN SECTION BEGIN -->
<section class="tenjin_calculator">
    <div class="container">	
      <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="tc_tenjin_calculator_inner">
            <h1>Maximize your returns with Tenjin</h1>
            <p>Our goal is to help you meet your financial goals, whether they're long or short term. Our AI technology allows you to see which stocks and ETFs are the best to invest in.</p>
          </div>
        </div>
        <div class="col-md-3 col-sm-0 col-12"></div>
      </div>
      <div class="row">
      	<div class="col-md-12 col-sm-12 col-12">
      		      	
      <div class="row input_range">
        <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="tc_slider_heading">
            <h2>Initial amount investment:</h2>
          </div>
            <div class="input-slider teca-iai" onchange="runCalcs2();">
            <input type="hidden" class="initial_amount" />
            </div>
            <div class="tc_slider_heading">
            <h2>Additional monthly contribution</h2>
          </div>
            <div class="input-slider teca-am" onchange="runCalcs2();">
            <input type="hidden" class="additional_monthly" />
            </div>
            <div class="tc_slider_heading">
            <h2>Years to grow</h2>
          </div>
            <div class="input-slider teca-ytg" onchange="runCalcs2();">
            <input type="hidden" class="year_grow" />
            </div>
            <div class="tc_slider_heading">
            <h2>Risk profile</h2>
          </div>
            <div class="input-slider teca-riskp" onchange="runCalcs2();">
            <input type="hidden" class="risk_profile" />
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 box_right_side">
          <div class="row boxes_in">
            <div class="col-md-12 col-sm-12 col-12">
              <div class="green_box">
                <p>Your return with Tenjin</p>
                <h2 id="our_amount"></h2>
                <span><strong id="our_growthrate"></strong></span>
                <span id="our_years"></span>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12">
              <div class="green_box2">
                <p>V.S</p>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12">
              <div class="green_box green_box1">
                <p>Your average market return</p>
                <h2 id="compare_amount"></h2>
                <span><strong id="compare_growthrate"></strong></span>
                <span id="compare_years"></span>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-12 chart_area">
          <div id="wrapper">
          <div class="scrollbar" id="style-1">
          <div class="force-overflow">
          <canvas id="myChart" width="400" height="200"></canvas>
        </div>
      </div>
    </div>
      </div>
      </div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="buttns_cls">          	
            <a href="javascriptvoid:(0)" id="myBtn">Download a PDF of this report</a>
            <a href="javascriptvoid:(0)" class="trans">Join us now</a>
          </div>
        </div>
      </div>
    </div>
    </div>
      </div>
  </section>
<!-- MAIN SECTION END -->

<!-- MODAL SECTION BEGIN -->

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>    </div>
    <form class="teca-pdf-frm" action="teca_pdfgenerate" method="POST">
      <div class="modal-body">
    
    <div style="display: block;">
    	<input type="hidden" name="txt_principle_amount" id="pdf-prin-amount">
		<input type="hidden" name="txt_add_amount" id="pdf-add-amount">
		<input type="hidden" name="txt_years" id="pdf-year">				
		<input type="hidden" name="txt_profile" id="pdf-risk-profile">		
		<input type="hidden" name="txt_ouramount" id="pdf-our-amount">
		<input type="hidden" name="txt_compamount" id="pdf-compare-amount">
		<input type="hidden" name="txt_totalinvest" id="pdf-total-invest">
		<input type="hidden" name="txt_ourgrate" id="pdf-our-grate">
		<input type="hidden" name="txt_compgrate" id="pdf-compare-grate">
    </div>	

      <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="inner_fields">
            <label>First Name:</label>
            <input type="text" name="txt_fname" id="txt-fname">
            <p class="txt-fname-msg" style="color: #000;"></p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="inner_fields">
            <label>Last Name:</label>
            <input type="text" name="txt_lname" id="txt-lname">
            <p class="txt-lname-msg" style="color: #000;"></p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="inner_fields">
            <label>Email Address:</label>
            <input type="text" name="txt_email" id="txt-email" required>
            <p class="txt-email-msg" style="color: #000;"></p>
          </div>
        </div>
      </div>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary teca-pdf-button">SUBMIT</button>
      </div>
    </form>

    <img id="teca-loading-image" src="<?php echo plugin_dir_url( __DIR__ )?>assets/images/teca-ajax-loader.gif">

    <div class="col-md-12 col-sm-12 col-12">
    	<div class="alert alert-success" role="alert" id="teca-pdf-success-msg" style="display: none;">
	        Email Submitted Successfully!
	        <button type="button" class="close" id="pdf_sclose">
	            <span aria-hidden="true">&times;</span>
	        </button>
    	</div>
    </div>

    <div class="col-md-12 col-sm-12 col-12">        
        <div class="alert alert-success" role="alert" id="teca-pdf-error-msg" style="display: none;">
        	Email Not Submitted!
        <button type="button" class="close" id="pdf_eclose">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    </div>
</div>

</div>

<!-- MODAL SECTION END -->

<p id="demo1"></p>
<hr>
<p id="demo2"></p>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="<?php echo plugin_dir_url( __DIR__ )?>assets/js/jquery.range.js"></script>
<script src="<?php echo plugin_dir_url( __DIR__ )?>assets/js/chart.min.js"></script>


<script>
  $(document).ready(function () {
          if (!$.browser.webkit) {
              $('.wrapper').html('<p>Sorry! Non webkit users. :(</p>');
          }
      });

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>