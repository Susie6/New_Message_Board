window.onload = function view() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp.responseText);

            var tip = document.getElementById("tip");
            tip.innerHTML = "当前是第1页";

            var former = document.getElementById("former");
            var res = JSON.parse(xhttp.responseText);
            var pages = res.pages;

            for (var i = 0; i < res.data.length; i++) {
                var id = (res.data[i])[0];
                var username = (res.data[i])[1];
                var message = (res.data[i])[2];
                var update_time = (res.data[i])[3];
                var pic = (res.data[i])[4];

                //显示留言
                var appear = document.createElement("div");
                appear.id = id;
                appear.style.Color = '#fff';
                appear.style.background = 'rgba(255,255,255,0.7)';
                appear.style.width = '80%';
                appear.style.outline = '#00FF00 dotted thick';
                appear.innerHTML = '<img src="' + pic + '"><p class=id>留言id：' + id + '</p>' + '<p class=user>用户名：' + username + '</p>' + '<p class=mess>留言：' + message + '</p>' +
                    '<p class=time>留言时间：' + update_time + '</p><button onclick = "edit(' + id + ')">修改</button><button onclick = "cancel(' + id +
                    ')">删除</button><button onclick = "comment1(' + id + ')">评论</button>';
                former.appendChild(appear);
            }

            //显示评论
            for (var k = 0; k < res.comments.length; k++) {
                var user_id = (res.comments[k])[0];
                var user = (res.comments[k])[1];
                var com_message = (res.comments[k])[2];
                var time = (res.comments[k])[3];
                var pic = (res.comments[k])[4];
                if (user_id >= (res.data[4])[0] && user_id <= (res.data[0])[0]) {
                    var get = document.getElementById(user_id);
                    var cre = document.createElement("div");
                    cre.style.borderBottom = '1px solid #00FF00 '; 
                    cre.innerHTML = '<img src="' + pic + '"><p>评论用户：' + user + '</p><p>评论内容：' + com_message + '</p><p>评论时间：' + time + '</p>';
                    get.appendChild(cre);
                }

            }

            //显示页码
            var page = document.getElementById("page");
            for (var j = 1; j <= pages; j++) {
                var page_button = document.createElement("button");
                // page_button.innerHTML = "第" + j + "页";
                page_button.innerHTML = '<button onclick = "turn_to_page(' + j + ')">' + j + '</button>';
                // page_button.addEventListener("click", function () {
                //     turn_to_page(j);
                // });
                page_button.id = j;
                page.appendChild(page_button);
            }

        }
    }
    xhttp.open("POST", "onload.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send();
}

//点击页码按钮
function turn_to_page(j) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var former = document.getElementById("former");
            var res = JSON.parse(xhttp.responseText);

            //去掉原来页面的留言
            while (former.hasChildNodes()) {
                var childs = former.childNodes;
                for (var k = 0; k < childs.length; k++) {
                    former.removeChild(childs[k]);
                }
            }

            var tip = document.getElementById("tip");
            tip.innerHTML = "当前是第" + j + "页";
            //显示第j页留言
            for (var i = 0; i < res.data.length; i++) {
                var id = (res.data[i])[0];
                var username = (res.data[i])[1];
                var message = (res.data[i])[2];
                var update_time = (res.data[i])[3];
                var pic = (res.data[i])[4];

                var appear = document.createElement("div");
                appear.id = id;
                appear.style.Color = '#fff';
                appear.style.background = 'rgba(255,255,255,0.7)';
                appear.style.width = '80%';
                appear.style.outline = '#00FF00 dotted thick';
                appear.innerHTML = '<img src="' + pic + '"><p class=id>留言id：' + id + '</p>' + '<p class=user>用户名：' + username + '</p>' + '<p class=mess>留言：' + message + '</p>' + '<p class=time>留言时间：' + update_time + '</p><button onclick = "edit(' + id + ')">修改留言</button><button onclick = "cancel(' + id + ')">删除留言</button><button onclick = "comment1(' + id + ')">评论</button>';
                former.appendChild(appear);
            }
            //显示评论
            for (var k = 0; k < res.comments.length; k++) {
                var user_id = (res.comments[k])[0];
                var user = (res.comments[k])[1];
                var com_message = (res.comments[k])[2];
                var time = (res.comments[k])[3];
                var pic =(res.comments[k][4]);

                if (user_id >= (res.data[4])[0] && user_id <= (res.data[0])[0]) {
                    var get = document.getElementById(user_id);
                    var cre = document.createElement("div");
                    cre.style.borderBottom = '5px solid #00FF00 ';
                    cre.innerHTML = '<img src="' + pic + '"><p>评论用户：' + user + '</p><p>评论内容：' + com_message + '</p><p>评论时间：' + time + '</p>';
                    get.appendChild(cre);
                }
            }
        }
    }
    xhttp.open("POST", "change_page.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var arr = {
        j
    };
    JSON.stringify(arr);
    xhttp.send("cur_page=" + j);
}

