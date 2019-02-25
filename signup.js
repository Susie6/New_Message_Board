function test() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var res = JSON.parse(xhttp.responseText);
            if (res.errcode != 0) {
                var msg = document.getElementById("msg");
                msg.innerHTML = res.errmsg;
                
            } else {
                var msg = document.getElementById("msg");
                msg.innerHTML = res.errmsg;
            }

        } 

    };
    xhttp.open("POST", "signup.php",true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var checkpwd = document.getElementById("checkpwd").value;

    var arr = {
        username,
        password,
        checkpwd
    };
    JSON.stringify(arr);
    xhttp.send("username=" + username + "&password=" + password + "&checkpwd=" + checkpwd);
}