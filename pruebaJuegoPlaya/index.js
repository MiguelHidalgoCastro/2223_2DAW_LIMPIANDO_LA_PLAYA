const canvas = document.querySelector('canvas')
	const c = canvas.getContext('2d')
	console.log(c)
	const MEDIDA = 32
	canvas.width = 960;
	canvas.height = 544;
	c.fillStyle = 'white'
	c.fillRect(0,0, canvas.width, canvas.height);
	
	const imagen = new Image()


  // Resolved - add font to document.fonts
	imagen.onload = () =>{
		animar()
		
	}
 
	
	imagen.src = 'mapav1.png'
	 /*No se le puede pasar la ruta de la imagen,
	 drawImage necesita un elemento html
	 */
	class Enemigo {
		constructor({position = {x: 0, y: 0} }) {
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
		}
		
		pintar() {
		
			c.fillStyle = 'red'
			c.fillRect(this.position.x, this.position.y, this.width, this.height)
			
			//Pongo el marcador aqui por ahora
			c.font = "30px serif";
			c.fillStyle = 'black'
			c.fillText("Puntos: " + 0, MEDIDA * 20, 32)
			c.fillText("Vidas: " + corazones, MEDIDA * 26, 32)
		}
		
		actualizar() {
			this.pintar()
			
			const waypoint = waypoints[this.waypointIndice]
			const distanciaY = waypoint.y - this.centrar.y
			const distanciaX = waypoint.x - this.centrar.x
			const angulo = Math.atan2(distanciaY, distanciaX)
			//Aqui se puede ajustar la rapidez
			const rapidez = 10
			this.velocidad.x = Math.cos(angulo)* rapidez
			this.velocidad.y = Math.sin(angulo)* rapidez
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
				this.waypointIndice < waypoints.length -1
			) {
				this.waypointIndice++
			}		
		}
	}
	
	const enemigos = []
	
	
	function spawnEnemigos(spawnCount){
		for (let i = 1; i < spawnCount + 1; i++)
		{
			const diferenciaX = i * 100
			enemigos.push(
			new Enemigo({
				position: { x: waypoints[0].x - diferenciaX,  y: waypoints[0].y}
			}))
		}
	}
	
	//Aqui podemos implementar el random
	
	let enemyCount = 9
	let corazones = 10
	spawnEnemigos(enemyCount)
	
	 function animar(){
		const animacion = requestAnimationFrame(animar)
		c.drawImage(imagen, 0, 0)
		
		
		for (let i = enemigos.length - 1; i>=0; i--){
			const enemigo = enemigos[i]
			enemigo.actualizar();
			
			if (enemigo.position.x > canvas.width){
				corazones -= 1
				enemigos.splice(i, 1)
				console.log(corazones)
				
				if (corazones === 0){
					c.font = "100px serif";
					//Que te ponga gameover
					c.fillStyle = 'black'
					c.fillText("Game over",canvas.width/4,canvas.height/2)
					cancelAnimationFrame(animacion)
				}
			}
			console.log(enemigos.length)
			if (enemigos.length === 0) {
				enemyCount += 2
				spawnEnemigos(enemyCount)			
			}
		}
			
	}
	 
	