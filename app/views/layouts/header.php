<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Biblioteca Verde UCV'; ?></title>
    <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
</head>

<style>
/* Header*/
.header {
    width: 100%;
    background: linear-gradient(135deg, #27ae60, #2c3e50);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

/* Eliminamos el margen superior del contenido principal */
main.container {
    margin-top: 0;
}

/* Navbar container - MODIFICADO para elementos pegados */
.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    /* Eliminamos padding horizontal */
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

/* Logo alineado a la izquierda - MODIFICADO */
.logo {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
    padding-left: 2rem;
    /* Padding solo a la izquierda */
}

.logo i {
    font-size: 1.5rem;
    color: #c8e6c9;
}

.logo h1 {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
    white-space: nowrap;
}

/* Contenedor para menu y hamburguesa - MODIFICADO */
.nav-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding-right: 2rem;
    /* Padding solo a la derecha */
}

/* Menú de navegación alineado a la derecha - REDUCIDO */
.nav-links {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
    gap: 1.5rem;
}

.nav-links li {
    margin: 0;
}

.nav-links a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-weight: 500;
    padding: 0.4rem 0.6rem;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.nav-links a:hover {
    background-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

.nav-links a i {
    font-size: 1rem;
}

/* Menú de usuario - REDUCIDO */
.user-menu {
    display: flex;
    gap: 0.8rem;
    margin-left: 0.8rem;
}

/* Botón hamburguesa - solo visible en móviles - REDUCIDO */
.nav-toggle {
    display: none;
    flex-direction: column;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.4rem;
    margin: 0;
}

.hamburger {
    width: 22px;
    height: 2.5px;
    background: white;
    margin: 2.5px 0;
    transition: 0.3s;
}

/* Estilos responsive */
@media (max-width: 768px) {
    .nav-container {
        padding: 0.5rem 0;
        /* Mantenemos sin padding horizontal */
    }

    .logo {
        padding-left: 1rem;
        /* Padding reducido en móviles */
    }

    .nav-right {
        padding-right: 1rem;
        /* Padding reducido en móviles */
    }

    .nav-toggle {
        display: flex;
    }

    .nav-links {
        position: fixed;
        top: 60px;
        right: 0;
        width: 70%;
        height: calc(100vh - 60px);
        flex-direction: column;
        padding: 0.5rem 0;
        gap: 0;
        transform: translateX(100%);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.98), rgba(44, 62, 80, 0.98));
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        z-index: 999;
    }

    .nav-links.active {
        transform: translateX(0);
        opacity: 1;
        visibility: visible;
    }

    .nav-links li {
        width: 100%;
        text-align: left;
    }

    .nav-links a {
        padding: 0.8rem 1.5rem;
        justify-content: flex-start;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: block;
        width: 100%;
        color: white;
        text-decoration: none;
    }

    .nav-links a:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .user-menu {
        flex-direction: column;
        gap: 0;
        margin-left: 0;
        width: 100%;
    }

    .user-menu a {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
}

/* Animación del botón hamburguesa cuando está activo */
.nav-toggle.active .hamburger:nth-child(1) {
    transform: rotate(-45deg) translate(-4px, 5px);
}

.nav-toggle.active .hamburger:nth-child(2) {
    opacity: 0;
}

.nav-toggle.active .hamburger:nth-child(3) {
    transform: rotate(45deg) translate(-4px, -5px);
}
</style>

<script>
// Agrega esto en tu archivo main.js o antes del cierre del body
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.querySelector('.nav-toggle');
    const navLinks = document.querySelector('.nav-links');

    function closeMenu() {
        navLinks.classList.remove('active');
        navToggle.classList.remove('active');
    }

    if (navToggle && navLinks) {
        // Abrir/cerrar menú al hacer clic en el botón hamburguesa
        navToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navLinks.classList.toggle('active');
            navToggle.classList.toggle('active');
        });

        // Cerrar menú al hacer clic en un enlace
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                closeMenu();
            });
        });

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (navLinks.classList.contains('active') &&
                !navLinks.contains(e.target) &&
                !navToggle.contains(e.target)) {
                closeMenu();
            }
        });

        // Cerrar menú al hacer scroll (solo en móviles)
        let scrollTimer;
        window.addEventListener('scroll', function() {
            if (window.innerWidth <= 768 && navLinks.classList.contains('active')) {
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(closeMenu, 150);
            }
        });

        // Cerrar menú al cambiar tamaño de ventana (si se pasa a desktop)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
                closeMenu();
            }
        });
    }
});
</script>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <!-- Logo a la izquierda - PEGADO AL INICIO -->
                <div class="logo">
                    <i class="fas fa-leaf"></i>
                    <h1>Biblioteca Verde UCV</h1>
                </div>

                <!-- Contenedor para menu y hamburguesa a la derecha - PEGADO AL FINAL -->
                <div class="nav-right">
                    <!-- Menú a la derecha -->
                    <ul class="nav-links">
                        <?php if (is_logged_in()) : ?>
                        <?php if (is_admin()) : ?>
                        <li><a href="<?php echo url('admin/panel'); ?>"><i class="fas fa-tachometer-alt"></i> Panel</a>
                        </li>
                        <li><a href="<?php echo url('prestamo/gestionar'); ?>"><i class="fas fa-exchange-alt"></i>
                                Préstamos</a>
                        </li>
                        <li><a href="<?php echo url('libro/gestionar'); ?>"><i class="fas fa-book"></i> Libros</a></li>
                        <li><a href="<?php echo url('admin/gestionarCategorias'); ?>"><i class="fas fa-tags"></i>
                                Categorías</a>
                        </li>
                        <?php else : ?>
                        <li><a href="<?php echo url('dashboard'); ?>"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                        </li>
                        <li><a href="<?php echo url('libro/catalogo'); ?>"><i class="fas fa-book"></i> Catálogo</a></li>
                        <li><a href="<?php echo url('prestamo/misPrestamos'); ?>"><i class="fas fa-list"></i> Mis
                                Préstamos</a>
                        </li>
                        <?php endif; ?>
                        <li class="user-menu">
                            <a href="<?php echo url('usuario/perfil'); ?>"><i class="fas fa-user-cog"></i>
                                Perfil</a>
                            <a href="<?php echo url('auth/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Salir</a>
                        </li>
                        <?php else : ?>
                        <li><a href="<?php echo url('home'); ?>"><i class="fas fa-home"></i> Inicio</a></li>
                        <li><a href="<?php echo url('auth/login'); ?>"><i class="fas fa-sign-in-alt"></i> Iniciar
                                Sesión</a>
                        </li>
                        <li><a href="<?php echo url('auth/register'); ?>"><i class="fas fa-user-plus"></i>
                                Registrarse</a>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Botón hamburguesa para móviles (a la derecha) -->
                    <button class="nav-toggle" aria-label="Abrir menú">
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>