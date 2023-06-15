<?php

$info = (object)[];

$data = false;
$data['userid'] = $DB->generate_id(20);
$data['date'] = date("Y-m-d H:i:s");

// Validate username
$data['username'] = $DATA_OBJ->username;
if (empty($DATA_OBJ->username)) {
    $Error .= "Vui lòng nhập tên người dùng hợp lệ. <br>";
} else {
    if (strlen($DATA_OBJ->username) < 3) {
        $Error .= "Tên đăng nhập phải dài ít nhất 3 ký tự. <br>";
    }

    if (!preg_match("/^[a-z A-Z]*$/", $DATA_OBJ->username)) {
        $Error .= "Vui lòng nhập tên người dùng hợp lệ. <br>";
    }
}

$data['email'] = $DATA_OBJ->email;
if (empty($DATA_OBJ->email)) {
    $Error .= "Vui lòng nhập email hợp lệ. <br>";
} else {
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email)) {
        $Error .= "Vui lòng nhập email hợp lệ. <br>";
    }
}

$data['gender'] = isset($DATA_OBJ->gender) ? $DATA_OBJ->gender : null;
if (empty($DATA_OBJ->gender)) {
    $Error .= "Vui lòng chọn một giới tính. <br>";
} else {
    if ($DATA_OBJ->gender != "Male" && $DATA_OBJ->gender != "Female") {
        $Error .= "Vui lòng chọn một giới tính hợp lệ. <br>";
    }
}

$data['password'] = md5($DATA_OBJ->password); // Mã hóa mật khẩu với MD5
$password = $DATA_OBJ->password2;
if (empty($DATA_OBJ->password)) {
    $Error .= "Vui lòng nhập mật khẩu hợp lệ. <br>";
} else {
    if ($DATA_OBJ->password != $DATA_OBJ->password2) {
        $Error .= "mật khẩu phải trùng khớp. <br>";
    }

    if (strlen($DATA_OBJ->password) < 8) {
        $Error .= "Mật khẩu phải dài ít nhất 8 ký tự. <br>";
    }
}

if ($Error == "") {

    $query = "insert into users (userid,username,gender,email,password,date) values (:userid,:username,:gender,:email,:password,:date)";
    $result = $DB->write($query, $data);

    if ($result) {
        $info->message = "Hồ sơ của bạn đã được tạo";
        $info->data_type = "info";
        echo json_encode($info);
    } else {

        $info->message = "Hồ sơ của bạn KHÔNG được tạo do lỗi";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    $info->message = $Error;
    $info->data_type = "error";
    echo json_encode($info);
}
