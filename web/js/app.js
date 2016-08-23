var current_table;



$( document ).ready(function() {
$.getScript("js/con2fig.js", function(){
   
   alert("asd")
   getTablesAjax()
   getDishesAjax()
   
});
});


function getTablesAjax(table) {

    current_table = table
$.ajax({

    url: services_url+'/tables',
    type: 'GET',
    success: function(data) {
        draw_tables(data)
    },
    error: function(jqXHR, textStatus, error) {
        alert("Server connection lost");
    }
});
}

function getOrdersAjax() {
$.ajax({

    url: services_url+'/orders/'+current_table,
    type: 'GET',
    success: function(data) {
        draw_orders(data)
    },
    error: function(jqXHR, textStatus, error) {
        alert("Server connection lost");
    }
});
}

function getDishesAjax() {
$.ajax({

    url: services_url+'/dishes',
    type: 'GET',
    success: function(data) {
        draw_dishes(data)
    },
    error: function(jqXHR, textStatus, error) {
        alert("Server connection lost");
    }
});
}

function create_orderAjax(dish) {
$.ajax({

    url: services_url+'/order',
    type: 'POST',
    data: {"dish": dish, "table": current_table},
    success: function(data) {
        getTablesAjax(current_table)
    },
    error: function(jqXHR, textStatus, error) {
        alert("Server connection lost");
    }
});
}


function draw_tables(tables)
{
    $("#tables_append").empty()
    tables_array = JSON.parse(tables)
    tables_array.forEach(function(table)
    {
        special_class="";

        if(!current_table)
            current_table = table.id
        if(current_table == table.id)
            special_class = " class='active' "
        
        $("#tables_append").append("<li "+special_class+"><a href='javascript:getTablesAjax("+table.id+")'>"+table.number+"</a></li>")    
    }
    )
    getOrdersAjax()
}

function finishAjax()
{
    $.ajax({
        url: services_url+'/finish',
        type: 'POST',
        data: {"table": current_table},
        success: function(data) {
            getOrdersAjax()
        },
        error: function(jqXHR, textStatus, error) {
            alert("Server connection lost");
        }
    });
}

function draw_orders(orders)
{
    console.log(orders)
    $("#orders_append").empty()
    $("#finish_button").remove()
    
          
    $("#orders_append").append("<div class='list-group-item active'>Orders</div>")
    
    orders_array = JSON.parse(orders)
    if(!orders_array.length)
    $("#orders_append").append("<div class='list-group-item'>No orders for this table yet</div>")
    
    orders_array.forEach(function(order)
    {
        $("<div class='list-group-item'>"+order.name+" x"+order.quantity+"</div>").hide().appendTo("#orders_append").fadeIn(1000)    
    }
    )
    if(orders_array.length)
        $("#finish_append").append("<div id='finish_button'><p> <button type='button' onclick='javascript:finishAjax()' class='btn btn-success' name='finish'>Finish order</button></p></div>")
}


function draw_dishes(dishes)
{
    dishes_array = JSON.parse(dishes)
    i=0;
    html = "";
    dishes_array.forEach(function(dish)
    {
        i++;
        
        if(i==1)
            html += "<div class='row'>";
        
        html +="<div class='col-md-4'><div class='thumbnail'><img src='images/"+dish.image+"' alt='"+dish.name+"'><div class='caption text-center'><h3>"+dish.name+"</h3><p>"+dish.description+"</p><p> <button type='button' onclick='javascript:create_orderAjax("+dish.id+")' class='btn btn-primary' name='order' >Order</button></p></div></div></div>"
        
       if(i>=3)
       {
           i=0     
           html +="</div>"
       }             
        
    }
    )
    $("#dishes_append").append(html);
    
}


