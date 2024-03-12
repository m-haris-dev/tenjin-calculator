<?php
/*
* File: class-teca-plugin-loader
*/

if (!class_exists('TECA_PLUGIN_LOADER')) {

	class TECA_PLUGIN_LOADER
	{
		public function __construct()
        {        	
			add_shortcode('tenjin_calculator', array($this, 'teca_calculator'));
						
			add_action('wp_enqueue_scripts', array($this, 'teca_scriptload'));

			// set form ajax function enqueue
            add_action('wp_ajax_teca_pdfgenerate', array($this, 'teca_pdfgenerate'));    //execute when wp logged in
            add_action('wp_ajax_nopriv_teca_pdfgenerate', array($this, 'teca_pdfgenerate')); //execute when logged out

        }

        function teca_scriptload(){
        	wp_register_script('teca-ajax-js', plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/js/calculator.js', array(), 1, 'all');
        	wp_localize_script('teca-ajax-js', 'teca_admin_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
			wp_enqueue_script('teca-ajax-js');	
        }        

		function teca_calculator(){
			ob_start();
			include_once( plugin_dir_path( __FILE__ ) . '/templates/calculator.php' );
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}

		function teca_pdfgenerate(){

			require_once (TECA_PLUGIN_DIR . '/assets/TCPDF-main/tcpdf.php');

			/*Start*/

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tenjin');
$pdf->SetTitle('Tenjin Calculator');
$pdf->SetSubject('Tenjin');
$pdf->SetKeywords('Tenjin, Calculator');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

$pdf->SetMargins(0, 0, 0,true);
// add a page 1
$pdf->AddPage();
$html = '
<img src="'.plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/images/pdf-top.png">
<br><br><br><br><br><br><br>
<table cellpadding="10" cellspacing="2">
<tr>
<td width="170">
</td>
<td style="" width="390" align="center">
<img src="'.plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/images/teca-logo.png">
<br><br><br>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">
Client Name: ';
$html .= $_POST['txt_fname'].' '.$_POST['txt_lname'];
$html .='
<br><br>
Prepared By: Tenjin AI Capital Advisors LLC " Tenjin AI "
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<strong>Client Investment Growth Report</strong>
</p>
</td>
<td width="60">
</td>
</tr>
</table>
';
$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(255, 255, 0)));
$pdf->SetFillColor(255, 255, 0);
$pdf->RoundedRect(72, 181, 65, 6, 0, '1111', 'DF');
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetMargins(15, 30, 15,true);
// add a page 2
$pdf->AddPage();
$html = '<h5 style="font-size: 17px;">Dear Investor,</h5>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">
We are pleased to present you with your Investment growth report. Based on the Information  you have provided, we have analyzed your investment growth with Tenjin AI.
<br><br>
The report contains an overview of your investment growth based on the following parameters.
<br><br>
Backtested Strategy Results<br>
Benchmark Performance ( S&P 500/Deposit rate )<br>
Hypothetical Strategy Performance<br>
<br><br>
We hope you find this information satisfactory. Please feel free to reach out to us if you need any clarification.
<br><br>
Sincerely,<br>
Team Tenjin A<br>
</p>
';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page 3
$pdf->AddPage();

// -----------------------------------------------------------------------------

// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)


// $pdf->Image('graph_img.png', '', '', 100, 60, '', '', 'T', false, 300, '', false, false, 1, false, false, false);



// define some HTML content with style
$html = '
<!-- EXAMPLE OF CSS STYLE -->
<style>
    
    p.first {
        color: #003300;
        font-family: helvetica;
        font-size: 14px;
    }
    p.first span {
        color: #006600;
        font-style: italic;
    }
    p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 14px;
        text-align: justify;
    }
    
    table.first {
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border: 1px solid #ffffff;
    }
    td {
        border: 1px solid #ffffff;
        background-color: #ffffff;
    }
    td.second {
        border: 1px solid #ffffff;
    }

    div.test {        
        font-family: helvetica;
        font-size: 14px;
        background-color: #00FF73;
        text-align: center;
        border-radius: 21px;
        width: 50%;
    }

</style>

<table class="first" cellpadding="10" cellspacing="2">

<tr>

<td style="" width="340">

<h4 style="font-size: 30px; font-weight: bolder;">Investment Growth Calculator</h4>

<p style="font-size: 14px;"><b>Initial Investment:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>$'; 
$html .= $_POST['pdf_prin_amount'];
$html .= '
</span></p>
<p style="font-size: 14px;"><b>Additional Monthly Contribution: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span> $';
$html .= $_POST['pdf_add_amount'];
$html .= '
</span></p>
<p style="font-size: 14px;"><b>Total Investment Amount: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span> $';
$html .= $_POST['pdf_total_invest'];
$html .='</span></p>
<p style="font-size: 14px;"><b>Years to Grow:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>';
$html .= $_POST['pdf_year'];
$html .= ' Years</span></p>
<p style="font-size: 14px;"><b>Risk Profile:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>';
$html .= $_POST['pdf_risk_profile'];
$html .= '</span></p>


</td>

<td style="" width="300">
<img src="'.plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/images/graph_img.png">
</td>

</tr>

</table>
<br><br><br><br>
<table class="first" cellpadding="0" cellspacing="3">

<tr>  

  <td style="border-radius:50%;" width="250" align="center" bgcolor="#00ff73">
    <h5 style="font-size: 12px;">Your return with Tenjin</h5>
    <br>
    <h4 style="font-size: 22px; line-height: 10px;" id="p_our_totalamount"><strong>$'; 
$html .= $_POST['pdf_our_amount'];
$html .= '</strong></h4>
    <span style="font-size: 12px;"><strong><span id="p_our_growth">'; 
$html .= $_POST['pdf_our_grate'];
$html .= '</span>% growth</strong></span><br>
    <span style="font-size: 12px;">Over <span id="p_our_year">'; 
$html .= $_POST['pdf_year'];
$html .= '</span> years</span>
    <br>
  </td>

  <td width="120" align="center">
        <br><br><br>
        <h5>V.S</h5>
  </td>

  <td style="border-radius:50%;" width="250" align="center" bgcolor="#2c2a49">
    <h5 style="color: #ffffff; font-size: 12px;">Your average market return</h5>
    <br>
    <h4 style="font-size: 22px; color: #ffffff; line-height: 10px;" id="p_compare_totalamount"><strong>$'; 
$html .= $_POST['pdf_compare_amount'];
$html .= '</strong></h4>
    <span style="color: #ffffff; font-size: 12px;"><strong><span id="p_compare_growth">'; 
$html .= $_POST['pdf_compare_grate'];
$html .= '</span>% growth</strong></span><br>
    <span style="color: #ffffff; font-size: 12px;">Over <span id="p_compare_year">'; 
$html .= $_POST['pdf_year'];
$html .= '</span> years</span>
    <br>
  </td>

</tr>


</table>

';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 255, 115)));
$pdf->SetFillColor(0, 255, 115);
$pdf->RoundedRect(16.2, 123, 69.77, 8, 3.50, '1111', 'DF');

$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 255, 115)));
$pdf->SetFillColor(0, 255, 115);
$pdf->RoundedRect(16.2, 157, 69.77, 8, 3.50, '1111', 'DF');

