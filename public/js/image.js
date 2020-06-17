
/* 
* Permet d'afficher le nom de l'image dans la barre d'ajout
*/
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });