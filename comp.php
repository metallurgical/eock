<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="header">
<?php include( 'header.php' ); ?>
        <div id="header2">
            <div style="position:absolute; top:40px; left:80px;">
            Search Product : <input type="text" name="searchID" size="30" /><input type="button" name="submit" value="Search"/>
            </div>
        </div>
	<div id="backgroundMenu">
        <div id="menu"> 
        	<ul>
                        <li><a href="index.php" class="current" >Home</a></li>
                         <li><a href="product.php">Product</a>
                            <ul>
                                <li><a href="cFood.php">Food</a></li>
                                <li><a href="cStat.php">Stationary</a></li>
                                <li><a href="cDrinks.php">Drinks</a></li>
                            </ul>
                        </li>
                        <li><a href="productH.php">Hot Product</a>
                        	<ul>
                                <li><a href="cFoodH.php">Food</a></li>
                                <li><a href="cStatH.php">Stationary</a></li>
                                <li><a href="cDrinksH.php">Drinks</a></li>
                            </ul>
                        </li>
                       
                       <li><a href="contact.php">Contact</a></li>
                        <li><a href="comp.php">Company</a></li>
            </ul>            
         </div>
         <div id="login"> 
        	
            <ul>
                        <li><a href="registerStaff.php">Register Staff</a></li>
                        <li><a href="loginStaff.php">Login Staff</a></li>
            </ul>            
         </div> 
	</div>
</div>  

<div id="content">
<!--Ko letak data ko kat sni , nnti dia display kat background putih tuh ..-->
	



</div>
<div id="kaki" align="center">Copyright 2014. Elektronic Operation System KIOSK (EOCK)</div> 
</body>
</html>