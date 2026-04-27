<?php
// [AI_READ_HERE]: ไฟล์นี้เป็น Configuration Engine หลักของระบบ (Central Configuration)
// AI INSTRUCTION: หากต้องการเพิ่มหรือลดช่องกรอกข้อมูลในอนาคต ให้แก้ไขเฉพาะที่ตัวแปร Array ในไฟล์นี้เท่านั้น ระบบจะจัดการส่วนอื่นให้อัตโนมัติ

$form_fields = [
    [
        "name" => "production_date",
        "label" => "วันที่ผลิต",
        "type" => "date",
        "required" => true,
        "col_class" => "col-md-6"
    ],
    [
        "name" => "shift",
        "label" => "กะการทำงาน",
        "type" => "time",
        "required" => true,
        "col_class" => "col-md-6"
    ],
    [
        "name" => "line_id",
        "label" => "รหัสไลน์การผลิต",
        "type" => "text",
        "placeholder" => "เช่น L-01",
        "required" => true,
        "col_class" => "col-md-6"
    ],
    [
        "name" => "product_name",
        "label" => "ชื่อสินค้า",
        "type" => "select",
        "options" => ["Product A", "Product B", "Product C", "Product D", "Product E", "Product F", "Product G", "Product H", "Product I", "Product J"],
        "required" => true,
        "col_class" => "col-md-6"
    ],
    [
        "name" => "target_qty",
        "label" => "เป้าหมายการผลิต (ชิ้น)",
        "type" => "number",
        "placeholder" => "0",
        "required" => true,
        "col_class" => "col-md-4"
    ],
    [
        "name" => "total_qty",
        "label" => "ผลิตทั้งหมด (ชิ้น)",
        "type" => "number",
        "placeholder" => "0",
        "required" => true,
        "col_class" => "col-md-4"
    ],
    [
        "name" => "defect_qty",
        "label" => "ของเสีย (ชิ้น)",
        "type" => "number",
        "placeholder" => "คำนวณอัตโนมัติ",
        "required" => false,
        "readonly" => true,
        "col_class" => "col-md-4"
    ],
    // [AI_READ_HERE]: เพิ่มฟิลด์ใหม่ โดยคัดลอกโครงสร้าง Array ด้านบนและแก้ไข name, label, type
];
