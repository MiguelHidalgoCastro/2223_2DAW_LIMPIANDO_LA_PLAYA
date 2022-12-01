

import { VistaJuego } from "../vistas/vistajuego.js";


/**
 * Controlador de la aplicación
 */
class Controlador {
    /**
     * Constructor de la aplicación
     * Al cargar la página llama a la funcion iniciar
     */
    constructor() {
        window.onload = this.iniciar.bind(this)
    }

    /**
     * Solo crea las vistas por ahora
     */
    iniciar() {

        //juego
        this.juegoCanvas = document.getElementsByTagName('canvas')[0]
        this.juegoTower = new VistaJuego(this.juegoCanvas)
    }
}

new Controlador()