//留言功能
function sendmessage() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var res = JSON.parse(xhttp.responseText);
            if (res.errcode != 0) {
                var tip = document.getElementById("tip");
                tip.innerHTML = res.errmsg;
            } else {
                var tip = document.getElementById("tip");
                tip.innerHTML = res.errmsg;

                var id = res.data.id;
                var username = res.data.username;
                var update_time = res.data.update_time;
                var pic = res.data.pic;
                //新建留言
                var add = document.getElementById("newmessage");
                var td = document.createElement("div");
                td.id = id;
                td.style.Color = '#fff';
                td.style.background = 'rgba(255,255,255,0.7)';
                td.style.width = '80%';
                td.style.outline = '#00FF00 dotted thick';

                td.innerHTML = '<img src="' + pic + '"><p class=id>留言id：' + id + '</p>' + '<p class=user>用户名：' + username + '</p>' + '<p class=mess>留言：' + message + '</p>' + '<p class=time>留言时间：' + update_time +
                    '</p><button onclick = "edit(' + id + ')">修改留言</button><button onclick = "cancel(' + id + ')">删除留言</button>';

                add.appendChild(td);
            }

        }
    };
    xhttp.open("POST", "messageboard.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var message = document.getElementById("message").value;
    var arr = {
        message
    };
    JSON.stringify(arr);

    xhttp.send("message=" + message);
}

//评论回复功能1:显示评论框
function comment1(id) {

    //创建编辑文本框
    var box = document.createElement("textarea");
    box.id = "mes";
    box.rows = "3";
    box.style = "margin: 0px; width: 760px; height: 138px;";

    //创建按钮
    var create = document.createElement("div");
    create.id = "create";
    create.innerHTML = '<button id = "btn1" onclick = "comment2(' + id + ')">确认</button><button id = "btn2" onclick = "disappear(' + id + ')">取消</button>';

    //将新建的元素放进div里面
    var ins = document.getElementById(id);
    ins.appendChild(box);
    ins.appendChild(create);
}

//评论回复功能2：评论显示以及评论框消失
function comment2(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp.responseText);
            var res = JSON.parse(xhttp.responseText);
            if (res.errcode == 0) {
                var username = res.data.username;
                var com_message = res.data.com_message;
                var time = res.data.time;
                var pic = res.data.pic;
                var get = document.getElementById(id);
                var com = document.createElement("div");
                com.innerHTML = '<img src="' + pic + '"><p>评论用户：' + username + '</p><p>评论内容：' + com_message + '</p><p>评论时间：' + time + '</p>';
                get.appendChild(com);

            } else {
                alert(res.errmsg);
            }

            //把创建的修改框去掉
            var del1 = document.getElementById("mes");
            var del2 = document.getElementById("create");

            var parent = document.getElementById(id);
            //alert(parent);
            parent.removeChild(del1);
            parent.removeChild(del2);
        }
    }
    xhttp.open("POST", "comment.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var com_message = document.getElementById("mes").value;
    var arr = {
        id,
        com_message
    };
    JSON.stringify(arr);
    xhttp.send("user_id=" + id + "&com_message=" + com_message);
}

//编辑留言功能
function edit(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var res = JSON.parse(xhttp.responseText);
            //var id = res.data.id;
            if (res.errcode == 0) {

                //创建编辑文本框
                var box = document.createElement("textarea");
                box.id = "mes";
                box.rows = "3";
                box.style = "margin: 0px; width: 760px; height: 138px;";

                //创建按钮
                var create = document.createElement("div");
                create.id = "create";
                create.innerHTML = '<button id = "btn1" onclick = "update(' + id + ')">确认修改</button><button id = "btn2" onclick = "disappear(' + id + ')">取消修改</button>';

                //将新建的元素放进div里面
                var ins = document.getElementById(id);
                ins.appendChild(box);
                ins.appendChild(create);

            } else {
                var tip = document.getElementById("tip");
                //tip.innerHTML = res.errmsg;
                alert(res.errmsg);
            }
        }
    }
    xhttp.open("POST", "judge.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

//更新留言功能
function update(id) {
    var xhttp = new XMLHttpRequest();
    var message = document.getElementById("mes").value;
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var res = JSON.parse(xhttp.responseText);

            //更新留言
            if (res.errcode == 0) {
                var tip = document.getElementById("tip");
                tip.innerHTML = res.errmsg;

                var update_time = res.data.update_time;

                var change = document.getElementById(id);

                change.getElementsByClassName("mess").innerHTML = '留言：' + message;
                change.getElementsByClassName("time").innerHTML = '留言时间：' + update_time;

            } else {
                var tip = document.getElementById("tip");
                //tip.innerHTML = res.errmsg;
                alert(res.errmsg);
            }

            //把创建的修改框去掉
            var del1 = document.getElementById("mes");
            var del2 = document.getElementById("create");

            var parent = document.getElementById(id);
            //alert(parent);
            parent.removeChild(del1);
            parent.removeChild(del2);

        }
    }
    xhttp.open("POST", "edit.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var new_one = document.getElementById("mes").value;
    var arr = {
        new_one
    };
    JSON.stringify(arr);
    xhttp.send("message=" + new_one + "&id=" + id);
};

//去框
function disappear(id) {
    //删除编辑框及按钮
    var parent = document.getElementById(id);
    var del1 = document.getElementById("mes");
    var del2 = document.getElementById("create");

    parent.removeChild(del1);
    parent.removeChild(del2);

}
//删除功能
function cancel(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var res = JSON.parse(xhttp.responseText);
            if (res.errcode = 0) {
                var del = document.getElementById(id);
                removeChild(del);
                var tip = document.getElementById("tip");
                tip.innerHTML = res.errmsg;
            } else {
                var tip = document.getElementById("tip");
                tip.innerHTML = res.errmsg;
                alert(res.errmsg);
            }
        }
    }
    xhttp.open("POST", "delete.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}