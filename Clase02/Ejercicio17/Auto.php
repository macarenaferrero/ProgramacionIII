<?php
/*Aplicación No 17 (Auto)
Realizar una clase llamada “Auto” que posea los siguientes atributos privados:

_color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.

Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un Double por
parámetro y que se sumará al precio del objeto.
Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.
Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.
Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);

Macarena Ferrero
*/

class Auto
{
    private $_color;
    private $_precio;
    private $_marca;
    private $_fecha;


    public function __construct($_marca, $_color, $_precio = 0, $_fecha= NULL) 
    {
        $this->_marca = $_marca;
        $this->_color = $_color;
        $this->_precio = $_precio;

        if($_fecha == NULL)
        {
            $this->_fecha = new DateTime();
        }
        else
        {
            $this->_fecha = $_fecha;
        }
    }

    public function AgregarImpuesto($_precio)
    {
        $this->_precio += $_precio;
    }

    public static function MostrarAuto($autoUno)
    {
        printf("Marca: " . $autoUno->_marca . "<br>");
        printf("Color: " . $autoUno->_color . "<br>");
        printf("Precio: $ " . $autoUno->_precio . "<br>");
    }

    public function Equals($autoUno)
    {
        $rta = false;        
            if($this->_marca == $autoUno->_marca)
            {
                $rta = true;
            }
        return $rta;
    }

    public static function Add($autoUno, $autoDos)
    {
        $rta = 0;
        if($autoUno->Equals($autoDos))
        {
            if($autoUno->_color == $autoDos->_color)
            {
                $rta = $autoUno->_precio + $autoDos->_precio;
            }
            else
            {
                echo "Ambos autos son de diferente color.<br/>";
            }
        }
        return $rta;
    }
}
?>