function deleteBook(id) {
    $.ajax({
        url: '/admin/books/' + id,
        type: 'DELETE',
        success: function (result) {
            window.location = '/admin'
        }
    });
}

function handleFileSelect(evt) {
    var file = evt.target.files; // FileList object
    var f = file[0];

    if (!f.type.match('image.*')) {
        alert("Image only please....");
    }
    var reader = new FileReader();

    reader.onload = (function (theFile) {
        return function (e) {
            var span = document.getElementById('output');
            span.innerHTML = ['<img class="img-thumbnail"  title=" style="height:150"', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
        };
    })(f);
    reader.readAsDataURL(f);
}


document.getElementById('file').addEventListener('change', handleFileSelect, false);
