<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class UserExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    protected Collection $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            '#',
            'Full Name',
            'Email',
            'Email Verified?',
            'Is Active?',
            'Created At',
            '# Listings',
            'Roles',
            'Permissions',
        ];
    }

    public function map($user): array
    {
        static $index = 0;
        $index++;

        $roles = $user->roles?->pluck('name')->implode(', ') ?: '';

        // Spatie Permission: direct + via roles
        $permissions = $user->getAllPermissions()
            ->pluck('name')
            ->unique()
            ->values()
            ->implode(', ') ?: '';

        return [
            $index,
            (string) $user->name,
            (string) $user->email,
            $user->email_verified_at ? 'Yes' : 'No',
            $user->is_active ? 'Active' : 'Inactive',
            optional($user->created_at)->format('Y-m-d H:i'),
            (int) ($user->business_listings_count ?? 0),
            $roles,
            $permissions,
        ];
    }

    // Simple widths so PDF export looks decent (you can tweak)
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 22,
            'C' => 28,
            'D' => 14,
            'E' => 10,
            'F' => 18,
            'G' => 10,
            'H' => 18,
            'I' => 45,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                $rangeAll = "A1:{$highestCol}{$highestRow}";
                $rangeHeader = "A1:{$highestCol}1";

                // Header: bold + centered vertically
                $sheet->getStyle($rangeHeader)->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                // Borders (simple outline + inner)
                $sheet->getStyle($rangeAll)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_TOP,
                    ],
                ]);

                // Wrap long text columns
                $sheet->getStyle("H2:I{$highestRow}")->getAlignment()->setWrapText(true);

                // Center a few columns
                $sheet->getStyle("A2:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("D2:E{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("G2:G{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Freeze header
                $sheet->freezePane('A2');

                // Filter row
                $sheet->setAutoFilter("A1:{$highestCol}1");

                // Row height for header
                $sheet->getRowDimension(1)->setRowHeight(18);

                // Print setup for “Export to PDF” from Excel
                $pageSetup = $sheet->getPageSetup();
                $pageSetup->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $pageSetup->setPaperSize(PageSetup::PAPERSIZE_A4);
                $pageSetup->setFitToWidth(1);
                $pageSetup->setFitToHeight(0); // unlimited height
                $pageSetup->setRowsToRepeatAtTopByStartAndEnd(1, 1); // repeat header on each PDF page

                // Margins (nice default)
                $margins = $sheet->getPageMargins();
                $margins->setTop(0.5);
                $margins->setBottom(0.5);
                $margins->setLeft(0.3);
                $margins->setRight(0.3);
            },
        ];
    }
}