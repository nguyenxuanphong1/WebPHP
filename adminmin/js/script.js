$(document).ready(function () {
  $("#table tbody tr").click(function () {
    var input1 = $(this).find("td:eq(0)").text().trim();
    var input2 = $(this).find("td:eq(1)").text().trim();
    var input3 = $(this).find("td:eq(2)").text().trim();
    var input4 = $(this).find("td:eq(3)").text().trim();
    var input5 = $(this).find("td:eq(4)").text().trim();
    var input6 = $(this).find("td:eq(4)").text().trim();

    $('input[name="input1"]').val(input1); // Thay input[name="idPhong"] bằng selector thật của ô input
    $('input[name="input2"]').val(input2); // Thay input[name="tenPhong"] bằng selector thật của ô input
    $('input[name="input3"]').val(input3); // Thay input[name="idKhoa"] bằng selector thật của ô input
    $('input[name="input4"]').val(input4); // Thay input[name="idMon"] bằng selector thật của ô input
    $('input[name="input5"]').val(input5); // Thay input[name="tinhTrang"] bằng selector thật của ô input
    $('input[name="input6"]').val(input6); // Thay input[name="tinhTrang"] bằng selector thật của ô input
  });



  // nút đăng xuất
  $('#logout').on('click', function (event) {
    event.preventDefault();

    Swal.fire({
      title: 'Xác nhận đăng xuất',
      text: 'Bạn có chắc chắn muốn đăng xuất?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Đồng ý',
      cancelButtonText: 'Hủy'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "../loginform.php?logout=true";
        // window.location.href = "loginform.php?logout=true";
        // Hoặc window.location.href = "user.php?logout=true"; nếu cần
      }
    });
  });

});

