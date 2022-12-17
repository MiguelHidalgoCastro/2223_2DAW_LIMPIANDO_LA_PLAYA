import { Torre } from "../objetos/torre.js"
import { Jugador } from "../objetos/jugador.js"
import { Enemigo } from "../objetos/enemigo.js"
import { Vista } from "../objetos/vista.js"
/** 
 * Constant for width of canvas
 * @type {number} 
*/
const WIDTH = 960
/** 
 * Constant for height of canvas
 * @type {number} 
 */
const HEIGHT = 544
/**
 * Constant for the measure of each cell
 * @type{number} 
 */
const MEDIDA = 32
/**
 * @author Miguel Hidalgo Castro - Sergio Rivera Salgado
 * CLASS VISTAJUEGO
 */
export class VistaJuego extends Vista{
    /**
     * Constructor of VistaJuego
     * @param {HTMLElement} canvas tag html
     */
    constructor(div,controlador,bandera) {
		super (div)
        this.contadorTiempo = 0
		this.bandera = false
		this.controlador = controlador
        window.onload = this.iniciar.bind(this)
    }

	//Añado esto para iniciar el juego
	cambiarBandera(){
		this.bandera = true
		this.continuar()
		this.divMenu.style.visibility = 'hidden'
		this.div.style.visibility = 'visible'
		this.audio.play()
	 }
    /**
     * Function that starts when the web has been loaded
     */
	 
    iniciar() {
		
        //Audios usados en el juego
		this.audio = document.getElementsByTagName('audio')[0]
        this.audio.volume = 0.5

        this.sonidoMatarEnemigo = document.getElementById('bichoMuerto')
        this.sonidoMatarEnemigo.volume = 0.5

        this.sonidoDerrota = document.getElementById('derrota')
        this.sonidoDerrota.volume = 0.5

		//Referente a la foto que inicia
		this.div.style.visibility = 'hidden'
		this.divMenu = document.getElementById('menu')
		this.divMenu.style.position ='absolute'
		this.divMenu.style.top = '40%'
		this.divMenu.style.left = '40%'
		this.divMenu.onclick = this.cambiarBandera.bind(this)

        //Referencia al formulario ranking
        this.divFormRanking = document.getElementById('divRankingJuego')
        this.h3Ranking = document.getElementById('h3PuntuacionLograda')
        this.inputPuntos = document.getElementById('puntosOculto')
        
		
        //Canvas
        this.canvas = document.getElementsByTagName("canvas")[0]
        this.canvas.width = WIDTH
        this.canvas.height = HEIGHT
        //Context
        this.ctx = this.canvas.getContext('2d')
        //https://developer.mozilla.org/es/docs/Web/API/Element/getBoundingClientRect#:~:text=getBoundingClientRect()%20devuelve%20el%20tama%C3%B1o,ventana%20de%20visualizaci%C3%B3n%20(viewport).
        this.borderBox = this.canvas.getBoundingClientRect()
        this.offsetX = this.borderBox.left
        this.offsetY = this.borderBox.top

        this.lvl1 = new Image()
        this.lvl1.src = "img/torres/lvl1.png"
        this.lvl2 = new Image()
        this.lvl2.src = "img/torres/lvl2.png"
        this.lvl3 = new Image()
        this.lvl3.src = "img/torres/lvl3.png"
		
		this.image = new Image()
        this.image.src = 'img/sprites/sprite2.png'

        this.imgDinero = new Image()
        this.imgDinero.src = 'img/iconos/billete.png'
        
        this.imgCorazon = new Image()
        this.imgCorazon.src = 'img/iconos/corazon.png'

        this.escenario = new Image()
        this.escenario.src = "img/escenarios/mapa2.png"
        this.escenario.onload = this.continuar.bind(this)

        //div del mouseover de torres
        this.divCaracteristicas = document.getElementById('divCaracteristicas')
       
        this.pLvl = document.getElementById('pLvl')
        this.pAlcance = document.getElementById('pAlcance')
        this.pRecogidos = document.getElementById('pRecogidos')


    }
    /**
     * Function that starts when the images has been loaded
     * Asynchronous call
     */
    continuar() {
        this.ctx.beginPath()
        this.ctx.drawImage(this.escenario, 0, 0)

        this.dragok = false
        this.startX
        this.startY

        //Creo el jugador
        this.jugador = new Jugador()
        this.jugador.asignarPuntos(0) //Para probar los upgrade
        this.jugador.asignarDinero(200) //Para probar los upgrade

        //Creo los enemigos
        this.enemigos = []
        this.enemyCount = 4

        //Creo las torres
        let torrelvl1 = new Torre()
        torrelvl1.asignarEspecificacion(torrelvl1.especificacionlvl1())
        let torrelvl2 = new Torre()
        torrelvl2.asignarEspecificacion(torrelvl2.especificacionlvl2())
        let torrelvl3 = new Torre()
        torrelvl3.asignarEspecificacion(torrelvl3.especificacionlvl3())

        this.torres = []
        this.torres.push(torrelvl1)
        this.torres.push(torrelvl2)
        this.torres.push(torrelvl3)

        this.torresColocadas = []

        this.arrayZonasDisponibles2 = this.conseguirZonasDisponibles(coordsMapaDos) //Comprobada

        this.canvas.onmousedown = this.pulsar.bind(this)
        this.canvas.onmouseup = this.soltar.bind(this)
        this.canvas.onmousemove = this.moverPulsado.bind(this)

        this.spawnEnemigos()
        this.animar()
        //this.dibujar()
    }


