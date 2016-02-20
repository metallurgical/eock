<?php
session_start();
require_once('Conn/dbconn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/cssstyles.css" />

</head>

<body>
<div id="header">
<?php include( 'header.php' ); ?>
        <div id="header2">
            
        </div>
     </div>   
	<div id="backgroundMenu">
        <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">
<br />
<div id="container" style="box-shadow: inset 0 0 3px rgba(0,0,0,0.4), 0 0 0 5px  #CCC;">
	<ul>
      	<li><img src="images/food/298fc4aa-bcbd-45f2-8b6a-8edf75512a96.jpg" width="604" height="453"/></li>
        <li><img src="images/food/612_chipmore-mentega-rangup.3.jpg" width="604" height="453" /></li>
        <li><img src="images/drink/34633.jpg" width="604" height="453" /></li>
        <li><img src="images/drink/pepsi-images-4.jpg" width="604" height="453" /></li>
        <li><img src="images/stationary/PAPERMATECORRECTIONPENNP107ML.jpg" width="604" height="453" /></li>
        <li><img src="images/stationary/SCISSORASTAR.jpg" width="604" height="453" /></li>
             
      </ul>
      <span class="button prevButton"></span>
      <span class="button nextButton"></span>
</div>
<br />
<script src="js/jquery-1.4.2.min.js"></script>

<script>
$(window).load(function(){
		var pages = $('#container li'), current=0;
		var currentPage,nextPage;
		var timeoutID;
		var buttonClicked=0;

		var handler1=function(){
			buttonClicked=1;
			$('#container .button').unbind('click');
			currentPage= pages.eq(current);
			if($(this).hasClass('prevButton'))
			{
				if (current <= 0)
					current=pages.length-1;
					else
					current=current-1;
			}
			else
			{

				if (current >= pages.length-1)
					current=0;
				else
					current=current+1;
			}
			nextPage = pages.eq(current);	
			currentPage.fadeTo('slow',0.3,function(){
				nextPage.fadeIn('slow',function(){
					nextPage.css("opacity",1);
					currentPage.hide();
					currentPage.css("opacity",1);
					$('#container .button').bind('click',handler1);
				});	
			});			
		}

		var handler2=function(){
			if (buttonClicked==0)
			{
			$('#container .button').unbind('click');
			currentPage= pages.eq(current);
			if (current >= pages.length-1)
				current=0;
			else
				current=current+1;
			nextPage = pages.eq(current);	
			currentPage.fadeTo('slow',0.3,function(){
				nextPage.fadeIn('slow',function(){
					nextPage.css("opacity",1);
					currentPage.hide();
					currentPage.css("opacity",1);
					$('#container .button').bind('click',handler1);				
				});	
			});
			timeoutID=setTimeout(function(){
				handler2();	
			}, 4000);
			}
		}

		$('#container .button').click(function(){
			clearTimeout(timeoutID);
			handler1();
		});

		timeoutID=setTimeout(function(){
			handler2();	
			}, 4000);
		
});

</script>

	<div style="height:400px; width:400px; position: absolute; top: 28px; left: 700px; font-size: 24px; border-radius: 20%; box-shadow: inset 0 0 3px rgba(0,0,0,0.4), 0 0 0 5px  #CCC;">
    <table border="0" cellpadding="2" cellspacing="2" align="center">
    <tr>
    <th width="50">&nbsp;</th>
    <th>Foods</th>
    <td align="center"><a href="cFood.php" ><img src="images/food/back-up.dfd-201_1z.jpg" height="133" width="100" /></a></td></tr>
    
    	<tr >  <th>&nbsp;</th>      
        <th>Drinks</th>
        <td align="center"><a href="cDrinks.php" ><img src="images/drink/A0115907-01_TRUE_1_760x760.jpg" height="141" width="177" /></a></td></tr>
        
        <tr bordercolor="#999999">  <th>&nbsp;</th>      
        <th>Stationary</th>
        <td align="center"><a href="cStat.php" ><img src="images/stationary/119136e.png" height="141" width="177" /></a></td></tr>
    </table>
    </div>


</div>

<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>