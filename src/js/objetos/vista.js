
/**
	Implementa una vista.
	Debería ser abstracta.
**/
export class Vista{
	/**
		Constructor de la clase
	**/
	constructor(div){
		this.div = div
	}
	/**
		Muestra u oculta el div principal de la vista.
		@param ver {Boolean} True muestra la vista y false la oculta.
	**/
	mostrar(ver){
		if (ver){
			this.div.style.display = 'flex'
		}
		else
			this.div.style.display = 'none'
	}
}