    /**
     * Function to draws a rectangle
     * @param {number} x coord X
     * @param {number} y coord Y
     * @param {number} w width
     * @param {number} h height
     * @param {color} color color
     */
    dibujarRect(x, y, w, h, color) {
        this.ctx.beginPath()
        this.ctx.rect(x, y, w, h)
        this.ctx.fillStyle = color
        this.ctx.closePath()
        this.ctx.fill()
    }
    /**
     * Function to draws a circle
     * @param {number} x coord X
     * @param {number} y coord Y
     * @param {number} radio radio
     */
    dibujarArc(x, y, radio) {
        this.ctx.beginPath()
        this.ctx.arc(x + 16, y + 16, radio, 0, 2 * Math.PI, false)
        this.ctx.fillStyle = "rgba(0, 0, 0, .1)"
        this.ctx.closePath()
        this.ctx.fill()
    }
    /**
     * Function to spawn enemies
     */
    spawnEnemigos() {
        for (let i = 1; i < this.enemyCount + 1; i++) {
            const diferenciaX = i * 100
            this.enemigos.push(
                new Enemigo(this.ctx, this.image, {
                    position: { x: waypoints[0].x - diferenciaX, y: waypoints[0].y }
                }))
        }
    }
    /**
     * Main function to animate the game
     */
    animar() {
  
        this.animacion = requestAnimationFrame(this.animar.bind(this))
		if (this.bandera == false)
			cancelAnimationFrame(this.animacion)
        this.dibujar()
        for (let i = this.enemigos.length - 1; i >= 0; i--) {
            const enemigo = this.enemigos[i]
            enemigo.actualizar();

            if (enemigo.position.x > this.canvas.width) {
                this.jugador.vidas -= 1
                this.enemigos.splice(i, 1)

                if (this.jugador.vidas === 0) {
                    this.dibujar()
                    this.ctx.font = '40px "arco"';
                    //Que te ponga gameover
                    this.ctx.fillStyle = 'black'
                    this.ctx.strokeStyle = 'white'
                    this.ctx.fillText("Game over", this.canvas.width / 2.75, this.canvas.height / 2)
                    this.ctx.strokeText("Game over", this.canvas.width / 2.75, this.canvas.height / 2)
                    this.audio.pause()
                    this.sonidoDerrota.play()
                    cancelAnimationFrame(this.animacion)

                    //Aparece formulario para registro de puntuación
                    this.registrarPuntuacion()
                }
            }
            if (this.enemigos.length === 0) {
                this.enemyCount += 2
                this.spawnEnemigos()
            }
        }
        setInterval(this.comprobarContacto(), 1000000)
    }
    /**
     * Function to check that the enemy is in the radius of the tower
     */
    comprobarContacto() { //queda en intento
        //console.log("primero: " + this.enemigos[0].position.x + "-" + this.enemigos[0].position.y);
        
        for (let i = 0; i < this.torresColocadas.length; i++) {
			if(this.torresColocadas[i].contadorTiempo<870){
				this.torresColocadas[i].contadorTiempo++
			}
            
            /*const element = this.torresColocadas[i];
            let area = Math.PI * Math.pow(element.radio, 2)
            console.log(area); //calcula bien el area de la torres*/

            for (let y = 0; y < this.enemigos.length; y++){
                //(px,py) Punto del perímetro del rectángulo más cercano al círculo
                //(cx,cy) Centro de la circunferencia
                //(x,y) esquina del rectángulo
                let px
                let py

                let cx = this.torresColocadas[i].x + 16
                let cy = this.torresColocadas[i].y + 16
                
                px = cx

                if(px < this.enemigos[y].position.x)
                    px = this.enemigos[y].position.x
               
                if(px > this.enemigos[y].position.x + this.enemigos[y].width)
                    px = this.enemigos[y].position.x + this.enemigos[y].width
                
                py = cy

                if(py < this.enemigos[y].position.y)
                    py = this.enemigos[y].position.y

                if(py > this.enemigos[y].position.y + this.enemigos[y].height)
                    py = this.enemigos[y].position.y + this.enemigos[y].height

                let distancia = Math.sqrt((cx - px)*(cx - px) + (cy - py)*(cy - py))
				
				console.log(this.torresColocadas[i].contadorTiempo)
                if(distancia < this.torresColocadas[i].radio && this.torresColocadas[i].contadorTiempo>=870){
                    this.enemigos[y].vida -=10
                    if (this.enemigos[y].vida==0){
                        this.enemigos.splice(y,1)
                        this.jugador.sumarPuntos(100)
                        this.jugador.sumarDinero(25)
                        this.sonidoMatarEnemigo.play()
                        this.torresColocadas[i].contadorTiempo=0                    
                        console.log(this.enemigos)
                        this.torresColocadas[i].recogidos++
                        if(this.enemigos.length===0){
                            this.enemyCount += 2
                            this.spawnEnemigos()
                        }
                    }
                    
                }
            }
        }
    }

