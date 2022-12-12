export class Sprite {
    constructor ({position= {x: 0, y: 0}, frames = {max: 1 } }){
        this.position = position
        this.frames = {
            max: frames.max,
            frame: 0
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
        
        this.frames.frame ++ 
        if (this.frames.frame >= this.frames.max){
            this.frames.frame = 0
        }
  }
}