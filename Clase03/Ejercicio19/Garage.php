<?php
/*Aplicación No 19 (Auto)
Realizar una clase llamada “Auto” que posea los siguientes atributos

privados: _color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)

Realizar un constructor capaz de poder instanciar objetos pasándole como

parámetros: i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.

Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble
por parámetro y que se sumará al precio del objeto.
Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.
Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.
Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);

En testAuto.php:
● Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el
resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o
no.
● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3,
5)

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