$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(44, 42, 73)));
$pdf->SetFillColor(44, 42, 73);
$pdf->RoundedRect(122.35, 123, 69.77, 8, 3.50, '1111', 'DF');

$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(44, 42, 73)));
$pdf->SetFillColor(44, 42, 73);
$pdf->RoundedRect(122.35, 157, 69.77, 8, 3.50, '1111', 'DF');

// add a page 4
$pdf->AddPage();
$html = '
<h4 style="font-size: 30px; font-weight: bolder;">Brief Overview</h4>
<h5 style="font-size: 17px;">What is Tenjin AI?</h5>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">
At Tenjin AI we make financial freedom accessible for all by using active investing style and hedge fund like strategies.<br><br>
Unlike traditional investment strategies that park your money in mutual funds and hope it will perform, our technology uses dynamic data and market sentiment to make smart decisions about where the market is headed.<br><br>
This approach allows your portfolio to outperform when the market goes up and shelters it when it goes down.<br><br>
With low minimums and zero locking, we’re opening the door for everyone to create their dream life.<br><br>
</p>
<br><br>
<h5 style="font-size: 17px;">Our Philosophy</h5>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">“At the heart of Tenjin philosophy is the belief that smart investing is for everyone. With advanced investment strategies and options to choose from, Tenjin makes it easy to grow your money at a faster pace - however big or small your portfolio is.”</p>
<br>
Shyam Sreenivasan<br>
Founder/CEO<br>
Tenjin AI<br>
';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page 5
$pdf->AddPage();
$html = '

