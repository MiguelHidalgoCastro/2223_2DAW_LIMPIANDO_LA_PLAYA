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