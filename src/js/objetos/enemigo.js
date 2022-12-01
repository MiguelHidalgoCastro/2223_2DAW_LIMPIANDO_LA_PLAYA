/**
 * author: Sergio Rivera Salgado
 */

export class Enemigo {
    constructor() {
        this.x
        this.y
        this.width = 32
        this.height = 32
        this.waypointIndice = 0
        this.centrar = {
            x: this.x + this.width / 2,
            y: this.y + this.height / 2
        }
        this.velocidad = {
            x: 0,
            y: 0
        }
    }

    crearEnemigo(coordX, coordY, width, height, velocidad) {
        this.x = coordX
        this.y = coordY
        this.width = width
        this.height = height
        this.velocidad.x = velocidad.x
        this.velocidad.y = velocidad.y
    }

    setwaypointindice(waypoint) {
        this.waypointIndice = waypoint
    }

    getwaypointinidice() {
        return this.waypointIndice
    }

    setVelocidad(velX, velY) {
        this.velocidad.x = velX
        this.velocidad.y = velY
    }

    getVelocidad() {
        return this.velocidad
    }

    setPosicion(coordX, coordY) {
        this.x = coordX
        this.y = coordY
        this.centrar = {
            x: this.x + this.width / 2,
            y: this.y + this.height / 2
        }
    }
}
