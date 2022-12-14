export class Sprite {
    constructor ({position= {x: 0, y: 0}, frames = {max: 1 } }){
        this.position = position
        this.frames = {
            max: frames.max,
            frame: 0,
            elapsed: 0,
            hold: 5
        }
    }
  pintar(ctx,imagen) {
    const trozoIdentificar = imagen.width / this.frames.max
    const trozo = {
        position: {
            x: 0,
            y: trozoIdentificar * this.frames.frame
        },
        width: trozoIdentificar,
        height: imagen.height
        
    }
    
    ctx.drawImage(
        imagen, 
        trozo.position.y,
        trozo.position.x,
        trozo.width,
        trozo.height,
        this.position.x,
        this.position.y,
        trozo.width,
        trozo.height
        )
         //Hace que se mueva mas suave, se intento con setTimeout pero no dio resultados
        this.frames.elapsed ++ 
        if (this.frames.elapsed % this.frames.hold === 0){
            this.frames.frame++
            if (this.frames.frame>= this.frames.max-1){
                this.frames.frame = 0
            }
        }
  }
}