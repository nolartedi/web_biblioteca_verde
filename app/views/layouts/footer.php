</main>

<footer style="background: var(--secondary-color); color: white; padding: 0.5rem 0;">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-fullwidth">
                <h3 style="margin: 0 0 0.3rem 0; font-size: 1.3rem;">Biblioteca Verde UCV</h3>
                <p style="margin: 0; font-size: 0.95rem; opacity: 0.9; line-height: 1.2;">
                    Plataforma inteligente de préstamo digital y gestión sostenible
                </p>
            </div>
            <div class="footer-two-columns">
                <div class="footer-section">
                    <h4 style="margin: 0 0 0.3rem 0; font-size: 1.1rem;">Enlaces Rápidos</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 0.2rem;">
                            <a href="<?php echo url('home'); ?>"
                                style="color: white; text-decoration: none; font-size: 0.95rem;">
                                Inicio
                            </a>
                        </li>
                        <li style="margin-bottom: 0.2rem;">
                            <a href="<?php echo url('libro/catalogo'); ?>"
                                style="color: white; text-decoration: none; font-size: 0.95rem;">
                                Catálogo
                            </a>
                        </li>
                        <li style="margin-bottom: 0;">
                            <a href="<?php echo url('home/about'); ?>"
                                style="color: white; text-decoration: none; font-size: 0.95rem;">
                                Acerca de
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4 style="margin: 0 0 0.3rem 0; font-size: 1.1rem;">Contacto</h4>
                    <div style="font-size: 0.95rem;">
                        <p style="margin: 0.2rem 0; display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fas fa-envelope" style="width: 16px;"></i>
                            <a href="mailto:bliblioteca@ucv.edu" style="color: white; text-decoration: none;">
                                bliblioteca@ucv.edu
                            </a>
                        </p>
                        <p style="margin: 0.2rem 0 0 0; display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fas fa-phone" style="width: 16px;"></i>
                            (123) 456-7890
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom"
            style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 0.5rem; margin-top: 1.5rem;">
            <p style="margin: 0; text-align: center; font-size: 0.9rem; opacity: 0.8;">
                &copy; <?php echo date('Y'); ?> Biblioteca Verde UCV. Todos los derechos reservados.
            </p>
        </div>
    </div>
</footer>

<style>
.footer-grid {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.footer-fullwidth {
    width: 100%;
}

.footer-two-columns {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.footer-section {
    display: flex;
    flex-direction: column;
}

/* Desktop - 3 columnas */
@media (min-width: 1025px) {
    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 1rem;
    }

    .footer-two-columns {
        display: contents;
    }

    .footer-section:first-of-type {
        grid-column: 2;
    }

    .footer-section:last-of-type {
        grid-column: 3;
    }
}

/* Tablet */
@media (max-width: 1024px) and (min-width: 769px) {
    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 1rem;
    }

    .footer-two-columns {
        display: contents;
    }
}

/* Móvil - 1 fila + 2 columnas */
@media (max-width: 768px) {
    footer {
        padding: 0.4rem 0 !important;
    }

    .footer-grid {
        gap: 0.4rem;
    }

    .footer-fullwidth {
        padding-bottom: 1rem;
    }

    .footer-two-columns {
        gap: 0.8rem;
    }

    .footer-bottom {
        margin-top: 1rem !important;
        padding-top: 0.4rem !important;
    }
}

/* Móviles pequeños */
@media (max-width: 480px) {
    .footer-two-columns {
        grid-template-columns: 1fr;
        gap: 0.6rem;
    }

    footer {
        padding: 0.3rem 0 !important;
    }
}
</style>

<!-- El chatbot se mantiene intacto -->
<script src="<?php echo url('assets/js/main.js'); ?>"></script>
<script src="<?php echo url('assets/js/chatbot.js'); ?>"></script>
</body>

</html>