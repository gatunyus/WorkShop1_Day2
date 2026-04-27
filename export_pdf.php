<?php
// [AI_READ_HERE]: ไฟล์นี้รับหน้าที่ประมวลผลข้อมูลและสร้างหน้า HTML สำหรับพิมพ์เป็น PDF
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['recordsData'])) {
    header("Location: index.php");
    exit;
}

$records = json_decode($_POST['recordsData'], true);
if (!is_array($records)) {
    $records = [];
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Production Report - PDF</title>
    <!-- ใช้ Bootstrap 5 สำหรับจัด Layout ตารางให้สวยงามพร้อมพิมพ์ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff; /* สีพื้นหลังขาวสำหรับการพิมพ์ */
            font-family: 'Sarabun', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        /* ซ่อนปุ่มหรือ UI ที่ไม่จำเป็นเวลาสั่งพิมพ์ (Print Media Query) */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="p-4">

<div class="container-fluid">
    <div class="no-print mb-4 text-end">
        <a href="index.php" class="btn btn-secondary me-2">กลับหน้าแรก</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ พิมพ์ / บันทึกเป็น PDF</button>
    </div>

    <div class="report-header">
        <h2 class="fw-bold">รายงานข้อมูลไลน์การผลิตรายวัน</h2>
        <p class="mb-0 text-muted">เอกสารออกเมื่อ: <?= date('Y-m-d H:i:s') ?></p>
    </div>

    <!-- [AI_READ_HERE]: ตารางแสดงผลข้อมูล หลายแถว -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center border-dark">
            <thead class="table-dark">
                <tr>
                    <th>วันที่ผลิต</th>
                    <th>กะการทำงาน</th>
                    <th>รหัสไลน์</th>
                    <th>ชื่อสินค้า</th>
                    <th>เป้าหมาย</th>
                    <th>ผลิตทั้งหมด</th>
                    <th>ของเสีย</th>
                    <th>% Yield</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($records) > 0): ?>
                    <?php foreach ($records as $rec): ?>
                    <tr>
                        <td><?= htmlspecialchars($rec['date'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($rec['shift'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($rec['line'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($rec['product'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($rec['target'] ?? '0') ?></td>
                        <td><?= htmlspecialchars($rec['total'] ?? '0') ?></td>
                        <td><?= htmlspecialchars($rec['defect'] ?? '0') ?></td>
                        <td><?= htmlspecialchars($rec['yield'] ?? '0') ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">ไม่มีข้อมูล</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-5 pt-4 text-end">
        <div class="d-inline-block text-center">
            <p class="mb-5">ลงชื่อผู้บันทึก: ___________________________</p>
            <p>(___________________________)</p>
            <p class="small text-muted mt-2">เจ้าหน้าที่ฝ่ายผลิต</p>
        </div>
    </div>
</div>

<!-- [AI_READ_HERE]: สคริปต์นี้จะถูกรันทันทีที่หน้าเว็บโหลดเสร็จ เพื่อสั่ง Print เป็น PDF อัตโนมัติ -->
<script>
    window.onload = function() {
        // ดีเลย์เล็กน้อยเพื่อให้หน้าจอเรนเดอร์เสร็จสมบูรณ์
        setTimeout(function() {
            window.print();
        }, 500);
    }
</script>
</body>
</html>
