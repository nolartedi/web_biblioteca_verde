<!-- 
 * footer - Pie de página y scripts globales de la aplicación
 * 
 * Contiene el cierre de la estructura HTML, enlaces a scripts JavaScript,
 * inicialización de componentes y widgets de terceros.
 * 
 * @package Views\template
 * @author Grupo 11
 * @version 1.0
 -->

<!-- ================================================== -->
<!-- WIDGET DE CONTACTO FLOTANTE - GetButton.io -->
<!-- ================================================== -->
<script type="text/javascript">
(function () {
    /**
     * Configuración del widget de contacto flotante
     * Este widget proporciona botones de contacto directo para WhatsApp
     */
    var options = {
        whatsapp: "+51 937624877", // Número de WhatsApp para contacto directo
        call_to_action: "Envíanos un mensaje", // Texto del call-to-action
        button_color: "#5e2129", // Color corporativo del botón (rojo vino)
        position: "right", // Posición en la pantalla: 'right' o 'left'
        order: "whatsapp", // Orden de los botones
        pre_filled_message: "Hola, necesito ayuda.", // Mensaje predefinido para WhatsApp
    };

    /**
     * Carga dinámica del script del widget GetButton
     * Esta técnica evita bloquear la renderización de la página
     */
    var proto = document.location.protocol, 
        host = "getbutton.io", 
        url = proto + "//static." + host;
    
    var s = document.createElement('script'); 
    s.type = 'text/javascript'; 
    s.async = true; 
    s.src = url + '/widget-send-button/js/init.js';
    
    /**
     * Inicializa el widget una vez cargado el script
     */
    s.onload = function () { 
        WhWidgetSendButton.init(host, proto, options); 
    };
    
    /**
     * Inserta el script en el DOM para comenzar la carga
     */
    var x = document.getElementsByTagName('script')[0]; 
    x.parentNode.insertBefore(s, x);
})();
</script>

<!-- ================================================== -->
<!-- PIE DE PÁGINA PRINCIPAL -->
<!-- ================================================== -->
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">
                <!-- Información de copyright y créditos -->
                Copyright <a target="_blank">Biblioteca Verde</a> 
                &copy; <span id="current-year"></span>
            </div>
        </div>
    </div>
</footer>
</div> <!-- Cierre del contenedor principal -->

<!-- ================================================== -->
<!-- BLOQUE DE SCRIPTS JAVASCRIPT -->
<!-- ================================================== -->

<!-- Librerías JavaScript esenciales -->
<script src="<?php echo base_url(); ?>Assets/js/jquery.min.js"></script>          <!-- jQuery - Manipulación DOM y AJAX -->
<script src="<?php echo base_url(); ?>Assets/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap - Componentes UI -->
<script src="<?php echo base_url(); ?>Assets/js/select2.min.js"></script>         <!-- Select2 - Selects mejorados -->
<script src="<?php echo base_url(); ?>Assets/js/scripts.js"></script>             <!-- Scripts principales de la aplicación -->
<script src="<?php echo base_url(); ?>Assets/js/Funciones.js"></script>           <!-- Funciones personalizadas -->
<script src="<?php echo base_url(); ?>Assets/js/all.min.js"></script>             <!-- FontAwesome - Iconos -->
<script src="<?php echo base_url(); ?>Assets/js/sweetalert2@9.js"></script>       <!-- SweetAlert2 - Alertas elegantes -->
<script src="<?php echo base_url(); ?>Assets/js/jquery.dataTables.min.js"></script> <!-- DataTables - Tablas interactivas -->
<script src="<?php echo base_url(); ?>Assets/js/dataTables.bootstrap4.min.js"></script> <!-- Integración DataTables + Bootstrap -->

<!-- ================================================== -->
<!-- INICIALIZACIÓN DE COMPONENTES JAVASCRIPT -->
<!-- ================================================== -->
<script>
    /**
     * Inicialización de DataTables para tablas interactivas
     * Se ejecuta cuando el documento está completamente cargado
     * Configura la tabla con ID 'table' para usar DataTables con traducción al español
     */
    $(document).ready(function() {
        $('#table').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar columna ascendente",
                    "sortDescending": ": activar para ordenar columna descendente"
                }
            }
        });
    });

    /** 
     * Script para actualizar el año automáticamente
     */
    document.addEventListener('DOMContentLoaded', function() {
            // Obtener el año actual
            const currentYear = new Date().getFullYear();
            // Insertar el año en el elemento correspondiente
            document.getElementById('current-year').textContent = currentYear;
        });

</script>

<!-- ================================================== -->
<!-- CIERRE DEL DOCUMENTO HTML -->
<!-- ================================================== -->
</body>
</html>