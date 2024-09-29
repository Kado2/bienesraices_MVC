<main class="contenedor seccion contenido-centrado">
   <h1>Iniciar Sesión</h1>
   <?php foreach($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario" action="/login">

        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">Email</label>
            <input id="email" name="credenciales[email]" type="email" placeholder="Tu email..">

            <label for="password">Password</label>
            <input id="password" name="credenciales[password]" type="password" placeholder="Tu contraseña..">

        </fieldset>

        <input class="boton-verde" type="submit" value="Iniciar Sesión">
    </form>
</main>