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

    public function GuardarCSV()
    {
        $archivo = fopen("Autos.csv", "a+");
        $autoArray = array($this->_marca, $this->_color, $this->_precio);  
    
        $guardarCSV = implode(',', $autoArray);
        $guardarCSV = $guardarCSV . "\n";
        
        if(fwrite($archivo, $guardarCSV) != false)
        {
            fclose($archivo);
            echo "<br/>Se ha guardardado el auto satisfactoriamente.<br/>";
        }
        else {
                echo "<br/>Ha ocurrido un problema al intentar guardar el usuario.<br/>";
        }
    }

    public function LeerCSV()
    {
        $archivo = fopen("Autos.csv", "r");
        $autosCargados = array();
        
        //var_dump($datos);
        while ($datos = fgetcsv($archivo)) {
            $user = new Auto($datos[0],$datos[1],$datos[2]);
            array_push($autosCargados, $user);
        }
        var_dump($autosCargados);
        fclose($archivo);
        return $autosCargados;
    }

}
?>