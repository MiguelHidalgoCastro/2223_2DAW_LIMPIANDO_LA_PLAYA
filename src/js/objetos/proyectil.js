/**
 * @author: Grupo Limpiemos La Playa
 * Class Proyectil
 */
 export class Proyectil {
	/**
	 * Proyectil Constructor
	 * @param {Context} ctx 
	 * @param {element} param1 Position
	 * 
	 */
	constructor(ctx, {position = { x: 0, y: 0 }}) {
		this.position = position
		this.velocidad = {
			x: 0,
			y: 0
		}
        this.ctx = ctx
	}
	/**
	 * Draw Proyectil
	 */
	pintar() {
		this.ctx.beginPath()
		this.ctx.arc(this.position.x, this.position.y, 50, 0, Math.PI * 2)
        this.ctx.fillStyle = 'orange'
        this.ctx.fill()
    }






	/**
	 * Delete Enemy
	 */
	borrar() {
		this.ctx.clearRect(this.position.x, this.position.y, this.width, this.height)
	}
	/**
	 * Update Enemy
	 */
	actualizar() {
		this.borrar()
		const waypoint = waypoints[this.waypointIndice]
		const distanciaY = waypoint.y - this.centrar.y
		const distanciaX = waypoint.x - this.centrar.x
		const angulo = Math.atan2(distanciaY, distanciaX)
		//Aqui se puede ajustar la rapidez
		const rapidez = .7
		this.velocidad.x = Math.cos(angulo) * rapidez
		this.velocidad.y = Math.sin(angulo) * rapidez
		this.position.x += this.velocidad.x
		this.position.y += this.velocidad.y

		this.centrar = {
			x: this.position.x + this.width / 2,
			y: this.position.y + this.height / 2
		}

		if (
			Math.abs(Math.round(this.centrar.x) - Math.round(waypoint.x)) <
			Math.abs(this.velocidad.x) &&
			Math.abs(Math.round(this.centrar.y) - Math.round(waypoint.y)) <
			Math.abs(this.velocidad.y) &&
			this.waypointIndice < waypoints.length - 1
		) {
			this.waypointIndice++
		}
		this.pintar()
	}
}