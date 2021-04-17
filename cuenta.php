<h1>Mis datos:</h1>
<section id="cuenta">
    <!--Poner nada mas entrar los datos de la cuenta y un boton para editar datos, será cuando aparezca el formulario siguiente-->
    <article id="verde"><!--No se si por defecto poner los datos de esa cuenta-->
        <h2>Modificar datos:</h2>
        <p>Nombre: <input type="text" name="" id=""></p>
        <p>Apellidos: <input type="text" name="" id=""></p>
        <p>E-mail: <input type="email" name="" id=""></p>
        <p>Password: <input type="password" name="" id=""></p>
        <input type="submit" value="Modificar datos">
    </article>
    <!--Eliminar cuanta desde la función de eliminar cuenta y redirigir a la home-->
    <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=crearUsuario">Eliminar cuenta</a>
</section>