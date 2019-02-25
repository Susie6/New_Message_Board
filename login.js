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
                msg.innerHTML = '<p>登录成功啦！ 这是你的第 ' + res.data.number_of_times + ' 次登录哦</p>' +
                                '<p>上一次登录时间：' + res.data.last_login_time + '</p>' ;
                var link = document.createElement("a");
                link.href = "messageboard.html" ;
                link.innerHTML = '去留言吧' ;
                msg.appendChild(link) ;
            }
        }
    };

    xhttp.open('POST', 'login.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var arr = {
        username,
        password,
    };
    JSON.stringify(arr);

    xhttp.send("username=" + username + "&password=" + password);
};

