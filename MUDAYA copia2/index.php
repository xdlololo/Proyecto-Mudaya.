<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<title>MUDAYA | Bienvenido</title>

<!-- ICONO EN LA PESTAÑA DEL NAVEGADOR -->
<link rel="icon" type="image/png" href="img/logo.png">

<link rel="stylesheet" href="styles.css">

<style>

body{
display:flex;
justify-content:center;
align-items:center;
height:100vh;
background:linear-gradient(135deg,#4a90e2 0%,#1e3c72 100%);
}

.login-card{
background:rgba(255,255,255,0.9);
backdrop-filter:blur(10px);
padding:40px;
border-radius:20px;
box-shadow:0 20px 40px rgba(0,0,0,0.2);
width:100%;
max-width:400px;
text-align:center;
}

/* LOGO */

.logo-container{
display:flex;
flex-direction:column;
align-items:center;
margin-bottom:15px;
}

.logo-container img{
width:110px;
margin-bottom:10px;
}

.logo-container h1{
margin:0;
font-size:28px;
}

.logo-container p{
margin:5px 0 20px 0;
color:#555;
}

.tab-group{
display:flex;
margin-bottom:25px;
border-bottom:2px solid #eee;
}

.tab{
flex:1;
padding:10px;
cursor:pointer;
font-weight:600;
color:#999;
}

.tab.active{
color:#4a90e2;
border-bottom:2px solid #4a90e2;
}

.form-content{
display:none;
}

.form-content.active{
display:block;
}

</style>

</head>

<body>

<div class="login-card">

<div class="logo-container">

<img src="img/logo.png" alt="Logo Mudaya">

<h1>MUDAYA</h1>

<p>Tu mudanza empieza aquí</p>

</div>

<div class="tab-group">

<div class="tab active" onclick="showForm('login',this)">Entrar</div>

<div class="tab" onclick="showForm('registro',this)">Crear Cuenta</div>

</div>

<form id="login" class="form-content active" action="auth.php" method="POST">

<div class="field-group">

<input type="email" name="correo" placeholder="Correo electrónico" required>

</div>

<div class="field-group">

<input type="password" name="password" placeholder="Contraseña" required>

</div>

<button type="submit" name="login" class="btn-main">

Iniciar Sesión

</button>

</form>

<form id="registro" class="form-content" action="auth.php" method="POST">

<div class="field-group">

<input type="text" name="nombre" placeholder="Nombre completo" required>

</div>

<div class="field-group">

<input type="email" name="correo" placeholder="Correo electrónico" required>

</div>

<div class="field-group">

<input type="password" name="password" placeholder="Crear contraseña" required>

</div>

<button type="submit" name="registrar" class="btn-main" style="background:#27ae60;">

Registrarme

</button>

</form>

</div>

<script>

function showForm(id,tab){

document.querySelectorAll('.form-content').forEach(f=>{
f.classList.remove('active');
});

document.querySelectorAll('.tab').forEach(t=>{
t.classList.remove('active');
});

document.getElementById(id).classList.add('active');

tab.classList.add('active');

}

</script>

</body>

</html>