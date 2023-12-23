function showUser(str)
{
    if (str == "")
    {
        document.getElementById("userSuggestion").innerHTML = "";
        return;
    }
    else 
    {
        if(str.length > 2)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("userSuggestion").innerHTML = this.responseText;
            }
            };
            xmlhttp.open("GET", "database/getuser.php?user="+str,true);
            xmlhttp.send();
        }
        else{
            return;
        }
    }
}