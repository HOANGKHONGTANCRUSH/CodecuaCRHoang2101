<?php

$info = (object)[];

$data = false;
$data['userid'] = $_SESSION['userid'];

//validate username
$data['username'] = $DATA_OBJ->username;
if (empty($DATA_OBJ->username)) {
	$Error .= "Vui lòng nhập tên người dùng hợp lệ . <br>";
} else {
	if (strlen($DATA_OBJ->username) < 3) {
		$Error .= "tên người dùng phải dài ít nhất 3 ký tự. <br>";
	}

	if (!preg_match("/^[a-z A-Z]*$/", $DATA_OBJ->username)) {
		$Error .= "Vui lòng nhập tên người dùng hợp lệ . <br>";
	}
}

$data['email'] = $DATA_OBJ->email;
if (empty($DATA_OBJ->email)) {
	$Error .= "Vui lòng nhập email hợp lệ . <br>";
} else {

	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email)) {
		$Error .= "Vui lòng nhập email hợp lệ . <br>";
	}
}

$data['gender'] = isset($DATA_OBJ->gender) ? $DATA_OBJ->gender : null;
if (empty($DATA_OBJ->gender)) {
	$Error .= "Vui lòng chọn một giới tính . <br>";
} else {

	if ($DATA_OBJ->gender != "Male" && $DATA_OBJ->gender != "Female") {
		$Error .= "Vui lòng chọn một giới tính hợp lệ. <br>";
	}
}

$data['password'] = password_hash($DATA_OBJ->password, PASSWORD_DEFAULT); // Mã hóa mật khẩu bằng bcrypt

$password = $DATA_OBJ->password2;
if (empty($DATA_OBJ->password)) {
	$Error .= "Vui lòng nhập mật khẩu hợp lệ . <br>";
} else {
	if ($DATA_OBJ->password != $DATA_OBJ->password2) {
		$Error .= "mật khẩu phải trùng khớp. <br>";
	}

	if (strlen($DATA_OBJ->password) < 4) {
		$Error .= "mật khẩu phải dài ít nhất 4 ký tự. <br>";
	}
}


if ($Error == "") {

	$query = "update users set username = :username, gender = :gender, email = :email, password = :password where userid = :userid limit 1";
	$result = $DB->write($query, $data);

	if ($result) {

		$info->message = "Dữ liệu của bạn đã được lưu";
		$info->data_type = "save_settings";
		echo json_encode($info);
	} else {

		$info->message = "Dữ liệu của bạn không được lưu do lỗi";
		$info->data_type = "save_settings";
		echo json_encode($info);
	}
} else {
	$info->message = $Error;
	$info->data_type = "save_settings";
	echo json_encode($info);
}
