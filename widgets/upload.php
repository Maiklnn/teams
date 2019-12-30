<?php
	include ($_SERVER['DOCUMENT_ROOT']."/admin/bloks/access_admin.php");
	// загрузка картинок галереи
	if($_POST['td']){
		$id = (int)$_POST['id'];
		$table = $_POST['table'];
		$td = $_POST['td'];
		$w = $_POST['w'];
		$h = $_POST['h'];
		$sm_h = $_POST['sm_h'];
		$sm_w = $_POST['sm_w'];
		$date = $_POST['date'];
		$add_p = $_SERVER['DOCUMENT_ROOT'].'/';
                
                
                
		$add_p = $_SERVER['DOCUMENT_ROOT'].'/';
		$uploaddir = $add.'img/files/'.$table.'/';
                
		$file = $_FILES['upload']['name'];
		echo $file;
                exit();
                $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $file));
		if ($td != 'img_slide') {
			$newimg = "{$id}.{$ext}"; 
			$uploadfile = $uploaddir.$newimg;
			if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)) { 
				if ($sm_w > 0) {
					$sm_newimg = 'sm_'.$newimg;
					resize($uploadfile, "$uploaddir/$sm_newimg", $sm_w, $sm_h, $ext);
				}

				resize($uploadfile, "$uploaddir/$newimg", $w, $h, $ext);
				
				
				
				mysqli_query($db,"UPDATE $table SET $td = '$newimg' WHERE id = $id");
				if ($date == 'undefined') {
					$_SESSION['as'] = $date;
				}
				$add_file = $table.'/'.$newimg;

				if (isset($_SESSION['add_files'][0])) {
					array_push($_SESSION['add_files'], '"'.$add_file);
				} else {
					$_SESSION['add_files'] = array($add_file);
				}
				$_SESSION['ajax1'] = array($add_file);
				$res = array("answer" => "OK", "file" => $http.'/img/files/'.$table.'/'.$newimg, "name" => $newimg);
				exit(json_encode($res));
			}			
		} else {

			$query = "SELECT $td FROM $table WHERE id = $id";
			$res = mysqli_query($db,$query);
			$row = mysqli_fetch_assoc($res);
			$img_g = $row['img_slide'];	
			if(!empty($img_g)){
				$images = explode("|", $img_g);
				$lastimg = end($images);
				$lastnum = preg_replace("#\d+_(\d+)\.\w+#", "$1", $lastimg); 
				$lastnum += 1;
				$newimg = "{$id}_{$lastnum}.{$ext}";
				$sm_newimg = "sm_{$id}_{$lastnum}.{$ext}";
				$sql = "{$img_g}|{$newimg}";
			}else{
				$newimg = "{$id}_0.{$ext}"; 
				$sm_newimg = "sm_{$id}_0.{$ext}";
				$sql = $newimg;
			}
			$uploadfile = $uploaddir.$newimg;
			if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)) { 
				resize($uploadfile, "$uploaddir/$newimg", $w, $h, $ext);
				resize($uploadfile, "$uploaddir/$sm_newimg", $sm_w, $sm_h, $ext);
				mysqli_query($db,"UPDATE $table SET $td = '$sql' WHERE id = $id");
				$res = array("answer" => "OK", "file" => $http.'/img/files/'.$table.'/'.$sm_newimg, "name" => $newimg);
				if ($date == 'undefined') {
					$sm_add_file = $table.'/'.$sm_newimg;
					array_push($_SESSION['add_files'][0], $sm_add_file);
				}
				exit(json_encode($res));
			} 
		}
	};
	
	
	// Удаление картинок
	if($_POST['td_del']){
		$id = $_POST['id'];
		$img = $_POST['img'];
		$table = $_POST['table'];
		$td = $_POST['td_del'];
		$small = $_POST['small'];
	    if ($td != 'img_slide') {
			mysqli_query($db,"UPDATE $table SET $td = '' WHERE id = $id");
			if(mysqli_affected_rows() > 0){
				$file = $_SERVER['DOCUMENT_ROOT'].'/img/files/'.$table.'/'.$img;
				unlink($file);
				if ($small > 0) {
					$file2 = $_SERVER['DOCUMENT_ROOT'].'/img/files/'.$table.'/sm_'.$img;
					unlink($file2);
				}
				$send = 'ok';
			}else{
				$send = 'Ошибка!';
				$del = 1;	
			}
	}else{
			$query = "SELECT $td FROM $table WHERE id = $id";
			$res = mysqli_query($db,$query);
			$row = mysqli_fetch_assoc($res);
			$images = explode("|", $row[$td]);
			foreach($images as $item){
				if($item == $img) continue;
				if(!isset($galleryfiles)){
					$galleryfiles = $item;
				}else{
					$galleryfiles .= "|$item";
				}
			}
			mysqli_query($db,"UPDATE $table SET $td = '$galleryfiles' WHERE id = $id");
			$send = mysqli_affected_rows();
			if(mysqli_affected_rows() > 0){
				$file1 = $add_p.'img/files/'.$table.'/'.$img;
				unlink($file1);
				$file2 = $add_p.'img/files/'.$table.'/sm_'.$img;
				unlink($file2);
				$send = 'ok';
			}else{
				$send = 'Ошибка!';		
			}
		}
		echo $send;
	}

// функция	resize
function resize($target, $dest, $wmax, $hmax, $ext){
    list($w_orig, $h_orig) = getimagesize($target);
    $ratio = $w_orig / $h_orig;
    if(($wmax / $hmax) > $ratio){
        $wmax = $hmax * $ratio;
    }else{
        $hmax = $wmax / $ratio;
    }
    $img = "";
    switch($ext){
        case("gif"):
            $img = imagecreatefromgif($target);
            break;
        case("png"):
            $img = imagecreatefrompng($target);
            break;
        default:
            $img = imagecreatefromjpeg($target);    
    }
    $newImg = imagecreatetruecolor($wmax, $hmax);
    if($ext == "png"){
        imagesavealpha($newImg, true);
        $transPng = imagecolorallocatealpha($newImg,0,0,0,127);
        imagefill($newImg, 0, 0, $transPng); 
    }
    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); 
    switch($ext){
        case("gif"):
            imagegif($newImg, $dest);
            break;
        case("png"):
            imagepng($newImg, $dest);
            break;
        default:
            imagejpeg($newImg, $dest);    
    }
    imagedestroy($newImg);
}


?>