    /**
     * Redraw scenary
     */
    clear() {
        this.ctx.drawImage(this.escenario, 0, 0)
    }

    /**
     * Main Function to redraw towers and their attack zones, letters & scenary
     */
    dibujar() {

        this.clear()
        //this.dibujarGrid()
        this.dibujarLetras(false)

        //DETALLES MENÚ SUPERIOR
        this.ctx.fillStyle = this.imgDinero.fill
        this.ctx.drawImage(this.imgDinero, MEDIDA * 23.2, 0)
        
        this.ctx.fillStyle = this.imgCorazon.fill
        this.ctx.drawImage(this.imgCorazon, MEDIDA * 28.3, 0)

        //DIBUJO EL MENÚ
        for (let i = 0; i < this.torres.length; i++) {
            let r = this.torres[i];
            this.ctx.fillStyle = r.fill;
            this.dibujarRect(r.x, r.y, r.width, r.height);
            if (r.lvl == 1)
                this.ctx.drawImage(this.lvl1, r.x, r.y)
            if (r.lvl == 2)
                this.ctx.drawImage(this.lvl2, r.x, r.y)
            if (r.lvl == 3)
                this.ctx.drawImage(this.lvl3, r.x, r.y)
        }

        

        //DIBUJO LAS COPIAS
        for (let i = 0; i < this.torresColocadas.length; i++) {
            let r = this.torresColocadas[i]
            this.ctx.fillStyle = r.fill
            this.dibujarRect(r.x, r.y, r.width, r.height);
            if (r.lvl == 1)
                this.ctx.drawImage(this.lvl1, r.x, r.y)
            if (r.lvl == 2)
                this.ctx.drawImage(this.lvl2, r.x, r.y)
            if (r.lvl == 3)
                this.ctx.drawImage(this.lvl3, r.x, r.y)
                
        }

        //ZONAS ATAQUE
        for (let i = 0; i < this.torresColocadas.length; i++) {
            let r = this.torresColocadas[i]
            this.ctx.fillStyle = r.fill
            if (r.lvl == 1)
                this.dibujarArc(r.x, r.y, r.radio)
            if (r.lvl == 2)
                this.dibujarArc(r.x, r.y, r.radio)
            if (r.lvl == 3)
                this.dibujarArc(r.x, r.y, r.radio)
        }

    }

