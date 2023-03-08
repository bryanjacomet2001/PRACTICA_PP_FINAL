const d = document, 
$frm = d.getElementById("frm"),
$containerCertificate = d.querySelector(".container_consulta_certificates"),
$tbody = d.querySelector("table tbody"),
$template = d.getElementById("row_template").content,
$fragment = d.createDocumentFragment(),
$msg = d.querySelector(".msg_info");;

/*Obtener los datos*/
const getConsulta = async ()=>{
    try{
        let options = {method: "POST", body: new FormData($frm)},  
        res = await fetch("http://localhost/PP2/Handler/certificado_handler.php", options),
        json = await res.json();

        if(!res.ok) throw {status: res.status, statusText: res.statusText};

        console.log(json);

        if(json.length !== 0) {
            $msg.classList.add("hidden");
            json.forEach(el => {
                $template.querySelector(".id").textContent = el.SUBMISSION_ID;
                $template.querySelector(".title").textContent = el.TITLE;
                $template.querySelector(".status > span").textContent = "PUBLICADO";
                $template.querySelector(".status > span").style.backgroundColor = "#28B463"; 
                $template.querySelector(".btn .btn_certificates").href=`http://localhost/PP2/pages/certificado.inc.php?idSub=${el.SUBMISSION_ID}&journal=${el.JOURNAL}`;
                let $clone = d.importNode($template, true);
                $fragment.appendChild($clone);
            });
            $tbody.appendChild($fragment); 
        }
        else{
            $msg.classList.remove("hidden");
        }
    }
    catch (err){
        let message = err.statusText || "Ocurrio un error";
        console.log(`Error: ${err.status}: ${message}`);
    }
};

/*Limpiar la tabla al realizar una busqueda */
const cleanTable = ()=>{
    const $rows = d.querySelectorAll(".row");
    if($rows.length !== 0) $rows.forEach(el => el.parentNode.removeChild(el));
}

/*Agregar los datos a la tabla */
d.addEventListener("submit", e =>{
    cleanTable();
    if(e.target.matches(".consulta_form")){
        e.preventDefault();
        getConsulta();
    }
});
