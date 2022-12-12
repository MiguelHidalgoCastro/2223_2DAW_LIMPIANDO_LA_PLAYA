import { Sprite } from "../objetos/sprite.js"
/**
 * author: Sergio Rivera Salgado
 */

export class Enemigo extends Sprite {
	/**
	 * 
	 * @param {Context} ctx 
	 * @param {*} param1 
	 * 
	 */
	constructor(ctx, imagen, { position = { x: 0, y: 0 } }) {
		super({
			position, 
			frames: {
				max: 7
			}
		})
		this.position = position
		this.width = 32
		this.height = 32
		this.waypointIndice = 0
		this.centrar = {
			x: this.position.x + this.width / 2,
			y: this.position.y + this.height / 2
		}
		this.velocidad = {
			x: 0,
			y: 0
		}
		this.imagen = imagen
		this.ctx = ctx
	}
	actualizar() {
		const waypoint = waypoints[this.waypointIndice]
		const distanciaY = waypoint.y - this.centrar.y
		const distanciaX = waypoint.x - this.centrar.x
		const angulo = Math.atan2(distanciaY, distanciaX)
		//Aqui se puede ajustar la rapidez
		const rapidez = 1
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
		this.pintar(this.ctx, this.imagen)
	}
}
