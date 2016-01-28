<?php 
if ( !isset( $_SESSION ) ) {
    session_start();
}
if ( !isset( $_SESSION['category'] ) ) { //************************************* no login ?>
    <div id="menu"> 
        <ul>
            <li><a href="index.php" class="current" >Home</a></li>
             <li><a href="product.php">Product</a>
                <ul>
                    <?php
                    $sqlMenu   = "SELECT * FROM `product` group by product_category";
                    $queryMenu = mysql_query( $sqlMenu ) or die("MySQL Error: " . mysql_error()); 
                    $rowMenu   = mysql_num_rows( $queryMenu );
                        
                    $i = 0;
                    while( $dataMenu = mysql_fetch_array( $queryMenu )) {
                        $categoryMenu  = $dataMenu['product_category'];
                        echo '<li><a href="callFood.php?category='.$categoryMenu.'">'.$categoryMenu.'</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li><a href="service.php">Service</a>
                <ul>
                    <li><a href="Printer.php">Printer</a></li>
                    <li><a href="Photostat.php">Photostat</a></li>
                 
                </ul>
            </li>
           
           <li><a href="contact.php">Contact</a></li>
        </ul>            
     </div>
     <div id="login">
        <ul>
            <!-- <li><a href="loginStudent.php"> Login Student</a></li> -->
            <li><a href="viewStaff.php">Register Staff</a></li>
            <li><a href="registerStudent.php">Register Student</a></li>
            <li><a href="loginStaff.php">Login</a></li>
        </ul>            
     </div> 
<?php
}
else if ( isset( $_SESSION['category'] ) && $_SESSION['category'] == 'admin' ) { //************************************* admin ?>
    <div id="menu"> 
        <ul>
            <li><a href="home.php" >Home</a></li>
            <li><a href="productStaff.php">Product</a>
                <ul>
                    <?php
                    $sqlMenu   = "SELECT * FROM `product` group by product_category";
                    $queryMenu = mysql_query( $sqlMenu ) or die("MySQL Error: " . mysql_error()); 
                    $rowMenu   = mysql_num_rows( $queryMenu );
                        
                    $i = 0;
                    while( $dataMenu = mysql_fetch_array( $queryMenu )) {
                        $categoryMenu  = $dataMenu['product_category'];
                        echo '<li><a href="callFood.php?category='.$categoryMenu.'">'.$categoryMenu.'</a></li>';
                    }
                    ?>
                </ul>
            </li>
            </li>
            <li><a href="service.php">Servis</a>
                <ul>
                    <li><a href="Printer.php">Printer</a></li>
                    <li><a href="Photostat.php">Photostat</a></li>
                 
                </ul>
            </li>
            <li><a href="#">Report</a>
                <ul>
                    <li><a href="reportProduct.php">Report Product</a></li>
                    <li><a href="reportService.php">Report Services</a></li>
                    <li><a href="reportProductMonthly.php">Product Monthly</a></li>
                    <li><a href="reportServiceMonthly.php">Service Monthly</a></li>
                 
                </ul>
            </li>
            <li><a href="contactS.php">Contact</a></li>
            <li><a href="#">Manage Staff</a>
                <ul >
                    <li><a href="registerStaff.php">Add Staff</a></li>
                    <li><a href="viewAllStaff.php">View/Delete Staff</a></li>
                </ul>
            </li>
            <li><a href="orderService.php">Order Service</a></li>
            <li><a href="profileStaff.php">
            <?php  echo $_SESSION['UserName'];?> | Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>            
     </div> 
<?php
}
else if ( isset( $_SESSION['category'] ) && $_SESSION['category']== 'student' ) { //************************************* student  ?>
        <div id="menu"> 
        <ul>
            <li><a href="index.php" class="current" >Home</a></li>
             <li><a href="product.php">Product</a>
                <ul>
                    <?php
                    $sqlMenu   = "SELECT * FROM `product` group by product_category";
                    $queryMenu = mysql_query( $sqlMenu ) or die("MySQL Error: " . mysql_error()); 
                    $rowMenu   = mysql_num_rows( $queryMenu );
                        
                    $i = 0;
                    while( $dataMenu = mysql_fetch_array( $queryMenu )) {
                        $categoryMenu  = $dataMenu['product_category'];
                        echo '<li><a href="callFood.php?category='.$categoryMenu.'">'.$categoryMenu.'</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li><a href="service.php">Service</a>
                <ul>
                    <li><a href="studentServices.php?cat=print">Printer</a></li>
                    <li><a href="studentServices.php?cat=fotostat">Photostat</a></li>
                 
                </ul>
            </li>
           
           <li><a href="contact.php">Contact</a></li>
           <li><a href="myOrder.php">My Order</a></li>
           <li><a href="myServices.php">My Services</a></li>
        </ul>            
     </div>
     <div id="login">
        <ul>            
            <li><a href="logout.php">Logout</a></li>
            <li><a href="#">Welcome, <?php echo $_SESSION['username']; ?></a></li>
        </ul>            
    </div>

<?php
}
else if ( isset( $_SESSION['category'] ) && $_SESSION['category'] != 'admin' ) { // staff?>
    <div id="menu"> 
        <ul>
            <li><a href="home.php" >Home</a></li>
            <li><a href="productStaff.php">Product</a>
                <ul>
                    <?php
                    $sqlMenu   = "SELECT * FROM `product` group by product_category";
                    $queryMenu = mysql_query( $sqlMenu ) or die("MySQL Error: " . mysql_error()); 
                    $rowMenu   = mysql_num_rows( $queryMenu );
                        
                    $i = 0;
                    while( $dataMenu = mysql_fetch_array( $queryMenu )) {
                        $categoryMenu  = $dataMenu['product_category'];
                        echo '<li><a href="callFood.php?category='.$categoryMenu.'">'.$categoryMenu.'</a></li>';
                    }
                    ?>
                </ul>
            </li>
            </li>
            <li><a href="service.php">Servis</a>
                <ul>
                    <li><a href="Printer.php">Printer</a></li>
                    <li><a href="Photostat.php">Photostat</a></li>
                 
                </ul>
            </li>
            
            <li><a href="orderService.php">Order Service</a></li>
            <li><a href="contactS.php">Contact</a></li>
            <li><a href="profileStaff.php">
            <?php  echo $_SESSION['UserName'];?> | Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>            
     </div> 
<?php
} ?>
