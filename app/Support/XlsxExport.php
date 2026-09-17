<?php

namespace App\Support;

use RuntimeException;
use Throwable;
use XMLWriter;
use ZipArchive;

/** A text-only XLSX writer for tabular catalog exports; never interprets cell data as formulas. */
class XlsxExport
{
    public function create(array $headers, iterable $rows): string
    {
        $path = tempnam(sys_get_temp_dir(), 'mmaci-xlsx-');
        $sheet = tempnam(sys_get_temp_dir(), 'mmaci-sheet-');
        if ($path === false || $sheet === false) {
            if ($path !== false) { unlink($path); }
            if ($sheet !== false) { unlink($sheet); }
            throw new RuntimeException('Unable to create export files.');
        }

        try {
            $xml = new XMLWriter;
            $xml->openUri($sheet);
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement('worksheet');
            $xml->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $xml->writeRaw('<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>');
            $xml->writeRaw('<cols><col min="1" max="'.count($headers).'" width="28" customWidth="1"/></cols>');
            $xml->startElement('sheetData');
            $this->row($xml, 1, $headers, true);
            $number = 1;
            foreach ($rows as $row) {
                if (++$number > 1048576) {
                    throw new RuntimeException('Too many rows for Excel. Select a program or category to narrow the export.');
                }
                $this->row($xml, $number, $row);
            }
            $xml->endElement();
            $xml->writeRaw('<autoFilter ref="A1:'.$this->column(count($headers)).$number.'"/>');
            $xml->endElement();
            $xml->endDocument();
            $xml->flush();
            unset($xml);

            $zip = new ZipArchive;
            if ($zip->open($path, ZipArchive::OVERWRITE) !== true) {
                throw new RuntimeException('Unable to open the Excel export.');
            }
            $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/></Types>');
            $zip->addFromString('_rels/.rels', '<?xml version="1.0"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
            $zip->addFromString('xl/workbook.xml', '<?xml version="1.0"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Folders" sheetId="1" r:id="rId1"/></sheets></workbook>');
            $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
            $zip->addFromString('xl/styles.xml', '<?xml version="1.0"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><color rgb="FFFFFFFF"/><sz val="11"/><name val="Calibri"/></font></fonts><fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF0B315E"/><bgColor indexed="64"/></patternFill></fill></fills><borders count="1"><border/></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="2"><xf numFmtId="49" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/><xf numFmtId="49" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"/></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>');
            $zip->addFile($sheet, 'xl/worksheets/sheet1.xml');
            if (! $zip->close()) {
                throw new RuntimeException('Unable to finish the Excel export.');
            }
            return $path;
        } catch (Throwable $exception) {
            unset($xml, $zip);
            unlink($path);
            throw $exception;
        } finally {
            unlink($sheet);
        }
    }

    private function row(XMLWriter $xml, int $number, array $values, bool $header = false): void
    {
        $xml->startElement('row');
        $xml->writeAttribute('r', (string) $number);
        foreach (array_values($values) as $index => $value) {
            $xml->startElement('c');
            $xml->writeAttribute('r', $this->column($index + 1).$number);
            $xml->writeAttribute('t', 'inlineStr');
            $xml->writeAttribute('s', $header ? '1' : '0');
            $xml->startElement('is');
            $xml->startElement('t');
            $xml->writeAttribute('xml:space', 'preserve');
            $text = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', (string) $value);
            $xml->text(mb_substr($text ?? '', 0, 32767));
            $xml->endElement();
            $xml->endElement();
            $xml->endElement();
        }
        $xml->endElement();
    }

    private function column(int $number): string
    {
        $column = '';
        while ($number > 0) {
            $column = chr(65 + (--$number % 26)).$column;
            $number = intdiv($number, 26);
        }
        return $column;
    }
}
