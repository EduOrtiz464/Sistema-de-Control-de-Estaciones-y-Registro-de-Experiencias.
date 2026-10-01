<?php
require_once "config/conexion.php";
require_once "models/Estacion.php";

if (file_exists("vendor/autoload.php")) {
    require_once "vendor/autoload.php";
}

class estacioncontrollers {

    public function registrar() {
        global $conexion;

        if (isset($_POST["registrar"])) {
            $visitante = $_POST["visitante"];
            $estacion  = $_POST["estacion"];
            $fecha     = $_POST["fecha"];

            $sql = "INSERT INTO experiencias (visitante_id, estacion, fecha)
                    VALUES ('$visitante', '$estacion', '$fecha')";

            if ($conexion->query($sql)) {
                echo "<script>
                        alert('Experiencia registrada correctamente');
                        window.location='index.php?action=registrar';
                      </script>";
            }
        }

        $visitantes = $conexion->query("SELECT * FROM visitantes");
        require_once "views/registrar.php";
    }

    // Función auxiliar interna para construir la consulta SQL con o sin filtro de fechas
    private function obtenerConsultaFiltrada() {
        $sql = "SELECT experiencias.id, visitantes.nombre, visitantes.documento, 
                       experiencias.estacion, experiencias.fecha
                FROM experiencias
                INNER JOIN visitantes ON experiencias.visitante_id = visitantes.id";

        $fecha_inicio = $_GET['fecha_inicio'] ?? '';
        $fecha_fin    = $_GET['fecha_fin'] ?? '';

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $sql .= " WHERE experiencias.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
        } elseif (!empty($fecha_inicio)) {
            $sql .= " WHERE experiencias.fecha >= '$fecha_inicio'";
        } elseif (!empty($fecha_fin)) {
            $sql .= " WHERE experiencias.fecha <= '$fecha_fin'";
        }

        $sql .= " ORDER BY experiencias.fecha DESC";
        return $sql;
    }

    // Método para mostrar la tabla con el rango aplicado
    public function ver() {
        global $conexion;
        $sql = $this->obtenerConsultaFiltrada();
        $resultado = $conexion->query($sql);
        require_once "views/ver.php";
    }

    // Exportar a PDF aplicando el mismo rango de fechas
    public function exportarPdf() {
        global $conexion;
        $sql = $this->obtenerConsultaFiltrada();
        $resultado = $conexion->query($sql);

        $dompdf = new \Dompdf\Dompdf();
        
        $html = '<h2 style="text-align:center;">Reporte de Experiencias</h2>';
        if (!empty($_GET['fecha_inicio']) || !empty($_GET['fecha_fin'])) {
            $html .= '<p style="text-align:center;"><b>Rango:</b> ' . ($_GET['fecha_inicio'] ?? 'Inicio') . ' al ' . ($_GET['fecha_fin'] ?? 'Fin') . '</p>';
        }

        $html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">';
        $html .= '<thead style="background-color:#2e6b3e; color:white;">';
        $html .= '<tr><th>Visitante</th><th>Documento</th><th>Estación</th><th>Fecha</th></tr>';
        $html .= '</thead><tbody>';

        while ($fila = $resultado->fetch_assoc()) {
            $html .= "<tr>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['documento']}</td>
                        <td>{$fila['estacion']}</td>
                        <td>{$fila['fecha']}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("experiencias_reporte.pdf", ["Attachment" => true]);
    }

    // Exportar a Excel aplicando el mismo rango de fechas
    public function exportarExcel() {
        global $conexion;
        $sql = $this->obtenerConsultaFiltrada();
        $resultado = $conexion->query($sql);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Visitante');
        $sheet->setCellValue('B1', 'Documento');
        $sheet->setCellValue('C1', 'Estación');
        $sheet->setCellValue('D1', 'Fecha');

        $row = 2;
        while ($fila = $resultado->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $fila['nombre']);
            $sheet->setCellValue('B' . $row, $fila['documento']);
            $sheet->setCellValue('C' . $row, $fila['estacion']);
            $sheet->setCellValue('D' . $row, $fila['fecha']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="experiencias_reporte.xlsx"');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    // Exportar solo una fila a PDF
    public function exportarFilaPdf() {
        global $conexion;
        $id = $_GET['id'] ?? null;

        $sql = "SELECT experiencias.id, visitantes.nombre, visitantes.documento, 
                       experiencias.estacion, experiencias.fecha
                FROM experiencias
                INNER JOIN visitantes ON experiencias.visitante_id = visitantes.id
                WHERE experiencias.id = '$id'";

        $resultado = $conexion->query($sql);
        $exp = $resultado->fetch_assoc();

        $dompdf = new \Dompdf\Dompdf();
        $html = "<h2>Detalle de Experiencia</h2>";
        $html .= "<p><strong>Visitante:</strong> {$exp['nombre']}</p>";
        $html .= "<p><strong>Documento:</strong> {$exp['documento']}</p>";
        $html .= "<p><strong>Estación:</strong> {$exp['estacion']}</p>";
        $html .= "<p><strong>Fecha:</strong> {$exp['fecha']}</p>";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("experiencia_{$id}.pdf", ["Attachment" => true]);
    }

    // Exportar solo una fila a Excel
    public function exportarFilaExcel() {
        global $conexion;
        $id = $_GET['id'] ?? null;

        $sql = "SELECT experiencias.id, visitantes.nombre, visitantes.documento, 
                       experiencias.estacion, experiencias.fecha
                FROM experiencias
                INNER JOIN visitantes ON experiencias.visitante_id = visitantes.id
                WHERE experiencias.id = '$id'";

        $resultado = $conexion->query($sql);
        $exp = $resultado->fetch_assoc();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Visitante');
        $sheet->setCellValue('B1', 'Documento');
        $sheet->setCellValue('C1', 'Estación');
        $sheet->setCellValue('D1', 'Fecha');

        $sheet->setCellValue('A2', $exp['nombre']);
        $sheet->setCellValue('B2', $exp['documento']);
        $sheet->setCellValue('C2', $exp['estacion']);
        $sheet->setCellValue('D2', $exp['fecha']);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="experiencia_' . $id . '.xlsx"');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
?>