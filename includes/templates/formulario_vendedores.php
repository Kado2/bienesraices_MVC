<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre del vendedor" value="<?php echo s($vendedor->nombre); ?>">

    <label for="precio">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido del vendedor" value="<?php echo s($vendedor->apellido); ?>" >

    <label for="telefono">Teléfono</label>
    <input type="tel" id="telefono" name="vendedor[telefono]" placeholder="(cod. Área)-número" value="<?php echo s($vendedor->telefono); ?>" >
</fieldset>
