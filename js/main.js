var table, rows, i, x, y,total,asc = true,active_table = '',run_num=1,copied_row='';

function search()
{
    console.log("test");
    var input, filter, table, tr, td, i;
    input = document.getElementById("Input");
    filter = input.value.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++)
    {
        // Hide the row initially.
        tr[i].style.display = "none";

        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++)
        {
            cell = tr[i].getElementsByTagName("td")[j];
            if (cell) {
                if (cell.innerHTML.toUpperCase().indexOf(filter) > -1)
                {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}

function stockCheck()
{
    var table = document.getElementById("table");
    var tr = table.getElementsByTagName("tr");

    for(var i = 1; i < tr.length; i++)
    {
        td = tr[i].getElementsByTagName("td");
        if (td[5].innerText < 5)
        {
            td[5].style.color = "red";
            td[5].style.fontWeight = "bold";
        }
        else if(td[5].innerText < 10)
        {
            td[5].style.color = "orange";
            td[5].style.fontWeight = "bold";
        }

    }
}

function getSupplier(row,id,route)
{
    selectRow(row,route)

    stats = document.getElementById("stats-left");
    space = String.fromCharCode(13);
    
    if(window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            result = this.responseText;
            results = result.split("-"); 

            stats.innerText = space;
            stats.innerText += "ID : "+id+space+space+space;
            stats.innerText += "Contact Name : "+results[0]+space+space;
            stats.innerText += "Contact Telephone : "+results[1]+space+space;
            stats.innerText += "Contact Email Address : "+results[2]+space+space;
        }
    };
    xmlhttp.open("GET","getSupplier.php?id="+id,true);
    xmlhttp.send();
}

function getProduct(row,id)
{
    selectRow(row,'')
    
    stats = document.getElementById("stats-left");
    space = String.fromCharCode(13);
    
    if(window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            result = this.responseText;
            results = result.split("-"); 
            console.log(results);

            stats.innerText = space;
            stats.innerText += "ID : "+id+space+space+space;
            stats.innerText += results[0]+" Used"+space+space;
            stats.innerText += "In the past "+results[1]+" Orders"+space+space;
            stats.innerText += "since : "+results[2]+"-"+results[3]+"-"+results[4]+space+space;
        }
    };
    xmlhttp.open("GET","getProduct.php?id="+id,true);
    xmlhttp.send();
}

function get_customer_details(row,id,route)
{
    console.log(id);
    console.log(route);
    selectRow(row,route);
    
    stats = document.getElementById("stats-left details");
    space = String.fromCharCode(13);
    
    xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            result = this.responseText;
            results = result.split("/"); 

            stats.innerText = space;
            stats.innerText += "ID : "+id+space+space+space;
            stats.innerText += "Company : "+results[1]+space+space+space;
            stats.innerText += "Address : "+results[2]+space+space+space;
            stats.innerText += "Phone : "+results[3]+space+space+space;
        }
    
    };
    xmlhttp.open("GET","../customers/getCustomerDetails.php?id="+id,true);
    xmlhttp.send();
}


function getCustomer(row,id,route)
{
    console.log(id);
    console.log(row);
    console.log(route);
    selectRow(row,route);
    
    stats = document.getElementById("stats-left");
    space = String.fromCharCode(13);
    
    if(window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            result = this.responseText;
            console.log(result);
            results = result.split("/"); 

            stats.innerText = space;
            stats.innerText += "ID : "+id+space+space+space;
            stats.innerText += "Last Order placed : "+results[1]+space+space+space;
            stats.innerText += "Orders Placed : "+results[3]+space+space+space;
            stats.innerText += "Average Days Between Orders : "+results[4]+space+space+space;
            stats.innerText += "predicted next order : "+results[5]+space+space+space;
            stats.innerText += "Days till predicted order : "+results[6]+space+space+space;
            
        }
    
    };
    xmlhttp.open("GET","getCustomer.php?id="+id,true);
    xmlhttp.send();
}

function selectRow(selectedRow,route)
{
    if (route == '')
    {
        table = document.getElementById("table");
    }
    else
    {
      table = document.getElementById(route);  
    }
    
    tr = table.getElementsByTagName("tr");


    for (i = 1; i < tr.length; i++)
    {
        tr[i].className = '';
    }

    selectedRow.className = 'active';
}

function post_customer_status(vars)
{

    var id,status,opening_hour = null;
    vars = vars.split(",");

    id = vars[0];
    status = vars[1];
    route = vars[2];

    opening_hour = document.getElementById(id+'_opening_hour').value;
    notes = document.getElementById(id).value;


    xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            result = this.responseText;
            console.log(result);  
            window.location.replace("http://192.168.1.94/views/orders/ordersCallList.php?route="+route);    
        }
    
    };
    xmlhttp.open("GET","post_customer_status.php?customer="+id+"&code="+status+"&notes="+notes+"&hour="+opening_hour,true);
    xmlhttp.send();
}


