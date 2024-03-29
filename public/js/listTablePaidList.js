new DataTable('#listData', {
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    responsive: true,
    scrollX: true,
    oLanguage: {
        oPaginate: {
            sFirst: '<small>หน้าแรก</small>',
            sLast: '<small>หน้าสุดท้าย</small>',
            sNext: '<small>ถัดไป</small>',
            sPrevious: '<small>กลับ</small>'
        },
        sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
        sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
        sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
        sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
    },
    initComplete: function () {
        this.api()
            .columns([2])
            .every(function () {
                var column = this;
                var select = $('<select class="form-select" style="width:100%;"><option value="">ทั้งหมด</option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = DataTable.util.escapeRegex($(this).val());
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                column
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        select.append(
                            '<option class="form-select" value="' + d + '">' + d + '</option>'
                        );
                    });
            });
        }
});

var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
DataTable.ext.search.push(function (settings, data, dataIndex) {
    var min = minDate.val();
    var max = maxDate.val();
    var date = new Date(data[1]);
 
    if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min <= date && max === null) ||
        (min <= date && date <= max)
    ) {
        return true;
    }
    return false;
});
 
// Create date inputs
minDate = new DateTime('#min', {
    format: 'YYYY-MM-DD'
});
maxDate = new DateTime('#max', {
    format: 'YYYY-MM-DD'
});
 
// DataTables initialisation
var table = $('#listData').DataTable();
 
// Refilter the table
$('#min, #max').on('change', function () {
    table.draw();
});