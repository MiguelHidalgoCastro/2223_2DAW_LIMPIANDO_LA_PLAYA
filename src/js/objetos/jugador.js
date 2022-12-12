
export class Jugador {
    constructor() {
        this.puntos = 0
        this.vidas = 10
    }
    /* Puntos */
    asignarPuntos(puntos) {
        this.puntos = puntos
    }
    sumarPuntos() {
        this.puntos += 100
        return true
    }
    quitarPuntos(puntos) {
        this.puntos -= puntos
    }

    /* Vidas */
    asignarVidas(vidas) {
        this.vidas = vidas
    }
    sumarVida() {
        this.vidas++
        return true
    }
    quitarVida() {
        this.vidas--
        return true
    }







}