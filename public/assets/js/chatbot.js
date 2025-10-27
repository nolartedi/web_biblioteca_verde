// Chatbot functionality (diseño solamente)
class Chatbot {
  constructor() {
    this.isOpen = false;
    this.init();
  }

  init() {
    this.createChatbotHTML();
    this.attachEventListeners();
  }

  createChatbotHTML() {
    const chatbotHTML = `
            <div class="chatbot-container">
                <div class="chatbot-window" id="chatbotWindow">
                    <div class="chatbot-header">
                        <h3>Asistente Virtual</h3>
                        <button class="close-chatbot">×</button>
                    </div>
                    <div class="chatbot-messages" id="chatbotMessages">
                        <div class="message bot-message">
                            <p>¡Hola! Soy tu asistente virtual de la Biblioteca Verde UCV. ¿En qué puedo ayudarte?</p>
                        </div>
                    </div>
                    <div class="chatbot-input">
                        <input type="text" id="chatbotInput" placeholder="Escribe tu mensaje..." class="form-control">
                        <button id="sendMessage" class="btn btn-primary mt-1">Enviar</button>
                    </div>
                </div>
                <button class="chatbot-button" id="chatbotToggle">
                    💬
                </button>
            </div>
        `;

    document.body.insertAdjacentHTML("beforeend", chatbotHTML);
  }

  attachEventListeners() {
    const toggleBtn = document.getElementById("chatbotToggle");
    const closeBtn = document.querySelector(".close-chatbot");
    const sendBtn = document.getElementById("sendMessage");
    const input = document.getElementById("chatbotInput");

    toggleBtn.addEventListener("click", () => this.toggleChatbot());
    closeBtn.addEventListener("click", () => this.closeChatbot());
    sendBtn.addEventListener("click", () => this.sendMessage());

    input.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        this.sendMessage();
      }
    });
  }

  toggleChatbot() {
    const window = document.getElementById("chatbotWindow");
    this.isOpen = !this.isOpen;
    window.style.display = this.isOpen ? "flex" : "none";
  }

  closeChatbot() {
    const window = document.getElementById("chatbotWindow");
    this.isOpen = false;
    window.style.display = "none";
  }

  sendMessage() {
    const input = document.getElementById("chatbotInput");
    const message = input.value.trim();

    if (message) {
      this.addUserMessage(message);
      input.value = "";

      // Simular respuesta del bot
      setTimeout(() => {
        this.addBotMessage(this.generateResponse(message));
      }, 1000);
    }
  }

  addUserMessage(message) {
    const messagesContainer = document.getElementById("chatbotMessages");
    const messageDiv = document.createElement("div");
    messageDiv.className = "message user-message";
    messageDiv.innerHTML = `<p>${message}</p>`;
    messagesContainer.appendChild(messageDiv);
    this.scrollToBottom();
  }

  addBotMessage(message) {
    const messagesContainer = document.getElementById("chatbotMessages");
    const messageDiv = document.createElement("div");
    messageDiv.className = "message bot-message";
    messageDiv.innerHTML = `<p>${message}</p>`;
    messagesContainer.appendChild(messageDiv);
    this.scrollToBottom();
  }

  generateResponse(userMessage) {
    const responses = [
      "Entiendo tu consulta sobre '" +
        userMessage +
        "'. Te recomiendo contactar con nuestro equipo de soporte para información más específica.",
      "Gracias por tu mensaje. Nuestro sistema de IA está en desarrollo y pronto podré ayudarte mejor.",
      "Como asistente virtual de la Biblioteca Verde UCV, puedo ayudarte con información sobre préstamos, catálogo y sostenibilidad.",
      "¿Te gustaría saber más sobre cómo calcular tu huella de carbono con nuestros préstamos digitales?",
      "Puedo ayudarte a encontrar libros en nuestro catálogo digital. ¿Qué tema te interesa?",
    ];

    return responses[Math.floor(Math.random() * responses.length)];
  }

  scrollToBottom() {
    const messagesContainer = document.getElementById("chatbotMessages");
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }
}

// Inicializar chatbot cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  new Chatbot();
});
