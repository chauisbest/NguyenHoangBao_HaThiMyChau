<?php
  // Đường dẫn file dùng để lưu trữ số lượt truy cập
  $fp = 'counter.txt';

  // Mở file ở chế độ chỉ đọc ('r')
  $fo = fopen($fp, 'r'); // fopen() trả về con trỏ file nếu thành công

  // Đọc nội dung hiện tại của file (số đếm)
  $count = fread($fo, filesize($fp)); // fread() đọc dữ liệu với kích thước bằng kích thước file

  // Tăng giá trị của số đếm lên 1
  $count++;

  // Đóng file đã mở
  $fc = fclose($fo); // fclose() đóng file và giải phóng tài nguyên

  // Mở file ở chế độ chỉ ghi ('w') - xóa dữ liệu cũ và chuẩn bị ghi dữ liệu mới
  $fo = fopen($fp, 'w'); 

  // Ghi giá trị mới của số đếm vào file
  $fo = fwrite($fo, $count); // fwrite() ghi dữ liệu vào file và trả về số byte đã ghi

  // Đóng file (bước này bị chú thích, nhưng cần để an toàn)
  // $fc = fclose($fo);

?>
