<?php
// [AI_READ_HERE]: ไฟล์นี้เป็นหน้าจอ UI หลัก ดึงข้อมูลฟอร์มแบบอัตโนมัติจาก config.php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบันทึกข้อมูลไลน์การผลิต</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/style.css" rel="stylesheet">
    <!-- SheetJS for XLSX Export -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script> -->
    <script src="assets/xlsx.full.min.js"></script>
    
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header text-white py-3" style="background-color: #2c3e50;">
                    <h4 class="mb-0 text-center fw-bold">บันทึกข้อมูลไลน์การผลิตรายวัน</h4>
                </div>
                <div class="card-body p-4">
                    
                    <!-- [AI_READ_HERE]: ฟอร์มนี้ถูกออกแบบให้รองรับหลาย Action
                         ที่นี่เรากำหนด action เริ่มต้นไว้ แต่เมื่อกดปุ่ม Submit ฝั่ง JavaScript จะจัดการเปลี่ยน action ของฟอร์มตามที่ผู้ใช้ต้องการ (Excel หรือ PDF) -->
                    <form id="productionForm" method="POST" action="">
                        <div class="row g-3">
                            <?php foreach ($form_fields as $field): ?>
                                <!-- [AI_READ_HERE]: การ Render ฟิลด์ต่างๆ โดยวนลูปตามตัวแปร $form_fields ใน config.php -->
                                <div class="<?= htmlspecialchars($field['col_class']) ?>">
                                    <label for="<?= htmlspecialchars($field['name']) ?>" class="form-label fw-bold text-secondary">
                                        <?= htmlspecialchars($field['label']) ?>
                                        <?php if(isset($field['required']) && $field['required']): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    
                                    <?php if ($field['type'] === 'select'): ?>
                                        <select class="form-select custom-input" id="<?= htmlspecialchars($field['name']) ?>" name="<?= htmlspecialchars($field['name']) ?>" <?= (isset($field['required']) && $field['required']) ? 'required' : '' ?>>
                                            <option value="">-- เลือก --</option>
                                            <?php foreach ($field['options'] as $option): ?>
                                                <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <input type="<?= htmlspecialchars($field['type']) ?>" 
                                               class="form-control custom-input" 
                                               id="<?= htmlspecialchars($field['name']) ?>" 
                                               name="<?= htmlspecialchars($field['name']) ?>" 
                                               placeholder="<?= htmlspecialchars($field['placeholder'] ?? '') ?>"
                                               <?= (isset($field['required']) && $field['required']) ? 'required' : '' ?>
                                               <?= (isset($field['readonly']) && $field['readonly']) ? 'readonly' : '' ?>>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- ปุ่มสำหรับเพิ่มลงตารางชั่วคราว -->
                        <div class="d-grid gap-custom d-md-flex justify-content-md-center mt-3">
                            <button type="button" class="btn btn-primary btn-lg px-4 shadow-sm" id="btnAddRecord" onclick="addRecord()">
                                ➕ เพิ่มรายการ (Add to List)
                            </button>
                            <button type="button" class="btn btn-warning btn-lg px-4 shadow-sm d-none" id="btnUpdateRecord" onclick="updateRecord()">
                                💾 บันทึกการแก้ไข (Update)
                            </button>
                            <button type="button" class="btn btn-secondary btn-lg px-4 shadow-sm d-none" id="btnCancelEdit" onclick="cancelEdit()">
                                ❌ ยกเลิก (Cancel)
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ตารางแสดงข้อมูลชั่วคราว -->
            <div class="card shadow-sm border-0 rounded-3 mt-4">
                <div class="card-header text-white py-2" style="background-color: #34495e;">
                    <h5 class="mb-0 text-center fw-bold">รายการที่เตรียมส่งออก (Temporary Records)</h5>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle text-center" id="tempTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Line</th>
                                    <th>Product</th>
                                    <th>Target</th>
                                    <th>Total</th>
                                    <th>Defect</th>
                                    <th>Yield</th>
                                    <th>จัดการ (Actions)</th>
                                </tr>
                            </thead>
                            <tbody id="recordTableBody">
                                <tr><td colspan="7" class="text-muted">ยังไม่มีข้อมูล โปรดกรอกแบบฟอร์มแล้วกด "เพิ่มรายการ"</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-3 border-secondary">
                    
                    <!-- ฟอร์มสำหรับส่งออก -->
                    <form id="exportForm" method="POST" action="">
                        <input type="hidden" id="recordsData" name="recordsData" value="[]">
                        <div class="d-grid gap-custom d-md-flex justify-content-md-center py-2">
                            <button type="button" class="btn btn-success btn-lg px-4 shadow-sm" id="btnExcel" onclick="exportToXlsx()">
                                📊 Export to Excel (.xlsx)
                            </button>
                            <button type="button" class="btn btn-info btn-lg px-4 shadow-sm text-white" id="btnCsv" onclick="submitForExport('export_excel.php')">
                                📝 Export to CSV
                            </button>
                            <button type="button" class="btn btn-danger btn-lg px-4 shadow-sm" id="btnPdf" onclick="submitForExport('export_pdf.php')">
                                📄 Export to PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4 text-muted small">
                &copy; <?= date("Y") ?> Factory Production Line App - Modular Architecture
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/script.js"></script>
</body>
</html>
