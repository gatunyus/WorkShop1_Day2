// [AI_READ_HERE]: ไฟล์นี้ใช้สำหรับจัดการ Logic ฝั่ง Frontend (JavaScript)
let tempRecords = [];
let editingIndex = -1;

/**
 * ฟังก์ชันสำหรับคำนวณของเสียอัตโนมัติ
 */
function calculateDefects() {
    const targetQty = document.getElementById('target_qty');
    const totalQty = document.getElementById('total_qty');
    const defectQty = document.getElementById('defect_qty');

    if (targetQty && totalQty && defectQty) {
        const target = parseFloat(targetQty.value) || 0;
        const total = parseFloat(totalQty.value) || 0;
        const defects = target - total;
        defectQty.value = defects;
    }
}

/**
 * ฟังก์ชันเพิ่มหรืออัปเดตรายการลงใน Temp Table
 */
function addRecord() {
    const form = document.getElementById('productionForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const target = parseFloat(document.getElementById('target_qty').value) || 0;
    const total = parseFloat(document.getElementById('total_qty').value) || 0;
    
    if (target < 0 || total < 0) {
        alert('จำนวนต้องไม่ติดลบ');
        return;
    }

    const record = {
        date: document.getElementById('production_date').value,
        shift: document.getElementById('shift').value,
        line: document.getElementById('line_id').value,
        product: document.getElementById('product_name').value,
        target: target,
        total: total,
        defect: target - total,
        yield: target > 0 ? ((total / target) * 100).toFixed(2) : 0
    };

    if (editingIndex > -1) {
        tempRecords[editingIndex] = record;
        cancelEdit(); // รีเซ็ตปุ่ม
    } else {
        tempRecords.push(record);
        // Clear เฉพาะข้อมูลตัวเลข เผื่อคีย์ต่อ
        document.getElementById('target_qty').value = '';
        document.getElementById('total_qty').value = '';
        document.getElementById('defect_qty').value = '';
    }

    renderTable();
    updateHiddenData();
}

/**
 * ฟังก์ชันอัปเดตตาราง UI
 */
function renderTable() {
    const tbody = document.getElementById('recordTableBody');
    tbody.innerHTML = '';

    if (tempRecords.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-muted">ยังไม่มีข้อมูล โปรดกรอกแบบฟอร์มแล้วกด "เพิ่มรายการ"</td></tr>';
        return;
    }

    tempRecords.forEach((rec, index) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${rec.line}</td>
            <td>${rec.product}</td>
            <td>${rec.target}</td>
            <td>${rec.total}</td>
            <td>${rec.defect}</td>
            <td>${rec.yield}%</td>
            <td>
                <button class="btn btn-sm btn-warning me-1" onclick="editRecord(${index})">✏️</button>
                <button class="btn btn-sm btn-danger" onclick="removeRecord(${index})">🗑️</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

/**
 * ฟังก์ชันลบรายการ
 */
function removeRecord(index) {
    if(confirm('ต้องการลบรายการนี้ใช่หรือไม่?')) {
        tempRecords.splice(index, 1);
        renderTable();
        updateHiddenData();
    }
}

/**
 * ฟังก์ชันโหลดข้อมูลกลับมาแก้ไข
 */
function editRecord(index) {
    const rec = tempRecords[index];
    document.getElementById('production_date').value = rec.date;
    document.getElementById('shift').value = rec.shift;
    document.getElementById('line_id').value = rec.line;
    document.getElementById('product_name').value = rec.product;
    document.getElementById('target_qty').value = rec.target;
    document.getElementById('total_qty').value = rec.total;
    calculateDefects();

    editingIndex = index;
    document.getElementById('btnAddRecord').classList.add('d-none');
    document.getElementById('btnUpdateRecord').classList.remove('d-none');
    document.getElementById('btnCancelEdit').classList.remove('d-none');
}

/**
 * เรียกตอนกดอัปเดต
 */
function updateRecord() {
    addRecord();
}

/**
 * ยกเลิกการแก้ไข
 */
function cancelEdit() {
    editingIndex = -1;
    document.getElementById('btnAddRecord').classList.remove('d-none');
    document.getElementById('btnUpdateRecord').classList.add('d-none');
    document.getElementById('btnCancelEdit').classList.add('d-none');
    
    document.getElementById('target_qty').value = '';
    document.getElementById('total_qty').value = '';
    document.getElementById('defect_qty').value = '';
}

/**
 * อัปเดตข้อมูลใส่ hidden input ไว้ให้ PHP
 */
function updateHiddenData() {
    document.getElementById('recordsData').value = JSON.stringify(tempRecords);
}

/**
 * สั่งให้ฟอร์ม hidden ส่งข้อมูลไป PHP (PDF / CSV)
 */
function submitForExport(url) {
    if(tempRecords.length === 0) {
        alert('กรุณาเพิ่มรายการอย่างน้อย 1 รายการก่อนทำการ Export');
        return;
    }
    const form = document.getElementById('exportForm');
    form.action = url;
    form.submit();
}

/**
 * ฟังก์ชัน Export ข้อมูลเป็นไฟล์ .xlsx โดยใช้ SheetJS
 */
function exportToXlsx() {
    if(tempRecords.length === 0) {
        alert('กรุณาเพิ่มรายการอย่างน้อย 1 รายการก่อนทำการ Export');
        return;
    }

    const headers = ['วันที่ผลิต', 'กะการทำงาน', 'รหัสไลน์การผลิต', 'ชื่อสินค้า', 'เป้าหมายการผลิต (ชิ้น)', 'ผลิตทั้งหมด (ชิ้น)', 'ของเสีย (ชิ้น)', '% Yield (Target Achievement)'];
    
    const ws_data = [headers];
    
    tempRecords.forEach(rec => {
        ws_data.push([
            rec.date, rec.shift, rec.line, rec.product, rec.target, rec.total, rec.defect, rec.yield + '%'
        ]);
    });

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(ws_data);
    XLSX.utils.book_append_sheet(wb, ws, "Production Report");

    const filename = `production_report_${new Date().toISOString().slice(0,10)}_${new Date().getTime()}.xlsx`;
    XLSX.writeFile(wb, filename);
}

document.addEventListener('DOMContentLoaded', function() {
    const targetQty = document.getElementById('target_qty');
    const totalQty = document.getElementById('total_qty');

    if (targetQty) targetQty.addEventListener('input', calculateDefects);
    if (totalQty) totalQty.addEventListener('input', calculateDefects);
});
