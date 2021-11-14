<?php

class Pizza
{
    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;


    public function __construct($id = 0, $sabor, $precio, $tipo, $cantidad)
    {
        if ($this->id != 0) {
            $this->id = $id;
        } else {
            $this->id = rand(1, 100);
        }
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        if($tipo == 'molde' || $tipo == 'piedra')
        {
            $this->tipo = $tipo;
        }
    }

    public function Equals($obj): bool
    {
        $retorno = false;
        if (
            get_class($obj) == "Pizza" &&
            $obj->sabor == $this->sabor &&
            $obj->tipo == $this->tipo
        ) {
            $retorno = true;
        }
        return $retorno;
    }

    public static function LeerEnJson($archivo = "pizza.json"): array
    {
        $pizzas = array();
        if (file_exists($archivo)) {
            $file = fopen($archivo, "r");
            if ($file) {
                $json = fread($file, filesize($archivo));
                $jsonArray = json_decode($json, true);

                foreach ($jsonArray as $pizza) {
                    array_push($pizzas, new Pizza(
                        $pizza["id"],
                        $pizza["sabor"],
                        $pizza["precio"],
                        $pizza["tipo"],
                        $pizza["cantidad"]
                    ));
                }
            }
            fclose($file);
        } else {

            echo "Error al leer el archivo.";
        }
        return $pizzas;
    }

    public static function GuardarEnJson($arrayDePizzas, $archivo = "pizza.json"): bool
    {
        $success = false;
        $file = fopen($archivo, "w");
        if ($file) {
            $json = json_encode($arrayDePizzas, JSON_PRETTY_PRINT);
            fwrite($file, $json);
            $success = true;
            echo "Archivo guardado satisfactoriamente.";
        } else {
            echo "Error al guardar el archivo.";
        }
        fclose($file);
        return $success;
    }

    public function VerificarPizza($arrayPizzas): bool
    {
        $success = false;
        if (!empty($arrayPizzas)) {
            foreach ($arrayPizzas as $pizza) {
                if ($this->Equals($pizza)) {
                    $success = true;
                    echo "Existe la pizza solicitada. \n";
                }
            }
        } else {

            echo "El array esta vacio. \n";
        }
        return $success;
    }

    public function ActualizarLista($pizza, $solicitud): string
    {
        $retorno = " ";
        $arrayPizzas = Pizza::LeerEnJson();
        if (!$pizza->VerificarPizza($arrayPizzas)) {
            if ($solicitud == "Agregar") {
                array_push($arrayPizzas, $pizza);
                $retorno = "La pizza fue agregada.";
            }
        } else {
            foreach ($arrayPizzas as $pizzaEncontrada) {
                if ($pizzaEncontrada->Equals($pizza)) {
                    if ($solicitud == "Agregar") {
                        $pizzaEncontrada->cantidad += $pizza->cantidad;
                        $pizzaEncontrada->precio = $pizza->precio;
                        $retorno = "La lista fue actualizada.";
                    }                
                } else {
                    $retorno = "La pizza no se encuentra en stock. \n";
                }
            }
        }
        Pizza::GuardarEnJson($arrayPizzas);
        return $retorno;
    }

    public static function GuardarImagen($pizza)
    {
        $dir_subida = 'ImagenesDeLaVenta/';
        if (!file_exists($dir_subida)) {
            mkdir($dir_subida, 0777, true);
        }
        $extension = explode(".",$_FILES["archivo"]["name"])[1];
        $nombreArchivo = $pizza->tipo ."-" .$pizza->sabor;
        $destino = $dir_subida .$nombreArchivo ."." .$extension;
        if(move_uploaded_file($_FILES["archivo"]["tmp_name"],$destino)){
            echo "Imagen cargada correctamente";
        }
        else {
            echo "Error al guardar la imagen. \n";
      }
    }

    public static function BuscarPizza($arrayPizzas, $sabor, $tipo)
    {
        $haySabor = false;
        $hayTipo = false;
        foreach ($arrayPizzas as $pizza) {
            if ($pizza->sabor == $sabor) {
                $haySabor = true;
            }
            if ($pizza->tipo == $tipo) {
                $hayTipo = true;
            }
        }
        if($haySabor && $hayTipo)
        {
            echo "Si hay "."\n";
        }
        else if($hayTipo){
           echo "Hay pizza del tipo " .$tipo .", pero no del sabor " .$sabor ."\n";
           
        }
        else if($haySabor){
           echo "Hay pizza del sabor " .$sabor .", pero no del tipo " .$tipo ."\n" ;
        }
        else {
            echo "No hay stock de la pizza solicitada" ."\n";
        }
    }

    public function ActualizarListaII($pizza, $solicitud): bool
    {
        $retorno = false;

        $arrayPizzas = Pizza::LeerEnJson();
        Pizza::BuscarPizza($arrayPizzas, $pizza->sabor, $pizza->tipo);
        if ($pizza->VerificarPizza($arrayPizzas)) { 
            foreach ($arrayPizzas as $pizzaEncontrada) {
                if ($pizzaEncontrada->Equals($pizza)) {
                    if ($solicitud == "Entregar") {
                        if ($pizzaEncontrada->cantidad >= $pizza->cantidad) {
                            $pizzaEncontrada->cantidad -= $pizza->cantidad;
                            Pizza::GuardarEnJson($arrayPizzas);
                            $retorno = true;
                        }
                    }
                }
            }
        }
        return $retorno;
    }

}

?>