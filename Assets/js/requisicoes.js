let td = document.querySelectorAll("#books td");


let tvID = document.querySelector("#id");
let tvISBN = document.querySelector("#isbn");
let tvTitulo = document.querySelector("#titulo");
let tvNum = document.querySelector("#num");
let btnLimpar = document.querySelector("#btnLimpar");
let tvControl = document.querySelector("#tvControl");
let tvUser = document.querySelector("#requisitante");

let radBtnReq = document.querySelector("#requisitar");
let radBtnDev = document.querySelector("#devolver");

let btnPost = document.querySelector("#btnPost");
let btnControl = document.querySelector("#btnControl");
let ant;

radBtnDev.addEventListener("click", devolver);
radBtnReq.addEventListener("click", devolver);

for (let target of td) {
    target.addEventListener("click", listCliked);
}

if (radBtnDev.checked) {
    btnPost.name = "delv";
    btnPost.textContent = "Devolver";
}


let parent;

function listCliked(e) {
    tdtarget = e.target;
    parent = tdtarget.parentElement;
    parent.classList.toggle("row-selected");


    if (ant != null && ant != parent) {
        ant.classList.remove("row-selected");
        setData(parent)
        ant = parent;

    } else if (ant == null) {
        setData(parent);
        ant = parent;

    } else if (ant == parent) {
        removeData();
    }
}

function setData(parent) {

    if (btnLimpar.classList.length == 1) {
        btnLimpar.classList.toggle("hide");
    }

    
    tvID.value = parent.id;
    tvISBN.value = rows[parent.id].ISBN;
    tvNum.value = rows[parent.id].num;
    tvTitulo.value = rows[parent.id].titulo;

    if (radBtnDev.checked) {
        tvControl.value = "devolver";
        tvUser.value = rows[parent.id].requisitante;
    } else {
        tvControl.value = "requisitar"
    }
}

function removeData() {
    
    if (btnLimpar.classList.length == 0) {
        btnLimpar.classList.toggle("hide");
    }

    if (ant.classList.length > 0) {
        ant.classList.remove("row-selected");
        
    }

    tvID.value = "";
    tvISBN.value = "";
    tvTitulo.value = "";
    tvNum.value = "";
    tvUser.value = "";
    ant = null;

}

btnLimpar.addEventListener("click", removeData);

function devolver() {
    btnControl.click();
}