    /**
     * FUNCIÓN COLISIONES
     */
    

    /**
     * Helper function to draw a grid
     */
    dibujarGrid() {
        this.ctx.strokeStyle = 'black'
        this.ctx.lineWidth = 4
        this.ctx.strokeRect(0, 0, WIDTH, HEIGHT)

        //lineas horizontales
        for (let index = 32; index < this.canvas.height; index += 32) {
            this.ctx.beginPath()
            this.ctx.lineWidth = .5
            this.ctx.moveTo(0, index)
            this.ctx.lineTo(this.canvas.width, index)
            this.ctx.stroke()
            this.ctx.closePath()

        }
        //lineas verticales
        for (let index = 32; index < this.canvas.width; index += 32) {
            this.ctx.beginPath()
            this.ctx.moveTo(index, 0)
            this.ctx.lineTo(index, this.canvas.height)
            this.ctx.stroke()
            this.ctx.closePath()
        }

        //Resaltar zonas disponibles
        for (let i = 0; i < this.arrayZonasDisponibles2.length; i++) {
            this.ctx.strokeStyle = 'blue'
            this.ctx.lineWidth = .5
            this.ctx.beginPath()
            this.ctx.strokeRect(this.arrayZonasDisponibles2[i].x * 32, this.arrayZonasDisponibles2[i].y * 32, 32, 32)
            this.ctx.stroke()
            this.ctx.closePath()
        }
    }

    /**
     * Function to draw various game texts
     */
    dibujarLetras() {

        this.ctx.beginPath()

        this.ctx.fillStyle = 'white';
        this.ctx.strokeStyle = 'black';
        
        this.ctx.font = '14px "arco"'

        this.ctx.fillText("LVL1", 280, MEDIDA * 16 - 8)
        this.ctx.strokeText("LVL1", 280, MEDIDA * 16 - 8)
        this.ctx.fillText("100$", 280, MEDIDA * 16.2)
        this.ctx.strokeText("100$", 280, MEDIDA * 16.2)

        this.ctx.fillText("LVL2",  440, MEDIDA * 16 - 8)
        this.ctx.strokeText("LVL2", 440, MEDIDA * 16 - 8)
        this.ctx.fillText("175$", 440, MEDIDA * 16.2)
        this.ctx.strokeText("175$", 440, MEDIDA * 16.2)

        this.ctx.fillText("LVL3", 600, MEDIDA * 16 - 8)
        this.ctx.strokeText("LVL3", 600, MEDIDA * 16 - 8)
        this.ctx.fillText("225$", 600, MEDIDA * 16.2)
        this.ctx.strokeText("225$", 600, MEDIDA * 16.2)
        


        //Menu superior derecha
        this.ctx.fillStyle = 'black'
        this.ctx.strokeStyle = 'white'

        this.ctx.fillText("Dinero: " + this.jugador.dinero+ '$', MEDIDA * 20, 18 )
        this.ctx.strokeText("Dinero: " + this.jugador.dinero+ '$', MEDIDA * 20, 18 )

        this.ctx.fillText("Puntuación: " + this.jugador.puntos, MEDIDA * 14, 18)
        this.ctx.strokeText("Puntuación: " + this.jugador.puntos, MEDIDA * 14, 18)

        this.ctx.fillText("Vidas: " + this.jugador.vidas, MEDIDA * 26, 18)
        this.ctx.strokeText("Vidas: " + this.jugador.vidas, MEDIDA * 26, 18)

        this.ctx.stroke()
        this.ctx.closePath()
    }