function report_earnings(totalProfit,totalSalesPrice,totalCostPrice)
{
    space = String.fromCharCode(13);
    stats = document.getElementById("stats-left");
    stats.innerText = "£"+totalProfit+" made since 2020-03-27.";
    stats.innerText += space;
    stats.innerText += "£"+totalSalesPrice+" revenue made.";
    stats.innerText += space;
    stats.innerText += "£"+totalCostPrice+" cost.";
    stats.innerText += space;
    margin = parseFloat((totalSalesPrice-totalCostPrice)/totalSalesPrice*100).toFixed(2);

    stats.innerText += "average margin: "+margin+"%";

}

function changeTab(evt,location)
{
    active_table = location;
    tables = document.getElementsByTagName("table");

    for (i = 0; i < tables.length; i++) 
    {
        tables[i].style.display = "none";
    }

    location_runs = document.getElementsByClassName(location);
    for(x = 0; x < location_runs.length;x++)
    {
        location_runs[x].style.display = "table";
    }
}

function changeCallListTab(evt,location)
{
    console.log(location);
    tabs = document.getElementsByClassName('tabcontent');

    for (i = 0; i < tabs.length; i++) 
    {
        tabs[i].style.display = "none";
    }

    todays_call_list = document.getElementById(location);
    todays_call_list.style.display = "table";
}

function create_table()
{
    new_table = active_table;
    run_num = run_num + 1;
    rowCount = 1;
    table_count = document.getElementById('table '+new_table);
    var d = new Date();
    day = d.getDate();
    month = d.getMonth()+1;
    year = d.getFullYear();
    
    if (day < 10){day = '0'+day;}
    if (month < 10){month = '0'+month;}

    date = year+'-'+month+'-'+day;

    table =
    `<table class='`+new_table+`' id='`+new_table+` `+run_num+`' class='tabcontent' style=display:table;margin-top:5px;'>
            <tbody>
            <tr> 
                <th> run `+run_num+`</th>
                <th>customer ID</th> 
                <th>Order Reference</th> 
                <th>Address</th> 
                <th>town/city</th> 
                <th>postCode</th>
                <th><button id='weight `+new_table+` `+run_num+`' onclick='updateWeight(`+`"`+new_table+'"'+","+run_num+`)'>0.0KG</button></th>
                <th><button onclick='printRun(`+`"`+new_table+'"'+","+run_num+`)'>Print Run</button></th>
            </tr>
            <tr id='`+new_table+` `+run_num+` 100' > 
                <td>
                    <i onClick='deleteRow(event,"`+new_table+`",`+run_num+`,100)' class='fas fa-times-circle' style='font-size:18px;padding-left:12px;'> </i>
                </td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td>
                <td></td>
                <td>
                    <i onClick='copyRow(event,"`+new_table+`",`+run_num+`,100,"`+date+`")' class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                </td>
            </tr>
        </tbody>`;
    tableLocation = document.getElementById('warehouse_body').insertAdjacentHTML('beforeend',table);
}

function deleteRow(event,table,run_num,row)
{
    console.log(table,run_num,row);
    tr = document.getElementById(table+" "+run_num+" "+row);
    console.log(tr);

    if(tr.parentNode.rows.length < 3)
    {
        tr.parentNode.parentNode.innerHTML = '';

    }
    else
    {
        tr.parentNode.parentNode.deleteRow(tr.parentNode.rows.length-1);
    }
}

