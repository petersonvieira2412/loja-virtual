<?php
function compressImage($source_path, $destination_path, $quality) {
    $info = getimagesize($source_path);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source_path);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source_path);
    }

    imagejpeg($image, $destination_path, $quality);

    return $destination_path;
}
if(isset($_POST['image'])){
	$data = $_POST['image'];
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$image_name = '../../assets/img/'.$_POST['pagina'].'/'.time().'.jpg';

	file_put_contents($image_name, $data);
	compressImage($image_name, $image_name, 90);
	echo $image_name;
}
?>