    /**
     * Function that returns all the cells that you can use for the towers
     * @param {array} array Array of coordenadas.js 
     * @returns {array} Array with the available cells
     */
    conseguirZonasDisponibles(array) {
        let matriz = []
        let auxiliar = []
        let i = 0
        let contador = 0
        //Lleno la matriz
        while (i < array.length) {
            if (contador < 30) {
                auxiliar[contador] = array[i]
                contador++
                i++
            }
            else {
                matriz.push(auxiliar)
                contador = 0
                auxiliar = []
            }
        }

        //En matriz ya tengo el escenario con los sitos posibles para las torres
        //console.log(matriz)
        //Recorro la matriz y creo un array con los sitos de colocación
        let sitios = []
        for (let i = 0; i < matriz.length; i++) {
            for (let j = 0; j < matriz[i].length; j++) {
                if (matriz[i][j] != 0)
                    sitios.push({ x: j, y: i })
            }

        }
        return sitios
    }

    //EVENTOS

    /**
     * Event of onmousedown
     * @param {event} e 
     */
    pulsar(e) {
        console.log("pulsando");
        // tell the browser we're handling this mouse event
        e.preventDefault()
        e.stopPropagation()

        // get the current mouse position
        let mx = parseInt(e.clientX - this.offsetX)
        let my = parseInt(e.clientY - this.offsetY)

         console.log("Coords: " + mx + "-" + my)



        if (this.comprobarTorreMenu(mx, my)) {
            //para ver si estoy pulsando en una torre del menú
            // test each rect to see if mouse is inside
            this.dragok = false;
            for (let i = 0; i < this.torres.length; i++) {
                let r = this.torres[i];
                if (mx > r.x && mx < r.x + r.width && my > r.y && my < r.y + r.height) {
                    // if yes, set that rects isDragging=true
                    this.dragok = true;
                    if (r.lvl == 1 || r.lvl == 2)
                        this.torresColocadas.push({ x: r.x, y: r.y, width: 32, height: 32, fill: r.fill, isDragging: true, colocada: false, upg: true, lvl: r.lvl, radio: r.radio, recogidos: r.recogidos, contadorTiempo: r.contadorTiempo })
                    else
                        this.torresColocadas.push({ x: r.x, y: r.y, width: 32, height: 32, fill: r.fill, isDragging: true, colocada: false, upg: false, lvl: r.lvl, radio: r.radio, recogidos: r.recogidos, contadorTiempo: r.contadorTiempo })
                }
            }
            // save the current mouse position
            this.startX = mx
            this.startY = my
        }

        //UPGRADE
        this.upgrade(mx, my)

    }
    /**
     * Event of onmouseup
     * @param {even} e 
     */
    soltar(e) {
        //console.log("soltado")
        // tell the browser we're handling this mouse event
        e.preventDefault()
        e.stopPropagation()

        let mx = parseInt(e.clientX - this.offsetX)
        let my = parseInt(e.clientY - this.offsetY)
        // console.log("Coords: " + mx + "-" + my)

        if (!this.comprobarZonaValida(mx, my) && this.dragok) { //dragok para que no me borre el ultimo elemento si pulso en cualquier lado de la pantalla
            this.torresColocadas.pop()
            //dibujar() //vuelvo a dibujar porque he eliminado el elemento del array
        }
        // clear all the dragging flags
        this.dragok = false
        for (let i = 0; i < this.torresColocadas.length; i++) {
            this.torresColocadas[i].isDragging = false
            if (i == this.torresColocadas.length - 1 && !this.torresColocadas[i].colocada) { //Aqui la coloco en el sitio exacto 
                let elemento = this.devolverCoordenada(mx, my)
                if (!this.comprobarCeldaOcupada(elemento.x, elemento.y) && this.torresColocadas[i].lvl == 1 && this.jugador.dinero>=100) {
                    this.torresColocadas[i].x = elemento.x
                    this.torresColocadas[i].y = elemento.y
                    this.torresColocadas[i].colocada = true
                    this.jugador.quitarDinero(100)
                }
                else {
                    if(!this.comprobarCeldaOcupada(elemento.x, elemento.y) && this.torresColocadas[i].lvl == 2 && this.jugador.dinero>=175){
                        this.torresColocadas[i].x = elemento.x
                        this.torresColocadas[i].y = elemento.y
                        this.torresColocadas[i].colocada = true
                        this.jugador.quitarDinero(175)
                    }
                    else {
                        if(!this.comprobarCeldaOcupada(elemento.x, elemento.y) && this.torresColocadas[i].lvl == 3 && this.jugador.dinero>=250){
                            this.torresColocadas[i].x = elemento.x
                            this.torresColocadas[i].y = elemento.y
                            this.torresColocadas[i].colocada = true
                            this.jugador.quitarDinero(250)
                        }
                        else {
                            this.torresColocadas.pop() //elimino del array si lo pongo encima
                        }
                    }
                }     
            }
        }
    }
    /**
     * Event of onmousemove
     * @param {event} e 
     */
    moverPulsado(e) {
        // if we're dragging anything...
        // tell the browser we're handling this mouse event
        e.preventDefault()
        e.stopPropagation()

        let div2 = document.getElementById('prueba')

        // get the current mouse position
        let mx = parseInt(e.clientX - this.offsetX)
        let my = parseInt(e.clientY - this.offsetY)

        // calculate the distance the mouse has moved
        // since the last mousemove
        let dx = mx - this.startX
        let dy = my - this.startY
        
        if (this.dragok) {

            // move each rect that isDragging 
            // by the distance the mouse has moved
            // since the last mousemove
            for (let i = 0; i < this.torresColocadas.length; i++) {
                let r = this.torresColocadas[i]
                if (r.isDragging) {
                    r.x += dx
                    r.y += dy
                }

            }
            // reset the starting mouse position for the next mousemove
            this.startX = mx
            this.startY = my
        }
        else{
            // get the current mouse position
            // mx y my es la coordenada del puntero
            
            //console.log("Coords: " + mx + "-" + my);
            //Recorre el array de torres colocadas, obtiene la coordenada y compara si el mouse está sobre ella
            for (let i = 0; i < this.torresColocadas.length; i++) {
                const element = this.torresColocadas[i];
                if (mx >= element.x && mx <= element.x + 32
                    && my >= element.y && my <= element.y + 32){
                       // console.log("sobre torre colocada")
                        this.divCaracteristicas.style.display = 'block'
                        i=this.torresColocadas.length //Para que salga del bucle for si se posiciona sobre cualquier torre
                        this.divCaracteristicas.style.transform = "translate(380px, 475px)"
                     
                        this.pLvl.textContent = 'Nivel de la torre: '+element.lvl
                        this.pAlcance.textContent = 'Alcance: '+element.radio
                        this.pRecogidos.textContent = 'Basura recogida: '+element.recogidos

                    }
                else{
                    //console.log('estoy fuera')
                    this.divCaracteristicas.style.display = 'none'
                }
            }

        }
        
        
    }

