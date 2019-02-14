<!DOCTYPE html>
<html>
    <head>
        <title>Công cụ đổi số điện thoại</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link href="/css/style.css" rel="stylesheet"/>
        <script src="/js/style.js"></script>
    </head>
<body>

<?php
    //Mobifone
    $mobi = ['0120', '0121', '0122', '0126', '0128', '+84120', '+84121', '+84122', '+84126', '+84128'];
    $kqmobi = ['070', '079', '077', '076', '078', '070', '079', '077', '076', '078'];

    //Viettel
    $viettel = ['0162', '0163', '0164', '0165', '0166', '0167', '0168', '0169', '+84162', '+84163', '+84164', '+84165', '+84166', '+84167', '+84168', '+84169'];
    $kqviettel = ['032', '033', '034', '035', '036', '037', '038', '039', '032', '033', '034', '035', '036', '037', '038', '039'];

    //Vinaphone
    $vina = ['0123', '0124', '0125', '0127', '0129', '+84123', '+84124', '+84125', '+84127', '+84129'];
    $kqvina = ['083', '084', '085', '081', '082', '083', '084', '085', '081', '082'];

    //Vietnamobile
    $vietnam = ['0186', '0188', '+84186', '+84188'];
    $kqvietnam = ['056', '058', '056', '058'];

    //Gmobile
    $gmobile = ['0199', '+84199'];
    $kqgmobile = ['059', '059'];

    $input = array_merge($mobi, $viettel, $vina, $vietnam, $gmobile);
    $output = array_merge($kqmobi, $kqviettel, $kqvina, $kqvietnam, $kqgmobile);

    if(isset($_FILES['contact'])){
        $file_name = $_FILES['contact']['name'];
        $file_size = $_FILES['contact']['size'];
        $file_tmp = $_FILES['contact']['tmp_name'];
        $file_type = $_FILES['contact']['type'];

        $file_ext = strtolower(end(explode('.',$_FILES['contact']['name'])));

        $expensions= array("csv", "vcf");

        if(in_array($file_ext,$expensions) === false){
            $errors = "<p class='alert alert-danger'>Bạn cần chọn file CSV hoặc VCF, bấm <a href='" . $huongdan . "'>" . "vào đây" . "</a>" . " để xem hướng dẫn</p>";
        }

        if($file_size > 2097152) {
            $errors = "<p class='alert alert-danger'>Kích thước file không được lớn hơn 2MB";
        }

        $path = './upload/'.date("Y-m-d-H.i.s-").$_FILES['contact']['name'];

        if(empty($errors) == true) {
            move_uploaded_file($file_tmp, $path);
            $tbsuccess = "<p class='alert alert-success'><b>Chuyển đổi 11 số về 10 số thành công!</b></p>";
            $cvt = file_get_contents($path);        
            $data = str_replace($input, $output, $cvt);
            $path = './upload/'.date("Y-m-d-H.i.s-").$_FILES['contact']['name'];
            file_put_contents('./converted/'.date("Y-m-d-H.i.s-").$_FILES['contact']['name'], $data, FILE_USE_INCLUDE_PATH);
            $path = './converted/'.date("Y-m-d-H.i.s-").$_FILES['contact']['name'];

            if($_FILES['contact']['type'] == "text/x-vcard"){
                $typecontact = "<i class='fab fa-apple fa-2x'></i> iPhone";
            }else {
                $typecontact = "<i class='fab fa-android fa-2x'></i> Android";
            }

            $infofile = '
                <ul class="list-group">
                <li class="list-group-item">Tên file danh bạ: ' . $_FILES['contact']['name'] . '</li>
                <li class="list-group-item">Kích thước: ' . ($_FILES['contact']['size']) . ' Bytes</li>
                <li class="list-group-item">Kiểu danh bạ: ' . $typecontact . '</li>
                <li class="list-group-item">Bấm <a class="btn btn-success btn-sm" href=" '. $path .' " >vào đây</a> nếu file không tự động tải xuống!
                </ul>
            ';
        } else{
            $errors;
        }
    }
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Chuyển đổi từ 11 số thành 10 số</h3>
            <hr class="style14">
            <div id="box-tool" class='panel panel-primary'>
                <div class='panel-body'>
                    <form action = "" method = "POST" enctype ="multipart/form-data">
                        <!-- <i class="fas fa-address-card fa-5x"></i> -->
                        <img src="/images/nhamang.jpg" alt="" width="100%">
                        <!-- <h3>Công cụ chuyển đổi</h3> -->
                        <span id="result"></span><br>
                        <input type="file" name="contact" id="upload-file">
                        <input type="button" id="choose-file" class="btn btn-primary" value="Chọn file">
                        <input id="convert-tel" data-complete-text="Đang thực hiện..." class="btn btn-primary" type = "submit" value="Chuyển đổi" autocomplete="off"/>
                    </form>
                </div>
                <?php
                    echo $tbsuccess;
                    echo $infofile;
                    echo $errors;
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Hướng dẫn sử dụng</h3>
            <hr class="style14">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <b>Hướng dẫn dành cho iPhone</b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <p>Bước 1: Đăng nhập vào website icloud.com, chọn "Danh bạ" </p>
                            <p>Bước 2: Góc dưới bên trái nhấn vào <i class="fas fa-cog"></i> sau đó chọn "Xuất vCard..."</p>
                            <p>Bước 3: Nhấn vào "Chọn file", tìm tới file vCard vừa xuất, nhấn "Chuyển đổi"</p>
                            <p>Bước 4: Download file đã chuyển đổi về</p>
                            <p>Bước 5: Quay lại icloud nhấn <i class="fas fa-cog"></i> chọn "Chọn tất cả", nhấn <i class="fas fa-cog"></i> chọn "Xóa"</p>
                            <p>Bước 6: Nhấn <i class="fas fa-cog"></i> Chọn "Nhập vCard...", tìm tới file ở bước 4, hoàn tất!</p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <b>Hướng dẫn dành cho Android</b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <p>Bước 1: Đăng nhập vào <a target="_blank" href="https://www.google.com/contacts/">Google Contact</a> sau đó vào mục "Danh bạ"</p>
                            <p>Bước 2: Nhấn vào "Khác" chọn "Xuất"</p>
                            <p>Bước 3: Nhấn vào "Chọn file", tìm tới file google.csv vừa xuất, nhấn "Chuyển đổi"</p>
                            <p>Bước 4: Download file đã chuyển đổi về</p>
                            <p>Bước 5: Chọn tất cả liên hệ, chọn "Khác" chọn "Xóa danh sách liên hệ</p>
                            <p>Bước 6: Chọn "Khác" chọn "Nhập", nhấn "Chọn tệp", tìm tới file ở bước 4, nhấn "Nhập", hoàn tất!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- <img src="/images/nhamang.jpg" alt="" width="100%"> -->
            <p id="text-bt">Copyright © HiepNH - hiepnh.com</p>
        </div>
    </div>
</div>

<script>
    $("#choose-file").click(function() {
        $('#upload-file').click();
    });

    $('#upload-file').on('change',function(){
        var files = $(this).get(0).files;
        var result = document.createElement('p');
        $('#result').html('Danh bạ của bạn: '+files[0].size/1000+' kbytes ('+files[0].size+' bytes)');
    })

    $('#convert-tel').on('click', function () {
        $(this).button('complete');
    })
    $('#myCollapsible').collapse({
        toggle: false
    })
</script>

</body>
</html>