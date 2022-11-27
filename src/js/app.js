/**
    @file Contiene el controlador principal de la aplicación
    @author Free Chapapote <albertosalazarmunoz.guadalupe@alumnado.fundacionloyola.net>
    @license GPL-3.0-or-later
**/

import { VistaAdmin } from './vistas/vistaadmin.js'

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
        console.log("estoy aqui");
    }

    /**
     * Solo crea las vistas por ahora
     */
    iniciar() {

        this.nav = document.getElementsByTagName('nav')[0] //Buscamos el elemento nav
        //this.vistaNav = new VistaNav (this.nav) //Introducimos el elemento en la vista nav


        this.formularioLogin = document.getElementsByTagName('main')[0]
        console.log(this.formularioLogin)
        this.vistaAdmin = new VistaAdmin(this.formularioLogin) //Introducimos el div del formulario en la clase Vista Admin 
    }
}

const app = new Controlador()