<h5 style="font-size: 17px;">Tenjin AI Strategies</h5>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">Tenjin AI strategies focuses on investing in an array of stocks and ETFs that is predicted by Tenjin’s advanced AI engine to outperform the market benchmarks in the near to medium term.
<br><br>
Tenjin AI strategies are for investors who want to grow their investment with systematic automated active asset management using advanced AI driven investment strategies, the same style used by hundreds of hedge funds exclusively for the rich and famous. Tenjin AI is breaking the barriers and provides access to such investment styles for all investors and for all risk appetites, customized to the needs of each and every investor. Due to the systematic nature of Tenjin AI strategies, every investors’ investments get high attention and care for the growth of their investments.
<br><br>
<b>Recommended for:</b>
<br><br>
ALL investment goals whether it is Short term investment goals such as for going on an exotic vacation, Medium term investment goals such as buying a property or saving for college education or Long term investment goals such as retirement.
</p>
<br><br>
<h5 style="font-size: 17px;">How does it wok?</h5>
<ol>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">Tenjin’s proprietary AI engine regularly scans the entire investment universe of high quality Stocks and ETFs for the past performance and predicts how it would behave in the current market conditions. Based on that it ranks the stocks and ETFs and creates a well balanced, diversified portfolio for different risk categories and automatically maintains the investments of all the investors.</li>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">Tenjin will monitor your portfolio every day and will rebalance the portfolio automatically with new profitable investments on a regular basis.</li>
</ol>
<br>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">You sit back and relax while Tenjin will manage your money actively and do the rest.</p>
<br><br>
<h5 style="font-size: 17px;">What’s in it for me?</h5>
<ol>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">A smart investing portfolio consisting of Stocks and ETFs</li>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">Automatic reallocation to new stocks and ETFs that is expected to perform well in the near future</li>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">A blend of curated stocks and ETFs aimed at helping you achieve a perfect balance between growth and portfolio volatility</li>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">Ability to select trends of investing with Tenjin AI such as AI & Robotics, Sustainability investing, Cybersecurity, Electric Vehicles, Cloud computing and Marijuana.</li>
</ol>
';

$pdf->writeHTML($html, true, false, true, false, '');

// add a page 6
$pdf->AddPage();
$html = '
<p style="color: #000000; font-family: helvetica; font-size: 14px;">This is ideal for you, if</p>
<br><br>
<ol>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">You are a long term investor but looking to grow your wealth by taking many short term bets</li>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">You are looking for investments in specific stocks poised to trend higher for great return in the short term</li>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">You want high returns on investments and do not mind short term fluctuations in your portfolio value</li>
<li style="color: #000000; font-family: helvetica; font-size: 14px;">You believe in building wealth by ‘taking calculated risks’ and actively seeking investments that has high growth and momentum prospects</li>
</ol>
<br><br><br>
<h5 style="font-size: 17px;">Our Performance</h5>
<br>
<img src="'.plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/images/table_1.PNG">

<h5 style="font-size: 17px;">How are we Different?</h5>
<br>
<img src="'.plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/images/table_2.PNG">
';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page 7
$pdf->AddPage();
$html = '
<h5 style="font-size: 17px;">Get the best value for your money</h5>
<br><br>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">
Step 1: Go to Tenjin AI website > www.tenjin-ai.com<br><br>
Step 2: Select your investing strategy<br><br>
Step 3: Create your own account and start investing
</p>
<br><br><br>
<h5 style="font-size: 17px;">Frequently Asked Questions</h5>
<br><br><br>
<p>
<b>1. What are the benefits of investing with Tenjin AI?</b>
<br><br>
A holistic investment experience tailormade for every investor. We ask you some questions that help us gain insight into your goals and motivations. We can then suggest a portfolio for you to help you meet your goals. In addition, Tenjin acts as your auto-pilot, choosing the best stocks/ETFs for you. This gets you higher returns in a good market and keeps you stable in a turbulent one.
<br><br><br>
<b>2. What are the benefits of investing with Tenjin AI?</b>
<br><br>
Yes. Currently, we only offer our services through Interactive Brokers.
<br><br><br>
<b>3. What returns can I expect?</b>
<br><br>
While not guaranteed, most investors that use Tenjin can expect potential returns of 8%-30% on a pre tax basis.
<br><br><br>
<b>4. How can I monitor my portfolio?</b>
<br><br>
You can view your portfolio in the Tenjin app ( iOS or Android ) or login to your Interactive Broker account.
</p>
';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page 8
$pdf->AddPage();
$html = '
<table cellpadding="10" cellspacing="2">
<tr>
<td width="100">
</td>
<td style="" width="400" align="center">
<img src="'.plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/images/teca-logo.png">
<br><br><br>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">
Tenjin AI Capital Advisors LLC
<br><br>
Toll Free: 1-844-QUANTEL | Email: <a style="color: #000000" href="mailto:support@tenjin-ai.com">support@tenjin-ai.com</a>
<br><br>
Website: <a style="color: #000000" href="https://www.tenjin-ai.com">https://www.tenjin-ai.com</a>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<h5 style="font-size: 17px; text-decoration: underline;">Our Office</h5>
<br>
<h5 style="font-size: 19px;">New York, USA</h5><br><br>
5 Pennsylvania Plaza<br><br>
New York, NY 10001
</p>

