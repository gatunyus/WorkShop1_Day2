# 📖 วัตถุประสงค์ (Purpose)
โปรเจกต์นี้จัดทำขึ้นเพื่อเป็น Starter Template / Example Code สำหรับผู้ที่ต้องการศึกษาหรือกำลังมองหาระบบหน้าบ้าน (Frontend) ที่เชื่อมต่อกับระบบ Export ข้อมูล โค้ดถูกเขียนให้เข้าใจง่าย เป็นสัดส่วน เพื่อให้นักพัฒนาสามารถนำไปสเกล (Scale) และปรับใช้กับฐานข้อมูลจริง (เช่น MySQL หรือ API) ได้ทันที

Markdown
# 📊 Data Management System Workshops (Day 2)

Repository นี้รวบรวมโปรเจกต์ Workshop สำหรับการพัฒนาระบบจัดการข้อมูล (Data Management System) แบบครบวงจร ตั้งแต่การออกแบบ Frontend ไปจนถึงการเขียนสคริปต์จัดการข้อมูล โดยมีจุดเด่นคือ **ระบบเพิ่ม/แก้ไขข้อมูล (Input & Edit)** และ **ระบบส่งออกข้อมูล (Export)** ไปเป็นไฟล์รูปแบบต่างๆ เพื่อนำไปใช้งานต่อได้อย่างมีประสิทธิภาพ

## 📂 โครงสร้างโปรเจกต์ (Project Structure)

ภายใน Repository นี้ประกอบไปด้วย Workshop 4 ส่วนหลัก ซึ่งไล่ระดับความซับซ้อนของการพัฒนา:

* **Workshop1:** พื้นฐานการสร้างฟอร์มรับข้อมูล (Input) และการแสดงผลข้อมูล
* **Workshop2:** ระบบแก้ไขข้อมูล (Edit/Update) แบบ Real-time
* **Workshop3:** ระบบส่งออกข้อมูล (Export) ในรูปแบบไฟล์ต่างๆ
* **Workshop4:** การจัดการ Assets รวบรวม UI และสคริปต์ที่ประยุกต์ใช้งานร่วมกัน

## 🌟 คุณสมบัติเด่น (Key Features)

* 📝 **Data Entry & Management:** ระบบฟอร์มรับข้อมูลและแก้ไขข้อมูลในตัว (CRUD Operations เบื้องต้น)
* 📥 **Multi-Format Export:** รองรับการดึงข้อมูลออกมาเพื่อทำรายงานหรือประมวลผลต่อ ได้แก่:
    * 📄 **.pdf** (สำหรับออกรายงาน เอกสารสรุป)
    * 📊 **.xlsx** (ไฟล์ Excel สำหรับการคำนวณและวิเคราะห์ข้อมูล)
    * 📑 **.csv** (สำหรับนำเข้าฐานข้อมูลหรือใช้งานกับ Data Pipeline อื่นๆ)
* 🎨 **Industrial UI/UX Design:** นำหลักการออกแบบ High Contrast และ Glanceability มาใช้ เพื่อให้หน้าจออ่านง่าย มองเห็นข้อมูลสำคัญได้ชัดเจน เหมาะสำหรับการใช้งานเป็นระบบหลังบ้าน (Back-office) หรือหน้าจอโรงงาน
* 📱 **Responsive Layout:** แสดงผลได้ดีในทุกขนาดหน้าจอ

## 🛠️ เทคโนโลยีที่ใช้ (Tech Stack)

* **Frontend:** HTML5, CSS3, JavaScript (Vanilla JS)
* **Backend / Scripting:** PHP (สำหรับการประมวลผลฝั่งเซิร์ฟเวอร์บางส่วน)
* **Framework:** Bootstrap (สำหรับการจัด Layout และ UI Components)
* **Libraries:** Library สำเร็จรูปสำหรับจัดการ Export ไฟล์ (เช่น DataTables, SheetJS หรือ jsPDF)

## 🚀 วิธีการเริ่มต้นใช้งาน (Getting Started)

**โคลนโปรเจกต์ลงเครื่องของคุณ:**
   ```bash
   git clone [https://github.com/gatunyus/WorkShop1_Day2.git](https://github.com/gatunyus/WorkShop1_Day2.git)
การรันโปรเจกต์:
เนื่องจากโปรเจกต์มีการใช้ PHP ในการประมวลผล แนะนำให้รันผ่าน Local Server อย่าง XAMPP, MAMP หรือ Laragon

นำโฟลเดอร์โปรเจกต์ไปไว้ใน htdocs (สำหรับ XAMPP) หรือ www

เปิด Web Browser และเข้าไปที่: http://localhost/WorkShop1_Day2/ จากนั้นเลือกเข้าดู Workshop ตามโฟลเดอร์ต่างๆ

