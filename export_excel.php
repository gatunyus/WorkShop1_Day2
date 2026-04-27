<?php
// [AI_READ_HERE]: ไฟล์นี้รับหน้าที่ประมวลผลข้อมูลและ Export ออกเป็นไฟล์ CSV (เปิดด้วย Excel ได้)
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recordsData'])) {
    $filename = "production_report_" . date('Ymd_His') . ".csv";

    // ตั้งค่า Header สำหรับการดาวน์โหลดไฟล์ CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    $output = fopen('php://output', 'w');

    // [AI_READ_HERE]: พิมพ์ UTF-8 BOM เพื่อให้เปิดใน Excel แล้วภาษาไทยไม่เพี้ยน
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // กำหนด Headers ให้ตรงกับ UI
    $headers = ['วันที่ผลิต', 'กะการทำงาน', 'รหัสไลน์การผลิต', 'ชื่อสินค้า', 'เป้าหมายการผลิต (ชิ้น)', 'ผลิตทั้งหมด (ชิ้น)', 'ของเสีย (ชิ้น)', '% Yield'];
    fputcsv($output, $headers);

    // รับและแปลงข้อมูล JSON
    $records = json_decode($_POST['recordsData'], true);

    if (is_array($records)) {
        foreach ($records as $rec) {
            $row_data = [
                $rec['date'] ?? '-',
                $rec['shift'] ?? '-',
                $rec['line'] ?? '-',
                $rec['product'] ?? '-',
                $rec['target'] ?? 0,
                $rec['total'] ?? 0,
                $rec['defect'] ?? 0,
                ($rec['yield'] ?? 0) . '%'
            ];
            fputcsv($output, $row_data);
        }
    }

    fclose($output);
    exit;
} else {
    // ถ้าไม่ได้เข้ามาผ่าน POST ให้กลับไปหน้าแรก
    header("Location: index.php");
    exit;
}
