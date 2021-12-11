/* global $*/
const previewImage = (obj) => {
	let fileReader = new FileReader();
	fileReader.onload = function(){
		$('#preview').prop('src', fileReader.result);
	};
	fileReader.readAsDataURL(obj.files[0]);
}
