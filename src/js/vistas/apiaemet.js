/**
    @file Contiene la llamada ajax a la api de la aemet para obtener el tiempo en Badajoz
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

    let myArr

    /**** Parte de AEMET ****/
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://opendata.aemet.es/opendata/api/prediccion/especifica/municipio/diaria/06015?api_key=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJhbnRvbmlvY2FybG9zbW9ydW5vZ29tZXouZ3VhZGFsdXBlQGFsdW1uYWRvLmZ1bmRhY2lvbmxveW9sYS5uZXQiLCJqdGkiOiI2YjEzOWY1OS0xYmYyLTQ2ZDItYWQwMS0yYTdkMTJlMTVjZWYiLCJpc3MiOiJBRU1FVCIsImlhdCI6MTY3MDI2NTU4NywidXNlcklkIjoiNmIxMzlmNTktMWJmMi00NmQyLWFkMDEtMmE3ZDEyZTE1Y2VmIiwicm9sZSI6IiJ9.P8lK0K7lft9YT96TkgvU_ywD2TdxQ51MXqLAR8C-Uc4",
        "method": "GET",
        "headers": {
        "cache-control": "no-cache"
        }
    }

    console.log(settings)
    
    $.ajax(settings).done(function (response) {

        var settings2 = {
        "async": true,
        "crossDomain": true,
        "url": response.datos,
        "method": "GET",
        "headers": {
            "cache-control": "no-cache"
        }

        }

        $.ajax(settings2).done(function (response2) {
        console.log(response2)
        myArr = JSON.parse(response2);
        
        tratarDatosTiempo()
        
        });

    });

    function tratarDatosTiempo(){
        let td1 = document.getElementsByTagName('td')[1]
        td1.appendChild(document.createTextNode(myArr[0].provincia))
        let td2 = document.getElementsByTagName('td')[3]
        td2.appendChild(document.createTextNode(myArr[0].prediccion.dia[0].estadoCielo[0].descripcion))
        let td3 = document.getElementsByTagName('td')[5]
        td3.appendChild(document.createTextNode(myArr[0].prediccion.dia[0].temperatura.minima+' ºC'))
        let td4 = document.getElementsByTagName('td')[7]
        td4.appendChild(document.createTextNode(myArr[0].prediccion.dia[0].temperatura.maxima+' ºC'))

        if (myArr[0].prediccion.dia[0].estadoCielo[0].descripcion == ''){
            td2.style.color = 'red'
            td2.appendChild(document.createTextNode('No hay datos registrados'))
        }
    }
    
}