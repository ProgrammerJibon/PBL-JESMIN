<?php
require_once './view-header.php';
?>
<title><?php echo $site_info['site_title']; ?> - Login Page</title>


<div class="container">
	<h2>Welcome back to <?php echo $site_info['site_title']; ?></h2>
	<form method="POST" class="login-form">
		<div class="imgcontainer">
			<img src="/assets/avatar-woman.png" alt="Avatar" class="avatar">
		</div>
		<label for="uname"><b>User ID</b></label>
		<input type="text" placeholder="User Id/Student Id/Phone Number/Email Address/Nid Number" name="user" required>

		<label for="password"><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="password" required>

		<div class="error"></div>

		<button type="submit" name="login" value="1">Login</button>
	</form>
</div>
<style>
	body {
		background-color: #f1f1f1;
	}

	.container {
		width: 500px;
		margin: 0 auto;
		margin-top: 100px;
		background-color: #fff;
		padding: 20px;
		border-radius: 5px;
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
	}

	h2 {
		text-align: center;
		margin-bottom: 20px;
	}

	input[type=text], input[type=number],input[type=password] {
		width: 100%;
		padding: 12px 20px;
		margin: 8px 0;
		display: inline-block;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
	}

	button[type=submit] {
		background-color: #4CAF50;
		color: white;
		padding: 14px 20px;
		margin: 8px 0;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		width: 100%;
	}

	button[type=submit]:hover {
		background-color: #45a049;
	}

	.cancelbtn {
		width: auto;
		padding: 10px 18px;
		background-color: #f44336;
	}

	.imgcontainer {
		text-align: center;
		margin: 24px 0 12px 0;
		position: relative;
	}

	img.avatar {
		width: 75px;
		height: 75px;
		border-radius: 50%;
	}

	.signup {
		color: dodgerblue;
		text-align: center;
		margin-top: 12px;
	}

	.forgotpassword {
		color: dodgerblue;
		text-align: center;
		margin-top: 12px;
	}

	.container > p {
		text-align: center;
	}
</style>
<script>
var loginError = document.querySelector("form.login-form .error");
var loginForm = document.querySelector("form.login-form");
var loginUser = document.querySelector("form.login-form input[name='user']");
var loginPassword = document.querySelector("form.login-form input[name='password']");
var errorFont = create("font");
errorFont.style.color = 'red';
errorFont.style.display = 'block';
loginError.appendChild(errorFont);

loginForm.onsubmit = (e) =>{
	errorFont.innerHTML = "";
	loginUserValue = loginUser.value.replaceAll(" ", "");
	let login = true;
	if(loginUserValue == ""){
		errorFont.innerHTML += "Invalid User Id<br>";
		login = false;
	}
	if(loginPassword.value == ""){
		errorFont.innerHTML += "Invalid Password<br>";
		login = false;
	}
	if(login){
		loadLink('/json', [['login','1'],['user',loginUserValue], ['password', loginPassword.value]]).then(result=>{
			console.log(result);
			if('login' in result){
				if(result.login){
					href("/");
				}
			}
			if('error' in result){
				errorFont.innerHTML = result.error+"<br>";
			}
		});
	}
	return false;
}

</script>

<?php
require_once './view-footer.php';
?>