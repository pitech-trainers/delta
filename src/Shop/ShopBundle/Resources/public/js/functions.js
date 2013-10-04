function loadCart(id, qty)
{
    if (qty == 0)
        qty = $('#qty').val();
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function()
    {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            response = $.parseJSON(xmlhttp.responseText);
            document.getElementById("cart").innerHTML = response.cart;
            document.getElementById("message").innerHTML = response.message;

        }
    }

    xmlhttp.open("POST", "/cart/addToCartAjax", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("id=" + id + "&qty=" + qty);
}

function showResult(str)
{
    if (str.length < 3)
    {
        document.getElementById("livesearch").innerHTML = "";
        return;

    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function()
    {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("POST", "/category/search", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("search=" + str);
}
function remove(id)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function()
    {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            response = $.parseJSON(xmlhttp.responseText);
            document.getElementById("cart").innerHTML = response.cart;
            document.getElementById("message").innerHTML = response.message;
        }
    }

    xmlhttp.open("POST", "/cart/deleteFromCartAjax", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("product_id=" + id);
}