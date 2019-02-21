//document.getElementById("matutino").style.color="#30A4E7";
//document.getElementById("vespertino").style.color="#30A4E7";
function hora(){
var d = new Date();
var hora=d.getHours;
var elements = document.getElementsByTagName("matutino");
var matutino = document.getElementsByTagName('span');
var vespertino = document.getElementsByTagName('a');
    
if(hora>9 && hora<12) {
 for(var i=0;i<=vespertino.length;i ++){
        vespertino[i].style.color="#30A4E7";
    }
}

if(hora>18 && hora<21) {
 for(var i=0;i<=matutino.length;i ++){
        matutino[i].style.color="#30A4E7";
    }
}


}




//d.getHours;