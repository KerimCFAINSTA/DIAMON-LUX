
function verif(){
    var divCaptcha = document.getElementById("captchacont");
    divCaptcha.style.display = "block";
}

function selection(nImg){
    var imageElement = document.getElementById("image"+nImg);
    var imageUrl = imageElement.src;
    var imageName = imageUrl.substring(imageUrl.lastIndexOf('/')+1);

    if(imgSelection1 === "vide"){
        imgSelection1Element = imageElement
        imgSelection1 = imageName;
        imageElement.style.border = "solid";
        imageElement.style.borderColor = "red";
        imageElement.style.borderWidth = "1px";

    }else{
        imgSelection2 = imageName;

        var nouvelleImg2 = imageElement.src.replace(imgSelection2, imgSelection1);
        imageElement.src = nouvelleImg2;

        var nouvelleImg1 = imageElement.src.replace(imgSelection1, imgSelection2);
        imgSelection1Element.src = nouvelleImg1;

        imgSelection1Element.style.border = "none";
        imgSelection1="vide";
        valider()
    }
}

window.onload = function miseEnPlace() {
    const imgExist = [];

    for (let i = 0; i < 4; i++) {
        const imageStart = document.getElementById("image" + i);
        
        let placement;
        do {
            placement = Math.floor(Math.random() * 4);
            console.log(placement);
        } while (placement == i || verifRandom(imgExist, placement));
        
        imgExist.push(placement);
        console.log(imgExist);

        imageStart.src = "../captcha/img/" + imgOrdre[placement];
    }
}

function verifRandom(tab,value){
    var verif=0;
    for(i=0;i<tab.length;i++){
        if(value==tab[i]){
            verif=1;
            return verif;
        }
    }
}


function valider() {
    
    const imgVerif=[];
    for(i=0;i<4;i++){
        var imageElement = document.getElementById("image"+i);
        var imageUrl = imageElement.src;
        var imageName = imageUrl.substring(imageUrl.lastIndexOf('/')+1);
        
        imgVerif.push(imageName);
        
    }
    console.log(imgVerif);
        
    var verifOrdre=1;
    for(i=0;i<4;i++){
       if(imgVerif[i]!=imgOrdre[i]){
            verifOrdre = 0;
            break;
       }
    }
    if(verifOrdre==1){
        var divBtn = document.getElementById("button");
        divBtn.style.display = "block";
    }
}


const imgOrdre=['img0.jpg','img1.jpg','img2.jpg','img3.jpg'];
const imgExist=[];

var verifOrdre=0;
var imgSelection1Element;
var imgSelection1="vide";
var imgSelection2;
