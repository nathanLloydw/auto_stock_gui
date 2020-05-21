
<?php

$invoice_order = "<?xml version='1.0'?>
<entry xmlns='http://www.w3.org/2005/Atom'
    xmlns:sdata='http://schemas.sage.com/sdata/2008/1' 
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' 
    xmlns:sc='http://schemas.sage.com/sc/2009' 
    xmlns:crm='http://schemas.sage.com/crmErp/2008'>
    <sdata:payload>
        <crm:salesInvoice>
            <crm:carrierTradingAccount>TEST</crm:carrierTradingAccount>
            <crm:invoiceTradingAccount> TEST</crm:invoiceTradingAccount>
            <crm:name>TEST</crm:name>
            <crm:tradingAccount sdata:uuid='494ada02-290b-4358-a977-35e7ae7eae14'>
                <crm:name>test</crm:name>
            </crm:tradingAccount>
            <crm:postalAddresses sdata:uuid='494ada02-290b-4358-a977-35e7ae7eae14'>
                <sc:postalAddress>
                    <sc:active>true</sc:active>
                    <sc:name>Delivery Address</sc:name>
                    <sc:description>Delivery Address</sc:description>
                    <sc:address1>57</sc:address1>
                    <sc:address2>appleby close</sc:address2>
                    <sc:townCity>darlington</sc:townCity>
                    <sc:stateRegion />
                    <sc:zipPostCode>DL1 4AJ</sc:zipPostCode>
                    <sc:country>GB</sc:country>
                    <sc:primacyIndicator>false</sc:primacyIndicator>
                    <sc:type>Shipping</sc:type>
                </sc:postalAddress>
                <sc:postalAddress>
                    <sc:active>true</sc:active>
                    <sc:name>Billing Address</sc:name>
                    <sc:description>Billing Address</sc:description>
                    <sc:address1>57</sc:address1>
                    <sc:address2>appleby close</sc:address2>
                    <sc:townCity>Darlington</sc:townCity>
                    <sc:stateRegion />
                    <sc:zipPostCode>DL1 4AJ</sc:zipPostCode>
                    <sc:country>GB</sc:country>
                    <sc:primacyIndicator>false</sc:primacyIndicator>
                    <sc:type>Billing</sc:type>
                </sc:postalAddress>
            </crm:postalAddresses>
            <crm:salesInvoiceLines>
            <crm:salesInvoiceLine>
                    <crm:type>Standard</crm:type>
                    <crm:commodity sdata:uuid='664faaab-d101-4594-b88e-02b739fc7810'/>
                    <crm:quantity>1</crm:quantity>
                    <crm:initialPrice>4.5</crm:initialPrice>
                    <crm:invoiceLineDiscountAmount>0</crm:invoiceLineDiscountAmount>
                    <crm:invoiceLineDiscountPercent>0</crm:invoiceLineDiscountPercent>
                    <crm:actualPrice>4.5</crm:actualPrice>
                    <crm:netTotal>4.5</crm:netTotal>
                    <crm:taxCodes />
                    <crm:taxTotal>0</crm:taxTotal>
                    <crm:grossTotal>4.5</crm:grossTotal>
                </crm:salesInvoiceLine>
                <crm:salesInvoiceLine>
                    <crm:type>Standard</crm:type>
                    <crm:commodity sdata:uuid='8bfbf273-4b4d-4497-b376-0d75b0eb093c'/>
                    <crm:quantity>1</crm:quantity>
                    <crm:initialPrice>15.99</crm:initialPrice>
                    <crm:invoiceLineDiscountAmount>0</crm:invoiceLineDiscountAmount>
                    <crm:invoiceLineDiscountPercent>0</crm:invoiceLineDiscountPercent>
                    <crm:actualPrice>15.99</crm:actualPrice>
                    <crm:netTotal>15.99</crm:netTotal>
                    <crm:taxCodes />
                    <crm:taxTotal>3.198</crm:taxTotal>
                    <crm:grossTotal>19.188</crm:grossTotal>
                </crm:salesInvoiceLine>
            </crm:salesInvoiceLines>    
            <crm:buyerContact>
                <crm:active>true</crm:active>
                <crm:type>Sales Invoice</crm:type>
                <crm:fullName>Nathan</crm:fullName>
                <crm:Name>Nathan</crm:Name>
                <crm:CompanyName>Nathan</crm:CompanyName>
                <crm:shortName>Nathan</crm:shortName>
                <crm:invoiceTradingAccount>Nathan</crm:invoiceTradingAccount>
                <crm:tradingAccount sdata:uuid='494ada02-290b-4358-a977-35e7ae7eae14'/>
            </crm:buyerContact>
            <crm:user>ORCHARDS</crm:user>
            <crm:text1>ORCHARDS</crm:text1>
            <crm:text2>ORCHARDS</crm:text2>
        </crm:salesInvoice>
    </sdata:payload>
