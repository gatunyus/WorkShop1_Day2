## 📖 วัตถุประสงค์ (Purpose)
โปรเจกต์นี้จัดทำขึ้นเพื่อเป็น **Example Code** สำหรับผู้ที่กำลังมองหาระบบจัดเก็บข้อมูลหน้าบ้าน (Frontend) ที่มีระบบ Export ในตัว โดยเน้นการวางโครงสร้างที่เข้าใจง่าย เพื่อให้นำไปพัฒนาต่อยอดเป็น Dashboard หรือระบบบริหารจัดการที่ซับซ้อนยิ่งขึ้นได้
```markdown
# Workshop 1: Data Management System (Input, Edit & Export) 📊

Repository นี้เป็นโปรเจกต์ตัวอย่าง (Starter Template) สำหรับระบบจัดการข้อมูลเบื้องต้น ที่มาพร้อมกับฟังก์ชันการนำเข้าข้อมูล (Input), การแก้ไข (Edit) และความสามารถในการส่งออกข้อมูล (Export) ในหลากหลายรูปแบบ เพื่อเป็นแนวทางให้นักพัฒนาสามารถนำไปต่อยอด (Scalable) ในโปรเจกต์จริงได้

## 🌟 คุณสมบัติเด่น (Features)

* **Data Entry & Management:** ระบบบันทึกและแก้ไขข้อมูลในตัว
* **Multi-Format Export:** รองรับการ Export ข้อมูลออกมาเป็นไฟล์ยอดนิยม:
    * 📄 **.pdf** (สำหรับรายงานที่ต้องการความสวยงาม)
    * Excel **.xlsx** (สำหรับงานจัดการข้อมูลเชิงคำนวณ)
    * 📑 **.csv** (สำหรับนำไปใช้กับฐานข้อมูลหรือโปรแกรมวิเคราะห์อื่นๆ)
* **Industrial UI/UX Design:** หน้าจอถูกออกแบบตามแนวคิด High Contrast และ Glanceability เน้นการอ่านข้อมูลง่าย สบายตา และใช้งานได้รวดเร็วตามมาตรฐาน UI สายอุตสาหกรรม
* **Responsive Design:** รองรับการแสดงผลทุกหน้าจอด้วย Bootstrap

## 🛠️ เทคโนโลยีที่ใช้ (Tech Stack)

* **Frontend:** HTML5, CSS3, JavaScript
* **Framework:** [Bootstrap](https://getbootstrap.com/)
* **Libraries:** (ระบุ Library ที่คุณใช้ เช่น SheetJS, jsPDF หรือ DataTables)
    * *ตัวอย่าง:* DataTables.js สำหรับการทำระบบตารางและการ Export

## 🚀 วิธีการเริ่มต้นใช้งาน (Getting Started)

**Clone Repository:**
   ```bash
   git clone [https://github.com/gatunyus/WorkShop1_Day2.git](https://github.com/gatunyus/WorkShop1_Day2.git)
   ```
**Open Project:**
   เปิดไฟล์ `index.html` (หรือไฟล์หลักของโปรเจกต์) ผ่าน Web Browser
3.**Development:**
   สามารถแก้ไขโค้ดเพื่อเชื่อมต่อกับ Database (เช่น MySQL, FastAPI) ได้ทันทีในส่วนของ Data Processing


