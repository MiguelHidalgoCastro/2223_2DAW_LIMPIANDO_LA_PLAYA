/**
    @file Contiene el controlador principal de la aplicación
    @author Free Chapapote <albertosalazarmunoz.guadalupe@alumnado.fundacionloyola.net>
    @license GPL-3.0-or-later
**/

import { VistaAdmin } from '../vistas/vistaadmin.js'


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

        this.nav = document.getElementsByTagName('nav')[0] //Buscamos el elemento nav

        this.formularioLogin = document.getElementsByTagName('main')[0]
        this.vistaAdmin = new VistaAdmin(this.formularioLogin)

    }
}

new Controlador()