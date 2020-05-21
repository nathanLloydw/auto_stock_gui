<?php

$path = "S:/dev/OrchardOrders/";

if(isset($_FILES['order']))
{
    $errors= array();
    $file_name = $_FILES['order']['name'];
    echo $file_name;
    $file_size =$_FILES['order']['size'];
    $file_tmp =$_FILES['order']['tmp_name'];
    $file_type=$_FILES['order']['type'];

    $file_ext= (explode('.',$file_name))[1];

    $extentions = array("csv","xlsx");
    
    if(in_array($file_ext,$extentions)=== false)
    {
       $errors[]="extension not allowed, please choose a csv or xlsx file.";
    }
    
    if($file_size > 2097152)
    {
       $errors[]='File size must be smaller than 2 MB';
    }
    
    if(empty($errors)==true)
    {
        move_uploaded_file($file_tmp,$path."files/".$file_name);
        echo "Success <br>";

        $newFileData = array();
        $data = array("ACCOUNT_REF","ADDRESS_1","ADDRESS_2","ADDRESS_3","ADDRESS_4","ADDRESS_5","AMOUNT_PREPAID","PAYMENT_REF","ANALYSIS_1","BANK_CODE","CARR_DEPT_NUMBER","CARR_NET","CARR_TAX","CARR_TAX_CODE","CONTACT_NAME","COURIER","CUST_COUNTRY_CODE","CUST_CURRENCY_CODE","CUST_DEPT_NUMBER","CUST_DISC_RATE","CUST_EMAIL","CUST_TAX_CODE","CUST_TAX_OVERRIDE","CUST_TEL_NUMBER","DISCOUNT_TYPE","EMAILED","EURO_GROSS","EURO_RATE","FOREIGN_GROSS","FOREIGN_RATE","GDN_NUMBER","GLOBAL_DEPT_NUMBER","GLOBAL_TAX_CODE","HAS_EXTERNAL_LINK","INVOICE_DATE","INVOICE_FOREIGN_BALANCE","INVOICE_TYPE","NAME","NETVALUE_DISCOUNT","PAYMENT_DUE_DATE","PAYMENT_TAX_CODE","PAYMENT_TYPE","POSTED_CODE","PRINTED_CODE","QUOTE_STATUS","SEND_VIA_EMAIL","SETTLEMENT_DISC_RATE","SETTLEMENT_DUE_DAYS","STATUS","TAKEN_BY","DEPT_NUMBER","DISCOUNT_AMOUNT","DISCOUNT_RATE","EXT_ORDER_LINE_REF","FULL_NET_AMOUNT","FUND_NUMBER","IS_NEGATIVE_LINE","GROSS_AMOUNT","ITEM_NUMBER","NET_AMOUNT","QTY_ORDER","SERVICE_AMOUNT","SERVICE_TEXT","STOCK_CODE","STOCK_ITEM_TYPE","TAX_AMOUNT","TAX_CODE","TAX_FLAG","TAX_RATE","UNIT_PRICE");
        array_push($newFileData,$data);

        $firstLoop = False;
        $looped = true;
        $lastInv = 1;
        $acountRef ="ORCHARDV";
        $ItemNumber = 1;
        $orderId = 00;
        
        $invNumber = 0;

        $fh = fopen('../../data/invNum.txt','r');
        $invNumber = (int) fgets($fh);
        fclose($fh);

        echo "uploading orders from order id: ".($invNumber+1)." and on:<br>";


        $fileHandle = fopen($path."files/".$file_name, "r");
        while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) 
        {
            if($firstLoop)
            {
                if($orderId != $row[0])
                {
                    if ($acountRef == "ORCHARDV"){$acountRef = "ORCHARD";} else {$acountRef= "ORCHARDV";}
                    $orderId = $row[0];
                    $ItemNumber = 1;
                    $email = $row[1];
                    $date = substr($row[3],0,10);
                    $orderId = $row[0];
                    $totalPrice = $row[11];
                    $discountCode = explode(",",$row[12]);
                    $contactPhone = $row[39];
                    $contactName = $row[32];
                    $shippingAddress1 = $row[33];
                    $shippingAddress2 = $row[34];
                    $shippingAddress3 = $row[35];
                    $shippingAddress5 = $row[36];
                    $taxCode = 0;
                    $taxAmount = 0;
                    $taxRate = 0;

                    //if($totalPrice >= 100)
                    //{
                    //    $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber,'0','1','0','','CN700','0','0',$taxCode,'0',$taxRate,'0');
                    //    array_push($newFileData,$data); 

                    //    $ItemNumber = $ItemNumber + 1;
                    //}

                    if($discountCode[0] == "VEGBUNDLE" && $orderId > $invNumber)
                    {
                        echo "getting discount\n";
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber,'0','1','0','','ORR700','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0','1','0','','FV611','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0','1','0','','FV612','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0','1','0','','FV601','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0','1','0','','FV604','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0','1','0','','FV602','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0','1','0','','FV610','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+7,'0','1','0','','FV635','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+8,'0','1','0','','FV620','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+9,'0','1','0','','FV607','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+10,'0','1','0','','FV614','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+11,'0','1','0','','FV609','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+12,'0','1','0','','FV621','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+13,'0','1','0','','FV600','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+14,'0','1','0','','FV619','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $ItemNumber = $ItemNumber + 15;
                    }

                    if($discountCode[0] == "FRUITBUNDLE" && $orderId > $invNumber)
                    { 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber,'0','1','0','','FV500','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0','1','0','','FV501','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0','1','0','','FV502','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0','1','0','','FV503','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0','1','0','','FV504','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0','1','0','','FV505','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0','1','0','','FV506','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+7,'0','1','0','','FV507','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+8,'0','1','0','','FV508','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+9,'0','1','0','','FV509','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+10,'0','1','0','','FV510','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+11,'0','1','0','','FV511','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+12,'0','1','0','','FV512','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+13,'0','1','0','','FV513','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 14;
                    }

                    if($looped && $orderId > $invNumber)
                    {
                        $lastInv = $orderId;
                        $looped = false;
                    }
                }
                 
                $itemQuantity = $row[16];
                $itemPrice = $row[18];
                $taxedItemPrice = $itemPrice;
                $itemCode = $row[19];
                $taxCode = 0;
                $taxAmount = 0;
                $taxRate = 0;
    
               
                if (substr($itemCode,0,2)=="DR" || substr($itemCode,0,2)=="PG" || substr($itemCode,0,2)=="SD" || substr($itemCode,0,2)=="WS" || substr($itemCode,0,2)=="CM")
                {
                    $taxCode = 1;
                    $taxRate = 20;
                    
                    $taxedItemPrice = $itemPrice / 1.2;
                    $taxAmount = $itemPrice - $taxedItemPrice;
                }

                if($orderId > $invNumber)
                {
                    echo $orderId."<br>"; 
                    
                    if($itemCode=='FV800-1')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','ORR700','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','FV611','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0',$itemQuantity,'0','','FV612','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0',$itemQuantity,'0','','FV601','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0',$itemQuantity,'0','','FV604','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0',$itemQuantity,'0','','FV602','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+7,'0',$itemQuantity,'0','','FV610','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+8,'0',$itemQuantity,'0','','FV635','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+9,'0',$itemQuantity,'0','','FV620','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+10,'0',$itemQuantity,'0','','FV607','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+11,'0',$itemQuantity,'0','','FV614','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+12,'0',$itemQuantity,'0','','FV609','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+13,'0',$itemQuantity,'0','','FV621','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+14,'0',$itemQuantity,'0','','FV600','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+15,'0',$itemQuantity,'0','','FV619','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 15;
                    }
                    else if($itemCode=='ORM892')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','ORM810','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','ORM802','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0',$itemQuantity,'0','','FV609','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0',$itemQuantity,'0','','SU311','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0',$itemQuantity,'0','','FV601','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0',$itemQuantity,'0','','SU001','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+7,'0',$itemQuantity*2,'0','','PB730','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 7;
                    }
                    else if($itemCode=='ORM891')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',2*$itemQuantity,'0','','ORM802','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','CS700','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0',$itemQuantity,'0','','CS204','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0',$itemQuantity,'0','','WS200','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data);

                        $ItemNumber = $ItemNumber + 4;
                    }
                    else if($itemCode=='ORM890')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','ORM803','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','CS701','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0',$itemQuantity,'0','','CS202','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0',$itemQuantity,'0','','ORV120','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0',$itemQuantity,'0','','SD511','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0',$itemQuantity,'0','','WS200','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 6;
                    }
                    else if($itemCode=='FV900')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','FV635','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','SU306','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 2;
                    }
                    else if($itemCode=='BS900')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','BS105','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','SU301','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 2;
                    }
                    else if($itemCode=='FV550')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','FV500','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','FV501','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0',$itemQuantity,'0','','FV502','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0',$itemQuantity,'0','','FV503','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0',$itemQuantity,'0','','FV504','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0',$itemQuantity,'0','','FV505','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+7,'0',$itemQuantity,'0','','FV506','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+8,'0',$itemQuantity,'0','','FV507','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+9,'0',$itemQuantity,'0','','FV508','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+10,'0',$itemQuantity,'0','','FV509','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+11,'0',$itemQuantity,'0','','FV510','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+12,'0',$itemQuantity,'0','','FV511','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+13,'0',$itemQuantity,'0','','FV512','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+14,'0',$itemQuantity,'0','','FV513','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 14;
                    }
                    else if($itemCode=='FV540')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','FV500','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','FV501','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0',$itemQuantity,'0','','FV502','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0',$itemQuantity,'0','','FV503','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0',$itemQuantity,'0','','FV504','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0',$itemQuantity,'0','','FV505','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+7,'0',$itemQuantity,'0','','FV509','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+8,'0',$itemQuantity,'0','','FV521','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+9,'0',$itemQuantity,'0','','FV522','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 9;
                    }
                    else if($itemCode=='ORM890')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','ORM803','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity,'0','','CS701','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+3,'0',$itemQuantity,'0','','CS202','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+4,'0',$itemQuantity,'0','','ORV120','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+5,'0',$itemQuantity,'0','','SD511','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+6,'0',$itemQuantity,'0','','SD511','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 6;
                    }
                    else if($itemCode=='CN900')
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+1,'0',$itemQuantity,'0','','CN700','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0','0','0','0','0',$ItemNumber+2,'0',$itemQuantity*2,'0','','ORM801','0','0',$taxCode,'0',$taxRate,'0');
                        array_push($newFileData,$data); 

                        $ItemNumber = $ItemNumber + 2;
                    }
                    else
                    {
                        $data = array($acountRef,$shippingAddress1,$shippingAddress2,$shippingAddress3,$contactPhone,$shippingAddress5,$totalPrice,$orderId,$orderId,'1256','0','0','0','1',$contactName,'1','GB','GBP','0','0',$email,'1','0',$contactPhone,'0','0','0','0',$totalPrice,'1','0','0','1','0',$date,$totalPrice,'IP',$orderId.' '.$contactName.' PRE-PAID ','0',$date,'0','4','0','0','0','0','0','0','0','ORCHARDS','0','0','0','0',$itemQuantity*$taxedItemPrice,'0','0',$itemQuantity*$itemPrice,$ItemNumber,$itemQuantity*$taxedItemPrice,$itemQuantity,$itemPrice,'',$itemCode,'0',$taxAmount,$taxCode,'0',$taxRate,$taxedItemPrice);
                        array_push($newFileData,$data); 
                    }
                    
                    $ItemNumber += 1; 
                }
            }
            else
            {
                $firstLoop = TRUE;
            }
            
        }

        if(!$looped)
        {
            $newFilePath = $path."/import/".$invNumber."-".$lastInv.".csv";
            $file = fopen($newFilePath, 'w');

            foreach($newFileData as $line)
            {
                fputcsv($file,$line);
            }
        
            fclose($file);   
        }
        
        $fh = fopen('../../db/invNum.txt','w');
        fwrite($fh, $lastInv);
        fclose($fh);
        
    }
    else
    {
       print_r($errors);
    }
 }





?>