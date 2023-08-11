<?php
namespace App\Services;
class SalustianoCsvService{

    public function exportCsv(array $dataToExport): void {
        if(!empty($dataToExport) && is_array($dataToExport)){
            $headerCsv = array_keys($dataToExport[0]);

            $csvArr = array($headerCsv);

            foreach ($dataToExport as $item){
                $values = array_values($item);
                $csvArr[] = $values;
            }

            $filename = 'dados.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $output = fopen('php://output', 'w');

            foreach ($csvArr as $row) {
                fputcsv($output, $row);
            }

            fclose($output);
        }

    }
}
