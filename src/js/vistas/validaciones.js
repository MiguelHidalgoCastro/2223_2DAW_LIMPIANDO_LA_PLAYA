/**
    @file Contiene la vista/validaciones del formulario de torres.
    @author Free Chapapote
    @license GPL-3.0-or-later
**/

/**
 * Llama a la función iniciar.
 */
window.onload = iniciar

/**
 * Contiene las validaciones de las torres
 */

function iniciar(){
  if(document.getElementById("formAnadir")){
    document.getElementById("formAnadir").addEventListener('submit', validacionAnadir)  
  }
  
  if(document.getElementById("formularioModificarEnemigo")){
    document.getElementById("formularioModificarEnemigo").addEventListener('submit', validacionModificar)
  }

  if(document.getElementById("formConfiguracion")){
    let inputDimension = document.getElementsByTagName('input')[5]
    inputDimension.addEventListener('mouseover', eventoDimensionMouseover) 
    inputDimension.addEventListener('mouseout', eventoDimensionMouseout) 
    document.getElementById("formConfiguracion").addEventListener('submit', validacionConfiguracion)
  }
  
}

/**
 * Función para validar que todos los campos del formulario añadir estén rellenos
 * @param {submit} evento 
 * @returns 
 */
function validacionAnadir(evento){
    evento.preventDefault()
    let nombre = document.getElementsByTagName('input')[2]
    let velocidad = document.getElementsByTagName('input')[3]
    let puntos = document.getElementsByTagName('input')[4]
    let imagen = document.getElementsByTagName('input')[5]
   
    if(confirm('¿Estás seguro de querer añadir un enemigo?')){
      if(nombre.value=="" || velocidad.value=="" || puntos.value=="" || imagen.value==""){
        alert('Todos los campos han de estar rellenados')
        return
      }
    }
    else{
      return
    }
    this.submit()
    alert('El enemigo ha sido creado con éxito')
}

/**
 * Función para validar que todos los campos del formulario de modificación de enemigos estén rellenos
 * @param {submit} evento 
 * @returns 
 */
function validacionModificar(evento){
  evento.preventDefault()
  let nombre = document.getElementsByTagName('input')[2]
  let velocidad = document.getElementsByTagName('input')[3]
  let puntos = document.getElementsByTagName('input')[4]
  let imagen = document.getElementsByTagName('input')[5]
 
  if(confirm('¿Estás seguro de querer añadir un enemigo?')){
    if(nombre.value=="" || velocidad.value=="" || puntos.value=="" || imagen.value==""){
      alert('Todos los campos han de estar rellenados')
      return
    }
  }
  else{
    return
  }
  this.submit()
  alert('El enemigo ha sido modificado con éxito')
}

/**
 * Función para validar que todos los campos del formulario de configuración estén rellenos
 * @param {submit} evento 
 * @returns 
 */
 function validacionConfiguracion(evento){
  evento.preventDefault()
  let rutaTorre = document.getElementsByTagName('input')[2]
  let rutaEnemigo = document.getElementsByTagName('input')[3]
  let rutaEscenario = document.getElementsByTagName('input')[4]
  let dimensiones = document.getElementsByTagName('input')[5]
  let filasRanking = document.getElementsByTagName('input')[6]
 
  if(confirm('¿Está seguro de querer modificar la configuración?. El juego podría dejar de funcionar')){
    if(rutaTorre.value=="" || rutaEnemigo.value=="" || rutaEscenario.value=="" || dimensiones.value=="" || filasRanking==""){
      alert('Todos los campos han de estar rellenados')
      return
    }
  }
  else{
    return
  }
  this.submit()
  alert('La configuración ha sido modificada con éxito')
}

function eventoDimensionMouseover(){
  document.getElementById('divEmergente').style.display = 'block'
}

function eventoDimensionMouseout(){
  document.getElementById('divEmergente').style.display = 'none'
}
