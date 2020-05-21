<?php

# includes all the neccesary styles and javascripts files to run the system.
echo "<link rel='stylesheet' href='../../css/nav_bar_styles.css'>";
echo "<link rel='stylesheet' href='../../css/shared_table_styles.css'>";
echo "<link rel='stylesheet' href='../../css/shared_main_styles.css'>";
echo "<script type='text/javascript' src='../../js/main.js'></script>";
echo "<script src=\"https://kit.fontawesome.com/a076d05399.js\"></script>";

echo "<div class='nav'> <a href='../../index.php'class='logobutton'><img class='logo' src='../../imgs/logo.svg'></a></a>";

# gets the name of the file using this file
$file = $_SERVER['PHP_SELF'];

# if the file name contains product we show that by setting it as active which affects the stylesheet. 
if(strpos($file,'product'))
{
    echo "<a class='active' href='../../views/products/products.php'>Stock</a>";
}
else
{
    echo "<a href='../../views/products/products.php'>Stock</a>";
}

# if the file name contains supplier we show that by setting it as active which affects the stylesheet. 
if(strpos($file,'supplier'))
{
    echo "<a class='active' href='../../views/suppliers/suppliers.php'>suppliers</a>";
}
else
{
    echo "<a href='../../views/suppliers/suppliers.php'>suppliers</a>";
}

# if the file name contains customer we show that by setting it as active which affects the stylesheet. 
if(strpos($file,'customer'))
{
    echo "<a class='active' href='../../views/customers/customers.php'>customers</a>";
}
else
{
    echo "<a href='../../views/customers/customers.php'>customers</a>";
}

echo "<div class='dropdown'>";

# if the file name contains warehouse we show that by setting it as active which affects the stylesheet. 
if(strpos($file,'warehouse'))
{
    echo "<button class='dropbtn-active'>Warehouse ";
}
else
{ 
    echo "<button class='dropbtn'>Warehouse ";
}
    
echo "<i class='fa fa-caret-down'></i>
        </button>
          <div class='dropdown-content'>
            <a href='../../views/warehouse/warehouseDriverSheets.php'>view driver sheets</a>
            <a href='../../views/warehouse/warehouseDriverRuns.php'>view driver Runs</a>
          </div>
    </div>";

echo "<div class='dropdown'>";

# if the file name contains Order we show that by setting it as active which affects the stylesheet. 
if(strpos($file,'Order'))
{
    echo "<button class='dropbtn-active'>Orders ";
}
else
{ 
    echo "<button class='dropbtn'>Orders ";
}
    
echo "<i class='fa fa-caret-down'></i>
        </button>
          <div class='dropdown-content'>
            <a href='../../views/orders/currentOrdersIn.php'>current purchase orders</a>
            <a href='../../views/orders/uploadOrchardOrders.php'>import orchard orders</a>
            <a href='../../views/orders/ordersCallList.php'>call list</a>
            <a href='../../views/orders/SuggestedOrders.php'>suggested orders</a>
          </div>
    </div>";

echo "<div class='dropdown'>";

# if the file name contains Report we show that by setting it as active which affects the stylesheet. 
if(strpos($file,'Report'))
{
    echo "<button class='dropbtn-active'>Reports ";
}
else
{
    echo "<button class='dropbtn'>Reports ";
}

echo "<i class='fa fa-caret-down'></i>
        </button>
            <div class='dropdown-content'>
            <a href='../../views/reports/orchardReport.php'>Orchard Vine</a>
            <a href='../../views/reports/wholeSaleReport.php'>DLS Wholesale</a>
            <a href='../../views/reports/smallSaleReport.php'>DLS Smallsale</a>
            <a href='../../views/reports/staffReports.php'>DLS Staff</a>
            </div>
        </div>";


echo "<i class='fas fa-search' style='color:white;margin:14px 14px 0px 0px;font-size:22px;float:right;padding-left: 10px;'></i><input type='text' id='Input' onkeyup='search()' placeholder=' Search here'></div>";
?>