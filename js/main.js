function openFrame(Name) {
    var i;
    var x = document.getElementsByClassName("frame");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(Name).style.display = "block";
}
function showToast(message, duration) {
  M.toast(message, duration);
}

function togel(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
}
// var elem = document.querySelector('.sidenav');
// var instance = M.Sidenav.init(elem, options);

$(document).ready(function(){
    $('select').formSelect();
    $('.modal').modal();
    $('.sidenav').sidenav();
// openFrame('guru');

});




//
// $('.tambah_guru').submit(function () {
//
//     // Get the Login Name value and trim it
//     var name = $.trim($('.tambah-guru-nama').val());
//
//     // Check if empty of not
//     if (name === '') {
//         alert('Text-field is empty.');
//         return false;
//     }
// });
