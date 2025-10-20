<?php
/**
 * Controllers - Clase base para todos los controladores
 * 
 * Proporciona la funcionalidad común que todos los controladores heredarán.
 * Implementa la carga automática de vistas y modelos relacionados,
 * siguiendo el patrón MVC (Model-View-Controller).
 * 
 * @package Libraries\Core
 * @author Grupo 11
 * @version 1.0
 */
class Controllers{
    /**
     * Constructor de la clase base Controller
     * 
     * Inicializa los componentes fundamentales que todo controlador necesita:
     * - Instancia del sistema de vistas
     * - Carga automática del modelo correspondiente
     * 
     * Este constructor se ejecuta automáticamente al crear cualquier controlador
     * que herede de esta clase base.
     */
    public function __construct()
    {
        /**
         * Inicializa el sistema de vistas
         * Permite al controlador renderizar templates y pasar datos a la vista
         */
        $this->views = new Views();
        
        /**
         * Carga automáticamente el modelo asociado al controlador
         * Ejemplo: HomeController carga automáticamente HomeModel
         */
        $this->loadModel();
    }

    /**
     * Carga automática del modelo correspondiente al controlador
     * 
     * Busca y carga dinámicamente el modelo que coincide con el nombre
     * del controlador actual. Sigue la convención: [ControllerName]Model
     * 
     * Ejemplo: 
     * - UsuarioController cargará UsuarioModel
     * - ProductoController cargará ProductoModel
     * 
     * @return void
     */
    public function loadModel()
    {
        /**
         * Obtiene el nombre de la clase actual y agrega sufijo "Model"
         * Ejemplo: Si la clase es "HomeController", el modelo será "HomeControllerModel"
         * NOTA: Considerar si el naming convention debería eliminar "Controller"
         */
        $model = get_class($this)."Model";
        
        /**
         * Construye la ruta del archivo del modelo
         * Asume que todos los modelos están en el directorio "Models/"
         */
        $routClass = "Models/".$model.".php";
        
        /**
         * Verifica si el archivo del modelo existe antes de cargarlo
         * Esto previene errores fatales si un controlador no tiene modelo asociado
         */
        if (file_exists($routClass)) {
            // Incluye el archivo de la clase del modelo
            require_once($routClass);
            
            /**
             * Crea una instancia del modelo y la asigna a una propiedad
             * del controlador, haciéndola accessible mediante $this->model
             */
            $this->model = new $model();
        }
        
        /**
         * Si el modelo no existe, simplemente no se carga
         * Esto permite tener controladores que no requieran modelo (solo vistas)
         */
    }
}
?>