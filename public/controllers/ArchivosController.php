<?php
require_once './models/ManejoArchivos.php';
require_once './models/encuestas.php';

use Fpdf\Fpdf;

class ArchivosController
{
    
    public function DescargaPDF($request, $response, $args)
    {
        
        $dato = Encuesta::obtenerTodos();
        if ($dato) {


            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 25);
            $pdf->Cell(160, 15, 'Registro Encuestas', 1, 3, 'L');
            $pdf->Ln(3);

            $pdf->SetFont('Arial', '', 15);
            $pdf->Cell(60, 4, 'Nombre: Ferrero Macarena', 0, 1, 'L');
            $pdf->Cell(20, 0, '', 'T');
            $pdf->Ln(3);
            
            $pdf->Cell(60, 4, 'Email: macarenabetsabeferrero@gmail.com', 0, 1, 'L');
            $pdf->Cell(15, 0, '', 'T');
            $pdf->Ln(5);

            
            $header = array('idEncuesta','idPedido' , 'valoracion Mesa', 'valoracion Restaurant', 'valoracion Mozo', 'valoracion Cocinero', 'comentarios');
            $pdf->SetFillColor(199, 0, 57 );
            $pdf->SetTextColor(255);
            $pdf->SetDrawColor(128, 0, 0);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('Arial', 'B', 7);
            $w = array(20, 18, 25, 30, 30, 30 ,40);
            for ($i = 0; $i < count($header); $i++) {
                $pdf->Cell($w[$i], 8, $header[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();
            // Restauración de colores y fuentes
            $pdf->SetFillColor(199, 0, 57);
            $pdf->SetTextColor(0);
            $pdf->SetFont('');
            // Datos
            $fill = false;

            // Cabecera
            foreach ($dato as $row) {
                $pdf->Cell($w[0], 6, $row->idEncuesta, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[1], 6, $row->idPedido, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[2], 6, $row->valoracionMesa, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[3], 6, $row->valoracionRestaurant, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[4], 6, $row->valoracionMozo, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[5], 6, $row->valoracionCocinero, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[6], 6, $row->comentarios, 'LR', 0, 'C', $fill);
                $pdf->Ln();
                $fill = !$fill;
            }
            $pdf->Cell(array_sum($w), 0, '', 'T');

            $pdf->Output('F', './archivos/' . "EncuestasGral" ."-" . date("m.d.y") .'.pdf', 'I');
            $payload = json_encode(array("mensaje" => 'archivo generado .archivos/' . "EncuestasGral" ."-" . date("m.d.y") .'.pdf'));
        } else {
            $payload = json_encode(array("error" => 'Registro no encontrado'));
        }
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    
}