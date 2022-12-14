<?php
class VistaListaEscenarios
{
    function __construct($configuracion)
    {
        $this->configuracion = $configuracion;
    }

    function mostrar_rutas($datos) //aqui dan problemas los imports, si me lo cargo en uno, me lo hace mal en otro
    {
        $domheader = new DOMDocument();
        @$domheader->loadHTMLFile($this->configuracion['path_html'] . 'header.html');
        echo $domheader->saveHTML();


        $domfooter = new DOMDocument();
        @$domfooter->loadHTMLFile($this->configuracion['path_html'] . 'footer.html');
        echo $domfooter->saveHTML();
    }

    function mostrar($datos)
    {

        $dom = new DOMDocument();
        @$dom->loadHTMLFile($this->configuracion['path_html'] . 'plantilla.html');

        $div = $dom->getElementsByTagName("main")[0];

        $btnCrear = $dom->createElement('a'); // ahora es un link
        $btnCrear->setAttribute('href', './escenario/vercrear/'); //aqui tengo que ir a index
        $btnCrear->textContent = 'Crear Escenario';
        $btnCrear->setAttribute('class', 'btn btn-success');

        $tabla = $dom->createElement('table');
        $tabla->setAttribute('class', 'table table-striped');

        //thead
        $thead = $dom->createElement('thead');
        //trhead
        $trh = $dom->createElement('tr');

        //th1
        $th1 = $dom->createElement('th');
        $th1->textContent = "#";
        $th1->setAttribute('scope', 'col');

        //th2
        $th2 = $dom->createElement('th');
        $th2->textContent = "Nombre";
        $th2->setAttribute('scope', 'col');

        //th3
        $th3 = $dom->createElement('th');
        $th3->textContent = "Opciones";
        $th3->setAttribute('scope', 'col');

        $dom->appendChild($div);
        $div->appendChild($tabla);
        $tabla->appendChild($btnCrear);
        $tabla->appendChild($thead);
        $thead->appendChild($trh);
        $trh->appendChild($th1);
        $trh->appendChild($th2);
        $trh->appendChild($th3);


        //tbody
        $tbody = $dom->createElement('tbody');

        $tabla->appendChild($tbody);
        //While

        while ($fila =  $datos->fetch_object()) {

            $trb = $dom->createElement('tr');
            $thb = $dom->createElement('th');
            $thb->setAttribute('scope', 'row');
            $thb->textContent = $fila->id;
            $td = $dom->createElement('td');
            $td->textContent = $fila->nombre;

            $tdo = $dom->createElement('td');

            $btnMod = $dom->createElement('a');
            $btnMod->textContent = 'Modificar';
            $btnMod->setAttribute('class','btn btn-info');
            $btnMod->setAttribute('href', './escenario/modificar?id=' . $fila->id . '/');

            $tbody->appendChild($trb);
            $trb->appendChild($thb);
            $trb->appendChild($td);
            $trb->appendChild($tdo);
            $tdo->appendChild($btnMod);
        }

        echo $dom->saveHTML();
    }
}