    /**
     * !IT DOES NOT WORK
     * Event of mouseover
     * @param {event} e 
     */
   /* mouseover(e) {
        e.preventDefault()
        e.stopPropagation()

        // get the current mouse position
        // mx y my es la coordenada del puntero
        
        let mx = parseInt(e.clientX - this.offsetX)
        let my = parseInt(e.clientY - this.offsetY)

        //console.log("Coords: " + mx + "-" + my);
        for (let i = 0; i < this.torresColocadas.length; i++) {
            const element = this.torresColocadas[i];
            if (mx >= element.x && mx <= element.x + 32
                && my >= element.y && my <= element.y + 32)
                console.log("sobre torre colocada");
                
        }
    }
*/
    /*CHECKS*/

    /**
     * Check if the tower is in the towers menu
     * @param {number} coordX 
     * @param {number} coordY 
     * @returns {boolean}
     */
    comprobarTorreMenu(coordX, coordY) {
        let bandera = false
        this.torres.forEach(element => {
            if (coordX >= element.x && coordX <= (element.x + element.width)
                && coordY >= element.y && coordY <= (element.y + element.height)) {
                bandera = true
            }
        })
        return bandera
    }

    /**
     * Check if the tower can be placed where I want to drop it
     * @param {number} coordX 
     * @param {number} coordY 
     * @returns {boolean}
     */
    comprobarZonaValida(coordX, coordY) {
        let bandera = false
        this.arrayZonasDisponibles2.forEach(element => {
            if (coordX >= element.x * 32 && coordY >= element.y * 32
                && coordX <= ((element.x + 1) * 32) && coordY <= ((element.y + 1) * 32)) {
                bandera = true
                return true
            }
        })
        return bandera
    }
    /**
     * Returns the top left coordinate of the cell
     * @param {number} coordX 
     * @param {number} coordY 
     * @returns {element} Returns coordinate
     */
    devolverCoordenada(coordX, coordY) {
        let elemento = { x: 0, y: 0 }

        elemento.x = parseInt(coordX / MEDIDA) * 32
        elemento.y = parseInt(coordY / MEDIDA) * 32

        return elemento
    }

