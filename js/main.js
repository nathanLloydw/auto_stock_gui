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

    console.log(active_table);
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
    console.log(new_table);
    rowCount = 1;
    table_count = document.getElementById('table '+new_table);

    table =
    `<table class='`+new_table+`' id='`+new_table+` `+run_num+`' class='tabcontent' style=display:table;margin-top:5px;'>
            <tbody>
            <tr> 
                <th> run `+run_num+`</th>
                <th>customer ID</th> 
                <th>Order Reference</th> 
                <th>Name</th> 
                <th>Address</th> 
                <th>town/city</th> 
                <th>postCode</th>
                <th>weight</th>
            </tr>
            <tr id='`+new_table+` `+run_num+` `+rowCount+`' > 
                <td onClick='copyRow(event,"`+new_table+`",`+run_num+`,1)'>
                    <i class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                </td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td>
                <td></td>
            </tr>
        </tbody>`;
    tableLocation = document.getElementById('warehouse_body').insertAdjacentHTML('beforeend',table);
}

function copyRow(event,table,run,row)
{
    console.log(table);
    console.log(row);
    console.log(run);
    if(copied_row != '')
    {
       console.log(copied_row.id); 
       if (copied_row.id == table+" "+run+" "+row)
       {
            tr = document.getElementById(table+" "+run+" "+row);
            tr.cells[0].innerHTML = `<td onClick='copyRow(event,`+'"'+table+'","'+row+'"'+`)'>
                                        <i class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                                    </td>`;
            copied_row='';
       }
       else
       {
            tr = document.getElementById(table+" "+run+" "+row);
            copied_row.cells[0].innerHTML = `<td onClick='copyRow(event,`+'"'+table+'","'+row+'"'+`)'>
                                                <i class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                                             </td>`;
            table = document.getElementById(table+" "+run+" "+row).parentNode.insertBefore(copied_row,tr);
            copied_row='';

            //recalculate run weights. 
       }
    }
    else
    {
        tr = document.getElementById(table+" "+run+" "+row);
        copied_row = tr;

        tr.cells[0].innerHTML = `<td onClick='copyRow(event,`+'"'+table+'","'+row+'"'+`)'>
                                    <i class='fas fa-paste' style='font-size:18px;padding-left:12px;'> </i>
                                 </td>`;

     
    }
}

function post_order(event,product,supplier,price)
{
    quantity = document.getElementById(supplier+"-"+product).value;
    confirmation_box = document.getElementById("order-"+supplier+"-"+product);

    if(quantity != '')
    {
        console.log('has value');
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



