<!DOCTYPE html>
<html>

<head>
	<title>Chat Box</title>
	<link rel="stylesheet" href="css/login.css">
</head>

<body>
	<div id="wrapper">
		<div id="header">
			Chat Box
			<div class="title">Đăng nhập</div>
		</div>
		<div id="error"></div>
		<form id="myform">
			<input type="text" name="email" placeholder="Email" class="input-field"><br>
			<input type="password" name="password" placeholder="Mật khẩu" class="input-field"><br>
			<input type="submit" value="Đăng nhập" id="login_button" class="submit-button"><br>

			<br>
			<a href="signup.php" class="signup-link">
				Không có một tài khoản? Đăng ký tại đây
			</a>
		</form>
	</div>
</body>

</html>

<script type="text/javascript">
	function _(element) {

		return document.getElementById(element);
	}

	var login_button = _("login_button");
	login_button.addEventListener("click", collect_data);

	function collect_data(e) {

		e.preventDefault();
		login_button.disabled = true;
		login_button.value = "Loading...Please wait..";

		var myform = _("myform");
		var inputs = myform.getElementsByTagName("INPUT");

		var data = {};
		for (var i = inputs.length - 1; i >= 0; i--) {

			var key = inputs[i].name;

			switch (key) {

				case "email":
					data.email = inputs[i].value;
					break;

				case "password":
					data.password = inputs[i].value;
					break;

			}
		}

		send_data(data, "login");

	}

	function send_data(data, type) {

		var xml = new XMLHttpRequest();

		xml.onload = function() {

			if (xml.readyState == 4 || xml.status == 200) {

				handle_result(xml.responseText);
				login_button.disabled = false;
				login_button.value = "đăng nhập";
			}
		}

		data.data_type = type;
		var data_string = JSON.stringify(data);

		xml.open("POST", "api.php", true);
		xml.send(data_string);
	}

	function handle_result(result) {

		var data = JSON.parse(result);
		if (data.data_type == "info") {

			window.location = "index.php";
		} else {

			var error = _("error");
			error.innerHTML = data.message;
			error.style.display = "block";

		}
	}
</script>