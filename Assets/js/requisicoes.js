let td = document.querySelectorAll("#books td");

let tvQuantidade = document.querySelector("#quantidade");
let tvID = document.querySelector("#id");
let tvISBN = document.querySelector("#isbn");
let tvTitulo = document.querySelector("#titulo");
let tvAutor = document.querySelector("#autor");
let tvEditora = document.querySelector("#editora");
let tvGenero = document.querySelector("#genero");
let tvEdicao = document.querySelector("#edicao");
let tvEstado = document.querySelector("#estado");
let tvRequisitavel = document.querySelector("#requisitavel");

let tvNum = document.querySelector("#num");
let AllCheckBoxs = document.querySelectorAll("#reqValue");
let btnLimpar = document.querySelector("#btnLimpar");

let ant;


tvQuantidade.value = 1;

for (let target of td) {
    target.addEventListener("click", listCliked);
}

for (let target of AllCheckBoxs) {
    target.addEventListener("click", editReq);
}

let parent;

function listCliked(e) {
    



    tdtarget = e.target;
    if (!tdtarget.classList.contains("checkmark") && tdtarget.id != "reqValue" && !tdtarget.classList.contains("fa-trash-alt")) {
   
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

    
    
}

function setData(parent) {

    if (btnLimpar.classList.length == 1) {
        btnLimpar.classList.toggle("hide");
        document.querySelector("#quantidade-wrapper").classList.toggle("hide")
        document.querySelector("#num-wrapper").classList.toggle("hide")

    } else {
        let list = document.querySelector("#books .fas.fa-trash-alt");  
        list.remove();
    }

    

    tvID.value = rows[parent.id].ID;
    tvISBN.value = rows[parent.id].ISBN;
    tvNum.value = rows[parent.id].num;
    tvTitulo.value = rows[parent.id].titulo;
    tvAutor.value = rows[parent.id].autor;
    tvEditora.value = rows[parent.id].editora;
    tvGenero.value = rows[parent.id].genero;
    tvEdicao.value = rows[parent.id].edicao;
    tvEstado.value = rows[parent.id].estado;
    

    if (rows[parent.id].requisitavel == 1) {
        tvRequisitavel.value = 1;
    } else {
        tvRequisitavel.value = 0;
    }

    let btnPost = document.querySelector("#btnPost");
    btnPost.textContent = "Editar";
    btnPost.name = "edit";

    let i = document.createElement("i");
    i.classList.add("fas"); 
    i.classList.add("fa-trash-alt");
    i.addEventListener("click", deleteData);


    parent.children[0].append(i);


}

function removeData() {
    
    if (btnLimpar.classList.length == 0) {
        btnLimpar.classList.toggle("hide");
        document.querySelector("#quantidade-wrapper").classList.toggle("hide")
        document.querySelector("#num-wrapper").classList.toggle("hide")
    }

    if (ant.classList.length > 0) {
        ant.classList.remove("row-selected");
        
    }

    let list = document.querySelector("#books .fas.fa-trash-alt");  
    list.remove();

    tvID.value = "";
    tvISBN.value = "";
    tvTitulo.value = "";
    tvAutor.value = "";
    tvEditora.value = "";
    tvGenero.value = "";
    tvEdicao.value = "";
    tvEstado.value = "";
    tvNum.value = "";
    tvQuantidade.value = 1;

    let btnPost = document.querySelector("#btnPost");
    btnPost.textContent = "Adicionar";
    btnPost.name = "add";

    ant = null;

}

btnLimpar.addEventListener("click", removeData);


function deleteData() {
    let btnPost = document.querySelector("#btnPost");
    btnPost.textContent = "Adicionar";
    btnPost.name = "del";
    btnPost.click();
    

}

function editReq(e) {
    let btnPost = document.querySelector("#btnPost");
    btnPost.textContent = "Adicionar";
    btnPost.name = "editReq";
    
    parent = e.target.parentElement;

    reqId = parent.parentElement.parentElement.id;
    tvID.value = reqId; 


    let checked = e.target.parentElement.children[0].checked;
    if (checked) {
        tvRequisitavel.value = 1;
    } else {
        tvRequisitavel.value = 0;
    }
    btnPost.click();
}

