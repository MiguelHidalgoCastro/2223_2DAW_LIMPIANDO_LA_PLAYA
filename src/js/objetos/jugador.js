/**
 * @author Miguel Hidalgo Castro
 * CLASS JUGADOR
 */
export class Jugador {
    /**
     * Constructor
     */
    constructor() {
        this.puntos = 0
        this.vidas = 10
        this.dinero = 0
    }
    /* Puntos */
    /**
     * Assign points
     * @param {number} puntos 
     */
    asignarPuntos(puntos) {
        this.puntos = puntos
    }
    /**
     * Add score points
     * @param {number} points points of kill enemies
     * @returns {boolean}
     */
    sumarPuntos(points) {
        this.puntos += points
        return true
    }
    /**
     * Substract points
     * @param {*} puntos 
     */
    quitarPuntos(puntos) {
        this.puntos -= puntos
    }
    /* Dinero */
    /**
     * Asignar dinero al jugador
     * @param {number} dinero 
     */
    asignarDinero(dinero) {
        this.dinero = dinero
    }
    /**
     * Sumar dinero al jugador
     * @param {number} dinero points of kill enemies
     * @returns {boolean}
     */
    sumarDinero(dinero) {
        this.dinero += dinero
        return true
    }
    /**
     * Quitar dinero al jugador
     * @param {*} dinero 
     */
    quitarDinero(dinero) {
        this.dinero -= dinero
    }

    /* Vidas */
    /**
     * Assigned lifes 
     * @param {number} vidas 
     */
    asignarVidas(vidas) {
        this.vidas = vidas
    }
    /**
     * Add life
     * @returns {boolean}
     */
    sumarVida() {
        this.vidas++
        return true
    }
    /**
     * Substract life
     * @returns {boolean}
     */
    quitarVida() {
        this.vidas--
        return true
    }







}