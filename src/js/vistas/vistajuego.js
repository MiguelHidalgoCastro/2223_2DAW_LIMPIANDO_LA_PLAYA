const WIDTH = 960
const HEIGHT = 544
const MEDIDA = 32

import { Torre } from "../objetos/torre.js"
import { Jugador } from "../objetos/jugador.js"
import { Enemigo } from "../objetos/enemigo.js"
export class VistaJuego {
    /**
     * Constructor de la Vista Juego, además, inicia el juego
     * @param {HTMLElement} canvas 
     */
    constructor(canvas) {
        this.etiquetaCanvas = canvas
        window.onload = this.iniciar()
    }


    iniciar() {
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
        

        this.escenario = new Image()
        this.escenario.src = "img/escenarios/mapa2.png"
        this.escenario.onload = this.continuar.bind(this)


    }

    continuar() {
        this.ctx.beginPath()
        this.ctx.drawImage(this.escenario, 0, 0)

        this.dragok = false
        this.startX
        this.startY

        //Creo el jugador
        this.jugador = new Jugador()
        this.jugador.asignarPuntos(2000) //Para probar los upgrade

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
        //this.canvas.addEventListener("mouseover", this.mouseover.bind(this))

        this.spawnEnemigos()
        this.animar()
        //this.dibujar()
    }


    //DIBUJAR TODO
    dibujarRect(x, y, w, h, color) {
        this.ctx.beginPath()
        this.ctx.rect(x, y, w, h)
        this.ctx.fillStyle = color
        this.ctx.closePath()
        this.ctx.fill()
    }

    dibujarArc(x, y, radio) {
        this.ctx.beginPath()
        this.ctx.arc(x + 16, y + 16, radio, 0, 2 * Math.PI, false)
        this.ctx.fillStyle = "rgba(0, 0, 0, .1)"
        this.ctx.closePath()
        this.ctx.fill()
    }

    spawnEnemigos() {
        for (let i = 1; i < this.enemyCount + 1; i++) {
            const diferenciaX = i * 100
            this.enemigos.push(
                new Enemigo(this.ctx, this.image,
                    {position: { x: waypoints[0].x - diferenciaX, y: waypoints[0].y }
                }))
        }
    }


    //Aqui es el main para que funcione el juego
    animar() {
        this.animacion = requestAnimationFrame(this.animar.bind(this))
        this.dibujar()
        for (let i = this.enemigos.length - 1; i >= 0; i--) {
            const enemigo = this.enemigos[i]
            enemigo.actualizar();

            if (enemigo.position.x > this.canvas.width) {
                this.jugador.vidas -= 1
                this.enemigos.splice(i, 1)

                if (this.jugador.vidas === 0) {
                    this.ctx.font = '40px "Press Start 2P"';
                    //Que te ponga gameover
                    this.ctx.fillStyle = 'black'
                    this.ctx.fillText("Game over", this.canvas.width / 4, this.canvas.height / 2)
                    cancelAnimationFrame(this.animacion)
                }
            }
            if (this.enemigos.length === 0) {
                this.enemyCount += 2
                this.spawnEnemigos()
            }
        }
        //let comprobar = setInterval(this.comprobarContacto.bind(this), 1000)
    }

