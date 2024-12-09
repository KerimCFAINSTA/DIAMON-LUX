function modif(numId){
    var input = document.getElementById("input-"+numId);
    input.style.display="block";
}

window.onload = function affichage_start(){
    for(var i=1; i<7; i++){
        var modif_input = document.getElementById("input-"+i);
        modif_input.style.display="none";
    }
}