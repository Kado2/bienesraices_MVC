<main class="contenedor seccion">
        <h1>Contacto</h1>
        <?php if ($mensaje) { ?>
                <p class="alerta exito"> <?php echo $mensaje; ?> </p>
        <?php } ?> 

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="imagen contacto">
        </picture>

        <h2>Llene el formulario de contacto</h2>

        <form class="formulario" action="/contacto" method="POST">
            <fieldset>
                <legend>Información Personal</legend>

                <label for="nombre">Nombre</label>
                <input id="nombre" name="contacto[nombre]" type="text" placeholder="Tu nombre.." required>

                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="contacto[mensaje]" placeholder="..." required></textarea>

            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <label for="opciones">Vende o Compra:</label>
                <select name="contacto[opciones]" id="opciones" required>
                    <option value="" disabled selected>--Seleccione una opción--</option>
                    <option value="compra">Compra</option>
                    <option value="vende">Vende</option>
                </select>

                <label for="presupuesto">Precio o Presupuesto</label>
                <input id="presupuesto" name="contacto[precio]" type="number" placeholder="Tu precio o presupuesto.." required>
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <p>¿Cómo desea ser contactado?</p>
                <div class="forma-contacto">
                    <label for="contactar-tel">Teléfono</label>
                    <input name="contacto[contactar]" type="radio" value="telefono" id="contactar-tel">

                    <label for="contactar-email">E-mail</label>
                    <input name="contacto[contactar]" type="radio" value="email" id="contactar-email">
                </div>

                <div id="contacto"></div>

            </fieldset>

            <input type="submit" value="Enviar" class="boton-verde-block" id="boton-jodido">
        </form>
    </main>