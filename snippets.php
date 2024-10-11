<!--------- CREA UN BUCLE DE CONTENIDO ------------>

<?php
// Paso 1: Definir los argumentos de la consulta
$args = array(
    'post_type' => 'post', // Tipo de post. Aquí puedes cambiar 'post' a 'page' u otro tipo de post si es necesario.
    'post_status' => 'publish', // Solo entradas publicadas. Puedes cambiar esto a 'draft' para incluir borradores.
    'posts_per_page' => 50, // Número de entradas a mostrar. Cambia este número según tus necesidades.
    'category_name' => 'diseno-y-desarrollo-web', // Filtrar por slug de categoría
);

// Paso 2: Crear una nueva instancia de WP_Query
$query = new WP_Query($args); // Crea una nueva consulta con los argumentos definidos

// Paso 3: Comenzar el bucle
if ($query->have_posts()) : // Comprueba si hay entradas
    while ($query->have_posts()) : $query->the_post(); // Itera sobre las entradas
        // Paso 4: Obtener el ID del post actual
        $post_id = get_the_ID();
        
        // Paso 5: Obtener el título de la entrada
        $title = get_the_title();
        
        // Paso 6: Obtener la URL del post
        $permalink = get_permalink($post_id); // Obtener la URL del post
        
        // Paso 7: Obtener el contenido de la entrada
        $content = get_the_content();
        
        // Paso 8: Obtener el ID de la imagen destacada
        $thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
        
        // Paso 9: Obtener la URL de la imagen destacada
        $thumbnail_url = wp_get_attachment_url($thumbnail_id);

        // Paso 10: Obtener el autor de la entrada
        $author = get_the_author(); // Aquí obtenemos el autor
		
        // Paso 11: Obtener el extracto de la entrada
        $extracto = get_the_excerpt(); // Aquí obtenemos el extracto
        ?>

        <!-- Paso 12: Estructura HTML para mostrar la entrada -->
        <div class="post">
            <h2 class="post__title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h2>
            
            <div class="post__author">Autor: <?php echo esc_html($author); ?></div> <!-- Aquí mostramos el autor -->	
            <br>
            <div class="post__excerpt">
                <?php echo wp_kses_post($extracto); // Mostrar el extracto de la entrada ?>
            </div>
			<br>
			
				<?php if ($thumbnail_id): // Comprobar si hay imagen destacada ?>
                <div class="post__thumbnail">
                    <a href="<?php echo esc_url($permalink); ?>">
                        <?php 
                        // Mostrar la imagen destacada con dimensiones personalizadas
                        echo wp_get_attachment_image($thumbnail_id, array(600, 400)); // 600px de ancho y 400px de alto
                        ?>
                    </a>
                </div>
            <?php endif; ?>
            <br><br>
        </div>

        <?php
    endwhile; // Fin del bucle
    wp_reset_postdata(); // Restablece los datos de la consulta para evitar conflictos
else : // Si no hay entradas
    echo '<p class="post__no-content">No hay nada de esta categoría</p>'; // Mensaje si no hay entradas
endif;
?>
