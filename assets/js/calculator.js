/*
* Range Slider
*/
$(document).ready(function(){

// width=$(".boxes_in").width();
width=$(".input-slider").width();
// if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 // some code..
//   width=width-50;
// }else{
//   width=width_big;
// }

  width2=$(window).width()-$(window).width()/100*15
    $('.initial_amount').jRange({
        from: 1,
        to: 5000000,
        width:width,
        step: 1,
        scale: ['$1','$5mn'],
        // format: '%s',
        format: function(value){
        return value.toLocaleString();
    },
        showLabels: true,
        snap: true
    });
    $('.additional_monthly').jRange({
        from: 1,
        to: 2000,
        width:width,
        step: 1,
        scale: ['$1','$2k'],
        // format: '%s',
        format: function(value){
        return value.toLocaleString();
    },
        showLabels: true,
        snap: true
    });
    $('.year_grow').jRange({
        from: 1,
        to: 30,
        width:width,
        step: 1,
        scale: ['1 year','30 years'],
        format: '%s',
        showLabels: true,
        snap: true
    });
    $('.risk_profile').jRange({
        from: 1,
        to: 5,
        width:width,
        step: 1,
        scale: ['Conservative', 'Conservative Aggressive', 'Moderate', 'Moderately Aggressive', 'Aggressive'],
        format: '%s',
        showLabels: true,
        snap: true
    });

    $('.initial_amount').jRange('setValue', '100000');
    $('.additional_monthly').jRange('setValue', '1000');
    $('.year_grow').jRange('setValue', '10');
    $('.risk_profile').jRange('setValue', '4');
});

window.onload = function runCalcs() {
  var initial_amount = $('.initial_amount').val();
  var additional_monthly = $('.additional_monthly').val();
  var year_grow = $('.year_grow').val();
  var risk_profile = $('.risk_profile').val();
  compare(initial_amount, year_grow, additional_monthly, risk_profile);
}

function runCalcs2() {
  var initial_amount = $('.initial_amount').val();
  var additional_monthly = $('.additional_monthly').val();
  var year_grow = $('.year_grow').val();
  var risk_profile = $('.risk_profile').val();
  compare(initial_amount, year_grow, additional_monthly, risk_profile);
};
    
var Benchmark_Deposit = 6;
var Benchmark_SP500 = 12.24;
var Conservative = 11;
var Moderate_Conservative = 14;
var Moderate = 18.18;
var Aggressive_Moderate = 20.7;
var Aggresive = 23.32;

