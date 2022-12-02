/**
    @file Contiene la vista del login del administrador
    @author Free Chapapote <albertosalazarmunoz.guadalupe@alumnado.fundacionloyola.net>
    @license GPL-3.0-or-later
**/

/**
 * Vista del administrador
 * Contiene el formulario para que el administrador inicie sesión
 * Se hace la validación de este formulario
 */
export class VistaAdmin {
    /**
     * @param  {HTMLDivElement} div Div principal de la vista
     */
    constructor(div) {
        this.div = div
        this.crear()
    }

    /**
     * La funcion crear va a añadir los diferentes elementos del formualario mediante DOM 
     */
    crear() {
        console.log("estoy aqui");
        this.etiquetaForm = document.createElement('form')
        this.etiquetaForm.setAttribute('id', 'login')
		this.etiquetaForm.setAttribute('method', 'POST')
		this.etiquetaForm.setAttribute('action', '')

        this.divNuevo = document.createElement('div')
        this.divNuevo.setAttribute('id', 'formularioLogin')

        this.tituloInicioSesion = document.createElement('h2')
        this.tituloInicioSesion.textContent = 'INICIO DE SESION'

        this.labelUsuario = document.createElement('label')
        this.labelUsuario.textContent = 'Usuario'
        this.labelUsuario.setAttribute('for', 'nombre')


        this.inputUsuario = document.createElement('input')
        this.inputUsuario.type = 'text'
        this.inputUsuario.name = 'nombre'
        this.inputUsuario.id = 'idInputUsuario'
        /*this.inputEmail.setAttribute('placeholder', 'example@addres.net')*/
        this.inputUsuario.setAttribute('required', 'required')
        //this.inputEmail.setAttribute('pattern', '^((?!\.)[\w_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$')

        this.labelPassword = document.createElement('label')
        this.labelPassword.textContent = 'Contraseña'
        this.labelPassword.setAttribute('for', 'pass')

        this.inputPassword = document.createElement('input')
        this.inputPassword.type = 'password'
        this.inputPassword.name = 'pass'
        this.inputPassword.id = 'idInputPass'
        this.inputPassword.setAttribute('required', 'required')
        //  this.inputPassword.setAttribute('pattern', '^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$')

        this.btnSubmit = document.createElement('button')
        this.btnSubmit.type = 'submit'
        this.btnSubmit.textContent = 'ENTRAR'
        this.btnSubmit.addEventListener('click', this.validarCampos)

        //Añadimos los elementos anteriormente creados en el div principal de esta vista
        this.div.appendChild(this.etiquetaForm)
        this.etiquetaForm.appendChild(this.divNuevo)
        this.divNuevo.appendChild(this.tituloInicioSesion)
        this.divNuevo.appendChild(this.labelUsuario)
        this.divNuevo.appendChild(this.inputUsuario)
        this.divNuevo.appendChild(this.labelPassword)
        this.divNuevo.appendChild(this.inputPassword)
        this.divNuevo.appendChild(this.btnSubmit)


    }

    /**
     * La funcion se carga cuando se podroduce el evento de clickar sobre el boton Entrar 'btnEntrar' 
     * La función comprueba si se estan cumpliendos los requisitos del match
     */
    validarCampos() {
        console.log('estoy aqui validadndo');
        let user = document.getElementById('idInputUsuario').value
        let pass = document.getElementById('idInputPass').value
        let formulario = document.getElementById('formularioLogin')

        /*if (user.match(/^((?!\.)[\w_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/) == null) {
            alert('introduce bien el email')

        } else if (pass.match(/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/) == null) {
            alert('introduce bien la contraseña')

        }
        else {
            alert('todo bien')
        }*/

    }
}