</entry>";

$purchase_order_payloud = "<?xml version='1.0'?>
    <entry xmlns='http://www.w3.org/2005/Atom'
        xmlns:sdata='http://schemas.sage.com/sdata/2008/1' 
        xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' 
        xmlns:sc='http://schemas.sage.com/sc/2009' 
        xmlns:crm='http://schemas.sage.com/crmErp/2008'>
        <sdata:payload>
        <crm:purchaseOrder>
        <crm:active>true</crm:active>
        <crm:reference2 />
        <crm:status />
        <crm:tradingAccount sdata:uuid='ab598355-9064-45bd-839a-cab3b5eb8c2b'>
            <crm:name>test</crm:name>
        </crm:tradingAccount>
        <crm:statusFlagText></crm:statusFlagText>
        <crm:supplierReference />
        <crm:copyFlag>false</crm:copyFlag>
        <crm:carrierNetPrice>0.00</crm:carrierNetPrice>
        <crm:carrierTaxPrice>0.00</crm:carrierTaxPrice>
        <crm:carrierTotalPrice>0.00</crm:carrierTotalPrice>
        <crm:carrierReference>1</crm:carrierReference>
        <crm:currency>GBP</crm:currency>
        <crm:operatingCompanyCurrency>GBP</crm:operatingCompanyCurrency>
        <crm:operatingCompanyCurrencyExchangeRate>1.00</crm:operatingCompanyCurrencyExchangeRate>
        <crm:operatingCompanyCurrencyExchangeRateOperator>/</crm:operatingCompanyCurrencyExchangeRateOperator>
        <crm:date>2020-05-20</crm:date>
        <crm:user>Nathan</crm:user>
        <crm:purchaseOrderLines>
            <crm:purchaseOrderLine>
            <crm:active>true</crm:active>
            <crm:number>1</crm:number>
            <crm:text>(CHINESE) Laila Spanish Long Grain x 20kg</crm:text>
            <crm:quantity>1250.00</crm:quantity>
            <crm:initialPrice>14062.50</crm:initialPrice> 
            <crm:actualPrice>11.25</crm:actualPrice>
            <crm:netTotal>14062.50</crm:netTotal>
            <crm:discountTotal>0.00</crm:discountTotal>
            <crm:taxTotal>0.00</crm:taxTotal>
            <crm:grossTotal>14062.50</crm:grossTotal>
            </crm:purchaseOrderLine>
        </crm:purchaseOrderLines>
        <crm:lineCount>1.00</crm:lineCount>
        <crm:text1 />
        <crm:text2 />
        <crm:netTotal>14062.50</crm:netTotal>
        <crm:taxTotal>0.00</crm:taxTotal>
        <crm:grossTotal>14062.50</crm:grossTotal>
        <crm:SupplierId>SUR001</crm:SupplierId>
        <crm:onOrder />
        </crm:purchaseOrder>
    </sdata:payload>
    </entry>";