function compare(principalAmount, years, additionalAmount, tenjinRateCode) {

      var principalAmount1 = principalAmount;  

      // principal amount for comp
      var principalAmount2 = principalAmount;  
      var months = years * 12;
      var additionalAmount = additionalAmount;
      var tenjinRateCode = tenjinRateCode;
      var riskStrategyRate;
      var riskStrategyName;
      var growthRate;
      var growthRate2;
      var totalinvestment;
      var benchmarkRate;
      var benchmarkName;
      if (tenjinRateCode == 1) {
        riskStrategyRate = Conservative;
        riskStrategyName = "Conservative";
        benchmarkRate = Benchmark_Deposit;
        benchmarkName = "Deposit";
      }
      else if (tenjinRateCode == 2) {
        riskStrategyRate = Moderate_Conservative;
        riskStrategyName = "Conservative Aggressive";
        benchmarkRate = Benchmark_Deposit;
        benchmarkName = "Deposit";
      }
      else if (tenjinRateCode == 3) {
        riskStrategyRate = Moderate;
        riskStrategyName = "Moderate";
        benchmarkRate = Benchmark_SP500;
        benchmarkName = "SP500";
      }
      else if (tenjinRateCode == 4) {
        riskStrategyRate = Aggressive_Moderate;
        riskStrategyName = "Moderately Aggressive";
        benchmarkRate = Benchmark_SP500;
        benchmarkName = "SP500";
      }
      else if (tenjinRateCode == 5) {
        riskStrategyRate = Aggresive;
        riskStrategyName = "Aggressive";
        benchmarkRate = Benchmark_SP500;
        benchmarkName = "SP500";
      }
      else {
        riskStrategyRate = 0;
        riskStrategyName = "Wrong input";
        benchmarkRate = 0;
        benchmarkName = "Wrong input";
      }

      let result = [];  //store results according to our plan.
      let result2 = []; //store results according to SP500.
      let counter=0;
      let counter2=0;
      for (let i = 0; i < (months); i++) {
        //calculation of results according to our plan starts.
        let growthInterest = principalAmount1 * (riskStrategyRate / 1200);  
        let growthAmount = +principalAmount1 + +growthInterest;
        let tenjinFee = (growthAmount / 12) * 0.01;
        let finalAmount = growthAmount - tenjinFee + +additionalAmount;
        let finalAmountRoundOff = finalAmount.toFixed(2);
        counter++;
        if(counter==12){
        result.push(finalAmountRoundOff);
        counter=0;
        }
        principalAmount1 = finalAmountRoundOff;  
        // calculations for results according to our plan ends.
        // calculations for results according to benchmark starts.
        let growthInterest2 = principalAmount2 * (benchmarkRate / 1200);  
        let growthAmount2 = +principalAmount2 + +growthInterest2;
        let tenjinFee2 = 0;
        let finalAmount2 = growthAmount2 - tenjinFee2 + +additionalAmount;
        let finalAmountRoundoff2 = finalAmount2.toFixed(2);
        counter2++;
        if(counter2==12){
        result2.push(finalAmountRoundoff2);
        counter2=0;
        }
        principalAmount2 = finalAmountRoundoff2;  
        // calculations for results according to SP500 ends.
      }

      // growth rate of tenjin strategy
      growthRate = (((((riskStrategyRate / 100) + 1) ** years) - 1) * 100).toFixed(0);  

      // growth rate of benchmark strategy
      growthRate2 = (((((benchmarkRate / 100) + 1) ** years) - 1) * 100).toFixed(0);

      // total investment amount
      totalinvestment =  (+principalAmount +(additionalAmount * months)).toFixed(0);

      // document.getElementById("demo1").innerHTML = ("OurPlan:"+ result + "<br>Growth Rate: "+ growthRate+"%" + "<br>Tenjin Strategy: " + riskStrategyName + "<br>Amount: $"+parseInt(principalAmount1).toLocaleString() );
      // document.getElementById("demo2").innerHTML = ("ComparePlan:"+result2 + "<br>Growth Rate: "+ growthRate2+"%" + "<br>Benchmark: " + benchmarkName + "<br>Amount: $"+parseInt(principalAmount2).toLocaleString() );

      document.getElementById("our_amount").innerHTML = "$"+parseInt(principalAmount1).toLocaleString();
      document.getElementById("compare_amount").innerHTML = "$"+parseInt(principalAmount2).toLocaleString();

      document.getElementById("our_growthrate").innerHTML = growthRate+"% growth";
      document.getElementById("compare_growthrate").innerHTML = growthRate2+"% growth";

      document.getElementById("our_years").innerHTML = " Over "+years+" years";
      document.getElementById("compare_years").innerHTML = " Over "+years+" years";

/*
* Data Get in Input Fields
*/

      document.getElementById("pdf-prin-amount").value = parseInt(principalAmount).toLocaleString();
      document.getElementById("pdf-year").value = years;
      document.getElementById("pdf-add-amount").value = parseInt(additionalAmount).toLocaleString();
      document.getElementById("pdf-risk-profile").value = riskStrategyName;
      document.getElementById("pdf-total-invest").value = parseInt(totalinvestment).toLocaleString();    
      document.getElementById("pdf-our-amount").value = parseInt(principalAmount1).toLocaleString();
      document.getElementById("pdf-compare-amount").value = parseInt(principalAmount2).toLocaleString();
      document.getElementById("pdf-our-grate").value = growthRate;
      document.getElementById("pdf-compare-grate").value = growthRate2;


/*
* Chart Result
*/

addData(result2, result);

};

let ctx = document.getElementById('myChart');
let myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Market Returns',
            data: [],
            backgroundColor: [
                'rgba(169, 186, 67, 1)',                
            ],
        },
        
        {
            label: 'Tenjin Returns',
            data: [],
            backgroundColor: [
                'rgba(183, 200, 84, 1)',
            ],
        }

        ]
    },
    options: {
        scales: {
            x: {
                stacked: true,
            },
            y: {
                beginAtZero: true
            }
        }
    }
});

function addData(resultset, resultset2) {  
    
    var chartData = [];
    var chartData2 = [];
    var chartLabel = [];
    
    for(var i = 0; i < resultset.length; i++){
      chartData.push(resultset[i]);
    }
    for(var i = 0; i < resultset2.length; i++){
      chartData2.push(resultset2[i]);
    }
    var current_year = new Date();
    var cl = current_year.getFullYear();
    for(var j = 0; j < resultset.length; j++){      
      chartLabel.push(cl++);
    }

    myChart.data.datasets[0].data = chartData;
    myChart.data.datasets[1].data = chartData2;
    myChart.data.labels = chartLabel;
    myChart.update();
}


