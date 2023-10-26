<?php
@$error=$_GET["error"];
if($error==1){
	$msg="<div class='tool_tip'><ul class='tt-wrapper'><li><img src='img/warning.png' alt=''/><span>Contrase&ntilde;a Inv&aacute;lida</span></li></ul></div>";
}
elseif($error==2){
	$msg2="<div class='tool_tip'><ul class='tt-wrapper'><li><img src='img/warning.png' alt=''/><span>Favor de escribir un usuario y contrase&ntilde;a</span></li></ul></div>";
}
?> 
<html>
<head>
	<link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
	<style media="all" type="text/css">@import "css/login.css";</style>
	<title>Portal Proveedores - Agricola Paredes</title>

</head>
<body onload="document.getElementById('user').focus();">
	<div id="login">
	<div class="imgLogo">
        <img id="logo" src="img/logo2.png">
    </div>
		<h2><span class="fontawesome-lock"></span>Portal Proveedores</h2>

		<form action="logi.php" name="frmLogin" method="POST">
			<fieldset>
				<p><label for="email">RFC</label></p>
				<p><input type="text" id="user" name="user" placeholder="Proporciona tu RFC"></p> 

				<p><label for="password">Password</label></p>
				<p><input type="password" id="pass" name="pass" placeholder="Proporciona tu Password"></p> 
				<p><?php echo @$msg2; ?><?php echo @$msg; ?></p>
				<p><input type="submit" value="Ingresar" id="loginbtn"></p>
			</fieldset>
		</form>

	</div> <!-- end login -->
	 <footer class="footer">
        <p>© 2023 Agricola Paredes S.A.P.I. de C.V.</p>
        <p>Paseo Niños Heroes Ext.520 Culiacán,Sinaloa. México CP.80000</p>
     </footer>
	
</body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62317136-1', 'auto');
  ga('send', 'pageview');

</script>
</html>
