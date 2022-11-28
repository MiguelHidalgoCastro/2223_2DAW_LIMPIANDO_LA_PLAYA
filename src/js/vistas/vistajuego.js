

export class VistaJuego {

    constructor(canvas) {
        this.etiquetaCanvas = canvas
        this.iniciarJuego()
    }

    iniciarJuego() {
        console.log("funciono");

        const canvas = document.querySelector('canvas')
        canvas.width = 960
        canvas.height = 544

        this.medida = 32
        this.primeraLinea = this.medida * 5
        this.segundaLinea = this.medida * 9
        this.terceraLinea = this.medida * 14

        const ctx = canvas.getContext('2d')

        this.dibujarGrid(ctx, canvas)
        this.update(ctx, canvas)
    }

    update(ctx, canvas) {
        console.log("Estoy en el udpate");
        ctx.clearRect(0, 0, canvas.width, canvas.height)
        this.dibujarGrid(ctx, canvas)

        requestAnimationFrame(this.update)
    }

    dibujarGrid(ctx, canvas) {
        ctx.strokeStyle = 'black'
        ctx.lineWidth = 10
        ctx.strokeRect(0, 0, this.medida * 30, this.medida * 17)
        //muevo el pincel
        ctx.lineWidth = 1


        //lineas horizontales
        for (let index = 32; index < canvas.height; index += 32) {
            ctx.beginPath()
            ctx.moveTo(0, index)
            ctx.lineTo(canvas.width, index)
            ctx.stroke()
            ctx.closePath()

        }

        //lineas verticales
        for (let index = 32; index < canvas.width; index += 32) {
            ctx.beginPath()
            ctx.moveTo(index, 0)
            ctx.lineTo(index, canvas.height)
            ctx.stroke()
            ctx.closePath()

        }

        //lineas de arriba de la calle
        ctx.strokeStyle = 'green'
        ctx.lineWidth = 4
        ctx.beginPath()
        ctx.moveTo(0, this.primeraLinea)
        ctx.lineTo(canvas.width, this.primeraLinea)
        ctx.stroke()
        ctx.closePath()

        //lineas de abajo de la calle
        ctx.strokeStyle = 'green'
        ctx.lineWidth = 4
        ctx.beginPath()
        ctx.moveTo(0, this.segundaLinea)
        ctx.lineTo(canvas.width, this.segundaLinea)
        ctx.stroke()
        ctx.closePath()

        //lineas de fin de escenario
        ctx.strokeStyle = 'green'
        ctx.lineWidth = 4
        ctx.beginPath()
        ctx.moveTo(0, this.terceraLinea)
        ctx.lineTo(canvas.width, this.terceraLinea)
        ctx.stroke()
        ctx.closePath()
    }
}