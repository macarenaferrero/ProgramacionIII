<?php
/*Aplicación No 18 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);


Macarena Ferrero
*/

include "Auto.php";


class Garage
{
    private $_razonSocial;
    private $_precioPorHora;
    private $_autos;

    public function __construct($_razonSocial, $_precioPorHora = 0)
    {
        $this->_razonSocial = $_razonSocial;
        $this->_precioPorHora = $_precioPorHora;
        $this->_autos = array();
    }

    public function MostrarGarage()
    {
        echo "<br/>Razon Social: $this->_razonSocial ";
        echo "<br/>Precio por hora: $ $this->_precioPorHora";
        
        echo "<br/>Listado de vehiculos: <br/>";

        foreach ($this->_autos as $auto) 
        {
            Auto::MostrarAuto($auto);
        }
    }

    public function Equals($auto1)
    {
        $rta = false;        
        foreach ($this->_autos as $auto) 
        {
            if($auto->Equals($auto1))
            {
                $rta = true;                
            }
        }
        return $rta;
    }

    public function Add($auto)
    {
        if($this->Equals($auto))
        {
            echo "<br/>El auto ya se encuentra en el Garage.<br/>";                     
        }
        else
        {
            array_push($this->_autos, $auto);
            echo "<br/>Auto añadido al Garage.<br/>";
        }
    }

    public function Remove($auto)
    {
        for ($i=0; $i < count($this->_autos); $i++) 
		{ 
			if($this->_autos[$i]->Equals($auto))
			{
				unset($this->_autos[$i]);
				$this->_autos = array_values($this->_autos);
				return ".<br/>Auto eliminado del garage.<br/>";

			} else {
				return ".<br/>El auto no existe en la lista.<br/>";
			}
		}
    }

}
?>