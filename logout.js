function logout(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var res = JSON.parse(xhttp.responseText);
            if (res.errcode != 0) {
                var msg = document.getElementById("log");
                msg.innerHTML = res.errmsg;
            } else {
                var msg = document.getElementById("log");
                msg.innerHTML = '<p>已退出登录</p>';
                var link = document.createElement("a");
                link.href = "login.html" ;
                link.innerHTML = '去登录吧' ;
                msg.appendChild(link) ;

                var lin = document.createElement("a");
                lin.href = "messageboard.html" ;
                lin.innerHTML = '去留言吧' ;
                msg.appendChild(lin) ;
            }
        }
    };
    xhttp.open('POST', 'logout.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}