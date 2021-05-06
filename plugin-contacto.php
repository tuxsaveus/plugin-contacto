<?php
/**
 * Plugin Name: Plugin Formulario de Contacto
 * Author: Iván Sánchez
 * Description: Plugin para crear un formulario personalizado. Utiliza el shortcode [formulario-contacto]
 */

 // Definir el shortcode para el formulario
 add_shortcode('formulario-contacto', 'formulario_contacto');

 function formulario_contacto(){
    ob_start();
    ?>
        <form action="<?php get_the_permalink(); ?>" method="POST" class="formulario">
            <div class="form-input">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" required>
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" required>
                <label for="telefono">Telefono</label>
                <input type="tel" name="telefono" required>
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <label for="direccion">Direccion</label>
                <textarea name="direccion" cols="30" rows="10"></textarea>
                <input type="submit" value="Enviar">
            </div>
        </form>
    <?php
    return ob_get_clean();
 }