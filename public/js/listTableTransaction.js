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

$('#listData tbody').on('click', 'tr', function () {
    $(this).toggleClass('selected');
});

// $('#btnCreate').click(function () {
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     var count = 'จำนวน ' + table.rows('.selected').data().length + ' : รายการ';
//     var array = [];
//     table.rows('.selected').every(function(rowIdx) {
//         array.push(table.row(rowIdx).data())
//     })
//     var formData = array;

//     Swal.fire({
//         title: 'ยืนยันสร้างการ Transaction ?',
//         text: count,
//         showCancelButton: true,
//         confirmButtonText: `สร้างรายการ Transaction`,
//         cancelButtonText: `ยกเลิก`,
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url:"/charge/bill",
//                 method:'POST',
//                 data:{formData: formData},
//                 success:function(data){
//                     let timerInterval
//                         Swal.fire({
//                         title: 'กำลังสร้าง Transaction',
//                         timer: 2000,
//                         timerProgressBar: true,
//                         didOpen: () => {
//                             Swal.showLoading()
//                             timerInterval = setInterval(() => {
//                             const content = Swal.getContent()
//                             if (content) {
//                                 const b = content.querySelector('b')
//                                 if (b) {
//                                 b.textContent = Swal.getTimerLeft()
//                                 }
//                             }
//                             }, 100)
//                         },
//                         willClose: () => {
//                             clearInterval(timerInterval)
//                         }
//                         }).then((result) => {
//                         if (result.dismiss === Swal.DismissReason.timer) {
//                                 Swal.fire({
//                                 icon: 'success',
//                                 title: 'สร้างรายการสำเร็จ',
//                                 showConfirmButton: false,
//                                 timer: 3000
//                             })
//                             window.setTimeout(function () {
//                                 location.replace('/charge/sent')
//                             }, 3500);
//                         }
//                     })
//                 }
//             });
//         }
//     })

// });

$('#btnCreate_all').click(function () {
    var count = 'จำนวน ' + table.rows().data().length + ' : รายการ';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var array = [];
    table.rows().every(function(rowIdx) {
        array.push(table.row(rowIdx).data())
    })
    var formData = array;

    Swal.fire({
        title: 'ยืนยันสร้างการ Transaction ?',
        text: count,
        showCancelButton: true,
        confirmButtonText: `สร้างรายการ Transaction`,
        cancelButtonText: `ยกเลิก`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:"/charge/bill",
                method:'POST',
                data:{formData: formData},
                success:function(data){
                    let timerInterval
                        Swal.fire({
                        title: 'กำลังสร้าง Transaction',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                                const b = content.querySelector('b')
                                if (b) {
                                b.textContent = Swal.getTimerLeft()
                                }
                            }
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                                Swal.fire({
                                icon: 'success',
                                title: 'สร้างรายการสำเร็จ',
                                showConfirmButton: false,
                                timer: 3000
                            })
                            window.setTimeout(function () {
                                location.replace('/charge/sent')
                            }, 3500);
                        }
                    })
                }
            });
        }
    })
});