$test_PO_payload = "<?xml version='1.0'?>
<entry xmlns='http://www.w3.org/2005/Atom'
    xmlns:sdata='http://schemas.sage.com/sdata/2008/1' 
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' 
    xmlns:sc='http://schemas.sage.com/sc/2009' 
    xmlns:crm='http://schemas.sage.com/crmErp/2008'>
    <sdata:payload>
    <crm:purchaseOrder>
    <crm:active>true</crm:active>
    <crm:reference2 />
    <crm:status />
    <crm:tradingAccount sdata:uuid=14ef6c10-097d-4869-bc67-6eb499466120'>
        <crm:name>test</crm:name>
    </crm:tradingAccount>
    <crm:statusFlagText></crm:statusFlagText>
    <crm:supplierReference />
    <crm:copyFlag>false</crm:copyFlag>
    <crm:carrierNetPrice>0.00</crm:carrierNetPrice>
    <crm:carrierTaxPrice>0.00</crm:carrierTaxPrice>
    <crm:carrierTotalPrice>0.00</crm:carrierTotalPrice>
    <crm:carrierReference>1</crm:carrierReference>
    <crm:currency>GBP</crm:currency>
    <crm:operatingCompanyCurrency>GBP</crm:operatingCompanyCurrency>
    <crm:operatingCompanyCurrencyExchangeRate>1.00</crm:operatingCompanyCurrencyExchangeRate>
    <crm:operatingCompanyCurrencyExchangeRateOperator>/</crm:operatingCompanyCurrencyExchangeRateOperator>
    <crm:date>2020-05-20</crm:date>
    <crm:user>Nathan</crm:user>
    <crm:purchaseOrderLines>
        <crm:purchaseOrderLine>
        <crm:active>true</crm:active>
        <crm:number>1</crm:number>
        <crm:commodity sdata:uuid='b014406d-2e3d-4a42-b905-d946a18080b8'/>
        <crm:quantity>450</crm:quantity>
        <crm:initialPrice>14062.50</crm:initialPrice> 
        <crm:actualPrice>11.25</crm:actualPrice>
        <crm:netTotal>14062.50</crm:netTotal>
        <crm:discountTotal>0.00</crm:discountTotal>
        <crm:taxTotal>0.00</crm:taxTotal>
        <crm:grossTotal>14062.50</crm:grossTotal>
        </crm:purchaseOrderLine>
    </crm:purchaseOrderLines>
    <crm:lineCount>1.00</crm:lineCount>
    <crm:text1 />
    <crm:text2 />
    <crm:netTotal>14062.50</crm:netTotal>
    <crm:taxTotal>0.00</crm:taxTotal>
    <crm:grossTotal>14062.50</crm:grossTotal>
    <crm:SupplierId>SUR001</crm:SupplierId>
    <crm:onOrder />
    </crm:purchaseOrder>
</sdata:payload>
</entry>";

function build_purchase_order_payload($product,$supplier,$quantity,$price)
{
    $total_cost = $price*$quantity;

    $purchase_order_payloud = "<?xml version='1.0'?>
    <entry xmlns='http://www.w3.org/2005/Atom'
        xmlns:sdata='http://schemas.sage.com/sdata/2008/1' 
        xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' 
        xmlns:sc='http://schemas.sage.com/sc/2009' 
        xmlns:crm='http://schemas.sage.com/crmErp/2008'>
        <sdata:payload>
        <crm:purchaseOrder>
        <crm:active>true</crm:active>
        <crm:reference2 />
        <crm:status />
        <crm:tradingAccount sdata:uuid='".$supplier."'>
            <crm:name>test</crm:name>
        </crm:tradingAccount>
        <crm:statusFlagText></crm:statusFlagText>
        <crm:supplierReference />
        <crm:copyFlag>false</crm:copyFlag>
        <crm:carrierNetPrice>0.00</crm:carrierNetPrice>
        <crm:carrierTaxPrice>0.00</crm:carrierTaxPrice>
        <crm:carrierTotalPrice>0.00</crm:carrierTotalPrice>
        <crm:carrierReference>1</crm:carrierReference>
        <crm:currency>GBP</crm:currency>
        <crm:operatingCompanyCurrency>GBP</crm:operatingCompanyCurrency>
        <crm:operatingCompanyCurrencyExchangeRate>1.00</crm:operatingCompanyCurrencyExchangeRate>
        <crm:operatingCompanyCurrencyExchangeRateOperator>/</crm:operatingCompanyCurrencyExchangeRateOperator>
        <crm:date>2020-05-20</crm:date>
        <crm:user>Nathan</crm:user>
        <crm:purchaseOrderLines>
            <crm:purchaseOrderLine>
            <crm:active>true</crm:active>
            <crm:number>1</crm:number>
            <crm:commodity sdata:uuid='".$product."'/>
            <crm:quantity>".$quantity."</crm:quantity>
            <crm:initialPrice>".$total_cost."</crm:initialPrice> 
            <crm:actualPrice>".$price."</crm:actualPrice>
            <crm:netTotal>".$total_cost."</crm:netTotal>
            <crm:discountTotal>0.00</crm:discountTotal>
            <crm:taxTotal>0.00</crm:taxTotal>
            <crm:grossTotal>".$total_cost."</crm:grossTotal>
            </crm:purchaseOrderLine>
        </crm:purchaseOrderLines>
        <crm:lineCount>1.00</crm:lineCount>
        <crm:text1 />
        <crm:text2 />
        <crm:netTotal>14062.50</crm:netTotal>
        <crm:taxTotal>0.00</crm:taxTotal>
        <crm:grossTotal>14062.50</crm:grossTotal>
        <crm:SupplierId>SUR001</crm:SupplierId>
        <crm:onOrder />
        </crm:purchaseOrder>
    </sdata:payload>
    </entry>";

    return $purchase_order_payloud;
}



?>