    /**
     * Check if cell is busy
     * @param {number} coordX 
     * @param {number} coordY 
     * @returns {boolean}
     */
    comprobarCeldaOcupada(coordX, coordY) {
        let bandera = false
        for (let i = 0; i < this.torresColocadas.length; i++) {
            const element = this.torresColocadas[i]
            if (element.x == coordX && element.y == coordY)
                bandera = true

        }
        return bandera
    }

    //upgrade torres
    /**
     * Function to upgrade towers
     * @param {number} coordX 
     * @param {number} coordY 
     */
    upgrade(coordX, coordY) {
        //En éste elemento tengo la coordenada de arriba izquierda de donde estoy pulsando
        // Tengo que buscar si está en el array de torres colocadas
        let elemento = this.devolverCoordenada(coordX, coordY)

        this.torresColocadas.forEach(element => {
            if (element.x == elemento.x && element.y == elemento.y && element.colocada && element.upg) {
                //si se puede upgradear y está colocada
                console.log("encontrado");
                //Subo el nivel 
                if (element.lvl == 1 && this.jugador.dinero >= 100) {
                    element.lvl++
                    element.fill = "#ff550d" //cambio el color
                    element.radio += 50
                    this.jugador.quitarDinero(100)
                }

                else if (element.lvl == 2 && this.jugador.dinero >= 100) {
                    element.lvl++
                    element.fill = "#444444" //cambio el color
                    element.upg = false //lo desactivo ya que es ultimo nivel
                    element.radio += 50
                    this.jugador.quitarDinero(100)
                }
            }

        });
    }

    //Registrar puntuación
    /**
     * Función que muestra el formulario para registrar puntuación del jugador
     */
    registrarPuntuacion(){
        this.h3Ranking.textContent = 'Puntuación lograda: ' + this.jugador.puntos
        this.divFormRanking.style.display = 'block'
        this.inputPuntos.value = this.jugador.puntos
    }

}
