

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
       this.iniciar()
    }

    /**
     * Solo crea las vistas por ahora
     */
    iniciar() {

        //juego
	this.juegoCanvas = document.getElementById('juego')
    this.juegoTower = new VistaJuego(this.juegoCanvas, this)
    }
}

new Controlador()