const WIDTH = 960
const HEIGHT = 544
const MEDIDA = 32
const PRIMERA = 5
const SEGUNDA = 9
const TERCERA = 14

export class VistaJuego {

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

        this.torres = []
        this.torres.push({ x: MEDIDA * 12, y: this.canvas.height - 64, width: 32, height: 32, fill: "#AFDAFF", isDragging: false, radio: 100, vel: 1, lvl: 1, upg: false })
        this.torres.push({ x: MEDIDA * 16, y: this.canvas.height - 64, width: 32, height: 32, fill: "#ff550d", isDragging: false, radio: 150, vel: 2, lvl: 2, upg: false })
        this.torres.push({ x: MEDIDA * 20, y: this.canvas.height - 64, width: 32, height: 32, fill: "#444444", isDragging: false, radio: 200, vel: 3, lvl: 3, upg: false })

        this.torresColocadas = []

        this.arrayZonasDisponibles2 = this.conseguirZonasDisponibles(coordsMapaDos) //Comprobada

        this.canvas.onmousedown = this.pulsar.bind(this)
        this.canvas.onmouseup = this.soltar.bind(this)
        this.canvas.onmousemove = this.moverPulsado(this)

        this.dibujar()
    }
    //DIBUJAR TODO
    dibujarRect(x, y, w, h, color) {
        this.ctx.beginPath()
        this.ctx.rect(x, y, w, h)
        this.ctx.fillStyle = color
        this.ctx.closePath()
        this.ctx.fill()
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
        }
        //DIBUJO LAS COPIAS
        for (let i = 0; i < this.torresColocadas.length; i++) {
            let r = this.torresColocadas[i]
            this.ctx.fillStyle = r.fill
            this.dibujarRect(r.x, r.y, r.width, r.height)
        }
        this.dibujarZonasAtaque()

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
        this.ctx.font = '30px "Press Start 2P"'
        this.ctx.fillText("LVL1", MEDIDA * 10 - 16, MEDIDA * 16 - 8)
        this.ctx.fillText("LVL2", MEDIDA * 14 - 16, MEDIDA * 16 - 8)
        this.ctx.fillText("LVL3", MEDIDA * 18 - 16, MEDIDA * 16 - 8)
        this.ctx.stroke()
        this.ctx.closePath()

    }
    dibujarZonasAtaque() { //no funciona
        //Circulos de ataque
        for (let i = 0; i < this.torresColocadas.length; i++) {
            let r = this.torresColocadas[i];
            this.ctx.beginPath()
            this.ctx.fillStyle = "rgba(0, 0, 0, .05)"
            this.ctx.arc(r.x + 16, r.y + 16, r.radio, 0, 2 * Math.PI, false)
            this.ctx.lineWidth = .05
            this.ctx.fill()
            this.ctx.stroke()
            this.ctx.closePath()
        }
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
                        this.torresColocadas.push({ x: r.x, y: r.y, width: 32, height: 32, fill: r.fill, isDragging: true, colocada: false, upg: true, lvl: r.lvl })
                    else
                        this.torresColocadas.push({ x: r.x, y: r.y, width: 32, height: 32, fill: r.fill, isDragging: true, colocada: false, upg: false, lvl: r.lvl })
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
        this.dibujar()
    }
    moverPulsado(e) {
        //console.log("moviendo")
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
            // redraw the scene with the new rect positions
            this.dibujar()

            // reset the starting mouse position for the next mousemove
            this.startX = mx
            this.startY = my
        }
    }

    comprobarTorreMenu(coordX, coordY) {
        let bandera = false
        this.torres.forEach(element => {
            if (coordX >= element.x && coordX <= (element.x + element.width)
                && coordY >= element.y && coordY <= (element.y + element.height)) {
                bandera = true
                //console.log("torre menu");
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

        //console.log("Elemento: " + elemento.x + "-" + elemento.y);
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
                element.lvl++
                //Cambio el color
                if (element.lvl == 2)
                    element.fill = "#ff550d"
                if (element.lvl == 3) {
                    element.fill = "#444444"
                    //Si ahora es nivel 3, no se puede upgradear
                    element.upg = false
                }


            }

        });
        this.dibujar()
    }
}
