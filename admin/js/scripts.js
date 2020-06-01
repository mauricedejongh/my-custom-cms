ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );


function checkAllCheckboxes() {
  const selectAllBoxes = document.getElementById('selectboxes');
  const checkBoxes = document.getElementsByClassName('checkBoxes');

  if (selectAllBoxes !== null) {
    selectAllBoxes.addEventListener('click', function(){
      Array.from(checkBoxes).forEach((el, i) => {
        if (selectAllBoxes.checked) {
          checkBoxes[i].checked = true;
        } else {
          checkBoxes[i].checked = false;
        }
      });
    });
  }

}

checkAllCheckboxes();

let divBox = "<div id='load-screen'><div id='loading'></div></div>";
$('body').prepend(divBox);

$('#load-screen').delay(700).fadeOut(600, function() {
  $(this).remove();
});
