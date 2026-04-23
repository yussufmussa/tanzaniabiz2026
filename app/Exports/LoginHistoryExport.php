<?php

namespace App\Exports;

use App\Models\LoginHistory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LoginHistoryExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    WithColumnFormatting
{
    use Exportable;

    private int $rowNumber = 0;

    public function query()
    {
        return LoginHistory::query()->with('user');
    }

    public function map($loginHistory): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $loginHistory->user->name,
            $loginHistory->user->email,
            $loginHistory->ip_address,
            $loginHistory->user_agent,
            $loginHistory->login_time,
        ];
    }

    public function headings(): array
    {
        return [
            'S/N',
            'User Name',
            'Email',
            'IP Address',
            'User Agent',
            'Login Time',
        ];
    }

    /**
     * Column Widths
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'C' => 30,
            'D' => 18,
            'E' => 50,
            'F' => 22,
        ];
    }

    /**
     * Column Formatting
     */
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    /**
     * Sheet Styles
     */
    public function styles(Worksheet $sheet)
    {
        // Heading style
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Wrap User Agent column
        $sheet->getStyle('E')->getAlignment()->setWrapText(true);

        // Apply borders to all rows
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:F{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }
}