    comprobarContacto() { //queda en intento
        //console.log("primero: " + this.enemigos[0].position.x + "-" + this.enemigos[0].position.y);

        for (let i = 0; i < this.torresColocadas.length; i++) {
            const element = this.torresColocadas[i];
            let area = Math.PI * Math.pow(element.radio, 2)
            //console.log(area); //calcula bien el area de la torres
        }
    }
    clear() {
        this.ctx.drawImage(this.escenario, 0, 0)
    }
    dibujar() {

        this.clear()
        //this.dibujarGrid()
        this.dibujarLetras()

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


    dibujarGrid() {
        this.ctx.strokeStyle = 'black'
        this.ctx.lineWidth = 4
        this.ctx.strokeRect(0, 0, WIDTH, HEIGHT)
        /*
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
        */
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

    //DIBUJAR LETRAS
    dibujarLetras() {
        this.ctx.beginPath()
        this.ctx.fillStyle = 'white'
        this.ctx.font = '12px "Press Start 2P"'
        this.ctx.fillText("LVL1", MEDIDA * 10 - 16, MEDIDA * 16 - 8)
        this.ctx.fillText("LVL2", MEDIDA * 14 - 16, MEDIDA * 16 - 8)
        this.ctx.fillText("LVL3", MEDIDA * 18 - 16, MEDIDA * 16 - 8)


        //Menu superior derecha
        this.ctx.fillStyle = 'black'
        this.ctx.fillText("Puntos: " + this.jugador.puntos, MEDIDA * 20, 18)
        this.ctx.fillText("Vidas: " + this.jugador.vidas, MEDIDA * 26, 18)

        this.ctx.stroke()
        this.ctx.closePath()
    }
    //DIBUJAR RECOGIDOS -- Para cuando funcione el mouseover
    dibujarRecogidos(coordX, coordY, cuantos) {
        this.ctx.beginPath()
        this.ctx.fillStyle = 'white'
        this.ctx.font = '26px "Press Start 2P"'
        this.ctx.fillText(cuantos, coordX, coordY)
        this.ctx.stroke()
        this.ctx.closePath()
    }

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
    pulsar(e) {
        // console.log("pulsando");
        // tell the browser we're handling this mouse event
        e.preventDefault()
        e.stopPropagation()

        // get the current mouse position
        let mx = parseInt(e.clientX - this.offsetX)
        let my = parseInt(e.clientY - this.offsetY)

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
                        this.torresColocadas.push({ x: r.x, y: r.y, width: 32, height: 32, fill: r.fill, isDragging: true, colocada: false, upg: true, lvl: r.lvl, radio: r.radio })
                    else
                        this.torresColocadas.push({ x: r.x, y: r.y, width: 32, height: 32, fill: r.fill, isDragging: true, colocada: false, upg: false, lvl: r.lvl, radio: r.radio })
                }
            }
            // save the current mouse position
            this.startX = mx
            this.startY = my
        }

        //UPGRADE
        this.upgrade(mx, my)

    }

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
                if (!this.comprobarCeldaOcupada(elemento.x, elemento.y)) {
                    this.torresColocadas[i].x = elemento.x
                    this.torresColocadas[i].y = elemento.y
                    this.torresColocadas[i].colocada = true
                }
                else {
                    this.torresColocadas.pop() //elimino del array si lo pongo encima
                }
            }
        }
    }
    moverPulsado(e) {
        // if we're dragging anything...
        if (this.dragok) {
            // tell the browser we're handling this mouse event
            e.preventDefault()
            e.stopPropagation()

            // get the current mouse position
            let mx = parseInt(e.clientX - this.offsetX)
            let my = parseInt(e.clientY - this.offsetY)

            // calculate the distance the mouse has moved
            // since the last mousemove
            let dx = mx - this.startX
            let dy = my - this.startY

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
    }
    mouseover(e) { // creo que me lo hace una vez porque no tengo el requestframeupdate
        e.preventDefault()
        e.stopPropagation()

        // get the current mouse position
        let mx = parseInt(e.clientX - this.offsetX)
        let my = parseInt(e.clientY - this.offsetY)
        console.log("Coords: " + mx + "-" + my);
        for (let i = 0; i < this.torresColocadas.length; i++) {
            const element = this.torresColocadas[i];
            if (mx >= element.x && mx <= element.x + 32
                && my >= element.y && my <= element.y + 32)
                console.log("estoy");
        }
    }

    /*Comprobaciones */
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

    devolverCoordenada(coordX, coordY) {
        let elemento = { x: 0, y: 0 }

        elemento.x = parseInt(coordX / MEDIDA) * 32
        elemento.y = parseInt(coordY / MEDIDA) * 32

        return elemento
    }
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

    upgrade(coordX, coordY) {
        //En éste elemento tengo la coordenada de arriba izquierda de donde estoy pulsando
        // Tengo que buscar si está en el array de torres colocadas
        let elemento = this.devolverCoordenada(coordX, coordY)

        this.torresColocadas.forEach(element => {
            if (element.x == elemento.x && element.y == elemento.y && element.colocada && element.upg) {
                //si se puede upgradear y está colocada
                console.log("encontrado");
                //Subo el nivel 
                if (element.lvl == 1 && this.jugador.puntos >= 100) {
                    element.lvl++
                    element.fill = "#ff550d" //cambio el color
                    element.radio += 50
                    this.jugador.quitarPuntos(100)
                }

                else if (element.lvl == 2 && this.jugador.puntos >= 200) {
                    element.lvl++
                    element.fill = "#444444" //cambio el color
                    element.upg = false //lo desactivo ya que es ultimo nivel
                    element.radio += 50
                    this.jugador.quitarPuntos(200)
                }
            }

        });
    }

}