function copyRow(event,table,run,row,date)
{
    if(copied_row != '')
    {
       if (copied_row.id == table+" "+run+" "+row)
       {
            tr = document.getElementById(table+" "+run+" "+row);
            tr.cells[7].innerHTML = `<td>
                                        <i onClick='copyRow(event,`+'"'+table+'",'+run+","+row+',"'+date+'"'+`)' class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                                    </td>`;
            copied_row='';
       }
       else
       {
            table_rows = document.getElementById(table+" "+run).rows.length;
            tr = document.getElementById(table+" "+run+" "+row);

            id = copied_row.id;
            id = id.split(" ");

            new_table = id[0];
            new_run = id[1];
            new_row = id[2];

            console.log(copied_row.parentNode);
            console.log("rows : "+copied_row.parentNode.rows.length);
            row_count = copied_row.parentNode.rows.length;

            copied_row.cells[7].innerHTML = `<td>
                                                 <i onClick='copyRow(event,`+'"'+new_table+'",'+run+","+new_row+',"'+date+'"'+`)' class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                                             </td>`; 

            copied_row.cells[0].innerHTML = `<td>
                <input type='text' id='input-`+new_table+"-"+run+"-"+new_row+"' name='fname' value='"+new_row+`' style='width:25px;height:19px;'>
                <i onClick='moveRow(event,`+'"'+new_table+'"'+", "+run+", "+new_row+","+'"'+date+'"'+`)' class='fas fa-check-circle' style='font-size:18px;padding-left:12px;'> </i>
            </td>`; 

            
            if(row_count < 3)
            {
                copied_row.parentNode.parentNode.innerHTML = '';
            }

            table = document.getElementById(table+" "+run+" "+row).parentNode.insertBefore(copied_row,tr); 

            copied_row.id = new_table+' '+run+' '+new_row;
            copied_row='';
            moveRow(event,new_table,run,new_row,date);
       }
    }
    else
    {
        tr = document.getElementById(table+" "+run+" "+row);

        copied_row = tr;
        tr.cells[7].innerHTML = `<td>
                                    <i onClick='copyRow(event,`+'"'+table+'",'+run+","+row+',"'+date+'"'+`)' class='fas fa-paste' style='font-size:18px;padding-left:12px;'> </i>
                                 </td>`;

     
    }
}

function moveRow(event,location,run_num,row_num,date)
{
    input = document.getElementById('input-'+location+'-'+run_num+'-'+row_num).value;

    current_row = document.getElementById(location+" "+run_num+" "+row_num);
    next_row = document.getElementById(location+" "+run_num+" "+input);
    next_row.parentNode.insertBefore(current_row,next_row);

    table = current_row.parentNode;
    size = table.rows.length;

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            result = this.responseText; 
        }
    };

    for(var i = 1; i < size-1;i++)
    {
        if(table.rows[i]!= undefined && table.rows[i].cells[0] != undefined && table.rows[i].id != location+' '+run_num+' 100')
        {
            customer_id = table.rows[i].cells[1].innerText;
            xmlhttp.open("GET","update_runs.php?customer="+customer_id+"&location="+location+"&run_num="+run_num+"&row="+i+"&date="+date,true);
            xmlhttp.send();

            table.rows[i].id = location+' '+run_num+' '+i;
        
            if(customer_id != '')
            {
                table.rows[i].cells[0].innerHTML = `<td>
                                <input type='text' id='input-`+location+"-"+run_num+"-"+i+"' name='fname' value='"+i+`' style='width:25px;height:19px;'>
                                <i onClick='moveRow(event,`+'"'+location+'"'+", "+run_num+", "+i+',"'+date+`")' class='fas fa-check-circle' style='font-size:18px;padding-left:12px;'> </i>
                            </td> `;
                table.rows[i].cells[7].innerHTML = `<td>
                                                    <i onClick='copyRow(event,`+'"'+location+'",'+run_num+","+i+',"'+date+'"'+`)' class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                                                    </td>`;
            }
        }
            
    }
}

function updateWeight(location,location_run_num)
{
    table = document.getElementById(location+" "+location_run_num);
    button = document.getElementById('weight '+location+" "+location_run_num);

    weight = 0.0;
    size = table.rows.length;

    for(i = 1; i < size;i++)
    {
        weight = weight + Number(table.rows[i].cells[6].innerHTML);
    }

    button.innerText = weight.toFixed(2)+'KG';
}

function printRun(location,location_run_num)
{
    table = document.getElementById(location+" "+location_run_num).innerHTML;
    nav = document.getElementsByClassName('nav');

    console.log(table);
    page = document.body.innerHTML;
    document.body.innerHTML=`<style type="text/css" media="print"> 
    @media print 
    {
    
        @page 
        {
            size: A4 landscape;max-height:100%; max-width:100%
        }
    
        img 
        { 
            height: 90%; margin: 0; padding: 0; 
        }
    
    body
    {
        width:100%;
        height:100%;
    }  
    
    
    </style><table style='margin-top:55px;font-size:10px;'>`+table+'</table>';

    print();

    document.body.innerHTML=page;

}


function post_order(event,product,supplier,price)
{
    quantity = document.getElementById(supplier+"-"+product).value;
    confirmation_box = document.getElementById("order-"+supplier+"-"+product);

    if(quantity != '')
    {
        confirmation_box.style.color='green';
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function()
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                result = this.responseText;
                console.log(result);  
            }
        
        };
        xmlhttp.open("GET","post_order.php?product="+product+"&supplier="+supplier+"&quantity="+quantity+"&price="+price,true);
        xmlhttp.send();

    }
    else
    {
        confirmation_box.style.color='red';
    }
}



