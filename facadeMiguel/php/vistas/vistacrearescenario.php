<?php
class VistaCrearEscenario
{

    function __construct($configuracion)
    {
        $this->configuracion = $configuracion;
    }

    function mostrar($datos)
    {
        $dom = new DOMDocument();
        @$dom->loadHTMLFile($this->configuracion['path_html'] . 'header.html');


        $main = $dom->getElementsByTagName("main")[0];
        $title = $dom->createElement('h1');
        $title->textContent = 'CREAR ESCENARIO';
        $title->setAttribute('class', 'h1');


        $form = $dom->createElement('form');
        $form->setAttribute('method', 'POST');



        //INSERT ESCENARIO UNO
        //Label Nombre
        $label1 = $dom->createElement('label');
        $label1->textContent = 'Nombre:';
        $label1->setAttribute('class', 'form-label col-8');
        //nombre input
        $input1 = $dom->createElement('input');
        //propiedades
        $input1->setAttribute('placeholder', 'Nombre escenario');
        $input1->setAttribute('type', 'text');
        $input1->setAttribute('name', 'inputname');
        $input1->setAttribute('class', 'form-control');

        //Label Dificultad
        $labelD = $dom->createElement('label');
        $labelD->textContent = 'Dificultad:';
        $labelD->setAttribute('class', 'form-label col-8');
        //nombre input
        $inputD = $dom->createElement('input');
        //propiedades
        $inputD->setAttribute('placeholder', 'Dificultad');
        $inputD->setAttribute('type', 'text');
        $inputD->setAttribute('name', 'inputdificultad');
        $inputD->setAttribute('class', 'form-control');

        //Label Waypoints
        $labelW = $dom->createElement('label');
        $labelW->textContent = 'Waypoints:';
        $labelW->setAttribute('class', 'form-label col-8');
        //nombre input
        $inputW = $dom->createElement('textarea');
        //propiedades
        $inputW->setAttribute('placeholder', 'waypoints');
        $inputW->setAttribute('name', 'textwaypoints');
        $inputW->setAttribute('class', 'form-control');

        //Label Coords
        $labelC = $dom->createElement('label');
        $labelC->textContent = 'Coordenadas:';
        $labelC->setAttribute('class', 'form-label col-8');
        //nombre input
        $inputC = $dom->createElement('textarea');
        //propiedades
        $inputC->setAttribute('placeholder', 'coordenadas');
        $inputC->setAttribute('name', 'textcoords');
        $inputC->setAttribute('class', 'form-control');

        //Label Ruta
        $labelR = $dom->createElement('label');
        $labelR->textContent = 'Ruta Imagen:';
        $labelR->setAttribute('class', 'form-label col-8');
        //nombre input
        $inputR = $dom->createElement('input');
        //propiedades
        $inputR->setAttribute('placeholder', 'Ruta');
        $inputR->setAttribute('type', 'text');
        $inputR->setAttribute('name', 'inputruta');
        $inputR->setAttribute('class', 'form-control');

        //INSERT ESCENARIO 2

        //nombre label2
        $label2 = $dom->createElement('label');
        $label2->textContent = 'Nombre:';
        $label2->setAttribute('class', 'form-label col-8');
        //nombre input2
        $input2 = $dom->createElement('input');
        //propiedades2
        $input2->setAttribute('placeholder', 'Nombre escenario');
        $input2->setAttribute('type', 'text');
        $input2->setAttribute('name', 'inputname2');

        //Label Dificultad
        $labelD2 = $dom->createElement('label');
        $labelD2->textContent = 'Dificultad:';
        //nombre input
        $inputD2 = $dom->createElement('input');
        //propiedades
        $inputD2->setAttribute('placeholder', 'Dificultad');
        $inputD2->setAttribute('type', 'text');
        $inputD2->setAttribute('name', 'inputdificultad2');

        //Label Waypoints
        $labelW2 = $dom->createElement('label');
        $labelW2->textContent = 'Waypoints:';
        //nombre input
        $inputW2 = $dom->createElement('textarea');
        //propiedades
        $inputW2->setAttribute('placeholder', 'waypoints');
        $inputW2->setAttribute('name', 'textwaypoints2');

        //Label Coords
        $labelC2 = $dom->createElement('label');
        $labelC2->textContent = 'Coordenadas:';
        //nombre input
        $inputC2 = $dom->createElement('textarea');
        //propiedades
        $inputC2->setAttribute('placeholder', 'coordenadas');
        $inputC2->setAttribute('name', 'textcoords2');

        //Label Ruta
        $labelR2 = $dom->createElement('label');
        $labelR2->textContent = 'Ruta Imagen:';
        //nombre input
        $inputR2 = $dom->createElement('input');
        //propiedades
        $inputR2->setAttribute('placeholder', 'Ruta');
        $inputR2->setAttribute('type', 'text');
        $inputR2->setAttribute('name', 'inputruta2');



        //boton submit
        $btnAceptar = $dom->createElement('input');
        $btnAceptar->setAttribute('type', 'submit');
        $btnAceptar->setAttribute('class', 'btn btn-success');
        $btnAceptar->setAttribute('value', 'ACEPTAR');
        // input hidden para decir que estoy haciendo <input type=hidden name=accion value=crear/>
        $inputhidden = $dom->createElement('input');
        $inputhidden->setAttribute('type', 'hidden');
        $inputhidden->setAttribute('name', 'accion');
        $inputhidden->setAttribute('value', 'crear');


        //divs
        $div = $dom->createElement('div');
        $div->setAttribute('class', 'mb-3');
        $div1 = $dom->createElement('div');
        $div1->setAttribute('class', 'mb-3');
        $div2 = $dom->createElement('div');
        $div2->setAttribute('class', 'mb-3');
        $div3 = $dom->createElement('div');
        $div3->setAttribute('class', 'mb-3');
        $div4 = $dom->createElement('div');
        $div4->setAttribute('class', 'mb-3');
        $div5 = $dom->createElement('div');
        $div5->setAttribute('class', 'mb-3');
        $div6 = $dom->createElement('div');
        $div6->setAttribute('class', 'mb-3');
        $div7 = $dom->createElement('div');
        $div7->setAttribute('class', 'mb-3');
        $div8 = $dom->createElement('div');
        $div8->setAttribute('class', 'mb-3');


        //Uniones
        $dom->appendChild($main);
        $main->appendChild($title);
        $main->appendChild($form);
        //escenario1
        $form->appendChild($div);
        $div->appendChild($label1);
        $label1->appendChild($input1);
        
        $form->appendChild($div1);
        $div1->appendChild($labelD);
        $labelD->appendChild($inputD);
        
        $form->appendChild($div2);
        $div2->appendChild($labelW);
        $labelW->appendChild($inputW);
       
        $form->appendChild($div3);
        $div3->appendChild($labelC);
        $labelC->appendChild($inputC);
        
        $form->appendChild($div4);
        $div4->appendChild($labelR);
        $labelR->appendChild($inputR);



        $form->appendChild($btnAceptar);
        $form->appendChild($inputhidden);

        echo $dom->saveHTML();




        $domfooter = new DOMDocument();
        @$domfooter->loadHTMLFile($this->configuracion['path_html'] . 'footer.html');
        echo $domfooter->saveHTML();
    }

    function mostrar_old($datos)
    {
        $dom = new DOMDocument();
        @$dom->loadHTMLFile($this->configuracion['path_html'] . 'plantilla.html');
        //solo estoy cargando la plantilla aqui
        // los dos archivos de las vistas están en el mismo sitio
        // tienen el mismo scope pero no coge el css

        $div = $dom->getElementsByTagName("main")[0];

        $form = $dom->createElement('form');

        //nombre label
        $label1 = $dom->createElement('label');
        $label1->textContent = 'Nombre:';
        //nombre input
        $input1 = $dom->createElement('input');
        //propiedades
        $input1->setAttribute('placeholder', 'Nombre escenario');
        $input1->setAttribute('type', 'text');
        //boton submit
        $btnAceptar = $dom->createElement('input');
        $btnAceptar->setAttribute('type', 'submit');
        // input hidden para decir que estoy haciendo <input type=hidden name=accion value=crear/>


        $dom->appendChild($div);
        $div->appendChild($form);
        $form->appendChild($label1);
        $label1->appendChild($input1);
        $form->appendChild($btnAceptar);

        echo $dom->saveHTML();
    }
}
