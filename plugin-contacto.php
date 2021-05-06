<?php
/**
 * Plugin Name: Plugin Formulario de Contacto
 * Author: Iván Sánchez
 * Description: Plugin para crear un formulario personalizado. Utiliza el shortcode [formulario_contacto]
 */
 register_activation_hook(__FILE__, 'formularioContacto');

 function formularioContacto(){
    global $wpdb;
    $tabla=$wpdb->prefix . 'contactos';
    $ordenar=$wpdb->get_charset_collate();
    //Preparamos la consulta que vamos a lanzar para crear la tabla
    $sql="CREATE TABLE IF NOT EXISTS $tabla (id_contacto int(10) NOT NULL AUTO_INCREMENT,
                                            Nombre varchar(40) NOT NULL,
                                            Apellido varchar(40) NOT NULL,
                                            Correo varchar(255) NOT NULL,
                                            Direccion varchar(255) NOT NULL,
                                            created_at datetime NOT NULL,
                                            UNIQUE (id_contacto)
                                            ) $ordenar";
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
 }

 // Definir el shortcode para el formulario
 add_shortcode('formulario_contacto', 'formulario_contacto');

 function formulario_contacto(){
    global $wpdb;
    if(!empty($_POST)
        AND $_POST['nombre'] != '' 
        AND is_email($_POST['email'])
        AND $_POST['apellido'] != ''
        AND $_POST['telefono'] != ''
        AND $_POST['direccion'] != ''){

            $tabla=$wpdb->prefix . 'contactos';
            $nombre = sanitize_text_field($_POST['nombre']);
            $apellido = sanitize_text_field($_POST['apellido']);
            $direccion = sanitize_text_field($_POST['direccion']);
            $email = sanitize_email($_POST['email']);
            $telefono = (int)$_POST['telefono'];
            $created_at = date('Y-m-d H:i:s');
            $wpdb->insert($tabla, array(
                'Nombre' => $nombre,
                'Apellido' => $apellido,
                'Correo' => $email,
                'Direccion' => $direccion,
                'created_at' => $created_at
            ));
    }
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