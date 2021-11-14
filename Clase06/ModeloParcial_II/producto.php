<?php

class Producto{

    public $id;
    public $sabor;
    public $precioBruto;
    public $precioFinal;
    public $tipo;
    public $cantidadUn;

    public function __construct() {
    
    }

    public static function CrearProducto($id = 0, $sabor, $precioBruto, $tipo, $cantidadUn)
    {
        $productoAux = new Producto();
        if ($productoAux->id != 0) {
            $productoAux->id = $id;
        } else {
            $productoAux->id = rand(1, 100);
        }
        $productoAux->sabor = $sabor;
        $productoAux->tipo = $tipo;
        $productoAux->cantidadUn = intval($cantidadUn);
        $productoAux->precioBruto = floatval($precioBruto);
        $productoAux->precioFinal = Producto::AgregarIVA(floatval($precioBruto));

        return $productoAux;
    }

    public static function AgregarIVA($precioBruto):float
    {
        $precioFinal = $precioBruto * 1.21;
        return $precioFinal;
    }

    public static function LeerEnJson($archivo = "producto.json"): array
    {
        $productos = array();
        if (file_exists($archivo)) {
            $file = fopen($archivo, "r");
            if ($file) {
                $json = fread($file, filesize($archivo));
                $jsonArray = json_decode($json, true);

                foreach ($jsonArray as $producto) {
                    $productoAux = Producto::CrearProducto(
                        $producto["id"],
                        $producto["sabor"],
                        $producto["precioBruto"],
                        $producto["tipo"],
                        $producto["cantidadUn"]
                    );
                    array_push($productos, $productoAux);
                }
            }
            fclose($file);
        } else {

            echo "Error al leer el archivo.";
        }
        return $productos;
    }

    public static function GuardarEnJson($arrayDeproductos, $archivo = "producto.json"): bool
    {
        $success = false;
        $file = fopen($archivo, "w");
        if ($file) {
            $json = json_encode($arrayDeproductos, JSON_PRETTY_PRINT);
            fwrite($file, $json);
            $success = true;
            echo "Archivo guardado satisfactoriamente.";
        } else {
            echo "Error al guardar el archivo.";
        }
        fclose($file);
        return $success;
    }


    public function Equals($obj): bool
    {
        $retorno = false;
        if (
            get_class($obj) == "Producto" &&
            $obj->sabor == $this->sabor &&
            $obj->tipo == $this->tipo
        ) {
            $retorno = true;
        }
        return $retorno;
    }

    public function VerificarProducto($arrayDeproductos): bool
    {
        $success = false;
        if (!empty($arrayDeproductos)) {
            foreach ($arrayDeproductos as $producto) {
                if ($this->Equals($producto)) {
                    $success = true;
                    echo "Existe el producto solicitado. \n";
                    break;
                }
            }
        } else {

            echo "El array esta vacio.";
        }
        return $success;
    }

    public function ActualizarLista($producto, $solicitud): string
    {
        $retorno = " ";
        $arrayDeproductos = Producto::LeerEnJson();
        if (!$producto->VerificarProducto($arrayDeproductos)) {
            if ($solicitud == "Agregar") {
                array_push($arrayDeproductos, $producto);
                $retorno = "El producto fue agregado.";
            }
        } else {
            foreach ($arrayDeproductos as $productoEncontrado) {
                if ($productoEncontrado->Equals($producto)) {
                    if ($solicitud == "Agregar") {
                        $productoEncontrado->cantidadUn += $producto->cantidadUn;
                        $productoEncontrado->precioBruto = $producto->precioBruto;
                        $producto->precioFinal = Producto::AgregarIVA($productoEncontrado->precioBruto);
                        $retorno = "La lista fue actualizada.";
                    }
                } else if ($solicitud == "Entregar") {
                    if ($productoEncontrado->cantidadUn >= $producto->cantidadUn) {
                        $productoEncontrado->cantidadUn -= $producto->cantidadUn;
                        $retorno = "El producto fue vendido.";
                    }
                } else {
                    $retorno = "El producto no se encuentra en stock";
                }
            }
        }
        Producto::GuardarEnJson($arrayDeproductos, "producto.json");
        return $retorno;
    }
    
    public static function BuscarProducto($arrayProducto, $sabor, $tipo)
    {
        $haySabor = false;
        $hayTipo = false;
        foreach ($arrayProducto as $producto) {
            if ($producto->sabor == $sabor) {
                $haySabor = true;
            }
            if ($producto->tipo == $tipo) {
                $hayTipo = true;
            }
        }
        if ($haySabor && $hayTipo) {
            echo "Si hay " . "\n";
        } else if ($hayTipo) {
            echo "Hay producto del tipo " . $tipo . ", pero no del sabor " . $sabor . "\n";
        } else if ($haySabor) {
            echo "Hay producto del sabor " . $sabor . ", pero no del tipo " . $tipo . "\n";
        } else {
            echo "No hay stock de la producto solicitada" . "\n";
        }
    }

}
?>