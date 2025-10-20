<!-- 
 * header - Cabecera principal del sistema de biblioteca
 * 
 * Contiene la estructura HTML head, metadatos, enlaces a recursos CSS,
 * barra de navegación superior, menú lateral y componentes de UI.
 * Implementa un diseño responsive con sidebar colapsable.
 * 
 * @package Views\template
 * @author Grupo 11
 * @version 1.0
 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ================================================== -->
    <!-- CONFIGURACIÓN BÁSICA DEL DOCUMENTO -->
    <!-- ================================================== -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- Viewport para diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Metadatos SEO -->
    <meta name="description" content="Sistema de gestión bibliotecaria Biblioteca Verde" />
    <meta name="author" content="Fuente Web" />
    
    <!-- Título de la aplicación -->
    <title>Biblioteca Verde</title>
    
    <!-- Hojas de estilo principales -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/styles.css" id="theme-stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/select2.min.css">          <!-- Select2 para selects mejorados -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/dataTables.bootstrap4.min.css"> <!-- DataTables para tablas -->
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url(); ?>Assets/img/favicon.png" type="image/x-icon" />
</head>

<body class="sb-nav-fixed">
    <!-- ================================================== -->
    <!-- BARRA DE NAVEGACIÓN SUPERIOR -->
    <!-- ================================================== -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <!-- Logo y nombre de la aplicación -->
        <a class="navbar-brand" href="<?php echo base_url(); ?>admin/listar">Biblioteca Verde</a>
        
        <!-- Botón para colapsar/expandir el menú lateral (visible en móviles) -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <!-- ================================================== -->
        <!-- COMPONENTE DE RELOJ EN TIEMPO REAL -->
        <!-- ================================================== -->
        &nbsp;&nbsp;&nbsp;
        <div id="reloj" class="reloj">00 : 00 : 00</div>

        <style>
            /**
             * Estilos para el componente de reloj
             * Diseñado para integrarse con la barra de navegación
             */
            .reloj {
                padding: 5px 10px; 
                border: 1px solid white; 
                font: bold 1.5em dotum, "lucida sans", arial; 
                text-align: center;
                color: #fff;
            }
        </style>

        <script>
            /**
             * Función para obtener la hora actual formateada
             * @returns {string} Hora en formato HH : MM : SS
             */
            function actual() {
                fecha = new Date(); // Objeto de fecha actual
                hora = fecha.getHours(); 
                minuto = fecha.getMinutes(); 
                segundo = fecha.getSeconds(); 
                
                // Formateo a 2 dígitos
                if (hora < 10) hora = "0" + hora;
                if (minuto < 10) minuto = "0" + minuto;
                if (segundo < 10) segundo = "0" + segundo;
                
                return hora + " : " + minuto + " : " + segundo;	
            }

            /**
             * Actualiza el contenido del reloj en el DOM
             * Se ejecuta cada segundo mediante setInterval
             */
            function actualizar() {
                mihora = actual();
                mireloj = document.getElementById("reloj");
                mireloj.innerHTML = mihora;
            }
            
            // Iniciar actualización automática cada segundo
            setInterval(actualizar, 1000);
        </script>

        &nbsp;&nbsp;&nbsp;          
                        
        <!-- ================================================== -->
        <!-- COMPONENTE DE FECHA ACTUAL -->
        <!-- ================================================== -->
        <div style="float:right; padding: 5px 10px; border: 1px solid white; text-align: center; color: #fff;">
            <script type="text/javascript">
                /**
                 * Script para mostrar la fecha actual en formato DD/MM/YYYY
                 * Se ejecuta al cargar la página
                 */
                var today = new Date();
                var m = today.getMonth() + 1; // Los meses van de 0-11
                var mes = (m < 10) ? '0' + m : m; // Formateo a 2 dígitos
                document.write('Fecha: ' + today.getDate() + '/' + mes + '/' + today.getFullYear());
            </script>
        </div>        

        <!-- ================================================== -->
        <!-- MENÚ DE USUARIO (DROPDOWN) -->
        <!-- ================================================== -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <!-- Botón dropdown con nombre del usuario -->
                <a class="nav-link dropdown-toggle text-capitalize" id="userDropdown" href="#" role="button" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <?php echo $_SESSION['nombre']; ?> <i class="fas fa-user fa-fw"></i>
                </a>
                
                <!-- Opciones del menú de usuario -->
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?php echo base_url(); ?>usuarios/perfil">Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url(); ?>usuarios/salir">Salir</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- ================================================== -->
    <!-- ESTRUCTURA PRINCIPAL DEL LAYOUT -->
    <!-- ================================================== -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            
            <!-- ================================================== -->
            <!-- MENÚ LATERAL (SIDEBAR) -->
            <!-- ================================================== -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        
                        <!-- PRÉSTAMOS (Solo para administradores) -->
                        <?php if ($_SESSION['rol'] == 1) { ?>
                            <a class="nav-link active" href="<?php echo base_url(); ?>admin/listar">
                                <div class="sb-nav-link-icon"><i class="fas fa-tasks fa-lg"></i></div>
                                Prestamo
                            </a>
                        <?php } ?>

                        <!-- MÓDULO DE LIBROS (Menú colapsable) -->
                        <a class="nav-link collapsed active" href="<?php echo base_url(); ?>/libros" 
                           data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" 
                           aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-book fa-lg"></i></div>
                            Libros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down fa-lg"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" 
                             data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link active" href="<?php echo base_url(); ?>libros">Libros</a>
                                <a class="nav-link active" href="<?php echo base_url(); ?>autor">Autor</a>
                                <a class="nav-link active" href="<?php echo base_url(); ?>editorial">Editorial</a>
                            </nav>
                        </div>

                        <!-- MATERIA -->
                        <a class="nav-link active" href="<?php echo base_url(); ?>materia">
                            <div class="sb-nav-link-icon"><i class="fas fa-list fa-lg"></i></div>
                            Materia
                        </a>

                        <!-- ESTUDIANTES -->
                        <a class="nav-link active" href="<?php echo base_url(); ?>estudiantes">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-graduate fa-lg"></i></div>
                            Estudiantes
                        </a>

                        <!-- USUARIOS (Solo para administradores) -->
                        <?php if ($_SESSION['rol'] == 1) { ?>
                            <a class="nav-link active" href="<?php echo base_url(); ?>usuarios/listar">
                                <div class="sb-nav-link-icon"><i class="fas fa-user fa-lg"></i></div>
                                Usuarios
                            </a>

                            <!-- CONFIGURACIÓN (Solo para administradores) -->
                            <a class="nav-link active" href="<?php echo base_url(); ?>configuracion/listar">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools fa-lg"></i></div>
                                Configuración
                            </a>
                        <?php } ?>

                        <!-- MÓDULO DE REPORTES (Menú colapsable) -->
                        <a class="nav-link collapsed active" href="<?php echo base_url(); ?>/libros" 
                           data-toggle="collapse" data-target="#collapseEst" aria-expanded="false" 
                           aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-pdf fa-lg"></i></div>
                            Reportes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down fa-lg"></i></div>
                        </a>
                        <div class="collapse" id="collapseEst" aria-labelledby="headingOne" 
                             data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <!-- Reportes en nueva pestaña -->
                                <a class="nav-link active" target="_blank" href="<?php echo base_url(); ?>admin/pdf">
                                    Prestamos
                                </a>
                                <a class="nav-link active" target="_blank" href="<?php echo base_url(); ?>libros/pdf">
                                    Libros
                                </a>
                            </nav>
                        </div>

                    </div>
                </div>
            </nav>
        </div>