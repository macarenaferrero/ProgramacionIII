<?php
require_once __DIR__ . '/FileManager.php';
require_once './models/Cripto.php';
require_once './models/Venta.php';

use Fpdf\Fpdf;

class ManejoArchivos
{
    
    public function DescargaPDF($request, $response, $args)
    {
        
        $dato = Venta::obtenerTodos();
        if ($dato) {


            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 25);
            $pdf->Cell(160, 15, 'Segundo Parcial Programacion', 1, 3, 'L');
            $pdf->Ln(3);

            $pdf->SetFont('Arial', '', 15);
            $pdf->Cell(60, 4, 'Nombre: Ferrero Macarena', 0, 1, 'L');
            $pdf->Cell(20, 0, '', 'T');
            $pdf->Ln(3);
            
            $pdf->Cell(60, 4, 'Email: macarenabetsabeferrero@gmail.com', 0, 1, 'L');
            $pdf->Cell(15, 0, '', 'T');
            $pdf->Ln(5);

            
            $header = array('IdCripto', 'Cantidad', 'Nombre', 'Precio', 'Foto', 'Nacionalidad');
            $pdf->SetFillColor(255, 0, 0);
            $pdf->SetTextColor(255);
            $pdf->SetDrawColor(128, 0, 0);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('Arial', 'B', 8);
            $w = array(20, 30, 30, 30, 40, 30);
            for ($i = 0; $i < count($header); $i++) {
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();
            // Restauración de colores y fuentes
            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetTextColor(0);
            $pdf->SetFont('');
            // Datos
            $fill = false;

            // Cabecera
            foreach ($dato as $row) {
                $pdf->Cell($w[0], 6, $row->idCripto, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[2], 6, $row->cantidad, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[3], 6, $row->nombre, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[5], 6, $row->foto, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[4], 6, $row->nacionalidad, 'LR', 0, 'C', $fill);
                $pdf->Ln();
                $fill = !$fill;
            }
            $pdf->Cell(array_sum($w), 0, '', 'T');

            $pdf->Output('F', './archivos/' . $row->cliente .'.pdf', 'I');
            $payload = json_encode(array("mensaje" => 'archivo generado ./archivos/' . $row->cliente .'.pdf'));
        } else {
            $payload = json_encode(array("error" => 'Cripto no encontrado'));
        }
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    
}