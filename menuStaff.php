<div id="menuStaff"> 
    <ul>
        <li><a href="home.php" >Home</a></li>
        <li><a href="productStaff.php">Product</a>
            <ul >
                <li><a href="cFoodS.php">Food</a></li>
                <li><a href="cStatS.php">Stationary</a></li>
                <li><a href="cDrinksS.php">Drinks</a></li>
            </ul>
        </li>
        </li>
        <li><a href="Servis.php">Servis</a>
        	<ul>
                <li><a href="Printer.php">Printer</a></li>
                <li><a href="Photostat.php">Photostat</a></li>
             
            </ul>
        </li>
        <li><a href="contactS.php">Contact</a></li>
        <li><a href="profileStaff.php">
    	<?php  echo $_SESSION['UserName'];?> | Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>   
</div>