</td>
<td width="100">
</td>
</tr>
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page 9
$pdf->AddPage();
$html = '
<h4 style="font-size: 30px; font-weight: bolder;">Disclosures:</h4>
<p style="color: #000000; font-family: helvetica; font-size: 14px;">
a. Tenjin AI Capital Advisors LLC provides advisory services under the brand name Tenjin AI. The content in this document is provided for informational purposes only. No material should be considered as investment advice directly, indirectly, implicitly, or in any manner whatsoever.
<br><br>
b. This report is for the personal use of the authorised recipient only and is not  for public distribution and should not be reproduced or redistributed to any third party or in any form without Tenjin AI’s permission.
<br><br>
c. <b>Net performance</b> is the results of a portfolio (or portions of a portfolio that are included in extracted performance) after the deduction of all fees which is 1.00% and expenses that a client or investor has paid or would have paid in connection with the investment advisor’s investment advisory services to the relevant portfolio. (Fees and expenses are advisory fees, advisory fees paid to an underlying investment vehicle, and payments by the IA for which the client or investor reimburses the IA. Although these can exclude the custodian fees paid to a bank or other third party organization for safekeeping of funds.)
<br><br>
d. <b>Backtested performance</b> and past live trading performance are NOT indicators of future actual results. The results reflect performance of a strategy not historically offered to investors and do NOT represent returns that any investor actually attained. Backtested results are calculated by the retroactive application of a model constructed on the basis of historical data and based on assumptions integral to the model which may or may not be testable and are subject to losses.<br><br>
The backtesting process assumes that the strategy would have been able to purchase the securities recommended by the model and the markets were sufficiently liquid to permit all trading. Changes in these assumptions may have a material impact on the back tested returns presented. Certain assumptions have been made for modeling purposes and are unlikely to be realized. No representations and warranties are made as to the reasonableness of the assumptions. This information is provided for illustrative purposes only.<br><br>
Backtested performance is developed with the benefit of hindsight and has inherent limitations. Specifically, backtested results do not reflect actual trading or the effect of material economic and market factors on the decision making process. Since trades have not actually been executed, results may have under- or over-compensated for the impact, if any, of certain market factors, such as lack of liquidity, and may not reflect the impact that certain economic or market factors may have had on the decision-making process. Further, backtesting allows the security selection methodology to be adjusted until past returns are maximized. Actual performance may differ significantly from backtested performance.
<br><br>
e. Targeted returns presented reflect the investment adviser’s aspirational performance goals and are hypothetical but are being used as a benchmark to describe an investment strategy or objective to measure the success of the strategy. These targeted returns should not be relied upon as the only information received regarding these strategies because specific criteria and assumptions are not factored into the final results. All investors must consider their specific risk tolerances before any financial strategies are chosen for investment purposes.
</p>
';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page 10
$pdf->SetMargins(0, 1.5, 0,true);
$pdf->AddPage();
$html = '
<br>
<table cellpadding="10" cellspacing="2">
<tr>
<td width="30">
</td>
<td style="" width="660">
<p style="color: #000000; font-family: helvetica; font-size: 14px;">
f. Projected returns reflect an investment adviser’s performance estimates, which is often based on historical data and assumptions. Projected returns are being used to  predict a likely return. Tenjin AI is using the Monte Carlo simulation method. All projected returns do not take into consideration general market performance or economic conditions. All investors must consider their specific risk tolerances before any financial strategies are chosen for investment purposes.
<br><br>
g. Tenjin AI investment methodology is based on the Multi-Factor Model and the algorithms encompass the whole stock of the universe. The stocks/ETFs are evaluated on the basis of multiple factors to ensure that only the top high-quality stocks have been considered and included in the strategy. In the next step, Tenjin evaluates the stocks that have a market cap e.g $20 Billion, liquidity of shares ( e.g ADV of 1MM shares ), and meets the sector and industry requirements (e.g VGT, VHT, VCR ) for ETFs the evaluation is on multiple factors such as ETFs that are having an AUM of $100 Million is considered. These ETFs should have an average daily volume of 10,000.Tenjin AI also refrain from investing in Leveraged investing and inverse ETFs. The next step after evaluating stocks/ETFs is the portfolio risk control. For both stocks and ETFs, Tenjin does it by finding less correlated assets or by selecting assets from various industries, sectors etc.
<br><br>
h. Security selection disclosure; The securities recommended in clients accounts are publicly traded companies and are a part of S&P 500 Index. Although Tenjin AI believes its selection process identifies securities with high liquidity, Tenjin AI selection process does not guarantee the quality of a particular security or that it will 1) be profitable, 2) trade in a liquid fashion.<br>
Tenjin AI reserves the right to change at any time the selection of securities that it recommends if, in Tenjin AI sole discretion, any security does not meet requirements for evaluating the universe of stocks or Proprietary algorithm.
Stocks/ETFs are only a type of securities product, and Tenjin AI generally does not make recommendations to Clients other types of securities products that an investor may wish to consider as part of his or her overall financial plan.
<br><br>
i. The use of index-based data is used to provide the performance data that could be achieved by a portfolio, and is hypothetical in nature and the opinions expressed in the Report are our current opinions  and may be subject to change from time to time without notice. Tenjin or any other persons connected with it do not accept any liability arising from the use of this document.
<br><br>
j. Performance results were prepared by Tenjin, and have not been compiled, reviewed or audited by an independent accountant. Performance estimates are subject to future adjustment and revision. Investors should be aware that a loss of investment is possible. Account holdings are for illustrative purposes only and are not investment recommendations. Additional information, including (i) the calculation methodology; and (ii) a list showing the contribution of each holding to the portfolio’s performance during the time period will be provided upon request.
<br>The 8% annualized returns for Conservative,11% for Conservative plus, 15% for Moderate, 21% for Aggressive shown on site is hypothetical and based on our model backtest and does not represent actual trading. The 12.24% market returns are for S&P 500 and 6% returns are for bank deposits.The time period for both returns are from 01/01/2018 to 01/07/2021.
<br><br>
k. Certain investments are not suitable for all investors. Before investing, consider your investment objectives and Tenjin’s fees. The rate of return on investments can vary widely over time, especially for long term investments. Investment losses are possible, including the potential loss of all amounts invested. Brokerage services are provided to Tenjin Clients by Interactive Brokers, an SEC registered broker-dealer and member FINRA/SIPC. Information provided by Tenjin Support is for informational and general educational purposes only and is not investment or financial advice.
</p>
</td>
<td width="20">
</td>
</tr>
</table>
<img src="'.plugin_dir_url( __DIR__ ).'tenjin-calculator/assets/images/pdf_bottom.jpg">
';
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->writeHTML($html, true, false, true, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$file_output = $pdf->Output('', 'S');

			/*End*/

			$file_name = md5(rand()) . '.pdf';
			file_put_contents(plugin_dir_path( __FILE__ ) .'temp_files/'.$file_name, $file_output);

//Email Send

	$filename = $file_name;
    $path = plugin_dir_path( __FILE__ ) .'temp_files';
    $file = $path . "/" . $filename;	
    $mailto = $_POST['txt_email'];
    $subject = 'Your Investment Growth PDF is ready for download';
    $message = 'Hi '.$_POST['txt_fname'].' '.$_POST['txt_lname'].',
Here is your PDF download from the Investment Growth Calculator.
The PDF contains information on your projected investment portfolio with Tenjin AI after considering multiple factors. It also benchmarks your portfolio value when invested with Tenjin AI vs. without Tenjin AI.
Click https://accounts.tenjin-ai.com/ login for Tenjin AI and start investing today.
Sincerely,
Team Tenjin AI';

    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From: Tenjin <wordpress@clickysoft.net>" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";

    //SEND Mail
    if (mail($mailto, $subject, $body, $headers)) {
        echo "mail send ... OK";
    } else {
        echo "ERROR!";
        print_r( error_get_last() );
    }			


		}
 
}
	new TECA_PLUGIN_LOADER();
}