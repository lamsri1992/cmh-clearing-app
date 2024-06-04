<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <form action="{{ route('cmh.report') }}" method="GET">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reportModalLabel">พิมพ์รายงานข้อมูลสรุปการเรียกเก็บ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select name="month" class="form-select">
                        <option value="">-- เลือกเดือน --</option>
                        <option value="01">มกราคม</option>
                        <option value="02">กุมภาพันธ์</option>
                        <option value="03">มีนาคม</option>
                        <option value="04">เมษายน</option>
                        <option value="05">พฤษภาคม</option>
                        <option value="06">มิถุนายน</option>
                        <option value="07">กรกฏาคม</option>
                        <option value="08">สิงหาคม</option>
                        <option value="09">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤศจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-print"></i>
                        ออกรายงาน
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<footer class="footer pt-3  ">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4 text-start">
                <small>CMPHO - MFCIMS : Medical Fee Compensations Information Management System</small>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-4 text-end">
                <small>กลุ่มงานสุขุภาพดิจิทัล สำนักงานสาธารณสุขจังหวัดเชียงใหม่</small>
            </div>
        </div>
    </div>
</footer>
