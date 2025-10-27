// Funciones generales para la aplicación
class BibliotecaApp {
  constructor() {
    this.init();
  }

  init() {
    this.initEventListeners();
    this.initComponents();
  }

  initEventListeners() {
    // Manejo de formularios
    document.addEventListener("DOMContentLoaded", () => {
      this.handleForms();
      this.initSearch();
      this.initModals();
    });
  }

  initComponents() {
    // Inicializar componentes específicos
    if (typeof this.initCharts === "function") {
      this.initCharts();
    }
  }

  handleForms() {
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
      form.addEventListener("submit", (e) => {
        this.validateForm(form, e);
      });
    });
  }

  validateForm(form, e) {
    const requiredFields = form.querySelectorAll("[required]");
    let isValid = true;

    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        isValid = false;
        this.showFieldError(field, "Este campo es obligatorio");
      } else {
        this.clearFieldError(field);
      }
    });

    // Validación de email
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach((field) => {
      if (field.value && !this.isValidEmail(field.value)) {
        isValid = false;
        this.showFieldError(field, "Por favor ingresa un email válido");
      }
    });

    if (!isValid) {
      e.preventDefault();
      this.showAlert(
        "Por favor completa todos los campos requeridos correctamente",
        "error"
      );
    }
  }

  isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  showFieldError(field, message) {
    this.clearFieldError(field);
    field.classList.add("error");

    const errorElement = document.createElement("div");
    errorElement.className = "field-error";
    errorElement.style.color = "#e74c3c";
    errorElement.style.fontSize = "0.8rem";
    errorElement.style.marginTop = "0.25rem";
    errorElement.textContent = message;

    field.parentNode.appendChild(errorElement);
  }

  clearFieldError(field) {
    field.classList.remove("error");
    const existingError = field.parentNode.querySelector(".field-error");
    if (existingError) {
      existingError.remove();
    }
  }

  initSearch() {
    const searchInput = document.querySelector(".search-input");
    if (searchInput) {
      searchInput.addEventListener(
        "input",
        this.debounce((e) => {
          this.performSearch(e.target.value);
        }, 300)
      );
    }
  }

  debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  performSearch(query) {
    // Implementar búsqueda en tiempo real
    console.log("Buscando:", query);
  }

  initModals() {
    // Inicializar modales si existen
    const modals = document.querySelectorAll(".modal");
    modals.forEach((modal) => {
      const closeBtn = modal.querySelector(".close-modal");
      if (closeBtn) {
        closeBtn.addEventListener("click", () => {
          modal.style.display = "none";
        });
      }
    });

    // Cerrar modal al hacer clic fuera
    window.addEventListener("click", (e) => {
      modals.forEach((modal) => {
        if (e.target === modal) {
          modal.style.display = "none";
        }
      });
    });
  }

  showAlert(message, type = "info") {
    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;

    // Insertar al inicio del contenedor principal
    const container = document.querySelector(".container") || document.body;
    container.insertBefore(alertDiv, container.firstChild);

    // Auto-remover después de 5 segundos
    setTimeout(() => {
      alertDiv.remove();
    }, 5000);
  }

  // Método para cargar contenido dinámicamente
  async loadContent(url, container) {
    try {
      const response = await fetch(url);
      const html = await response.text();
      container.innerHTML = html;
    } catch (error) {
      console.error("Error cargando contenido:", error);
      this.showAlert("Error al cargar el contenido", "error");
    }
  }

  // Método para formatear fechas
  formatDate(dateString) {
    const options = {
      year: "numeric",
      month: "long",
      day: "numeric",
    };
    return new Date(dateString).toLocaleDateString("es-ES", options);
  }

  // Método para formatear números
  formatNumber(number) {
    return new Intl.NumberFormat("es-ES").format(number);
  }
}

// Inicializar la aplicación
const app = new BibliotecaApp();

// Funciones específicas para gráficos
class ChartManager {
  static initHuellaCarbonoChart(data) {
    // Implementar gráfico de huella de carbono
    console.log("Inicializando gráfico de huella de carbono:", data);
  }

  static initPrestamosChart(data) {
    // Implementar gráfico de préstamos
    console.log("Inicializando gráfico de préstamos:", data);
  }
}

// Exportar para uso global
window.BibliotecaApp = app;
window.ChartManager = ChartManager;