jQuery(document).ready(function ($) {
"use strict";
  $(".teca-pdf-button").click(function (e) {
    e.preventDefault();
    let form = $(this).closest(".teca-pdf-frm");

    let pdf_prin_amount = $(form).find("#pdf-prin-amount").val();
    let pdf_add_amount = $(form).find("#pdf-add-amount").val();
    let pdf_year = $(form).find("#pdf-year").val();
    let pdf_risk_profile = $(form).find("#pdf-risk-profile").val();
    let pdf_total_invest = $(form).find("#pdf-total-invest").val();
    let pdf_our_amount = $(form).find("#pdf-our-amount").val();
    let pdf_compare_amount = $(form).find("#pdf-compare-amount").val();
    let pdf_our_grate = $(form).find("#pdf-our-grate").val();
    let pdf_compare_grate = $(form).find("#pdf-compare-grate").val();
    let txt_fname = $(form).find("#txt-fname").val();
    let txt_lname = $(form).find("#txt-lname").val();
    let txt_email = $(form).find("#txt-email").val();

    let is_fields_true = true;

    if (pdf_prin_amount == "" || pdf_add_amount == "" || pdf_year == "" || pdf_risk_profile == "" || pdf_total_invest == "" || pdf_our_amount == "" || pdf_compare_amount == "" || pdf_our_grate == "" || pdf_compare_grate == "") {
      is_fields_true = false;
    }

    if (txt_fname == "") {
      is_fields_true = false;

      $(form)
        .find("#txt-fname")
        .siblings(".txt-fname-msg")
        .html("First name is required.");
    }

    if (txt_lname == "") {
      is_fields_true = false;

      $(form)
        .find("#txt-lname")
        .siblings(".txt-lname-msg")
        .html("Last name is required.");
    }

    if (txt_email == "") {
      is_fields_true = false;

      $(form)
        .find("#txt-email")
        .siblings(".txt-email-msg")
        .html("Email is required.");
        
    } else if (!isValidEmailAddress(txt_email)) {
      is_fields_true = false;

      $(form)
        .find("#txt-email")
        .siblings(".txt-email-msg")
        .html("Invalid Email.");
    }

    if (is_fields_true == true) {

    $.ajax({
        type: "POST",
        url: teca_admin_ajax.ajax_url,
        data: {
          action: "teca_pdfgenerate",
          pdf_prin_amount: pdf_prin_amount,
          pdf_add_amount: pdf_add_amount,
          pdf_year: pdf_year,
          pdf_risk_profile: pdf_risk_profile,
          pdf_total_invest: pdf_total_invest,
          pdf_our_amount: pdf_our_amount,
          pdf_compare_amount: pdf_compare_amount,
          pdf_our_grate: pdf_our_grate,
          pdf_compare_grate: pdf_compare_grate,
          txt_fname: txt_fname,
          txt_lname: txt_lname,
          txt_email: txt_email,
        },
        beforeSend: function (response) {
          $("#teca-loading-image").css("display", "block");
        },
        success: function (response) {
          $("#teca-pdf-success-msg").css("display", "block");
          $("#teca-loading-image").css("display", "none");
        },
        error: function (data) {
          $("#teca-pdf-error-msg").css("display", "block");
          $("#teca-loading-image").css("display", "none");
        },
      });

    }

    $("#txt-fname").on("input", function () {
      if ($(this).val() != "") {
        $(this).siblings(".txt-fname-msg").html("");
      }
    });

    $("#txt-lname").on("input", function () {
      if ($(this).val() != "") {
        $(this).siblings(".txt-lname-msg").html("");
      }
    });

    $("#txt-email").on("input", function () {
      if ($(this).val() != "") {
        $(this).siblings(".txt-email-msg").html("");
      }
    });

  });

});   

//email validation
function isValidEmailAddress(emailAddress) {
  var pattern = new RegExp(
    /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i
  );
  return pattern.test(emailAddress);
}

$("#pdf_sclose").click(function () {
  $("#teca-pdf-success-msg").css("display", "none");
});
$("#pdf_eclose").click(function () {
  $("#teca-pdf-error-msg").css("display", "none");
}); 

jQuery(document).ready(function ($) {
  $(".teca-range-field").keypress(function(e){
    if (isNaN(String.fromCharCode(e.which)) ) e.preventDefault();
  });

  $(".teca-iai").find(".teca-range-field").keypress(function(e){
    if(e.which == 13){
      $('.initial_amount').jRange('setValue', $(this).text());
      e.preventDefault();
    }        
  });
  $(".teca-am").find(".teca-range-field").keypress(function(e){       
    if(e.which == 13){
      $('.additional_monthly').jRange('setValue', $(this).text());
      e.preventDefault();
    }    
  });
  $(".teca-ytg").find(".teca-range-field").keypress(function(e){   
    if(e.which == 13){
      $('.year_grow').jRange('setValue', $(this).text());    
      e.preventDefault();
    }    
  });
   $(".teca-riskp").find(".teca-range-field").keypress(function(e){   
    if(e.which == 13){
      $('.risk_profile').jRange('setValue', $(this).text());    
      e.preventDefault();
    }
  });
});